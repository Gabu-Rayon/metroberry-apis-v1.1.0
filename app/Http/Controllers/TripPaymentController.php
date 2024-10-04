<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Trip;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TripPayment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MetroBerryAccounts;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class TripPaymentController extends Controller
{


    /**
     * Generate a unique invoice number.
     *
     * @return string
     */
    private function generateInvoiceNumber()
    {
        // Example: "MB-INV001", "MB-INV002", etc.
        $latestPayment = TripPayment::latest()->first();
        $latestInvoiceNumber = $latestPayment ? $latestPayment->id + 1 : 1;
        return 'MB-INV' . str_pad($latestInvoiceNumber, 3, '0', STR_PAD_LEFT);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tripTripPayment = TripPayment::all();

            Log::info('All Trips Made from the Api :' . $tripTripPayment);


            return response()->json([
                'Trip TripPayment' => $tripTripPayment
            ], 200);
        } catch (Exception $e) {
            Log::error('ERROR FETCHING tripTripPayment');
            Log::error($e);
            return response()->json([
                'message' => 'Error occurred while fetching tripTripPayment',
                'error' => $e->getMessage()
            ], 500);
        }

        // $tripTripPayment = TripPayment::all();
        // return response()->json($tripTripPayment);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'customer_id' => 'required|exists:customers,id',
            'TripPayment_no' => 'required|string',
            'customer_tin' => 'required|string',
            'customer_name' => 'required|string',
            'receipt_type_code' => 'required|string',
            'payment_type_code' => 'required|string',
            'sales_status_code' => 'required|string',
            'confirm_date' => 'required|date',
            'sales_date' => 'required|date',
            'cancel_request_date' => 'nullable|date',
            'refund_reason_code' => 'nullable|string',
            'total_taxable_amount' => 'required|numeric',
            'total_tax_amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'remark' => 'required|string',
        ]);

        // Generate QR code URL
        $qrCodeUrl = $this->generateQrCode($validatedData);

        // Add QR code URL to validated data
        $validatedData['qr_code_url'] = $qrCodeUrl;

        // Create trip TripPayment
        $tripTripPayment = TripPayment::create($validatedData);

        return response()->json(['Trip TripPayment' => $tripTripPayment], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the trip TripPayment by ID
        $tripTripPayment = TripPayment::findOrFail($id);
        return response()->json(['Trip TripPayment' => $tripTripPayment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the trip TripPayment by ID
        $tripTripPayment = TripPayment::findOrFail($id);

        // Validate request data
        $validatedData = $request->validate([
            'trip_id' => 'sometimes|required|exists:trips,id',
            'customer_id' => 'sometimes|required|exists:customers,id',
            'TripPayment_no' => 'sometimes|required|string',
            'customer_tin' => 'sometimes|required|string',
            'customer_name' => 'sometimes|required|string',
            'receipt_type_code' => 'sometimes|required|string',
            'payment_type_code' => 'sometimes|required|string',
            'sales_status_code' => 'sometimes|required|string',
            'confirm_date' => 'sometimes|required|date',
            'sales_date' => 'sometimes|required|date',
            'cancel_request_date' => 'sometimes|nullable|date',
            'refund_reason_code' => 'sometimes|nullable|string',
            'total_taxable_amount' => 'sometimes|required|numeric',
            'total_tax_amount' => 'sometimes|required|numeric',
            'total_amount' => 'sometimes|required|numeric',
            'remark' => 'sometimes|required|string',
        ]);

        // Update trip TripPayment
        $tripTripPayment->update($validatedData);

        return response()->json(['Trip TripPayment' => $tripTripPayment]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the trip TripPayment by ID and delete it
        $tripTripPayment = TripPayment::findOrFail($id);
        $tripTripPayment->delete();

        return response()->json(['message' => 'Trip TripPayment deleted successfully']);
    }

    /**
     * Generate QR code URL and store the QR code image.
     */
    private function generateQrCode(array $data): string
    {
        $qrCodeContent = json_encode($data);

        // Generate QR code
        $qrCode = QrCode::generate($qrCodeContent);

        // Store QR code image
        $fileName = 'qr_codes/' . uniqid('qr_code_') . '.png';
        Storage::disk('public')->put($fileName, $qrCode);

        // Return the file path or URL
        return Storage::url($fileName);
    }

    /**
     * Receive payment for a billed trip.
     */
    public function billedTripRecievePayment($id)
    {
        try {
            Log::info('Trip billed to receive Payment');
            Log::info($id);

            // Fetch the trip details where the status is 'billed' or 'partially paid'
            $trip = Trip::where('id', $id)
                ->whereIn('status', ['billed', 'partially paid'])
                ->firstOrFail();

            // Calculate the total paid amount
            $totalPaid = TripPayment::where('trip_id', $id)->sum('total_amount');

            // Calculate the remaining amount
            $remainingAmount = $trip->total_price - $totalPaid;

            // Fetch all accounts
            $accounts = MetroBerryAccounts::all();

            // Pass the necessary data to the view
            return view('trips.billed-receive-payment', compact('trip', 'remainingAmount', 'accounts'));
        } catch (\Exception $e) {
            Log::error('Error receiving payment for trip: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while receiving the payment. Please try again.')->withInput();
        }
    }



    public function billedTripRecievePaymentStore(Request $request, $id)
    {
        try {
            $data = $request->all();

            Log::info('Data from the Form receive payment of billed trip:');
            Log::info($data);

            $creator = Auth::user();
            Log::info('User making the payment:');
            Log::info($creator);

            // Validation rules
            $validator = Validator::make($data, [
                'payment_date' => 'required|date',
                'amount' => 'required|numeric',
                'account_id' => 'required|string',
                'remark' => 'nullable|string',
                'payment_receipt' => 'required|mimes:png,jpg,jpeg,pdf,doc,docx',
                'reference' => 'required|string',
            ]);

            if ($validator->fails()) {
                // Log::info('VALIDATION ERROR:', $validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $invoiceNo = $this->generateInvoiceNumber();
            Log::info('Invoice Generated No.:');
            Log::info($invoiceNo);

            // Retrieve trip details based on $id
            $trip = Trip::findOrFail($id);

            $tripPayment = new TripPayment();
            $tripPayment->trip_id = $trip->id;
            $tripPayment->customer_id = $trip->customer_id;
            $tripPayment->invoice_no = $invoiceNo;
            $tripPayment->account_id = $data['account_id'];
            $tripPayment->customer_tin = $trip->customer->user->customer_tin;
            $tripPayment->customer_name = $trip->customer->user->name;
            $tripPayment->receipt_type_code = null;
            $tripPayment->payment_type_code = null;
            $tripPayment->confirm_date = null;
            $tripPayment->payment_date = $data['payment_date'];
            $tripPayment->total_taxable_amount = $trip->total_price;
            $tripPayment->total_tax_amount = null;
            $tripPayment->total_amount = $data['amount'];
            $tripPayment->remark = $data['remark'];
            $tripPayment->payment_receipt = $data['payment_receipt'];
            $tripPayment->reference = $data['reference'];
            $tripPayment->qr_code_url = null;
            $tripPayment->created_by = $creator->id;

            // Handle payment receipt file upload
            if ($request->hasFile('payment_receipt')) {
                $file = $request->file('payment_receipt');
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('payment_receipts'), $fileName);
                $tripPayment->payment_receipt = $fileName;
            }

            $tripPayment->save();
            Log::info('Trip Payment Saved:');
            Log::info($tripPayment);

            $totalPaidAmount = TripPayment::where('trip_id', $trip->id)->sum('total_amount');
            Log::info('Total Paid Amount:');
            Log::info($totalPaidAmount);


            // Update trip status based on total paid amount
            if ($totalPaidAmount >= $trip->total_price) {
                $trip->status = 'paid';
            } else {
                $trip->status = 'partially paid';
            }
            $trip->save();
            Log::info('Trip Status Updated:');
            Log::info($trip->status);

            return redirect()->route('trip.payment.checkout', ['id' => $id])
                ->with('success', 'Payment received && Added successfully.');
        } catch (\Exception $e) {
            Log::error('Error receiving payment for trip: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while receiving the payment. Please try again.');
        }
    }


    /**
     * Download TripPayment for a billed trip.
     */
    public function billedTripDownloadInvoice($id)
    {
        try {
            // Fetch the trip details where the status is 'billed' or 'partially paid'
            $trip = Trip::where('id', $id)->whereIn('status', ['billed', 'partially paid'])->with('customer.user')->firstOrFail();

            // Fetch related payments
            $payments = $trip->payments;

            Log::info('This trip payments data To Download: ', $trip->toArray());

            // Calculate total amount and balance
            $totalAmount = $payments->sum('amount');
            $balance = $trip->total_price - $totalAmount;

            $invoiceNumber  = $this->generateInvoiceNumber();

            // Fetch customer details
            $customer = $trip->customer;
            if (!$customer || !$customer->user) {
                return back()->with('error', 'Customer information is missing.');
            }

            $data = [
                'title' => 'Invoice',
                'date' => date('m/d/Y'),
                'due_date' => date('m/d/Y', strtotime('+30 days')),
                'customer' => $customer->user->name,
                'address' => $customer->user->address,
                'invoice_number' => $invoiceNumber,
                'total_amount' => $totalAmount,
                'balance' => $balance,
                'items' => [$trip],
                'status' => $trip->status,
            ];

            // Load the view and pass the data
            $pdf = Pdf::loadView('invoices.trip-invoice-template', compact('data'));

            // Download the PDF
            return $pdf->download('trip_invoice_' . $trip->id . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error downloading TripPayment for trip: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while downloading the TripPayment. Please try again.');
        }
    }




    public function billedTripDownloadInvoiceReceipt($id)
    {
        try {
            // Fetch the payment details using the given ID
            $payment = TripPayment::where('id', $id)->firstOrFail();

            // Fetch the related trip details
            $trip = Trip::where('id', $payment->trip_id)
                ->whereIn('status', ['paid'])
                ->with('customer.user')
                ->firstOrFail();

            Log::info('This trip payment data To Download: ', $payment->toArray());
            Log::info('This trip data To Download: ', $trip->toArray());

            // Calculate total amount and balance
            $totalAmount = $payment->amount; // Assuming amount is the field for paid amount
            $balance = $trip->total_price - $totalAmount;

            // Fetch customer details
            $customer = $trip->customer;
            if (!$customer || !$customer->user) {
                return back()->with('error', 'Customer information is missing.');
            }

            // Prepare data for the receipt
            $data = [
                'title' => 'Trip Payment Receipt',
                'date' => now()->format('m/d/Y'),
                'due_date' => now()->addDays(30)->format('m/d/Y'),
                'customer' => $customer->user->name,
                'address' => $customer->user->address,
                'invoice_number' => $payment->invoice_no,
                'total_amount' => $totalAmount,
                'balance' => $balance,
                'items' => [$trip],
                'status' => $trip->status,
            ];

            // Load the view and pass the data
            $pdf = PDF::loadView('receipts.trip-payment-receipt', compact('data'));

            // Download the PDF
            return $pdf->download('trip_payment_receipt_' . $trip->id . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error downloading Trip Payment Receipt for trip: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while downloading the Trip Payment Receipt. Please try again.');
        }
    }



    /**
     * Resend TripPayment for a billed trip.
     */

    /**
     * Send TripPayment for a billed trip.
     */
    public function billedTripResendInvoice($id)
    {
        try {
            $trip = Trip::where('id', $id)->whereIn('status', ['billed', 'partially paid', 'paid'])->firstOrFail();


            Log::info('Data for the trip to be email to the customer : ');
            Log::info($trip);

            // Prepare data for the invoice
            $data = [
                'title' => 'Invoice',
                'invoice_number' => $this->generateInvoiceNumber(),
                'date' => now()->format('Y-m-d'),
                'customer' => $trip->customer->user->name,
                'address' => $trip->customer->user->address,
                'items' => [
                    [
                        'customer' => $trip->customer->user->name,
                        'billed_by' => $trip->billed_by,
                        'vehicle_mileage' => $trip->vehicle_mileage,
                        'engine_hours' => $trip->engine_hours,
                        'idle_time' => $trip->idle_time,
                        'vehicle' => $trip->vehicle,
                        'total_price' => $trip->total_price
                    ]
                ]
            ];

            Log::info('Raw data for the trip to be attached to email invoice to send to the customer: ', $data);


            // Generate the PDF from the Blade view
            $pdf = PDF::loadView('invoices.trip-invoice-template-resend', compact('data'));


            // Define the directory to save the PDF
            $pdfDirectory = public_path('trip-mailed-resent-invoices');

            // Create the directory if it doesn't exist
            if (!File::exists($pdfDirectory)) {
                File::makeDirectory($pdfDirectory, 0755, true);
            }

            // Define the PDF path
            $pdfPath = "{$pdfDirectory}/invoice_{$trip->id}.pdf";

            // Save the PDF to the public storage folder
            $pdf->save($pdfPath);

            // Define the email view data
            $emailData = [
                'customer' => $trip->customer->user->name
            ];

            // Send the email with the PDF attachment
            Mail::send('mail-view.resend-trip-invoice-mail-view', $emailData, function ($message) use ($trip, $pdf) {
                $message->to($trip->customer->user->email)
                    ->subject('Your Trip Invoice')
                    ->attachData($pdf->output(), "invoice_{$trip->id}.pdf");
            });

            return back()->with('success', 'Trip invoice has been resent successfully as a reminder to the customer.');
        } catch (\Exception $e) {
            Log::error('Error Emailing the  trip invoice: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while Emailing the trip invoice. Please try again.');
        }
    }

    /**
     * Send TripPayment for a billed trip.
     */
    public function billedTripSendInvoice($id)
    {
        try {
            $trip = Trip::where('id', $id)->whereIn('status', ['billed', 'partially paid', 'paid'])->firstOrFail();


            Log::info('Data for the trip to be email to the customer : ');
            Log::info($trip);

            // Prepare data for the invoice
            $data = [
                'title' => 'Invoice',
                'invoice_number' => $this->generateInvoiceNumber(),
                'date' => now()->format('Y-m-d'),
                'customer' => $trip->customer->user->name,
                'address' => $trip->customer->user->address,
                'items' => [
                    [
                        'customer' => $trip->customer->user->name,
                        'billed_by' => $trip->billed_by,
                        'vehicle_mileage' => $trip->vehicle_mileage,
                        'engine_hours' => $trip->engine_hours,
                        'idle_time' => $trip->idle_time,
                        'vehicle' => $trip->vehicle,
                        'total_price' => $trip->total_price
                    ]
                ]
            ];

            Log::info('Raw data for the trip to be attached to email invoice to send to the customer: ', $data);


            // Generate the PDF from the Blade view
            $pdf = PDF::loadView('invoices.trip-invoice-template-send', compact('data'));


            // Define the directory to save the PDF
            $pdfDirectory = public_path('trip-mailed-sent-invoices');

            // Create the directory if it doesn't exist
            if (!File::exists($pdfDirectory)) {
                File::makeDirectory($pdfDirectory, 0755, true);
            }

            // Define the PDF path
            $pdfPath = "{$pdfDirectory}/invoice_{$trip->id}.pdf";

            // Save the PDF to the public storage folder
            $pdf->save($pdfPath);

            // Define the email view data
            $emailData = [
                'customer' => $trip->customer->user->name
            ];

            // Send the email with the PDF attachment
            Mail::send('mail-view.send-trip-invoice-mail-view', $emailData, function ($message) use ($trip, $pdf) {
                $message->to($trip->customer->user->email)
                    ->subject('Your Trip Invoice')
                    ->attachData($pdf->output(), "invoice_{$trip->id}.pdf");
            });

            return back()->with('success', 'Trip invoice sent successfully.');
        } catch (\Exception $e) {
            Log::error('Error Emailing the  trip invoice: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while Emailing the trip invoice. Please try again.');
        }
    }
}

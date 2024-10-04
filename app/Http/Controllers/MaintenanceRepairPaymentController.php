<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MaintenanceRepair;
use App\Models\MetroBerryAccounts;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceRepairPayment;
use Illuminate\Support\Facades\Validator;

class MaintenanceRepairPaymentController extends Controller
{

    /**
     * Receive payment for a billed MaintenanceRepairPayment.
     */
    public function billedVehicleRepairMaintenanceRecievePayment($id)
    {
        try {
            Log::info('Vehicle Maintainance Repair to receive Payment');
            Log::info($id);

            // Fetch the service details where the status is 'billed', 'paid', or 'partially paid'
            $maintenanceRepair = MaintenanceRepair::where('id', $id)
                ->whereIn('repair_status', ['billed', 'paid', 'partially paid'])
                ->firstOrFail();

            // Calculate the total paid amount from the Maintenance MaintenanceRepair table
            $totalPaid = MaintenanceRepairPayment::where('maintenance_repair_id', $id)->sum('total_amount');

            // Calculate the remaining amount to be paid
            $remainingAmount = $maintenanceRepair->repair_cost - $totalPaid;

            // Fetch all accounts
            $accounts = MetroBerryAccounts::all();

            // Pass the necessary data to the view
            return view('vehicle.maintenance-repairs.repairsCheckout.vehicle-repair-receive-payment', compact('maintenanceRepair', 'remainingAmount', 'accounts'));
        } catch (\Exception $e) {
            Log::error('Error receiving payment for Vehicle Maintainance Repair: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while receiving the payment. Please try again.');
        }
    }



    public function billedVehicleRepairMaintenanceRecievePaymentStore(Request $request, $id)
    {
        try {
            $data = $request->all();

            Log::info('Data from the Form to receive payment of billed Vehicle Repair Maintenance ');
            Log::info($data);

            $creator = Auth::user();

            Log::info('User who is processing the payment');
            Log::info($creator);

            // Validation rules
            $validator = Validator::make($data, [
                'payment_date' => 'required|date',
                'amount' => 'required|numeric',
                'account_id' => 'required|exists:accounts,id', 
                'remark' => 'nullable|string',
                'payment_receipt' => 'required|mimes:png,jpg,jpeg,pdf,doc,docx|max:2048',
                'reference' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::info('Validation Error');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $invoiceNo = $this->generateInvoiceNumber();
            Log::info('Generated Invoice Number');
            Log::info($invoiceNo);

            // Retrieve service details based on $id
            $maintenanceRepair = MaintenanceRepair::findOrFail($id);


            $maintenanceRepairPayment = new MaintenanceRepairPayment();
            $maintenanceRepairPayment->maintenance_repair_id = $maintenanceRepair->id;
            $maintenanceRepairPayment->vehicle_id = $maintenanceRepair->vehicle_id;
            $maintenanceRepairPayment->part_id = $maintenanceRepair->part_id;
            $maintenanceRepairPayment->repair_type = $maintenanceRepair->repair_type;
            $maintenanceRepairPayment->repair_cost = $maintenanceRepair->repair_cost;
            $maintenanceRepairPayment->account_id = $data['account_id'];
            $maintenanceRepairPayment->invoice_no = $invoiceNo;
            $maintenanceRepairPayment->receipt_type_code = null;
            $maintenanceRepairPayment->payment_type_code = null;
            $maintenanceRepairPayment->confirm_date = null;
            $maintenanceRepairPayment->payment_date = $data['payment_date'];
            $maintenanceRepairPayment->total_taxable_amount = $maintenanceRepair->service_cost;
            $maintenanceRepairPayment->total_tax_amount = null; 
            $maintenanceRepairPayment->total_amount = $data['amount'];
            $maintenanceRepairPayment->remark = $data['remark'];
            $maintenanceRepairPayment->reference = $data['reference'];
            $maintenanceRepairPayment->qr_code_url = null;
            $maintenanceRepairPayment->created_by = $creator->id;

            // Handle payment receipt file upload
            if ($request->hasFile('payment_receipt')) {
                $file = $request->file('payment_receipt');
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('maintenance_repair_payment_receipts'), $fileName);
                $maintenanceRepairPayment->payment_receipt = $fileName;
            }

            $maintenanceRepairPayment->save();
            Log::info('Maintenance Repair Payment Saved');

            // Update the MaintenanceService status
            $totalPaid = MaintenanceRepairPayment::where('maintenance_repair_id', $maintenanceRepair->id)->sum('total_amount');

            if ($totalPaid >= $maintenanceRepair->repair_cost) {
                $maintenanceRepair->repair_status = 'paid';
            } else {
                $maintenanceRepair->repair_status = 'partially paid';
            }
            $maintenanceRepair->save();

            return redirect()->route('maintenance.repair.payment.checkout', ['id' => $id])
                ->with('success', 'Payment received and added successfully.');
        } catch (\Exception $e) {
            Log::error('Error receiving payment for Maintenance Service: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while receiving the payment for the Maintenance Repair. Please try again.');
        }
    }


    /**
     * Generate a unique invoice number.
     *
     * @return string
     */
    private function generateInvoiceNumber()
    {
        // Example: "MB-INV001", "MB-INV002", etc.
        $latestPayment = MaintenanceRepairPayment::latest()->first();
        $latestInvoiceNumber = $latestPayment ? $latestPayment->id + 1 : 1;
        return 'MB-INV' . str_pad($latestInvoiceNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Download MaintenanceRepairPayment for a billed MaintenanceRepairPayment.
     */
    public function billedVehicleRepairMaintenanceDownloadInvoice($id)
    {
        try {
            // Fetch the MaintenanceRepairPayment details where the status is 'billed'
            $service = MaintenanceRepair::where('id', $id)->where('status', 'billed')->firstOrFail();

            // Logic to generate and download the MaintenanceServicePayment
            //Now to download will call a template pass all the data for this invoice to
            //  the template the download it  in a pdf  
            // the template  is in MaintenanceServiceInvoiceTemplate.metro-berry-MaintenanceRepairPayment-invoice-template 

            // return response()->download($maintenanceServicePath);
        } catch (\Exception $e) {
            Log::error('Error downloading detials for vehicle Maintenance: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while downloading the vehicle Maintenance Billied Invoice. Please try again.');
        }
    }

    /**
     * Resend MaintenanceService  for a billed MaintenanceService.
     */
    public function billedVehicleRepairMaintenanceResendInvoice($id)
    {
        try {
            // Fetch the MaintenanceRepair details where the status is 'billed'
            $service = MaintenanceRepair::where('id', $id)->where('status', 'billed')->firstOrFail();

            // Logic to send the Payment  For vehicle  MaintenanceService
            // For example, send the Payment via email
            // Mail::to($service->vendor->email)->send(new MaintenanceServicePaymentMail($service));

            return back()->with('success', 'Vehicle Maintenance Service Billed  resent successfully.');
        } catch (\Exception $e) {
            Log::error('Error resending Payment for Vehicle Maintenance Service Billed : ' . $e->getMessage());
            return back()->with('error', 'An error occurred while resending the MaintenanceRepairPayment. Please try again.');
        }
    }

    /**
     * Send Payment for a billed vehicle maintenance  Service.
     */
    public function billedVehicleRepairMaintenanceSendInvoice($id)
    {
        try {
            // Fetch the MaintenanceRepairPayment details where the status is 'billed'
            $service = MaintenanceRepair::where('id', $id)->where('status', 'billed')->firstOrFail();

            // Logic to send the Payment  For vehicle  MaintenanceService
            // For example, send the Payment via email
            // Mail::to($service->vendor->email)->send(new MaintenanceRepaiPÓaymentMail($service));

            return back()->with('success', 'Vehicle Maintenance Service Billed  sent successfully.');
        } catch (\Exception $e) {
            Log::error('Error sending Payment for Vehicle Maintenance Service Billed : ' . $e->getMessage());
            return back()->with('error', 'An error occurred while sending the payment For Vehicle Maintenance Service Billed . Please try again.');
        }
    }


}
<?php

namespace App\Http\Controllers;

use App\Exports\VehicleInsuranceExport;
use App\Models\Expense;
use Exception;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\InsuranceCompany;
use App\Models\VehicleInsurance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\InsuranceRecurringPeriod;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class VehicleInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $vehicleInsurances = null;
            $insuranceCompanies = null;
            $recurringPeriods = InsuranceRecurringPeriod::all();
            $vehicles = Vehicle::whereDoesntHave('insurance')->get();

            // Check the user's role
            if (Auth::user()->role == 'admin') {
                // If the user is an admin, fetch all vehicle insurances
                $vehicleInsurances = VehicleInsurance::all();
                $insuranceCompanies = InsuranceCompany::where('status', 1)->get();
            } else {
                // Otherwise, fetch vehicle insurances created by the authenticated user
                $vehicleInsurances = VehicleInsurance::where('created_by', Auth::user()->id)->get();
                $insuranceCompanies = InsuranceCompany::where('status', 1)
                    ->where('created_by', Auth::user()->id)
                    ->get();
            }

            Log::info('Vehicle Insurances fetched: ', ['vehicleInsurances' => $vehicleInsurances]);

            $insuranceCompanies = InsuranceCompany::where('status', 1)->get();
            $recurringPeriods = InsuranceRecurringPeriod::all();
            $vehicles = Vehicle::whereDoesntHave('insurance')->get();

            return view('vehicle.insurance.index', compact('vehicleInsurances', 'insuranceCompanies', 'recurringPeriods', 'vehicles'));
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error fetching vehicle insurances: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while fetching the vehicle insurances. Please try again.');
        }
    }



    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
    }



    /**
     * Store a newly created resource in storage.
     *
     *
     */
    public function store(Request $request)
    {
        try {
            // Log the request data
            Log::info('Vehicle Insurance store request data From the Form :', $request->all());

            $data = $request->all();
            // Validate the request data

            $validator = Validator::make($data, [
                'vehicle_id' => 'required|numeric|unique:vehicle_insurances',
                'insurance_company_id' => 'required|numeric',
                'insurance_policy_no' => 'required|numeric',
                'insurance_date_of_issue' => 'required|date',
                'insurance_date_of_expiry' => 'required|date|after:insurance_date_of_issue',
                'charges_payable' => 'required|numeric',
                'recurring_period_id' => 'required|numeric',
                'recurring_date' => 'required|date',
                'reminder' => 'required|numeric',
                'deductible' => 'required|numeric',
                'status' => 'required|numeric',
                'remark' => 'nullable|string',
                'policy_document' => 'required|file|mimes:pdf|max:2048',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR Here ');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Log the request data
            Log::info('Vehicle Insurance store request data:', $request->all());

            // Handle the file upload
            if ($request->hasFile('policy_document')) {
                $policyDocument = time() . '.' . $request->policy_document->extension();
                $request->policy_document->move(public_path('images'), $policyDocument);
            }

            // Create a new vehicle insurance record
            $vehicleInsurance = new VehicleInsurance();
            $vehicleInsurance->vehicle_id = $request->vehicle_id;
            $vehicleInsurance->insurance_company_id = $request->insurance_company_id;
            $vehicleInsurance->insurance_policy_no = $request->insurance_policy_no;
            $vehicleInsurance->insurance_date_of_issue = $request->insurance_date_of_issue;
            $vehicleInsurance->insurance_date_of_expiry = $request->insurance_date_of_expiry;
            $vehicleInsurance->charges_payable = $request->charges_payable;
            $vehicleInsurance->recurring_period_id = $request->recurring_period_id;
            $vehicleInsurance->recurring_date = $request->recurring_date;
            $vehicleInsurance->reminder = $request->reminder;
            $vehicleInsurance->deductible = $request->deductible;
            $vehicleInsurance->status = $request->status;
            $vehicleInsurance->remark = $request->remark;
            $vehicleInsurance->policy_document = $policyDocument;
            $vehicleInsurance->created_by = Auth::user()->id;

            $vehicleInsurance->save();

            Expense::create([
                'name' => 'Vehicle Insurance',
                'amount' => $request->charges_payable,
                'category' => 'vehicle_insurance',
                'entry_date' => now(),
                'description' => 'New Vehicle Insurance for ' . $vehicleInsurance->vehicle->plate_number,
            ]);

            DB::commit();

            return redirect()->route('vehicle.insurance.index')->with('success', 'Vehicle Insurance added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error adding vehicle Insurance: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while adding the vehicle Insurance. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleInsurance $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        try {
            $vehicleInsurance = VehicleInsurance::findOrFail($id);
            $insuranceCompanies = InsuranceCompany::where('status', 1)->get();
            $recurringPeriods = InsuranceRecurringPeriod::all();
            $vehicles = Vehicle::all();

            return view('vehicle.insurance.edit', compact('vehicleInsurance', 'insuranceCompanies', 'recurringPeriods', 'vehicles'));
        } catch (Exception $e) {
            Log::error('Error fetching vehicle Insurance Details for edit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the Insurance Details. Please try again.');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     *
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $data = $request->all();

        $validator = Validator::make($data, [
            'vehicle_id' => 'required|exists:vehicles,id',
            'insurance_company_id' => 'required|exists:insurance_companies,id',
            'insurance_policy_no' => 'required|string|max:255',
            'insurance_date_of_issue' => 'nullable|date',
            'insurance_date_of_expiry' => 'nullable|date|after:insurance_date_of_issue',
            'charges_payable' => 'required|numeric',
            'recurring_period_id' => 'required|exists:insurance_recurring_periods,id',
            'recurring_date' => 'nullable|date',
            'reminder' => 'required|boolean',
            'deductible' => 'required|numeric',
            'status' => 'required|boolean',
            'remark' => 'nullable|string|max:500',
            'policy_document' => 'nullable|file|mimes:jpeg,png,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR Here');
            Log::info($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            DB::beginTransaction();
            $vehicleInsurance = VehicleInsurance::findOrFail($id);

            // Handle file upload if provided
            if ($request->hasFile('policy_document')) {
                $file = $request->file('policy_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('policy_documents', $filename, 'public');

                // Delete old policy document if it exists
                if ($vehicleInsurance->policy_document) {
                    Storage::disk('public')->delete($vehicleInsurance->policy_document);
                }

                // Set new policy document path
                $vehicleInsurance->policy_document = $filePath;
            }

            // Update the vehicle insurance record with the validated data
            $vehicleInsurance->update([
                'vehicle_id' => $request->vehicle_id,
                'insurance_company_id' => $request->insurance_company_id,
                'insurance_policy_no' => $request->insurance_policy_no,
                'insurance_date_of_issue' => $request->insurance_date_of_issue,
                'insurance_date_of_expiry' => $request->insurance_date_of_expiry,
                'charges_payable' => $request->charges_payable,
                'recurring_period_id' => $request->recurring_period_id,
                'recurring_date' => $request->recurring_date,
                'reminder' => $request->reminder,
                'deductible' => $request->deductible,
                'status' => $request->status,
                'remark' => $request->remark,
                'policy_document' => $vehicleInsurance->policy_document ?? $vehicleInsurance->policy_document,
            ]);

            $vehicleInsurance->vehicle->status = 'inactive';
            $vehicleInsurance->vehicle->driver->status = 'inactive';
            $vehicleInsurance->vehicle->save();
            $vehicleInsurance->vehicle->driver->save();

            DB::commit();
            return redirect()->route('vehicle.insurance.index')->with('success', 'Vehicle Insurance updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating vehicle Insurance: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the Insurance. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    /**
     * Show the form for deleting the specified resource.
     */
    public function delete($id)
    {
        try {
            $insurance = VehicleInsurance::findOrFail($id);
            return view('vehicle.insurance.delete', compact('insurance'));
        } catch (Exception $e) {
            Log::error('Error fetching vehicle insurance for delete: ' . $e);
            return redirect()->back()->with('error', 'An error occurred while fetching the insurance details. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $insurance = VehicleInsurance::find($id);

            if (!$insurance) {
                return redirect()->back()->with('error', 'Vehicle insurance not found');
            }

            // Delete old policy document if it exists
            if ($insurance->policy_document) {
                Storage::disk('public')->delete($insurance->policy_document);
            }

            DB::beginTransaction();
            $insurance->vehicle->status = 'inactive';
            $insurance->vehicle->driver->status = 'inactive';
            $insurance->vehicle->save();
            $insurance->vehicle->driver->save();
            $insurance->delete();

            DB::commit();

            return redirect()->route('vehicle.insurance.index')->with('success', 'Vehicle Insurance Details deleted successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE Vehicle Insurance Details ERROR: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting Vehicle Insurance Details');
        }
    }

    public function export()
    {
        return Excel::download(new VehicleInsuranceExport, 'vehicle_insurances.xlsx');
    }

    public function renew($id) {
        $insurance = VehicleInsurance::findOrFail($id);
        return view('vehicle.insurance.renew', compact('insurance'));
    }

    public function renewPost($id, Request $request) {
        try {
            $insurance = VehicleInsurance::findOrFail($id);

            $data = $request->all();

            $validator = Validator::make($data, [
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after:issue_date|after:today',
                'policy_document' => 'required|file|mimes:pdf|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $insurance->update([
                'insurance_date_of_issue' => $data['issue_date'],
                'insurance_date_of_expiry' => $data['expiry_date'],
                'status' => true,
            ]);

            $policyDocument = null;

            // handle file upload
            if ($request->hasFile('policy_document')) {
                $policyDocument = time() . '.' . $request->policy_document->extension();
                $request->policy_document->move(public_path('images'), $policyDocument);
            }

            $insurance->policy_document = $policyDocument;

            $insurance->save();

            Expense::create([
                'name' => 'Vehicle Insurance',
                'amount' => $insurance->charges_payable,
                'category' => 'vehicle_insurance',
                'entry_date' => now(),
                'description' => 'Renewed Vehicle Insurance for ' . $insurance->vehicle->plate_number,
            ]);

            DB::commit();

            return redirect()->route('vehicle.insurance.index')->with('success', 'Vehicle Insurance renewed successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('RENEW VEHICLE INSURANCE ERROR ');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }
}

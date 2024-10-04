<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\InsuranceCompany;
use Illuminate\Support\Facades\Log;
use App\Models\InsuranceRecurringPeriod;
use Illuminate\Support\Facades\Validator;

class InsuranceCompanyController extends Controller
{

    public function index()
    {
        Log::info('HERE');
        try {
            $insuranceCompanies = InsuranceCompany::all();
            return view('vehicle.insurance.company.index', compact('insuranceCompanies'));
        } catch (Exception $e) {
            Log::info('INS COMP INDEX ERROR');
            Log::info($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function create()
    {
        $insuranceCompanies = InsuranceCompany::all();
        return view('vehicle.insurance.company.create', compact('insuranceCompanies'));
    }
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'address' => 'nullable|string|max:255',
                'website' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR Here');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Create a new insurance company record
            $company = new InsuranceCompany();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->address = $request->address;
            $company->website = $request->website;
            $company->created_by = 1;
            $company->save();

            return redirect()->route('vehicle.insurance.company')->with('success', 'Insurance company added successfully.');
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error storing insurance company: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while adding the insurance company. Please try again.');
        }
    }

    public function edit($id)
    {
        try {
            $company = InsuranceCompany::findOrFail($id);

            return view('vehicle.insurance.company.edit', compact('company'));
        } catch (Exception $e) {
            Log::error('Error fetching insurance company for edit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the insurance company. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {

            Log::info('Data from edting the Insurance Compnanies : ');
            Log::info($request);
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'address' => 'nullable|string|max:255',
                'website' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR Here');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Find the existing insurance company record
            $company = InsuranceCompany::findOrFail($id);

            // Update the insurance company record
            $company->name = $request->name;
            $company->email = $request->email;
            $company->address = $request->address;
            $company->website = $request->website;
            $company->save();

            return redirect()->route('vehicle.insurance.company')->with('success', 'Insurance company updated successfully.');
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error updating insurance company: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while updating the insurance company. Please try again.');
        }
    }

    public function insuranceRecurringPeriod()
    {
        $recurringPeriods = InsuranceRecurringPeriod::all();
        return view('vehicle.insurance.recurring-period.index', compact('recurringPeriods'));
    }
    public function insuranceRecurringPeriodCreate()
    {
        return view('vehicle.insurance.recurring-period.create');
    }

    public function insuranceRecurringPeriodStore(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'period' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR Here');
            Log::info($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            // Create a new insurance recurring period record
            $insuranceRecurringPeriod = new InsuranceRecurringPeriod();
            $insuranceRecurringPeriod->period = $request->input('period');
            $insuranceRecurringPeriod->description = $request->input('description');
            $insuranceRecurringPeriod->status = $request->input('status');
            $insuranceRecurringPeriod->created_by = 1;
            $insuranceRecurringPeriod->save();

            return redirect()->route('vehicle.insurance.recurring.period')->with('success', 'Insurance recurring period created successfully.');
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error creating insurance recurring period: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while creating the insurance recurring period. Please try again.');
        }
    }

    public function insuranceRecurringPeriodEdit($id)
    {
        $period = InsuranceRecurringPeriod::findOrFail($id);
        return view('vehicle.insurance.recurring-period.edit', compact('period'));
    }

    public function insuranceRecurringPeriodUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'period' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $period = InsuranceRecurringPeriod::findOrFail($id);
        $period->update([
            'period' => $validatedData['period'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'updated_by' => 1,
        ]);

        return redirect()->route('vehicle.insurance.recurring.period')->with('success', 'Insurance Recurring Period updated successfully.');
    }



    public function delete($id)
    {
        $company = InsuranceCompany::findOrFail($id);
        return view('vehicle.insurance.company.delete', compact('company'));
    }

    public function destroy($id)
    {
        try {
            $company = InsuranceCompany::findOrFail($id);
            $company->delete();
            return redirect()->route('vehicle.insurance.company')->with('success', 'Insurance company deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting insurance company: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the insurance company. Please try again.');
        }
    }

    public function activateForm($id)
    {
        $company = InsuranceCompany::findOrFail($id);
        return view('vehicle.insurance.company.activate', compact('company'));
    }

    public function activate(Request $request, $id)
    {
        try {
            $company = InsuranceCompany::findOrFail($id);
            $company->status = 1;
            $company->save();
            return redirect()->route('vehicle.insurance.company')->with('success', 'Insurance company activated successfully.');
        } catch (Exception $e) {
            Log::error('Error activating insurance company: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while activating the insurance company. Please try again.');
        }
    }

    public function deactivateForm($id)
    {
        $company = InsuranceCompany::findOrFail($id);
        return view('vehicle.insurance.company.deactivate', compact('company'));
    }

    public function deactivate(Request $request, $id)
    {
        try {
            $company = InsuranceCompany::findOrFail($id);
            $company->status = 0;
            $company->save();
            return redirect()->route('vehicle.insurance.company')->with('success', 'Insurance company deactivated successfully.');
        } catch (Exception $e) {
            Log::error('Error deactivating insurance company: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deactivating the insurance company. Please try again.');
        }
    }
}

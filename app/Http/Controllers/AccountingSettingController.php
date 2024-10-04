<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetroBerryAccounts;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountingSettingController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        try {
            $settings = MetroBerryAccounts::all();
            return view('accounting-setting.index', compact('settings'));
        } catch (\Exception $e) {
            Log::error('Error fetching accounting settings: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the accounting settings.');
        }
    }

    // Show the form for creating a new resource
    public function create()
    {
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $creator = Auth::user()->id;

            $validator = Validator::make($data, [
                'holder_name' => 'required|string|max:255',
                'bank_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:255',
                'opening_balance' => 'required|numeric',
                'contact_number' => 'required|string|max:20',
                'bank_address' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::info('Validation Error:', $validator->errors()->toArray());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Log the request data
            Log::info('Account Setting Data from the Form request:', $request->all());

            $metroBerryAccounts = new MetroBerryAccounts();

            // Create the Bank Account record
            $metroBerryAccounts->holder_name = $request->holder_name;
            $metroBerryAccounts->bank_name = $request->bank_name;
            $metroBerryAccounts->account_number = $request->account_number;
            $metroBerryAccounts->opening_balance = $request->opening_balance;
            $metroBerryAccounts->contact_number = $request->contact_number;
            $metroBerryAccounts->bank_address = $request->bank_address;
            $metroBerryAccounts->created_by = $creator;

            $metroBerryAccounts->save();

            // Redirect to the index page with a success message
            return redirect()->route('metro.berry.account.setting')
                ->with('success', 'Accounting setting created successfully.');
        } catch (\Exception $e) {
            // Log any errors that occur during the process
            Log::error('Error storing accounting setting:', ['message' => $e->getMessage()]);

            // Redirect back with an error message if an exception is caught
            return back()->with('error', 'An error occurred while creating the accounting setting.')->withInput();
        }
    }


    // Show the form for editing the specified resource
    public function edit($id)
    {
        try {
            $setting = MetroBerryAccounts::findOrFail($id);
            return view('accounting-setting.edit', compact('setting'));
        } catch (\Exception $e) {
            Log::error('Error fetching accounting setting for edit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the accounting setting for editing.');
        }
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'holder_name' => 'required|string|max:255',
                'bank_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:255',
                'opening_balance' => 'required|numeric',
                'contact_number' => 'required|string|max:20',
                'bank_address' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::info('Validation Error:', $validator->errors()->toArray());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Log the request data
            Log::info('Account Setting Data from the Form request:', $request->all());

            $metroBerryAccounts = MetroBerryAccounts::findOrFail($id);

            // Update the Bank Account record
            $metroBerryAccounts->holder_name = $request->holder_name;
            $metroBerryAccounts->bank_name = $request->bank_name;
            $metroBerryAccounts->account_number = $request->account_number;
            $metroBerryAccounts->opening_balance = $request->opening_balance;
            $metroBerryAccounts->contact_number = $request->contact_number;
            $metroBerryAccounts->bank_address = $request->bank_address;

            $metroBerryAccounts->save();

            // Redirect to the index page with a success message
            return redirect()->route('metro.berry.account.setting')
                ->with('success', 'Accounting setting updated successfully.');
        } catch (\Exception $e) {
            // Log any errors that occur during the process
            Log::error('Error updating accounting setting:', ['message' => $e->getMessage()]);

            // Redirect back with an error message if an exception is caught
            return back()->with('error', 'An error occurred while updating the accounting setting.')->withInput();
        }
    }


    public function delete($id)
    {
        $setting = MetroBerryAccounts::findOrFail($id);
        return view('accounting-setting.delete', compact('setting'));
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        try {
            $setting = MetroBerryAccounts::findOrFail($id);
            $setting->delete();

            return redirect()->route('metro.berry.account.setting')
                ->with('success', 'Accounting setting deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting accounting setting: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the accounting setting.');
        }
    }
}

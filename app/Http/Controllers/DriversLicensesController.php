<?php

namespace App\Http\Controllers;

use App\Exports\DriversLicensesExport;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\DriversLicenses;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DriversLicensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $licenses = DriversLicenses::all();
        $drivers = Driver::whereDoesntHave('license')->get();
        return view('driver.license.index', compact('licenses', 'drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drivers = Driver::whereDoesntHave('license')->get();
        return view('driver.license.create', compact('drivers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'driver' => 'required|numeric|exists:drivers,id',
                'license_no' => 'required|string|unique:drivers_licenses,driving_license_no',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after:issue_date',
                'front_page_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'back_page_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('CREATE LICENSE VALIDATION ERROR');
                Log::error($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $frontLicensePath = null;
            $backLicensePath = null;
            $licenseNumber = $data['license_no'];

            if ($request->hasFile('front_page_id')) {
                $frontLicenseFile = $request->file('front_page_id');
                $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
                $frontLicenseFileName = "{$licenseNumber}-front-id.{$frontLicenseExtension}";
                $frontLicensePath = $frontLicenseFile->storeAs('uploads/front-license-pics', $frontLicenseFileName, 'public');
            }

            if ($request->hasFile('back_page_id')) {
                $backLicenseFile = $request->file('back_page_id');
                $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
                $backLicenseFileName = "{$licenseNumber}-back-id.{$backLicenseExtension}";
                $backLicensePath = $backLicenseFile->storeAs('uploads/back-license-pics', $backLicenseFileName, 'public');
            }

            DB::beginTransaction();

            DriversLicenses::create([
                'driver_id' => $data['driver'],
                'driving_license_no' => $licenseNumber,
                'driving_license_date_of_issue' => $data['issue_date'],
                'driving_license_date_of_expiry' => $data['expiry_date'],
                'driving_license_avatar_front' => $frontLicensePath,
                'driving_license_avatar_back' => $backLicensePath,
            ]);

            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('CREATE LICENSE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DriversLicenses $driversLicenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $license = DriversLicenses::findOrFail($id);
        return view('driver.license.edit', compact('license'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $license = DriversLicenses::findOrFail($id);
            $data = $request->all();

            $validator = Validator::make($data, [
                'license_no' => 'required|string',
                'driving_license_date_of_issue' => 'required|date',
                'driving_license_date_of_expiry' => 'required|date|after:driving_license_date_of_issue',
                'driving_license_avatar_front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'driving_license_avatar_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('UPDATE LICENSE VALIDATION ERROR');
                Log::error($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            if (!$license) {
                return redirect()->back()->with('error', 'License not found');
            }

            $frontLicensePath = null;
            $backLicensePath = null;

            if ($request->hasFile('driving_license_avatar_front')) {
                $frontLicenseFile = $request->file('driving_license_avatar_front');
                $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
                $frontLicenseFileName = "{$license->driving_license_no}-front-id.{$frontLicenseExtension}";
                $frontLicensePath = $frontLicenseFile->storeAs('uploads/front-license-pics', $frontLicenseFileName, 'public');
            }

            if ($request->hasFile('driving_license_avatar_back')) {
                $backLicenseFile = $request->file('driving_license_avatar_back');
                $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
                $backLicenseFileName = "{$license->driving_license_no}-back-id.{$backLicenseExtension}";
                $backLicensePath = $backLicenseFile->storeAs('uploads/back-license-pics', $backLicenseFileName, 'public');
            }

            DB::beginTransaction();

            $license->update([
                'driving_license_date_of_issue' => $data['driving_license_date_of_issue'],
                'driving_license_date_of_expiry' => $data['driving_license_date_of_expiry'],
                'driving_license_avatar_front' => $frontLicensePath,
                'driving_license_avatar_back' => $backLicensePath,
                'verified' => false
            ]);

            $license->driver->status = 'inactive';
            $license->driver->save();

            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE LICENSE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $license = DriversLicenses::findOrFail($id);
        return view('driver.license.delete', compact('license'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $license = DriversLicenses::findOrFail($id);
            $driver = $license->driver;

            if (!$license) {
                return redirect()->back()->with('error', 'License not found');
            }

            DB::beginTransaction();

            $license->delete();
            $driver->status = 'inactive';

            $driver->save();

            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE LICENSE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function verify($id)
    {
        try {

            $license = DriversLicenses::findOrFail($id);

            if (!$license) {
                return redirect()->back()->with('error', 'License not found');
            }

            return view('driver.license.verify', compact('license'));
        } catch (Exception $e) {
            Log::error('VERIFY LICENSE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function verifyStore($id)
    {
        try {

            $license = DriversLicenses::findOrFail($id);

            if (!$license) {
                return redirect()->back()->with('error', 'License not found');
            }

            if ($license->verified) {
                return redirect()->back()->with('error', 'License already verified');
            }

            if ($license->driving_license_date_of_expiry < Carbon::today()) {
                return redirect()->back()->with('error', 'License has expired');
            }

            if (!$license->driving_license_avatar_front || !$license->driving_license_avatar_back) {
                return redirect()->back()->with('error', 'License documents are missing');
            }

            DB::beginTransaction();

            $license->update([
                'verified' => true
            ]);

            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License verified successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('VERIFY LICENSE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function revoke($id)
    {
        try {
            $license = DriversLicenses::findOrFail($id);
            return view('driver.license.revoke', compact('license'));
        } catch (Exception $e) {
            Log::error('REVOKE LICENSE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function revokeStore($id)
    {
        try {

            $license = DriversLicenses::findOrFail($id);

            if (!$license) {
                return redirect()->back()->with('error', 'License not found');
            }

            if (!$license->verified) {
                return redirect()->back()->with('error', 'License already suspended');
            }

            DB::beginTransaction();

            $license->update([
                'verified' => false
            ]);

            $license->driver->status = 'inactive';
            $license->driver->save();

            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License suspended successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('SUSPEND LICENSE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new DriversLicensesExport, 'drivers-licenses.xlsx');
    }
}

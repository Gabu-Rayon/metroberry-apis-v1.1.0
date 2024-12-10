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
    // public function store(Request $request)
    // {
    //     try {
    //         $data = $request->all();

    //         $validator = Validator::make($data, [
    //             'driver' => 'required|numeric|exists:drivers,id',
    //             'license_no' => 'required|string|unique:drivers_licenses,driving_license_no',
    //             'issue_date' => 'required|date',
    //             'expiry_date' => 'required|date|after:issue_date',
    //             'front_page_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //             'back_page_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //         ]);

    //         if ($validator->fails()) {
    //             Log::error('CREATE LICENSE VALIDATION ERROR');
    //             Log::error($validator->errors()->first());
    //             return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    //         }

    //         $licenseNumber = $data['license_no'];
    //         $frontLicensePath = null;
    //         $backLicensePath = null;

    //         // Handle the front license image upload
    //         if ($request->hasFile('front_page_id')) {
    //             $frontLicenseFile = $request->file('front_page_id');
    //             $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
    //             $frontLicenseFileName = "{$licenseNumber}-front-id.{$frontLicenseExtension}";
    //             // Move the file to the public directory
    //             $frontLicensePath = 'uploads/front-license-pics/' . $frontLicenseFileName;
    //             $frontLicenseFile->move(public_path('uploads/front-license-pics'), $frontLicenseFileName);
    //         }

    //         // Handle the back license image upload
    //         if ($request->hasFile('back_page_id')) {
    //             $backLicenseFile = $request->file('back_page_id');
    //             $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
    //             $backLicenseFileName = "{$licenseNumber}-back-id.{$backLicenseExtension}";
    //             // Move the file to the public directory
    //             $backLicensePath = 'uploads/back-license-pics/' . $backLicenseFileName;
    //             $backLicenseFile->move(public_path('uploads/back-license-pics'), $backLicenseFileName);
    //         }

    //         DB::beginTransaction();

    //         DriversLicenses::create([
    //             'driver_id' => $data['driver'],
    //             'driving_license_no' => $licenseNumber,
    //             'driving_license_date_of_issue' => $data['issue_date'],
    //             'driving_license_date_of_expiry' => $data['expiry_date'],
    //             'driving_license_avatar_front' => $frontLicensePath,
    //             'driving_license_avatar_back' => $backLicensePath,
    //         ]);

    //         DB::commit();

    //         return redirect()->route('driver.license')->with('success', 'License created successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('CREATE LICENSE ERROR');
    //         Log::error($e);
    //         return redirect()->back()->with('error', $e->getMessage())->withInput();
    //     }
    // }


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

            $licenseNumber = $data['license_no'];
            $frontLicensePath = null;
            $backLicensePath = null;

            // Handle the front license image upload
            if ($request->hasFile('front_page_id')) {
                $frontLicenseFile = $request->file('front_page_id');
                $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
                $frontLicenseFileName = "{$licenseNumber}-front-id.{$frontLicenseExtension}";
                // Move the file to the specified directory
                $frontLicensePath = 'uploads/front-license-pics/' . $frontLicenseFileName;
                $frontLicenseFile->move('public_html_metroberry_app/uploads/front-license-pics', $frontLicenseFileName);
            }

            // Handle the back license image upload
            if ($request->hasFile('back_page_id')) {
                $backLicenseFile = $request->file('back_page_id');
                $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
                $backLicenseFileName = "{$licenseNumber}-back-id.{$backLicenseExtension}";
                // Move the file to the specified directory
                $backLicensePath = 'uploads/back-license-pics/' . $backLicenseFileName;
                $backLicenseFile->move('public_html_metroberry_app/uploads/back-license-pics', $backLicenseFileName);
            }

            DB::beginTransaction();

            DriversLicenses::create([
                'driver_id' => $data['driver'],
                'driving_license_no' => $licenseNumber,
                'driving_license_date_of_issue' => $data['issue_date'],
                'driving_license_date_of_expiry' => $data['expiry_date'],
                'driving_license_avatar_front' => $frontLicenseFile,
                'driving_license_avatar_back' => $backLicenseFile,
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
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $license = DriversLicenses::findOrFail($id);
    //         $data = $request->all();

    //         $validator = Validator::make($data, [
    //             'license_no' => 'required|string',
    //             'driving_license_date_of_issue' => 'required|date',
    //             'driving_license_date_of_expiry' => 'required|date|after:driving_license_date_of_issue',
    //             'driving_license_avatar_front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //             'driving_license_avatar_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //         ]);

    //         if ($validator->fails()) {
    //             Log::error('UPDATE LICENSE VALIDATION ERROR');
    //             Log::error($validator->errors()->first());
    //             return redirect()->back()->with('error', $validator->errors()->first());
    //         }

    //         $frontLicensePath = $license->driving_license_avatar_front; // Preserve the old path
    //         $backLicensePath = $license->driving_license_avatar_back; // Preserve the old path

    //         // Handle new front license image upload
    //         if ($request->hasFile('driving_license_avatar_front')) {
    //             // If there's an existing front image, delete it
    //             if ($frontLicensePath && file_exists(public_path($frontLicensePath))) {
    //                 unlink(public_path($frontLicensePath));
    //             }
    //             // Store the new front image in the public directory
    //             $frontLicenseFile = $request->file('driving_license_avatar_front');
    //             $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
    //             $frontLicenseFileName = "{$license->driving_license_no}-front-id.{$frontLicenseExtension}";
    //             $frontLicensePath = 'uploads/front-license-pics/' . $frontLicenseFileName; // Path to store
    //             $frontLicenseFile->move(public_path('uploads/front-license-pics'), $frontLicenseFileName); // Move file
    //         }

    //         // Handle new back license image upload
    //         if ($request->hasFile('driving_license_avatar_back')) {
    //             // If there's an existing back image, delete it
    //             if ($backLicensePath && file_exists(public_path($backLicensePath))) {
    //                 unlink(public_path($backLicensePath));
    //             }
    //             // Store the new back image in the public directory
    //             $backLicenseFile = $request->file('driving_license_avatar_back');
    //             $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
    //             $backLicenseFileName = "{$license->driving_license_no}-back-id.{$backLicenseExtension}";
    //             $backLicensePath = 'uploads/back-license-pics/' . $backLicenseFileName; // Path to store
    //             $backLicenseFile->move(public_path('uploads/back-license-pics'), $backLicenseFileName); // Move file
    //         }

    //         DB::beginTransaction();

    //         // Update license details
    //         $license->update([
    //             'driving_license_date_of_issue' => $data['driving_license_date_of_issue'],
    //             'driving_license_date_of_expiry' => $data['driving_license_date_of_expiry'],
    //             'driving_license_avatar_front' => $frontLicensePath,
    //             'driving_license_avatar_back' => $backLicensePath,
    //             'verified' => false
    //         ]);

    //         $license->driver->status = 'inactive';
    //         $license->driver->save();

    //         DB::commit();

    //         return redirect()->route('driver.license')->with('success', 'License updated successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('UPDATE LICENSE ERROR');
    //         Log::error($e);
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }


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

            $frontLicensePath = $license->driving_license_avatar_front; // Preserve the old path
            $backLicensePath = $license->driving_license_avatar_back; // Preserve the old path

            // Handle new front license image upload
            if ($request->hasFile('driving_license_avatar_front')) {
                // If there's an existing front image, delete it
                if ($frontLicensePath && file_exists('public_html_metroberry_app/' . $frontLicensePath)) {
                    unlink('public_html_metroberry_app/' . $frontLicensePath);
                }
                // Store the new front image
                $frontLicenseFile = $request->file('driving_license_avatar_front');
                $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
                $frontLicenseFileName = "{$license->driving_license_no}-front-id.{$frontLicenseExtension}";
                $frontLicensePath = 'uploads/front-license-pics/' . $frontLicenseFileName; // Path to store
                $frontLicenseFile->move('public_html_metroberry_app/uploads/front-license-pics', $frontLicenseFileName); // Move file
            }

            // Handle new back license image upload
            if ($request->hasFile('driving_license_avatar_back')) {
                // If there's an existing back image, delete it
                if ($backLicensePath && file_exists('public_html_metroberry_app/' . $backLicensePath)) {
                    unlink('public_html_metroberry_app/' . $backLicensePath);
                }
                // Store the new back image
                $backLicenseFile = $request->file('driving_license_avatar_back');
                $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
                $backLicenseFileName = "{$license->driving_license_no}-back-id.{$backLicenseExtension}";
                $backLicensePath = 'uploads/back-license-pics/' . $backLicenseFileName; // Path to store
                $backLicenseFile->move('public_html_metroberry_app/uploads/back-license-pics', $backLicenseFileName); // Move file
            }

            DB::beginTransaction();

            // Update license details
            $license->update([
                'driving_license_date_of_issue' => $data['driving_license_date_of_issue'],
                'driving_license_date_of_expiry' => $data['driving_license_date_of_expiry'],
                'driving_license_avatar_front' => $frontLicenseFile,
                'driving_license_avatar_back' => $backLicenseFile,
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
    // public function destroy($id)
    // {
    //     try {
    //         // Find the license by ID
    //         $license = DriversLicenses::findOrFail($id);
    //         $driver = $license->driver;

    //         // Check if the license is found
    //         if (!$license) {
    //             return redirect()->back()->with('error', 'License not found');
    //         }

    //         // Start a database transaction
    //         DB::beginTransaction();

    //         // Delete the front avatar if it exists
    //         if ($license->driving_license_avatar_front && file_exists(public_path($license->driving_license_avatar_front))) {
    //             unlink(public_path($license->driving_license_avatar_front)); // Delete the front avatar
    //         }

    //         // Delete the back avatar if it exists
    //         if ($license->driving_license_avatar_back && file_exists(public_path($license->driving_license_avatar_back))) {
    //             unlink(public_path($license->driving_license_avatar_back)); // Delete the back avatar
    //         }

    //         // Delete the license
    //         $license->delete();

    //         // Update driver status
    //         $driver->status = 'inactive';
    //         $driver->save();

    //         // Commit the transaction
    //         DB::commit();

    //         return redirect()->route('driver.license')->with('success', 'License deleted successfully');
    //     } catch (Exception $e) {
    //         // Rollback transaction on error
    //         DB::rollBack();
    //         Log::error('DELETE LICENSE ERROR');
    //         Log::error($e);
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }


    public function destroy($id)
    {
        try {
            // Find the license by ID
            $license = DriversLicenses::findOrFail($id);
            $driver = $license->driver;

            // Check if the license is found
            if (!$license) {
                return redirect()->back()->with('error', 'License not found');
            }

            // Start a database transaction
            DB::beginTransaction();

            // Delete the front avatar if it exists
            if ($license->driving_license_avatar_front && file_exists('public_html_metroberry_app/' . $license->driving_license_avatar_front)) {
                unlink('public_html_metroberry_app/' . $license->driving_license_avatar_front); // Delete the front avatar
            }

            // Delete the back avatar if it exists
            if ($license->driving_license_avatar_back && file_exists('public_html_metroberry_app/' . $license->driving_license_avatar_back)) {
                unlink('public_html_metroberry_app/' . $license->driving_license_avatar_back); // Delete the back avatar
            }

            // Delete the license
            $license->delete();

            // Update driver status
            $driver->status = 'inactive';
            $driver->save();

            // Commit the transaction
            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License deleted successfully');
        } catch (Exception $e) {
            // Rollback transaction on error
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
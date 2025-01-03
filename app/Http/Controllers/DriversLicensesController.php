<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\DriversLicenses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DriversLicensesExport;
use Illuminate\Support\Facades\Validator;

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

            // Validate input data
            $validator = Validator::make($data, [
                'driver' => 'required|numeric|exists:drivers,id',
                'license_no' => 'required|string|unique:drivers_licenses,driving_license_no',
                'first_date_of_issue' => 'required|date|before:' . now()->subYears(5)->toDateString(),
                'driving_license_renewal_date_issue' => 'required|date',
                'expiry_date' => 'required|date|after:driving_license_renewal_date_issue',
                'front_page_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'back_page_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('CREATE LICENSE VALIDATION ERROR');
                Log::error($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $licenseNumber = $data['license_no'];

            // Fetch driver details
            $dl_driver_id = $request->driver;
            $driver = Driver::findOrFail($dl_driver_id);
            $driverUserId = $driver->user_id;
            $driverUser = User::findOrFail($driverUserId);
            $driver_name = $driverUser->name;
            $driver_email = $driverUser->email;
            $driver_phone = $driverUser->phone;

            // Define the absolute paths for the uploads
            $frontLicensePath = '/home/kknuicdz/public_html_metroberry_app/uploads/front-license-pics/';
            $backLicensePath = '/home/kknuicdz/public_html_metroberry_app/uploads/back-license-pics/';

            // Handle the front license image upload
            if ($request->hasFile('front_page_id')) {
                $frontLicenseFile = $request->file('front_page_id');
                $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
                $frontLicenseFileName = "{$licenseNumber}-{$driver_name}-{$driver_email}-{$driver_phone}-driver-license-front.{$frontLicenseExtension}";

                // Move the file to the specified path
                $frontLicenseFile->move($frontLicensePath, $frontLicenseFileName);
            }

            // Handle the back license image upload
            if ($request->hasFile('back_page_id')) {
                $backLicenseFile = $request->file('back_page_id');
                $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
                $backLicenseFileName = "{$licenseNumber}-{$driver_name}-{$driver_email}-{$driver_phone}-driver-license-back.{$backLicenseExtension}";

                // Move the file to the specified path
                $backLicenseFile->move($backLicensePath, $backLicenseFileName);
            }

            // Begin database transaction
            DB::beginTransaction();

            // Create the new driver's license record
            DriversLicenses::create([
                'driver_id' => $data['driver'],
                'driving_license_no' => $licenseNumber,
                'driving_license_renewal_date_issue' => $data['driving_license_renewal_date_issue'],
                'first_date_of_issue' => $data['first_date_of_issue'],
                'driving_license_date_of_expiry' => $data['expiry_date'],
                'driving_license_avatar_front' => 'uploads/front-license-pics/' . $frontLicenseFileName,
                'driving_license_avatar_back' => 'uploads/back-license-pics/' . $backLicenseFileName,
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License created successfully');
        } catch (Exception $e) {
            // Rollback transaction if there was an error
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
                'first_date_of_issue' => 'required|date|before:' . now()->subYears(5)->toDateString(),
                'driving_license_renewal_date_issue' => 'required|date',
                'driving_license_date_of_expiry' => 'required|date|after:driving_license_date_of_issue',
                'driving_license_avatar_front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'driving_license_avatar_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('UPDATE LICENSE VALIDATION ERROR');
                Log::error($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            // Define the document paths
            $frontLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-license-pics/';
            $backLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-license-pics/';

            // Get driver details
            $dl_driver_id = $license->driver_id;  // Assuming this is the correct column for driver_id
            $driver = Driver::findOrFail($dl_driver_id);
            $driverUserId = $driver->user_id;
            $driverUser = User::findOrFail($driverUserId);
            $driver_name = $driverUser->name;
            $driver_email = $driverUser->email;
            $driver_phone = $driverUser->phone;

            // Handle new front license image upload
            if ($request->hasFile('driving_license_avatar_front')) {
                // Delete the existing front image if it exists
                if ($license->driving_license_avatar_front && file_exists($frontLicenseDirectory . basename($license->driving_license_avatar_front))) {
                    unlink($frontLicenseDirectory . basename($license->driving_license_avatar_front));
                }

                // Store the new front image
                $frontLicenseFile = $request->file('driving_license_avatar_front');
                $frontLicenseExtension = $frontLicenseFile->getClientOriginalExtension();
                $frontLicenseFileName = "{$license->driving_license_no}-{$driver_name}-{$driver_email}-{$driver_phone}-driver-license-front.{$frontLicenseExtension}";
                $frontLicensePath = 'uploads/front-license-pics/' . $frontLicenseFileName; // Relative path to store in DB

                // Move the file to the specified directory
                $frontLicenseFile->move($frontLicenseDirectory, $frontLicenseFileName);
            }

            // Handle new back license image upload
            if ($request->hasFile('driving_license_avatar_back')) {
                // Delete the existing back image if it exists
                if ($license->driving_license_avatar_back && file_exists($backLicenseDirectory . basename($license->driving_license_avatar_back))) {
                    unlink($backLicenseDirectory . basename($license->driving_license_avatar_back));
                }

                // Store the new back image
                $backLicenseFile = $request->file('driving_license_avatar_back');
                $backLicenseExtension = $backLicenseFile->getClientOriginalExtension();
                $backLicenseFileName = "{$license->driving_license_no}-{$driver_name}-{$driver_email}-{$driver_phone}-driver-license-back.{$backLicenseExtension}";
                $backLicensePath = 'uploads/back-license-pics/' . $backLicenseFileName; // Relative path to store in DB

                // Move the file to the specified directory
                $backLicenseFile->move($backLicenseDirectory, $backLicenseFileName);
            }

            DB::beginTransaction();

            // Update the license details
            $license->update([
                'first_date_of_issue' => $data['first_date_of_issue'],
                'driving_license_renewal_date_issue' => $data['driving_license_renewal_date_issue'],
                'driving_license_date_of_expiry' => $data['driving_license_date_of_expiry'],
                'driving_license_avatar_front' => $frontLicensePath ?? $license->driving_license_avatar_front,
                'driving_license_avatar_back' => $backLicensePath ?? $license->driving_license_avatar_back,
                'verified' => false
            ]);

            // Update driver status
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
            // Find the license by ID
            $license = DriversLicenses::findOrFail($id);
            $driver = $license->driver;

            // Start a database transaction
            DB::beginTransaction();

            // Define the directories for front and back license images
            $frontLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-license-pics/';
            $backLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-license-pics/';

            // Delete the front license image if it exists
            if ($license->driving_license_avatar_front && file_exists($frontLicenseDirectory . $license->driving_license_avatar_front)) {
                unlink($frontLicenseDirectory . $license->driving_license_avatar_front); // Delete the front avatar
                Log::info('Deleted front license avatar: ' . $license->driving_license_avatar_front);
            }

            // Delete the back license image if it exists
            if ($license->driving_license_avatar_back && file_exists($backLicenseDirectory . $license->driving_license_avatar_back)) {
                unlink($backLicenseDirectory . $license->driving_license_avatar_back); // Delete the back avatar
                Log::info('Deleted back license avatar: ' . $license->driving_license_avatar_back);
            }

            // Delete the license record from the database
            $license->delete();

            // Update the driver's status to 'inactive'
            $driver->status = 'inactive';
            $driver->save();

            // Commit the transaction
            DB::commit();

            return redirect()->route('driver.license')->with('success', 'License and associated files deleted successfully');
        } catch (Exception $e) {
            // Rollback the transaction on error
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

            $today = Carbon::today();

            // Check if the driver license issue date is less than 5 years old
            $issueDate = Carbon::parse($license->first_date_of_issue);
            $fiveYearsAgo = $today->subYears(5);

            if ($issueDate > $fiveYearsAgo) {
                return redirect()->back()->with('error', 'Driver license issue date is less than 5 years old');
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
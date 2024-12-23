<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Exports\DriverExport;
use App\Imports\DriverImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $drivers = null;

            if (Auth::user()->role == 'admin') {
                $drivers = Driver::with('user')->get();
            } elseif (Auth::user()->role == 'organisation') {
                $drivers = Driver::whereHas('user', function ($query) {
                    $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                    $query->where('organisation_id', $organisation->id);
                })->with('user')->get();
            } else {
                $drivers = Driver::where('created_by', Auth::user()->id)->with('user')->get();
            }

            $organisations = Organisation::all();
            return view('driver.index', compact('drivers', 'organisations'));
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error fetching drivers: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while fetching the drivers. Please try again.');
        }
    }

    // public function store(Request $request) {

    //     try {


    //         $data = $request->all();

    //         $validator = Validator::make($data, [
    //             'name' => 'required|string',
    //             'phone' => 'required|string',
    //             'organisation' => 'required|string',
    //             'email' => 'required|email|unique:users,email',
    //             'address' => 'nullable|string',
    //             'national_id' => 'required|string',
    //             'front_page_id' => 'required|file|mimes:jpg,jpeg,png,webp',
    //             'back_page_id' => 'required|file|mimes:jpg,jpeg,png,webp',
    //             'password' => 'required|string',
    //             'avatar' => 'nullable|file|mimes:jpg,jpeg,png,webp,jfif',
    //         ]);

    //         if ($validator->fails()) {
    //             Log::error('VALIDATION ERROR');
    //             Log::error($validator->errors());
    //             return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    //         }

    //         DB::beginTransaction();

    //         $organisation = Organisation::where('organisation_code', $data['organisation'])->first();

    //         if (!$organisation) {
    //             return redirect()->back()->with('error', 'Organisation not found')->withInput();
    //         }

    //         $frontIdPath = null;
    //         $backIdPath = null;
    //         $avatarPath = null;
    //         $email = $data['email'];
    //         $generatedPassword = $data['password'];

    //         if ($request->hasFile('front_page_id')) {
    //             $frontIdFile = $request->file('front_page_id');
    //             $frontIdExtension = $frontIdFile->getClientOriginalExtension();
    //             $frontIdFileName = "{$email}-front-id.{$frontIdExtension}";
    //             $frontIdPath = $frontIdFile->storeAs('uploads/front-page-ids', $frontIdFileName, 'public');
    //         }

    //         if ($request->hasFile('back_page_id')) {
    //             $backIdFile = $request->file('back_page_id');
    //             $backIdExtension = $backIdFile->getClientOriginalExtension();
    //             $backIdFileName = "{$email}-back-id.{$backIdExtension}";
    //             $backIdPath = $backIdFile->storeAs('uploads/back-page-ids', $backIdFileName, 'public');
    //         }

    //         if ($request->hasFile('avatar')) {
    //             $avatarFile = $request->file('avatar');
    //             $avatarExtension = $avatarFile->getClientOriginalExtension();
    //             $avatarFileName = "{$email}-avatar.{$avatarExtension}";
    //             $avatarPath = $avatarFile->storeAs('uploads/user-avatars', $avatarFileName, 'public');
    //         }

    //         $user = User::create([
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'password' => bcrypt($data['password']),
    //             'phone' => $data['phone'],
    //             'address' => $data['address'],
    //             // 'phone' => $data['phone'],
    //             // 'address' => $data['address'],
    //             'avatar' => $avatarPath,
    //             'created_by' => Auth::user()->id,
    //             'role' => 'driver',
    //         ]);

    //         $user->assignRole('driver');

    //         Driver::create([
    //             'created_by' => Auth::user()->id,
    //             'user_id' => $user->id,
    //             'organisation_id' => $organisation->id,
    //             'national_id_no' => $data['national_id'],
    //             'national_id_front_avatar' => $frontIdPath,
    //             'national_id_behind_avatar' => $backIdPath,
    //         ]);

    //         DB::commit();

    //         // Send email with the plain password
    //         Mail::send('mail-view.driver-welcome-mail', [
    //             'driver' => $user->name,
    //             'email' => $user->email,
    //             'password' => $generatedPassword
    //         ], function ($message) use ($user) {
    //             $message->to($user->email)
    //                 ->subject('Your Account Created');
    //         });


    //         return redirect()->route('driver')->with('success', 'Driver created successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('CREATE DRIVER ERROR');
    //         Log::error($e);
    //         return redirect()->back()->with('error', 'An error occurred')->withInput();
    //     }
    // }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('DATA');
            Log::info($data);

            $validator = Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'organisation' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'address' => 'nullable|string',
                'national_id_no' => 'required|digits:8|unique:drivers|unique:customers',
                'front_page_id' => 'required|file|mimes:jpg,jpeg,png,webp',
                'back_page_id' => 'required|file|mimes:jpg,jpeg,png,webp',
                'password' => 'required|string',
                'avatar' => 'nullable|file|mimes:jpg,jpeg,png,webp,jfif',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $organisation = Organisation::where('organisation_code', $data['organisation'])->first();

            if (!$organisation) {
                return redirect()->back()->with('error', 'Organisation not found')->withInput();
            }

            $frontIdPath = null;
            $backIdPath = null;
            $avatarPath = null;
            $email = $data['email'];
            $name = $data['name'];
            $phone = $data['phone'];
            $generatedPassword = $data['password'];

            // Define the document paths
            $driverFrontPageIdDocPath = 'home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids/';
            $driverBackPageIdDocPath = 'home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids/';

            // Handle front ID upload
            if ($request->hasFile('front_page_id')) {
                $frontIdFile = $request->file('front_page_id');
                $frontIdExtension = $frontIdFile->getClientOriginalExtension();
                $frontIdFileName = "{$name}-{$email}-{$phone}-front-id.{$frontIdExtension}";
                $frontIdPath = 'uploads/front-page-ids/' . $frontIdFileName;

                // Ensure the directory exists and move the file
                $destinationPath = $driverFrontPageIdDocPath . dirname($frontIdPath);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true); // Create directory if it doesn't exist
                }

                $frontIdFile->move($destinationPath, $frontIdFileName);
            }

            // Handle back ID upload
            if ($request->hasFile('back_page_id')) {
                $backIdFile = $request->file('back_page_id');
                $backIdExtension = $backIdFile->getClientOriginalExtension();
                $backIdFileName = "{$name}-{$email}-{$phone}-back-id.{$backIdExtension}";
                $backIdPath = 'uploads/back-page-ids/' . $backIdFileName;

                // Ensure the directory exists and move the file
                $destinationPath = $driverBackPageIdDocPath . dirname($backIdPath);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true); // Create directory if it doesn't exist
                }

                $backIdFile->move($destinationPath, $backIdFileName);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$name}-{$email}-{$phone}-avatar.{$avatarExtension}";
                $avatarPath = 'uploads/user-avatars/' . $avatarFileName;

                // Ensure the directory exists and move the file
                $destinationPath = 'home/kknuicdz/public_html_metroberry_app/' . dirname($avatarPath);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true); // Create directory if it doesn't exist
                }

                $avatarFile->move($destinationPath, $avatarFileName);
            }

            // Create the user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'phone' => $data['phone'],
                'address' => $data['address'],
                'avatar' => $avatarPath,
                'created_by' => Auth::user()->id,
                'role' => 'driver',
            ]);

            $user->assignRole('driver');

            // Create the driver record
            Driver::create([
                'created_by' => Auth::user()->id,
                'user_id' => $user->id,
                'organisation_id' => $organisation->id,
                'national_id_no' => $data['national_id_no'],
                'national_id_front_avatar' => $frontIdPath,
                'national_id_behind_avatar' => $backIdPath,
            ]);

            DB::commit();

            // Send email with the plain password
            Mail::send('mail-view.driver-welcome-mail', [
                'driver' => $user->name,
                'email' => $user->email,
                'password' => $generatedPassword
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your Account Created');
            });

            return redirect()->route('driver')->with('success', 'Driver created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('CREATE DRIVER ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred')->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $driver = Driver::with('vehicle')->findOrFail($id);

            return response()->json([
                'driver' => $driver
            ], 200);
        } catch (Exception $e) {
            Log::error('Error fetching driver');
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function create()
    {
        $organisations = Organisation::where('status', 'active')->get();
        return view('driver.create', compact('organisations'));
    }


    public function edit($id)
    {
        $driver = Driver::with('vehicle')->findOrfail($id);
        Log::info('DRIVER');
        Log::info($driver);
        $organisations = Organisation::all();
        return view('driver.edit', compact('driver', 'organisations'));
    }


    public function update(Request $request, $id)
    {
        try {
            $driver = Driver::find($id);
            $user = User::find($driver->user_id);
            $data = $request->all();
            $organisation = Organisation::where('organisation_code', $data['organisation'])->first();

            if (!$driver) {
                return redirect()->back()->with('error', 'Driver not found');
            }

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            if (!$organisation) {
                return redirect()->back()->with('error', 'Organisation not found');
            }

            $validator = Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'organisation' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'address' => 'nullable|string',
                'national_id_no' => 'required|digits:8|unique:drivers|unique:customers',
                'front_page_id' => 'nullable|file|mimes:jpg,jpeg,png,webp',
                'back_page_id' => 'nullable|file|mimes:jpg,jpeg,png,webp',
                'avatar' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            Log::info('UPDATE DRIVER');
            Log::info($data);

            DB::beginTransaction();

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->address = $data['address'];
            $driver->national_id_no = $data['national_id_no'];

            $email = $data['email'];
            $name = $data['name'];
            $phone = $data['phone'];

            // Define the upload paths
            $avatarPath = 'home/kknuicdz/public_html_metroberry_app/uploads/user-avatars/';
            $frontIdPath = 'home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids/';
            $backIdPath = 'home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids/';

            // Update avatar if a new file is uploaded
            if ($request->hasFile('avatar')) {
                // Check if the user already has an avatar and delete it
                if ($user->avatar) {
                    $oldAvatarPath = 'home/kknuicdz/public_html_metroberry_app/uploads/' . $user->avatar;
                    if (file_exists($oldAvatarPath)) {
                        unlink($oldAvatarPath); // Delete the old avatar
                    }
                }

                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$name}-{$email}-{$phone}-avatar.{$avatarExtension}";

                // Ensure the directory exists
                if (!is_dir($avatarPath)) {
                    mkdir($avatarPath, 0755, true); // Create directory if it doesn't exist
                }

                // Move the file to the user avatars directory
                $avatarFile->move($avatarPath, $avatarFileName);
                $user->avatar = 'uploads/user-avatars/' . $avatarFileName; // Save the relative path
            }

            // Update front ID if a new file is uploaded
            if ($request->hasFile('front_page_id')) {
                // Check if the driver already has a front ID and delete it
                if ($driver->national_id_front_avatar) {
                    $oldFrontIdPath = 'home/kknuicdz/public_html_metroberry_app/uploads/' . $driver->national_id_front_avatar;
                    if (file_exists($oldFrontIdPath)) {
                        unlink($oldFrontIdPath); // Delete the old front ID
                    }
                }

                $frontIdFile = $request->file('front_page_id');
                $frontIdExtension = $frontIdFile->getClientOriginalExtension();
                $frontIdFileName = "{$email}-front-id.{$frontIdExtension}";

                // Ensure the directory exists
                if (!is_dir($frontIdPath)) {
                    mkdir($frontIdPath, 0755, true); // Create directory if it doesn't exist
                }

                // Move the file to the front ID directory
                $frontIdFile->move($frontIdPath, $frontIdFileName);
                $driver->national_id_front_avatar = 'uploads/front-page-ids/' . $frontIdFileName; // Save the relative path
            }

            // Update back ID if a new file is uploaded
            if ($request->hasFile('back_page_id')) {
                // Check if the driver already has a back ID and delete it
                if ($driver->national_id_behind_avatar) {
                    $oldBackIdPath = 'home/kknuicdz/public_html_metroberry_app/uploads/' . $driver->national_id_behind_avatar;
                    if (file_exists($oldBackIdPath)) {
                        unlink($oldBackIdPath); // Delete the old back ID
                    }
                }

                $backIdFile = $request->file('back_page_id');
                $backIdExtension = $backIdFile->getClientOriginalExtension();
                $backIdFileName = "{$name}-{$email}-{$phone}-back-id.{$backIdExtension}";

                // Ensure the directory exists
                if (!is_dir($backIdPath)) {
                    mkdir($backIdPath, 0755, true); // Create directory if it doesn't exist
                }

                // Move the file to the back ID directory
                $backIdFile->move($backIdPath, $backIdFileName);
                $driver->national_id_behind_avatar = 'uploads/back-page-ids/' . $backIdFileName; // Save the relative path
            }

            // Save the changes to the driver and user
            $driver->save();
            $user->save();

            DB::commit();

            return redirect()->route('driver')->with('success', 'Driver updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE DRIVER ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred');
        }
    }



    public function assignVehicleForm($id)
    {
        $driver = Driver::with('vehicle')->findOrfail($id);
        $vehicles = Vehicle::where('status', 'active')
            ->doesntHave('driver')
            ->get();
        return view('driver.assign-vehicle', compact('driver', 'vehicles'));
    }

    public function assignVehicle(Request $request, $id)
    {
        try {

            $driver = Driver::find($id);
            $data = $request->all();

            $validator = Validator::make($data, [
                'vehicle_id' => 'required|exists:vehicles,id',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            if (!$driver) {
                return redirect()->back()->with('error', 'Driver not found');
            }

            $vehicle = Vehicle::find($data['vehicle_id']);

            if (!$vehicle) {
                return redirect()->back()->with('error', 'Vehicle not found');
            }

            if ($vehicle->driver) {
                return redirect()->back()->with('error', 'Vehicle is already assigned to another driver');
            }

            DB::beginTransaction();

            $vehicle->driver_id = $driver->id;
            $vehicle->save();

            DB::commit();

            return redirect()->route('driver')->with('success', 'Vehicle assigned successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ASSIGN VEHICLE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred');
        }
    }

    public function driverPerformance()
    {
        $drivers = Driver::with('user', 'vehicle')->get();
        return view('driver.performance.index', compact('drivers'));
    }

    public function createDriverPerformance()
    {
        return view('driver.performance.create');
    }

    /**
     * Activate driver
     */

    public function activateForm($id)
    {
        $driver = Driver::findOrfail($id);
        return view('driver.activate', compact('driver'));
    }

    public function activate($id)
    {
        try {
            $driver = Driver::findOrFail($id);

            Log::info('DRIVER to ACTIVATE : ');
            Log::info($driver);

            Log::info('DRIVER PSV Badge is : ');
            Log::info($driver->psvBadge);

            Log::info('DRIVER LICENSE Is : ');
            Log::info($driver->driverLicense);

            if ($driver->status == 'active') {
                return redirect()->back()->with('error', 'Driver is already active');
            }

            if (!$driver->driverLicense) {
                return redirect()->back()->with('error', 'Driver does not have a license');
            }

            // Check if the driver license issue date is less than 5 years old
            if (!is_null($driver->driverLicense->first_date_of_issue)) {
                $issueDate = Carbon::parse($driver->driverLicense->first_date_of_issue);
                $fiveYearsAgo = Carbon::now()->subYears(5);

                if ($issueDate > $fiveYearsAgo) {
                    return redirect()->back()->with('error', 'Driver license issue date is less than 5 years old');
                }
            } else {
                return redirect()->back()->with('error', 'Driver license first date of issue is not available');
            }

            if (Carbon::parse($driver->driverLicense->driving_license_date_of_expiry) < Carbon::today()) {
                return redirect()->back()->with('error', 'Driver license has expired');
            }

            if (!$driver->driverLicense->driving_license_avatar_front || !$driver->driverLicense->driving_license_avatar_back) {
                return redirect()->back()->with('error', 'Driver license documents are missing');
            }

            if (!$driver->driverLicense->verified) {
                return redirect()->back()->with('error', 'Driver license has not been verified');
            }

            if (!$driver->psvBadge) {
                return redirect()->back()->with('error', 'Driver does not have a PSV Badge');
            }

            if (Carbon::parse($driver->psvBadge->psv_badge_date_of_expiry) < Carbon::today()) {
                return redirect()->back()->with('error', 'Driver PSV Badge has expired');
            }

            if (!$driver->psvBadge->psv_badge_avatar) {
                return redirect()->back()->with('error', 'Driver PSV Badge documents are missing');
            }

            if (!$driver->psvBadge->verified) {
                return redirect()->back()->with('error', 'Driver PSV Badge has not been verified');
            }

            DB::beginTransaction();

            $driver->status = 'active';
            $driver->save();

            DB::commit();

            return redirect()->route('driver')->with('success', 'Driver activated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ACTIVATE DRIVER ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred');
        }
    }

    public function deactivateForm($id)
    {
        $driver = Driver::findOrfail($id);
        return view('driver.deactivate', compact('driver'));
    }

    /**
     * Deactivate driver
     */

    public function deactivate($id)
    {
        try {

            $driver = Driver::findOrfail($id);

            if ($driver->status == 'inactive') {
                return redirect()->back()->with('error', 'Driver is already inactive');
            }

            DB::beginTransaction();

            $driver->status = 'inactive';

            $driver->save();

            DB::commit();

            return redirect()->route('driver')->with('success', 'Driver deactivated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DEACTIVATE DRIVER ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred');
        }
    }




    // public function export()
    // {
    //     $fileName = 'drivers_' . date('Y-m-d_H-i-s') . '.xlsx';

    //     \Log::info('Exporting file: ' . $fileName);

    //     return Excel::download(new DriverExport, $fileName);
    // }

    public function export(Request $request)
    {
        return Excel::download(new DriverExport(), 'drivers.xlsx');
    }


    /**
     * 
     *Import Driver detials 

     */
    // Display the import file view
    public function importFile()
    {
        return view('driver.importDriver');
    }

    // Handle the import of the file
    public function import(Request $request)
    {
        // Validation rules
        $rules = [
            'file' => 'required|mimes:csv,txt,xlsx',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, redirect back with error message
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            // Import the file using the DriverImport class
            Excel::import(new DriverImport, $request->file('file'));

            // Log the import action
            Log::info('Data from Driver CSV File being Imported: ', ['file' => $request->file('file')]);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Records imported successfully.');
        } catch (Exception $e) {
            // Log the error
            Log::error('Error importing Drivers: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'An error occurred while importing the Driver records.');
        }
    }





    public function delete($id)
    {
        $driver = Driver::findOrFail($id);

        $user = User::find($driver->user_id);
        return view('driver.delete', compact('driver', 'user'));
    }

    // Remove the specified resource from storage
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $driver = Driver::find($id);

            if (!$driver) {
                return redirect()->back()->with('error', 'Driver not found');
            }

            $user = User::find($driver->user_id);

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            // Define the file paths
            $avatarPath = 'home/kknuicdz/public_html_metroberry_app/uploads/user-avatars/';
            $frontIdPath = 'home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids/';
            $backIdPath = 'home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids/';

            // Delete the user's avatar if it exists
            if ($user->avatar) {
                $oldAvatarPath = $avatarPath . $user->avatar;
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath); // Delete the old avatar
                }
            }

            // Delete the driver's front ID if it exists
            if ($driver->national_id_front_avatar) {
                $oldFrontIdPath = $frontIdPath . $driver->national_id_front_avatar;
                if (file_exists($oldFrontIdPath)) {
                    unlink($oldFrontIdPath); // Delete the old front ID
                }
            }

            // Delete the driver's back ID if it exists
            if ($driver->national_id_behind_avatar) {
                $oldBackIdPath = $backIdPath . $driver->national_id_behind_avatar;
                if (file_exists($oldBackIdPath)) {
                    unlink($oldBackIdPath); // Delete the old back ID
                }
            }

            DB::beginTransaction();

            // Delete the driver and user records
            $driver->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('driver')->with('success', 'Driver details deleted successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE DRIVER ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred while deleting the driver');
        }
    }

}
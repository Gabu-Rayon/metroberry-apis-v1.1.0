<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\PSVBadge;
use App\Models\Organisation;
use App\Models\VehicleClass;
use Illuminate\Http\Request;
use App\Models\DriversLicenses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverAppController extends Controller
{

    /**
     * Show Driver Signup Form
     * 
     * @return \Illuminate\View\View
     */

    public function signup()
    {
        // Retrieve organisations from the database
        $organisations = Organisation::all();
        return view('driver-app.signup', compact('organisations'));
    }

    /**
     * Store Driver Signup Form
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function signupstore(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/'
                ],
                'national_id_no' => 'required|string|max:255|unique:drivers|unique:customers',
                'organisation_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $user = DB::table('users')->insertGetId([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => 'driver',
            ]);

            DB::table('drivers')->insert([
                'created_by' => $user,
                'organisation_id' => $data['organisation_id'],
                'user_id' => $user,
                'national_id_no' => $data['national_id_no'],
            ]);

            DB::commit();

            return redirect()->route('driver.login')->with('success', 'Driver signed up successfully.')->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('SIGN UP DRIVER ERROR');
            Log::error($e);

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Show Driver Dashboard
     * 
     * @return \Illuminate\View\View
     */

    public function dashboard()
    {

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a driver
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the driver data based on the user_id in the drivers table
        $driver = Driver::where('user_id', $user->id)->firstOrFail();

        // Log driver information for debugging
        Log::info('Driver is Huyo Apa:', ['driver' => $driver]);

        // Fetch the completed trips for the driver
        $trips = Trip::where('driver_id', $driver->id)->where('status', 'assigned')->get();
        Log::info('Driver Trips Ndizo hzi  Apa:', ['trips' => $trips]);

        return view('driver-app.dashboard', compact('trips'));
    }

    /**
     * Store Driver Personal Documents
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function iddocs(Request $request)
    {
        try {
            $data = $request->all();

            // Validate the incoming request data
            $validator = Validator::make($data, [
                'national_id_front_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'national_id_back_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            // Store files in the storage/app/public/uploads directory

            // National ID front image uploaded to uploads/front-page-ids
            $national_id_front_avatar = $request->file('national_id_front_avatar')->store('uploads/front-page-ids', 'public');

            // National ID back image uploaded to uploads/back-page-ids
            $national_id_back_avatar = $request->file('national_id_back_avatar')->store('uploads/back-page-ids', 'public');

            $driver = auth()->user()->driver;

            $driver->national_id_front_avatar = $national_id_front_avatar;
            $driver->national_id_behind_avatar = $national_id_back_avatar;

            $driver->save();

            return redirect()->route('driver.dashboard')->with('success', 'Driver personal documents uploaded successfully.');
        } catch (Exception $e) {
            Log::error('UPLOAD DRIVER PERSONAL DOCUMENTS ERROR');
            Log::error($e);

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Store Driver License
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function license(Request $request)
    {
        try {
            $data = $request->all();

            // Validate the incoming request data
            $validator = Validator::make($data, [
                'driving_license_no' => 'required|string|max:255|unique:drivers_licenses',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after:issue_date',
                'driving_license_avatar_front' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'driving_license_avatar_back' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Store files in the storage/app/public/uploads directory

            // Front license image uploaded to uploads/front-license-pics
            $driving_license_avatar_front = $request->file('driving_license_avatar_front')->store('uploads/front-license-pics', 'public');

            // Back license image uploaded to uploads/back-license-pics
            $driving_license_avatar_back = $request->file('driving_license_avatar_back')->store('uploads/back-license-pics', 'public');

            // Create a new driver license record with the stored file paths
            DriversLicenses::create([
                'driver_id' => auth()->user()->driver->id,
                'driving_license_no' => $data['driving_license_no'],
                'driving_license_date_of_issue' => $data['issue_date'],
                'driving_license_date_of_expiry' => $data['expiry_date'],
                'driving_license_avatar_front' => $driving_license_avatar_front,
                'driving_license_avatar_back' => $driving_license_avatar_back,
            ]);

            DB::commit();

            return redirect()->route('driver.dashboard')->with('success', 'Driver license uploaded successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPLOAD DRIVER LICENSE ERROR');
            Log::error($e);

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Update Driver License
     * 
     * @param \Illuminate\Http\Request $request
     * @param String $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateLicense(Request $request, $id)
    {
        try {
            $data = $request->all();

            // Validate the incoming request data
            $validator = Validator::make($data, [
                'driving_license_no' => 'required|string|max:255',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after:issue_date',
                'license_front_avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'license_back_avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $license = DriversLicenses::find($id);

            if ($request->hasFile('license_front_avatar')) {
                // License front image uploaded to uploads/front-license-pics
                $driving_license_avatar_front = $request->file('license_front_avatar')->store('uploads/front-license-pics', 'public');
                $license->driving_license_avatar_front = $driving_license_avatar_front;
            }

            if ($request->hasFile('license_back_avatar')) {
                // License back image uploaded to uploads/back-license-pics
                $driving_license_avatar_back = $request->file('license_back_avatar')->store('uploads/back-license-pics', 'public');
                $license->driving_license_avatar_back = $driving_license_avatar_back;
            }

            $license->driving_license_no = $data['driving_license_no'];
            $license->driving_license_date_of_issue = $data['issue_date'];
            $license->driving_license_date_of_expiry = $data['expiry_date'];

            $license->save();

            DB::commit();

            return redirect()->route('driver.dashboard')->with('success', 'Driver license updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE DRIVER LICENSE ERROR');
            Log::error($e);

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }


    /**
     * Store Driver PSV Badge
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function psvbadge(Request $request)
    {
        try {
            $data = $request->all();

            // Validate the incoming request data
            $validator = Validator::make($data, [
                'psv_badge_no' => 'required|string|max:255|unique:psv_badges',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after:issue_date',
                'badge_copy' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Store the uploaded file in the public disk under uploads/psvbadge-avatars
            $psv_badge_avatar = $request->file('badge_copy')->store('uploads/psvbadge-avatars', 'public');

            // Create a new PSV badge record
            PSVBadge::create([
                'driver_id' => auth()->user()->driver->id,
                'psv_badge_no' => $data['psv_badge_no'],
                'psv_badge_date_of_issue' => $data['issue_date'],
                'psv_badge_date_of_expiry' => $data['expiry_date'],
                'psv_badge_avatar' => $psv_badge_avatar,
            ]);

            DB::commit();

            return redirect()->route('driver.dashboard')->with('success', 'Driver PSV badge uploaded successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPLOAD DRIVER PSV BADGE ERROR');
            Log::error($e);

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Update Driver PSV Badge
     * 
     * @param \Illuminate\Http\Request $request
     * @param String $id
     * 
     * @return \Illuminate\View\View
     */

    public function updatePsvBadge(Request $request, $id)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'psv_badge_no' => 'required|string|max:255',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after:issue_date',
                'badge_copy' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $psvBadge = PSVBadge::find($id);

            if ($request->hasFile('badge_copy')) {
                //Psv to be upoaded to uploads/psvbadge-avatars
                $psv_badge_avatar = $request->file('badge_copy')->store('uploads/psvbadge-avatars', 'public');
                $psvBadge->psv_badge_avatar = $psv_badge_avatar;
            }

            $psvBadge->psv_badge_no = $data['psv_badge_no'];
            $psvBadge->psv_badge_date_of_issue = $data['issue_date'];
            $psvBadge->psv_badge_date_of_expiry = $data['expiry_date'];

            $psvBadge->save();

            DB::commit();

            return redirect()->route('driver.dashboard')->with('success', 'Driver PSV badge updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE DRIVER PSV BADGE ERROR');
            Log::error($e);

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Driver Documents Page
     * 
     * @return \Illuminate\View\View
     */

    public function documents()
    {
        return view('driver-app.documents');
    }

    /**
     * Driver Vehicle Page
     * 
     * @return \Illuminate\View\View
     */

    public function vehicle()
    {

        // Get the authenticated user
        $user = Auth::user();
        $organisations = Organisation::all();
        $vehicleClasses = VehicleClass::all();

        // Check if the user is a customer
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the customer data based on the user_id in the customers table
        $driver = Driver::where('user_id', $user->id)->firstOrFail();
        return view('driver-app.vehicle', compact('driver', 'organisations', 'vehicleClasses'));
    }

    /**
     * 
     * 
     * @return \Illuminate\View\View
     */


    public function driverRegistrationPage()
    {
        return view('driver-app.driver-registration');
    }

    public function driverLicenseDocument()
    {
        return view('driver-app.driver-license');
    }

    public function personalIdCardDocument()
    {
        return view('driver-app.personal-id-card');
    }


    public function psvbadgeDocument()
    {
        return view('driver-app.psv-badge');
    }

    public function profile()
    {

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a customer
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the customer data based on the user_id in the customers table
        $driver = Driver::where('user_id', $user->id)->firstOrFail();
        return view('driver-app.profile', compact('driver'));
    }

    public function profileUpdate(Request $request, $id)
    {
        try {
            $data = $request->all();

            Log::info('DATA');
            Log::info($data);

            $validator = Validator::make($data, [
                'full-name' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required|string|max:255',
                'national_id_no' => 'required|string|max:255',
                'organisation_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            $driver = Driver::find($id);

            $driver->name = $data['name'];
            $driver->email = $data['email'];
            $driver->phone = $data['phone'];
            $driver->national_id_no = $data['national_id_no'];
            $driver->organisation_id = $data['organisation_id'];

            $driver->save();

            return redirect()->route('driver.profile')->with('success', 'Driver profile updated successfully.');
        } catch (Exception $e) {
            Log::error('UPDATE DRIVER PROFILE ERROR');
            Log::error($e);

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /****
     * 
     * Driver Trips History 
     * 
     */

    // Method to show trip history page
    public function tripHistoryPage()
    {
        // $user = Auth::user();
        // $driver = $user->driver;

        // $trips = Trip::where('driver_id', $driver->id)->get();

        return view('driver-app.trips-history');
    }

    // Method to show assigned trips page
    public function tripsAssignedPage()
    {
        $user = Auth::user();
        $driver = $user->driver;

        $trips = Trip::where('driver_id', $driver->id)->where('status', 'assigned')->get();

        return view('driver-app.trips-assigned', compact('trips'));
    }

    // Method to show a specific assigned trip details
    public function tripAssignedShowPage($id)
    {
        $trip = Trip::findOrFail($id);

        return view('driver-app.trip-assigned-show', compact('trip'));
    }

    // Method to show completed trips page
    public function tripsCompletedPage()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a driver
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the driver data based on the user_id in the drivers table
        $driver = Driver::where('user_id', $user->id)->firstOrFail();

        // Log driver information for debugging
        Log::info('Driver is Huyo Apa:', ['driver' => $driver]);

        // Fetch the completed trips for the driver
        $trips = Trip::where('driver_id', $driver->id)->where('status', 'completed')->get();
        Log::info('Driver Trips Ndizo hzi  Apa:', ['trips' => $trips]);

        // Return the view with the trips data
        return view('driver-app.trips-completed', compact('trips'));
    }


    // Method to show a specific completed trip details
    public function tripCompletedShowPage($id)
    {
        $trip = Trip::findOrFail($id);

        return view('driver-app.trip-completed-show', compact('trip'));
    }


    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $driver = $user->driver;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = $file->getClientOriginalName();
            $directory = 'uploads/user-avatars/' . $user->id . '/';
            $filePath = $directory . $fileName;

            // Store the file in the public disk in this folder of uploads/user-avatars
            Storage::disk('public')->put($filePath, file_get_contents($file));

            // Update the user's profile picture path
            $driver->user->avatar = $filePath;
            $driver->user->save();

            return response()->json(['newProfilePictureUrl' => Storage::url($filePath)]);
        }

        return response()->json(['error' => 'Failed to upload profile picture'], 400);
    }



}
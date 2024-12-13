<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Trip;
use App\Models\User;
use App\Rules\Phone;
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
            Log::info('Driver Sign up : ');
            Log::info($data);

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => ['required', 'string', 'unique:users,phone', 'max:15', new Phone()],
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
                'national_id_no' => 'required|digits:8|unique:drivers|unique:customers',
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
                'phone' => $data['phone'],
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

            return redirect()->route('users.sign.in.page')->with('success', 'Your Account Created successfully.')->withInput();
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

        // Ensure the user is a driver
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the driver data based on the user_id in the drivers table
        $driver = Driver::where('user_id', $user->id)->firstOrFail();

        // Log driver information for debugging
        Log::info('Driver Information:', ['driver' => $driver]);

        // Fetch All assigned trips for the driver of not return null 
        $trips = Trip::where('driver_id', $driver->id)
            ->where('status', 'assigned')
            ->get();

        // Log the driver's trips for debugging
        Log::info('Driver Trips:', ['trips' => $trips]);

        // Return the dashboard view with the trips data
        return view('driver-app.dashboard', compact('trips'));
    }

    /**
     * Store Driver Personal Documents
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function iddocs(Request $request, $id)
    {
        try {
            $data = $request->all();

            // Validate the request data
            $validator = Validator::make($data, [
                'national_id_front_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'national_id_back_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            // Find the driver by ID
            $driver = Driver::findOrFail($id);

            // Define the directories for the ID uploads
            $frontIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids';
            $backIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids';

            if (app()->environment('local')) {
                $frontIdDirectory = public_path('uploads/front-page-ids');
                $backIdDirectory = public_path('uploads/back-page-ids');
            } else {
                $frontIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids';
                $backIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids';
                if (!is_dir($frontIdDirectory)) {
                    mkdir($frontIdDirectory, 0755, true); // Create directory if it doesn't exist
                }

                if (!is_dir($backIdDirectory)) {
                    mkdir($backIdDirectory, 0755, true); // Create directory if it doesn't exist
                }
            }

            // Ensure the directories exist

            // Upload front and back images
            $national_id_front_avatar = $request->file('national_id_front_avatar');
            $national_id_back_avatar = $request->file('national_id_back_avatar');

            // Create file names
            $frontFileName = "{$driver->email}-national-id-front." . $national_id_front_avatar->getClientOriginalExtension();
            $backFileName = "{$driver->email}-national-id-back." . $national_id_back_avatar->getClientOriginalExtension();

            // Move the uploaded files to the new directories
            $national_id_front_avatar->move($frontIdDirectory, $frontFileName);
            $national_id_back_avatar->move($backIdDirectory, $backFileName);

            // Update driver details with the relative paths
            $driver->national_id_front_avatar = 'uploads/front-page-ids/' . $frontFileName;
            $driver->national_id_behind_avatar = 'uploads/back-page-ids/' . $backFileName;
            $driver->save();

            return redirect()->route('driver.registration.page')->with('success', 'Driver personal documents uploaded successfully.');
        } catch (Exception $e) {
            Log::error('UPLOAD DRIVER PERSONAL DOCUMENTS ERROR');
            Log::error($e->getMessage());

            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }


    public function iddocsUpdate(Request $request, $id)
    {
        try {
            $data = $request->all();

            // Validate the request data
            $validator = Validator::make($data, [
                'national_id_no' => 'nullable|digits:8', // Exactly 8 numeric digits
                'national_id_front_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'national_id_back_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            // Find the driver by ID
            $driver = Driver::findOrFail($id);

            // Define the directories for the ID uploads
            $frontIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids';
            $backIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids';

            if (app()->environment('local')) {
                $frontIdDirectory = public_path('uploads/front-page-ids');
                $backIdDirectory = public_path('uploads/back-page-ids');
            } else {
                $frontIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids';
                $backIdDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids';
                // Create directories if they don't exist
                if (!is_dir($frontIdDirectory)) {
                    mkdir($frontIdDirectory, 0755, true);
                }

                if (!is_dir($backIdDirectory)) {
                    mkdir($backIdDirectory, 0755, true);
                }
            }

            // Upload front and back images
            $national_id_front_avatar = $request->file('national_id_front_avatar');
            $national_id_back_avatar = $request->file('national_id_back_avatar');

            // Create file names
            $frontFileName = "{$driver->email}-national-id-front." . $national_id_front_avatar->getClientOriginalExtension();
            $backFileName = "{$driver->email}-national-id-back." . $national_id_back_avatar->getClientOriginalExtension();

            // Move the uploaded files to the new directories
            $national_id_front_avatar->move($frontIdDirectory, $frontFileName);
            $national_id_back_avatar->move($backIdDirectory, $backFileName);

            // Update driver details with the relative paths
            $driver->national_id_front_avatar = 'uploads/front-page-ids/' . $frontFileName;
            $driver->national_id_behind_avatar = 'uploads/back-page-ids/' . $backFileName;
            $driver->national_id_no = $request->input('national_id_no'); // Corrected key name here
            $driver->save();

            return redirect()->route('driver.registration.page')->with('success', 'Driver personal documents uploaded successfully.');
        } catch (Exception $e) {
            Log::error('UPLOAD DRIVER PERSONAL DOCUMENTS ERROR');
            Log::error($e->getMessage());

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
                'license_front_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'license_back_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Define directories for license uploads
            $frontLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-license-pics';
            $backLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-license-pics';

            $license_front_avatar = $request->file('license_front_avatar');
            $frontFileName = auth()->user()->driver->email . '-front-license.' . $license_front_avatar->getClientOriginalExtension();
            $license_front_avatar->move($frontLicenseDirectory, $frontFileName);

            // Upload back license image
            $license_back_avatar = $request->file('license_back_avatar');
            $backFileName = auth()->user()->driver->email . '-back-license.' . $license_back_avatar->getClientOriginalExtension();
            $license_back_avatar->move($backLicenseDirectory, $backFileName);

            // Create a new driver license record with the stored file paths
            DriversLicenses::create([
                'driver_id' => auth()->user()->driver->id,
                'driving_license_no' => $data['driving_license_no'],
                'driving_license_date_of_issue' => $data['issue_date'],
                'driving_license_date_of_expiry' => $data['expiry_date'],
                'driving_license_avatar_front' => 'uploads/front-license-pics/' . $frontFileName,
                'driving_license_avatar_back' => 'uploads/back-license-pics/' . $backFileName,
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
     * 
     * 
     */



    public function updateLicense(Request $request, $id)
    {
        try {
            $data = $request->all();

            // Validate the incoming request data
            $validator = Validator::make($data, [
                'driving_license_no' => 'nullable|string|max:255',
                'driving_license_date_of_issue' => 'nullable|date',
                'driving_license_date_of_expiry' => 'nullable|date|after:driving_license_date_of_issue',
                'license_front_avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'license_back_avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Get the current license for the authenticated driver
            $license = Auth::user()->driver->license;

            // Define directories for license uploads
            $frontLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/front-license-pics';
            $backLicenseDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/back-license-pics';

            // Ensure the directories exist
            if (!is_dir($frontLicenseDirectory)) {
                mkdir($frontLicenseDirectory, 0755, true); // Create directory if it doesn't exist
            }

            if (!is_dir($backLicenseDirectory)) {
                mkdir($backLicenseDirectory, 0755, true); // Create directory if it doesn't exist
            }

            // Handle file uploads
            if ($request->hasFile('license_front_avatar')) {
                // Delete the old front avatar if it exists
                if ($license->driving_license_avatar_front && file_exists(public_path($license->driving_license_avatar_front))) {
                    unlink(public_path($license->driving_license_avatar_front));
                }

                // Upload the new front license image
                $license_front_avatar = $request->file('license_front_avatar');
                $frontFileName = auth()->user()->driver->email . '-front-license.' . $license_front_avatar->getClientOriginalExtension();
                $license_front_avatar->move($frontLicenseDirectory, $frontFileName);
                $license->driving_license_avatar_front = 'uploads/front-license-pics/' . $frontFileName; // Set the new value
            }

            if ($request->hasFile('license_back_avatar')) {
                // Delete the old back avatar if it exists
                if ($license->driving_license_avatar_back && file_exists(public_path($license->driving_license_avatar_back))) {
                    unlink(public_path($license->driving_license_avatar_back));
                }

                // Upload the new back license image
                $license_back_avatar = $request->file('license_back_avatar');
                $backFileName = auth()->user()->driver->email . '-back-license.' . $license_back_avatar->getClientOriginalExtension();
                $license_back_avatar->move($backLicenseDirectory, $backFileName);
                $license->driving_license_avatar_back = 'uploads/back-license-pics/' . $backFileName; // Set the new value
            }

            // Update only non-null fields
            $license->driving_license_no = $data['driving_license_no'] ?? $license->driving_license_no;
            $license->driving_license_date_of_issue = $data['driving_license_date_of_issue'] ?? $license->driving_license_date_of_issue;
            $license->driving_license_date_of_expiry = $data['driving_license_date_of_expiry'] ?? $license->driving_license_date_of_expiry;

            $license->save();

            DB::commit();

            return redirect()->route('driver.registration.page')->with('success', 'Driver license updated successfully.');
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
     * 
     * 
     */

    public function psvBadgeCreate(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('Data for creating Driver PSV Badge: ');
            Log::info($data);

            // Validate the incoming request data
            $validator = Validator::make($data, [
                'psv_badge_no' => 'required|string|max:255|unique:psv_badges',
                'psv_issue_date' => 'required|date',
                'psv_expiry_date' => 'required|date|after:psv_issue_date',
                'badge_copy' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Define the directory for storing PSV badge images
            $psvBadgeDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/psvbadge-avatars';

            if (app()->environment('local')) {
                $psvBadgeDirectory = public_path('uploads/psvbadge-avatars');
            } else {
                $psvBadgeDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/psvbadge-avatars';
                if (!is_dir($psvBadgeDirectory)) {
                    mkdir($psvBadgeDirectory, 0755, true); // Create directory if it doesn't exist
                }
            }

            // Ensure the directory exists

            // Handle the file upload
            $badge_copy = $request->file('badge_copy');
            $badgeFileName = auth()->user()->driver->email . '-psv-badge.' . $badge_copy->getClientOriginalExtension();
            $badge_copy->move($psvBadgeDirectory, $badgeFileName);

            // Create a new PSV badge record
            PSVBadge::create([
                'driver_id' => auth()->user()->driver->id,
                'psv_badge_no' => $data['psv_badge_no'],
                'psv_badge_date_of_issue' => $data['psv_issue_date'],
                'psv_badge_date_of_expiry' => $data['psv_expiry_date'],
                'psv_badge_avatar' => 'uploads/psvbadge-avatars/' . $badgeFileName, // Store relative path
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
     * 
     * 
     */


    public function updatePsvBadge(Request $request, $id)
    {
        try {
            $data = $request->all();

            Log::info('DATA');
            Log::info($data);

            $validator = Validator::make($data, [
                'psv_badge_no' => 'nullable|string|max:255',
                'psv_badge_date_of_issue' => 'nullable|date',
                'psv_badge_date_of_expiry' => 'nullable|date|after:psv_badge_date_of_issue',
                'badge_copy' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Find the existing PSV badge
            $psvBadge = PSVBadge::findOrFail($id); // Use findOrFail for better error handling

            // Handle file upload if a new file is provided
            if ($request->hasFile('badge_copy')) {
                // Define the directory for storing PSV badge images
                $psvBadgeDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/psvbadge-avatars';

                // Ensure the directory exists
                if (!is_dir($psvBadgeDirectory)) {
                    mkdir($psvBadgeDirectory, 0755, true); // Create directory if it doesn't exist
                }

                // Handle the file upload
                $badge_copy = $request->file('badge_copy');
                $badgeFileName = auth()->user()->driver->email . '-psv-badge-' . time() . '.' . $badge_copy->getClientOriginalExtension();
                $badge_copy->move($psvBadgeDirectory, $badgeFileName);

                // Update the badge avatar path
                $psvBadge->psv_badge_avatar = 'uploads/psvbadge-avatars/' . $badgeFileName;
            }

            // Update the PSV badge details
            $psvBadge->psv_badge_no = $data['psv_badge_no'] ?? $psvBadge->psv_badge_no;
            $psvBadge->psv_badge_date_of_issue = $data['psv_badge_date_of_issue'] ?? $psvBadge->psv_badge_date_of_issue;
            $psvBadge->psv_badge_date_of_expiry = $data['psv_badge_date_of_expiry'] ?? $psvBadge->psv_badge_date_of_expiry;

            $psvBadge->save();

            DB::commit();

            return redirect()->route('driver.registration.page')->with('success', 'Driver PSV badge updated successfully.');
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

        // Check if the user is a driver
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the driver data based on the user_id in the drivers table
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

        // Check if the user is a driver
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the driver data based on the user_id in the drivers table
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
                'full_name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255',
                'phone' => 'nullable|string|max:255',
                'national_id_no' => 'nullable|string|max:255',
                'organisation_id' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors()->all());

                return back()->with('error', $validator->errors()->first())->withInput();
            }
            $driver = Driver::findOrFail($id);
            $user = User::find($driver->user_id);

            $user->update([
                'name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);

            $driver->update([
                'national_id_no' => $data['national_id_no'],
                'organisation_id' => $data['organisation_id'],
            ]);

            $user->save();
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
            // Check if the old profile picture exists and delete it if necessary
            if ($driver->user->avatar) {
                $oldProfilePath = '/home/kknuicdz/public_html_metroberry_app/' . $driver->user->avatar;
                if (file_exists($oldProfilePath)) {
                    unlink($oldProfilePath); // Delete the old profile picture
                }
            }

            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Use a unique name for the file
            $directory = 'uploads/user-avatars/' . $user->id . '/';

            // Ensure the directory exists
            $fullDirectoryPath = '/home/kknuicdz/public_html_metroberry_app/' . $directory;
            if (!is_dir($fullDirectoryPath)) {
                mkdir($fullDirectoryPath, 0755, true); // Create directory if it doesn't exist
            }

            // Move the file to the specified directory
            $file->move($fullDirectoryPath, $fileName);

            // Update the user's profile picture path
            $driver->user->avatar = $directory . $fileName; // Save the relative path
            $driver->user->save();

            return response()->json(['newProfilePictureUrl' => asset($driver->user->avatar)]); // Use asset() to get the URL
        }

        return response()->json(['error' => 'Failed to upload profile picture'], 400);
    }

    public function psvbadgeDocumentUpdate(Request $request, $driverId)
    {
        try {
            // Fetch the driver and their associated PSV badge
            $user = Auth::user();
            $driver = $user->driver;

            // Validate the request
            $validator = Validator::make($request->all(), [
                'psv_badge_no' => 'nullable|string',
                'psv_badge_date_of_issue' => 'nullable|date',
                'psv_badge_date_of_expiry' => 'nullable|date|after_or_equal:psv_badge_date_of_issue',
                'badge_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Find the existing PSV badge
            $psvBadge = $driver->psvBadge;

            if (!$psvBadge) {
                return redirect()->back()->with('error', 'PSV badge not found')->withInput();
            }

            // Begin transaction
            DB::beginTransaction();

            // Update the PSV badge fields
            $psvBadge->update([
                'psv_badge_no' => $request->input('psv_badge_no'),
                'psv_badge_date_of_issue' => $request->input('psv_badge_date_of_issue'),
                'psv_badge_date_of_expiry' => $request->input('psv_badge_date_of_expiry'),
            ]);

            // Handle file upload for the badge copy
            if ($request->hasFile('badge_copy')) {
                // Store the new badge copy in the specified directory
                $badgeCopyFile = $request->file('badge_copy');
                $badgeCopyFileName = "psv_badge_{$driverId}." . $badgeCopyFile->getClientOriginalExtension();
                $badgeCopyPath = $badgeCopyFile->move('/home/kknuicdz/public_html_metroberry_app/psvbadge-avatars', $badgeCopyFileName);

                // Update the avatar path in the database
                $psvBadge->update(['psv_badge_avatar' => $badgeCopyPath]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('driver.registration.page')->with('success', 'PSV badge updated successfully');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('PSV Badge Update Error', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while updating the PSV badge')->withInput();
        }
    }

    public function updateVehicleDetails(Request $request, $driverVehicleDetails)
    {
        $user = Auth::user();
        $driver = $user->driver;

        // Validate the request data
        $validated = $request->validate([
            'speed_govenor_front_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'speed_govenor_back_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organisation_id' => 'required|exists:organisations,id',
            'vehicle_class_id' => 'required|exists:vehicle_classes,id',
            'car_registration_num' => 'required|string|max:255',
            'car_fuel_type' => 'nullable|string|max:255',
            'date_of_manufacture' => 'nullable|date',
            'manufacture_make' => 'nullable|string|max:255',
            'car_engine_size' => 'nullable|string|max:255',
        ]);

        $vehicle = $driver->vehicle;

        if (!$vehicle) {
            return redirect()->back()->with('error', 'Vehicle not found! Contact Admin for registration instructions.');
        }

        // Define the base storage path
        $basePath = '/home/kknuicdz/public_html_metroberry_app/';

        // Handle file upload for the vehicle avatar
        if ($request->hasFile('vehicle_avatar')) {
            $vehicleAvatarFile = $request->file('vehicle_avatar');
            $vehicleAvatarFileName = "vehicle_{$vehicle->id}." . $vehicleAvatarFile->getClientOriginalExtension();
            $vehicleAvatarPath = $vehicleAvatarFile->move($basePath . 'vehicle-avatars', $vehicleAvatarFileName);

            $vehicle->update(['avatar' => $vehicleAvatarPath]);
        }

        // Handle file upload for the vehicle certificate (front)
        if ($request->hasFile('license_front_avatar')) {
            $certificateFrontFile = $request->file('license_front_avatar');
            $certificateFrontFileName = "vehicle_certificate_front_{$vehicle->id}." . $certificateFrontFile->getClientOriginalExtension();
            $certificateFrontPath = $certificateFrontFile->move($basePath . 'vehicle-certificates', $certificateFrontFileName);

            $vehicle->update(['license_front_avatar' => $certificateFrontPath]);
        }

        // Handle file upload for the vehicle certificate (back)
        if ($request->hasFile('license_back_avatar')) {
            $certificateBackFile = $request->file('license_back_avatar');
            $certificateBackFileName = "vehicle_certificate_back_{$vehicle->id}." . $certificateBackFile->getClientOriginalExtension();
            $certificateBackPath = $certificateBackFile->move($basePath . 'vehicle-certificates', $certificateBackFileName);

            $vehicle->update(['license_back_avatar' => $certificateBackPath]);
        }

        // Update the other vehicle details in the database
        $vehicle->update([
            'organisation_id' => $request->organisation_id,
            'vehicle_class_id' => $request->vehicle_class_id,
            'plate_number' => $request->input('car_registration_num'),
            'fuel_type' => $request->input('car_fuel_type'),
            'year' => $request->input('date_of_manufacture'),
            'make' => $request->input('manufacture_make'),
            'engine_size' => $request->input('car_engine_size'),
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'Vehicle details updated successfully.');
    }



}
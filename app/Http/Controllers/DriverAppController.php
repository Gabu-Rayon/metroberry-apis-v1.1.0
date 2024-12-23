<?php

namespace App\Http\Controllers;

use App\Models\InsuranceRecurringPeriod;
use Exception;
use App\Models\Trip;
use App\Models\User;
use App\Rules\Phone;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\FuelType;
use App\Models\PSVBadge;
use App\Models\Organisation;
use App\Models\VehicleClass;
use Illuminate\Http\Request;
use App\Models\DriversLicenses;
use App\Models\InsuranceCompany;
use App\Models\VehicleInsurance;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleManufacturer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\NTSAInspectionCertificate;
use Illuminate\Support\Facades\Validator;
use App\Models\VehicleSpeedGovernorCertificate;

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
            $frontIdDirectory = 'home/kknuicdz/public_html_metroberry_app/front-page-ids';
            $backIdDirectory = 'home/kknuicdz/public_html_metroberry_app/back-page-ids';

            if (app()->environment('local')) {
                $frontIdDirectory = public_path('uploads/front-page-ids');
                $backIdDirectory = public_path('uploads/back-page-ids');
            } else {
                $frontIdDirectory = 'home/kknuicdz/public_html_metroberry_app/front-page-ids';
                $backIdDirectory = 'home/kknuicdz/public_html_metroberry_app/back-page-ids';
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

            $validator = Validator::make($data, [
                'national_id_no' => 'nullable|digits:8', // Exactly 8 numeric digits
                'national_id_front_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'national_id_back_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->with('error', $validator->errors()->first())->withInput();
            }

            $driver = Driver::findOrFail($id);

            $frontIdDirectory = app()->environment('local')
                ? public_path('uploads/front-page-ids')
                : 'home/kknuicdz/public_html_metroberry_app/front-page-ids';

            $backIdDirectory = app()->environment('local')
                ? public_path('uploads/back-page-ids')
                : 'home/kknuicdz/public_html_metroberry_app/back-page-ids';

            foreach ([$frontIdDirectory, $backIdDirectory] as $directory) {
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }
            }

            if ($request->hasFile('national_id_front_avatar')) {
                $frontAvatar = $request->file('national_id_front_avatar');
                $frontFileName = "{$driver->email}-national-id-front." . $frontAvatar->getClientOriginalExtension();
                $frontAvatar->move($frontIdDirectory, $frontFileName);
                $driver->national_id_front_avatar = 'uploads/front-page-ids/' . $frontFileName;
            }

            if ($request->hasFile('national_id_back_avatar')) {
                $backAvatar = $request->file('national_id_back_avatar');
                $backFileName = "{$driver->email}-national-id-back." . $backAvatar->getClientOriginalExtension();
                $backAvatar->move($backIdDirectory, $backFileName);
                $driver->national_id_back_avatar = 'uploads/back-page-ids/' . $backFileName;
            }

            $driver->national_id_no = $request->input('national_id_no');
            $driver->save();

            return redirect()->route('driver.registration.page')->with('success', 'Driver personal documents uploaded successfully.');
        } catch (\Exception $e) {
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
            Log::info('Driver License Data From the Form in the Driver App Dashboard : ' . json_encode($data));

            // Validate the incoming request data
            $validator = Validator::make($data, [
                'driving_license_no' => 'required|string|max:255|unique:drivers_licenses',
                'first_date_of_issue' => 'required|date|before:' . now()->subYears(5)->toDateString(),
                'driving_license_renewal_date_issue' => 'required|date',
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
            $frontLicenseDirectory = 'home/kknuicdz/public_html_metroberry_app/front-license-pics';
            $backLicenseDirectory = 'home/kknuicdz/public_html_metroberry_app/back-license-pics';

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
                'driving_license_renewal_date_issue' => $data['driving_license_renewal_date_issue'],
                'driving_license_date_of_expiry' => $data['expiry_date'],
                'driving_license_avatar_front' => 'uploads/front-license-pics/' . $frontFileName,
                'driving_license_avatar_back' => 'uploads/back-license-pics/' . $backFileName,
                'first_date_of_issue' => $data['first_date_of_issue'],
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
                'first_date_of_issue' => 'required|date|before:' . now()->subYears(5)->toDateString(),
                'driving_license_renewal_date_issue' => 'required|date',
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
            $frontLicenseDirectory = 'home/kknuicdz/public_html_metroberry_app/front-license-pics';
            $backLicenseDirectory = 'home/kknuicdz/public_html_metroberry_app/back-license-pics';

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
            $license->driving_license_renewal_date_issue = $data['driving_license_renewal_date_issue'] ?? $license->driving_license_renewal_date_issue;
            $license->driving_license_date_of_expiry = $data['driving_license_date_of_expiry'] ?? $license->driving_license_date_of_expiry;
            $license->first_date_of_issue = $data['first_date_of_issue'] ?? $license->first_date_of_issue;

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
            $psvBadgeDirectory = '/home/kknuicdz/public_html_metroberry_app/psvbadge-avatars';

            // Ensure the directory exists
            if (!is_dir($psvBadgeDirectory)) {
                mkdir($psvBadgeDirectory, 0755, true); // Create directory if it doesn't exist
            }

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
                'badge_copy' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
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
                $psvBadgeDirectory = '/home/kknuicdz/public_html_metroberry_app/psvbadge-avatars';

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
                $oldProfilePath = 'home/kknuicdz/public_html_metroberry_app/' . $driver->user->avatar;
                if (file_exists($oldProfilePath)) {
                    unlink($oldProfilePath); // Delete the old profile picture
                }
            }

            // Set the base path for uploading user avatar
            $baseUploadUserAvatarPath = 'home/kknuicdz/public_html_metroberry_app/uploads/user-avatars/';
            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Use a unique name for the file

            // Ensure the directory exists
            $fullDirectoryPath = $baseUploadUserAvatarPath . $user->id . '/';
            if (!is_dir($fullDirectoryPath)) {
                mkdir($fullDirectoryPath, 0755, true); // Create directory if it doesn't exist
            }

            // Move the file to the specified directory
            $file->move($fullDirectoryPath, $fileName);

            // Update the user's profile picture path (store the relative path)
            $driver->user->avatar = 'uploads/user-avatars/' . $user->id . '/' . $fileName; // Save the relative path
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

            // Define the base path for uploading the PSV badge avatar
            $baseUploadPSVBadgeAvatarPath = 'home/kknuicdz/public_html_metroberry_app/uploads/psvbadge-avatars/';

            // Handle file upload for the badge copy
            if ($request->hasFile('badge_copy')) {
                // Get the uploaded file
                $badgeCopyFile = $request->file('badge_copy');
                $badgeCopyFileName = "psv_badge_{$driverId}." . $badgeCopyFile->getClientOriginalExtension();

                // Move the file to the defined directory
                $badgeCopyPath = $baseUploadPSVBadgeAvatarPath . $badgeCopyFileName;
                $badgeCopyFile->move(public_path($baseUploadPSVBadgeAvatarPath), $badgeCopyFileName);

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



    //Methods for the Vehicle Registration 


    public function driverVehicleDocsRegsitration()
    {

        return view('driver-app.driver-vehicle-registration');

    }



    /****
     * 
     * Driver Vehicle Registration  
     * 
     * Use the Same Form to POST  & PUT
     * 
     */




    public function vehicleRegistration()
    {
        // Get the authenticated user
        $user = Auth::user();
        $organisations = Organisation::all();
        $vehicleClasses = VehicleClass::all();
        $VehicleManufacturers = VehicleManufacturer::all();
        $vehicleFuelTypes = FuelType::all();

        // Check if the user is a driver
        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        // Fetch the driver data based on the user_id in the drivers table
        $driver = Driver::where('user_id', $user->id)->firstOrFail();


        return view('driver-app.vehicle-registration', compact('organisations', 'vehicleClasses', 'VehicleManufacturers', 'driver', 'vehicleFuelTypes'));

    }



    // Store a new vehicle
    public function vehicleRegistrationStore(Request $request)
    {
        $data = $request->all();

        Log::info('Data From the Form to Create A new Vehicle: ');
        Log::info($data);

        $validator = Validator::make($data, [
            'driver_vehicle_model' => 'required|string|max:255',
            'driver_vehicle_plate_number' => 'required|string|max:255',
            'driver_vehicle_seats_no' => 'required|integer',
            'driver_vehicle_avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,jfif|max:2048',
            'driver_vehicle_organisation' => 'required|exists:organisations,id',
            'driver_vehicle_class' => 'required|exists:vehicle_classes,id',
            'driver_vehicle_fuel_type' => 'required|exists:fuel_types,id',
            'driver_vehicle_date_of_manufacture' => 'required|digits:4',
            'driver_vehicle_manufacturer' => 'required|exists:vehicle_manufacturers,id',
            'driver_vehicle_engine_size' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('VALIDATION ERROR: ');
            Log::error($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $avatarPath = null;
        $authUser = Auth::user();

        // Retrieve driver's name
        $driverName = $authUser->name;
        $driverPlateNumber = $data['driver_vehicle_plate_number'];

        // Define the upload path
        $baseUploadVehicleAvatarPath = 'home/kknuicdz/public_html_metroberry_app/uploads/vehicle-avatars/';

        // Handle avatar upload
        if ($request->hasFile('driver_vehicle_avatar')) {
            $avatarFile = $request->file('driver_vehicle_avatar');
            $avatarExtension = $avatarFile->getClientOriginalExtension();
            $avatarFileName = "{$driverName}-{$driverPlateNumber}-avatar.{$avatarExtension}";

            // Set the file path where the avatar will be uploaded
            $avatarPath = 'uploads/vehicle-avatars/' . $avatarFileName;

            // Move the file to the desired location
            $avatarFile->move($baseUploadVehicleAvatarPath, $avatarFileName);
        }

        Log::info('The  vehicle avatar path  to be uploaded : ');
        Log::info($avatarPath);

        $fuelTypeId = $data['driver_vehicle_fuel_type'];

        // Retrieve fuel type name (assuming there's a "name" column in "fuel_types" table)
        $fuelType = Fueltype::find($fuelTypeId);
        $fuelTypeName = $fuelType ? $fuelType->name : 'Unknown';

        Log::info('the Fuel Type Name :');
        Log::info($fuelTypeName);

        // Retrieve driver_id from drivers table using the user_id
        $driver = Driver::where('user_id', $authUser->id)->first();
        if (!$driver) {
            Log::error('Driver not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver not found.')->withInput();
        }

        // Create a new vehicle record
        $vehicle = Vehicle::create([
            'created_by' => $authUser->id,
            'driver_id' => $driver->id,
            'organisation_id' => $data['driver_vehicle_organisation'],
            'model' => $data['driver_vehicle_model'],
            'manufacturer_id' => $data['driver_vehicle_manufacturer'],
            'fuel_type_id' => $data['driver_vehicle_fuel_type'],
            'year' => $data['driver_vehicle_date_of_manufacture'],
            'plate_number' => $data['driver_vehicle_plate_number'],
            'color' => $data['driver_vehicle_color'] ?? 'Unknown',
            'seats' => $data['driver_vehicle_seats_no'],
            'class' => $data['driver_vehicle_class'],
            'engine_size' => $data['driver_vehicle_engine_size'],
            'avatar' => $avatarPath,
            'fuel_type' => $fuelTypeName,
            'ride_type_id' => null,
            'status' => $data['status'] ?? 'inactive',
        ]);

        return redirect()->route('driver.vehicle.docs.registration')->with('success', 'Vehicle Added successfully');
    }


    // Update an existing vehicle
    public function vehicleRegistrationUpdate(Request $request, $vehicle)
    {
        $data = $request->all();

        Log::info('Data From the Form to Update Vehicle: ', $data);

        // Validate the incoming request data
        $validator = Validator::make($data, [
            'driver_vehicle_model' => 'required|string|max:255',
            'driver_vehicle_plate_number' => 'required|string|max:255',
            'driver_vehicle_seats_no' => 'required|integer',
            'driver_vehicle_avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,jfif|max:2048',
            'driver_vehicle_organisation' => 'required|exists:organisations,id',
            'driver_vehicle_class' => 'required|exists:vehicle_classes,id',
            'driver_vehicle_fuel_type' => 'required|exists:fuel_types,id',
            'driver_vehicle_date_of_manufacture' => 'required|digits:4',
            'driver_vehicle_manufacturer' => 'required|exists:vehicle_manufacturers,id',
            'driver_vehicle_engine_size' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('VALIDATION ERROR: ', $validator->errors()->toArray());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Retrieve the vehicle to be updated
        $vehicle = Vehicle::findOrFail($vehicle);

        $avatarPath = $vehicle->avatar;
        $authUser = Auth::user();

        // Retrieve the authenticated user's name and vehicle plate number from the request data
        $driverName = $authUser->name;
        $driverPlateNumber = $data['driver_vehicle_plate_number'];

        // Define the base path for avatar upload
        $baseUploadVehicleAvatarPath = 'home/kknuicdz/public_html_metroberry_app/uploads/vehicle-avatars/';

        // Handle avatar upload
        if ($request->hasFile('driver_vehicle_avatar')) {
            // Delete the old avatar if it exists
            if ($avatarPath && file_exists($baseUploadVehicleAvatarPath . $avatarPath)) {
                unlink($baseUploadVehicleAvatarPath . $avatarPath);
            }

            // Upload the new avatar
            $avatarFile = $request->file('driver_vehicle_avatar');
            $avatarExtension = $avatarFile->getClientOriginalExtension();
            $avatarFileName = "{$driverName}-{$driverPlateNumber}-avatar.{$avatarExtension}";
            $avatarPath = 'uploads/vehicle-avatars/' . $avatarFileName;
            $avatarFile->move($baseUploadVehicleAvatarPath, $avatarFileName);
        }

        Log::info('The vehicle avatar path to be uploaded: ', [$avatarPath]);

        // Retrieve the fuel type name based on the provided fuel type ID
        $fuelTypeId = $data['driver_vehicle_fuel_type'];
        $fuelType = Fueltype::find($fuelTypeId);
        $fuelTypeName = $fuelType ? $fuelType->name : 'Unknown';

        Log::info('The Fuel Type Name: ', [$fuelTypeName]);

        // Retrieve the driver based on the authenticated user ID
        $driver = Driver::where('user_id', $authUser->id)->first();
        if (!$driver) {
            Log::error('Driver not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver not found.')->withInput();
        }

        // Update the vehicle record
        $vehicle->update([
            'created_by' => $authUser->id,
            'driver_id' => $driver->id,
            'organisation_id' => $data['driver_vehicle_organisation'],
            'model' => $data['driver_vehicle_model'],
            'manufacturer_id' => $data['driver_vehicle_manufacturer'],
            'fuel_type_id' => $data['driver_vehicle_fuel_type'],
            'make' => $data['driver_vehicle_model'],
            'year' => $data['driver_vehicle_date_of_manufacture'],
            'plate_number' => $data['driver_vehicle_plate_number'],
            'color' => $data['driver_vehicle_color'] ?? 'Unknown',
            'seats' => $data['driver_vehicle_seats_no'],
            'class' => $data['driver_vehicle_class'],
            'engine_size' => $data['driver_vehicle_engine_size'],
            'avatar' => $avatarPath,
            'fuel_type' => $fuelTypeName,
            'ride_type_id' => null,
            'status' => $data['status'] ?? 'inactive',
        ]);

        return redirect()->route('driver.vehicle.docs.registration')->with('success', 'Vehicle updated successfully');
    }


    /**
     * 
     * Vehicle Insurance Registration
     * 
     * 
     */

    public function vehicleInsuranceDocument()
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        $driver = Driver::where('user_id', $user->id)->firstOrFail();

        if (!$driver->vehicle) {
            return redirect()->back()->with('error', 'Please Register Vehicle to continue to Vehicle Insurance Registration.');
        }

        $vehicle = $driver->vehicle;

        $vehicleInsurance = VehicleInsurance::where('vehicle_id', $vehicle->id)->get();
        $vehiclesInsuranceCompanies = InsuranceCompany::where('status', 1)->orWhere('status', true)->get();
        $vehicleInsuranceRecurringPeriod = InsuranceRecurringPeriod::all();

        return view('driver-app.vehicle-insurance-registration', compact('driver', 'vehicleInsurance', 'vehiclesInsuranceCompanies', 'vehicleInsuranceRecurringPeriod', 'vehicle'));

    }

    public function vehicleInsuranceStore(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'driver_vehicle_id' => 'required|exists:vehicles,id',
            'driver_vehicle_insurance_company_id' => 'required|exists:insurance_companies,id',
            'driver_insurance_policy_no' => 'required|string|max:255',
            'driver_insurance_date_of_issue' => 'required|date',
            'driver_insurance_date_of_expiry' => 'required|date|after_or_equal:driver_insurance_date_of_issue',
            'driver_vehicle_insurance_recurring_period' => 'required|exists:insurance_recurring_periods,id',
            'driver_insurance_recurring_date' => 'required|date',
            'driver_insurance_reminder' => 'nullable|string',
            'driver_insurance_deductible' => 'nullable|integer',
            'driver_insurance_charges_payable' => 'nullable|integer',
            'driver_insurance_remark' => 'nullable|string',
            'driver_insurance_policy_document' => 'nullable|file|mimes:pdf,jpg,png,jpeg,webp,jfif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('VALIDATION ERROR: ', $validator->errors()->toArray());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Retrieve the authenticated user and their driver record
        $authUser = Auth::user();
        $driver = Driver::where('user_id', $authUser->id)->first();

        if (!$driver) {
            Log::error('Driver not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver not found.')->withInput();
        }

        // Define the path for storing the insurance policy document
        $driverVehicleInsurancePolicyDocPath = null;

        // Set the base upload path
        $baseUploadVehicleInsuranceDocPath = 'home/kknuicdz/public_html_metroberry_app/uploads/vehicle_insurance_policy_document/';

        if ($request->hasFile('driver_insurance_policy_document')) {
            $file = $request->file('driver_insurance_policy_document');
            $fileName = "{$authUser->name}-{$authUser->email}-{$request->driver_insurance_policy_no}.{$file->getClientOriginalExtension()}";
            $driverVehicleInsurancePolicyDocPath = 'uploads/vehicle_insurance_policy_document/' . $fileName;

            // Create the destination path inside the public directory
            $destinationPath = $baseUploadVehicleInsuranceDocPath;

            // Ensure the destination path exists, if not, create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded file to the desired location
            $file->move($destinationPath, $fileName);
        }

        Log::info('The Driver vehicle Insurance Policy Document path to be uploaded: ', [$driverVehicleInsurancePolicyDocPath]);

        // Store the vehicle insurance data
        VehicleInsurance::create([
            'vehicle_id' => $request->driver_vehicle_id,
            'insurance_company_id' => $request->driver_vehicle_insurance_company_id,
            'insurance_policy_no' => $request->driver_insurance_policy_no,
            'insurance_date_of_issue' => $request->driver_insurance_date_of_issue,
            'insurance_date_of_expiry' => $request->driver_insurance_date_of_expiry,
            'charges_payable' => $request->driver_insurance_charges_payable,
            'recurring_period_id' => $request->driver_vehicle_insurance_recurring_period,
            'recurring_date' => $request->driver_insurance_recurring_date,
            'reminder' => $request->driver_insurance_reminder,
            'deductible' => $request->driver_insurance_deductible,
            'status' => false,
            'remark' => $request->driver_insurance_remark,
            'policy_document' => $driverVehicleInsurancePolicyDocPath,
            'created_by' => $authUser->id,
        ]);

        return redirect()->route('driver.vehicle.docs.registration')->with('success', 'Vehicle insurance added successfully.');
    }


    public function vehicleInsuranceUpdate(Request $request, $insuranceId)
    {
        $data = $request->all();

        Log::info('Data From the Form to Update Vehicle Insurance : ', $data);

        $validator = Validator::make($data, [
            'driver_vehicle_id' => 'required',
            'driver_vehicle_insurance_company_id' => 'required',
            'driver_insurance_policy_no' => 'required|string|max:255',
            'driver_insurance_date_of_issue' => 'required|date',
            'driver_insurance_date_of_expiry' => 'required|date',
            'driver_vehicle_insurance_recurring_period' => 'required|integer',
            'driver_insurance_recurring_date' => 'required|date',
            'driver_insurance_reminder' => 'nullable|string',
            'driver_insurance_deductible' => 'nullable|integer',
            'driver_insurance_charges_payable' => 'nullable|integer',
            'driver_insurance_remark' => 'nullable|string',
            'driver_insurance_policy_document' => 'nullable|file|mimes:pdf,jpg,png,jpeg,webp,jfif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('VALIDATION ERROR: ', $validator->errors()->toArray());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $authUser = Auth::user();
        $driver = Driver::where('user_id', $authUser->id)->first();

        if (!$driver) {
            Log::error('Driver not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver not found.')->withInput();
        }

        $driverVehicle = Vehicle::where('driver_id', $driver->id)->first();

        if (!$driverVehicle) {
            Log::error('Driver Vehicle not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver Vehicle not found.')->withInput();
        }

        $driverVehicleInsurance = VehicleInsurance::findOrFail($insuranceId);
        $driverVehicleInsurancePolicyDocPath = $driverVehicleInsurance->policy_document;

        if ($request->hasFile('driver_insurance_policy_document')) {
            // Delete the old document if it exists
            if ($driverVehicleInsurancePolicyDocPath && file_exists('home/kknuicdz/public_html_metroberry_app/' . $driverVehicleInsurancePolicyDocPath)) {
                unlink('home/kknuicdz/public_html_metroberry_app/' . $driverVehicleInsurancePolicyDocPath);
            }

            // Upload the new document
            $file = $request->file('driver_insurance_policy_document');
            $fileName = "{$authUser->name}-{$authUser->email}-{$request->driver_insurance_policy_no}.{$file->getClientOriginalExtension()}";
            $driverVehicleInsurancePolicyDocPath = 'uploads/vehicle_insurance_policy_document/' . $fileName;

            $destinationPath = 'home/kknuicdz/public_html_metroberry_app/' . dirname($driverVehicleInsurancePolicyDocPath);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $fileName);
        }

        Log::info('The Driver vehicle Insurance Policy Document path to be uploaded: ', [$driverVehicleInsurancePolicyDocPath]);

        $driverVehicleInsurance->update([
            'vehicle_id' => $data['driver_vehicle_id'],
            'insurance_company_id' => $data['driver_vehicle_insurance_company_id'],
            'insurance_policy_no' => $data['driver_insurance_policy_no'],
            'insurance_date_of_issue' => $data['driver_insurance_date_of_issue'],
            'insurance_date_of_expiry' => $data['driver_insurance_date_of_expiry'],
            'charges_payable' => $data['driver_insurance_charges_payable'],
            'recurring_period_id' => $data['driver_vehicle_insurance_recurring_period'],
            'recurring_date' => $data['driver_insurance_recurring_date'],
            'reminder' => $data['driver_insurance_reminder'],
            'deductible' => $data['driver_insurance_deductible'],
            'status' => false,
            'remark' => $data['driver_insurance_remark'],
            'policy_document' => $driverVehicleInsurancePolicyDocPath,
            'created_by' => $authUser->id,
        ]);

        return redirect()->route('driver.vehicle.docs.registration')->with('success', 'Vehicle insurance updated successfully.');
    }





    /**
     * NTSA Vehicle Registration
     */

    public function ntsaInspectionCertificateDocument()
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        $driver = Driver::where('user_id', $user->id)->firstOrFail();

        if (!$driver->vehicle) {
            return redirect()->back()->with('error', 'Please Register Vehicle to continue to NTSA Inspection Certificate Registration..');
        }

        $vehicle = $driver->vehicle;

        $inspectionCertificate = NTSAInspectionCertificate::where('vehicle_id', $vehicle->id)->get();

        return view('driver-app.ntsa-inspection-registration', compact('driver', 'inspectionCertificate', 'vehicle'));
    }



    public function ntsaInspectionCertificateStore(Request $request)
    {
        Log::info('Data for Add new Driver NTSA Inspection Certificate: ');
        Log::info($request->all());

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'driver_ntsa_inspection_certificate_no' => 'required|string|max:255',
            'driver_ntsa_inspection_certificate_date_of_issue' => 'required|date',
            'driver_ntsa_inspection_certificate_date_of_expiry' => 'required|date|after_or_equal:driver_ntsa_inspection_certificate_date_of_issue',
            'driver_ntsa_certificate_copy' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'driver_vehicle_id' => 'required|exists:vehicles,id',
            'cost' => 'required|numeric',
        ]);

        try {
            if ($validator->fails()) {
                Log::error('VALIDATION ERROR: ', $validator->errors()->toArray());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Retrieve the authenticated user and their driver record
            $authUser = Auth::user();
            $driver = Driver::where('user_id', $authUser->id)->first();
            $ntsaCertificateNo = $request->input('driver_ntsa_inspection_certificate_no');

            if (!$driver) {
                Log::error('Driver not found for the authenticated user.');
                return redirect()->back()->with('error', 'Driver not found.')->withInput();
            }

            // Define the path for storing the insurance policy document
            $driverNTSAInspectionCertDocPath = 'home/kknuicdz/public_html_metroberry_app/uploads/ntsa-insp-cert-copies/';

            if ($request->hasFile('driver_ntsa_certificate_copy')) {
                $file = $request->file('driver_ntsa_certificate_copy');
                $fileName = "{$authUser->name}-{$authUser->email}-{$ntsaCertificateNo}.{$file->getClientOriginalExtension()}";

                // Full path for the file to be saved
                $destinationPath = $driverNTSAInspectionCertDocPath . $fileName;

                // Ensure the directory exists
                if (!file_exists($driverNTSAInspectionCertDocPath)) {
                    mkdir($driverNTSAInspectionCertDocPath, 0777, true);
                }

                // Move the file to the destination path
                $file->move($driverNTSAInspectionCertDocPath, $fileName);
            }

            Log::info('The Driver NTSA Inspection Certificate Document path to be uploaded: ', [$driverNTSAInspectionCertDocPath]);

            // Store the inspection certificate in the database
            $inspectionCertificate = new NTSAInspectionCertificate([
                'vehicle_id' => $request->input('driver_vehicle_id'),
                'creator_id' => auth()->id(),
                'ntsa_inspection_certificate_no' => $request->input('driver_ntsa_inspection_certificate_no'),
                'ntsa_inspection_certificate_date_of_issue' => $request->input('driver_ntsa_inspection_certificate_date_of_issue'),
                'ntsa_inspection_certificate_date_of_expiry' => $request->input('driver_ntsa_inspection_certificate_date_of_expiry'),
                'ntsa_inspection_certificate_avatar' => 'uploads/ntsa-insp-cert-copies/' . $fileName, // Storing relative path
                'cost' => $request->input('cost'),
                'verified' => false,
            ]);

            // Save the inspection certificate
            $inspectionCertificate->save();

            // Return success response or redirect
            return redirect()->route('driver.vehicle.docs.registration')->with('success', 'NTSA Inspection Certificate added successfully!');
        } catch (\Exception $e) {
            Log::error('Error while adding NTSA Inspection Certificate: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was an error while adding the NTSA Inspection Certificate. Please try again.']);
        }
    }

    public function ntsaInspectionCertificateUpdate(Request $request, $id)
    {
        Log::info('Data For Updating new NTSA Inspection Cert : ');
        Log::info($request->all());

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'driver_ntsa_inspection_certificate_no' => 'required|string|max:255',
            'driver_ntsa_inspection_certificate_date_of_issue' => 'required|date',
            'driver_ntsa_inspection_certificate_date_of_expiry' => 'required|date|after_or_equal:driver_ntsa_inspection_certificate_date_of_issue',
            'driver_ntsa_certificate_copy' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'driver_vehicle_id' => 'required|exists:vehicles,id',
            'cost' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Log::error('VALIDATION ERROR: ', $validator->errors()->toArray());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Find the existing inspection certificate
        $inspectionCertificate = NTSAInspectionCertificate::findOrFail($id);

        // Retrieve the authenticated user and their driver record
        $authUser = Auth::user();
        $driver = Driver::where('user_id', $authUser->id)->first();

        if (!$driver) {
            Log::error('Driver not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver not found.')->withInput();
        }

        // Set the base path for the file uploads
        $baseUploadPath = 'home/kknuicdz/public_html_metroberry_app/uploads/ntsa-insp-cert-copies/';

        // Retrieve the NTSA certificate number
        $ntsaCertificateNo = $request->input('driver_ntsa_inspection_certificate_no');

        // Use the existing certificate avatar if no new file is uploaded
        $driverNTSAInspectionCertDocPath = $inspectionCertificate->ntsa_inspection_certificate_avatar;

        // Handle the file upload if a new file is provided
        if ($request->hasFile('driver_ntsa_certificate_copy')) {
            // Unlink the old file if it exists
            if ($driverNTSAInspectionCertDocPath && file_exists($baseUploadPath . $driverNTSAInspectionCertDocPath)) {
                unlink($baseUploadPath . $driverNTSAInspectionCertDocPath);
            }

            // Handle the new uploaded file
            $file = $request->file('driver_ntsa_certificate_copy');
            $fileName = "{$authUser->name}-{$authUser->email}-{$ntsaCertificateNo}.{$file->getClientOriginalExtension()}";

            // Set the new file path
            $driverNTSAInspectionCertDocPath = 'uploads/ntsa-insp-cert-copies/' . $fileName;

            // Ensure the directory exists
            $destinationPath = $baseUploadPath . dirname($driverNTSAInspectionCertDocPath);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded file to the destination directory
            $file->move($destinationPath, $fileName);
        }

        Log::info('The Driver NTSA Inspection Certificate Document path to be uploaded: ', [$driverNTSAInspectionCertDocPath]);

        // Update the certificate data
        $inspectionCertificate->update([
            'vehicle_id' => $request->input('driver_vehicle_id'),
            'creator_id' => auth()->id(),
            'ntsa_inspection_certificate_no' => $request->input('driver_ntsa_inspection_certificate_no'),
            'ntsa_inspection_certificate_date_of_issue' => $request->input('driver_ntsa_inspection_certificate_date_of_issue'),
            'ntsa_inspection_certificate_date_of_expiry' => $request->input('driver_ntsa_inspection_certificate_date_of_expiry'),
            'ntsa_inspection_certificate_avatar' => $driverNTSAInspectionCertDocPath,
            'cost' => $request->input('cost'),
            'verified' => false,
        ]);

        // Return success response or redirect
        return redirect()->route('driver.vehicle.docs.registration')->with('success', 'NTSA Inspection Certificate updated successfully!');
    }


    /***
     * 
     * 
     * Speed Limit Certificate
     * 
     * 
     */

    public function speedGovernorRegistration()
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user->role !== 'driver') {
            return redirect()->back()->with('error', 'Access Denied. Only Drivers can access this page.');
        }

        $driver = Driver::where('user_id', $user->id)->firstOrFail();

        if (!$driver->vehicle) {
            return redirect()->back()->with('error', 'Please Register Vehicle to continue to Speed Governor Registration.');
        }

        $vehicle = $driver->vehicle;

        $speedGovernorCertificate = VehicleSpeedGovernorCertificate::where('vehicle_id', $vehicle->id)->get();

        // Pass the data to the view
        return view('driver-app.speed-governor-registration', compact('driver', 'vehicle', 'speedGovernorCertificate'));
    }

    public function speedGovernorRegistrationStore(Request $request)
    {
        $data = $request->all();

        Log::info('Data From the Form to Store Vehicle Speed Governor : ', $data);

        // Validate the incoming request
        $validator = Validator::make($data, [
            'driver_speed_governor_certificate_no' => 'required|string|max:255',
            'driver_speed_governor_certificate_copy' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'driver_speed_governor_class_no' => 'required|string|max:255',
            'driver_speed_governor_date_of_installation' => 'required|date',
            'driver_speed_governor_expiry_date' => 'required|date|after:driver_speed_governor_date_of_installation',
            'driver_speed_governor_type' => 'required|string|max:255',
            'driver_speed_governor_vehicle_id' => 'required|exists:vehicles,id',
            'driver_vehicle_chasis_no' => 'required|string|Max:255'
        ]);

        if ($validator->fails()) {
            Log::error('VALIDATION ERROR: ', $validator->errors()->toArray());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Get the authenticated user and the associated driver
        $authUser = Auth::user();
        $driver = Driver::where('user_id', $authUser->id)->first();

        if (!$driver) {
            Log::error('Driver not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver not found.')->withInput();
        }

        $driverVehicle = Vehicle::where('driver_id', $driver->id)->first();

        if (!$driverVehicle) {
            Log::error('Driver Vehicle not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver Vehicle not found.')->withInput();
        }

        // Define the document path
        $driverVehicleSpeedGovernorDocPath = 'home/kknuicdz/public_html_metroberry_app/uploads/speed-governor-cert-copies/';

        if ($request->hasFile('driver_speed_governor_certificate_copy')) {
            $file = $request->file('driver_speed_governor_certificate_copy');
            $fileName = "{$authUser->name}-{$driverVehicle->model}-{$driverVehicle->plate_number}-{$data['driver_speed_governor_certificate_no']}.{$file->getClientOriginalExtension()}";

            // Ensure the destination directory exists
            $destinationPath = $driverVehicleSpeedGovernorDocPath;  // No need for public_path here as you're using an absolute path

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the file to the specified path
            $file->move($destinationPath, $fileName);

            // Update the document path for saving in the database
            $driverVehicleSpeedGovernorDocPath = 'uploads/speed-governor-cert-copies/' . $fileName;
        }

        Log::info('The Driver vehicle Speed Governor Certificate Document path to be uploaded: ', [$driverVehicleSpeedGovernorDocPath]);

        // Create a new SpeedGovernorCertificate
        $speedGovernorCertificate = new VehicleSpeedGovernorCertificate([
            'certificate_no' => $request->driver_speed_governor_certificate_no,
            'certificate_copy' => $driverVehicleSpeedGovernorDocPath,
            'class_no' => $request->driver_speed_governor_class_no,
            'date_of_installation' => $request->driver_speed_governor_date_of_installation,
            'expiry_date' => $request->driver_speed_governor_expiry_date,
            'type_of_governor' => $request->driver_speed_governor_type,
            'chasis_no' => $request->driver_vehicle_chasis_no,
            'driver_id' => $driver->id,
            'vehicle_id' => $request->driver_speed_governor_vehicle_id,
            'status' => 'inactive',
        ]);

        // Save the Speed Governor Certificate
        $speedGovernorCertificate->save();

        // Redirect with success message
        return redirect()->route('driver.vehicle.docs.registration')
            ->with('success', 'Speed Governor Certificate successfully Added.');
    }

    public function speedGovernorRegistrationUpdate(Request $request, $certificateId)
    {
        Log::info('Data From Update the Speed Governor Form: ', $request->all());

        $data = $request->all();

        // Validate the incoming request
        $validator = Validator::make($data, [
            'driver_speed_governor_certificate_no' => 'required|string|max:255',
            'driver_speed_governor_certificate_copy' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'driver_speed_governor_class_no' => 'required|string|max:255',
            'driver_speed_governor_date_of_installation' => 'required|date',
            'driver_speed_governor_expiry_date' => 'required|date|after:driver_speed_governor_date_of_installation',
            'driver_speed_governor_type' => 'required|string|max:255',
            'driver_speed_governor_vehicle_id' => 'required|exists:vehicles,id',
            'driver_vehicle_chasis_no' => 'required|string|Max:255'
        ]);

        if ($validator->fails()) {
            Log::error('VALIDATION ERROR: ', $validator->errors()->toArray());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Retrieve the existing speed governor certificate
        $speedGovernorCertificate = VehicleSpeedGovernorCertificate::findOrFail($certificateId);

        // Get the authenticated user and the associated driver
        $authUser = Auth::user();
        $driver = Driver::where('user_id', $authUser->id)->first();

        if (!$driver) {
            Log::error('Driver not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver not found.')->withInput();
        }

        $driverVehicle = Vehicle::where('driver_id', $driver->id)->first();

        if (!$driverVehicle) {
            Log::error('Driver Vehicle not found for the authenticated user.');
            return redirect()->back()->with('error', 'Driver Vehicle not found.')->withInput();
        }

        // Set initial document path
        $driverVehicleSpeedGovernorDocPath = $speedGovernorCertificate->certificate_copy;

        // Define the absolute path for file storage
        $uploadDirectory = 'home/kknuicdz/public_html_metroberry_app/uploads/speed-governor-cert-copies/';

        // Handle file upload if a new file is provided
        if ($request->hasFile('driver_speed_governor_certificate_copy')) {
            // Delete the old file if it exists
            $oldFilePath = $uploadDirectory . $speedGovernorCertificate->certificate_copy;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);  // Delete old file
            }

            // Process the new file
            $file = $request->file('driver_speed_governor_certificate_copy');
            $fileName = "{$authUser->name}-{$driverVehicle->model}-{$driverVehicle->plate_number}-{$data['driver_speed_governor_certificate_no']}.{$file->getClientOriginalExtension()}";

            // Set the new file path for saving
            $newFilePath = 'uploads/speed-governor-cert-copies/' . $fileName;
            $destinationPath = $uploadDirectory . dirname($newFilePath);

            // Ensure the destination directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);  // Create the directory if it doesn't exist
            }

            // Move the uploaded file to the desired path
            $file->move($destinationPath, $fileName);

            // Update the document path for database storage
            $driverVehicleSpeedGovernorDocPath = $newFilePath;
        }

        Log::info('The Driver vehicle Speed Governor Certificate Document path to be uploaded: ', [$driverVehicleSpeedGovernorDocPath]);

        // Update the SpeedGovernorCertificate with the new details
        $speedGovernorCertificate->update([
            'certificate_no' => $request->driver_speed_governor_certificate_no,
            'certificate_copy' => $driverVehicleSpeedGovernorDocPath,
            'class_no' => $request->driver_speed_governor_class_no,
            'date_of_installation' => $request->driver_speed_governor_date_of_installation,
            'expiry_date' => $request->driver_speed_governor_expiry_date,
            'type_of_governor' => $request->driver_speed_governor_type,
            'chasis_no' => $request->driver_vehicle_chasis_no,
            'driver_id' => $driver->id,
            'vehicle_id' => $request->driver_speed_governor_vehicle_id,
            'status' => 'inactive',
        ]);

        // Redirect with success message
        return redirect()->route('driver.vehicle.docs.registration')
            ->with('success', 'Speed Governor Certificate successfully updated.');
    }




}
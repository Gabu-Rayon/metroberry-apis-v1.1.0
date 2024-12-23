<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use App\Rules\Phone;
use App\Models\Routes;
use App\Models\Customer;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Models\RouteLocations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerAppController extends Controller
{
    // Customer homepage
    public function customerIndexPage()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a customer
        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Access Denied. Only customers can access this page.');
        }

        // Fetch the customer data based on the user_id in the customers table
        $customer = Customer::where('user_id', $user->id)->firstOrFail();

        // Fetch the organization that the customer belongs to
        $organization = Organisation::find($customer->organisation_id);

        // Fetch booked trips for the customer (`trips` relationship in Customer model)
        $trips = Trip::where('customer_id', $customer->id)->get();

        // Fetch the routes for the organization (assuming you have a routes table)
        $trips = Trip::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get();


        // Fetch the routes for the organization (assuming you have a routes table)
        $routes = Routes::all();

        // Fetch the route locations (route_locations table with a route_id foreign key)
        $routeLocations = RouteLocations::whereIn('route_id', $routes->pluck('id'))->get();

        // Pass the data to the view
        return view('customer-app.index', [
            'user' => $user,
            'customer' => $customer,
            'organisation' => $organization,
            'routes' => $routes,
            'routeLocations' => $routeLocations,
            'trips' => $trips, // Pass the trips to the view
        ]);
    }

    // Register page method
    public function registerPage()
    {
        // Retrieve organisations from the database
        $organisations = Organisation::all();
        return view('customer-app.register', compact('organisations'));
    }

    // Handle registration form submission
    public function registerCustomer(Request $request)
    {
        Log::info('Data from the Customer Registration : ', $request->all());

        // Trim password inputs
        $request->merge([
            'password' => trim($request->input('password')),
            'password_confirmation' => trim($request->input('password_confirmation')),
        ]);

        // Validation rules with password complexity check
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
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
            'organisation' => 'required|exists:organisations,id',
            'address' => 'required',
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        // Redirect with errors if validation fails
        if ($validator->fails()) {
            Log::error('VALIDATION ERROR');
            Log::error($validator->errors()->all());

            return back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            // Handle avatar upload if provided
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                // Concatenate email, phone, and name to form a unique file name
                $file = $request->file('avatar');
                $fileName = strtolower(str_replace(['@', '.', ' '], ['', '', '_'], $request->input('email'))) . '-' .
                    strtolower(str_replace([' ', '-', '+'], ['_', '_', ''], $request->input('phone'))) . '-' .
                    strtolower(str_replace(' ', '_', $request->input('name'))) . '.' . $file->getClientOriginalExtension();

                // Set the path where the avatar will be uploaded
                $avatarDirectory = './public_html_metroberry_app/user-avatars';

                // Create the directory if it doesn't exist
                if (!file_exists($avatarDirectory)) {
                    mkdir($avatarDirectory, 0755, true);
                }

                // Move the uploaded avatar to the specified directory
                $file->move($avatarDirectory, $fileName);
                $avatarPath = 'avatars/' . $fileName; // Save the relative path in the database
            }

            // Create the user
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'avatar' => $avatarPath,
                'created_by' => null,
                'role' => 'customer',
            ]);
            Log::info('User created: ', $user->toArray());

            // Retrieve the organisation code
            $organisation = Organisation::find($request->input('organisation'));
            $organisation_code = $organisation->organisation_code;

            // Create the customer
            $customer = Customer::create([
                'created_by' => $user->id,
                'user_id' => $user->id,
                'organisation_id' => $organisation->id,
                'customer_organisation_code' => $organisation_code,
                'national_id_no' => null,
                'national_id_front_avatar' => null,
                'national_id_behind_avatar' => null,
            ]);
            Log::info('Customer created: ', $customer->toArray());

            // Redirect to phone input page with success message
            return redirect()->route('users.sign.in.page')->with('success', 'Account created successfully. Please provide your phone number.');
        } catch (\Exception $e) {
            // Handle exceptions and show an error message
            Log::error('Registration Error: ', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to register customer. Please try again later.');
        }
    }


    // Sign-up continue page method
    public function signUpContinuePage()
    {
        return view('customer-app.sign-up-continue-to-verify');
    }

    // Send verification code method
    public function sendVerificationCode(Request $request)
    {
        // Validate phone number
        $request->validate([
            'phone' => 'required|string|max:15',
        ]);

        // Simulate sending verification code (replace with actual SMS sending logic)
        $verificationCode = rand(1000, 9999);

        // Store the verification code in session
        session(['verification_code' => $verificationCode]);

        // Redirect to the verification code input page
        return redirect()->route('verify.code.page')->with('phone', $request->phone);
    }

    // Verify code page
    public function verifyCodePage()
    {
        return view('customer-app.verify-account');
    }

    // Handle verification code submission
    public function verifyCode(Request $request)
    {
        // Validate verification code
        $request->validate([
            'verification-code' => 'required|numeric',
        ]);

        // Compare the submitted code with the stored one
        if ($request->input('verification-code') == session('verification_code')) {
            // Code is correct, mark the user as verified (or proceed to log in)
            session()->forget('verification_code');
            return redirect()->route('customer.index.page')->with('success', 'Phone number verified successfully.');
        }

        // If the code is incorrect
        return redirect()->back()->withErrors(['verification-code' => 'Invalid code'])->withInput();
    }

    //Get all the routes  waypoint for the selected route
    public function getAllRouteWaypoints(Request $request)
    {
        Log::info('HERE');
        try {
            $routeLocationWaypoints = RouteLocations::where('route_id', $request->route_id)
                ->get(['name', 'id', 'point_order']);
            Log::info('Data request for getting all waypoints for route ID: ' . $request->route_id);
            Log::info('Retrieved waypoints: ', $routeLocationWaypoints->toArray());

            return response()->json($routeLocationWaypoints);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error fetching waypoints: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch waypoints'], 500);
        }
    }



    public function customerBookingPage()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a customer
        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Access Denied. Only customers can access this page.');
        }

        if ($user->customer->status !== 'active') {
            return redirect()->back()->with('error', 'Your account is not active. Please contact support.');
        }

        // Fetch the customer data based on the user_id in the customers table
        $customer = Customer::where('user_id', $user->id)->firstOrFail();

        // Fetch the organization that the customer belongs to
        $organization = Organisation::find($customer->organisation_id);

        // Fetch the routes for the organization (assuming you have a routes table)
        $routes = Routes::all();

        // Fetch the route locations (assuming you have a route_locations table with a route_id foreign key)
        $routeLocations = RouteLocations::whereIn('route_id', $routes->pluck('id'))->get();

        // Pass the data to the view
        return view('customer-app.book-a-trip', [
            'user' => $user,
            'customer' => $customer,
            'organisation' => $organization,
            'routes' => $routes,
            'routeLocations' => $routeLocations,
        ]);
    }
    public function customerBookingTrip(Request $request)
    {
        try {
            // Get all data from the request
            $data = $request->all();
            $user = Auth::user();

            // Log the incoming booking data for debugging
            Log::info('Customer booking trip data: ', $data);

            if ($user->customer->status !== 'active') {
                return redirect()->back()->with('error', 'Your account is not active. Please contact support.');
            }

            // Validate incoming data
            $validator = Validator::make($data, [
                'customer_id' => 'required|exists:users,id',
                'pick_up_location' => 'required|string',
                'preferred_route_id' => 'required|exists:routes,id',
                'drop_off_location' => 'required|string',
                'pickup_time' => 'required|date_format:H:i',
                'trip_date' => 'required|date|after_or_equal:today',
            ]);

            // Handle validation failures
            if ($validator->fails()) {
                Log::info('Validation failed: ', $validator->errors()->toArray());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Begin transaction to ensure atomic operations
            DB::beginTransaction();

            $given_user = User::findOrFail($data['customer_id']);
            $customer_id = $given_user->customer->id;

            // Create the trip record in the database
            $trip = Trip::create([
                'customer_id' => $customer_id,
                'route_id' => $data['preferred_route_id'],
                'pick_up_time' => $data['pickup_time'],
                'pick_up_location' => $data['pick_up_location'],
                'drop_off_location' => $data['drop_off_location'],
                'trip_date' => $data['trip_date'],
                'created_by' => $data['customer_id'],
            ]);

            // Commit the transaction if all went well
            DB::commit();

            // Log trip creation success
            Log::info('Trip created successfully: ', ['trip_id' => $trip->id]);

            // Redirect with a success message
            return redirect()->route('customer.index.page')->with('success', 'Trip Booked successfully.');

        } catch (\Exception $e) {
            // Rollback transaction in case of any errors
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error creating trip: ', ['error' => $e->getMessage()]);

            // Redirect with an error message
            return redirect()->back()->with('error', 'Something Went Wrong. Please try again later.')->withInput();
        }
    }


    public function customerProfile()
    {
        // Get the authenticated user
        $user = Auth::user();
        $organisations = Organisation::all();

        // Check if the user is a customer
        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Access Denied. Only customers can access this page.');
        }

        // Fetch the customer data based on the user_id in the customers table
        $customer = Customer::where('user_id', $user->id)->firstOrFail();

        return view('customer-app.profile', compact('customer', 'user', 'organisations'));
    }


    // public function customerProfileUpdate(Request $request, $id)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'phone' => 'required|string|max:15',
    //         'full-name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'address' => 'nullable|string|max:255',
    //         'organisation' => 'required|exists:organisations,id',
    //         'national_id_no' => 'nullable|string|max:50',
    //         'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'national_id_front_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'national_id_behind_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     // Find the customer by ID
    //     $customer = Customer::findOrFail($id);
    //     $user = User::find($customer->user_id);

    //     // Update customer details
    //     $user->name = $request->input('full-name');
    //     $user->email = $request->input('email');
    //     $user->phone = $request->input('phone');
    //     $user->address = $request->input('address');
    //     $customer->organisation_id = $request->input('organisation');
    //     $customer->national_id_no = $request->input('national_id_no');

    //     // Handle profile picture upload
    //     if ($request->hasFile('profile_picture')) {
    //         // Check if the old file exists and delete it if necessary
    //         if ($customer->profile_picture) {
    //             $oldProfilePath = public_path($customer->profile_picture);
    //             if (file_exists($oldProfilePath)) {
    //                 unlink($oldProfilePath); // Delete the old profile picture
    //             }
    //         }

    //         $file = $request->file('profile_picture');
    //         $filename = time() . '_profile.' . $file->getClientOriginalExtension();
    //         $filePath = 'uploads/user-avatars/' . $customer->id . '/' . $filename;

    //         // Move the new file to the public directory
    //         $file->move(public_path('uploads/user-avatars/' . $customer->id), $filename);
    //         $customer->profile_picture = $filePath; // Save the relative path
    //     }

    //     // Handle national ID front avatar upload
    //     if ($request->hasFile('national_id_front_avatar')) {
    //         // Check if the old file exists and delete it if necessary
    //         if ($customer->national_id_front_avatar) {
    //             $oldFrontIdPath = public_path($customer->national_id_front_avatar);
    //             if (file_exists($oldFrontIdPath)) {
    //                 unlink($oldFrontIdPath); // Delete the old front ID avatar
    //             }
    //         }

    //         $file = $request->file('national_id_front_avatar');
    //         $filename = time() . '_national_id_front.' . $file->getClientOriginalExtension();
    //         $filePath = 'uploads/front-page-ids/' . $customer->id . '/' . $filename;

    //         // Move the new file to the public directory
    //         $file->move(public_path('uploads/front-page-ids/' . $customer->id), $filename);
    //         $customer->national_id_front_avatar = $filePath; // Save the relative path
    //     }

    //     // Handle national ID behind avatar upload
    //     if ($request->hasFile('national_id_behind_avatar')) {
    //         // Check if the old file exists and delete it if necessary
    //         if ($customer->national_id_behind_avatar) {
    //             $oldBackIdPath = public_path($customer->national_id_behind_avatar);
    //             if (file_exists($oldBackIdPath)) {
    //                 unlink($oldBackIdPath); // Delete the old back ID avatar
    //             }
    //         }

    //         $file = $request->file('national_id_behind_avatar');
    //         $filename = time() . '_national_id_behind.' . $file->getClientOriginalExtension();
    //         $filePath = 'uploads/national_id_avatars/' . $customer->id . '/' . $filename;

    //         // Move the new file to the public directory
    //         $file->move(public_path('uploads/national_id_avatars/' . $customer->id), $filename);
    //         $customer->national_id_behind_avatar = $filePath; // Save the relative path
    //     }

    //     // Save the updated customer details
    //     $customer->save();
    //     $user->save(); // Don't forget to save the user details

    //     // Redirect back with a success message
    //     return redirect()->route('customer.profile', $id)->with('success', 'Profile updated successfully.');
    // }


    //     public function customerProfileUpdate(Request $request, $id)
// {
//     // Validate the incoming request data
//     $request->validate([
//         'phone' => 'required|string|max:15',
//         'full-name' => 'required|string|max:255',
//         'email' => 'required|email|max:255',
//         'address' => 'nullable|string|max:255',
//         'organisation' => 'required|exists:organisations,id',
//         'national_id_no' => 'nullable|string|max:50',
//         'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         'national_id_front_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         'national_id_behind_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

    //     // Find the customer by ID
//     $customer = Customer::findOrFail($id);
//     $user = User::find($customer->user_id);

    //     // Update customer details
//     $user->name = $request->input('full-name');
//     $user->email = $request->input('email');
//     $user->phone = $request->input('phone');
//     $user->address = $request->input('address');
//     $customer->organisation_id = $request->input('organisation');
//     $customer->national_id_no = $request->input('national_id_no');

    //     // Base path for uploads

    //     // Handle profile picture upload
//     if ($request->hasFile('profile_picture')) {
//         // Check if the old file exists and delete it if necessary
//         if ($customer->profile_picture) {
//             $oldProfilePath = public_path($customer->profile_picture);
//             if (file_exists($oldProfilePath)) {
//                 unlink($oldProfilePath); // Delete the old profile picture
//             }
//         }

    //         $file = $request->file('profile_picture');
//         $filename = time() . '_profile.' . $file->getClientOriginalExtension();
//         $filePath = 'user-avatars/' . $customer->id . '/' . $filename;

    //         // Move the new file to the specified directory
//         $file->move($baseUploadPath . '/user-avatars/' . $customer->id, $filename);
//         $customer->profile_picture = $filePath; // Save the relative path
//     }

    //     // Handle national ID front avatar upload
//     if ($request->hasFile('national_id_front_avatar')) {
//         // Check if the old file exists and delete it if necessary
//         if ($customer->national_id_front_avatar) {
//             $oldFrontIdPath = public_path($customer->national_id_front_avatar);
//             if (file_exists($oldFrontIdPath)) {
//                 unlink($oldFrontIdPath); // Delete the old front ID avatar
//             }
//         }

    //         $file = $request->file('national_id_front_avatar');
//         $filename = time() . '_national_id_front.' . $file->getClientOriginalExtension();
//         $filePath = 'front-page-ids/' . $customer->id . '/' . $filename;

    //         // Move the new file to the specified directory
//         $file->move($baseUploadPath . '/front-page-ids/' . $customer->id, $filename);
//         $customer->national_id_front_avatar = $filePath; // Save the relative path
//     }

    //     // Handle national ID behind avatar upload
//     if ($request->hasFile('national_id_behind_avatar')) {
//         // Check if the old file exists and delete it if necessary
//         if ($customer->national_id_behind_avatar) {
//             $oldBackIdPath = public_path($customer->national_id_behind_avatar);
//             if (file_exists($oldBackIdPath)) {
//                 unlink($oldBackIdPath); // Delete the old back ID avatar
//             }
//         }

    //         $file = $request->file('national_id_behind_avatar');
//         $filename = time() . '_national_id_behind.' . $file->getClientOriginalExtension();
//         $filePath = 'national_id_avatars/' . $customer->id . '/' . $filename;

    //         // Move the new file to the specified directory
//         $file->move($baseUploadPath . '/national_id_avatars/' . $customer->id, $filename);
//         $customer->national_id_behind_avatar = $filePath; // Save the relative path
//     }

    //     // Save the updated customer details
//     $customer->save();
//     $user->save(); // Don't forget to save the user details

    //     // Redirect back with a success message
//     return redirect()->route('customer.profile', $id)->with('success', 'Profile updated successfully.');
// }


    public function customerProfileUpdate(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'phone' => 'required|string|max:15',
            'full-name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'organisation' => 'required|exists:organisations,id',
            'national_id_no' => 'nullable|string|max:50',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'national_id_front_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'national_id_behind_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the customer by ID
        $customer = Customer::findOrFail($id);
        $user = User::find($customer->user_id);

        // Update customer details
        $user->name = $request->input('full-name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $customer->organisation_id = $request->input('organisation');
        $customer->national_id_no = $request->input('national_id_no');

        // Base path for uploads
        $baseUploadPath = './public/public_html_metroberry_app/';

        // Function to create directory if it doesn't exist
        $createDirIfNotExists = function ($path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        };

        // Function to generate file name based on user details
        $generateFileName = function ($type, $file, $user) {
            return strtolower(str_replace(['@', '.', ' '], ['', '', '_'], $user->email)) . '-' .
                strtolower(str_replace([' ', '-', '+'], ['_', '_', ''], $user->phone)) . '-' .
                strtolower(str_replace(' ', '_', $user->name)) . '-' .
                time() . '-' . $type . '.' . $file->getClientOriginalExtension();
        };

        // Handle profile picture upload (avatar)
        if ($request->hasFile('profile_picture')) {
            // Check if the old file exists and delete it if necessary
            if ($customer->profile_picture) {
                $oldProfilePath = public_path($customer->profile_picture);
                if (file_exists($oldProfilePath)) {
                    unlink($oldProfilePath); // Delete the old profile picture
                }
            }

            $file = $request->file('profile_picture');
            $fileName = $generateFileName('profile', $file, $user);

            $userDirPath = $baseUploadPath . 'uploads/user-avatars/' . $customer->id;

            // Create the directory if it doesn't exist
            $createDirIfNotExists($userDirPath);

            // Move the new file to the specified directory
            $file->move($userDirPath, $fileName);
            $customer->profile_picture = 'uploads/user-avatars/' . $customer->id . '/' . $fileName; // Save the relative path
        }

        // Handle national ID front avatar upload
        if ($request->hasFile('national_id_front_avatar')) {
            // Check if the old file exists and delete it if necessary
            if ($customer->national_id_front_avatar) {
                $oldFrontIdPath = public_path($customer->national_id_front_avatar);
                if (file_exists($oldFrontIdPath)) {
                    unlink($oldFrontIdPath); // Delete the old front ID avatar
                }
            }

            $file = $request->file('national_id_front_avatar');
            $fileName = $generateFileName('national_id_front', $file, $user);

            $frontIdDirPath = $baseUploadPath . 'uploads/front-page-ids/' . $customer->id;

            // Create the directory if it doesn't exist
            $createDirIfNotExists($frontIdDirPath);

            // Move the new file to the specified directory
            $file->move($frontIdDirPath, $fileName);
            $customer->national_id_front_avatar = 'uploads/front-page-ids/' . $customer->id . '/' . $fileName; // Save the relative path
        }

        // Handle national ID behind avatar upload
        if ($request->hasFile('national_id_behind_avatar')) {
            // Check if the old file exists and delete it if necessary
            if ($customer->national_id_behind_avatar) {
                $oldBackIdPath = public_path($customer->national_id_behind_avatar);
                if (file_exists($oldBackIdPath)) {
                    unlink($oldBackIdPath); // Delete the old back ID avatar
                }
            }

            $file = $request->file('national_id_behind_avatar');
            $fileName = $generateFileName('national_id_behind', $file, $user);

            $behindIdDirPath = $baseUploadPath . 'uploads/back-page-ids/' . $customer->id;

            // Create the directory if it doesn't exist
            $createDirIfNotExists($behindIdDirPath);

            // Move the new file to the specified directory
            $file->move($behindIdDirPath, $fileName);
            $customer->national_id_behind_avatar = 'uploads/back-page-ids/' . $customer->id . '/' . $fileName; // Save the relative path
        }

        // Save the updated customer details
        $customer->save();
        $user->save(); // Don't forget to save the user details

        // Redirect back with a success message
        return redirect()->route('customer.profile', $id)->with('success', 'Profile updated successfully.');
    }


    public function tripsHistory()
    {
        return view('customer-app.trips-history');
    }


    public function showTripDetails($id)
    {
        // Retrieve the trip details using the provided id
        $trip = Trip::findOrFail($id);
        $customer = auth()->user();

        // Pass the trip details to the view
        return view('customer-app.show-trip-detail', compact('trip', 'customer'));
    }

    public function cancelTrip($id)
    {

        Log::info('Trip Id being cancalled');
        Log::info($id);
        $trip = Trip::findOrFail($id);
        $trip->status = 'cancelled';
        $trip->save();

        return redirect()->route('customer.index.page', $trip->id)->with('status', 'Trip has been cancelled.');
    }



    // Payment Methods
    public function paymentMethod()
    {
        // view file resources/views/customer/payment-methods.blade.php
        return view('customer-app.payment-methods');
    }

    // Customer Addresses
    public function customerAddress()
    {
        // view file resources/views/customer/addresses.blade.php
        return view('customer-app.addresses');
    }

    // Apply Promo Code
    public function applyPromoCode()
    {
        // view file resources/views/customer/apply-promo-code.blade.php
        return view('customer-app.apply-promo-code');
    }

    // Settings
    public function customerSettings()
    {
        // view file resources/views/customer/settings.blade.php
        return view('customer-app.settings');
    }

    // Online Support
    public function onlineSupport()
    {
        // view file resources/views/customer/online-support.blade.php
        return view('customer-app.online-support');
    }

    public function tripsCompleted()
    {
        $user = Auth::user();
        $customer = $user->customer;

        $trips = Trip::where('customer_id', $customer->id)->where('status', 'completed')->get();

        return view('customer-app.trips-completed', compact('trips'));
    }

    // Method to show a specific Completed trip details
    public function tripCompletedShowPage($id)
    {
        $trip = Trip::findOrFail($id);

        return view('customer-app.trip-completed-show', compact('trip'));
    }

    // Method to show Booked trips page
    public function tripsBooked()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a customer
        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Access Denied. Only customers can access this page.');
        }

        // Fetch the customer data based on the user_id in the customers table
        $customer = customer::where('user_id', $user->id)->firstOrFail();

        // Log customer information for debugging
        Log::info('customer is Huyo Apa:', ['customer' => $customer]);

        // Fetch the completed trips for the customer
        $trips = Trip::where('customer_id', $customer->id)->where('status', 'scheduled')->get();
        Log::info('customer Trips Ndizo hzi  Apa:', ['trips' => $trips]);

        // Return the view with the trips data
        return view('customer-app.trips-booked', compact('trips'));
    }



    public function tripsCancelled()
    {
        $user = Auth::user();
        $customer = $user->customer;

        $trips = Trip::where('customer_id', $customer->id)->where('status', 'cancelled')->get();

        return view('customer-app.trips-cancelled', compact('trips'));
    }

    // Method to show a specific cancelled trip details
    public function tripCancelledShowPage($id)
    {
        $trip = Trip::findOrFail($id);

        return view('customer-app.trip-cancelled-show', compact('trip'));
    }

    // public function updateProfilePicture(Request $request)
    // {
    //     $request->validate([
    //         'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $user = Auth::user();
    //     $customer = $user->customer;

    //     if ($request->hasFile('profile_picture')) {
    //         // Check if the old profile picture exists and delete it if necessary
    //         if ($customer->user->avatar) {
    //             $oldProfilePath = public_path($customer->user->avatar);
    //             if (file_exists($oldProfilePath)) {
    //                 unlink($oldProfilePath); // Delete the old profile picture
    //             }
    //         }

    //         $file = $request->file('profile_picture');
    //         $fileName = time() . '_' . $file->getClientOriginalName(); // Use a unique name for the file
    //         $directory = 'uploads/user-avatars/' . $user->id . '/';

    //         // Ensure the directory exists
    //         if (!is_dir(public_path($directory))) {
    //             mkdir(public_path($directory), 0755, true); // Create directory if it doesn't exist
    //         }

    //         // Move the file to the public directory
    //         $file->move(public_path($directory), $fileName);

    //         // Update the user's profile picture path
    //         $customer->user->avatar = $directory . $fileName; // Save the relative path
    //         $customer->user->save();

    //         return response()->json(['newProfilePictureUrl' => asset($customer->user->avatar)]); // Use asset() to get the URL
    //     }

    //     return response()->json(['error' => 'Failed to upload profile picture'], 400);
    // }


    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $customer = $user->customer;

        if ($request->hasFile('profile_picture')) {
            // Check if the old profile picture exists and delete it if necessary
            if ($customer->user->avatar) {
                $oldProfilePath = './public/public_html_metroberry_app/' . $customer->user->avatar;
                if (file_exists($oldProfilePath)) {
                    unlink($oldProfilePath); // Delete the old profile picture
                }
            }

            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Use a unique name for the file
            $directory = 'uploads/user-avatars/' . $user->id . '/';

            // Ensure the directory exists
            $fullDirectoryPath = './public/public_html_metroberry_app/' . $directory;
            if (!is_dir($fullDirectoryPath)) {
                mkdir($fullDirectoryPath, 0755, true); // Create directory if it doesn't exist
            }

            // Move the file to the specified directory
            $file->move($fullDirectoryPath, $fileName);

            // Update the user's profile picture path
            $customer->user->avatar = $directory . $fileName; // Save the relative path
            $customer->user->save();

            return response()->json(['newProfilePictureUrl' => asset($customer->user->avatar)]); // Use asset() to get the URL
        }

        return response()->json(['error' => 'Failed to upload profile picture'], 400);
    }


}
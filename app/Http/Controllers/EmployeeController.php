<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use Exception;
use App\Models\User;
use App\Models\Customer;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $customers = null;

            // Check the user's role
            if (Auth::user()->role == 'admin') {
                // If the user is an admin, fetch all customers
                $customers = Customer::all();
            } elseif (Auth::user()->role == 'organisation') {
                // If the user is an organisation, fetch customers for that organisation
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $customers = Customer::where('customer_organisation_code', $organisation->organisation_code)->get();
                }
            } else {
                // If the user has another role, fetch customers created by the user
                $customers = Customer::where('created_by', Auth::user()->id)->get();
            }

            Log::info('Customers fetched: ', ['customers' => $customers]);

            // Fetch organisations with user information
            $organisations = Organisation::with('user')->get();

            return view('employee.index', compact('customers', 'organisations'));
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error fetching customers: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while fetching the customers. Please try again.');
        }
    }



    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $creator = Auth::user();

            // Validation rules
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|string|unique:users,phone',
                'organisation' => 'required|string|exists:organisations,organisation_code',
                'email' => 'required|email|unique:users,email',
                'address' => 'required|string',
                'national_id' => 'required|string|unique:customers,national_id_no',
                'front_page_id' => 'required|file|mimes:jpg,jpeg,png,webp',
                'back_page_id' => 'required|file|mimes:jpg,jpeg,png,webp',
                'avatar' => 'nullable|file|mimes:jpg,jpeg,png,webp',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $organisation = Organisation::where('organisation_code', $data['organisation'])->first();

            if (!$organisation) {
                return redirect()->back()->with('error', 'Organisation not found')->withInput();
            }

            $name = $data['name'];
            $email = $data['email'];
            $phone = $data['phone'];

            // Define exact paths
            $frontIdPath = '/home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids/';
            $backIdPath = '/home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids/';
            $avatarPath = '/home/kknuicdz/public_html_metroberry_app/uploads/user-avatars/';

            // Handle front page ID upload
            if ($request->hasFile('front_page_id')) {
                $frontIdPath = $this->uploadFile($request, 'front_page_id', $frontIdPath, $name, $email, $phone);
            }

            // Handle back page ID upload
            if ($request->hasFile('back_page_id')) {
                $backIdPath = $this->uploadFile($request, 'back_page_id', $backIdPath, $name, $email, $phone);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $this->uploadFile($request, 'avatar', $avatarPath, $name, $email, $phone);
            }

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'phone' => $data['phone'],
                'address' => $data['address'],
                'avatar' => $avatarPath,
                'created_by' => $creator->id,
                'role' => 'customer',
            ]);

            $user->assignRole('customer');

            // Create customer
            Customer::create([
                'created_by' => $creator->id,
                'user_id' => $user->id,
                'organisation_id' => $organisation->id,
                'customer_organisation_code' => $data['organisation'],
                'national_id_no' => $data['national_id'],
                'national_id_front_avatar' => $frontIdPath,
                'national_id_behind_avatar' => $backIdPath,
            ]);

            DB::commit();

            // Send email with the plain password
            Mail::send('mail-view.employee-welcome-mail', [
                'customer' => $user->name,
                'email' => $user->email,
                'password' => $data['password']
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your Account Created');
            });

            Log::info('SUCCESS');

            return redirect()->route('employee')->with('success', 'Customer created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('CREATE CUSTOMER ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred')->withInput();
        }
    }

    private function uploadFile(Request $request, $inputName, $path, $name, $email, $phone)
    {
        $file = $request->file($inputName);
        $fileName = "{$name}-{$email}-{$phone}.{$file->getClientOriginalExtension()}";
        $absolutePath = $path . $fileName;

        // Move the file to the absolute path
        $file->move($path, $fileName);

        // Return the relative path to store in the database
        return 'uploads/' . basename($path) . '/' . $fileName;
    }




    /**
     * Display the specified resource.
     */



    public function show(string $id)
    {
        try {
            // Retrieve the customer with the user, creator, and organisation details
            $customer = Customer::with([
                'user',
                'creator',
                'organisation.user'
            ])->findOrFail($id);

            // Prepare the response data
            $response = [
                'id' => $customer->id,
                'created_by' => [
                    'id' => $customer->creator->id,
                    'name' => $customer->creator->name,
                    'email' => $customer->creator->email,
                    "phone" => $customer->creator->phone,
                    "address" => $customer->creator->address,
                    "avatar" => $customer->creator->avatar,
                    "organisation" => $customer->creator->organisation
                ],
                'user' => [
                    'id' => $customer->user->id,
                    'name' => $customer->user->name,
                    'email' => $customer->user->email,
                    "phone" => $customer->user->phone,
                    "address" => $customer->user->address,
                    "avatar" => $customer->user->avatar,
                    "organisation" => $customer->user->organisation
                ],
                'organisation' => [
                    'id' => $customer->organisation->id,
                    'name' => $customer->organisation->user->name,
                    "phone" => $customer->organisation->user->phone,
                    "address" => $customer->organisation->user->address,
                    "avatar" => $customer->organisation->user->avatar,
                    "organisation" => $customer->organisation->user->organisation
                ],
                'organisation_id' => $customer->organisation_id,
                'customer_organisation_code' => $customer->customer_organisation_code
            ];

            return response()->json([
                'message' => 'Customer retrieved successfully',
                'customer' => $response
            ], 200);
        } catch (Exception $e) {
            Log::error('RETRIEVE CUSTOMER ERROR');
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred while fetching customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */


    public function create(Request $request)
    {
        $organisations = Organisation::with('user')->where('status', 'active')->get();
        return view('employee.create', compact('organisations'));
    }




    public function edit($id)
    {
        // Fetch the customer details
        $customer = Customer::with('user')->findOrFail($id);

        // Fetch organisations (if necessary)
        $organisations = Organisation::where('status', 'active')->get();

        // Return the view with data
        return view('employee.edit', compact('customer', 'organisations'));
    }


    public function update(Request $request, $id)
    {
        try {
            $customer = Customer::find($id);
            $user = User::find($customer->user_id);
            $data = $request->all();
            $organisation = Organisation::where('organisation_code', $data['organisation'])->first();

            // Check if customer, user, and organisation exist
            if (!$customer) {
                return redirect()->back()->with('error', 'Customer not found');
            }

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            if (!$organisation) {
                return redirect()->back()->with('error', 'Organisation not found');
            }

            // Validate the incoming data
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'organisation' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'address' => 'nullable|string',
                'national_id_no' => 'required|string|unique:customers,national_id_no,' . $customer->id,
                'front_page_id' => 'nullable|file|mimes:jpg,jpeg,png,webp',
                'back_page_id' => 'nullable|file|mimes:jpg,jpeg,png,webp',
                'avatar' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Update user and customer details
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->address = $data['address'];
            $customer->national_id_no = $data['national_id_no'];
            $email = $data['email'];
            $name = $data['name'];
            $phone = $data['phone'];

            // Define absolute upload paths
            $frontIdPath = '/home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids/';
            $backIdPath = '/home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids/';
            $avatarPath = '/home/kknuicdz/public_html_metroberry_app/uploads/user-avatars/';

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$name}-{$email}-{$phone}-avatar.{$avatarExtension}";
                $avatarFilePath = $avatarPath . $avatarFileName;

                // Delete old file if it exists
                if ($user->avatar && file_exists('/home/kknuicdz/public_html_metroberry_app/' . $user->avatar)) {
                    unlink('/home/kknuicdz/public_html_metroberry_app/' . $user->avatar);
                }

                // Move new file to the specified directory
                $avatarFile->move($avatarPath, $avatarFileName);
                $user->avatar = 'uploads/user-avatars/' . $avatarFileName; // Save the relative path
            }

            // Handle front page ID upload
            if ($request->hasFile('front_page_id')) {
                $frontIdFile = $request->file('front_page_id');
                $frontIdExtension = $frontIdFile->getClientOriginalExtension();
                $frontIdFileName = "{$name}-{$email}-{$phone}-front-page-id.{$frontIdExtension}";
                $frontIdFilePath = $frontIdPath . $frontIdFileName;

                // Delete old file if it exists
                if ($customer->national_id_front_avatar && file_exists('/home/kknuicdz/public_html_metroberry_app/' . $customer->national_id_front_avatar)) {
                    unlink('/home/kknuicdz/public_html_metroberry_app/' . $customer->national_id_front_avatar);
                }

                // Move new file to the specified directory
                $frontIdFile->move($frontIdPath, $frontIdFileName);
                $customer->national_id_front_avatar = 'uploads/front-page-ids/' . $frontIdFileName; // Save the relative path
            }

            // Handle back page ID upload
            if ($request->hasFile('back_page_id')) {
                $backIdFile = $request->file('back_page_id');
                $backIdExtension = $backIdFile->getClientOriginalExtension();
                $backIdFileName = "{$name}-{$email}-{$phone}-back-page-id.{$backIdExtension}";
                $backIdFilePath = $backIdPath . $backIdFileName;

                // Delete old file if it exists
                if ($customer->national_id_behind_avatar && file_exists('/home/kknuicdz/public_html_metroberry_app/' . $customer->national_id_behind_avatar)) {
                    unlink('/home/kknuicdz/public_html_metroberry_app/' . $customer->national_id_behind_avatar);
                }

                // Move new file to the specified directory
                $backIdFile->move($backIdPath, $backIdFileName);
                $customer->national_id_behind_avatar = 'uploads/back-page-ids/' . $backIdFileName; // Save the relative path
            }

            // Update organisation details
            $customer->organisation_id = $organisation->id;
            $customer->customer_organisation_code = $data['organisation'];
            $customer->status = 'inactive';

            // Save changes
            $customer->save();
            $user->save();

            DB::commit();

            return redirect()->route('employee')->with('success', 'Customer updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('UPDATE CUSTOMER ERROR');
            Log::info($e);
            return redirect()->back()->with('error', 'An error occurred while updating customer');
        }
    }



    public function activateForm($id)
    {
        $customer = Customer::findOrFail($id);
        return view('employee.activate', compact('customer'));
    }

    public function activate($id)
    {
        try {

            $customer = Customer::find($id);

            if (!$customer) {
                return redirect()->back()->with('error', 'Customer not found');
            }

            if (!$customer->national_id_front_avatar || !$customer->national_id_behind_avatar) {
                return redirect()->back()->with('error', 'Missing Documents');
            }

            if (!$customer->national_id_no) {
                return redirect()->back()->with('error', 'Missing National ID');
            }

            $user = User::find($customer->user_id);

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            DB::beginTransaction();

            $customer->status = 'active';

            $customer->save();

            DB::commit();

            return redirect()->route('employee')->with('success', 'Customer activated successfully');
        } catch (Exception $e) {
            Log::info('ACTIVATE CUSTOMER ERROR');
            Log::info($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function deactivateForm($id)
    {
        $customer = Customer::findOrFail($id);
        return view('employee.deactivate', compact('customer'));
    }

    public function deactivate($id)
    {
        try {

            $customer = Customer::find($id);

            if (!$customer) {
                return redirect()->back()->with('error', 'Customer not found');
            }

            $user = User::find($customer->user_id);

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            DB::beginTransaction();

            $customer->status = 'inactive';

            $customer->save();

            DB::commit();

            return redirect()->route('employee')->with('success', 'Customer deactivated successfully');
        } catch (Exception $e) {
            Log::info('DEACTIVATE CUSTOMER ERROR');
            Log::info($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }



    public function delete($id)
    {
        $customer = Customer::findOrFail($id);

        $user = User::find($customer->user_id);
        return view('employee.delete', compact('customer', 'user'));
    }

    // Remove the specified resource from storage
    /**
     * Remove the specified resource from storage.
     */



    public function destroy(string $id)
    {
        try {
            $customer = Customer::find($id);

            if (!$customer) {
                return redirect()->back()->with('error', 'Customer not found');
            }

            $user = User::find($customer->user_id);

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            // Define the paths for the files
            $frontIdPath = '/home/kknuicdz/public_html_metroberry_app/uploads/front-page-ids/';
            $backIdPath = '/home/kknuicdz/public_html_metroberry_app/uploads/back-page-ids/';
            $avatarPath = '/home/kknuicdz/public_html_metroberry_app/uploads/user-avatars/';

            // Delete associated files for the user
            if ($user->avatar) {
                $oldAvatarPath = $avatarPath . $user->avatar;
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath); // Delete the old avatar
                }
            }

            // Delete associated front-page ID for the customer
            if ($customer->national_id_front_avatar) {
                $oldFrontIdPath = $frontIdPath . $customer->national_id_front_avatar;
                if (file_exists($oldFrontIdPath)) {
                    unlink($oldFrontIdPath); // Delete the old front ID
                }
            }

            // Delete associated back-page ID for the customer
            if ($customer->national_id_behind_avatar) {
                $oldBackIdPath = $backIdPath . $customer->national_id_behind_avatar;
                if (file_exists($oldBackIdPath)) {
                    unlink($oldBackIdPath); // Delete the old back ID
                }
            }

            // Begin transaction to delete the customer and user
            DB::beginTransaction();

            // Delete the customer and the user
            $customer->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('employee')->with('success', 'Customer details deleted successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('DELETE CUSTOMER ERROR');
            Log::info($e);
            return redirect()->back()->with('error', 'An error occurred while deleting customer');
        }
    }


    public function export()
    {
        $role = Auth::user()->role;
        $organisation = null;

        if ($role == 'organisation') {
            $organisation = Organisation::where('user_id', Auth::user()->id)->first();
        }

        $export = new CustomerExport($role, $organisation);

        return Excel::download($export, 'customers.xlsx');
    }




    /**
     * 
     *Import Employee detials 

     */
    public function importFile()
    {
        return view('employee.importEmployee');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt,xlsx',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            Excel::import(new EmployeeImport, $request->file('file'));

            //log 
            Log::info('data from Employee CSV File being Imported : ');
            Log::info($request->file('file'));

            return redirect()->back()->with('success', 'Records imported successfully.');
        } catch (Exception $e) {
            Log::error('Error importing employees: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while importing the Employee records.');
        }
    }
}
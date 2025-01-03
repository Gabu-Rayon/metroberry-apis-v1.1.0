<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RefuellingStation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RefuellingStationController extends Controller
{

    public function dashboard()
    {
        return view('refueling.station.home');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = RefuellingStation::all();
        return view('refueling.station.index', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('refueling.station.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'station_code' => 'required|string|max:255|unique:refuelling_stations',
                'phone' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'address' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'certificate_of_operations' => 'required|file|mimes:pdf',
                'avatar' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'payment_period' => 'required|in:daily,weekly,monthly,quarterly,biannually,annually',
            ]);

            if ($validator->fails()) {
                Log::error('STORE REFUELING STATION VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            // Absolute paths
            $certificateOfOperationsPath = "/home/kknuicdz/public_html_metroberry_app/uploads/cert-ops";
            $avatarPath = "/home/kknuicdz/public_html_metroberry_app/uploads/user-avatars";

            $email = $data['email'];
            $phone = $data['phone'];
            $name = $data['name'];
            $generatedPassword = $data['password'];

            // Handling the certificate of operations file upload
            $certificateOfOperationsFile = $request->file('certificate_of_operations');
            $certificateOfOperationsExtension = $certificateOfOperationsFile->getClientOriginalExtension();
            $certificateOfOperationsFileName = "{$name}-{$email}-{$phone}-cert-op.{$certificateOfOperationsExtension}";
            $certificateOfOperationsFile->move($certificateOfOperationsPath, $certificateOfOperationsFileName);
            $certificateOfOperationsPath = 'uploads/cert-ops/' . $certificateOfOperationsFileName;

            // Handling avatar file upload
            if ($request->hasFile('avatar')) {
                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$name}-{$email}-{$phone}-avatar.{$avatarExtension}";
                $avatarFile->move($avatarPath, $avatarFileName);
                $avatarPath = 'uploads/user-avatars/' . $avatarFileName;
            }

            // Create user record
            $user = User::create([
                'name' => $data['name'],
                'email' => $email,
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'address' => $data['address'],
                'avatar' => $avatarPath,
                'created_by' => auth()->id(),
                'role' => 'refueling_station',
            ]);

            // Create refueling station record
            RefuellingStation::create([
                'user_id' => $user->id,
                'station_code' => $data['station_code'],
                'certificate_of_operations' => $certificateOfOperationsPath,
                'payment_period' => $data['payment_period'],
            ]);

            // Assign role to the user
            $user->assignRole('refueling_station');

            DB::commit();

            // Send email with the plain password
            Mail::send('mail-view.fuel-station-welcome-mail', [
                'station' => $user->name,
                'email' => $user->email,
                'password' => $generatedPassword
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your Account Created');
            });

            return redirect()->route('refueling.station')->with('success', 'Refueling Station created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('STORE REFUELING STATION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(RefuellingStation $refuellingStation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $station = RefuellingStation::find($id);
        return view('refueling.station.edit', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     */



    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $station = RefuellingStation::findOrFail($id);
            $user = User::findOrFail($station->user_id);

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'station_code' => 'required|string|max:255|unique:refuelling_stations,station_code,' . $id,
                'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'address' => 'required|string|max:255',
                'certificate_of_operations' => 'nullable|file|mimes:pdf',
                'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'payment_period' => 'required|in:daily,weekly,monthly,quarterly,biannually,annually',
            ]);

            if ($validator->fails()) {
                Log::error('UPDATE REFUELING STATION VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $email = $data['email'];
            $name = $data['name'];
            $phone = $data['phone'];

            // Define absolute paths
            $certificateOfOperationsUploadPath = "/home/kknuicdz/public_html_metroberry_app/uploads/cert-ops";
            $avatarUploadPath = "/home/kknuicdz/public_html_metroberry_app/uploads/user-avatars";

            // Handling certificate of operations file upload
            $certificateOfOperationsPath = $station->certificate_of_operations; // Default to old path
            if ($request->hasFile('certificate_of_operations')) {
                $certificateOfOperationsFile = $request->file('certificate_of_operations');
                $certificateOfOperationsExtension = $certificateOfOperationsFile->getClientOriginalExtension();
                $certificateOfOperationsFileName = "{$name}-{$email}-{$phone}-cert-op.{$certificateOfOperationsExtension}";

                // Move the file to the specified directory
                $certificateOfOperationsFile->move($certificateOfOperationsUploadPath, $certificateOfOperationsFileName);
                $certificateOfOperationsPath = 'uploads/cert-ops/' . $certificateOfOperationsFileName;

                // Delete the old certificate file if a new one is uploaded
                if ($station->certificate_of_operations) {
                    $oldCertificatePath = public_path($station->certificate_of_operations);
                    if (file_exists($oldCertificatePath)) {
                        unlink($oldCertificatePath);
                    }
                }
            }

            // Handling avatar file upload
            $avatarPath = $user->avatar; // Default to old path
            if ($request->hasFile('avatar')) {
                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$name}-{$email}-{$phone}-avatar.{$avatarExtension}";

                // Move the file to the specified directory
                $avatarFile->move($avatarUploadPath, $avatarFileName);
                $avatarPath = 'uploads/user-avatars/' . $avatarFileName;

                // Delete the old avatar file if a new one is uploaded
                if ($user->avatar) {
                    $oldAvatarPath = public_path($user->avatar);
                    if (file_exists($oldAvatarPath)) {
                        unlink($oldAvatarPath);
                    }
                }
            }

            // Update user and station data
            $user->update([
                'name' => $data['name'],
                'email' => $email,
                'phone' => $data['phone'],
                'address' => $data['address'],
                'avatar' => $avatarPath,
            ]);

            $station->update([
                'station_code' => $data['station_code'],
                'certificate_of_operations' => $certificateOfOperationsPath,
                'payment_period' => $data['payment_period'],
                'status' => 'inactive',
            ]);

            DB::commit();

            return redirect()->route('refueling.station')->with('success', 'Refueling Station updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE REFUELING STATION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }




    public function activateForm($id)
    {
        $station = RefuellingStation::find($id);
        return view('refueling.station.activate', compact('station'));
    }

    public function activate($id)
    {
        try {
            $station = RefuellingStation::findOrfail($id);

            if ($station->status == 'active') {
                return redirect()->back()->with('error', 'Refueling Station is already active');
            }

            if (!$station->certificate_of_operations) {
                return redirect()->back()->with('error', 'Missing Documents');
            }

            DB::beginTransaction();

            $station->status = 'active';

            $station->save();

            DB::commit();

            return redirect()->route('refueling.station')->with('success', 'Refueling Station activated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ACTIVATE REFUELING STATION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deactivateForm($id)
    {
        $station = RefuellingStation::find($id);
        return view('refueling.station.deactivate', compact('station'));
    }

    public function deactivate($id)
    {
        try {
            $station = RefuellingStation::findOrfail($id);

            if ($station->status == 'inactive') {
                return redirect()->back()->with('error', 'Refueling Station is already inactive');
            }

            DB::beginTransaction();

            $station->status = 'inactive';

            $station->save();

            DB::commit();

            return redirect()->route('refueling.station')->with('success', 'Refueling Station deactivated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DEACTIVATE REFUELING STATION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $station = RefuellingStation::find($id);
        return view('refueling.station.delete', compact('station'));
    }


    
    public function destroy($id)
    {
        try {
            $station = RefuellingStation::findOrFail($id);
            $user = User::findOrFail($station->user_id);

            if (!$station) {
                return redirect()->back()->with('error', 'Refueling Station not found');
            }

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            DB::beginTransaction();

            // Absolute paths for files
            $certificateOfOperationsPath = "/home/kknuicdz/public_html_metroberry_app/uploads/cert-ops";
            $avatarPath = "/home/kknuicdz/public_html_metroberry_app/uploads/user-avatars";

            // Delete certificate of operations file if it exists
            if ($station->certificate_of_operations) {
                $certificateFilePath = $certificateOfOperationsPath . '/' . $station->certificate_of_operations;
                if (file_exists($certificateFilePath)) {
                    unlink($certificateFilePath);  // Deleting certificate of operations
                }
            }

            // Delete avatar file if it exists
            if ($user->avatar) {
                $avatarFilePath = $avatarPath . '/' . $user->avatar;
                if (file_exists($avatarFilePath)) {
                    unlink($avatarFilePath);  // Deleting avatar file
                }
            }

            // Delete the station and user
            $station->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('refueling.station')->with('success', 'Refueling Station deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE REFUELING STATION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
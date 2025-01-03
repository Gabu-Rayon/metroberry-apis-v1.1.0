<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Driver;
use App\Models\PSVBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DriversPSVBadgesExport;
use Illuminate\Support\Facades\Validator;

class PSVBadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $psvbadges = PSVBadge::all();
        $drivers = Driver::whereDoesntHave('psvBadge')->get();
        return view('driver.psvbadge.index', compact('psvbadges', 'drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        try {
            $data = $request->all();

            // Validation
            $validator = Validator::make($data, [
                'driver' => 'required|numeric|exists:drivers,id',
                'psvbadge_no' => 'required|unique:psv_badges,psv_badge_no',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after:issue_date',
                'psv_badge_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('PSV BADGE STORE VALIDATION ERROR');
                Log::error($validator->errors()->all());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $badgePath = null;
            $badgeNumber = $data['psvbadge_no'];

            // Retrieve driver and driver user details
            $driver = Driver::findOrFail($data['driver']);
            $driverUserId = $driver->user_id;
            $driverUser = User::findOrFail($driverUserId);
            $driver_name = $driverUser->name;
            $driver_email = $driverUser->email;
            $driver_phone = $driverUser->phone;

            DB::beginTransaction();

            // Define the file upload path
            $psvbadgeUploadpath = "/home/kknuicdz/public_html_metroberry_app/uploads/psvbadge-avatars";

            // Check if the PSV badge avatar file is uploaded
            if ($request->hasFile('psv_badge_avatar')) {
                $badgeFile = $request->file('psv_badge_avatar');
                $badgeExtension = $badgeFile->getClientOriginalExtension();
                $badgeFileName = "{$badgeNumber}-{$driver_name}-{$driver_email}-{$driver_phone}.{$badgeExtension}";

                // Move the uploaded file to the specified path
                $badgeFile->move($psvbadgeUploadpath, $badgeFileName);

                // Store the relative file path for the database
                $badgePath = 'uploads/psvbadge-avatars/' . $badgeFileName;
            }

            // Create the PSV badge record in the database
            PSVBadge::create([
                'driver_id' => $data['driver'],
                'psv_badge_no' => $badgeNumber,
                'psv_badge_date_of_issue' => $data['issue_date'],
                'psv_badge_date_of_expiry' => $data['expiry_date'],
                'psv_badge_avatar' => $badgePath,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'PSV Badge Added Successfully');
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction if an error occurs
            Log::error('PSV BADGE STORE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(PSVBadge $pSVBadge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $psvbadge = PSVBadge::findOrFail($id);
        return view('driver.psvbadge.edit', compact('psvbadge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            // Find the PSV badge from the database
            $psvbadge = PSVBadge::findOrFail($id);

            $validator = Validator::make($data, [
                'psv_badge_date_of_issue' => 'required|date',
                'psv_badge_date_of_expiry' => 'required|date|after:psv_badge_date_of_issue',
                'psv_badge_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('PSV BADGE UPDATE VALIDATION ERROR');
                Log::error($validator->errors()->all());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            if (!$psvbadge) {
                return redirect()->back()->with('error', 'PSV Badge Not Found');
            }

            $badgePath = $psvbadge->psv_badge_avatar;
            $badgeNumber = $psvbadge->psv_badge_no;

            // Get driver details
            $psvbadge_driver_id = $psvbadge->driver_id;
            $driver = Driver::findOrFail($psvbadge_driver_id);
            $driverUserId = $driver->user_id;
            $driverUser = User::findOrFail($driverUserId);
            $driver_name = $driverUser->name;
            $driver_email = $driverUser->email;
            $driver_phone = $driverUser->phone;

            DB::beginTransaction();

            // Handle new avatar upload
            $psvbadgeUploadpath = "/home/kknuicdz/public_html_metroberry_app/uploads/psvbadge-avatars";

            if ($request->hasFile('psv_badge_avatar')) {
                // Delete old avatar if exists
                if ($badgePath && file_exists($psvbadgeUploadpath . '/' . $badgePath)) {
                    unlink($psvbadgeUploadpath . '/' . $badgePath);  // Deleting old avatar from the directory
                }

                $badgeFile = $request->file('psv_badge_avatar');
                $badgeExtension = $badgeFile->getClientOriginalExtension();
                $badgeFileName = "{$badgeNumber}-{$driver_name}-{$driver_email}-{$driver_phone}-back-id.{$badgeExtension}";

                // Move the file to the specified directory
                $badgeFile->move($psvbadgeUploadpath, $badgeFileName);

                // Update badge path
                $badgePath = 'psvbadge-avatars/' . $badgeFileName;
            }

            // Update PSV Badge record
            $psvbadge->update([
                'psv_badge_date_of_issue' => $data['psv_badge_date_of_issue'],
                'psv_badge_date_of_expiry' => $data['psv_badge_date_of_expiry'],
                'psv_badge_avatar' => $badgePath,
            ]);

            // Optionally, update the driver's status
            $psvbadge->driver->status = 'inactive'; // Adjust this logic if needed
            $psvbadge->driver->save();

            DB::commit();

            return redirect()->back()->with('success', 'PSV Badge Updated Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('PSV BADGE UPDATE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }




    public function delete($id)
    {
        $psvbadge = PSVBadge::findOrFail($id);
        return view('driver.psvbadge.delete', compact('psvbadge'));
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        try {
            $psvbadge = PSVBadge::findOrFail($id);
            $driver = $psvbadge->driver;

            if (!$psvbadge) {
                return redirect()->back()->with('error', 'Badge not found');
            }

            DB::beginTransaction();

            // Get the avatar path and delete the file if it exists
            $psvbadgeUploadpath = "/home/kknuicdz/public_html_metroberry_app/uploads/psvbadge-avatars";
            $avatarPath = $psvbadgeUploadpath . '/' . $psvbadge->psv_badge_avatar;

            if (file_exists($avatarPath)) {
                unlink($avatarPath); // Delete the file
            }

            // Delete the PSV badge and update driver status
            $psvbadge->delete();
            $driver->status = 'inactive'; // Set driver status to inactive
            $driver->save();

            DB::commit();

            return redirect()->route('driver.psvbadge')->with('success', 'Badge deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE BADGE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function verify($id)
    {
        $psvbadge = PSVBadge::findOrFail($id);
        return view('driver.psvbadge.verify', compact('psvbadge'));
    }

    public function verifyStore($id)
    {
        try {

            $psvbadge = PSVBadge::findOrFail($id);

            if (!$psvbadge) {
                return redirect()->back()->with('error', 'Badge not found');
            }

            if ($psvbadge->verified) {
                return redirect()->back()->with('error', 'Badge already verified');
            }

            if ($psvbadge->psv_badge_date_of_expiry < Carbon::today()) {
                return redirect()->back()->with('error', 'Badge has expired');
            }

            if (!$psvbadge->psv_badge_avatar) {
                return redirect()->back()->with('error', 'Badge documents are missing');
            }

            DB::beginTransaction();

            $psvbadge->update([
                'verified' => true
            ]);

            DB::commit();

            return redirect()->route('driver.psvbadge')->with('success', 'Badge verified successfully');
        } catch (Exception $e) {
            Log::error('PSV BADGE VERIFY ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function revoke($id)
    {
        $psvbadge = PSVBadge::findOrFail($id);
        return view('driver.psvbadge.revoke', compact('psvbadge'));
    }

    public function revokeStore($id)
    {
        try {

            $psvbadge = PSVBadge::findOrFail($id);

            if (!$psvbadge) {
                return redirect()->back()->with('error', 'Badge not found');
            }

            if (!$psvbadge->verified) {
                return redirect()->back()->with('error', 'Badge already suspended');
            }

            DB::beginTransaction();

            $psvbadge->update([
                'verified' => false
            ]);

            $psvbadge->driver->status = 'inactive';

            DB::commit();

            return redirect()->route('driver.psvbadge')->with('success', 'Badge suspended successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('SUSPEND BADGE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new DriversPSVBadgesExport, 'psvbadges.xlsx');
    }
}
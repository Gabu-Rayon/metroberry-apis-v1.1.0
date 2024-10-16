<?php

namespace App\Http\Controllers;

use App\Exports\DriversPSVBadgesExport;
use App\Models\Driver;
use App\Models\PSVBadge;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
    // public function store(Request $request)
    // {
    //     try {
    //         $data = $request->all();

    //         $validator = Validator::make($data, [
    //             'driver' => 'required|numeric|exists:drivers,id',
    //             'psvbadge_no' => 'required|unique:psv_badges,psv_badge_no',
    //             'issue_date' => 'required|date',
    //             'expiry_date' => 'required|date|after:issue_date',
    //             'psv_badge_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //         ]);

    //         if ($validator->fails()) {
    //             Log::error('PSV BADGE STORE VALIDATION ERROR');
    //             Log::error($validator->errors()->all());
    //             return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    //         }

    //         $badgePath = null;
    //         $badgeNumber = $data['psvbadge_no'];

    //         DB::beginTransaction();

    //         if ($request->hasFile('psv_badge_avatar')) {
    //             $badgeFile = $request->file('psv_badge_avatar');
    //             $badgeExtension = $badgeFile->getClientOriginalExtension();
    //             $badgeFileName = "{$badgeNumber}-back-id.{$badgeExtension}";
    //             // Store the avatar directly in the public directory
    //             $badgePath = $badgeFile->move(public_path('uploads/psvbadge-avatars'), $badgeFileName);
    //             $badgePath = 'uploads/psvbadge-avatars/' . $badgeFileName; 
    //         }

    //         PSVBadge::create([
    //             'driver_id' => $data['driver'],
    //             'psv_badge_no' => $badgeNumber,
    //             'psv_badge_date_of_issue' => $data['issue_date'],
    //             'psv_badge_date_of_expiry' => $data['expiry_date'],
    //             'psv_badge_avatar' => $badgePath,
    //         ]);

    //         DB::commit();

    //         return redirect()->back()->with('success', 'PSV Badge Created Successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack(); // Rollback if there's an error
    //         Log::error('PSV BADGE STORE ERROR');
    //         Log::error($e);
    //         return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
    //     }
    // }


    public function store(Request $request)
    {
        try {
            $data = $request->all();

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

            DB::beginTransaction();

            if ($request->hasFile('psv_badge_avatar')) {
                $badgeFile = $request->file('psv_badge_avatar');
                $badgeExtension = $badgeFile->getClientOriginalExtension();
                $badgeFileName = "{$badgeNumber}-back-id.{$badgeExtension}";
                // Store the avatar directly in the specified directory
                $badgeFilePath = '/home/kknuicdz/portal_public_html/uploads/psvbadge-avatars';
                $badgeFile->move($badgeFilePath, $badgeFileName);
                $badgePath = 'uploads/psvbadge-avatars/' . $badgeFileName;
            }

            PSVBadge::create([
                'driver_id' => $data['driver'],
                'psv_badge_no' => $badgeNumber,
                'psv_badge_date_of_issue' => $data['issue_date'],
                'psv_badge_date_of_expiry' => $data['expiry_date'],
                'psv_badge_avatar' => $badgePath,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'PSV Badge Created Successfully');
        } catch (Exception $e) {
            DB::rollBack(); // Rollback if there's an error
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
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $data = $request->all();
    //         $psvbadge = PSVBadge::findOrFail($id);

    //         $validator = Validator::make($data, [
    //             'psv_badge_date_of_issue' => 'required|date',
    //             'psv_badge_date_of_expiry' => 'required|date|after:psv_badge_date_of_issue',
    //             'psv_badge_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //         ]);

    //         if ($validator->fails()) {
    //             Log::error('PSV BADGE UPDATE VALIDATION ERROR');
    //             Log::error($validator->errors()->all());
    //             return redirect()->back()->with('error', $validator->errors()->first());
    //         }

    //         if (!$psvbadge) {
    //             return redirect()->back()->with('error', 'PSV Badge Not Found');
    //         }

    //         $badgePath = $psvbadge->psv_badge_avatar;
    //         $badgeNumber = $psvbadge->psv_badge_no;

    //         DB::beginTransaction();

    //         // Handle new avatar upload
    //         if ($request->hasFile('psv_badge_avatar')) {
    //             // Delete old avatar if exists
    //             if ($badgePath && file_exists(public_path($badgePath))) {
    //                 unlink(public_path($badgePath));
    //             }

    //             $badgeFile = $request->file('psv_badge_avatar');
    //             $badgeExtension = $badgeFile->getClientOriginalExtension();
    //             $badgeFileName = "{$badgeNumber}-back-id.{$badgeExtension}";

    //             // Define the path in the public directory
    //             $publicPath = public_path('uploads/psvbadge-avatars');
    //             // Create the directory if it doesn't exist
    //             if (!file_exists($publicPath)) {
    //                 mkdir($publicPath, 0755, true);
    //             }

    //             // Move the file to the public directory
    //             $badgeFile->move($publicPath, $badgeFileName);
    //             $badgePath = 'uploads/psvbadge-avatars/' . $badgeFileName; // Set the relative path for database
    //         }

    //         $psvbadge->update([
    //             'psv_badge_date_of_issue' => $data['psv_badge_date_of_issue'],
    //             'psv_badge_date_of_expiry' => $data['psv_badge_date_of_expiry'],
    //             'psv_badge_avatar' => $badgePath,
    //         ]);

    //         $psvbadge->driver->status = 'inactive';
    //         $psvbadge->driver->save();

    //         DB::commit();

    //         return redirect()->back()->with('success', 'PSV Badge Updated Successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('PSV BADGE UPDATE ERROR');
    //         Log::error($e);
    //         return redirect()->back()->with('error', 'Something Went Wrong');
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
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

            DB::beginTransaction();

            // Handle new avatar upload
            if ($request->hasFile('psv_badge_avatar')) {
                // Delete old avatar if exists
                if ($badgePath && file_exists('/home/kknuicdz/portal_public_html/' . $badgePath)) {
                    unlink('/home/kknuicdz/portal_public_html/' . $badgePath);
                }

                $badgeFile = $request->file('psv_badge_avatar');
                $badgeExtension = $badgeFile->getClientOriginalExtension();
                $badgeFileName = "{$badgeNumber}-back-id.{$badgeExtension}";

                // Define the path in the specified directory
                $publicPath = '/home/kknuicdz/portal_public_html/uploads/psvbadge-avatars';
                // Create the directory if it doesn't exist
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }

                // Move the file to the specified directory
                $badgeFile->move($publicPath, $badgeFileName);
                $badgePath = 'uploads/psvbadge-avatars/' . $badgeFileName; // Set the relative path for database
            }

            $psvbadge->update([
                'psv_badge_date_of_issue' => $data['psv_badge_date_of_issue'],
                'psv_badge_date_of_expiry' => $data['psv_badge_date_of_expiry'],
                'psv_badge_avatar' => $badgePath,
            ]);

            $psvbadge->driver->status = 'inactive';
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
    // public function destroy($id)
    // {
    //     try {
    //         $psvbadge = PSVBadge::findOrFail($id);
    //         $driver = $psvbadge->driver;

    //         if (!$psvbadge) {
    //             return redirect()->back()->with('error', 'Badge not found');
    //         }

    //         DB::beginTransaction();

    //         // Get the avatar path and delete the file if it exists
    //         $avatarPath = public_path($psvbadge->psv_badge_avatar);
    //         if (file_exists($avatarPath)) {
    //             unlink($avatarPath); // Delete the file
    //         }

    //         $psvbadge->delete();
    //         $driver->status = 'inactive';
    //         $driver->save();

    //         DB::commit();

    //         return redirect()->route('driver.psvbadge')->with('success', 'Badge deleted successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('DELETE BADGE ERROR');
    //         Log::error($e);
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }


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
            $avatarPath = '/home/kknuicdz/portal_public_html/' . $psvbadge->psv_badge_avatar;
            if (file_exists($avatarPath)) {
                unlink($avatarPath); // Delete the file
            }

            $psvbadge->delete();
            $driver->status = 'inactive';
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
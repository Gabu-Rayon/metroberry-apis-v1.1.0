<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\PSVBadge;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Models\VehicleInsurance;
use Illuminate\Support\Facades\DB;
use App\Exports\OrganisationExport;
use App\Imports\OrganisationImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Charts\MaintenanceCostReport;
use App\Models\NTSAInspectionCertificate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\DriversLicenses;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function dashboard()
    {
        $user = Auth::user();
        $organisation = Organisation::where('user_id', $user->id)->first();

        $activeVehicles = Vehicle::where('status', 'active')
            ->where('organisation_id', $organisation->id)
            ->get();

        $inactiveVehicles = Vehicle::where('organisation_id', $organisation->id)
            ->where('status', 'inactive')
            ->get();

        $organisationCode = $organisation->organisation_code;
        $tripsThisMonth = Trip::whereMonth('created_at', date('m'))
            ->whereHas('customer', function ($query) use ($organisationCode) {
                $query->where('customer_organisation_code', $organisationCode);
            })
            ->get();

        $tripCounts = $tripsThisMonth->groupBy('status')->map->count();

        $scheduledTripsCount = $tripCounts->get('scheduled', 0);
        $completedTripsCount = $tripCounts->get('completed', 0);
        $cancelledTripsCount = $tripCounts->get('cancelled', 0);
        $billedTripsCount = $tripCounts->get('billed', 0);

        $totalExpenses = $tripsThisMonth->where('status', 'billed')->sum('total_price');

        $venDiagram = new MaintenanceCostReport;
        $venDiagram->labels(['Scheduled', 'Completed', 'Cancelled', 'Billed']);
        $venDiagram->dataset('Trips', 'doughnut', [
            $scheduledTripsCount,
            $completedTripsCount,
            $cancelledTripsCount,
            $billedTripsCount,
        ])->options([
            'backgroundColor' => ['#198754', '#0d6efd', '#dc3545', '#ffc107'],
            'scales' => [
                'y' => ['display' => false],
                'x' => ['display' => false],
            ],
        ]);

        $today = Carbon::today()->toDateString();

        $expiredInsurances = VehicleInsurance::whereHas('vehicle', function ($query) use ($organisation) {
            $query->where('organisation_id', $organisation->id);
        })->where('insurance_date_of_expiry', '<', $today)->get();

        $expiredInspectionCertificates = NTSAInspectionCertificate::whereHas('vehicle', function ($query) use ($organisation) {
            $query->where('organisation_id', $organisation->id);
        })->where('ntsa_inspection_certificate_date_of_expiry', '<', $today)->get();

        $expiredLicenses = DriversLicenses::whereHas('driver', function ($query) use ($organisation) {
            $query->where('organisation_id', $organisation->id);
        })->where('driving_license_date_of_expiry', '<', $today)->get();

        $expiredPSVBadges = PSVBadge::whereHas('driver', function ($query) use ($organisation) {
            $query->where('organisation_id', $organisation->id);
        })->where('psv_badge_date_of_expiry', '<', $today)->get();

        return view('organisation.dashboard', compact(
            'activeVehicles',
            'inactiveVehicles',
            'scheduledTripsCount',
            'completedTripsCount',
            'cancelledTripsCount',
            'billedTripsCount',
            'totalExpenses',
            'venDiagram',
            'expiredInsurances',
            'expiredInspectionCertificates',
            'expiredLicenses',
            'expiredPSVBadges'
        ));
    }

    public function index()
    {

        $organisations = Organisation::where('created_by', Auth::user()->id)->get();
        return view('organisation.index', compact('organisations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('organisation.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email|unique:users',
                'address' => 'required|string',
                'logo' => 'required|file|mimes:jpeg,jpg,png,gif,webp|max:2048',
                'organisation_certificate' => 'required|file|mimes:pdf|max:2048',
                'organisation_code' => 'required|string|unique:organisations',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $logoPath = null;
            $email = $data['email'];
            $generatedPassword =  $data['password'];
            Log::info('password Generated for this  Organisation : ');

            Log::info($generatedPassword);

            if ($request->hasFile('logo')) {
                $logoFile = $request->file('logo');
                $logoExtension = $logoFile->getClientOriginalExtension();
                $logoFileName = "{$email}-avatar.{$logoExtension}";
                $logoPath = $logoFile->storeAs('uploads/company-logos', $logoFileName, 'public');
            }

            if ($request->hasFile('organisation_certificate')) {
                $certificateFile = $request->file('organisation_certificate');
                $certificateExtension = $certificateFile->getClientOriginalExtension();
                $certificateFileName = "{$email}-certificate.{$certificateExtension}";
                $certificatePath = $certificateFile->storeAs('uploads/organisation-certificates', $certificateFileName, 'public');
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
                'address' => $data['address'],
                'role' => 'organisation',
                'avatar' => $logoPath,
                'created_by' => Auth::user()->id
            ]);

            $user->assignRole('organisation');

            Organisation::create([
                'user_id' => $user->id,
                'certificate_of_organisation' => $certificatePath,
                'billing_cycle' => null,
                'terms_and_conditions' => null,
                'created_by' => Auth::user()->id,
                'organisation_code' => $data['organisation_code']
            ]);

            DB::commit();


            // Send email with the plain password
            Mail::send('mail-view.organisation-welcome-mail', [
                'organisation' => $user->name,
                'email' => $user->email,
                'password' => $generatedPassword
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your Account Created');
            });

            return redirect()->route('organisation')->with('success', 'Organisation created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error Creating Organisation');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred while creating organisation')->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Log::info('Fetching Organisation');
        $organisation = Organisation::where('id', $id)->first();
        Log::info('Organisation Fetched');
        Log::info($organisation);
        return view('organisation.show', compact('organisation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $organisation = Organisation::findOrfail($id);
        return view('organisation.edit', compact('organisation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $organisation = Organisation::findOrfail($id);
            $user = User::findOrfail($organisation->user_id);

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'address' => 'required|string',
                'logo' => 'file|mimes:jpeg,jpg,png,gif,webp|max:2048',
                'certificate_of_organisation' => 'file|mimes:pdf|max:2048',
                'organisation_code' => 'required|string|unique:organisations,organisation_code,' . $organisation->id,
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERRORS');
                Log::info($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            DB::beginTransaction();

            $logoPath = $user->avatar;

            if ($request->hasFile('logo')) {
                $logoFile = $request->file('logo');
                $logoExtension = $logoFile->getClientOriginalExtension();
                $logoFileName = "{$user->email}-avatar.{$logoExtension}";
                $logoPath = $logoFile->storeAs('uploads/company-logos', $logoFileName, 'public');
            }

            if ($request->hasFile('certificate_of_organisation')) {
                $certificateFile = $request->file('certificate_of_organisation');
                $certificateExtension = $certificateFile->getClientOriginalExtension();
                $certificateFileName = "{$user->email}-certificate.{$certificateExtension}";
                $certificatePath = $certificateFile->storeAs('uploads/organisation-certificates', $certificateFileName, 'public');
            }

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'avatar' => $logoPath
            ]);

            $organisation->update([
                'certificate_of_organisation' => $certificatePath ?? $organisation->certificate_of_organisation,
                'organisation_code' => $data['organisation_code']
            ]);

            DB::commit();

            return redirect()->route('organisation')->with('success', 'Organisation updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR UPDATING Organisation');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred while updating organisation');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $organisation = Organisation::findOrFail($id);
        return view('organisation.delete', compact('organisation'));
    }

    // Handle the deletion
    public function destroy(string $id)
    {
        try {
            $organisation = Organisation::findOrFail($id);

            if (!$organisation) {
                return redirect()->back()->with('error', 'Organisation not found');
            }

            $user = User::find($organisation->user_id);

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            DB::beginTransaction();

            // Delete related files
            $certificatesPath = public_path('uploads/organisation-certificates/' . $organisation->id);
            $logosPath = public_path('uploads/company-logos/' . $organisation->id);

            // Check if the directories exist and delete them
            if (File::exists($certificatesPath)) {
                File::deleteDirectory($certificatesPath);
            }

            if (File::exists($logosPath)) {
                File::deleteDirectory($logosPath);
            }

            // Delete the organisation and user
            $organisation->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('organisation')->with('success', 'Organisation deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR DELETING Organisation');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred while deleting organisation');
        }
    }

    public function activateForm(string $id)
    {
        $organisation = Organisation::findOrfail($id);
        return view('organisation.activate', compact('organisation'));
    }

    public function activate($id)
    {
        try {

            $organisation = Organisation::findOrfail($id);

            if (!$organisation) {
                return redirect()->back()->with('error', 'Organisation not found');
            }

            if ($organisation->status == 'active') {
                return redirect()->back()->with('error', 'Organisation is already active');
            }

            if (!$organisation->certificate_of_organisation) {
                return redirect()->back()->with('error', 'Missing Documents');
            }

            DB::beginTransaction();

            $organisation->update([
                'status' => 'active'
            ]);

            DB::commit();

            return redirect()->route('organisation')->with('success', 'Organisation activated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR ACTIVATING Organisation');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function deactivateForm($id)
    {
        $organisation = Organisation::findOrfail($id);
        return view('organisation.deactivate', compact('organisation'));
    }

    public function deactivate($id)
    {
        try {

            $organisation = Organisation::findOrfail($id);

            if (!$organisation) {
                return redirect()->back()->with('error', 'Organisation not found');
            }

            if ($organisation->status == 'inactive') {
                return redirect()->back()->with('error', 'Organisation is already inactive');
            }

            DB::beginTransaction();

            $organisation->update([
                'status' => 'inactive'
            ]);

            DB::commit();

            return redirect()->route('organisation')->with('success', 'Organisation deactivated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR DEACTIVATING Organisation');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }



    /***
     * 
     */

    // public function export()
    // {
    //     $fileName = 'organisations' . date('Y-m-d_H-i-s') . '.xlsx';

    //     \Log::info('Exporting file: ' . $fileName);

    //     return Excel::download(new OrganisationExport, $fileName);
    // }

    public function export()
    {
        return Excel::download(new OrganisationExport, 'organisations.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }




    /**
     * 
     *Import organisation detials 

     */
    public function importFile()
    {
        return view('organisation.importOrganisation');
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
            Excel::import(new OrganisationImport, $request->file('file'));

            // Log the import event
            Log::info('Organisation CSV file imported: ', ['file' => $request->file('file')]);

            //log 
            Log::info('Organisation CSV file imported : ');
            Log::info($request->file('file'));

            return redirect()->back()->with('success', 'Records imported successfully.');
        } catch (Exception $e) {
            Log::error('Error importing organisations: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while importing the organisation records.');
        }
    }
}

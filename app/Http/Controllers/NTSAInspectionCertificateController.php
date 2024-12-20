<?php

namespace App\Http\Controllers;

use App\Exports\NTSAInspectionCertificateExport;
use App\Models\Expense;
use App\Models\NTSAInspectionCertificate;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;


class NTSAInspectionCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificates = NTSAInspectionCertificate::all();
        $vehicles = Vehicle::doesntHave('inspectionCertificates')->get();
        return view('vehicle.inspection-certificates.index', compact('certificates', 'vehicles'));
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

            $validator = Validator::make($data, [
                'vehicle' => 'required|exists:vehicles,id',
                'ntsa_inspection_certificate_date_of_issue' => 'required|date',
                'ntsa_inspection_certificate_no' => 'required|string|unique:ntsa_inspection_certificates,ntsa_inspection_certificate_no',
                'ntsa_inspection_certificate_date_of_expiry' => 'required|date',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'cost' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return back()->with('error', $validator->errors()->first())->withInput();
            }

            Log::info('NTSA INSPECTION CERTIFICATE DATA');
            Log::info($data);

            DB::beginTransaction();

            $avatarPath = null;
            $certNo = $data['ntsa_inspection_certificate_no'];

        $vehicle = Vehicle::findOrFail($request->vehicle);
            $plate_number = $vehicle->plate_number;
            $vehicle_model = $vehicle->model;

            // Generate a unique filename for the avatar
            $avatarFile = $request->file('avatar');
            $avatarExtension = $avatarFile->getClientOriginalExtension();
            $avatarFileName = "{$certNo}-{$plate_number}-{$vehicle_model}-inspection-certificate.{$avatarExtension}";

            // Define the path where the avatar will be stored
            $baseUploadPath = './public/public_html_metroberry_app/uploads';
            $avatarPath = "{$baseUploadPath}/ntsa-insp-cert-copies/{$avatarFileName}";

            // Create the directory if it doesn't exist
            if (!file_exists(dirname($avatarPath))) {
                mkdir(dirname($avatarPath), 0755, true); // Create the directory if it doesn't exist
            }

            // Store the avatar directly in the public folder
            $avatarFile->move(dirname($avatarPath), $avatarFileName); // Move the file to the correct path

            // Create the NTSA inspection certificate record
            NTSAInspectionCertificate::create([
                'vehicle_id' => $data['vehicle'],
                'creator_id' => auth()->id(),
                'ntsa_inspection_certificate_no' => $certNo,
                'ntsa_inspection_certificate_date_of_issue' => $data['ntsa_inspection_certificate_date_of_issue'],
                'ntsa_inspection_certificate_date_of_expiry' => $data['ntsa_inspection_certificate_date_of_expiry'],
                'ntsa_inspection_certificate_avatar' => 'uploads/ntsa-insp-cert-copies/' . $avatarFileName,
                'cost' => $data['cost'],
            ]);

            // Uncomment and adjust if you want to log an expense related to this certificate
            // Expense::create([
            //     'name' => 'NTSA Inspection Certificate',
            //     'amount' => $cert->cost,
            //     'category' => 'ntsa_inspection_certificate',
            //     'entry_date' => now(),
            //     'description' => 'Add NTSA Inspection Certificate for ' . $cert->vehicle->plate_number,
            // ]);

            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'Inspection Certificate added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('STORE INSPECTION CERTIFICATE ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.')->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(NTSAInspectionCertificate $nTSAInspectionCertificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vehicles = Vehicle::all();
        $certificate = NTSAInspectionCertificate::find($id);
        return view('vehicle.inspection-certificates.edit', compact('certificate', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'vehicle' => 'required|exists:vehicles,id',
                'ntsa_inspection_certificate_date_of_issue' => 'required|date',
                'ntsa_inspection_certificate_no' => 'required|string|unique:ntsa_inspection_certificates,ntsa_inspection_certificate_no,' . $id,
                'ntsa_inspection_certificate_date_of_expiry' => 'required|date',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return back()->with('error', $validator->errors()->first());
            }

            DB::beginTransaction();

            $certificate = NTSAInspectionCertificate::findOrFail($id); // Use findOrFail for better error handling

            $avatarPath = $certificate->ntsa_inspection_certificate_avatar; // Keep the existing path initially
            $certNo = $data['ntsa_inspection_certificate_no'];
            
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            $plate_number = $vehicle->plate_number;
            $vehicle_model = $vehicle->model;


            // Check if a new avatar file is uploaded
            if ($request->hasFile('avatar')) {
                // Remove the old avatar file if it exists
                if (File::exists(public_path($avatarPath))) {
                    File::delete(public_path($avatarPath));
                }

                // Upload new avatar file
                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$certNo}-{$plate_number}-{$vehicle_model}-avatar.{$avatarExtension}";

                // Define the path for the new avatar
                $baseUploadPath = './public/public_html_metroberry_app/uploads';
                $avatarPath = "{$baseUploadPath}/ntsa-insp-cert-copies/{$avatarFileName}";

                // Create the directory if it doesn't exist
                if (!file_exists(dirname($avatarPath))) {
                    mkdir(dirname($avatarPath), 0755, true); // Create the directory if it doesn't exist
                }

                // Move the new avatar file to the specified path
                $avatarFile->move(dirname($avatarPath), $avatarFileName); // Move the file
            }

            // Update the certificate
            $certificate->update([
                'vehicle_id' => $data['vehicle'],
                'creator_id' => auth()->id(),
                'ntsa_inspection_certificate_no' => $certNo,
                'ntsa_inspection_certificate_date_of_issue' => $data['ntsa_inspection_certificate_date_of_issue'],
                'ntsa_inspection_certificate_date_of_expiry' => $data['ntsa_inspection_certificate_date_of_expiry'],
                'ntsa_inspection_certificate_avatar' => 'uploads/ntsa-insp-cert-copies/' . $avatarFileName, // Save the relative path
                'verified' => false,
            ]);

            $certificate->vehicle->status = 'inactive';
            $certificate->vehicle->save();

            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'Inspection Certificate updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE INSPECTION CERTIFICATE ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }


    public function verifyForm($id)
    {
        $certificate = NTSAInspectionCertificate::find($id);
        return view('vehicle.inspection-certificates.verify', compact('certificate'));
    }

    public function verify($id)
    {
        try {
            $certificate = NTSAInspectionCertificate::findOrFail($id);
            $expired = strtotime($certificate->ntsa_inspection_certificate_date_of_expiry) < strtotime(date('Y-m-d'));

            if ($expired) {
                return back()->with('error', 'Inspection Certificate has expired.');
            }

            if ($certificate->verified) {
                return back()->with('error', 'Inspection Certificate already verified.');
            }

            DB::beginTransaction();

            $certificate->update([
                'verified' => true,
            ]);

            $certificate->save();

            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'Inspection Certificate verified successfully.');
        } catch (Exception $e) {
            Log::error('VERIFY INSPECTION CERTIFICATE ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function suspendForm($id)
    {
        $certificate = NTSAInspectionCertificate::find($id);
        return view('vehicle.inspection-certificates.suspend', compact('certificate'));
    }

    public function suspend($id)
    {
        try {
            $certificate = NTSAInspectionCertificate::findOrFail($id);

            if (!$certificate->verified) {
                return back()->with('error', 'Inspection Certificate already suspended.');
            }

            DB::beginTransaction();

            $certificate->update([
                'verified' => false,
            ]);

            $certificate->vehicle->status = 'inactive';

            $certificate->save();
            $certificate->vehicle->save();

            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'Inspection Certificate suspended successfully.');
        } catch (Exception $e) {
            Log::error('SUSPEND INSPECTION CERTIFICATE ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $certificate = NTSAInspectionCertificate::find($id);
        return view('vehicle.inspection-certificates.delete', compact('certificate'));
    }


    public function destroy($id)
    {
        try {
            $certificate = NTSAInspectionCertificate::findOrFail($id);

            DB::beginTransaction();

            // Change vehicle status to inactive
            $certificate->vehicle->status = 'inactive';
            $certificate->vehicle->save();

            // Define the path to the avatar
            $avatarPath = './public/public_html_metroberry_app/' . $certificate->ntsa_inspection_certificate_avatar;

            // Delete the associated image from the specified directory
            if (File::exists($avatarPath)) {
                File::delete($avatarPath);
            }

            // Delete the inspection certificate
            $certificate->delete();

            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'Inspection Certificate deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE INSPECTION CERTIFICATE ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }



    public function export()
    {
        return Excel::download(new NTSAInspectionCertificateExport, 'ntsa-inspection-certificates.xlsx');
    }
    public function renew($id)
    {
        $certificate = NTSAInspectionCertificate::findOrFail($id);
        return view('vehicle.inspection-certificates.renew', compact('certificate'));
    }

    public function renewPost($id)
    {
        try {
            $certificate = NTSAInspectionCertificate::findOrFail($id);

            $data = request()->all();

            $validator = Validator::make($data, [
                'issue_date' => 'required|date',
                'certificate_copy' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'expiry_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return back()->with('error', $validator->errors()->first());
            }

            DB::beginTransaction();

            $certificate->update([
                'ntsa_inspection_certificate_date_of_issue' => $data['issue_date'],
                'ntsa_inspection_certificate_date_of_expiry' => $data['expiry_date'],
                'ntsa_inspection_certificate_avatar' => $data['certificate_copy'],
                'verified' => false,
            ]);

            $certificate->vehicle->status = 'inactive';

            $certificate->save();
            $certificate->vehicle->save();

            Expense::create([
                'name' => 'NTSA Inspection Certificate',
                'amount' => $certificate->cost,
                'category' => 'ntsa_inspection_certificate',
                'entry_date' => now(),
                'description' => 'Renew NTSA Inspection Certificate for ' . $certificate->vehicle->plate_number,
            ]);

            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'Inspection Certificate renewed successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('RENEW INSPECTION CERTIFICATE ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }
}
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
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Make avatar optional in case it's not updated
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

            // Define the path where the avatar will be stored
            $NtsaIspectionCertUploadpath = "/home/kknuicdz/public_html_metroberry_app/uploads/ntsa-insp-cert-copies";

            // Check if a new avatar file is provided
            if ($request->hasFile('avatar')) {
                // Generate a unique filename for the avatar
                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$certNo}-{$plate_number}-{$vehicle_model}-inspection-certificate.{$avatarExtension}";

                // Set the full avatar path
                $avatarPath = "{$NtsaIspectionCertUploadpath}/{$avatarFileName}";

                // Store the avatar directly in the specified path
                $avatarFile->move($NtsaIspectionCertUploadpath, $avatarFileName); // Move the file to the correct path
            }

            // Create a new NTSA inspection certificate record
            $inspectionCertificate = new NTSAInspectionCertificate();
            $inspectionCertificate->vehicle_id = $data['vehicle'];
            $inspectionCertificate->creator_id = auth()->id();
            $inspectionCertificate->ntsa_inspection_certificate_no = $certNo;
            $inspectionCertificate->ntsa_inspection_certificate_date_of_issue = $data['ntsa_inspection_certificate_date_of_issue'];
            $inspectionCertificate->ntsa_inspection_certificate_date_of_expiry = $data['ntsa_inspection_certificate_date_of_expiry'];
            $inspectionCertificate->ntsa_inspection_certificate_avatar = $avatarPath ? 'uploads/ntsa-insp-cert-copies/' . basename($avatarPath) : null;
            $inspectionCertificate->cost = $data['cost'];
            $inspectionCertificate->save();

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

            // Validation rules
            $validator = Validator::make($data, [
                'vehicle' => 'required|exists:vehicles,id',
                'ntsa_inspection_certificate_date_of_issue' => 'required|date',
                'ntsa_inspection_certificate_no' => 'required|string|unique:ntsa_inspection_certificates,ntsa_inspection_certificate_no,' . $id,
                'ntsa_inspection_certificate_date_of_expiry' => 'required|date',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // If validation fails
            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return back()->with('error', $validator->errors()->first());
            }

            DB::beginTransaction();

            // Find the NTSA inspection certificate
            $certificate = NTSAInspectionCertificate::findOrFail($id);

            // Save the current avatar path for deletion if a new one is uploaded
            $avatarPath = $certificate->ntsa_inspection_certificate_avatar;
            $certNo = $data['ntsa_inspection_certificate_no'];

            // Retrieve the associated vehicle
            $vehicle = Vehicle::findOrFail($data['vehicle']);
            $plate_number = $vehicle->plate_number;
            $vehicle_model = $vehicle->model;

            // Define the upload path for the new avatar
            $NtsaIspectionCertUploadpath = "/home/kknuicdz/public_html_metroberry_app/uploads/ntsa-insp-cert-copies";

            // Handle the new avatar file upload, if any
            if ($request->hasFile('avatar')) {
                // Remove the old avatar file if it exists
                if (File::exists(public_path($avatarPath))) {
                    File::delete(public_path($avatarPath));
                }

                // Get the uploaded avatar file
                $avatarFile = $request->file('avatar');
                $avatarExtension = $avatarFile->getClientOriginalExtension();
                $avatarFileName = "{$certNo}-{$plate_number}-{$vehicle_model}-avatar.{$avatarExtension}";

                // Move the new avatar file to the target directory
                $avatarFile->move($NtsaIspectionCertUploadpath, $avatarFileName);

                // Save the relative file path in the database
                $avatarPath = "uploads/ntsa-insp-cert-copies/{$avatarFileName}";
            }

            // Update the certificate with the new data
            $certificate->update([
                'vehicle_id' => $data['vehicle'],
                'creator_id' => auth()->id(),
                'ntsa_inspection_certificate_no' => $certNo,
                'ntsa_inspection_certificate_date_of_issue' => $data['ntsa_inspection_certificate_date_of_issue'],
                'ntsa_inspection_certificate_date_of_expiry' => $data['ntsa_inspection_certificate_date_of_expiry'],
                'ntsa_inspection_certificate_avatar' => $avatarPath,
                'verified' => false,
            ]);

            // Update the vehicle status to inactive
            $certificate->vehicle->status = 'inactive';
            $certificate->vehicle->save();

            // Commit the transaction
            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'Inspection Certificate updated successfully.');
        } catch (Exception $e) {
            // Rollback the transaction in case of error
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

            // Define the path to the inspection certificate
            $NtsaIspectionCertUploadpath = "/home/kknuicdz/public_html_metroberry_app/uploads/ntsa-insp-cert-copies";

            // Check if the associated certificate file exists, then delete it
            if ($certificate->file_name && File::exists($NtsaIspectionCertUploadpath . '/' . $certificate->file_name)) {
                // Delete the associated file
                File::delete($NtsaIspectionCertUploadpath . '/' . $certificate->file_name);
            }

            // Delete the inspection certificate record
            $certificate->delete();

            DB::commit();

            return redirect()->route('vehicle.inspection.certificate')->with('success', 'NTSA Inspection Certificate deleted successfully.');
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
<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use Exception;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\SpeedGovernorExport;
use App\Imports\SpeedGovernorImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\VehicleSpeedGovernorCertificate;



class VehicleSpeedGovernorCertificateController extends Controller
{
    public function index()
    {
        $speed_governors = VehicleSpeedGovernorCertificate::with('vehicle')->get();
        $vehicles = Vehicle::doesntHave('speedGovernorCertificates')->get();
        return view('vehicle-speed-governor-certificates.index', compact('speed_governors', 'vehicles'));
    }


    public function store(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Data For Creating a New Vehicle Speed Governor Certificate: ' . json_encode($data));

            Log::info('DATA');
            Log::info($data);

            $validator = Validator::make($data, [
                'vehicle_id' => 'required|exists:vehicles,id',
                'class_no' => 'required|in:A,B',
                'installation_date' => 'required|date',
                'certificate_no' => 'required',
                'type' => 'required',
                'expiry_date' => 'required|date',
                'chasis_no' => 'required',
                'copy' => 'required|file|mimes:png,jpg,jpeg,webp',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION FAILED');
                Log::info($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            // Fetch vehicle details
            $vehicle = Vehicle::findOrFail($data['vehicle_id']);
            $vehicle_model = $vehicle->model;
            $vehicle_plate_number = $vehicle->plate_number;

            // Define the absolute directory for storing the copy
            $avatarDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/speed-governor-cert-copies/';

            // Create the directory if it does not exist
            if (!File::exists($avatarDirectory)) {
                File::makeDirectory($avatarDirectory, 0755, true);
            }

            $driverVehicleSpeedGovernorDocPath = null;

            if ($request->hasFile('copy')) {
                $file = $request->file('copy');
                $fileName = "{$vehicle_model}-{$vehicle_plate_number}-{$data['certificate_no']}.{$file->getClientOriginalExtension()}";
                $driverVehicleSpeedGovernorDocPath = 'uploads/speed-governor-cert-copies/' . $fileName;
                $destinationPath = $avatarDirectory;

                // Move the file to the specified absolute directory
                $file->move($destinationPath, $fileName);
            }

            Log::info('The Driver vehicle Speed Governor Certificate Document path to be uploaded: ', [$driverVehicleSpeedGovernorDocPath]);

            // Create a new Vehicle Speed Governor Certificate record
            VehicleSpeedGovernorCertificate::create([
                'certificate_no' => $data['certificate_no'],
                'vehicle_id' => $data['vehicle_id'],
                'class_no' => $data['class_no'],
                'type_of_governor' => $data['type'],
                'date_of_installation' => $data['installation_date'],
                'expiry_date' => $data['expiry_date'],
                'certificate_copy' => $driverVehicleSpeedGovernorDocPath,
                'chasis_no' => $data['chasis_no'],
                'status' => 'inactive',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Vehicle Speed Governor Certificate added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SOMETHING WENT WRONG');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function edit($id)
    {
        $vehicles = Vehicle::all();
        $certificate = VehicleSpeedGovernorCertificate::find($id);
        return view('vehicle-speed-governor-certificates.edit', compact('certificate', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            // Validate the incoming data
            $validator = Validator::make($data, [
                'vehicle_id' => 'exists:vehicles,id',
                'certificate_no' => 'string',
                'class_no' => 'in:A,B',
                'type_of_governor' => 'string',
                'date_of_installation' => 'date',
                'expiry_date' => 'date',
                'certificate_copy' => 'file|mimes:png,jpg,jpeg,webp',
                'chasis_no' => 'string',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return back()->with('error', $validator->errors()->first());
            }

            DB::beginTransaction();

            // Fetch the existing certificate
            $certificate = VehicleSpeedGovernorCertificate::findOrFail($id);

            // Fetch the vehicle details
            $vehicle = Vehicle::findOrFail($data['vehicle_id']);
            $vehicle_model = $vehicle->model;
            $vehicle_plate_number = $vehicle->plate_number;

            // Define the absolute directory for storing the certificate copy
            $avatarDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/speed-governor-cert-copies/';

            // Ensure the directory exists
            if (!File::exists($avatarDirectory)) {
                File::makeDirectory($avatarDirectory, 0755, true);
            }

            // Store the document path for the certificate
            $driverVehicleSpeedGovernorDocPath = $certificate->certificate_copy;

            // Check if a new file is uploaded
            if ($request->hasFile('certificate_copy')) {
                // Delete the old file if it exists
                if (File::exists(public_path($driverVehicleSpeedGovernorDocPath))) {
                    File::delete(public_path($driverVehicleSpeedGovernorDocPath));
                }

                // Handle the new file upload
                $file = $request->file('certificate_copy');
                $fileName = "{$vehicle_model}-{$vehicle_plate_number}-{$data['certificate_no']}.{$file->getClientOriginalExtension()}";

                // Update the file path
                $driverVehicleSpeedGovernorDocPath = 'uploads/speed-governor-cert-copies/' . $fileName;
                $destinationPath = $avatarDirectory;

                // Move the file to the specified directory
                $file->move($destinationPath, $fileName);
            }

            Log::info('The Driver vehicle Speed Governor Certificate Document path to be uploaded: ', [$driverVehicleSpeedGovernorDocPath]);

            // Update the certificate record in the database
            $certificate->update([
                'certificate_no' => $data['certificate_no'],
                'vehicle_id' => $data['vehicle_id'],
                'class_no' => $data['class_no'],
                'type_of_governor' => $data['type_of_governor'],
                'date_of_installation' => $data['date_of_installation'],
                'expiry_date' => $data['expiry_date'],
                'certificate_copy' => $driverVehicleSpeedGovernorDocPath,
                'chasis_no' => $data['chasis_no'],
                'status' => 'inactive',
            ]);

            // Update the vehicle's status
            $certificate->vehicle->status = 'inactive';
            $certificate->vehicle->save();

            DB::commit();

            return redirect()->route('vehicle.speed.governor')->with('success', 'Speed Governor updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE SPEED GOVERNOR CERTIFICATE ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }


    public function activateForm(string $id)
    {
        $certificate = VehicleSpeedGovernorCertificate::find($id);
        return view('vehicle-speed-governor-certificates.activate', compact('certificate'));
    }

    public function activate(string $id)
    {
        try {
            $certificate = VehicleSpeedGovernorCertificate::findOrFail($id);
            $expired = strtotime($certificate->expiry_date) < strtotime(date('Y-m-d'));

            if ($expired) {
                return back()->with('error', 'Speed Governor has expired.');
            }

            if ($certificate->status == 'active') {
                return back()->with('error', 'Speed Governor already verified.');
            }

            DB::beginTransaction();

            $certificate->update([
                'status' => 'active',
            ]);

            $certificate->save();

            DB::commit();

            return redirect()->route('vehicle.speed.governor')->with('success', 'Speed Governor verified successfully.');
        } catch (Exception $e) {
            Log::error('VERIFY SPEED GOVERNOR ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function deactivateForm(string $id)
    {
        $certificate = VehicleSpeedGovernorCertificate::find($id);
        return view('vehicle-speed-governor-certificates.deactivate', compact('certificate'));
    }

    public function deactivate(string $id)
    {
        try {
            $certificate = VehicleSpeedGovernorCertificate::findOrFail($id);
            $expired = strtotime($certificate->expiry_date) < strtotime(date('Y-m-d'));

            if ($expired) {
                return back()->with('error', 'Speed Governor has expired.');
            }

            if ($certificate->status == 'inactive') {
                return back()->with('error', 'Speed Governor not verified.');
            }

            DB::beginTransaction();

            $certificate->update([
                'status' => 'inactive',
            ]);

            $certificate->save();

            DB::commit();

            return redirect()->route('vehicle.speed.governor')->with('success', 'Speed Governor deactivated successfully.');
        } catch (Exception $e) {
            Log::error('DEACTIVATE SPEED GOVERNOR ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function delete($id)
    {
        $certificate = VehicleSpeedGovernorCertificate::find($id);
        return view('vehicle-speed-governor-certificates.delete', compact('certificate'));
    }


    public function destroy($id)
    {
        try {
            $certificate = VehicleSpeedGovernorCertificate::findOrFail($id);

            DB::beginTransaction();

            // Set the vehicle status to inactive
            $certificate->vehicle->status = 'inactive';
            $certificate->vehicle->save();

            // Define the absolute path for the certificate copy
            $avatarDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/speed-governor-cert-copies/';
            $avatarPath = $avatarDirectory . $certificate->copy;

            // Check if the file exists and delete it
            if (File::exists($avatarPath)) {
                File::delete($avatarPath);
            }

            // Delete the certificate record
            $certificate->delete();

            DB::commit();

            return redirect()->route('vehicle.speed.governor')->with('success', 'Speed Governor Certificate deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE SPEED GOVERNOR ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function export()
    {
        return Excel::download(new SpeedGovernorExport, 'speed-governors.xlsx');
    }

    public function import()
    {
        return view('vehicle-speed-governor-certificates.import');
    }

    public function importStore(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt,xlsx',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            Excel::import(new SpeedGovernorImport, $request->file('file'));

            Log::info('Data from SpeedGovernorImport CSV File being Imported: ', ['file' => $request->file('file')]);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Records imported successfully.');
        } catch (Exception $e) {
            // Log the error
            Log::error('Error importing Speed Governors: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'An error occurred while importing the Speed Governors records.');
        }
    }
}
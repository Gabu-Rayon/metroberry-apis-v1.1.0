<?php

namespace App\Http\Controllers;
use App\Models\VehicleSpeedGovernorCertificate;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VehicleSpeedGovernorCertificateController extends Controller
{
    public function index()
    {
        $speed_governors = VehicleSpeedGovernorCertificate::with('vehicle')->get();
        $vehicles = Vehicle::doesntHave('speedGovernorCertificates')->get();
        return view('vehicle-speed-governor-certificates.index', compact('speed_governors', 'vehicles'));
    }

    public function store(Request $request) {
        try {
            $data = $request->all();

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

            
            $avatarPath = '';

            $avatarDirectory = '/home/kknuicdz/public_html_metroberry_app/uploads/vehicle-speed-governor-copy/';

            if (!File::exists($avatarDirectory)) {
                File::makeDirectory($avatarDirectory, 0755, true);
            }

            $avatarName = $request->certificate_no . '-copy.' . $request->file('copy')->getClientOriginalExtension();

            $request->file('copy')->move($avatarDirectory, $avatarName);

            $avatarPath = 'uploads/vehicle-speed-governor-copy/' . $avatarName;

            VehicleSpeedGovernorCertificate::create([
                'vehicle_id' => $data['vehicle_id'],
                'class_no' => $data['class_no'],
                'installation_date' => $data['installation_date'],
                'certificate_no' => $data['certificate_no'],
                'type' => $data['type'],
                'expiry_date' => $data['expiry_date'],
                'chasis_no' => $data['chasis_no'],
                'copy' => $avatarPath,
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

    public function activateForm(string $id) {
        $certificate = VehicleSpeedGovernorCertificate::find($id);
        return view('vehicle-speed-governor-certificates.activate', compact('certificate'));
    }

    public function activate(string $id) {
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

    public function deactivateForm(string $id) {
        $certificate = VehicleSpeedGovernorCertificate::find($id);
        return view('vehicle-speed-governor-certificates.deactivate', compact('certificate'));
    }

    public function deactivate(string $id) {
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

            $certificate->vehicle->status = 'inactive';
            $certificate->vehicle->save();

            $avatarPath = '/home/kknuicdz/public_html_metroberry_app/' . $certificate->copy;

            if (File::exists($avatarPath)) {
                File::delete($avatarPath);
            }

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
}

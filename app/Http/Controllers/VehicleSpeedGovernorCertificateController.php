<?php

namespace App\Http\Controllers;
use App\Models\VehicleSpeedGovernorCertificate;

use Illuminate\Http\Request;

class VehicleSpeedGovernorCertificateController extends Controller
{
    public function index()
    {
        $speed_governors = VehicleSpeedGovernorCertificate::all();
        return view('vehicle-speed-governor-certificates.index', compact('speed_governors'));
    }
}

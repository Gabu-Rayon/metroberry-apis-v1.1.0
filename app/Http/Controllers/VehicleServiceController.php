<?php

namespace App\Http\Controllers;

use App\Models\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VehicleServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $vehicleServices = VehicleService::all();
        // return response()->json($vehicleServices);

        $vehicleServices = VehicleService::all();
        return view('vehicle.maintenance.index',compact('vehicleServices'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicle.maintenance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'servicing_company_name' => 'required|string',
            'servicing_company_address' => 'required|string',
            'servicing_company_contact' => 'required|string',
            'servicing_company_email' => 'nullable|email',
            'servicing_done' => 'required|boolean',
            'total_repairs' => 'required|string',
            'total_repairs_costs' => 'required|numeric',
            'payment_type_code' => 'required|string',
            'invoice_no' => 'required|string',
            'company_invoice_no' => 'required|string',
            'servicing_date' => 'required|date',
            'invoice_qr_code_url' => 'required|string',
        ]);

        $data['created_by'] = Auth::id();

        $vehicleService = VehicleService::create($data);

        return response()->json([
            'message' => 'Vehicle service created successfully',
            'vehicleService' => $vehicleService,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicleService = VehicleService::findOrFail($id);
        return response()->json($vehicleService);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehicleService = VehicleService::findOrFail($id);
        // If using a form, return a view with the vehicle service data
        // return view('vehicle_services.edit', compact('vehicleService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'servicing_company_name' => 'required|string',
            'servicing_company_address' => 'required|string',
            'servicing_company_contact' => 'required|string',
            'servicing_company_email' => 'nullable|email',
            'servicing_done' => 'required|boolean',
            'total_repairs' => 'required|string',
            'total_repairs_costs' => 'required|numeric',
            'payment_type_code' => 'required|string',
            'invoice_no' => 'required|string',
            'company_invoice_no' => 'required|string',
            'servicing_date' => 'required|date',
            'invoice_qr_code_url' => 'required|string',
        ]);

        $vehicleService = VehicleService::findOrFail($id);
        $vehicleService->update($data);

        return response()->json([
            'message' => 'Vehicle service updated successfully',
            'vehicleService' => $vehicleService,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicleService = VehicleService::findOrFail($id);
        $vehicleService->delete();

        return response()->json([
            'message' => 'Vehicle service deleted successfully',
        ]);
    }
}
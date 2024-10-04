<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InsuranceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $vehicleId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $vehicleId)
    {
        try {
            Log::info("Request for Updating vehicle Insurance : " . $request);
            // Find the vehicle by its ID
            $vehicle = Vehicle::findOrFail($vehicleId);

            Log::info(" vehicle ID being updated Insurance : " . $vehicle);

            // Validate the request data
            $data = $request->validate([
                'vehicle_insurance_issue_date' => 'nullable|date_format:Y-m-d',
                'vehicle_insurance_expiry' => 'nullable|date_format:Y-m-d',
                'vehicle_insurance_issue_organisation' => 'nullable|string',
            ]);


            // Update vehicle insurance details
            $vehicle->update([
                'vehicle_insurance_issue_date' => $data['vehicle_insurance_issue_date'],
                'vehicle_insurance_expiry' => $data['vehicle_insurance_expiry'],
                'vehicle_insurance_issue_organisation' => $data['vehicle_insurance_issue_organisation'],
            ]);

            // Return success response
            return response()->json([
                'message' => 'Vehicle Insurance updated successfully',
                'vehicle' => $vehicle
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Vehicle not found with ID: ' . $vehicleId);
            return response()->json([
                'message' => 'Vehicle not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            Log::error('Error updating vehicle insurance');
            Log::error($e);
            return response()->json([
                'message' => 'Error occurred while updating vehicle insurance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}

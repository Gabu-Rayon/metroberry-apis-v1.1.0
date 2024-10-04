<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripPricing;

class TripPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tripPricings = TripPricing::all();
        return response()->json($tripPricings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method is typically used to show a form in a web application, not needed for an API
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ride_type_id' => 'required|exists:ride_types,id',
            'base_price' => 'required|numeric',
            'price_per_km' => 'required|numeric',
            'price_per_minute' => 'required|numeric'
        ]);

        $tripPricing = TripPricing::create($request->all());

        return response()->json([
            'message' => 'Trip pricing created successfully',
            'tripPricing' => $tripPricing
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tripPricing = TripPricing::findOrFail($id);
        return response()->json($tripPricing);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // This method is typically used to show a form in a web application, not needed for an API
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ride_type_id' => 'required|exists:ride_types,id',
            'base_price' => 'required|numeric',
            'price_per_km' => 'required|numeric',
            'price_per_minute' => 'required|numeric'
        ]);

        $tripPricing = TripPricing::findOrFail($id);
        $tripPricing->update($request->all());

        return response()->json([
            'message' => 'Trip pricing updated successfully',
            'tripPricing' => $tripPricing
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tripPricing = TripPricing::findOrFail($id);
        $tripPricing->delete();

        return response()->json([
            'message' => 'Trip pricing deleted successfully'
        ], 200);
    }
}
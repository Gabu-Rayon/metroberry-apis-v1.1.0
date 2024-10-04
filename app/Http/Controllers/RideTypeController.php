<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RideType;

class RideTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rideTypes = RideType::all();
        return response()->json($rideTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $rideType = RideType::create([
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id()
        ]);

        return response()->json($rideType, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rideType = RideType::findOrFail($id);
        return response()->json($rideType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $rideType = RideType::findOrFail($id);

        $rideType->update([
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return response()->json($rideType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rideType = RideType::findOrFail($id);
        $rideType->delete();

        return response()->json(null, 204);
    }
}
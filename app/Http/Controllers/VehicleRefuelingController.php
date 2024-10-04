<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\RefuellingStation;
use App\Models\Vehicle;
use App\Models\VehicleRefueling;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleRefuelingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $refuelings = VehicleRefueling::all();
        $vehicles = Vehicle::all();
        $stations = RefuellingStation::where('status', 'active')->get();
        return view('refueling.index', compact('refuelings', 'vehicles', 'stations'));
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
                'vehicle' => 'required|numeric|exists:vehicles,id',
                'date' => 'required|date',
                'volume' => 'required|numeric',
                'attendant_name' => 'required|string',
                'station' => 'required|numeric|exists:refuelling_stations,id',
                'time' => 'required|string',
                'cost' => 'required|numeric',
                'attendant_phone' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            VehicleRefueling::create([
                'vehicle_id' => $data['vehicle'],
                'refuelling_date' => $data['date'],
                'refuelling_volume' => $data['volume'],
                'attendant_name' => $data['attendant_name'],
                'refuelling_station_id' => $data['station'],
                'refuelling_time' => $data['time'],
                'refuelling_cost' => $data['cost'],
                'attendant_phone' => $data['attendant_phone'],
                'creator_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('refueling.index')->with('success', 'Vehicle refueling created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('STORE VEHICLE REFUELING ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong')->withInput();
        }
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
        $refueling = VehicleRefueling::find($id);
        $vehicles = Vehicle::all();
        $stations = RefuellingStation::where('status', 'active')->get();
        return view('refueling.edit', compact('refueling', 'vehicles', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->all();

            Log::info('DATA');
            Log::info($data);

            $validator = Validator::make($data, [
                'vehicle_id' => 'required|numeric|exists:vehicles,id',
                'refuelling_date' => 'required|date',
                'refuelling_volume' => 'required|numeric',
                'attendant_name' => 'required|string',
                'refuelling_station_id' => 'required|numeric|exists:refuelling_stations,id',
                'refuelling_time' => 'required|string',
                'refuelling_cost' => 'required|numeric',
                'attendant_phone' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $refueling = VehicleRefueling::find($id);

            $refueling->update([
                'vehicle_id' => $data['vehicle_id'],
                'refuelling_date' => $data['refuelling_date'],
                'refuelling_volume' => $data['refuelling_volume'],
                'attendant_name' => $data['attendant_name'],
                'refuelling_station_id' => $data['refuelling_station_id'],
                'refuelling_time' => $data['refuelling_time'],
                'refuelling_cost' => $data['refuelling_cost'],
                'attendant_phone' => $data['attendant_phone'],
            ]);

            DB::commit();

            return redirect()->route('refueling.index')->with('success', 'Vehicle refueling updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE VEHICLE REFUELING ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong')->withInput();
        }
    }

    public function approveForm(string $id)
    {
        $refueling = VehicleRefueling::find($id);
        return view('refueling.approve', compact('refueling'));
    }

    public function approve(string $id)
    {
        try {

            DB::beginTransaction();

            $refueling = VehicleRefueling::find($id);

            $refueling->update([
                'status' => 'approved',
            ]);

            DB::commit();

            return redirect()->route('refueling.index')->with('success', 'Vehicle refueling updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('APPROVE VEHICLE REFUELING ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong');
        }
    }

    public function billForm(string $id)
    {
        $refueling = VehicleRefueling::find($id);
        return view('refueling.bill', compact('refueling'));
    }

    public function bill(string $id)
    {
        try {

            DB::beginTransaction();

            $refueling = VehicleRefueling::find($id);

            $refueling->update([
                'status' => 'billed',
            ]);

            Expense::create([
                'name' => 'Refuelling Vehicle',
                'amount' => $refueling->refuelling_cost,
                'category' => 'fuel',
                'entry_date' => now(),
                'description' => 'Refuelling vehicle ' . $refueling->vehicle->plate_number . ' with ' . $refueling->refuelling_volume . ' litres of fuel',
            ]);

            DB::commit();

            return redirect()->route('refueling.index')->with('success', 'Vehicle refueling updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('BILL VEHICLE REFUELING ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong');
        }
    }

    public function rejectForm(string $id)
    {
        $refueling = VehicleRefueling::find($id);
        return view('refueling.reject', compact('refueling'));
    }

    public function reject(string $id)
    {
        try {

            DB::beginTransaction();

            $refueling = VehicleRefueling::find($id);

            $refueling->update([
                'status' => 'rejected',
            ]);

            DB::commit();

            return redirect()->route('refueling.index')->with('success', 'Vehicle refueling updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('REJECT VEHICLE REFUELING ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong');
        }
    }

    public function redoForm(string $id)
    {
        $refueling = VehicleRefueling::find($id);
        return view('refueling.redo', compact('refueling'));
    }

    public function redo(Request $request, string $id)
    {
        try {

            $data = $request->all();
            $refueling = VehicleRefueling::find($id);

            $validator = Validator::make($data, [
                'refuelling_date' => 'required|date',
                'refuelling_time' => 'required|string',
                'attendant_name' => 'required|string',
                'attendant_phone' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            VehicleRefueling::create([
                'vehicle_id' => $refueling->vehicle_id,
                'refuelling_date' => $data['refuelling_date'],
                'refuelling_volume' => $refueling->refuelling_volume,
                'attendant_name' => $data['attendant_name'],
                'refuelling_station_id' => $refueling->refuelling_station_id,
                'refuelling_time' => $data['refuelling_time'],
                'refuelling_cost' => $refueling->refuelling_cost,
                'attendant_phone' => $data['attendant_phone'],
                'creator_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('refueling.index')->with('success', 'Vehicle refueling updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('REDO VEHICLE REFUELING ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(string $id)
    {
        $refueling = VehicleRefueling::find($id);
        return view('refueling.delete', compact('refueling'));
    }

    public function destroy(string $id)
    {
        try {
            $refueling = VehicleRefueling::findOrFail($id);

            if (!$refueling) {
                return back()->with('error', 'Vehicle refueling not found');
            }

            if ($refueling->status == 'rejected') {
                return back()->with('error', 'Cannot delete a rejected transaction');
            }

            if ($refueling->status == 'billed') {
                return back()->with('error', 'Cannot delete a billed transaction');
            }

            DB::beginTransaction();

            $refueling->delete();

            DB::commit();

            return redirect()->route('refueling.index')->with('success', 'Vehicle refueling deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE VEHICLE REFUELING ERROR');
            Log::error($e);
            return back()->with('error', 'Something went wrong');
        }
    }
}

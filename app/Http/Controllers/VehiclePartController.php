<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\VehiclePart;
use App\Models\VehiclePartCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehiclePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parts = VehiclePart::all();
        $categories = VehiclePartCategory::all();
        return view('vehicle.maintenance.parts.index', compact('parts', 'categories'));
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
                'name' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:vehicle_part_categories,id',
                'model_number' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'compatibility' => 'required|string',
                'sku' => 'required|string|max:255|unique:vehicle_parts,sku',
                'brand' => 'required|string|max:255',
                'price' => 'required|numeric',
                'condition' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
            }

            DB::beginTransaction();

            $vclprt = VehiclePart::create([
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'model_number' => $data['model_number'],
                'quantity' => $data['quantity'],
                'compatibility' => $data['compatibility'],
                'sku' => $data['sku'],
                'brand' => $data['brand'],
                'price' => $data['price'],
                'condition' => $data['condition'],
                'notes' => $data['notes'],
            ]);

            Expense::create([
                'name' => 'Vehicle Part Purchase',
                'amount' => $vclprt['price'] * $vclprt['quantity'],
                'category' => 'vehicle_parts_purchase',
                'entry_date' => now(),
                'description' => 'Purchased ' . $vclprt['quantity'] . ' ' . $vclprt['name'] . ' vehicle parts',
            ]);

            DB::commit();

            return redirect()->route('vehicle.maintenance.parts')->with('success', 'Vehicle Part Added Successfully');
        } catch (Exception $e) {
            Log::info('STORE VEHICLE PART ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $part = VehiclePart::find($id);
        $categories = VehiclePartCategory::all();
        return view('vehicle.maintenance.parts.edit', compact('part', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:vehicle_part_categories,id',
                'model_number' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'compatibility' => 'required|string',
                'sku' => 'required|string|max:255|unique:vehicle_parts,sku,' . $id,
                'brand' => 'required|string|max:255',
                'price' => 'required|numeric',
                'condition' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
            }

            DB::beginTransaction();

            $part = VehiclePart::find($id);
            $part->name = $data['name'];
            $part->category_id = $data['category_id'];
            $part->model_number = $data['model_number'];
            $part->quantity = $data['quantity'];
            $part->compatibility = $data['compatibility'];
            $part->sku = $data['sku'];
            $part->brand = $data['brand'];
            $part->price = $data['price'];
            $part->condition = $data['condition'];
            $part->notes = $data['notes'];
            $part->save();

            DB::commit();

            return redirect()->route('vehicle.maintenance.parts')->with('success', 'Vehicle Part Updated Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('UPDATE VEHICLE PART ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $part = VehiclePart::find($id);
        return view('vehicle.maintenance.parts.delete', compact('part'));
    }
    public function destroy(string $id)
    {
        try {
            $part = VehiclePart::findOrFail($id);

            DB::beginTransaction();

            $part->delete();

            DB::commit();
            return redirect()->route('vehicle.maintenance.parts')->with('success', 'Vehicle Part Deleted Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('DELETE VEHICLE PART ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function add($id) {
        $part = VehiclePart::find($id);
        return view('vehicle.maintenance.parts.add', compact('part'));
    }

    public function addPost(Request $request, $id) {
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'quantity' => 'required|integer',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
            }

            DB::beginTransaction();

            $part = VehiclePart::find($id);
            $part->quantity += $data['quantity'];
            $part->save();

            Expense::create([
                'name' => 'Vehicle Part Purchase',
                'amount' => $part['price'] * $data['quantity'],
                'category' => 'vehicle_parts_purchase',
                'entry_date' => now(),
                'description' => 'Purchased ' . $data['quantity'] . ' ' . $part['name'] . ' vehicle parts',
            ]);

            DB::commit();

            return redirect()->route('vehicle.maintenance.parts')->with('success', 'Vehicle Part Added Successfully');
        } catch (Exception $e) {
            Log::info('ADD VEHICLE PART ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
        }
    }
}

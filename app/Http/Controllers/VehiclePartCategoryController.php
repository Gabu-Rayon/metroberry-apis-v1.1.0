<?php

namespace App\Http\Controllers;

use App\Models\VehiclePartCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehiclePartCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $categories = VehiclePartCategory::all();
        return view('vehicle.maintenance.parts.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('vehicle.maintenance.parts.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            VehiclePartCategory::create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            DB::commit();

            return redirect()->route('vehicle.maintenance.parts.category')->with('success', 'Vehicle part category created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('STORE VEHICLE PART CATEGORY ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Failed to create vehicle part category');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VehiclePartCategory $vehiclePartCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $category = VehiclePartCategory::find($id);
        return view('vehicle.maintenance.parts.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $category = VehiclePartCategory::findOrFail($id);

            $category->update([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            DB::commit();

            return redirect()->route('vehicle.maintenance.parts.category')->with('success', 'Vehicle part category updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE VEHICLE PART CATEGORY ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Failed to update vehicle part category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete ($id) {
        $category = VehiclePartCategory::find($id);
        return view('vehicle.maintenance.parts.category.delete', compact('category'));
    }

    public function destroy($id){
        try {

            $vehiclePartCategory = VehiclePartCategory::findOrFail($id);
            
            DB::beginTransaction();

            $vehiclePartCategory->delete();

            DB::commit();

            return redirect()->route('vehicle.maintenance.parts.category')->with('success', 'Vehicle part category deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE VEHICLE PART CATEGORY ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Failed to delete vehicle part category');
        }
    }
}

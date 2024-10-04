<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use App\Models\ServiceTypeCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceCategories = ServiceTypeCategory::all();
        $serviceTypes = ServiceType::all();
        return view('vehicle.maintenance.service.categories.index', compact('serviceCategories', 'serviceTypes'));
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
                'description' => 'required|string|max:255',
                'serviceType' => 'required|exists:service_types,id',
            ]);

            if ($validator->fails()) {
                Log::error('STORE SERVICE CATEGORY VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            ServiceTypeCategory::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'service_type_id' => $data['serviceType'],
            ]);

            DB::commit();

            return redirect()->route('vehicle.maintenance.service.categories')->with('success', 'Service Category created successfully');
        } catch (Exception $e) {
            Log::info('STORE SERVICE CATEGORY ERROR');
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
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
        $serviceCategory = ServiceTypeCategory::find($id);
        $serviceTypes = ServiceType::all();
        return view('vehicle.maintenance.service.categories.edit', compact('serviceCategory', 'serviceTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'serviceType' => 'required|exists:service_types,id',
            ]);

            if ($validator->fails()) {
                Log::error('UPDATE SERVICE CATEGORY VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $serviceCategory = ServiceTypeCategory::find($id);
            $serviceCategory->name = $data['name'];
            $serviceCategory->description = $data['description'];
            $serviceCategory->service_type_id = $data['serviceType'];
            $serviceCategory->save();

            DB::commit();

            return redirect()->route('vehicle.maintenance.service.categories')->with('success', 'Service Category updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('UPDATE SERVICE CATEGORY ERROR');
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(string $id)
    {
        $serviceCategory = ServiceTypeCategory::find($id);
        return view('vehicle.maintenance.service.categories.delete', compact('serviceCategory'));
    }
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $serviceCategory = ServiceTypeCategory::findOrfail($id);
            $serviceCategory->delete();

            DB::commit();

            return redirect()->route('vehicle.maintenance.service.categories')->with('success', 'Service Category deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('DELETE SERVICE CATEGORY ERROR');
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}

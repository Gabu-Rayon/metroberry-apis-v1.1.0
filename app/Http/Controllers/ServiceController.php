<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use App\Models\ServiceTypeCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceTypes = ServiceType::all();
        return view('vehicle.maintenance.service.index', compact('serviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicle.maintenance.service.create');
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
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
            }

            DB::beginTransaction();

            ServiceType::create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            DB::commit();

            return redirect()->route('vehicle.maintenance.service')->with('success', 'Service Type Created Successfully');
        } catch (Exception $e) {
            Log::error('ERROR STORING SERVICE TYPE');
            lOG::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
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
        $serviceType = ServiceType::findOrfail($id);
        return view('vehicle.maintenance.service.edit', compact('serviceType'));
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
            ]);

            if ($validator->fails()) {
                Log::error('UPDATE SERVICE TYPE VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
            }

            DB::beginTransaction();

            $serviceType = ServiceType::findOrfail($id);
            $serviceType->update([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            DB::commit();

            return redirect()->route('vehicle.maintenance.service')->with('success', 'Service Type Updated Successfully');
        } catch (Exception $e) {
            Log::error('ERROR UPDATING SERVICE TYPE');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $serviceType = ServiceType::findOrfail($id);
        return view('vehicle.maintenance.service.delete', compact('serviceType'));
    }
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $serviceType = ServiceType::findOrfail($id);
            $serviceType->delete();

            DB::commit();

            return redirect()->route('vehicle.maintenance.service')->with('success', 'Service Type Deleted Successfully');
        } catch (Exception $e) {
            Log::error('ERROR DELETING SERVICE TYPE');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function getServiceCategories($serviceTypeId)
    {
        $categories = ServiceTypeCategory::where('service_type_id', $serviceTypeId)->get();
        return response()->json($categories);
    }
}

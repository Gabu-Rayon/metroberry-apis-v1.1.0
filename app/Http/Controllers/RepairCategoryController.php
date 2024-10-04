<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\RepairCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RepairCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairCategories = RepairCategory::all();
        $repairTypes = Repair::all();
        return view('vehicle.maintenance.repairs.categories.index', compact('repairCategories', 'repairTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'repair_id' => 'required|integer|exists:repairs,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::info('STORE REPAIR CATEGORY VALIDATION ERROR');
                Log::info($validator->errors());
                return redirect()->back()->with('error', 'Something went wrong.')->withInput();
            }

            DB::beginTransaction();

            RepairCategory::create($data);

            DB::commit();

            return redirect()->route('vehicle.maintenance.repairs.categories')->with('success', 'Repair category created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('STORE REPAIR CATEGORY ERROR');
            Log::info($e);
            return redirect()->back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairCategory $repairCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $repairCategory = RepairCategory::find($id);
        $repairTypes = Repair::all();
        return view('vehicle.maintenance.repairs.categories.edit', compact('repairCategory', 'repairTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairCategory $repairCategory)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'repair_id' => 'required|integer|exists:repairs,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::info('UPDATE REPAIR CATEGORY VALIDATION ERROR');
                Log::info($validator->errors());
                return redirect()->back()->with('error', 'Something went wrong.')->withInput();
            }

            DB::beginTransaction();

            $repairCategory->update($data);

            DB::commit();

            return redirect()->route('vehicle.maintenance.repairs.categories')->with('success', 'Repair category updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('UPDATE REPAIR CATEGORY ERROR');
            Log::info($e);
            return redirect()->back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $repairCategory = RepairCategory::find($id);
        return view('vehicle.maintenance.repairs.categories.delete', compact('repairCategory'));
    }
    public function destroy(RepairCategory $repairCategory)
    {
        try {
            DB::beginTransaction();

            $repairCategory->delete();

            DB::commit();

            return redirect()->route('vehicle.maintenance.repairs.categories')->with('success', 'Repair category deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('DELETE REPAIR CATEGORY ERROR');
            Log::info($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}

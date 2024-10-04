<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairs = Repair::all();
        return view('vehicle.maintenance.repairs.index', compact('repairs'));
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
            ]);

            if ($validator->fails()) {
                Log::error('STORE REPAIR TYPE VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Something went wrong.')->withInput();
            }

            DB::beginTransaction();

            Repair::create($data);

            DB::commit();

            return redirect()->route('vehicle.maintenance.repairs')->with('success', 'Repair type created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('STORE REPAIR TYPE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $repair = Repair::find($id);
        return view('vehicle.maintenance.repairs.edit', compact('repair'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $repair = Repair::findOrFail($id);

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::error('UPDATE REPAIR TYPE VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Something went wrong.')->withInput();
            }

            DB::beginTransaction();

            $repair->update($data);

            DB::commit();

            return redirect()->route('vehicle.maintenance.repairs')->with('success', 'Repair type updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE REPAIR TYPE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $repair = Repair::find($id);
        return view('vehicle.maintenance.repairs.delete', compact('repair'));
    }

    public function destroy(string $id)
    {
        try {
            $repair = Repair::findOrFail($id);

            DB::beginTransaction();

            $repair->delete();

            DB::commit();

            return redirect()->route('vehicle.maintenance.repairs')->with('success', 'Repair type deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE REPAIR TYPE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}

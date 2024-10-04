<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Guard;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $permissions = Permission::all();
        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::error('STORE PERMISSION VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            Permission::firstOrCreate(['name' => $data['name']]);

            return redirect()->route('permission.index')->with('success', 'Permission created successfully');
        } catch (Exception $e) {
            Log::error('STORE PERMISSION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Error while creating permission');
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
    public function edit(string $id){
        $permission = Permission::find($id);
        return view('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::error('UPDATE PERMISSION VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $permission = Permission::find($id);
            $permission->update($data);

            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Permission updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('UPDATE PERMISSION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Error while updating permission');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete ($id) {
        $permission = Permission::find($id);
        return view('permission.delete', compact('permission'));
    }

    public function destroy(string $id){
        try {
            $permission = Permission::find($id);

            DB::beginTransaction();

            $permission->delete();

            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Permission deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('DELETE PERMISSION ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Error while deleting permission');
        }
    }
}
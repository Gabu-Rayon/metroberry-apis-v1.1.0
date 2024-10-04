<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserRole;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $roles = UserRole::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        $settingPermissions = PermissionGroup::where('group_name', 'settings')->get();
        $dashboardPermissions = PermissionGroup::where('group_name', 'dashboard')->get();
        $employeePermissions = PermissionGroup::where('group_name', 'employee')->get();
        $organisationPermissions = PermissionGroup::where('group_name', 'organisation')->get();
        $driversPermissions = PermissionGroup::where('group_name', 'drivers')->get();
        $licensePermissions = PermissionGroup::where('group_name', 'license')->get();
        $psv_badgePermissions = PermissionGroup::where('group_name', 'psv_badge')->get();
        $driver_performancePermissions = PermissionGroup::where('group_name', 'driver_performance')->get();
        $vehiclePermissions = PermissionGroup::where('group_name', 'vehicle')->get();
        $vehicle_insurancePermissions = PermissionGroup::where('group_name', 'vehicle_insurance')->get();
        $routePermissions = PermissionGroup::where('group_name', 'route')->get();
        $route_locationPermissions = PermissionGroup::where('group_name', 'route_location')->get();
        $tripPermissions = PermissionGroup::where('group_name', 'trip')->get();
        $insurance_companyPermissions = PermissionGroup::where('group_name', 'insurance_company')->get();
        $vehicle_maintenancePermissions = PermissionGroup::where('group_name', 'vehicle_maintenance')->get();
        return view('role.create', compact(
            'settingPermissions',
            'dashboardPermissions',
            'employeePermissions',
            'organisationPermissions',
            'driversPermissions',
            'licensePermissions',
            'psv_badgePermissions',
            'driver_performancePermissions',
            'vehiclePermissions',
            'vehicle_insurancePermissions',
            'routePermissions',
            'route_locationPermissions',
            'tripPermissions',
            'insurance_companyPermissions',
            'vehicle_maintenancePermissions',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            
            // Validate the request data
            $data = $request->validate([
                'name' => 'required|string|unique:roles,name',
                'permissions.*.' => 'required|array',
            ]);
            Log::info('data from the form of creating new Role  with Permissions : ');
            Log::info($data);

            // Start a database transaction
            DB::beginTransaction();

            // Create a new role
            $role = UserRole::create([
                'name' => $data['name'],
                'guard_name' => 'web',
            ]);

            // Process permissions
            $permissionIds = [];
            foreach ($data['permissions'] as $key => $value) {
                $permissionGroup = PermissionGroup::where('permission_name', $key)->first();
                if ($permissionGroup) {
                    $permission = Permission::where('name', $permissionGroup->permission_name)->first();
                    if ($permission) {
                        $permissionIds[] = $permission->id;
                    }
                }
            }

            // Attach permissions to the role
            $role->permissions()->attach($permissionIds);


            // Commit the transaction
            DB::commit();

            return redirect()->route('permission.role')->with('success', 'Role created successfully');
        } catch (Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the role. Please try again.')->withInput();
        }
    }




    // public function store(Request $request)
    // {
    //     try {
    //         // Validate the request data
    //         $data = $request->validate([
    //             'name' => 'required|string|unique:roles,name',
    //             'permissions' => 'required|array',
    //         ]);

    //       Log::info('data from the form of creating new Role  with Permissions : ');
   //        Log::info($data);


    //         // Start a database transaction
    //         DB::beginTransaction();

    //         // Create a new role with guard_name set to 'web'
    //         $role = Role::create([
    //             'name' => $data['name'],
    //             'guard_name' => 'web',
    //         ]);

    //         // Process permissions
    //         $permissionIds = [];
    //         foreach ($data['permissions'] as $permissionId) {
    //             $permission = Permission::find($permissionId);
    //             if ($permission) {
    //                 $permissionIds[] = $permission->id;
    //             }
    //         }

    //         // Attach permissions to the role
    //         $role->syncPermissions($permissionIds);

    //         // Commit the transaction
    //         DB::commit();

    //         return redirect()->route('roles.index')->with('success', 'Role created successfully');
    //     } catch (Exception $e) {
    //         // Rollback the transaction if something goes wrong
    //         DB::rollBack();
    //         Log::error('Error creating role: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'An error occurred while creating the role. Please try again.')->withInput();
    //     }
    // }


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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Organisation;
use App\Models\VehicleClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;



class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the authenticated user has the 'view vehicle' permission

        try {
            $vehicles = null;

            // Check the user's role
            if (Auth::user()->role == 'admin') {
                // If the user is an admin, fetch all vehicles
                $vehicles = Vehicle::all();
            } elseif (Auth::user()->role == 'organisation') {
                // If the user is an organisation, fetch vehicles for that organisation
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $vehicles = Vehicle::with('driver')->where('organisation_id', $organisation->id)->get();
                }
            } else {
                // If the user has another role, fetch vehicles created by the user
                $vehicles = Vehicle::where('created_by', Auth::user()->id)->get();
            }

            Log::info('Vehicles fetched: ', ['vehicles' => $vehicles]);
            $organisations = Organisation::all();
            $vehicleClasses = VehicleClass::all();

            return view('vehicle.index', compact('vehicles', 'organisations', 'vehicleClasses'));
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error fetching vehicles: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while fetching the vehicles. Please try again.');
        }
    }



    /**
     * Store a newly created resource in storage.
     */


    public function create()
    {
    }
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $data = $request->all();

            $validator = Validator::make($data, [
                'model' => 'required|string|max:255',
                'make' => 'required|string|max:255',
                'year' => 'required|date',
                'color' => 'required|string|max:255',
                'seats' => 'required|string|max:255',
                'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',
                'fuel_type' => 'required|string|max:255',
                'engine_size' => 'required|numeric',
                'vehicle_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,jfif|max:2048',
                'organisation_id' => 'required|numeric',
                'vehicle_class' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR Here');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            // Log the request data
            Log::info('Vehicle store request data:', $request->all());

            // Handle the file upload
            if ($request->hasFile('vehicle_avatar')) {
                $avatarName = time() . '.' . $request->vehicle_avatar->extension();
                $request->vehicle_avatar->move(public_path('images'), $avatarName);
            }

            // Extract the year from the date input
            $year = Carbon::parse($request->year)->year;

            // Create a new vehicle record
            $vehicle = new Vehicle();
            $vehicle->created_by = Auth::user()->id;
            $vehicle->organisation_id = $request->organisation_id;
            $vehicle->model = $request->model;
            $vehicle->make = $request->make;
            $vehicle->year = $year;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
            $vehicle->class = $request->vehicle_class;
            $vehicle->plate_number = $request->plate_number;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->engine_size = $request->engine_size;
            $vehicle->avatar = $avatarName;
            $vehicle->save();

            return redirect()->route('vehicle')->with('success', 'Vehicle added successfully.');
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error adding vehicle: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while adding the vehicle. Please try again.')->withInput();
        }
    }




    // public function store(Request $request)
    // {
    //     try {
    //         $creator = Organisation::find(Auth::id());

    //         Log::info('User with role of Admin / Organisation Creating Vechile');
    //         Log::info($creator);

    //         $data = $request->validate([
    //             'make' => 'required|string',
    //             'model' => 'required|string',
    //             'year' => 'required|integer',
    //             'color' => 'required|string',
    //             'plate_number' => 'required|string',
    //             'seats' => 'required|integer',
    //             'fuel_type' => 'required|string',
    //             'engine_size' => 'required|string',
    //         ]);

    //         Log::info('VEHICLE VALIDATION DATA');
    //         Log::info($data);

    //         DB::beginTransaction();

    //         $organisation = Organisation::find(Auth::id());

    //         Log::info('Who is creating the Vehicle : ' . $organisation);

    //         $vehicle = Vehicle::create([
    //             'organisation_id' => $organisation->id,
    //             'make' => $data['make'],
    //             'model' => $data['model'],
    //             'year' => $data['year'],
    //             'color' => $data['color'],
    //             'plate_number' => $data['plate_number'],
    //             'seats' => $data['seats'],
    //             'fuel_type' => $data['fuel_type'],
    //             'engine_size' => $data['engine_size'],
    //             'created_by' => Auth::id(),
    //             'status' => 'inactive'
    //         ]);

    //         Log::info('VEHICLE');
    //         Log::info($vehicle);

    //         DB::commit();

    //         return response()->json([
    //             'message' => 'Vehicle created successfully',
    //             'vehicle' => $vehicle
    //         ], 201);

    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('ERROR CREATING VEHICLE');
    //         Log::error($e);
    //         return response()->json([
    //             'message' => 'Error occurred while creating vehicle',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    /**
     * Display the specified resource.
     */
    public function show($vehicleId, Request $request)
    {
        try {
            // Retrieve the vehicle with related creator and driver details
            $vehicle = Vehicle::with([
                'creator:id,name,email',
                'driver.user:id,name,email'
            ])->findOrFail($vehicleId);

            Log::info('Vehicle details from the API:', $vehicle->toArray());

            $response = [
                'id' => $vehicle->id,
                'make' => $vehicle->make,
                'model' => $vehicle->model,
                'year' => $vehicle->year,
                'color' => $vehicle->color,
                'plate_number' => $vehicle->plate_number,
                'seats' => $vehicle->seats,
                'fuel_type' => $vehicle->fuel_type,
                'engine_size' => $vehicle->engine_size,
                'organisation_id' => $vehicle->engine_size,
                'vehicle_insurance_issue_date' => $vehicle->vehicle_insurance_issue_date,
                'vehicle_insurance_expiry' => $vehicle->vehicle_insurance_expiry,
                'vehicle_insurance_issue_organisation' => $vehicle->vehicle_insurance_issue_organisation,
                'vehicle_avatar' => $vehicle->vehicle_avatar,
                'status' => 'inactive',
                'creator' => [
                    'id' => $vehicle->creator->id,
                    'name' => $vehicle->creator->name,
                    'email' => $vehicle->creator->email,
                    'address' => $vehicle->creator->address,
                ],
                'driver' => $vehicle->driver ? [
                    'id' => $vehicle->driver->user->id,
                    'name' => $vehicle->driver->user->name,
                    'email' => $vehicle->driver->user->email,
                    'address' => $vehicle->driver->user->address,
                ] : null,

                // 'organisation' => $vehicle->driver ? [
                //     'id' => $vehicle->driver->user->id,
                //     'name' => $vehicle->driver->user->name,
                //     'email' => $vehicle->driver->user->email,
                //     'address' => $vehicle->driver->user->address,
                // ] : null,
            ];

            return response()->json([
                'vehicle' => $response
            ], 200);
        } catch (Exception $e) {
            Log::error('ERROR FETCHING VEHICLE');
            Log::error($e);
            return response()->json([
                'message' => 'Error occurred while fetching vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function edit($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $drivers = Driver::all();
            $organisations = Organisation::all();
            $vehicleClasses = VehicleClass::all();

            // Fetch the assigned Organisation's name if exists
            $assignedOrganisationName = null;
            if ($vehicle->organisation_id) {
                $organisation = Organisation::with('user')->findOrFail($vehicle->organisation_id);
                $assignedOrganisationName = $organisation->user->name;
            }

            // Fetch the assigned driver's name if exists
            $assignedDriverName = null;
            if ($vehicle->driver_id) {
                $driver = Driver::with('user')->findOrFail($vehicle->driver_id);
                $assignedDriverName = $driver->user->name;
            }

            // Fetch the assigned vehicle class name if exists
            $assignedVehicleClass = null;
            if ($vehicle->class) {
                $vehicleClass = VehicleClass::where('name', $vehicle->class)->first();
                $assignedVehicleClass = $vehicleClass ? $vehicleClass->name : null;
            }


            return view('vehicle.edit', compact('vehicle', 'assignedDriverName', 'drivers', 'assignedOrganisationName', 'organisations', 'assignedVehicleClass', 'vehicleClasses'));
        } catch (Exception $e) {
            Log::error('Error fetching vehicle for edit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the vehicle. Please try again.');
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            // Log the request data
            Log::info('Vehicle update request data From the from :', $data);

            $validator = Validator::make($data, [
                'model' => 'required|string|max:255',
                'make' => 'required|string|max:255',
                'year' => 'required|date_format:Y',
                'color' => 'required|string|max:255',
                'seats' => 'required|integer|min:1',
                'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' . $id,
                'fuel_type' => 'required|string|max:255',
                'engine_size' => 'required|numeric',
                'vehicle_avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'driver_id' => 'nullable|exists:drivers,id',
                'organisation_id'  => 'nullable|exists:organisations,id',
                'vehicle_class' => 'required|string'
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR Here');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }


            // Log the request data
            Log::info('Vehicle update request data:', $request->all());

            // Find the existing vehicle record
            $vehicle = Vehicle::findOrFail($id);

            // Handle the file upload if a new file is provided
            if ($request->hasFile('vehicle_avatar')) {
                $avatarName = time() . '.' . $request->vehicle_avatar->extension();
                $request->vehicle_avatar->move(public_path('images'), $avatarName);
                $vehicle->avatar = $avatarName;
            }

            // Update the vehicle record
            $vehicle->model = $request->model;
            $vehicle->make = $request->make;
            $vehicle->year = $request->year;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
            $vehicle->plate_number = $request->plate_number;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->engine_size = $request->engine_size;
            $vehicle->organisation_id = $request->organisation_id;
            $vehicle->class = $request->vehicle_class;
            $vehicle->status = 'inactive';

            // Update driver_id in vehicles table if provided
            if ($request->has('driver_id')) {
                $driverId = $request->input('driver_id');
                $vehicle->driver_id = $driverId;

                // Update vehicle_id in drivers table
                if ($driverId) {
                    $driver = Driver::findOrFail($driverId);
                    $driver->vehicle_id = $vehicle->id;
                    $driver->save();
                }
            } else {
                // Clear driver_id if no driver is selected
                $vehicle->driver_id = null;
            }

            $vehicle->save();

            return redirect()->route('vehicle')->with('success', 'Vehicle updated successfully.');
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error updating vehicle: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while updating the vehicle. Please try again.');
        }
    }


    // public function update(Request $request, $vehicleId)
    // {
    //     try {
    //         // Find the vehicle by its ID
    //         $vehicle = Vehicle::find($vehicleId);

    //         // Check if the vehicle exists
    //         if (!$vehicle) {
    //             return response()->json([
    //                 'message' => 'Vehicle not found',
    //             ], 404);
    //         }

    //         // Use Gate to check if the authenticated user can edit the vehicle
    //         if (Gate::denies('edit-vehicle', $vehicle)) {
    //             return response()->json([
    //                 'message' => 'Unauthorized',
    //             ], 401);
    //         }


    //         // Validate the request data
    //         $data = $request->validate([
    //             'make' => 'required|string',
    //             'model' => 'required|string',
    //             'year' => 'required|integer',
    //             'color' => 'required|string',
    //             'plate_number' => 'required|string',
    //             'seats' => 'required|integer',
    //             'fuel_type' => 'required|string',
    //             'engine_size' => 'required|string',
    //             'organisation_id' => 'required|integer',
    //             'vehicle_insurance_issue_date' => 'nullable|date_format:Y-m-d',
    //             'vehicle_insurance_expiry' => 'nullable|date_format:Y-m-d',
    //             'vehicle_insurance_issue_organisation' => 'nullable|string',
    //             'vehicle_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);

    //         // Update the vehicle attributes
    //         $vehicle->make = $data['make'];
    //         $vehicle->model = $data['model'];
    //         $vehicle->year = $data['year'];
    //         $vehicle->color = $data['color'];
    //         $vehicle->plate_number = $data['plate_number'];
    //         $vehicle->seats = $data['seats'];
    //         $vehicle->fuel_type = $data['fuel_type'];
    //         $vehicle->engine_size = $data['engine_size'];

    //         $vehicle->organisation_id = $data['organisation_id'];
    //         $vehicle->vehicle_insurance_issue_date = $data['vehicle_insurance_issue_date'];
    //         $vehicle->vehicle_insurance_expiry = $data['vehicle_insurance_expiry'];
    //         $vehicle->vehicle_insurance_issue_organisation = $data['vehicle_insurance_issue_organisation'];
    //         $vehicle->vehicle_avatar = $data['vehicle_avatar'];

    //         // Handle vehicle avatar update if provided
    //         if ($request->hasFile('vehicle_avatar')) {
    //             $avatarPath = $request->file('vehicle_avatar')->store('VehicleAvatars', 'public');
    //             $vehicle->vehicle_avatar = $avatarPath;
    //         }

    //         // Save the updated vehicle
    //         $vehicle->save();

    //         // Return success response
    //         return response()->json([
    //             'message' => 'Vehicle updated successfully',
    //             'vehicle' => $vehicle
    //         ], 200);

    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         Log::error('Vehicle not found with ID: ' . $vehicleId);
    //         return response()->json([
    //             'message' => 'Vehicle not found',
    //             'error' => $e->getMessage()
    //         ], 404);
    //     } catch (Exception $e) {
    //         Log::error('ERROR UPDATING VEHICLE');
    //         Log::error($e);
    //         return response()->json([
    //             'message' => 'Error occurred while updating vehicle',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle.delete', compact('vehicle'));
    }

    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            return redirect()->route('vehicle')->with('success', 'Vehicle deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting Vehicle: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the Vehicle. Please try again.');
        }
    }
    /**
     * Assign driver to vehicle
     * 
     */

    // public function assign_driver($vehicle, Request $request) {
    //     try {

    //         $car = Vehicle::find($vehicle);

    //         Log::info("Vechile being Assign on:" . $car );

    //         $organisation = Organisation::where('user_id', auth()->user()->id)->first();

    //         Log::info("org  Assigning Vehicle:" . $organisation);

    //         $data = $request->validate([

    //             'driver_id' => 'required|integer'
    //         ]);

    //         if (!$car) {
    //             return response()->json([
    //                 'error' => 'Vehicle not found'
    //             ], 404);
    //         }

    //         if ($car->status === 'active') {
    //             return response()->json([
    //                 'error' => 'Vehicle already has a driver'
    //             ], 400);
    //         }

    //         if (!$organisation) {
    //             return response()->json([
    //                 'message' => 'Unauthorised',
    //             ], 401);
    //         }

    //         if ($car->organisation_id !== $organisation->id) {
    //             return response()->json([
    //                 'message' => 'Unauthorised',
    //             ], 401);
    //         }

    //         $driver = Driver::find($data['driver_id']);

    //         if (!$driver) {
    //             return response()->json([
    //                 'error' => 'Driver not found'
    //             ], 404);
    //         }

    //         if ($driver->vehicle) {
    //             return response()->json([
    //                 'error' => 'Driver already has a vehicle'
    //             ], 400);
    //         }

    //         if (!$driver->license) {
    //             return response()->json([
    //                 'error' => 'Driver has no license'
    //             ], 400);
    //         }

    //         if (!$driver->license_expiry || strtotime($driver->license_expiry) < time()) {
    //             return response()->json([
    //                 'error' => 'Driver license has expired'
    //             ], 400);
    //         }

    //         $car->driver_id = $driver->id;
    //         $car->status = 'active';
    //         $car->save();

    //         return response()->json([
    //             'message' => 'Driver assigned to vehicle successfully',
    //             'vehicle' => $car
    //         ], 200);

    //     } catch (Exception $e) {
    //         Log::error('ERROR ASSIGNING DRIVER TO VEHICLE');
    //         Log::error($e);
    //         return response()->json([
    //             'message' => 'Error occurred while assigning driver to vehicle',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }



    public function assignDriverForm($id, Request $request)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $drivers = Driver::where('status', 'active')
                ->whereNull('vehicle_id')
                ->get();
            return view('vehicle.assign-driver', compact('vehicle', 'drivers'));
        } catch (Exception $e) {
            Log::error('Error fetching vehicle for Assigning: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch vehicle details.');
        }
    }

    public function assignDriver($id, Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        try {
            $vehicle = Vehicle::with('insurance')->findOrFail($id);
            $driver = Driver::findOrFail($request->input('driver_id'));

            // Check if the vehicle has valid insurance
            if (!$vehicle->insurance) {
                return redirect()->back()->with('error', 'Vehicle has no insurance.');
            }

            $insurance = $vehicle->insurance;
            $today = now()->toDateString();
            $insuranceStartDate = $insurance->insurance_date_of_issue;
            $insuranceEndDate = $insurance->insurance_date_of_expiry;

            // Validate insurance dates
            if ($today < $insuranceStartDate || $today > $insuranceEndDate) {
                return redirect()->back()->with('error', 'Insurance is not valid today.');
            }

            // Check if insurance status is active
            if ($insurance->status != 1) {
                return redirect()->back()->with('error', 'Insurance is not active.');
            }

            // Assign driver to vehicle
            $vehicle->driver_id = $driver->id;
            $vehicle->save();

            // Update driver with vehicle_id
            $driver->vehicle_id = $vehicle->id;
            $driver->save();

            return redirect()->route('vehicle')->with('success', 'Driver assigned successfully.');
        } catch (Exception $e) {
            Log::error('Error assigning driver to vehicle: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to assign driver.');
        }
    }


    public function activate_vehicle($id)
    {
        try {
            $vehicle = Vehicle::find($id);

            if (!$vehicle) {
                return response()->json([
                    'error' => 'Vehicle not found'
                ], 404);
            }

            $vehicle->status = 'active';
            $vehicle->save();

            return response()->json([
                'message' => 'Vehicle activated successfully',
                'vehicle' => $vehicle
            ], 200);
        } catch (Exception $e) {
            Log::error('ERROR ACTIVATING VEHICLE');
            Log::error($e);
            return response()->json([
                'message' => 'Error occurred while activating vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deactivate_vehicle($id)
    {
        try {
            $vehicle = Vehicle::find($id);

            if (!$vehicle) {
                return response()->json([
                    'error' => 'Vehicle not found'
                ], 404);
            }

            $vehicle->status = 'inactive';
            $vehicle->save();

            return response()->json([
                'message' => 'Vehicle deactivated successfully',
                'vehicle' => $vehicle
            ], 200);
        } catch (Exception $e) {
            Log::error('ERROR DEACTIVATING VEHICLE');
            Log::error($e);
            return response()->json([
                'message' => 'Error occurred while deactivating vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function vehicleInsurance()
    {
        return view('vehicle.insurance');
    }

    public function activateForm($id)
    {
        $vehicle = Vehicle::findOrfail($id);
        return view('vehicle.activate', compact('vehicle'));
    }


    public function activate($id)
    {
        try {
            // Fetch the vehicle with its insurance and inspection certificates details
            $vehicle = Vehicle::with(['insurance', 'inspectionCertificates'])->findOrFail($id);

            Log::info('VEHICLE');
            Log::info($vehicle);

            // Check if the vehicle is already active
            if ($vehicle->status == 'active') {
                return redirect()->back()->with('error', 'Vehicle is already active');
            }

            // Validate insurance details
            $insurance = $vehicle->insurance;
            if (!$insurance) {
                return redirect()->back()->with('error', 'Vehicle has no insurance');
            }

            $today = now()->toDateString();
            if ($today < $insurance->insurance_date_of_issue || $today > $insurance->insurance_date_of_expiry) {
                return redirect()->back()->with('error', 'Insurance is not valid today');
            }

            if ($insurance->status != 1) {
                return redirect()->back()->with('error', 'Insurance is not active');
            }

            // Validate inspection certificates
            $inspectionCertificates = $vehicle->inspectionCertificates;
            if ($inspectionCertificates->isEmpty()) {
                return redirect()->back()->with('error', 'Vehicle has no inspection certificate');
            }

            $validCertificateFound = false;
            foreach ($inspectionCertificates as $certificate) {
                if ($today >= $certificate->ntsa_inspection_certificate_date_of_issue && $today <= $certificate->ntsa_inspection_certificate_date_of_expiry && $certificate->verified == 1) {
                    $validCertificateFound = true;
                    break;
                }
            }

            if (!$validCertificateFound) {
                return redirect()->back()->with('error', 'No valid and active inspection certificate found');
            }

            // Activate the vehicle
            DB::beginTransaction();

            $vehicle->status = 'active';
            $vehicle->save();

            DB::commit();

            return redirect()->route('vehicle')->with('success', 'Vehicle activated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ACTIVATE VEHICLE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred while activating the vehicle');
        }
    }



    public function deactivateForm($id)
    {
        $vehicle = Vehicle::findOrfail($id);
        return view('vehicle.deactivate', compact('vehicle'));
    }


    public function deactivate($id)
    {
        try {

            $vehicle = Vehicle::findOrfail($id);

            if ($vehicle->status == 'inactive') {
                return redirect()->back()->with('error', 'Vehicle is already inactive');
            }

            DB::beginTransaction();

            $vehicle->status = 'inactive';

            $vehicle->save();

            DB::commit();

            return redirect()->route('vehicle')->with('success', 'Vehicle deactivated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('VEHICLE DRIVER ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred');
        }
    }
}

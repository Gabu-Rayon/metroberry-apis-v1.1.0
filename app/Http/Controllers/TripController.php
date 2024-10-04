<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Exception;
use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Routes;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\TripPayment;
use App\Models\BillingRates;
use App\Models\Driver;
use App\Models\Organisation;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\View;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //     public function index(){
    //         $scheduledTrips = Trip::with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
    //             ->where('status', 'scheduled')
    //             ->orderBy('pick_up_time')
    //             ->get()
    //             ->groupBy(function ($trip) {
    //                 return $trip->customer->user->organisation->name;
    //             });

    //         $scheduledTrips = $scheduledTrips->groupBy(function ($trip) {
    //             return $trip->customer->organization;
    //         });

    //         Log::info('SCHEDULED TRIPS');
    //         Log::info($scheduledTrips);

    //         return view('trips.scheduled', compact('scheduledTrips'));
    // }



    public function index()
    {
        try {
            $trips = null;

            // Check the user's role
            if (Auth::user()->role == 'admin') {
                // If the user is an admin, fetch all scheduled trips
                $trips = Trip::with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->where('status', 'scheduled')
                    ->orderBy('pick_up_time')
                    ->get()
                    ->groupBy(function ($trip) {
                        return $trip->customer->user->organisation->name;
                    });
            } elseif (Auth::user()->role == 'organisation') {
                // If the user is an organisation, fetch trips for that organisation
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $trips = Trip::with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                        ->where('status', 'scheduled')
                        ->whereHas('customer', function ($query) use ($organisation) {
                            $query->where('customer_organisation_code', $organisation->organisation_code);
                        })
                        ->orderBy('pick_up_time')
                        ->get()
                        ->groupBy(function ($trip) {
                            return $trip->customer->user->organisation->name;
                        });
                }
            } else {
                // If the user has another role, fetch trips created by the user
                $trips = Trip::with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->where('status', 'scheduled')
                    ->where('created_by', Auth::user()->id)
                    ->orderBy('pick_up_time')
                    ->get()
                    ->groupBy(function ($trip) {
                        return $trip->customer->user->organisation->name;
                    });
            }

            Log::info('Scheduled trips fetched: ', ['trips' => $trips]);

            return view('trips.scheduled', compact('trips'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error fetching trips: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while fetching the trips. Please try again.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = null;
        if (auth()->user()->role == 'organisation') {
            $organisation = Organisation::where('user_id', auth()->user()->id)->first();
            $employees = Customer::where('organisation_id', $organisation->id)
                ->where('status', 'active')
                ->get();
        } else {
            $employees = Customer::where('status', 'active')->get();
        }
        $routes = Routes::all();
        return view('trips.create', compact('employees', 'routes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     */



    // public function store(Request $request)
    // {
    //     try {
    //         $data = $request->validate([
    //             'customer_id' => 'required|exists:customers,id',
    //             'vehicle_id' => 'required|exists:vehicles,id',
    //             'driver_id' => 'required|exists:drivers,id',
    //             'preferred_route_id' => 'required|exists:routes,id',
    //             'pick_up_time' => 'required|date_format:H:i',
    //             'drop_off_or_pick_up_date' => 'required|date',
    //             'pick_up_location' => 'required|in:Home,Office',
    //             'mileage_gps' => 'required|numeric',
    //             'mileage_can' => 'required|numeric',
    //             'engine_hours_gps' => 'required|numeric',
    //             'engine_hours_can' => 'required|numeric',
    //             'can_distance_till_service' => 'required|numeric',
    //             'average_fuel_consumption_litre_per_km' => 'required|numeric',
    //             'average_fuel_consumption_litre_per_hour' => 'required|numeric',
    //             'average_fuel_consumption_kg_per_km' => 'required|numeric',
    //         ]);

    //         $trip = Trip::create($data);

    //         return response()->json([
    //             'message' => 'Trip created successfully',
    //             'trip' => $trip
    //         ], 201);
    //     } catch (Exception $e) {
    //         Log::error('ERROR CREATING TRIP');
    //         Log::error($e);
    //         return response()->json([
    //             'message' => 'An error occurred while creating trip',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }



    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $creator = Auth::user();

            $validator = Validator::make($data, [
                'customer_id' => 'required|exists:customers,id',
                'pick_up_location' => 'required|string',
                'preferred_route_id' => 'required|exists:routes,id',
                'drop_off_location' => 'required|string',
                'pickup_time' => 'required|date_format:H:i',
                'trip_date' => 'required|date',
            ]);

            if ($validator->fails()) {

                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());

                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            //For pick_up_time will be the  shift_end_time
            // drop_off_or_pick_up_date will be trip date
            //then if user select 'pick_up_location' => 'Home', and vice versa for Home
            //  we then get there home address from the table of users  by referencing using the customer_id
            //then we will get the lat and long of the address and store it in the database

            //then if user select 'dropOffLocation' => 'Office', and vice verse for Home
            //   we will get there organisation address by referecing using their customer_id then
            //     we get organisation address using the models relationship where the data for organisation is also in the users table

            //then
            // if user select  'drop_off_location' => '4',  which in this case will came id we will get the

            DB::beginTransaction();

            Trip::create([
                'customer_id' => $data['customer_id'],
                'route_id' => $data['preferred_route_id'],
                'pick_up_time' => $data['pickup_time'],
                'pick_up_location' => $data['pick_up_location'],
                'drop_off_location' => $data['drop_off_location'],
                'trip_date' => $data['trip_date'],
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Trip Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR CREATING TRIP');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $trip = Trip::findOrFail($id);
            return response()->json($trip);
        } catch (Exception $e) {
            Log::error('ERROR FETCHING TRIP');
            Log::error($e);
            return response()->json([
                'message' => 'Trip not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Typically not used in APIs
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'customer_organisation_code' => 'required|string',
                'customer_contact' => 'required|string',
                'home_address' => 'required|string',
                'vehicle_id' => 'required|exists:vehicles,id',
                'car_class' => 'required|string',
                'driver_id' => 'required|exists:drivers,id',
                'car_license_plate' => 'required|string',
                'preferred_route' => 'required|string',
                'pick_up_time' => 'required|date_format:H:i',
                'drop_off_or_pick_up_date' => 'required|date',
                'pick_up_location' => 'required|in:Home,Office',
                'mileage_gps' => 'required|numeric',
                'mileage_can' => 'required|numeric',
                'engine_hours_gps' => 'required|numeric',
                'engine_hours_can' => 'required|numeric',
                'can_distance_till_service' => 'required|numeric',
                'average_fuel_consumption_litre_per_km' => 'required|numeric',
                'average_fuel_consumption_litre_per_hour' => 'required|numeric',
                'average_fuel_consumption_kg_per_km' => 'required|numeric',
            ]);

            $trip = Trip::findOrFail($id);
            $trip->update($data);

            return response()->json([
                'message' => 'Trip updated successfully',
                'trip' => $trip
            ]);
        } catch (Exception $e) {
            Log::error('ERROR UPDATING TRIP');
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred while updating trip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $trip = Trip::findOrFail($id);
            $trip->delete();

            return response()->json([
                'message' => 'Trip deleted successfully'
            ]);
        } catch (Exception $e) {
            Log::error('ERROR DELETING TRIP');
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred while deleting trip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showMapRouteForm($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        return view('map_route', compact('trip'));
    }


    public function mapTripToRoute(Request $request, $trip)
    {
        try {
            $data = $request->validate([
                'preferred_route_id' => 'required|integer',
            ]);
            $trip = Trip::findOrFail($trip);

            $trip->update($data);

            // Return a success response
            return response()->json([
                'message' => 'Route Preferred Mapped Successfully',
                'Trip Being Mapped to Preferred Route' => $trip
            ]);
        } catch (Exception $e) {
            Log::error('ERROR Mapping the Preferred Route');
            Log::error($e);

            return response()->json([
                'message' => 'An error occurred while mapping Preferred Route',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function mapTripToVehicle(Request $request, $trip)
    {
        try {
            $data = $request->validate([
                'vehicle_id' => 'required|integer',
                'driver_id' => 'required|integer',
            ]);
            $trip = Trip::findOrFail($trip);

            $trip->update($data);

            // Return a success response
            return response()->json([
                'message' => 'Vehicle Mapped Successfully',
                'Vehicle Being Mapped to Preferred Route' => $trip
            ]);
        } catch (Exception $e) {
            Log::error('ERROR Mapping the Vehicle');
            Log::error($e);

            return response()->json([
                'message' => 'An error occurred while mapping Vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function vehicleTripDataCollection($vehicle, Request $request)
    {
        try {
            // Retrieve the authenticated user
            $user = auth()->user();

            // Validate the request data
            $validatedData = $request->validate([
                'mileage_gps' => 'required|numeric',
                'mileage_can' => 'required|numeric',
                'engine_hours_gps' => 'required|numeric',
                'engine_hours_can' => 'required|numeric',
                'can_distance_till_service' => 'required|numeric',
                'average_fuel_consumption_litre_per_km' => 'required|numeric',
                'average_fuel_consumption_litre_per_hour' => 'required|numeric',
                'average_fuel_consumption_kg_per_km' => 'required|numeric',
            ]);
            //trip associated with the provided vehicle ID
            $trip = Trip::where('vehicle_id', $vehicle)->firstOrFail();

            // Update trip Vehicle Data Collected record with validated data
            $trip->update($validatedData);

            Log::info('Trip updated successfully', ['trip_id' => $trip->id]);

            return response()->json([
                'message' => 'Trip updated successfully',
                'trip' => $trip,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating trip: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while updating trip',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function tripScheduled()
    {
        try {
            $scheduledTrips = null;
            $organisations = Organisation::all();
            $vehicles = Vehicle::where('status', 'active')
                ->whereHas('driver', function ($query) {
                    $query->where('status', 'active');
                })->get();

            if (Auth::user()->role == 'admin') {
                $scheduledTrips = Trip::where('status', 'scheduled')
                    ->with(['customer', 'driver', 'vehicle', 'route'])
                    ->get();
            } elseif (Auth::user()->role == 'organisation') {
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $scheduledTrips = Trip::where('status', 'scheduled')
                        ->whereHas('customer', function ($query) use ($organisation) {
                            $query->where('customer_organisation_code', $organisation->organisation_code);
                        })
                        ->with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                        ->get();
                    $vehicles = Vehicle::where('status', 'active')
                        ->whereHas('driver', function ($query) use ($organisation) {
                            $query->where('organisation_id', $organisation->id);
                        })->get();
                } else {
                    return back()->with('error', 'Organisation not found');
                }
            } else {
                $scheduledTrips = Trip::where('status', 'scheduled')
                    ->where('created_by', Auth::user()->id)
                    ->with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->get();
            }


            $givenRoutes = Routes::all();


            return view('trips.scheduled', compact('scheduledTrips', 'organisations', 'givenRoutes', 'vehicles'));
        } catch (\Exception $e) {
            Log::error('Error fetching scheduled trips: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the scheduled trips. Please try again.');
        }
    }

    public function tripScheduledStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'trip_ids' => 'required|string',
                'vehicle' => 'required|integer|exists:vehicles,id',
            ]);

            if ($validator->fails()) {
                Log::error('Validation error: ' . $validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $data = $request->all();
            $tripIdsArray = explode(',', $data['trip_ids']);

            foreach ($tripIdsArray as $tripId) {
                $trip = Trip::findOrFail($tripId);
                $vehicle = Vehicle::findOrFail($data['vehicle']);
                $trip->vehicle_id = $vehicle->id;
                $trip->driver_id = $vehicle->driver->id;
                $trip->status = 'assigned';
                $trip->save();
            }

            return redirect()->back()->with('success', 'Trips Scheduled Successfully');
        } catch (Exception $e) {
            Log::error('Error storing scheduled trips: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }
    
    public function tripAssigned() {
        try {
            $assignedTrips = null;
            $organisations = Organisation::all();
            $vehicles = Vehicle::where('status', 'active')
                ->whereHas('driver', function ($query) {
                    $query->where('status', 'active');
                })->get();

            if (Auth::user()->role == 'admin') {
                $assignedTrips = Trip::where('status', 'assigned')
                    ->with(['customer', 'driver', 'vehicle', 'route'])
                    ->get();
            } elseif (Auth::user()->role == 'organisation') {
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $assignedTrips = Trip::where('status', 'assigned')
                        ->whereHas('customer', function ($query) use ($organisation) {
                            $query->where('customer_organisation_code', $organisation->organisation_code);
                        })
                        ->with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                        ->get();
                    $vehicles = Vehicle::where('status', 'active')
                        ->whereHas('driver', function ($query) use ($organisation) {
                            $query->where('organisation_id', $organisation->id);
                        })->get();
                } else {
                    return back()->with('error', 'Organisation not found');
                }
            } else {
                $scheduledTrips = Trip::where('status', 'assigned')
                    ->where('created_by', Auth::user()->id)
                    ->with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->get();
            }


            $givenRoutes = Routes::all();


            return view('trips.assigned', compact('assignedTrips', 'organisations', 'givenRoutes', 'vehicles'));
        } catch (\Exception $e) {
            Log::error('Error fetching scheduled trips: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the scheduled trips. Please try again.');
        }
        
    }






    public function tripCompleted(Request $request)
    {
        try {
            $groupByOrganisation = $request->query('group_by_organisation', false);

            $trips = collect();

            if (Auth::user()->role == 'admin') {
                $trips = Trip::where('status', 'completed')
                    ->with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->get();
            } elseif (Auth::user()->role == 'organisation') {
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $trips = Trip::where('status', 'completed')
                        ->whereHas('customer', function ($query) use ($organisation) {
                            $query->where('customer_organisation_code', $organisation->organisation_code);
                        })
                        ->with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                        ->get();
                }
            } else {
                $trips = Trip::where('status', 'completed')
                    ->where('created_by', Auth::user()->id)
                    ->with(['customer.user', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->get();
            }

            // Group by organization if required
            if ($groupByOrganisation) {
                $trips = $trips->groupBy(function ($trip) {
                    return $trip->customer->user->organisation->name ?? 'N/A'; // Use 'N/A' if organisation is null
                });
            }

            return view('trips.completed', compact('trips', 'groupByOrganisation'));
        } catch (\Exception $e) {
            Log::error('Error fetching completed trips: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the completed trips. Please try again.');
        }
    }

    public function tripCancelled()
    {
        try {
            $cancelledTrips = collect();

            if (Auth::user()->role == 'admin') {
                $cancelledTrips = Trip::where('status', 'cancelled')
                    ->with(['customer.user.organisation', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->get()
                    ->groupBy(function ($trip) {
                        return optional($trip->customer->user->organisation)->name;
                    });
            } elseif (Auth::user()->role == 'organisation') {
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $cancelledTrips = Trip::where('status', 'cancelled')
                        ->whereHas('customer', function ($query) use ($organisation) {
                            $query->where('customer_organisation_code', $organisation->organisation_code);
                        })
                        ->with(['customer.user.organisation', 'vehicle.driver.user', 'vehicle', 'route'])
                        ->get()
                        ->groupBy(function ($trip) {
                            return optional($trip->customer->user->organisation)->name;
                        });
                }
            } else {
                $cancelledTrips = Trip::where('status', 'cancelled')
                    ->where('created_by', Auth::user()->id)
                    ->with(['customer.user.organisation', 'vehicle.driver.user', 'vehicle', 'route'])
                    ->get()
                    ->groupBy(function ($trip) {
                        return optional($trip->customer->user->organisation)->name;
                    });
            }

            return view('trips.cancelled', compact('cancelledTrips'));
        } catch (\Exception $e) {
            Log::error('Error fetching cancelled trips: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the cancelled trips. Please try again.');
        }
    }




    public function tripBilled()
    {
        try {
            $billedTrips = collect();

            if (Auth::user()->role == 'admin') {
                $billedTrips = Trip::whereIn('status', ['billed', 'paid', 'partially paid'])
                    ->with(['customer.user.organisation', 'vehicle.driver.user', 'vehicle', 'route', 'billingRate'])
                    ->get()
                    ->groupBy(function ($trip) {
                        return optional($trip->customer->user->organisation)->name;
                    });
            } elseif (Auth::user()->role == 'organisation') {
                $organisation = Organisation::where('user_id', Auth::user()->id)->first();
                if ($organisation) {
                    $billedTrips = Trip::whereIn('status', ['billed', 'paid', 'partially paid'])
                        ->whereHas('customer', function ($query) use ($organisation) {
                            $query->where('customer_organisation_code', $organisation->organisation_code);
                        })
                        ->with(['customer.user.organisation', 'vehicle.driver.user', 'vehicle', 'route', 'billingRate'])
                        ->get()
                        ->groupBy(function ($trip) {
                            return optional($trip->customer->user->organisation)->name;
                        });
                }
            } else {
                $billedTrips = Trip::whereIn('status', ['billed', 'paid', 'partially paid'])
                    ->where('created_by', Auth::user()->id)
                    ->with(['customer.user.organisation', 'vehicle.driver.user', 'vehicle', 'route', 'billingRate'])
                    ->get()
                    ->groupBy(function ($trip) {
                        return optional($trip->customer->user->organisation)->name;
                    });
            }

            Log::info('BILLED TRIPS: ', ['billedTrips' => $billedTrips]);

            return view('trips.billed', compact('billedTrips'));
        } catch (\Exception $e) {
            Log::error('Error fetching billed trips: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the billed trips. Please try again.');
        }
    }






    public function completeTripForm($id)
    {
        $trip = Trip::findOrFail($id);
        return view('trips.complete', compact('trip'));
    }

    public function completeTrip($id)
    {
        try {
            $trip = Trip::findOrFail($id);

            if (!$trip->vehicle_id) {
                return redirect()->back()->with('error', 'Vehicle Not Assigned');
            }

            DB::beginTransaction();

            $trip->status = 'completed';
            $trip->drop_off_time = Carbon::now('Africa/Nairobi')->format('H:i:s');

            $trip->save();

            DB::commit();

            return redirect()->back()->with('success', 'Trip Completed Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something Went Wrong');
            Log::error('ERROR COMPLETING TRIP');
            Log::error($e);
        }
    }

    public function cancelTripForm($id)
    {
        $trip = Trip::findOrFail($id);
        return view('trips.cancel', compact('trip'));
    }

    public function cancelTrip($id)
    {
        try {
            $trip = Trip::findOrFail($id);

            DB::beginTransaction();

            $trip->status = 'cancelled';

            $trip->save();

            DB::commit();

            return redirect()->back()->with('success', 'Trip Cancelled Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something Went Wrong');
            Log::error('ERROR CANCELLING TRIP');
            Log::error($e);
        }
    }

    public function assignVehicleToTrips()
    {
        try {
            $currentTime = Carbon::now('Africa/Nairobi');
            $oneHourLater = $currentTime->copy()->addHour();

            $trips = Trip::whereNull('vehicle_id')
                ->whereBetween('pick_up_time', [$currentTime, $oneHourLater])
                ->whereDate('trip_date', Carbon::today('Africa/Nairobi'))
                ->where('status', 'scheduled')
                ->get();

            if ($trips->isEmpty()) {
                return redirect()->back()->with('error', 'No Trips Found');
            }

            $tripsByRouteAndOrg = $trips->groupBy(function ($trip) {
                $organisationCode = $trip->customer->customer_organisation_code;
                $routeId = $trip->route_id;
                $pickupTime = $trip->pick_up_time;
                $pickUpLocation = $trip->pick_up_location;
                return "{$routeId}-{$organisationCode}-{$pickupTime}-{$pickUpLocation}";
            });

            $vehicles = Vehicle::where('status', 'active')->get();

            foreach ($tripsByRouteAndOrg as $key => $tripGroup) {
                $splitKey = explode('-', $key);
                $routeId = $splitKey[0];
                $organisationCode = $splitKey[1];
                $pickupTime = $splitKey[2];
                $pickUpLocation = $splitKey[3];

                foreach ($tripGroup as $trip) {
                    $isTripAssigned = false;

                    while (!$isTripAssigned) {
                        foreach ($vehicles as $vehicle) {
                            if (!$vehicle->scheduledTrips()->exists()) {
                                $trip->vehicle_id = $vehicle->id;
                                $trip->save();
                                break;
                            } else {
                                $first = $vehicle->scheduledTrips()->first();
                                if ($first->pick_up_time != $pickupTime) {
                                    continue;
                                } elseif ($first->route_id != $routeId) {
                                    continue;
                                } elseif ($first->customer->customer_organisation_code != $organisationCode) {
                                    continue;
                                } else {
                                    if ($pickUpLocation == $first->pick_up_location) {
                                        $trip->vehicle_id = $vehicle->id;
                                        $trip->save();
                                        break;
                                    } else {
                                        continue;
                                    }
                                }
                            }
                        }
                        $isTripAssigned = true;
                    }
                }
            }

            return redirect()->back()->with('success', 'Trips Assigned Successfully');
        } catch (Exception $e) {
            Log::error('ERROR ASSIGNING VEHICLE TO TRIPS');
            Log::error($e);

            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }







    public function details($id)
    {
        $trip = Trip::with(['customer', 'vehicle'])->findOrFail($id);
        return view('trips.details', compact('trip'));
    }

    public function detailsPut(Request $request, $id)
    {
        try {

            $trip = Trip::findOrFail($id);
            $data = $request->all();

            $validator = Validator::make($data, [
                'vehicle_mileage' => 'required|numeric',
                'engine_hours' => 'required|numeric',
                'fuel_consumed' => 'required|numeric',
                'idle_time' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            if (!$trip) {
                return redirect()->back()->with('error', 'Trip not found')->withInput();
            }

            if ($trip->status != 'completed') {
                return redirect()->back()->with('error', 'Trip is not completed')->withInput();
            }

            DB::beginTransaction();

            $trip->update($data);

            DB::commit();

            return redirect()->back()->with('success', 'Trip Details Updated Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR UPDATING TRIP DETAILS');
            Log::error($e);

            return redirect()->back()->with('error', 'Something Went Wrong')->withInput();
        }
    }

    public function bill($id)
    {
        $trip = Trip::findOrFail($id);
        $billingRates = BillingRates::all();
        return view('trips.bill', compact('trip', 'billingRates'));
    }

    public function billPut(Request $request, $id)
    {
        try {

            $trip = Trip::findOrFail($id);
            $data = $request->all();

            $validator = Validator::make($data, [
                'billing_rate_id' => 'required|exists:billing_rates,id',
                'bill_by' => 'required|in:distance,car_class,time',
                'total' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            DB::beginTransaction();

            $trip->billing_rate_id = $data['billing_rate_id'];
            $trip->billed_by = $data['bill_by'];
            $trip->total_price = $data['total'];
            $trip->billed_at = Carbon::now('Africa/Nairobi');
            $trip->status = 'billed';

            $trip->save();

            $organisation = Organisation::where('organisation_code', $trip->customer->customer_organisation_code)->first();

            Income::create([
                'name' => 'Trip Payment',
                'amount' => $trip->total_price,
                'category' => 'trips',
                'entry_date' => now(),
                'description' => 'Trip Payment from ' . $trip->customer->user->name . ' for organisation ' . $organisation->user->name
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Trip Billed Successfully');
        } catch (Exception $e) {
            Log::error('ERROR BILLING TRIP');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function getBillingRate($id)
    {
        $billingRate = BillingRates::findOrFail($id);

        return response()->json([
            'rate_per_km' => $billingRate->rate_per_km,
            'rate_per_minute' => $billingRate->rate_per_minute,
            'rate_by_car_class' => $billingRate->rate_by_car_class,
        ]);
    }


    public function tripPaymentCheckOut($id)
    {
        try {
            // Fetch the trip details where the status is 'billed' or 'partially paid',' paid'
            $trip = Trip::where('id', $id)
                ->whereIn('status', ['billed', 'paid', 'partially paid'])
                ->firstOrFail();

            Log::info('Trip payment: ');
            Log::info($trip->payment);

            // Retrieve all payments for this trip
            // $ThisTripPayments = TripPayment::where('trip_id', $id)->get();
            $ThisTripPayments = TripPayment::where('trip_id', $id)->with('account')->get();

            Log::info('This trip payments data: ', $ThisTripPayments->toArray());

            // Calculate the total paid amount from the trip_payments table
            $totalPaid = TripPayment::where('trip_id', $id)->sum('total_amount');

            // Calculate the remaining amount to be paid
            $remainingAmount = $trip->total_price - $totalPaid;

            // Return the view with the trip details and remaining amount
            return view('trips.tripPaymentCheckout', compact('trip', 'remainingAmount', 'ThisTripPayments'));
        } catch (Exception $e) {
            Log::error('Error fetching trip details for payment checkout: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the trip details. Please try again.');
        }
    }


    public function invoice()
    {
        $organisationCode = auth()->user()->organisation->organisation_code;

        $trips = Trip::where('status', 'billed')
            ->whereHas('customer', function ($query) use ($organisationCode) {
                $query->where('customer_organisation_code', $organisationCode);
            })
            ->with('customer')
            ->with('vehicle')
            ->with('route')
            ->with('billingRate')
            ->get();

        Log::info('TRIPS');
        Log::info($trips);


        $data = [
            'title' => 'Invoice',
            'date' => date('m/d/Y'),
            'due_date' => date('m/d/Y', strtotime('+30 days')),
            'customer' => auth()->user()->organisation->user->name,
            'address' => auth()->user()->organisation->user->address,
            'invoice_number' => 'INV-' . time(),
            'items' => $trips,
        ];
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('fontDir', public_path('fonts'));
        $options->set('fontCache', storage_path('fonts'));
        $dompdf->getOptions()->set('defaultFont', 'Roboto');
        $filesystem = new Filesystem;
        $pdf = new PDF($dompdf, Config::getFacadeRoot(), $filesystem, View::getFacadeRoot());
        $pdf = $pdf->loadView('invoices.invoice', compact('data'));
        return $pdf->stream('invoice.pdf');
    }
}

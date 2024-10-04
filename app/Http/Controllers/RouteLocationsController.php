<?php

namespace App\Http\Controllers;

use App\Exports\RouteLocationsExport;
use Exception;
use App\Models\Routes;
use Illuminate\Http\Request;
use App\Models\RouteLocations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RouteLocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routelocations = RouteLocations::all();
        $routes = Routes::all();
        return view('route.locations.index', compact('routelocations', 'routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = Routes::all();
        return view('route.locations.create', compact('routes'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'route' => 'required|string|exists:routes,id',
                'type' => 'required|string|in:start_location,end_location,waypoint',
                'name' => 'required|string',
                'point_order' => 'required_if:type,waypoint|nullable|integer',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR WHILE ADDING NEW ROUTE LOCATION');
                Log::error($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $route = Routes::find($data['route']);

            if (!$route) {
                return redirect()->back()->with('error', 'Route Not Found');
            }

            DB::beginTransaction();

            if ($data['type'] === 'start_location') {
                $existingStartLocation = RouteLocations::where('route_id', $data['route'])
                    ->where('is_start_location', 1)
                    ->first();

                $existingStartLocation->point_order = 1;

                foreach ($route->waypoints as $waypoint) {
                    $waypoint->point_order += 1;
                    $waypoint->save();
                }

                $existingStartLocation->is_start_location = 0;
                $existingStartLocation->is_waypoint = 1;
                $existingStartLocation->save();

                RouteLocations::create([
                    'route_id' => $data['route'],
                    'name' => $data['name'],
                    'is_start_location' => 1,
                    'is_end_location' => 0,
                    'is_waypoint' => 0,
                    'point_order' => null,
                ]);

                $route->name = $data['name'] . ' - ' . $route->end_location->name;
            } elseif ($data['type'] === 'end_location') {
                $existingEndLocation = RouteLocations::where('route_id', $data['route'])
                    ->where('is_end_location', 1)
                    ->first();

                $existingEndLocation->point_order = $route->waypoints->count() + 2;

                $existingEndLocation->is_end_location = 0;
                $existingEndLocation->is_waypoint = 1;
                $existingEndLocation->save();

                RouteLocations::create([
                    'route_id' => $data['route'],
                    'name' => $data['name'],
                    'is_start_location' => 0,
                    'is_end_location' => 1,
                    'is_waypoint' => 0,
                    'point_order' => null,
                ]);

                $route->name = $route->start_location->name . ' - ' . $data['name'];
            } elseif ($data['type'] === 'waypoint') {

                if ($data['point_order'] < 1) {
                    return redirect()->back()->with('error', 'Point Order Must Be Greater Than 0');
                }

                $existingWaypoint = RouteLocations::where('route_id', $data['route'])
                    ->where('point_order', $data['point_order'])
                    ->first();

                if ($existingWaypoint) {
                    $existingWaypoint->point_order += 1;
                    $existingWaypoint->save();

                    RouteLocations::create([
                        'route_id' => $data['route'],
                        'name' => $data['name'],
                        'is_start_location' => 0,
                        'is_end_location' => 0,
                        'is_waypoint' => 1,
                        'point_order' => $data['point_order'],
                    ]);
                } else {
                    RouteLocations::create([
                        'route_id' => $data['route'],
                        'name' => $data['name'],
                        'is_start_location' => 0,
                        'is_end_location' => 0,
                        'is_waypoint' => 1,
                        'point_order' => $data['point_order'],
                    ]);
                }

                $route->name = $route->start_location->name . ' - ' . $route->end_location->name;
            }

            $route->save();

            DB::commit();

            return redirect()->route('route.location.index')->with('success', 'Route Added Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error Adding New Routes');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }


    /**
     * Display the specified resource.
     * 
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

    public function delete($id)
    {
        $route = RouteLocations::find($id);
        return view('route.locations.delete', compact('route'));
    }
    public function destroy(string $id)
    {
        //
    }

    public function getAllRouteWaypoints(Request $request)
    {
        Log::info('HERE');
        try {
            $routeLocationWaypoints = RouteLocations::where('route_id', $request->route_id)
                ->get(['name', 'id', 'point_order']);
            Log::info('Data request for getting all waypoints for route ID: ' . $request->route_id);
            Log::info('Retrieved waypoints: ', $routeLocationWaypoints->toArray());

            return response()->json($routeLocationWaypoints);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error fetching waypoints: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch waypoints'], 500);
        }
    }

    public function export()
    {
        return Excel::download(new RouteLocationsExport, 'route-locations.xlsx');
    }
}
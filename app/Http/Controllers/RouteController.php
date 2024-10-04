<?php

namespace App\Http\Controllers;

use App\Exports\RoutesExport;
use App\Imports\RoutesImport;
use App\Models\RouteLocations;
use Exception;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $routes = Routes::all();
            return view('route.index', compact('routes'));
        } catch (Exception $e) {
            Log::error('ERROR FETCHING ROUTES');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('route.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Data from the Creating a route Form :');
            Log::info($data);

            $validator = Validator::make($data, [
                'county' => 'required|string',
                'start_location' => 'required|string',
                'end_location' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR WHILE ADDING NEW ROUTE');
                Log::error($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $routeName = $data['start_location'] . ' - ' . $data['end_location'];

            Log::info('Route Name Generated  :');
            Log::info($routeName);

            DB::beginTransaction();

            $route = Routes::create([
                'county' => $data['county'],
                'name' => $routeName,
                'created_by' => 1,
            ]);

            RouteLocations::create([
                'route_id' => $route->id,
                'name' => $data['start_location'],
                'is_start_location' => true,
                'is_end_location' => false,
                'is_waypoint' => false,
            ]);

            RouteLocations::create([
                'route_id' => $route->id,
                'name' => $data['end_location'],
                'is_start_location' => false,
                'is_end_location' => true,
                'is_waypoint' => false,
            ]);

            DB::commit();

            return redirect()->route('route.index')->with('success', 'Route Added Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error Adding New Routes');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
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
        $route = Routes::findOrfail($id);
        return view('route.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $route = Routes::findOrfail($id);
            $data = $request->all();

            $validator = Validator::make($data, [
                'county' => 'required|string',
                'start_location' => 'required|string',
                'end_location' => 'required|string',
                'locations' => 'nullable|array',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR WHILE UPDATING ROUTE');
                Log::error($validator->errors()->first());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            Log::info('DATA');
            Log::info($data);

            DB::beginTransaction();

            $routeStartLocation = $route->route_locations()->where('is_start_location', true)->first();
            $routeEndLocation = $route->route_locations()->where('is_end_location', true)->first();

            if ($routeStartLocation) {
                $routeStartLocation->name = $data['start_location'];
                $routeStartLocation->save();
            } else {
                RouteLocations::create([
                    'route_id' => $route->id,
                    'name' => $data['start_location'],
                    'is_start_location' => true,
                    'is_end_location' => false,
                    'is_waypoint' => false,
                ]);
            }

            if ($routeEndLocation) {
                $routeEndLocation->name = $data['end_location'];
                $routeEndLocation->save();
            } else {
                RouteLocations::create([
                    'route_id' => $route->id,
                    'name' => $data['end_location'],
                    'is_start_location' => false,
                    'is_end_location' => true,
                    'is_waypoint' => false,
                ]);
            }

            $route->county = $data['county'];
            $route->name = $data['start_location'] . ' - ' . $data['end_location'];

            $route->save();

            if (isset($data['locations'])) {
                foreach ($data['locations'] as $location) {
                    RouteLocations::create([
                        'route_id' => $route->id,
                        'name' => $location['name'],
                        'point_order' => $location['point_order'],
                        'is_start_location' => false,
                        'is_end_location' => false,
                        'is_waypoint' => true,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('route.index')->with('success', 'Route Updated Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR FETCHING ROUTE');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        try {
            $route = Routes::findOrfail($id);
            return view('route.delete', compact('route'));
        } catch (Exception $e) {
            Log::error('ERROR DELETING ROUTE');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }
    public function destroy(string $id)
    {
        try {
            $route = Routes::findOrfail($id);

            DB::beginTransaction();

            $route->route_locations()->delete();
            $route->delete();

            DB::commit();
            return redirect()->route('route.index')->with('success', 'Route Deleted Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR DELETING ROUTE');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function export()
    {
        return Excel::download(new RoutesExport, 'routes.xlsx');
    }


    /**
   * 
   *Import organisation detials 

   */
    public function importFile()
    {
        return view('route.importRoute');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt,xlsx',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            Excel::import(new RoutesImport, $request->file('file'));

            // Log the import event
            Log::info('Routes CSV file imported: ', ['file' => $request->file('file')]);

            //log 
            Log::info('Organisation CSV file imported : ');
            Log::info($request->file('file'));

            return redirect()->back()->with('success', 'Records imported successfully.');
        } catch (Exception $e) {
            Log::error('Error importing Routes: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while importing the Routes records.');
        }
    }
}
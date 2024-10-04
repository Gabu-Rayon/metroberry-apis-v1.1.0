<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ServiceTypeCategory;
use Exception;
use App\Models\Vehicle;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Models\MaintenanceService;
use App\Models\MetroBerryAccounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceServicePayment;
use Illuminate\Support\Facades\Validator;

class MaintenanceServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenanceServices = MaintenanceService::with('vehicle', 'creator')->get();
        $vehicles = Vehicle::all();
        $serviceTypes = ServiceType::all();
        return view('vehicle.maintenance-services.index', compact('maintenanceServices', 'vehicles', 'serviceTypes'));
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
                'vehicle' => 'required|numeric|exists:vehicles,id',
                'service_type_id' => 'required|numeric|exists:service_types,id',
                'service_date' => 'required|date',
                'service_description' => 'required|string|max:255',
                'service_category_id' => 'required|numeric|exists:service_type_categories,id',
                'service_cost' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                Log::error('VALIDATION ERROR');
                Log::error($validator->errors());
                return redirect()->back()->with('error', 'Validation error')->withInput();
            }

            DB::beginTransaction();

            $service = MaintenanceService::create([
                'vehicle_id' => $data['vehicle'],
                'creator_id' => auth()->id(),
                'service_type_id' => $data['service_type_id'],
                'service_category_id' => $data['service_category_id'],
                'service_date' => $data['service_date'],
                'service_cost' => $data['service_cost'],
                'service_description' => $data['service_description'],
            ]);

            DB::commit();

            return redirect()->route('maintenance.service')->with('success', 'Maintenance service created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('STORE MAINTENANCE SERVICE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceService $maintenanceService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceService $maintenanceService)
    {
        //
    }

    public function approveForm($id)
    {
        $service = MaintenanceService::findOrFail($id);
        return view('vehicle.maintenance-services.approve', compact('service'));
    }

    public function approve($id)
    {
        try {
            $service = MaintenanceService::findOrFail($id);

            DB::beginTransaction();

            $service->update([
                'service_status' => 'approved'
            ]);

            DB::commit();

            return redirect()->route('maintenance.service')->with('success', 'Maintenance service approved successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('APPROVE MAINTENANCE SERVICE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function rejectForm($id)
    {
        $service = MaintenanceService::findOrFail($id);
        return view('vehicle.maintenance-services.reject', compact('service'));
    }

    public function reject($id)
    {
        try {
            $service = MaintenanceService::findOrFail($id);

            DB::beginTransaction();

            $service->update([
                'service_status' => 'rejected',
            ]);

            DB::commit();

            return redirect()->route('maintenance.service')->with('success', 'Maintenance service rejected successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('REJECT MAINTENANCE SERVICE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function billForm($id)
    {
        $service = MaintenanceService::findOrFail($id);
        return view('vehicle.maintenance-services.bill', compact('service'));
    }

    public function bill($id)
    {
        try {
            $service = MaintenanceService::findOrFail($id);

            DB::beginTransaction();

            $service->update([
                'service_status' => 'billed',
            ]);

            $service_type = ServiceType::find($service['service_type_id']);
            $service_category = ServiceTypeCategory::find($service['service_category_id']);

            Expense::create([
                'name' => $service_type->name . ' - ' . $service_category->name,
                'amount' => $service->service_cost,
                'category' => 'vehicle_service',
                'entry_date' => now(),
                'description' => $service_type->name . ' - ' . $service_category->name . ' Service for ' . $service->vehicle->plate_number,
            ]);

            DB::commit();

            return redirect()->route('maintenance.service')->with('success', 'Maintenance service billed successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('BILL MAINTENANCE SERVICE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceService $maintenanceService)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceService $maintenanceService)
    {
        //
    }

    public function maintenanceServicePaymentCheckOut($id)
    {
        try {
            // Fetch the service details where the status is 'billed', 'paid', or 'partially paid'
            $service = MaintenanceService::where('id', $id)
                ->whereIn('service_status', ['billed', 'paid', 'partially paid'])
                ->firstOrFail();

            // Retrieve all payments for this service
            $ThisMaintenanceServicePayment = MaintenanceServicePayment::where('maintenance_service_id', $id)->with('account')->get();

            Log::info('This Maintenance Service payments data: ', $ThisMaintenanceServicePayment->toArray());

            // Calculate the total paid amount from the MaintenanceServicePayment table
            $totalPaid = MaintenanceServicePayment::where('maintenance_service_id', $id)->sum('total_amount');

            // Calculate the remaining amount to be paid
            $remainingAmount = $service->service_cost - $totalPaid;

            // Return the view with the service details and remaining amount
            return view('vehicle.maintenance-services.serviceCheckout.vehicle-service-checkout', compact('service', 'remainingAmount', 'ThisMaintenanceServicePayment'));
        } catch (Exception $e) {
            Log::error('Error fetching service details for payment checkout: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the service details. Please try again.');
        }
    }
}

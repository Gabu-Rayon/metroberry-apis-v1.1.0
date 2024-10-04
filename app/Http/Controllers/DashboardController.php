<?php

namespace App\Http\Controllers;

use App\Charts\MaintenanceCostReport;
use App\Models\DriversLicenses;
use App\Models\Expense;
use App\Models\Income;
use App\Models\MaintenanceRepair;
use App\Models\MaintenanceService;
use App\Models\NTSAInspectionCertificate;
use App\Models\PSVBadge;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\VehicleInsurance;
use App\Models\VehicleRefueling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $user = Auth::user();

        Log::info('USER');
        Log::info($user);

        if ($user->role == 'organisation') {
            return redirect()->route('organisation.dashboard');
        }

        if ($user->role == 'refueling_station') {
            return redirect()->route('refueling.station.dashboard');
        }


        $activeVehicles = Vehicle::where('status', 'active')->get();
        $inactiveVehicles = Vehicle::where('status', 'inactive')->get();
        $tripsThisMonth = Trip::whereMonth('created_at', date('m'))->get();
        $services = MaintenanceService::where('service_status', 'billed')->get();
        $repairs = MaintenanceRepair::where('repair_status', 'billed')->get();
        $refuelings = VehicleRefueling::where('status', 'billed')->get();
        $scheduledTrips = $tripsThisMonth->filter(function ($trip) {
            return $trip->status == 'scheduled';
        });
        $completedTrips = $tripsThisMonth->filter(function ($trip) {
            return $trip->status == 'completed';
        });
        $cancelledTrips = $tripsThisMonth->filter(function ($trip) {
            return $trip->status == 'cancelled';
        });
        $billedTrips = $tripsThisMonth->filter(function ($trip) {
            return $trip->status == 'billed';
        });
        $totalIncome = $billedTrips->sum(function ($trip) {
            return $trip->total_price;
        });
        $totalExpense = $services->sum(function ($service) {
            return $service->service_cost;
        });
        $totalExpense += $repairs->sum(function ($repair) {
            return $repair->repair_cost;
        });
        $totalExpense += $refuelings->sum(function ($refueling) {
            return $refueling->refuelling_cost;
        });
        $maintenanceExpenses = $services->map(function ($item) {
            return [
                'cost' => $item->service_cost,
                'date' => $item->service_date,
            ];
        })->merge($repairs->map(function ($item) {
            return [
                'cost' => $item->repair_cost,
                'date' => $item->repair_date,
            ];
        }));

        $monthlyCosts = array_fill(0, 12, 0);

        // Iterate over maintenance expenses and accumulate costs for each month
        $maintenanceExpenses->each(function ($item) use (&$monthlyCosts) {
            $month = (int) Carbon::parse($item['date'])->format('m') - 1;
            $monthlyCosts[$month] += (float) $item['cost'];
        });
        $backgroundColors = [];
        for ($i = 0; $i < 12; $i++) {
            $backgroundColors[] = $i % 2 == 0 ? '#198754' : '#ffffff';
        }

        $maintenanceCostReport = new MaintenanceCostReport;
        $maintenanceCostReport->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $maintenanceCostReport->dataset('Cost', 'bar', $monthlyCosts)->options([
            'fill' => 'true',
            'backgroundColor' => $backgroundColors,
        ]);


        $expiredInsurances = VehicleInsurance::where('insurance_date_of_expiry', '<', date('Y-m-d'))->get();
        $expiredInspectionCertificates = NTSAInspectionCertificate::where('ntsa_inspection_certificate_date_of_expiry', '<', date('Y-m-d'))->get();
        $expiredLicenses = DriversLicenses::where('driving_license_date_of_expiry', '<', date('Y-m-d'))->get();
        $expiredPSVBadges = PSVBadge::where('psv_badge_date_of_expiry', '<', date('Y-m-d'))->get();

        $fuelExpensesSum = VehicleRefueling::where('status', 'billed')->sum('refuelling_cost');
        $serviceExpensesSum = MaintenanceService::where('service_status', 'billed')->sum('service_cost');
        $repairExpensesSum = MaintenanceRepair::where('repair_status', 'billed')->sum('repair_cost');
        $totalExpenses = $fuelExpensesSum + $serviceExpensesSum + $repairExpensesSum;

        $expensePieChart = new MaintenanceCostReport;
        $expensePieChart->labels(['Fuel', 'Service', 'Repair']);
        $expensePieChart->dataset('Expenses', 'doughnut', [$fuelExpensesSum, $serviceExpensesSum, $repairExpensesSum])->options([
            'fill' => 'true',
            'backgroundColor' => ['#198754', '#0d6efd', '#dc3545'],
            'scales' => [
                'y' => [
                    'display' => false,
                ],
                'x' => [
                    'display' => false,
                ]
            ],
        ]);

        $cancelledTripsCount = $cancelledTrips->count();
        $completedTripsCount = $completedTrips->count();
        $scheduledTripsCount = $scheduledTrips->count();
        $billedTripsCount = $billedTrips->count();

        $venDiagram = new MaintenanceCostReport;

        $venDiagram->labels(['Scheduled', 'Completed', 'Cancelled', 'Billed']);

        $venDiagram->dataset('Trips', 'pie', [
            $scheduledTripsCount,
            $completedTripsCount,
            $cancelledTripsCount,
            $billedTripsCount,
        ])->options([
            'backgroundColor' => ['#198754', '#0d6efd', '#dc3545', '#ffc107'],
        ]);

        $expenses = Expense::all();
        $totalAmount = $expenses->sum('amount');
        $incomes = Income::all();
        $totalIncomes = $incomes->sum('amount');

        return view('dashboard', compact(
            'activeVehicles',
            'inactiveVehicles',
            'tripsThisMonth',
            'scheduledTrips',
            'completedTrips',
            'cancelledTrips',
            'billedTrips',
            'expiredInsurances',
            'expiredInspectionCertificates',
            'expiredLicenses',
            'expiredPSVBadges',
            'totalIncome',
            'totalExpense',
            'maintenanceCostReport',
            'expensePieChart',
            'venDiagram',
            'totalAmount',
            'totalIncomes'
        ));
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
        //
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

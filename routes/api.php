<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\TripInvoiceController;
use App\Http\Controllers\TripPricingController;
use App\Http\Controllers\OrganisationController;
use Illuminate\Support\Facades\Log;

Route::get('/user', function (Request $request) {
    $user = $request->user();
    $permissions = $user->getAllPermissions()->pluck('name')->toArray();
    $user->permitted_to = $permissions;
    return $user;
})->middleware('auth:sanctum');

Route::get('vehicles-avatar/{avatar}', function ($avatar) {
    $path = storage_path('app/public/VehicleAvatars/' . $avatar);
    if (!file_exists($path)) {
        $path = storage_path('app/public/vehicles/default.png');
    }
    return response()->file($path);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('routes', [RouteController::class, 'index'])->middleware(['auth:sanctum', 'can:view routes']);
Route::post('routes', [RouteController::class, 'store'])->middleware(['auth:sanctum', 'can:create route']);
Route::put('routes/{route}', [RouteController::class, 'update'])->middleware(['auth:sanctum', 'can:edit route']);
Route::delete('routes/{route}', [RouteController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete route']);
Route::get('routes/{route}', [RouteController::class, 'show'])->middleware(['auth:sanctum', 'can:show route']);

Route::apiResource('vehicles', VehicleController::class)->middleware(['auth:sanctum', 'can:view vehicles']);


Route::put('insurances/{vehicleId}', [InsuranceController::class,'update'])->middleware(['auth:sanctum', 'can:edit vehicle']);

Route::get('organisation', [OrganisationController::class, 'index'])->middleware(['auth:sanctum', 'can:view organisation']);
Route::post('organisation', [OrganisationController::class, 'store'])->middleware(['auth:sanctum', 'can:create organisation']);
Route::put('organisations/{organisation}', [OrganisationController::class, 'update'])->middleware(['auth:sanctum', 'can:edit organisation']);
Route::delete('organisations/{organisation}', [OrganisationController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete organisation']);
Route::get('organisations/{organisation}', [OrganisationController::class, 'show'])->middleware(['auth:sanctum', 'can:show organisation']);

Route::get('drivers', [DriverController::class, 'index'])->middleware(['auth:sanctum', 'can:view drivers']);
Route::post('drivers', [DriverController::class, 'store'])->middleware(['auth:sanctum', 'can:create driver']);
Route::put('drivers/{driver}', [DriverController::class, 'update'])->middleware(['auth:sanctum', 'can:edit driver']);
Route::delete('drivers/{driver}', [DriverController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete driver']);
Route::get('drivers/{driver}', [DriverController::class, 'show'])->middleware(['auth:sanctum', 'can:show driver']);
Route::post('renew-license/{driver_id}', [DriverController::class, 'renewLicense'])->middleware(['auth:sanctum', 'can:edit driver']);
Route::post('activate-driver/{driver_id}', [DriverController::class, 'activateDriver'])->middleware(['auth:sanctum', 'can:edit driver']);
Route::post('deactivate-driver/{driver_id}', [DriverController::class, 'deactivateDriver'])->middleware(['auth:sanctum', 'can:edit driver']);

Route::get('customers', [EmployeeController::class, 'index'])->middleware(['auth:sanctum', 'can:view customers']);
Route::post('customers', [EmployeeController::class, 'store'])->middleware(['auth:sanctum', 'can:create customer']);
Route::get('customers/{id}', [EmployeeController::class, 'show'])->middleware(['auth:sanctum', 'can:view customers']);
Route::put('customers/{id}', [EmployeeController::class, 'update'])->middleware(['auth:sanctum', 'can:edit customer']);
Route::delete('customers/{id}', [EmployeeController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete customer']);

Route::get('trips', [TripController::class, 'index'])->middleware(['auth:sanctum', 'can:view trips']);
Route::post('trip', [TripController::class, 'store'])->middleware(['auth:sanctum', 'can:create trip']);
Route::put('trips/{trip}', [TripController::class, 'update'])->middleware(['auth:sanctum', 'can:edit trip']);
Route::delete('trips/{trip}', [TripController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete trip']);
Route::get('trips/{trip}', [TripController::class, 'show'])->middleware(['auth:sanctum', 'can:show trip']);
Route::post('vehicleTripDataCollection/{vehicle}', [TripController::class, 'vehicleTripDataCollection'])->middleware(['auth:sanctum', 'can:edit vehicle']);


Route::get('/trips/{trip}/', [TripController::class, 'showMapRouteForm'])->middleware(['auth:sanctum', 'can:edit trip']);
Route::post('mapTripToRoute/{trip}', [TripController::class, 'mapTripToRoute'])->middleware(['auth:sanctum', 'can:edit trip']);

Route::get('/trips/{trip}/', [TripController::class, 'showMapVehicleForm'])->middleware(['auth:sanctum', 'can:edit trip']);
Route::post('mapTripToVehicle/{trip}', [TripController::class, 'mapTripToVehicle'])->middleware(['auth:sanctum', 'can:edit trip']);


//TripPricing
Route::get('trip-pricing', [TripPricingController::class, 'index'])->middleware(['auth:sanctum', 'can:view trip pricing']);
Route::post('trip-pricing', [TripPricingController::class, 'store'])->middleware(['auth:sanctum', 'can:create trip pricing']);
Route::get('trip-pricing/{id}', [TripPricingController::class, 'show'])->middleware(['auth:sanctum', 'can:view trip pricing']);
Route::put('trip-pricing/{id}', [TripPricingController::class, 'update'])->middleware(['auth:sanctum', 'can:edit trip pricing']);
Route::delete('trip-pricing/{id}', [TripPricingController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete trip pricing']);



//RideType 
use App\Http\Controllers\RideTypeController;

Route::get('ride-types', [RideTypeController::class, 'index'])->middleware(['auth:sanctum', 'can:view ride types']);
Route::post('ride-types', [RideTypeController::class, 'store'])->middleware(['auth:sanctum', 'can:create ride type']);
Route::get('ride-types/{id}', [RideTypeController::class, 'show'])->middleware(['auth:sanctum', 'can:view ride types']);
Route::put('ride-types/{id}', [RideTypeController::class, 'update']) ->middleware(['auth:sanctum', 'can:edit ride type']);
Route::delete('ride-types/{id}', [RideTypeController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete ride type']);

    
Route::get('invoices', [TripInvoiceController::class, 'index'])->middleware(['auth:sanctum', 'can:view invoices']);
Route::post('invoice', [TripInvoiceController::class, 'store'])->middleware(['auth:sanctum', 'can:create invoice']);
Route::put('invoices/{invoice}', [TripInvoiceController::class, 'update'])->middleware(['auth:sanctum', 'can:edit invoice']);
Route::delete('invoices/{invoice}', [TripInvoiceController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete invoice']);
Route::get('invoices/{invoice}', [TripInvoiceController::class, 'show'])->middleware(['auth:sanctum', 'can:show invoice']);
<?php

use App\Http\Controllers\InsuranceCompanyController;
use Illuminate\Support\Facades\Route;

/**
 * 
 * Insurance companies Routes
 * 
 */


Route::get('/vehicle/insurance/company', [InsuranceCompanyController::class, 'index'])
    ->name('vehicle.insurance.company')
    ->middleware('auth', 'can:view insurance companies');

Route::get('/vehicle/insurance/company/create', [InsuranceCompanyController::class, 'create'])
    ->name('vehicle.insurance.company.create')
    ->middleware('auth', 'can:create insurance company');

Route::post('/vehicle/insurance/company/store', [InsuranceCompanyController::class, 'store'])
    ->name('vehicle.insurance.company.store')
    ->middleware('auth', 'can:create insurance company');

Route::get('/vehicle/insurance/company/{id}', [InsuranceCompanyController::class, 'show'])
    ->name('vehicle.insurance.company.show')
    ->middleware('auth', 'can:show insurance company');

Route::get('/vehicle/insurance/company/{id}/edit', [InsuranceCompanyController::class, 'edit'])
    ->name('vehicle.insurance.company.edit')
    ->middleware('auth', 'can:edit insurance company');

Route::put('/vehicle/insurance/company/{id}', [InsuranceCompanyController::class, 'update'])
    ->name('vehicle.insurance.company.update')
    ->middleware('auth', 'can:edit insurance company');

Route::delete('/vehicle/insurance/company/{id}', [InsuranceCompanyController::class, 'destroy'])
    ->name('vehicle.insurance.company.destroy')
    ->middleware('auth', 'can:delete insurance company');


// vehicle.insurance.recurring.period
Route::get('/vehicle/insurance/recurring-period', [InsuranceCompanyController::class, 'insuranceRecurringPeriod'])
    ->name('vehicle.insurance.recurring.period')
    ->middleware('auth', 'can:view insurance companies');

Route::get('/vehicle/insurance/recurring-period/create', [InsuranceCompanyController::class, 'insuranceRecurringPeriodCreate'])
    ->name('vehicle.insurance.recurring.period.create')
    ->middleware('auth', 'can:create insurance company');

Route::post('/vehicle/insurance/recurring-period/store', [InsuranceCompanyController::class, 'insuranceRecurringPeriodStore'])
    ->name('vehicle.insurance.recurring.period.create.store')
    ->middleware('auth', 'can:create insurance company');

Route::get('/vehicle/insurance/recurring-period/{id}/edit', [InsuranceCompanyController::class, 'insuranceRecurringPeriodEdit'])
    ->name('vehicle.insurance.recurring.period.edit')
    ->middleware('auth', 'can:edit insurance company');

Route::put('/vehicle/insurance/recurring-period/{id}', [InsuranceCompanyController::class, 'insuranceRecurringPeriodUpdate'])
    ->name('vehicle.insurance.recurring.period.update')
    ->middleware('auth', 'can:edit insurance company');


// Activate vehicle.insurance.company 
Route::get('/vehicle/insurance/company/{id}/activate', [InsuranceCompanyController::class, 'activateForm'])
    ->name('vehicle.insurance.company.activate')
    ->middleware('auth', 'can:activate insurance company');

Route::put('/vehicle/insurance/company/{id}/activateStore', [InsuranceCompanyController::class, 'activate'])
    ->name('vehicle.insurance.company.activateStore')
    ->middleware('auth', 'can:activate insurance company');

Route::get('/vehicle/insurance/company/{id}/deactivate', [InsuranceCompanyController::class, 'deactivateForm'])
    ->name('vehicle.insurance.company.deactivate')
    ->middleware('auth', 'can:deactivate insurance company');

Route::put('/vehicle/insurance/company/{id}/deactivateStore', [InsuranceCompanyController::class, 'deactivate'])
    ->name('vehicle.insurance.company.deactivateStore')
    ->middleware('auth', 'can:deactivate insurance company');

// Delete vehicle.insurance.company
Route::get('/vehicle/insurance/company/{id}/delete', [InsuranceCompanyController::class, 'delete'])
    ->name('vehicle.insurance.company.delete')
    ->middleware('auth', 'can:delete insurance company');

Route::delete('/vehicle/insurance/company/{id}/destory', [InsuranceCompanyController::class, 'destroy'])
    ->name('vehicle.insurance.company.destroy')
    ->middleware('auth', 'can:delete insurance company');

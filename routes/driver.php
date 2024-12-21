<?php

use App\Http\Controllers\DriverAppController;
use Illuminate\Support\Facades\Route;

Route::get('/driver/signup', [DriverAppController::class, 'signup'])->name('driver.signup');
Route::post('/driver/signup', [DriverAppController::class, 'signupstore'])->name('driver.signup');

Route::get('/driver/profile', [DriverAppController::class, 'profile'])->name('driver.profile');
Route::put('/driver/profile/update/{id}', [DriverAppController::class, 'profileUpdate'])->name('driver.profile.update');

Route::put('/driver/password/update/{id}', [DriverAppController::class, 'passwordUpdate'])->name('driver.password.update');

Route::get('/driver/documents', [DriverAppController::class, 'documents'])->name('driver.documents');

Route::get('/driver/dashboard', [DriverAppController::class, 'dashboard'])->name('driver.dashboard')->middleware('auth');
Route::post('driver/personal-documents/{id}', [DriverAppController::class, 'iddocs'])->name('driver.personal-documents')->middleware('auth');


Route::post('/driver/license', [DriverAppController::class, 'license'])->name('driver.add.license')->middleware('auth');
Route::put('/driver/license/{id}', [DriverAppController::class, 'updateLicense'])->name('driver.license.update')->middleware('auth');

Route::post('/driver/psvbadge/create', [DriverAppController::class, 'psvBadgeCreate'])->name('driver.psvbadge.create')->middleware('auth');
Route::put('/driver/psvbadge/{id}', [DriverAppController::class, 'updatePsvBadge'])->name('driver.psvbadge.update')->middleware('auth');

Route::get('driver/psvbadge-document', [DriverAppController::class, 'psvbadgeDocument'])->name('psvbadge.document')->middleware('auth');
Route::put('driver/psvbadge-document/{id}', [DriverAppController::class, 'psvbadgeDocumentUpdate'])->name('psvbadge.document.update')->middleware('auth');


Route::get('/driver/vehicle', [DriverAppController::class, 'vehicle'])->name('driver.vehicle')->middleware('auth');
Route::get('/driver/trips', [DriverAppController::class, 'trips'])->name('driver.trips')->middleware('auth');


//Driver Regsitrations View Routes and Update
Route::get('driver/registration-documentation', [DriverAppController::class, 'driverRegistrationPage'])->name('driver.registration.page')->middleware('auth');

Route::get('driver/license-document', [DriverAppController::class, 'driverLicenseDocument'])->name('driver.license.document')->middleware('auth');
Route::put('driver/license-document/{id}', [DriverAppController::class, 'updateLicense'])->name('driver.license.document.update')->middleware('auth');

Route::get('driver/personal-id-card-documents', [DriverAppController::class, 'personalIdCardDocument'])->name('personal.id.card.document')->middleware('auth');
Route::put('driver/personal-id-card-document/{id}', [DriverAppController::class, 'iddocsUpdate'])->name('personal.id.card.document.update')->middleware('auth');





//DriverTrips View Routes and Update
Route::get('driver/trips-history', [DriverAppController::class, 'tripHistorypage'])->name('trips.history.page')->middleware('auth');

Route::get('driver/trips-assigned', [DriverAppController::class, 'tripsAssignedPage'])->name('trips.assigned.page')->middleware('auth');
Route::put('driver/trip-assigned/show/{id}', [DriverAppController::class, 'tripAssignedShowPage'])->name('trip.assigned.show.page')->middleware('auth');

Route::get('driver/trips-completed', [DriverAppController::class, 'tripsCompletedPage'])->name('trips.completed.page')->middleware('auth');
Route::put('driver/trip-completed/show/{id}', [DriverAppController::class, 'tripCompletedShowPage'])->name('trip.compelete.show.page')->middleware('auth');


//Driver update profile avatar 
Route::post('driver/update-profile-picture', [DriverAppController::class, 'updateProfilePicture'])->name('driver.updateProfilePicture')->middleware('auth');


//More route for driver Vehicle Registration 
Route::get('driver/vehicle/docs/registration', [DriverAppController::class, 'driverVehicleDocsRegsitration'])->name('driver.vehicle.docs.registration')->middleware('auth');


/***
 * 
 * 
 * Vehicle Registration
 * 
 * 
 */



Route::get('/driver/registration/vehicle', [DriverAppController::class, 'vehicleRegistration'])->name('driver.registration.vehicle')->middleware('auth');

/** Use the same Form to both PUT & POST */
// creating a new vehicle
Route::post('driver/registration/vehicle/store', [DriverAppController::class, 'vehicleRegistrationStore'])->name('driver.registration.vehicle.store')->middleware('auth');

// updating an existing vehicle
Route::put('driver/registration/vehicle/{vehicle}/update', [DriverAppController::class, 'vehicleRegistrationUpdate'])->name('driver.registration.vehicle.update')->middleware('auth');


/***
 * 
 * 
 *Insurance Document 
 * 
 * 
 */

Route::get('/driver/registration/vehicle/insurance/document', [DriverAppController::class, 'vehicleInsuranceDocument'])->name('driver.registration.vehicle.insurance.document')->middleware('auth');

/** Use the same Form to both PUT & POST */
// creating a new Insurance Document Post
Route::post('/driver/registration/vehicle/insurance/store', [DriverAppController::class, 'vehicleInsuranceStore'])->name('driver.registration.vehicle.insurance.store')->middleware('auth');

// updating an existing  Insurance Document Post
Route::put('/driver/registration/vehicle/insurance/{insuranceId}/update', [DriverAppController::class, 'vehicleInsuranceUpdate'])->name('driver.registration.vehicle.insurance.update')->middleware('auth');



/***
 * 
 * 
 *  inspection certificate
 * 
 * 
 */

Route::get('/driver/registration/ntsa/inspection/certificate/document', [DriverAppController::class, 'ntsaInspectionCertificateDocument'])->name('driver.registration.ntsa.ispection.certificate.document')->middleware('auth');

/** Use the same Form to both PUT & POST */
// creating a new inspection certificate
Route::post('driver/registration/vehicle/ntsa/inspection/certificate/store', [DriverAppController::class, 'ntsaInspectionCertificateStore'])->name('driver.registration.ntsa.ispection.certificate.store')->middleware('auth');

// updating an existing inspection certificate
Route::put('driver/registration/vehicle/ntsa/inspection/certificate/{ntsaCertificateId}/update', [DriverAppController::class, 'ntsaInspectionCertificateUpdate'])->name('driver.registration.ntsa.ispection.certificate.update')->middleware('auth');



/***
 * 
 * 
 *  Speed Governor
 * 
 * 
 */

Route::get('/driver/speed/governor/registration', [DriverAppController::class, 'speedGovernorRegistration'])->name('driver.speed.governor.registration')->middleware('auth');

/** Use the same Form to both PUT & POST */
// creating a new Speed Governor
Route::post('driver/registration//speed/governor/vehicle/store', [DriverAppController::class, 'speedGovernorRegistrationStore'])->name('driver.registration.speed.governor.store')->middleware('auth');

// updating an existing Speed Governor
Route::put('driver/registration/vehicle/speed/governor/{certificateId}/update', [DriverAppController::class, 'speedGovernorRegistrationUpdate'])->name('driver.registration.speed.governor.update')->middleware('auth');
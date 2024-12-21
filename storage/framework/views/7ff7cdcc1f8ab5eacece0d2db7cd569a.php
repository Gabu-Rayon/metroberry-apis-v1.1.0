

<?php $__env->startSection('title', 'Vehicle Insurance | Driver'); ?>
<?php $__env->startSection('content'); ?>
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>

    <?php
        $user = Auth::user();
        $driver = $user->driver;
        $vehicleInsurance = $driver->vehicle->insurance ?? null;
    ?>

    

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="text-center header-icons-container">
                <a href="<?php echo e(route('driver.vehicle.docs.registration')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                </a>
                <?php if($driver->status == 'inactive'): ?>
                    <span>Account Deactivated</span>
                <?php else: ?>
                    <span>Vehicle Insurance</span>
                <?php endif; ?>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="address-title">
                    <span>Vehicle Insurance</span>

                    <?php if($vehicleInsurance): ?>
                        <?php if($vehicleInsurance->status): ?>
                            <span class="badge badge-pill fs-6 badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-pill fs-6 badge-danger">Inactive</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge badge-pill fs-6 badge-danger">Inactive</span>
                    <?php endif; ?>

                </div>
                <?php if(session('success')): ?>
                    <div id="success-message" class="alert alert-success" style="display: none;">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div id="error-message" class="alert alert-danger" style="display: none;">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <!--Driver's License Fields Container Start-->
                <div class="all-container all-container-with-classes">
                    <form class="width-100"
                        action="<?php echo e($vehicleInsurance ? route('driver.registration.vehicle.insurance.update', $vehicleInsurance->id) : route('driver.registration.vehicle.insurance.store')); ?>"
                        method="POST" enctype="multipart/form-data">

                        <?php echo csrf_field(); ?>
                        <?php if($vehicleInsurance): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>

                        <!--Input Field Container Start-->
                        <input class="form-control form-control-with-padding" type="hidden" name="driver_vehicle_id"
                            autocomplete="off" placeholder="Vehicle ID"
                            value="<?php echo e(old('driver_vehicle_id', $driver->vehicle->id)); ?>" readonly />

                        <div class="form-group form-control-margin">

                            
                            <label class="label-title">Vehicle</label>
                            <div class="#">

                                <?php echo e($driver->vehicle->plate_number ?? 'N/A'); ?>:
                                <?php echo e(optional($driver->vehicle->manufacturer)->name ?? ''); ?>

                                <?php echo e($driver->vehicle->model ?? ''); ?>

                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Insurance Company</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_insurance_company_id">
                                        <?php $__currentLoopData = $vehiclesInsuranceCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>"
                                                <?php echo e(old('driver_vehicle_insurance_company_id', $vehicleInsurance->insurance_company_id ?? '') == $company->id ? 'selected' : ''); ?>>
                                                <?php echo e($company->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </span>
                            </label>
                        </div>
                        <!--Input Field Container End-->


                        <!--Input Field Container Start-->
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Insurance Recurring Period</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_insurance_recurring_period">
                                        <?php $__currentLoopData = $vehicleInsuranceRecurringPeriod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurringPeriod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($recurringPeriod->id); ?>"
                                                <?php echo e(old('driver_vehicle_insurance_recurring_period', $vehicleInsurance->recurring_period_id ?? '') == $recurringPeriod->id ? 'selected' : ''); ?>>
                                                <?php echo e($recurringPeriod->period); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </span>
                            </label>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Insurance Policy No</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driver_insurance_policy_no" autocomplete="off" placeholder="Insurance Policy No"
                                    value="<?php echo e(old('driver_insurance_policy_no', $vehicleInsurance->insurance_policy_no ?? '')); ?>" />
                                <div class="input-group-append">

                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Insurance Issue Date</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_insurance_date_of_issue" autocomplete="off"
                                    placeholder="Insurance Issue Date"
                                    value="<?php echo e(old('driver_insurance_date_of_issue', $vehicleInsurance->insurance_date_of_issue ?? '')); ?>" />
                                <div class="input-group-append">

                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Insurance Expiry Date</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_insurance_date_of_expiry" autocomplete="off"
                                    placeholder="Insurance Expiry Date"
                                    value="<?php echo e(old('driver_insurance_date_of_expiry', $vehicleInsurance->insurance_date_of_expiry ?? '')); ?>" />
                                <div class="input-group-append">

                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Recurring Date</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_insurance_recurring_date" autocomplete="off" placeholder="Recurring Date"
                                    value="<?php echo e(old('driver_insurance_recurring_date', $vehicleInsurance->recurring_date ?? '')); ?>" />
                                <div class="input-group-append">

                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container End-->
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Reminder Me</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_insurance_reminder">
                                        <option value="1"
                                            <?php echo e(old('driver_insurance_reminder', $vehicleInsurance->reminder ?? '') == '1' ? 'selected' : ''); ?>>
                                            YES</option>
                                        <option value="0"
                                            <?php echo e(old('driver_insurance_reminder', $vehicleInsurance->reminder ?? '') == '0' ? 'selected' : ''); ?>>
                                            NO</option>
                                    </select>
                                </span>
                            </label>
                        </div>


                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Deductible</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="number"
                                    name="driver_insurance_deductible" autocomplete="off" placeholder="Deductible"
                                    value="<?php echo e(old('driver_insurance_deductible', $vehicleInsurance->deductible ?? '')); ?>" />
                                <div class="input-group-append">

                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->


                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Deductible</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="number"
                                    name="driver_insurance_charges_payable" autocomplete="off"
                                    placeholder="Charges Payable"
                                    value="<?php echo e(old('driver_insurance_deductible', $vehicleInsurance->charges_payable ?? '')); ?>" />
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Remark :
                            </label>
                            <div class="#">
                                <textarea class="form-control form-control-with-padding" name="driver_insurance_remark" colspan="30"
                                    autocomplete="off" placeholder="Remark"><?php echo e(old('remark', $vehicleInsurance->remark ?? '')); ?></textarea>
                            </div>
                        </div>
                        <!--Input Field Container End-->


                        <!-- Upload Insurance Policy Document -->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="driver_insurance_policy_document" id="national-id-back-input" />
                                    </span>
                                    <span class="text-uppercase">Insurance Policy Document</span>
                                    <span class="delete-btn" id="national-id-back-delete">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    <img id="national-id-back-preview"
                                                        src="<?php echo e($vehicleInsurance && $vehicleInsurance->policy_document
                                                            ? asset($vehicleInsurance && $vehicleInsurance->policy_document)
                                                            : asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                        alt="Driver Vehicle Insurance Policy Document" />

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Upload Policy Document End -->
                        <div class="text-center form-submit-button">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                <?php echo e($vehicleInsurance ? 'Update Vehicle Insurance' : 'Save Vehicle Insurance'); ?>

                            </button>
                        </div>
                    </form>
                </div>
                <!--Driver's License Fields Container End-->
            </div>
        </div>

        <!--Terms And Conditions Agreement Container Start-->
        <div class="text-center col-xs-12 col-sm-12 sms-rate-text font-roboto flex-end margin-bottom-30">
            <div class="container-sms-rate-text width-100 font-11">
                <span class="light-gray font-weight-light">
                </span>
                <br />
                <a href="#" class="dark-link">
                    <span class="font-weight-light">Metroberry Tours & Travel</span>
                </a>
            </div>
        </div>
        <!--Terms And Conditions Agreement Container End-->

        <!--Main Menu Start-->
        <?php echo $__env->make('components.driver-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--Main Menu End-->
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script>
        // Show success message for 5 seconds
        document.addEventListener("DOMContentLoaded", function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'block';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }

            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/vehicle-insurance-registration.blade.php ENDPATH**/ ?>
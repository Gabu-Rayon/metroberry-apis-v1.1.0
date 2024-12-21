

<?php $__env->startSection('title', 'Inspection Certificate | Driver'); ?>
<?php $__env->startSection('content'); ?>
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>

    <?php
        $user = Auth::user();
        $driver = $user->driver;
        $vehicle = optional($driver->vehicle);
        $inspectionCertificate = optional($vehicle->inspectionCertificates);

        $isUpdate = $inspectionCertificate->exists;
        $route = $isUpdate
            ? route('driver.registration.ntsa.ispection.certificate.update', $inspectionCertificate->id)
            : route('driver.registration.ntsa.ispection.certificate.store');
        $method = $isUpdate ? 'PUT' : 'POST';
    ?>

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12">
            <!-- Page Title & Icons Start -->
            <div class="text-center header-icons-container">
                <a href="<?php echo e(route('driver.vehicle.docs.registration')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                </a>
                <?php if($driver->status == 'inactive'): ?>
                    <span>Account Deactivated</span>
                <?php else: ?>
                    <span>NTSA Inspection Certificate</span>
                <?php endif; ?>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!-- Page Title & Icons End -->

            <div class="rest-container">
                <div class="address-title">
                    <span>NTSA Inspection Certificate</span>

                    <?php if($driver->vehicle->inspectionCertificates): ?>
                        <?php if($driver->vehicle->inspectionCertificates->verified): ?>
                            <span class="badge badge-pill fs-4 badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-pill fs-4 badge-danger">Inactive</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge badge-pill fs-4 badge-danger">Inactive</span>
                    <?php endif; ?>

                </div>
                <?php if(session('success')): ?>
                    <div id="success-message" class="alert alert-success" style="display: block;">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div id="error-message" class="alert alert-danger" style="display: block;">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <div class="all-container all-container-with-classes">
                    <form class="width-100" action="<?php echo e($route); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field($method); ?>

                        <!-- Vehicle Info -->

                        <input class="form-control form-control-with-padding" type="hidden" name="driver_vehicle_id"
                            autocomplete="off" placeholder="Vehicle ID"
                            value="<?php echo e(old('driver_vehicle_id', $driver->vehicle->id)); ?>" readonly />

                        <div class="form-group form-control-margin">

                            
                            <label class="label-title">Vehicle</label>
                            <div class="#">

                                <?php echo e($vehicle->plate_number ?? 'N/A'); ?>: <?php echo e(optional($vehicle->manufacturer)->name ?? ''); ?>

                                <?php echo e($vehicle->model ?? ''); ?>

                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!-- Certificate Number -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Certificate No</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driver_ntsa_inspection_certificate_no" autocomplete="on" required maxlength="50"
                                    placeholder="Driver NTSA Inspection Certificate No"
                                    value="<?php echo e(old('driver_ntsa_inspection_certificate_no', $inspectionCertificate->ntsa_inspection_certificate_no ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Cost -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Cost</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="number" name="cost"
                                    autocomplete="on" required placeholder="Cost"
                                    value="<?php echo e(old('cost', $inspectionCertificate->cost ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-dollar icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Certificate Copy -->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="driver_ntsa_certificate_copy" id="certificate-copy-input" />
                                    </span>
                                    <span class="text-uppercase">NTSA Certificate Copy</span>
                                    <span class="delete-btn" id="certificate-copy-delete">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container text-center">
                                            <img id="certificate-copy-preview"
                                                src="<?php echo e($inspectionCertificate->ntsa_inspection_certificate_avatar ?? asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                alt="Certificate Copy" />
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Issue Date -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Date of Issue</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_ntsa_inspection_certificate_date_of_issue" autocomplete="on"
                                    value="<?php echo e(old('driver_ntsa_inspection_certificate_date_of_issue', $inspectionCertificate->ntsa_inspection_certificate_date_of_issue ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-calendar-alt icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Expiry Date -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Expiry Date</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_ntsa_inspection_certificate_date_of_expiry" autocomplete="on"
                                    value="<?php echo e(old('driver_ntsa_inspection_certificate_date_of_expiry', $inspectionCertificate->ntsa_inspection_certificate_date_of_expiry ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-calendar-check icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-submit-button text-center">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                <?php echo e($isUpdate ? 'Update' : 'Register'); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center col-xs-12 col-sm-12 sms-rate-text font-roboto flex-end margin-bottom-30">
            <div class="container-sms-rate-text width-100 font-11">
                <a href="#" class="dark-link">
                    <span class="font-weight-light">Metroberry Tours & Travel</span>
                </a>
            </div>
        </div>

        <?php echo $__env->make('components.driver-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <script>
        document.getElementById('certificate-copy-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('certificate-copy-preview').src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/ntsa-inspection-registration.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'License | Driver'); ?>
<?php $__env->startSection('content'); ?>
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        <?php
            $user = Auth::user();
            $driver = $user->driver;
        ?>
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="text-center header-icons-container">
                <a href="<?php echo e(route('driver.registration.page')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                </a>
                <?php if($driver->status == 'inactive'): ?>
                    <span>Deactivated</span>
                <?php else: ?>
                    <span>Driver's License</span>
                <?php endif; ?>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="address-title">Driver's License</div>

                <!--Driver's License Fields Container Start-->
                <div class="all-container all-container-with-classes">
                    <form class="width-100" action="<?php echo e(route('driver.license.document.update', $driver->id)); ?>"
                        method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Driver License Number</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driving_license_no" autocomplete="off" placeholder="Driver License Number"
                                    value="<?php echo e($driver->driverLicense->driving_license_no); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Date of issue : <span class="text-primary">
                                    <?php echo e($driver->driverLicense->driving_license_date_of_issue); ?></span></label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driving_license_date_of_issue" autocomplete="off"
                                    placeholder="Driver License Number" value="#" />
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Expiry Date : <span
                                    class="text-primary"><?php echo e($driver->driverLicense->driving_license_date_of_expiry); ?></span></label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driving_license_date_of_expiry" autocomplete="off"
                                    placeholder="Driver License Number" value="#" />
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Upload Front Start-->
                        <div class="display-flex justify-content-between">
                            <span class="position-relative upload-btn">
                                <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                <input class="scan-prompt" type="file" accept="image/*"
                                    onchange="previewImage(event, 'frontImagePreview')" />
                            </span>
                            <span class="text-uppercase">FRONT</span>
                        </div>
                        <div class="scan-your-card-prompt margin-top-5">
                            <div class="position-relative">
                                <div class="upload-picture-container">
                                    <div class="text-center upload-camera-container">
                                        <img id="frontImagePreview" alt="National ID Front Preview" class="img-fluid"
                                            style="display: none;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Upload Front End-->

                        <!--Upload Back Start-->
                        <div class="display-flex justify-content-between">
                            <span class="position-relative upload-btn">
                                <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                <input class="scan-prompt" type="file" accept="image/*"
                                    onchange="previewImage(event, 'backImagePreview')" />
                            </span>
                            <span class="text-uppercase">BACK</span>
                        </div>
                        <div class="scan-your-card-prompt margin-top-5">
                            <div class="position-relative">
                                <div class="upload-picture-container">
                                    <div class="text-center upload-camera-container">
                                        <img id="backImagePreview" alt="National ID Back Preview" class="img-fluid"
                                            style="display: none;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Upload Back End-->

                        <div class="text-center form-submit-button">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                Update
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
        function previewImage(event, previewElementId) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imgElement = document.getElementById(previewElementId);
                imgElement.src = e.target.result;
                imgElement.style.display = 'block'; // Show the image
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/driver-app/driver-license.blade.php ENDPATH**/ ?>
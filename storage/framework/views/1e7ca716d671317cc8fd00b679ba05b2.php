<?php $__env->startSection('title', 'Register Account | Driver'); ?>
<?php $__env->startSection('content'); ?>


    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12">

            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <a href="<?php echo e(route('sign.up.options.page')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon">
                    </span>
                </a>
                <span>Register Account</span>
            </div>

            <div class="rest-container">
                <div class="text-center header-icon-logo-margin">
                    <img src="<?php echo e(asset('company-logos/logo_white.png')); ?>" height="150" width="300" alt="Main Logo">
                </div>

                <!--Sign Up Container Start-->
                <div class="sign-up-form-container text-center">
                    <!--Page Title & Icons End-->
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div><?php echo e($error); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form class="width-100"method="POST" action="<?php echo e(route('auth.customer.register')); ?>">
                        <?php echo csrf_field(); ?>

                        <!--Sign Up Input Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span>
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/avatar-light.svg')); ?>"
                                            alt="Avatar Icon">
                                    </span>
                                </div>
                                <input class="form-control" type="text" autocomplete="on" name="name"
                                    placeholder="Name" value ="<?php echo e(old('name')); ?>">
                            </div>
                        </div>
                        <!--Sign Up Input Field End-->

                        <!--Sign Up Input Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span><img src="<?php echo e(asset('mobile-app-assets/icons/envelope.svg')); ?>"
                                            alt="Envelope Icon"></span>
                                </div>
                                <input class="form-control" type="text" autocomplete="on" name="email"
                                    placeholder="Email" value ="<?php echo e(old('email')); ?>">
                            </div>
                        </div>
                        <!--Sign Up Input Field End-->

                        
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" id="phone-input" type="text" name="phone" autocomplete="on"
                                    data-intl-tel-input-id="0" placeholder="(254) 70 0000 000">
                            </div>
                        </div>
                        

                         <!--Sign Up Input Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span><i class="fa fa-id-card" aria-hidden="true"></i></span>
                                </div>
                                <input class="form-control" type="number" autocomplete="on" name="national_id_no"
                                    placeholder="National Id" value ="<?php echo e(old('national_id_no')); ?>">
                            </div>
                        </div>
                        <!--Sign Up Input Field End-->

                        <!--Sign Up Input Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span><img src="<?php echo e(asset('mobile-app-assets/icons/lock.svg')); ?>" alt="Lock Icon"></span>
                                </div>
                                <input class="form-control" type="password" name="password" placeholder="Password"
                                    value ="<?php echo e(old('password')); ?>">
                                <div class="input-group-append password-visibility">
                                    <span>
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/eye.svg')); ?>"
                                            alt="Password Visibility Icon">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--Sign Up Input Field End-->
                        <!--Sign Up Input Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span><img src="<?php echo e(asset('mobile-app-assets/icons/lock.svg')); ?>"
                                            alt="Lock Icon"></span>
                                </div>
                                <input class="form-control" type="password" name="password_confirmation"
                                    placeholder="Confirm Password" value ="<?php echo e(old('password_confirmation')); ?>">
                                <div class="input-group-append password-visibility">
                                    <span>
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/eye.svg')); ?>"
                                            alt="Password Visibility Icon">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--Sign Up Input Field End-->


                        <!--Pickup organisations Field Start-->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="input-group-prepend">
                                    <span>
                                        <span class="label-title">Select Organisation </span>
                                    </span>
                                </div>
                                <span class="car-info-wrap display-block">
                                    <select name="organisation" class="custom-select font-weight-light car-info"
                                        id="organisation" required>
                                        <option value="" readonly>Select Organisation</option>
                                        <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($organisation->id); ?>"><?php echo e($organisation->user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </span>
                            </label>
                        </div>
                        <!--Pickup organisations Field End-->

                        <div class="form-submit-button">
                            <button class="btn btn-primary text-uppercase" type="submit">Register </button>
                        </div>
                    </form>
                   <div class="text-center sms-rate-text">
                        <a href="<?php echo e(route('users.sign.in.page')); ?>" class="regular-link">Already have an account ? Sign in</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/signup.blade.php ENDPATH**/ ?>
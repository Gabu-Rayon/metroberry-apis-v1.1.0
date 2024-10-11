<?php $__env->startSection('title', 'Sign in | Metroberry Be-Spoken'); ?>
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
                <span>Sign In | Metroberry Be-Spoken </span>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="text-center header-icon-logo-margin header-icon-logo-margin-extra">
                    <img src="<?php echo e(asset('company-logos/logo_white.png')); ?>" height="150" width="300" alt="Main Logo">
                    <div>
                        <p class="text-dark fs-16">Be-Spoken</p>
                    </div>
                </div>

                <!--Sign Up Container Start-->
                <div class="sign-up-form-container text-center">

                    <?php if(session('success')): ?>
                        <div class="text-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="text-danger"><?php echo e(session('error')); ?> !</div>
                    <?php endif; ?>
                </div>
                <div class="sign-up-form-container text-center">

                    <form class="width-100"method="POST" action="<?php echo e(route('auth.users.sign.in')); ?>">
                        <?php echo csrf_field(); ?>
                        <!--Sign In Form Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span>
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/avatar-light.svg')); ?>"
                                            alt="Avatar Icon">
                                    </span>
                                </div>
                                <input class="form-control" type="text" autocomplete="off" name="email"
                                    placeholder="Email Address" value="<?php echo e(old('email')); ?>">
                            </div>
                        </div>
                        <!--Sign In Form Field End-->

                        <!--Sign In Form Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span>
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/lock.svg')); ?>" alt="Lock Icon">
                                    </span>
                                </div>
                                <input class="form-control" type="password" name="password" placeholder="Password">
                                <div class="input-group-append password-visibility">
                                    <span>
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/eye.svg')); ?>"
                                            alt="Password Visibility Icon">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--Sign In Form Field End-->
                        <div class="form-submit-button">
                            <button class="btn btn-primary text-uppercase" type="submit">Sign In </button>
                        </div>
                    </form>

                    <div class="have-an-account text-center mt-3">
                        <a href="<?php echo e(route('sign.up.options.page')); ?>" class="regular-link">Don't have an account ? Sign
                            up</a>
                    </div>
                </div>
                <!--Sign Up Container Start-->

            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/sign-in.blade.php ENDPATH**/ ?>
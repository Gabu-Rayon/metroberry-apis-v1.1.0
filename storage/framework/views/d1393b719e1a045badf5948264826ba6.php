

<?php $__env->startSection('title', 'Choose Appropriate | Metroberry Be-Spoken'); ?>
<?php $__env->startSection('content'); ?>

    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>

    <div class="row h-100 align-items-center">
    <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <span>Choose Appropriate | Metroberry Be-Spoken </span>
            </div>
            <!--Page Title & Icons End-->
        <div class="col-xs-12 col-sm-12 margin-bottom-up">

            <?php echo $__env->make('components.logometro', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            

            <div class="sign-up-btn-container">
                <a href="<?php echo e(route('customer.register.page')); ?>"
                    class="btn btn-center width-100 display-block btn-primary text-uppercase margin-top-10">Customer Sign
                    up</a>
            </div>

            <div class="sign-up-btn-container">
                <a href="<?php echo e(route('driver.signup')); ?>"
                    class="btn btn-center width-100 display-block btn-primary text-uppercase margin-top-10">Driver Sign
                    up</a>
            </div>

            <div class="have-an-account text-center">
                <a href="<?php echo e(route('users.sign.in.page')); ?>" class="regular-link">Already have an account ? Sign in</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/sign-in-options.blade.php ENDPATH**/ ?>
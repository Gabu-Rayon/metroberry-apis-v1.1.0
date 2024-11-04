

<?php $__env->startSection('title', '403 - Forbidden'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container-fluid ">
        <div class="d-flex align-items-center justify-content-center text-center h-100vh">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="four_zero_four_bg">
                        <h1 class="fw-bold text-monospace">403</h1>
                    </div>
                    <div class="contant_box_505">
                        <h3 class="h2">Forbidden</h3>
                        <p><b>403 - Forbidden:</b>
                            Looks like someone doesn't want you to view this page.</p>
                    </div>
                    <div>
                        <a class="btn btn-success mt-3" href="<?php echo e(route('welcome.page')); ?>">
                            <i class="typcn typcn-arrow-back-outline mr-1"></i>
                            Home
                        </a>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <footer class="text-center text-black">
                        <div class="">
                            <div class="copy">© 2024 <a class="text-capitalize" href="https://metroberry.co.ke/"
                                                        target="_blank">MetroBerry</a>.</div>
                            <div class="credit">Designed &amp; developed by: <a href="https://yourapps.co.ke/"
                                                                                target="_blank">Your Apps</a></div>
                        </div>
                    </footer>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/errors/403.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('content'); ?>

    <div class="wrapper">
        <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content-wrapper">
            <div class="main-content">
                <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="body-content">
                    <div class="tile">

                        <div class="row justify-content-center">
                            <div class="col-md-8 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="fs-17 fw-semi-bold mb-0">Profile</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="media m-1 ">
                                                <div class="align-left p-1">
                                                    <a href="#" class="profile-image">
                                                        <a href="#" class="profile-image">
                                                            <img src="<?php echo e(url('storage/' . \Auth::user()->avatar)); ?>"
                                                                class="avatar avatar-xl rounded-circle img-border height-100"
                                                                alt="Profile Image">
                                                        </a>
                                                    </a>
                                                </div>
                                                <div class="media-body ms-3 mt-1">
                                                    <h3 class="font-large-1 white">
                                                        <?php echo e(Auth::user()->name); ?>

                                                        <span class="font-medium-1 white">(<?php echo e(Auth::user()->role); ?>)</span>
                                                    </h3>
                                                    <div class="row justify-content-center">

                                                        <table class="table table-borderless table-responsive">

                                                            <tbody>

                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-map-marker-alt"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        <?php echo e(Auth::user()->address); ?>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-phone"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        <?php echo e(Auth::user()->phone); ?>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-envelope"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        <?php echo e(Auth::user()->email); ?>

                                                                    </td>
                                                                </tr>

                                                                 <?php if(Auth::user()->role == 'organisation' && Auth::user()->organisation): ?>
                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-building"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        <?php echo e(Auth::user()->organisation->organisation_code); ?>

                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overlay"></div>
            <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <!--end  vue page -->
    </div>
    <!-- END layout-wrapper -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/profile/show.blade.php ENDPATH**/ ?>
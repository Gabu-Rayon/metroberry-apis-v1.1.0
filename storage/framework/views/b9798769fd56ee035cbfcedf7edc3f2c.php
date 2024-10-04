<?php $__env->startSection('title', 'Billed Trips'); ?>
<?php $__env->startSection('content'); ?>

    <body class="fixed sidebar-mini">

        <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- react page -->
        <div id="app">
            <!-- Begin page -->
            <div class="wrapper">
                <!-- start header -->
                <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- end header -->
                <div class="content-wrapper">
                    <div class="main-content">
                        <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <?php if($billedTrips->isNotEmpty()): ?>
                                                    <?php $__currentLoopData = $billedTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisationName => $trips): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <h5><?php echo e($organisationName); ?></h5>
                                                        <table class="table" id="driver-table">
                                                            <thead>
                                                                <tr>
                                                                    <th title="Name">Customer</th>
                                                                    <th title="Billing Rate">Billing Rate</th>
                                                                    <th title="Total Price" width="150">Total Price</th>
                                                                    <th title="Billed At">Billed At</th>
                                                                    <th title="Trip Status">Status</th>
                                                                    <th title="Action" width="150">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td><?php echo e($trip->customer->user->name ?? 'N/A'); ?></td>
                                                                        <td><?php echo e($trip->billingRate->name ?? 'N/A'); ?></td>
                                                                        <td><?php echo e($trip->total_price); ?></td>
                                                                        <td><?php echo e(\Carbon\Carbon::parse($trip->billed_at)->format('F jS, Y \a\t h:i a')); ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php if($trip->status == 'billed'): ?>
                                                                                <span class="badge bg-success">Billed</span>
                                                                            <?php elseif($trip->status == 'paid'): ?>
                                                                                <span class="badge bg-success">Paid</span>
                                                                            <?php else: ?>
                                                                                <span class="badge bg-danger">Partially
                                                                                    Paid</span>
                                                                            <?php endif; ?>
                                                                        </td>

                                                                        <td class="text-center">
                                                                            <?php if(Auth::user()->can('pay for trip')): ?>
                                                                                <a href="<?php echo e(route('trip.payment.checkout', ['id' => $trip->id])); ?>"
                                                                                    class="btn btn-primary btn-sm"
                                                                                    title="Proceed to pay for your trip.">
                                                                                    <small><i
                                                                                            class="fa-solid fa-money-bill"></i></small>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <p>No billed trips available.</p>
                                                <?php endif; ?>
                                            </div>
                                            <div id="page-axios-data" data-table-id="#driver-table">
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

        <!-- Modal -->
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form">
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item? you won t be able to revert this item back!
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-danger" type="submit" id="delete_submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/trips/billed.blade.php ENDPATH**/ ?>
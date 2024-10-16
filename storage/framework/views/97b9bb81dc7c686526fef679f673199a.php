

<?php $__env->startSection('title', 'Checkout Vehicle Service'); ?>
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
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Service Payment</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="actions">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Status :</p>
                                                <?php if($service->service_status == 'billed'): ?>
                                                    <span class="badge bg-success">Billed</span>
                                                <?php elseif($service->service_status == 'paid'): ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Partially Paid</span>
                                                <?php endif; ?>
                                                <div class="accordion-header d-flex justify-content-end align-items-center"
                                                    id="flush-headingOne">
                                                    <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                        onclick="axiosModal('<?php echo e(route('billed.vehicle.service.send.invoice', ['id' => $service->id])); ?>')">
                                                        <i class="fa-solid fa-arrow-right"></i> &nbsp;
                                                        Send Vehicle Service Invoice
                                                    </a>

                                                    <span class="m-1"></span>
                                                    <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                        onclick="axiosModal('<?php echo e(route('billed.vehicle.service.resend.invoice', ['id' => $service->id])); ?>')">
                                                        <i class="fas fa-share-square"></i> &nbsp;
                                                        Resend Vehicle Service Invoice
                                                    </a>

                                                    <span class="m-1"></span>
                                                    <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                        onclick="axiosModal('<?php echo e(route('billed.vehicle.service.download.invoice', ['id' => $service->id])); ?>')">
                                                        <i class="fa-solid fa-download"></i> &nbsp;
                                                        Download Vehicle Service Invoice
                                                    </a>

                                                    <span class="m-1"></span>
                                                    <?php if(in_array($service->service_status, ['billed', 'partially paid'])): ?>
                                                        <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                            onclick="axiosModal('<?php echo e(route('billed.vehicle.service.receive.payment', ['id' => $service->id])); ?>')">
                                                            <i class="fa-solid fa-plus"></i> &nbsp;
                                                            Receive Vehicle Service Payment
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="col-md-12 col-lg-12">
                                            <table class="table" id="checkout-table">
                                                <thead>
                                                    <tr>
                                                        <th title="SrNo" width="30">SrNo</th>
                                                        <th title="Trip Route">Vehicle</th>
                                                        <th title="Billed By">Service Type</th>
                                                        <th title="Charges or Trip price ">Date </th>
                                                        <th title="Charges or Trip price ">Description </th>
                                                        <th title="Billed By"> Vehicle Plate</th>
                                                        <th title="Charges or Trip price ">Service Category </th>
                                                        <th title="Charges or Trip price ">Cost </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $item = 1 ?>
                                                    <tr>
                                                        <td><?php echo e($item++); ?></td>
                                                        <td> <?php echo e($service->vehicle->plate_number ?? null); ?></td>
                                                        <td> <?php echo e($service->serviceType->name); ?> </td>
                                                        <td><?php echo e($service->service_date); ?></td>
                                                        <td> <?php echo e($service->service_description); ?></td>
                                                        <td> <?php echo e($service->vehicle->plate_number ?? null); ?></td>
                                                        <td><?php echo e($service->serviceCategory->name); ?></td>
                                                        <td>Kes. <?php echo e($service->service_cost); ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right my-20"><strong>Total</strong>
                                                        </td>
                                                        <td><strong>Kes.<?php echo e($service->service_cost); ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right my-20">
                                                            <strong>Balance</strong>
                                                        </td>
                                                        <td><strong>Kes.<?php echo e($remainingAmount); ?></strong></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Receipt Summary</h6>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12 col-lg-12">
                                            <table class="table" id="checkout-table">
                                                <thead>
                                                    <tr>
                                                        <th title="PAYMENT RECEIPT" width="30">Payment Receipt</th>
                                                        <th title="Date">Date</th>
                                                        <th title="Date">Amount</th>
                                                        <th title="Payment Type">Payment Type</th>
                                                        <th title="Account">Account</th>
                                                        <th title="Reference">Reference</th>
                                                        <th title="description">Description</th>
                                                        <th title="Receipt ">Receipt</th>
                                                        <th title="ORDERID">OrderID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $ThisMaintenanceServicePayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td> <a href="<?php echo e(route('billed.vehicle.service.download.invoice', ['id' => $payment->id])); ?>"
                                                                    class="btn btn-primary btn-sm"> <i
                                                                        class="fa-solid fa-download"></i> &nbsp;</a></td>
                                                            <td><?php echo e($payment->payment_date); ?></td>
                                                            <td>Kes.<?php echo e($payment->total_amount); ?></td>
                                                            <td><?php echo e($payment->payment_type_code); ?></td>
                                                            <td><?php echo e($payment->account->holder_name); ?></td>
                                                            <td><?php echo e($payment->reference); ?></td>
                                                            <td><?php echo e($payment->remark); ?></td>
                                                            <td>
                                                                <a href="<?php echo e(asset($payment->payment_receipt)); ?>"
                                                                    download>
                                                                    <i class="fa-solid fa-file-pdf"></i> Receipt
                                                                </a>
                                                            </td>
                                                            </td>
                                                            <td><?php echo e($payment->invoice_no); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                            </table>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/vehicle/maintenance-services/serviceCheckout/vehicle-service-checkout.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', 'Checkout To A Trip'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Trip Route : <?php echo e($trip->route->name); ?>

                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="actions">
                                                <div class="accordion-header d-flex justify-content-end align-items-center"
                                                    id="flush-headingOne">
                                                    <?php if(\Auth::user()->can('send trip invoice')): ?>
                                                        <a href="<?php echo e(route('billed.trip.send.invoice', ['id' => $trip->id])); ?>"
                                                            class="btn btn-success btn-sm" title="Send Invoice.">
                                                            <i class="fas fa-arrow-right"></i> &nbsp;
                                                            Send Trip Invoice
                                                        </a>
                                                    <?php endif; ?>

                                                    <span class="m-1"></span>
                                                    <?php if(\Auth::user()->can('resend trip invoice')): ?>
                                                        <a href="<?php echo e(route('billed.trip.resend.invoice', ['id' => $trip->id])); ?>"
                                                            class="btn btn-success btn-sm" title="Resend Invoice.">
                                                            <i class="fas fa-share-square"></i> &nbsp;
                                                            Resend Trip Invoice
                                                        </a>
                                                    <?php endif; ?>

                                                    <span class="m-1"></span>
                                                    <?php if(in_array($trip->status, ['billed', 'partially paid'])): ?>
                                                        <?php if(Auth::user()->role == 'organisation'): ?>
                                                            <a class="btn btn-primary btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('<?php echo e(route('billed.trip.recieve.payment', ['id' => $trip->id])); ?>')">
                                                                <i class="fa-solid fa-plus"></i> &nbsp;
                                                                Pay My Trip
                                                            </a>
                                                        <?php elseif(Auth::user()->role == 'admin'): ?>
                                                            <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('<?php echo e(route('billed.trip.recieve.payment', ['id' => $trip->id])); ?>')">
                                                                <i class="fa-solid fa-plus"></i> &nbsp;
                                                                Receive Trip Payment
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <span class="m-1"></span>
                                                    <?php if(in_array($trip->status, ['billed', 'partially paid', 'paid'])): ?>
                                                        <?php if(\Auth::user()->can('download trip invoice')): ?>
                                                            <a href="<?php echo e(route('trip.download.invoice', ['id' => $trip->id])); ?>"
                                                                class="btn btn-primary btn-sm" title="Download.">
                                                                <small><i class="fa-solid fa-download"></i> &nbsp;</small>

                                                            </a>
                                                        <?php endif; ?>
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
                                        <div class="row">
                                            <div class="col-md-12 col-lg-6">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Customer :</p>
                                                <div class="form-group row my-2">
                                                    <label for="plate_number" class="col-sm-5 col-form-label"> Name <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->customer->user->name); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="fuel_type" class="col-sm-5 col-form-label">Address
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->customer->user->address); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="engine_size" class="col-sm-5 col-form-label">org Code
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->customer->customer_organisation_code); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Vehicle :</p>
                                                <div class="form-group row my-2">
                                                    <label for="plate_number" class="col-sm-5 col-form-label"> Plate No <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->vehicle->plate_number); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="plate_number" class="col-sm-5 col-form-label"> Model <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->vehicle->model); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="fuel_type" class="col-sm-5 col-form-label">Driver
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->vehicle->driver->user->name); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="engine_size" class="col-sm-5 col-form-label">Driver
                                                        Contact
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->vehicle->driver->user->phone); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="engine_size" class="col-sm-5 col-form-label">Vehicle Org
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->vehicle->organisation->user->name); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Customer Org :</p>
                                                <div class="form-group row my-2">
                                                    <label for="color" class="col-sm-5 col-form-label">Org name <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->customer->organisation->user->name); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="color" class="col-sm-5 col-form-label">Org Address <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        <?php echo e($trip->customer->organisation->user->address); ?>

                                                    </div>
                                                </div>
                                                <p class="mb-0 mr-3 text-dark fw-bold">Status :</p>
                                                <?php if($trip->status == 'billed'): ?>
                                                    <span class="badge bg-success">Billed</span>
                                                <?php elseif($trip->status == 'paid'): ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Partially Paid</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12">
                                            <table class="table" id="checkout-table">
                                                <thead>
                                                    <tr>
                                                        <th title="SrNo" width="30">SrNo</th>
                                                        <th title="Trip Route">Trip Route</th>
                                                        <th title="Billed By">Billed By</th>
                                                        <th title="Charges or Trip price ">Charges :</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $item = 1 ?>
                                                    <tr>
                                                        <td><?php echo e($item++); ?></td>
                                                        <td> <?php echo e($trip->route->name); ?></td>
                                                        <td> <?php echo e($trip->billed_by); ?></td>
                                                        <td>Kes. <?php echo e($trip->total_price); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right my-20"><strong>Total</strong>
                                                        </td>
                                                        <td><strong>Kes.<?php echo e($trip->total_price); ?></strong></td>
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
                                        <div class="col-md-12 col-lg-12">
                                            <div class="d-flex align-items-center mb-3">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Pay with IntaSend</p>
                                                <span></span>
                                                <img src="<?php echo e(asset('admin-assets/img/payment-img/intasend-icon-20x27.png')); ?>"
                                                    alt="IntaSend Logo" class="img-fluid">
                                            </div>
                                            <div class="bg-secondary bg-gradient border rounded p-3">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="<?php echo e(asset('admin-assets/img/payment-img/IntasendPaymentGateways.png')); ?>"
                                                        alt="IntaSend payments Gateways" class="mr-3">
                                                </div>
                                                <p class="mb-0 mt-6 text-white fw-bold text-left">Secure mobile and card
                                                    payments.</p>
                                            </div>
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
                                                    <?php $__currentLoopData = $ThisTripPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td> <a href="<?php echo e(route('billed.trip.download.invoice.receipt', ['id' => $payment->id])); ?>"
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/trips/tripPaymentCheckout.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Vehicle Inspection Certificates'); ?>
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
                                            <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Insepction Certificate(s)</h6>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <?php if(Auth::user()->can('export vehicle inspection certificates')): ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href=<?php echo e(route('vehicle.certificate.export')); ?>

                                                                title="Export">
                                                                <i class="fa-solid fa-file-export"></i>
                                                                &nbsp;
                                                                Export
                                                            </a>
                                                        <?php endif; ?>
                                                        <span class="m-1"></span>
                                                        <!-- <?php if(Auth::user()->can('import vehicle inspection certificates')): ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href=<?php echo e(route('vehicle.certificate.import')); ?>

                                                                title="Import">
                                                                <i class="fa-solid fa-file-import"></i>
                                                                &nbsp;
                                                                Import
                                                            </a>
                                                        <?php endif; ?> -->
                                                        <span class="m-1"></span>
                                                        <?php if(Auth::user()->can('create vehicle inspection certificate')): ?>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#vehicleInspectionCertificateModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp; Add Vehicle
                                                                Inspection Certificate
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Name">Certificate No</th>
                                                        <th title="Address">Vehicle</th>
                                                        <th title="Email">Issue Date</th>
                                                        <th title="Phone">Expiry Date</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e(Log::info('Certificate')); ?>

                                                        <?php echo e(Log::info($certificate)); ?>

                                                        <tr>
                                                            <td><?php echo e($certificate->ntsa_inspection_certificate_no); ?></td>
                                                            <td><?php echo e($certificate->vehicle->plate_number); ?></td>
                                                            <td><?php echo e($certificate->ntsa_inspection_certificate_date_of_issue); ?>

                                                            </td>
                                                            <td><?php echo e($certificate->ntsa_inspection_certificate_date_of_expiry); ?>

                                                            </td>
                                                           
                                                            <td>
                                                                <?php
                                                                    $avatar =
                                                                        $certificate->ntsa_inspection_certificate_avatar;

                                                                    if (!$avatar) {
                                                                        $badgeClass = 'badge bg-danger';
                                                                        $badgeText = 'Missing Document';
                                                                    } else {
                                                                        $expiryDate = \Carbon\Carbon::parse(
                                                                            $certificate->ntsa_inspection_certificate_date_of_expiry,
                                                                        );
                                                                        $today = \Carbon\Carbon::today();

                                                                        // Determine if the certificate has expired
                                                                        $isExpired = \Carbon\Carbon::parse($certificate->ntsa_inspection_certificate_date_of_expiry)->isPast();

                                                                        // Calculate days until expiry if the certificate has not expired
                                                                        $daysUntilExpiry = $isExpired
                                                                            ? 0
                                                                            : $today->diffInDays($expiryDate, false);

                                                                        Log::info(
                                                                            'Days until expiry: ' . $daysUntilExpiry,
                                                                        );

                                                                        if ($isExpired) {
                                                                            $badgeClass = 'badge bg-danger';
                                                                            $badgeText = 'Expired';
                                                                        } elseif (
                                                                            $daysUntilExpiry <= 30 &&
                                                                            $certificate->verified
                                                                        ) {
                                                                            $badgeClass = 'badge bg-warning text-dark';
                                                                            $badgeText = 'Expires Soon';
                                                                        } elseif (
                                                                            $daysUntilExpiry > 30 &&
                                                                            $certificate->verified
                                                                        ) {
                                                                            $badgeClass = 'badge bg-success';
                                                                            $badgeText = 'Valid';
                                                                        } else {
                                                                            $badgeClass = 'badge bg-warning text-dark';
                                                                            $badgeText = 'Pending Verification';
                                                                        }
                                                                    }
                                                                ?>
                                                                <span class="<?php echo e($badgeClass); ?>"><?php echo e($badgeText); ?></span>
                                                            </td>
                                                            <td class="d-flex">
                                                                <?php if(Auth::user()->can('edit vehicle inspection certificate')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('<?php echo e(route('vehicle.inspection.certificate.edit', $certificate->id)); ?>')"
                                                                        title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(!$certificate->verified): ?>
                                                                    <?php if(Auth::user()->can('activate vehicle inspection certificate')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('<?php echo e(route('vehicle.inspection.certificate.verify', $certificate->id)); ?>')"
                                                                            title="Verify">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php if(Auth::user()->can('deactivate vehicle inspection certificate')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('<?php echo e(route('vehicle.inspection.certificate.suspend', $certificate->id)); ?>')"
                                                                            title="Suspend">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(Auth::user()->can('delete vehicle inspection certificate')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('<?php echo e(route('vehicle.inspection.certificate.delete', $certificate->id)); ?>')"
                                                                        title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                    <?php ($expired = \Carbon\Carbon::parse($certificate->ntsa_inspection_certificate_date_of_expiry)->isPast()); ?>
                                                                    <?php if($expired): ?>
                                                                        <span class="m-1"></span>
                                                                        <a href="javascript:void(0);" class="btn btn-sm btn-warning"
                                                                           onclick="axiosModal('<?php echo e(route('vehicle.certificate.renew', $certificate->id)); ?>')">
                                                                            <i class="fas fa-sync"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="page-axios-data" data-table-id="#driver-table"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlay"></div>
                    <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="vehicleInspectionCertificateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('vehicle.inspection.certificate.create')); ?>" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Inspection Certificate</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="vehicle" class="col-sm-5 col-form-label">
                                        Vehicle
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="vehicle" class="form-control" id="vehicle" required>
                                            <option value="" disabled selected>Select a vehicle</option>
                                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->make); ?>

                                                    <?php echo e($vehicle->model); ?>,
                                                    <?php echo e($vehicle->plate_number); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="ntsa_inspection_certificate_date_of_issue" class="col-sm-5 col-form-label">
                                        Date of Issue
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="ntsa_inspection_certificate_date_of_issue" class="form-control"
                                            type="date" id="ntsa_inspection_certificate_date_of_issue" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="ntsa_inspection_certificate_no" class="col-sm-5 col-form-label">
                                        Certificate No
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="ntsa_inspection_certificate_no" class="form-control" type="text"
                                            placeholder="Certificate No" id="ntsa_inspection_certificate_no" required />
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <div class="col-sm-5 col-form-label">
                                        Requested By
                                        <i class="text-danger">*</i>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="form-control"><?php echo e(auth()->user()->name); ?></div>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="ntsa_inspection_certificate_date_of_expiry"
                                        class="col-sm-5 col-form-label">
                                        Date of Expiry
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="ntsa_inspection_certificate_date_of_expiry" class="form-control"
                                            type="date" id="ntsa_inspection_certificate_date_of_expiry" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="avatar" class="col-sm-5 col-form-label">
                                        Certificate Copy
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="avatar" class="form-control" type="file" accept="image/*"
                                            id="avatar" required />
                                        <img id="avatar_preview" class="form-control mt-2" style="display: none;" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('avatar').addEventListener('change', function() {
                            const file = this.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function() {
                                    const preview = document.getElementById('avatar_preview');
                                    preview.src = reader.result;
                                    preview.style.display = 'block';
                                };
                                reader.onerror = function(error) {
                                    console.error("Error reading file:", error);
                                };
                                reader.readAsDataURL(file);
                            } else {
                                document.getElementById('avatar_preview').style.display = 'none';
                            }
                        });
                    });
                </script>

            </div>
        </div>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/inspection-certificates/index.blade.php ENDPATH**/ ?>
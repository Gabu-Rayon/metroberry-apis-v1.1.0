<?php $__env->startSection('title', 'Routes'); ?>
<?php $__env->startSection('content'); ?>

    <body class="fixed sidebar-mini">
        <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div id="app">
            <div class="wrapper">
                <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="content-wrapper">
                    <div class="main-content">
                        <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Routes</h6>
                                            </div>
                                            <div class="text-end">
                                                <?php if(Auth::user()->can('export routes')): ?>
                                                    <a class="btn btn-success btn-sm" href=<?php echo e(route('route.export')); ?>

                                                        title="Export">
                                                        <i class="fa-solid fa-file-export"></i>
                                                        &nbsp;
                                                        Export
                                                    </a>
                                                <?php endif; ?>
                                                <span class='m-1'></span>
                                                <?php if(Auth::user()->can('import routes')): ?>
                                                    <a class="btn btn-success btn-sm" href="<?php echo e(route('route.import')); ?>"
                                                        title="Import From csv excel file">
                                                        <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                    </a>
                                                <?php endif; ?>
                                                <span class="m-1"></span>
                                                <?php if(Auth::user()->can('create route')): ?>
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#routeModal">
                                                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Route
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Name">Name</th>
                                                        <th title="Name">County</th>
                                                        <th title="Email">Start Location</th>
                                                        <th title="Address">Waypoints</th>
                                                        <th title="Phone">End Location</th>
                                                        <?php if(Auth::user()->role == 'admin'): ?>
                                                            <th title="Action" width="80">Action</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($route->name); ?></td>
                                                            <td><?php echo e($route->county); ?></td>
                                                            <td class="text-center">
                                                                <?php echo e($route->start_location->name ?? '-'); ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                    $waypoints = $route->waypoints->sortBy(
                                                                        'point_order',
                                                                    );
                                                                ?>
                                                                <?php $__currentLoopData = $waypoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $waypoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php echo e($waypoint->name); ?>

                                                                    <?php if(!$loop->last): ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </td>
                                                            <td class="text-center"><?php echo e($route->end_location->name ?? '-'); ?>

                                                            </td>
                                                            <?php if(Auth::user()->role == 'admin'): ?>
                                                                <td class="d-flex">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('route/<?php echo e($route->id); ?>/edit')">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <span class='m-1'></span>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('route/<?php echo e($route->id); ?>/delete')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
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
        </div>

        <div class="modal fade" id="routeModal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('route.store')); ?>" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Route</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="start_location" class="col-sm-5 col-form-label">
                                        Start Location <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="start_location" class="form-control" type="text"
                                            placeholder="Start Location" id="start_location" required />
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="county" class="col-sm-5 col-form-label">
                                        County <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="county" class="form-control" type="text" placeholder="County"
                                            id="county" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="end_location" class="col-sm-5 col-form-label">
                                        End Location <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="end_location" class="form-control" type="text"
                                            placeholder="End Location" id="end_location" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Organisation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this organisation? This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/route/index.blade.php ENDPATH**/ ?>
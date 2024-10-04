<?php $__env->startSection('title', 'Fuel Setting'); ?>
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
                            <!--/.Content Header (Page header)-->
                            <div class="body-content">
                                <div class="row">
                                    <div class="col-md-12 my-2">
                                        <?php echo $__env->make('components.site-setting.site-setting-nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card mb-4 p-5">
                                          <form action="<?php echo e(route('fuel.setting.update')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div>
        <fieldset>
            <legend>Station Code Prefix</legend>
            <div class="panel-body mt-1 mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <input id="station_code_prefix" class="form-control" type="text"
                            placeholder="Setting Station Code Prefix"
                            name="station_code_prefix" value="<?php echo e(old('station_code_prefix', $station_code_prefix)); ?>" />
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div>
        <fieldset>
            <legend>Station Requestion Code Prefix</legend>
            <div class="panel-body mt-1 mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <input id="station_requisition_prefix" class="form-control" type="text"
                            placeholder="Setting Station Requestion Code Prefix"
                            name="station_requisition_prefix" value="<?php echo e(old('station_requisition_prefix', $station_requisition_prefix)); ?>" />
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="d-flex justify-content-end mt-5">
        <button type="submit" class="btn btn-success">Save settings</button>
    </div>
</form>

                                            <span id="media-upload-url"
                                                data-file-upload-url="admin/setting/file-upload"></span>
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
        <!-- start scripts -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/settings/general-settings/fuel-setting.blade.php ENDPATH**/ ?>
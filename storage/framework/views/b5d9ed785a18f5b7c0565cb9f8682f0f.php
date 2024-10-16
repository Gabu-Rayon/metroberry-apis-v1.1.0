

<?php $__env->startSection('title', 'System Settings'); ?>
<?php $__env->startSection('content'); ?>

    <!-- No need for the body tag here; it's handled by the layout -->
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
                    <div class="tile">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="text-end">
                                        <?php echo $__env->make('components.site-setting.site-setting-nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <form action="<?php echo e(route('settings.site.update')); ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="alert alert-warning">
                                            <p>
                                                <strong>Note: </strong>
                                                Every change there will have a direct impact on your app's
                                                environment; this may cause your app to crash, so be careful with
                                                every change you make.
                                            </p>
                                        </div>

                                        <div>

                                            <fieldset>
                                                <legend>Site Url</legend>
                                                <div class="d-flex justify-content-between">
                                                    <div class="panel-heading my-2">
                                                        <code
                                                            class="badge badge-pill badge-info text-light setting_key"><?php echo e(url('/')); ?></code>
                                                        <a href="javascript:void(0);" class="panel-action-btn clipboard"
                                                            data-clipboard-text="<?php echo e(url('/')); ?>">
                                                            <i class="fas fa-clipboard"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="panel-body mt-1 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input id="site_url" class="form-control" type="text"
                                                                placeholder="Site Url" name="site_url" id="site_url"
                                                                value="<?php echo e(url('/')); ?>" />
                                                            <div class="my-1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <legend>Name</legend>
                                                <div class="d-flex justify-content-between">
                                                    <div class="panel-heading my-2">
                                                        <code
                                                            class="badge badge-pill badge-info text-light setting_key"><?php echo e(config('app.name')); ?></code>
                                                        <a href="javascript:void(0);" class="panel-action-btn clipboard"
                                                            data-clipboard-text="<?php echo e(config('app.name')); ?>">
                                                            <i class="fas fa-clipboard"></i>
                                                        </a>
                                                    </div>

                                                </div>
                                                <div class="panel-body mt-1 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input id="site_name" class="form-control" type="text"
                                                                placeholder="Setting Name" name="site_name" id="site_name"
                                                                value="<?php echo e(config('app.name')); ?>" />
                                                            <div class="my-1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <legend>Description</legend>
                                                <div class="d-flex justify-content-between">
                                                    <div class="panel-heading my-2">
                                                        <code
                                                            class="badge badge-pill badge-info text-light setting_key"><?php echo e(config('app.description')); ?></code>
                                                        <a href="javascript:void(0);" class="panel-action-btn clipboard"
                                                            data-clipboard-text="<?php echo e(config('app.description')); ?>">
                                                            <i class="fas fa-clipboard"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="panel-body mt-1 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <textarea class="form-control" name="app_description" id="app_description" placeholder="Description"><?php echo e(config('app.description')); ?></textarea>

                                                            <div class="my-1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <legend>Logo White</legend>
                                                <div class="d-flex justify-content-between">
                                                    <div class="panel-heading my-2">
                                                        <code
                                                            class="badge badge-pill badge-info text-light setting_key">setting('site.logo_light')</code>
                                                        <a href="javascript:void(0);" class="panel-action-btn clipboard"
                                                            data-clipboard-text="setting('site.logo_light')">
                                                            <svg width="18px" version="1.1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                viewBox="0 0 1000 1000"
                                                                enable-background="new 0 0 1000 1000" xml:space="preserve">
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="M761.3,924.7H108v-588h653.3v196h65.3V206c0-35.7-29.6-65.3-65.3-65.3h-196C565.3,68.2,507.1,10,434.7,10C362.2,10,304,68.2,304,140.7H108c-35.7,0-65.3,29.6-65.3,65.3v718.7c0,35.7,29.6,65.3,65.3,65.3h653.3c35.7,0,65.3-29.6,65.3-65.3V794h-65.3V924.7z M238.7,206c29.6,0,29.6,0,65.3,0s65.3-29.6,65.3-65.3c0-35.7,29.6-65.3,65.3-65.3c35.7,0,65.3,29.6,65.3,65.3c0,35.7,32.7,65.3,65.3,65.3c32.7,0,33.7,0,65.3,0s65.3,29.6,65.3,65.3H173.3C173.3,231.5,201.9,206,238.7,206z M173.3,728.7H304v-65.3H173.3V728.7z M630.7,598V467.3l-261.3,196l261.3,196V728.7h326.7V598H630.7z M173.3,859.3h196V794h-196V859.3z M500,402H173.3v65.3H500V402z M304,532.7H173.3V598H304V532.7z" />
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="panel-body mt-1 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mt-1 mb-2">

                                                                <a href="/">

                                                                    <img height="100" width="150"
                                                                        src="<?php echo e(asset($settings['logo_white'])); ?>"
                                                                        alt="Site Logo White">

                                                                </a>
                                                            </div>
                                                            <input id="site.logo_light" class="form-control" type="file"
                                                                placeholder="Logo White" name="logo_white"
                                                                accept="image/*" />
                                                            <div class="my-1">
                                                                Default image size 205x60
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <legend>Logo Black</legend>
                                                <div class="d-flex justify-content-between">
                                                    <div class="panel-heading my-2">
                                                        <code
                                                            class="badge badge-pill badge-info text-light setting_key">setting('site.logo_black')</code>
                                                        <a href="javascript:void(0);" class="panel-action-btn clipboard"
                                                            data-clipboard-text="setting('site.logo_black')">
                                                            <svg width="18px" version="1.1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                viewBox="0 0 1000 1000"
                                                                enable-background="new 0 0 1000 1000"
                                                                xml:space="preserve">
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="M761.3,924.7H108v-588h653.3v196h65.3V206c0-35.7-29.6-65.3-65.3-65.3h-196C565.3,68.2,507.1,10,434.7,10C362.2,10,304,68.2,304,140.7H108c-35.7,0-65.3,29.6-65.3,65.3v718.7c0,35.7,29.6,65.3,65.3,65.3h653.3c35.7,0,65.3-29.6,65.3-65.3V794h-65.3V924.7z M238.7,206c29.6,0,29.6,0,65.3,0s65.3-29.6,65.3-65.3c0-35.7,29.6-65.3,65.3-65.3c35.7,0,65.3,29.6,65.3,65.3c0,35.7,32.7,65.3,65.3,65.3c32.7,0,33.7,0,65.3,0s65.3,29.6,65.3,65.3H173.3C173.3,231.5,201.9,206,238.7,206z M173.3,728.7H304v-65.3H173.3V728.7z M630.7,598V467.3l-261.3,196l261.3,196V728.7h326.7V598H630.7z M173.3,859.3h196V794h-196V859.3z M500,402H173.3v65.3H500V402z M304,532.7H173.3V598H304V532.7z" />
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="panel-body mt-1 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mt-1 mb-2">

                                                                <a href="/">

                                                                    <img height="100" width="150"
                                                                        src="<?php echo e(asset($settings['logo_black'])); ?>"
                                                                        alt="Site Logo Black">

                                                                </a>
                                                            </div>
                                                            <input id="site.logo_light" class="form-control"
                                                                type="file" placeholder="Logo White" name="logo_black"
                                                                accept="image/*" />
                                                            <div class="my-1">
                                                                Default image size 205x60
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <legend>Favicon</legend>
                                                <div class="d-flex justify-content-between">
                                                    <div class="panel-heading my-2">
                                                        <code
                                                            class="badge badge-pill badge-info text-light setting_key">setting('site.favicon')</code>
                                                        <a href="javascript:void(0);" class="panel-action-btn clipboard"
                                                            data-clipboard-text="setting('site.favicon')">
                                                            <svg width="18px" version="1.1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                viewBox="0 0 1000 1000"
                                                                enable-background="new 0 0 1000 1000"
                                                                xml:space="preserve">
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="M761.3,924.7H108v-588h653.3v196h65.3V206c0-35.7-29.6-65.3-65.3-65.3h-196C565.3,68.2,507.1,10,434.7,10C362.2,10,304,68.2,304,140.7H108c-35.7,0-65.3,29.6-65.3,65.3v718.7c0,35.7,29.6,65.3,65.3,65.3h653.3c35.7,0,65.3-29.6,65.3-65.3V794h-65.3V924.7z M238.7,206c29.6,0,29.6,0,65.3,0s65.3-29.6,65.3-65.3c0-35.7,29.6-65.3,65.3-65.3c35.7,0,65.3,29.6,65.3,65.3c0,35.7,32.7,65.3,65.3,65.3c32.7,0,33.7,0,65.3,0s65.3,29.6,65.3,65.3H173.3C173.3,231.5,201.9,206,238.7,206z M173.3,728.7H304v-65.3H173.3V728.7z M630.7,598V467.3l-261.3,196l261.3,196V728.7h326.7V598H630.7z M173.3,859.3h196V794h-196V859.3z M500,402H173.3v65.3H500V402z M304,532.7H173.3V598H304V532.7z" />
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="panel-body mt-1 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mt-1 mb-2">

                                                                <a href="/">

                                                                    <img height="100" width="150"
                                                                        src="<?php echo e(asset($settings['site_favicon'])); ?>"
                                                                        alt="Site Favicon">

                                                                </a>
                                                            </div>
                                                            <input id="site.logo_light" class="form-control"
                                                                type="file" placeholder="Logo White"
                                                                name="site_favicon" accept="image/*" />
                                                            <div class="my-1">
                                                                Default image size 205x60
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                        </div>
                                        <div class="d-flex justify-content-end mt-5">
                                            <button type="submit" class="btn btn-success">Save
                                                settings</button>
                                        </div>

                                    </form>
                                </div>
                                <div id="page-axios-data" data-table-id="#driver-table"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="overlay"></div>
                <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <!-- end vue page -->
    </div>
    <!-- END layout-wrapper -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/settings/site.blade.php ENDPATH**/ ?>
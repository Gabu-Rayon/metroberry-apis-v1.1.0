<?php $__env->startSection('title', 'Mail Setting'); ?>
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
                                            <!--/.Content Header (Page header)-->
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="fs-17 fw-semi-bold mb-0">Mail setting</h6>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form action="<?php echo e(route('settings.mail.update')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>

                                                    <div class="alert alert-warning">
                                                        <p>
                                                            <strong>Note: </strong>
                                                            Any changes you make will directly affect your app's environment
                                                            and email process. This could cause your app to crash, so please
                                                            exercise caution with every modification.
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_mailer">Mail mailer</label>
                                                                <select name="mail_mailer" id="mail_mailer"
                                                                    class="form-control">
                                                                    <option value="smtp"
                                                                        <?php echo e(env('MAIL_MAILER') === 'smtp' ? 'selected' : ''); ?>>
                                                                        SMTP</option>
                                                                    <option value="sendmail"
                                                                        <?php echo e(env('MAIL_MAILER') === 'sendmail' ? 'selected' : ''); ?>>
                                                                        Sendmail</option>
                                                                    <option value="mailgun"
                                                                        <?php echo e(env('MAIL_MAILER') === 'mailgun' ? 'selected' : ''); ?>>
                                                                        Mailgun</option>
                                                                    <option value="ses"
                                                                        <?php echo e(env('MAIL_MAILER') === 'ses' ? 'selected' : ''); ?>>
                                                                        SES</option>
                                                                    <option value="postmark"
                                                                        <?php echo e(env('MAIL_MAILER') === 'postmark' ? 'selected' : ''); ?>>
                                                                        Postmark</option>
                                                                    <option value="log"
                                                                        <?php echo e(env('MAIL_MAILER') === 'log' ? 'selected' : ''); ?>>
                                                                        Log</option>
                                                                    <option value="array"
                                                                        <?php echo e(env('MAIL_MAILER') === 'array' ? 'selected' : ''); ?>>
                                                                        Array</option>
                                                                    <option value="failover"
                                                                        <?php echo e(env('MAIL_MAILER') === 'failover' ? 'selected' : ''); ?>>
                                                                        Failover</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_host">Mail host</label>
                                                                <input type="text" class="form-control" id="mail_host"
                                                                    name="mail_host" placeholder="Mail host name"
                                                                    value="<?php echo e(env('MAIL_HOST')); ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_port">Mail port</label>
                                                                <input type="number" class="form-control arrow-hidden"
                                                                    id="mail_port" name="mail_port"
                                                                    placeholder="Mail port number"
                                                                    value="<?php echo e(env('MAIL_PORT')); ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_username">Mail username</label>
                                                                <input type="text" class="form-control"
                                                                    id="mail_username" name="mail_username"
                                                                    placeholder="Mail username"
                                                                    value="<?php echo e(env('MAIL_USERNAME')); ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_password">Mail password</label>
                                                                <input type="password" class="form-control"
                                                                    id="mail_password" name="mail_password"
                                                                    placeholder="Mail password"
                                                                    value="<?php echo e(env('MAIL_PASSWORD')); ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_from_address">Sender email address</label>
                                                                <input type="text" class="form-control"
                                                                    id="mail_from_address" name="mail_from_address"
                                                                    placeholder="Sender email address"
                                                                    value="<?php echo e(env('MAIL_FROM_ADDRESS')); ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_from_name">Sender name</label>
                                                                <input type="text" class="form-control"
                                                                    id="mail_from_name" name="mail_from_name"
                                                                    placeholder="Sender name" value="${APP_NAME}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_encryption">Mail encryption</label>
                                                                <select id="mail_encryption" name="mail_encryption"
                                                                    class="form-control">
                                                                    <option value="tls"
                                                                        <?php echo e(env('MAIL_ENCRYPTION') === 'tls' ? 'selected' : ''); ?>>
                                                                        TLS</option>
                                                                    <option value="ssl"
                                                                        <?php echo e(env('MAIL_ENCRYPTION') === 'ssl' ? 'selected' : ''); ?>>
                                                                        SSL</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- SAVE CHANGES ACTION BUTTON -->
                                                        <div class="col-12 border-0 text-right mb-2 mt-1">
                                                            <button type="submit" class="btn btn-success">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/settings/mail.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('mobile-app-assets/css/bootstrap.min.css')); ?>" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo e(asset('mobile-app-assets/css/fontawesome.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('mobile-app-assets/css/chart.min.css')); ?>" />
    <script src="<?php echo e(asset('mobile-app-assets/js/chart.bundle.min.js ')); ?>"></script>
    <script src="<?php echo e(asset('mobile-app-assets/js/utils.js ')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('mobile-app-assets/css/owl.carousel.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('mobile-app-assets/css/owl.theme.css ')); ?>" />
    <!-- Main Style -->
    <link rel="stylesheet" href="<?php echo e(asset('mobile-app-assets/css/styles.css')); ?>" />
     <link href="<?php echo e(asset('mobile-app-assets/css/trips-table.css')); ?>"rel="stylesheet">
    <!--International Telephone input JS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">
    <script src="https://kit.fontawesome.com/e53bf7a0b8.js" crossorigin="anonymous"></script>
    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>

<body>
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/components/driver-mobile-app/header.blade.php ENDPATH**/ ?>
<?php
if (has_session('user')) {
    redirect('home');
}
?>
<!DOCTYPE html>
<html class="no-js before-run" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?php echo get_config('description'); ?>">
    <meta name="author" content="<?php echo get_config('author'); ?>">

    <title>Login | Immortal</title>

    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/bootstrap/css/bootstrap-extend.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/asscrollable/asScrollable.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/loadmask/loadmask.css'); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('fonts/roboto/roboto.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('fonts/web-icons/web-icons.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('css/style.css'); ?>">

    <link rel="stylesheet" href="<?php echo asset_url('css/login.css'); ?>">

    <script src="<?php echo asset_url('vendor/modernizr/modernizr.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/breakpoints/breakpoints.js'); ?>"></script>

    <script>

        Breakpoints();

        function baseUrl() {
            return '<?php echo base_url(); ?>';
        }

        function siteUrl(uri) {
            return '<?php echo site_url("'+uri+'"); ?>';
        }

    </script>

</head>

<body class="page-login layout-full">

    <?php  echo get_content(); ?>

    <script src="<?php echo asset_url('vendor/jquery/jquery.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/bootstrap/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/asscrollable/jquery.asScrollable.all.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/loadmask/loadmask.js'); ?>"></script>

    <script src="<?php echo asset_url('js/core.js'); ?>"></script>
    <script src="<?php echo asset_url('js/script.js'); ?>"></script>
    <script src="<?php echo asset_url('js/components/asscrollable.js'); ?>"></script>

    <script src="<?php echo asset_url('js/login.js'); ?>"></script>



</body>

</html>
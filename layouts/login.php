<?php
if (has_session('user')) {
    redirect('/');
}
?>
<!DOCTYPE html>
<html class="no-js before-run" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">

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

    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
        <div class="page-content vertical-align-middle">
            <div class="brand">
                <img class="brand-img" src="<?php echo asset_url('img/logo-small.png'); ?>" alt="...">
                <h2 class="brand-text">Immortal</h2>
            </div>
            <p>Sign into your pages account</p>
            <form id="form-login" method="post" action="<?php echo site_url('login/validate'); ?>">
                <div class="form-group">
                    <label class="sr-only" for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                </div>
                <div class="form-group clearfix">
                    <div class="checkbox-custom checkbox-inline pull-left">
                        <input type="checkbox" id="inputCheckbox" name="checkbox">
                        <label for="inputCheckbox">Remember me</label>
                    </div>
                    <a class="pull-right" href="forgot-password.html">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
            <p>Still no account? Please go to <a href="register.html">Register</a></p>

        </div>
    </div>

    <!-- modal -->
    <div class="modal modal-danger fade modal-fade-in-scale-up" id="modal-alert" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Login Error!</h4>
                </div>
                <div class="modal-body">
                    <p style="color: #222"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->

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
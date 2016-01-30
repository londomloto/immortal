<!doctype html>
<html>
<head>
    <title><?php echo get_config('title'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
</head>
<body>

    <div class="container vbox">

        <div class="header">
            <h1>pushstate.com</h1>
        </div>

        <div class="flex hbox">

            <div class="sidebar">
                <ul class="menu">
                    <li><a href="<?php echo site_url('home'); ?>" data-push="1">Homepage</a></li>
                    <li><a href="<?php echo site_url('products'); ?>" data-push="1">Products</a></li>
                    <li><a href="<?php echo site_url('about'); ?>" data-push="1">About Us</a></li>

                    <li><a href="http://www.facebook.com" target="_blank">Facebook</a></li>
                </ul>
            </div>

            <div class="flex tampungan">

            	<?php echo get_content(); ?>

            </div>

        </div>
    </div>


    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/script.js"></script>

</body>
</html>
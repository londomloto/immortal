<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo get_config( 'title'); ?>
    </title>

    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/bootstrap/css/bootstrap-extend.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/asscrollable/asScrollable.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('vendor/loadmask/loadmask.css'); ?>">
    
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('fonts/roboto/roboto.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('fonts/web-icons/web-icons.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url('css/style.css'); ?>">

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

<body>

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided" data-toggle="menubar">
                <span class="sr-only">Toggle navigation</span>
                <span class="hamburger-bar"></span>
            </button>
            <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
                <i class="icon wb-more-horizontal" aria-hidden="true"></i>
            </button>
            <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search" data-toggle="collapse">
                <span class="sr-only">Toggle Search</span>
                <i class="icon wb-search" aria-hidden="true"></i>
            </button>
            <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
                <img class="navbar-brand-logo" src="<?php echo asset_url('img/logo.png'); ?>" title="Immortal">
                <span class="navbar-brand-text"> Immortal</span>
            </div>
        </div>

        <div class="navbar-container container-fluid">
            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
                <!-- Navbar Toolbar -->
                <ul class="nav navbar-toolbar navbar-right">
                    <li class="hidden-xs" id="toggleFullscreen">
                        <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                            <span class="sr-only">Toggle fullscreen</span>
                        </a>
                    </li>
                    <li class="hidden-float">
                        <a class="icon wb-search" data-toggle="collapse" href="#site-navbar-search" role="button">
                            <span class="sr-only">Toggle Search</span>
                        </a>
                    </li>
                    <li class="hidden-float" id="toggleMenubar">
                        <a data-toggle="menubar" href="#" role="button">
                            <i class="icon hamburger hamburger-arrow-left">
                              <span class="sr-only">Toggle menubar</span>
                              <span class="hamburger-bar"></span>
                            </i>
                        </a>
                    </li>

                </ul>
                <!-- End Navbar Toolbar -->
                
            </div>
            <!-- End Navbar Collapse -->

            <!-- Site Navbar Seach -->
            <div class="collapse navbar-search-overlap" id="site-navbar-search">
                <form role="search">
                    <div class="form-group">
                        <div class="input-search">
                            <i class="input-search-icon wb-search" aria-hidden="true"></i>
                            <input type="text" class="form-control" name="site-search" placeholder="Search...">
                            <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search" data-toggle="collapse" aria-label="Close"></button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Site Navbar Seach -->
        </div>
    </nav>
    <div class="site-menubar">
        <div class="site-menubar-body">
            <div>
                <div>
                    <ul class="site-menu">
                        <li class="site-menu-category">General</li>
                        
                        <li class="site-menu-item">
                            <a class="animsition-link" href="<?php echo site_url('home'); ?>" data-push="1">
                                <i class="site-menu-icon wb-menu" aria-hidden="true"></i>
                                <span class="site-menu-title">Home</span>
                            </a>
                        </li>

                        <li class="site-menu-item">
                            <a class="animsition-link" href="<?php echo site_url('table'); ?>" data-push="1">
                                <i class="site-menu-icon wb-menu" aria-hidden="true"></i>
                                <span class="site-menu-title">Table</span>
                            </a>
                        </li>

                        <li class="site-menu-item">
                            <a class="animsition-link" href="<?php echo site_url('crud-product'); ?>" data-push="1">
                                <i class="site-menu-icon wb-menu" aria-hidden="true"></i>
                                <span class="site-menu-title">CRUD Products</span>
                            </a>
                        </li>

                    </ul>
                    
                </div>
            </div>
        </div>

        <div class="site-menubar-footer">
            <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Settings">
                <span class="icon wb-settings" aria-hidden="true"></span>
            </a>
            <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
                <span class="icon wb-eye-close" aria-hidden="true"></span>
            </a>
            <a href="<?php echo site_url('logout'); ?>" data-push="1" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
                <span class="icon wb-power" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div class="site-gridmenu">
        <ul>
            <li>
                <a href="#">
                    <i class="icon wb-envelope"></i>
                    <span>Mailbox</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon wb-calendar"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon wb-user"></i>
                    <span>Contacts</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon wb-camera"></i>
                    <span>Media</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon wb-order"></i>
                    <span>Documents</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon wb-image"></i>
                    <span>Project</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon wb-chat-group"></i>
                    <span>Forum</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon wb-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="page">
        <div class="page-content">
            <?php echo get_content(); ?>
        </div>
    </div>

    <footer class="site-footer">
        <span class="site-footer-legal">© 2015 Immortal</span>
        <div class="site-footer-right">
            crafted with <i class="red-600 wb wb-heart"></i> by <a href="http://supernova.xyz/">supernova</a>
        </div>
    </footer>

    <script src="<?php echo asset_url('vendor/jquery/jquery.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/bootstrap/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/asscroll/jquery-asScroll.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/mousewheel/jquery.mousewheel.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/asscrollable/jquery.asScrollable.all.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/ashoverscroll/jquery-asHoverScroll.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/screenfull/screenfull.js'); ?>"></script>
    <script src="<?php echo asset_url('vendor/loadmask/loadmask.js'); ?>"></script>
    
    
    <script src="<?php echo asset_url('js/core.js'); ?>"></script>
    <script src="<?php echo asset_url('js/script.js'); ?>"></script>

    <script src="<?php echo asset_url('js/components/asscrollable.js'); ?>"></script>



</body>

</html>
<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="description" content="Sabilulungan - Bansos dan hibah online">
    <meta name="copyright" content="2016 Sabilulungan. All rights reserved.">

    <title>Sabilulungan - Bansos dan hibah online</title>

    <link rel="icon" type="image/png" href="<?php echo base_url('static/img/favicon.png') ?>">
    <link rel="stylesheet" href="<?php echo base_url('static/css/main.css') ?>">

    <script>var HOST = "<?php echo base_url() ?>";</script>    
    <script type="text/javascript">var base_urls = "<?php echo base_url() ?>", site_urls = "<?php echo site_url() ?>";</script>

    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/form.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/login.js') ?>"></script>

    <script src="<?php echo base_url('static/js/vendor/modernizr-2.6.2.min.js') ?>"></script>
</head>

<body>
    <noscript>
        <p align="center">This application rich of javascript, please enabled your JavaScript browser</p>
    </noscript>
    <header role="banner" class="header-main clearfix">
    <div class="wrapper">
        <a class="logo" href="<?php echo base_url() ?>">
            <img src="<?php echo base_url('static/img/logo.png') ?>" alt="" height="36" width="180">
        </a>
        <nav role="navigation" class="nav-main">
            <ul class="clearfix list-nostyle">
                <li>
                    <a class="link-green" href="<?php echo site_url('tentang') ?>">Tentang Sabilulungan</a>
                </li>
                <li>
                    <a class="link-blue" href="<?php echo site_url('proposal') ?>">Proposal Hibah Bansos</a>
                </li> 
                <li>
                    <a class="link-purple" href="<?php echo site_url('peraturan') ?>">Peraturan</a>
                </li> 
                <li>
                    <a class="link-green" href="<?php echo site_url('lapor') ?>">Lapor</a>
                </li> 
            </ul>
        </nav>
        <!-- nav-main -->
        <div class="nav-user list-nostyle clearfix">
            <form class="form-search-header">
                <input type="text" placeholder="Cari">
                <a class="btn-search btn-ir" href="#">Search</a>
            </form>
            <!-- <a class="btn-user btn-ir" href="<?php echo site_url('login') ?>">User</a> -->
            <a class="logo-bandung" href="http://bandung.go.id/">
                <img src="<?php echo base_url('static/img/logo-bandung.png') ?>" alt="">
            </a>
            <a class="logo-bandung" href="<?php echo site_url('login') ?>" style="margin-top:3px;margin-right:10px">
                <img src="<?php echo base_url('static/img/btn-user.png') ?>" alt="">
            </a>
        </div>
        <!-- nav-user -->
    </div>
    <!-- wrapper -->
    <div class="nav-user-panel nav-sub-panel" style="display: none;">
        <div class="wrapper clearfix">
            <form class="form-signin-header" action="<?php echo site_url('process/login') ?>">
                <input type="text" name="uname" placeholder="Username">
                <input type="password" name="pswd" placeholder="Password">
                <button class="btn-login btn-red btn-plain btn" type="submit">Masuk</button>
                <span class="link-register">/ <a href="<?php echo site_url('daftar') ?>">Daftar</a></span>
            </form>
            <!-- <ul class="user-links list-nostyle">
                <li class="username">
                    Vostro Robert
                </li>
                <li>
                    <a href="#">Edit Profile</a>
                </li>
                <li class="signout">
                    <a class="btn-red btn-plain btn" href="#">Keluar</a>
                </li>
            </ul> -->
        </div>
        <!-- <div style="font-size:10px;margin-left:53.5%;"><a href="<?php echo site_url('sandi') ?>" style="color:#FFF">Lupa Kata Sandi ?</a></div> -->
    </div>
    <!-- nav-user -->
    </header>
    <!-- header-main -->

    <div role="main" class="content-main">
        <div class="wrapper-half">
            <div id="page-container">
                <div id="login">
                    <h1 class="page-title page-title-border">Log in</h1>
                    <form class="form-global" method="post" action="<?php echo site_url('login') ?>" id="iflogin_f" onsubmit="return iFlogin_s()">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="">Username</label>
                                <div class="controls">
                                    <input type="text" name="uname" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="">Password</label>
                                <div class="controls">
                                    <input type="password" name="pswd" required>
                                </div>
                            </div>
                            <div class="control-actions clearfix">
                                <input type="hidden" id="timereload" value="2" />
                                <button class="btn-red btn-plain btn" type="submit">Masuk</button>
                            </div>
                        </fieldset>
                    </form>
                    <!-- form-register -->
                </div>
            </div>
        </div>
        <!-- wrapper-half -->
    </div>
    <!-- content-main -->

    <footer role="contentinfo" class="footer-main">
        <div class="wrapper clearfix">
            <a class="logo-footer" href="<?php echo base_url() ?>">
                <img src="<?php echo base_url('static/img/logo-footer.png') ?>" alt="">
            </a>
            <ul class="social-links list-nostyle clearfix">
                <li>
                    <a class="btn-facebook btn-ir" href="#">Facebook</a>
                </li>
                <li>
                    <a class="btn-twitter btn-ir" href="#">Twitter</a>
                </li>
            </ul>
            <!-- social-links -->
            <p class="copyright">Pemerintah Kota Bandung © 2016</p>

            <!-- Start of StatCounter Code for Default Guide -->
            <div style="text-align:center;margin-top:12px;color:#FFF;font-size:14px">
                Pengunjung :
                <script type="text/javascript">
                var sc_project=10741566; 
                var sc_invisible=0; 
                var sc_security="2e35f489"; 
                var scJsHost = (("https:" == document.location.protocol) ?
                "https://secure." : "http://www.");
                document.write("<sc"+"ript type='text/javascript' src='" +
                scJsHost+
                "statcounter.com/counter/counter.js'></"+"script>");
                </script>
                <noscript><div class="statcounter"><a title="web analytics"
                href="http://statcounter.com/" target="_blank"><img
                class="statcounter"
                src="http://c.statcounter.com/10741566/0/2e35f489/0/"
                alt="web analytics"></a></div></noscript>
                <!-- End of StatCounter Code for Default Guide -->
            </div>
        </div>
    </footer>
    <!-- footer-main -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url('static/js/vendor/jquery-1.10.2.min.js') ?>"><\/script>')</script>
    <script src="<?php echo base_url('static/js/vendor/jquery.fancybox.pack.js') ?>"></script>
    <script src="<?php echo base_url('static/js/vendor/zebra_datepicker.js') ?>"></script>

    <script src="<?php echo base_url('static/js/main.js') ?>"></script>
</body>
</html>
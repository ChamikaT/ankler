<?php
$uploadOk = false;
$file_uploaded = false;
if (isset($_POST["submit"]) && !empty($_FILES)) {
    $file_uploaded = true;
    $target_dir = "upload/";
    $target_file = $target_dir . 'TestDiagram.png';
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (!empty($_FILES["bpmn_diagram"]["tmp_name"])) {
        $check = getimagesize($_FILES["bpmn_diagram"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = true;
        } else {
            $uploadOk = false;
        }

        if ($uploadOk) {
            if(file_exists($target_file)) unlink($target_file);
            if (move_uploaded_file($_FILES["bpmn_diagram"]["tmp_name"], $target_file)) {
                chmod($target_file, 0777);
                $command = escapeshellcmd('python /opt/lampp/htdocs/ankle-injury/upload/roi.py');
                $output = shell_exec($command);
                error_log($command);
                error_log($output);
            } else {
                $uploadOk = false;
            }
        }
    } else {
        $uploadOk = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Ankle Injury</title>

    <!-- Css Starts-->

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Icons CSS -->
    <!--<link href="css/fontawesome.min.css" rel="stylesheet">-->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/themify-icons.css" rel="stylesheet">

    <!-- Meanmenu CSS -->
    <link href="css/meanmenu.css" rel="stylesheet">

    <!-- Owl Carousel CSS -->
    <link href="css/owl.carousel.css" rel="stylesheet">

    <!-- Magnific Popup CSS -->
    <link href="css/magnific-popup.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/file_upload.css" rel="stylesheet">

    <!-- Css Ends-->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- Preloader -->
<div id="overlay">
    <div class="spinner"></div>
</div>
<!-- /Preloader -->

<!-- Header Top -->
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <ul class="top-info">
                    <li><i class="fa fa-envelope-o"></i><a href="mailto:chamikathilan8375@gmail.com">chamikathilan8375@gmail.com</a>
                    </li>
                    <li><i class="fa fa-phone"></i><a href="tel:+94713587045">(+94) 71 358 70 45</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="top-social">
                    <a href="https://www.facebook.com/profile.php?id=100004407460173"><i class="fa fa-facebook"></i></a>
                    <a href="https://www.linkedin.com/in/chamika-haputhanthri-691abaa2"><i
                                class="fa fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/in/chamika-haputhanthri-691abaa2/"><i class="fa fa-linkedin"></i></a>
                    <a href="https://google.lk"><i class="fa fa-google-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
</div><!-- /Header Top -->

<!-- Header Area -->
<header id="sticky-header" class="gray-bg">
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="logo">
                        <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt=""/></a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="main-menu text-right">
                        <nav>
                            <ul class="menu">
                                <li><a href="index.html#">Home <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="about-02.html">About <i class="fa fa-angle-down"
                                                                     aria-hidden="true"></i></a>
                                </li>

                                <li><a href="blog-details.html">Experience <i class="fa fa-angle-down"
                                                                              aria-hidden="true"></i></a>
                                </li>
                                <li><a href="contact.html">Contact <i class="fa fa-angle-down"
                                                                      aria-hidden="true"></i></a>
                                </li>
                                <li id="login-btn"><a href="login.php">Login</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="mobile-menu"></div>
                </div>
            </div>
        </div>
    </div><!-- /.Navigation -->
</header><!-- /Header Area -->

<div class="page-wrapper">


    <!-- Signup Area -->
    <section class="signup-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="signup">
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <div class="col-sm-12">
                                <div class="upload">
                                    <div class="upload-files">
                                        <header>
                                            <p>
                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                                <span class="up">up</span>
                                                <span class="load">load</span>
                                            </p>
                                        </header>
                                        <div class="body" id="drop">
                                            <i class="fa fa-file-text-o pointer-none" aria-hidden="true"></i>
                                            <p class="pointer-none"><b>Drag and drop</b> BPMN knowledge model here <br/>
                                                or <a href="" id="triggerFile">browse</a> to begin the upload</p>
                                            <input type="file" multiple="multiple" name="bpmn_diagram"
                                                   id="bpmn_diagram"/>
                                        </div>
                                        <footer>
                                            <div class="divider">
                                                <span><AR>FILES</AR></span>
                                            </div>
                                            <div class="list-files">
                                                <!--   template   -->
                                            </div>
                                            <button hidden class="importar">UPDATE FILES</button>
                                        </footer>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button name="submit" type="submit">Generate XML</button>
                            </div>
                        </form>
                        <!--								<p><a href="signup.html">Don't you have account? Signup!</a></p>-->
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Signup Area -->

    <!-- Footer Area -->
    <footer class="site-footer footer-v2 footer-overlay"
            style="background:url('images/banner/11.jpg') no-repeat fixed;">
        <div class="container">
            <div class="row">
                <!--<div class="site-bottom clearfix">-->
                <!--<div class="col-md-2 col-sm-6 site-bottom-1">-->
                <!--<aside class="widget widget-nav">-->
                <!--<h3 class="widget-title">Pages</h3>-->
                <!--<ul class="menu">-->
                <!--<li><a href="index.html#">About</a></li>-->
                <!--<li><a href="index.html#">Services</a></li>-->
                <!--<li><a href="index.html#">Latest news</a></li>-->
                <!--<li><a href="index.html#">Team</a></li>-->
                <!--<li><a href="index.html#">Contact</a></li>-->
                <!--</ul>-->
                <!--</aside>-->
                <!--</div>-->
                <!--<div class="col-md-3 col-sm-6 site-bottom-3">-->
                <!--<aside class="widget widget-nav">-->
                <!--<h3 class="widget-title">Terms</h3>-->
                <!--<ul class="menu">-->
                <!--<li><a href="index.html#">FAQ’s</a></li>-->
                <!--<li><a href="index.html#">Privecy & Policy</a></li>-->
                <!--<li><a href="index.html#">Terms & Conditions</a></li>-->
                <!--<li><a href="index.html#">Lience Policy</a></li>-->
                <!--<li><a href="index.html#">404 Policy</a></li>-->
                <!--</ul>-->
                <!--</aside>-->
                <!--</div>-->
                <!--<div class="col-md-4 col-sm-6 site-bottom-2">-->
                <!--<aside class="widget widget-nav">-->
                <!--<h3 class="widget-title">Twitter feed</h3>-->
                <!--<div class="twitter-feed">-->
                <!--<div class="twitter-feed-icon">-->
                <!--<i class="fa fa-twitter"></i>-->
                <!--</div>-->
                <!--<div class="twitter-feed-content">-->
                <!--<p>Our every products has a grate discount. Get 50% discount to get started with <a-->
                <!--href="index.html">#Wordpress</a> <a href="index.html">#discount</a><br/><a-->
                <!--href="index.html">http://t.co/Wa8Hg98Okg</a></p>-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="twitter-feed">-->
                <!--<div class="twitter-feed-icon">-->
                <!--<i class="fa fa-twitter"></i>-->
                <!--</div>-->
                <!--<div class="twitter-feed-content">-->
                <!--<p><a href="index.html">@RidoyRajoan</a> Hi Weblos, I need a website to build. Can-->
                <!--you help me?</p>-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="twitter-feed">-->
                <!--<div class="twitter-feed-icon">-->
                <!--<i class="fa fa-twitter"></i>-->
                <!--</div>-->
                <!--<div class="twitter-feed-content bor-btm-none">-->
                <!--<p>Themerio: <a href="index.html">#design</a> vs <a href="index.html">#analysis</a>-->
                <!--which one you will prefer? <br/><a href="index.html">http://t.co/Zo71Uh9ObG</a>-->
                <!--</p>-->
                <!--</div>-->
                <!--</div>-->
                <!--</aside>-->
                <!--</div>-->
                <!--<div class="col-md-3 col-sm-6 site-bottom-4">-->
                <!--<aside class="widget widget-text">-->
                <!--<h3 class="widget-title">Newsletter</h3>-->
                <!--<p>Subscribe to our newsletter to receive news, updates, free stuff and new releases by-->
                <!--email. We don't do spam.</p>-->
                <!--<form class="form-newsletter-ft" action="index.html#" method="get">-->
                <!--<input name="email" placeholder="Enter your email" required="" type="email">-->
                <!--<input value="Go" type="submit">-->
                <!--</form>-->
                <!--</aside>-->
                <!--</div>-->
                <!--</div>-->
                <!-- .site-bottom -->
                <div class="bottom-footer">
                    <div class="col-md-6 col-sm-4 pull-right">
                        <div class="socials">
                            <ul>
                                <li><a href="index.html#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="index.html#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="index.html#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="index.html#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="index.html#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="index.html#"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="copyright">
                            <p>&copy; 2018 All Rights Reserved Ankler.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .row -->
        </div>
    </footer><!-- /Footer Area -->
    <div class="popup-wrap-success">
        <div class="popup-box-success">
            <h2>Successfully Uploaded!</h2>
            <h3>The BPMN Diagram is successfully uploaded and converted into XML</h3>
            <a class="close-btn popup-close-success" href="#">x</a>
        </div>
    </div>
    <div class="popup-wrap-fail">
        <div class="popup-box-fail">
            <h2>Uploaded Failed!</h2>
            <h3>An Error Occured while uploading. Please check file type.</h3>
            <a class="close-btn popup-close-fail" href="#">x</a>
        </div>
    </div>

</div>

<!-- Scroll To Top Button -->
<!--		<a class="page-scroll" href="login.php#page-top" id="toTop"><span class="ti-rocket"></span></a>-->



<!-- Jquery JS -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="js/bootstrap.min.js"></script>

<script>
    var uploadOk = -1;
    <?php if ($uploadOk && $file_uploaded) {  ?>
    uploadOk = 1;
    <?php } else if ($file_uploaded) { ?>
    uploadOk = 0;
    <?php } ?>
    $(document).ready(function() {
        console.debug('ready....');
        console.debug(uploadOk);
        if (uploadOk == 1) {
            $('.popup-wrap-success').fadeIn(500);
            $('.popup-box-success').removeClass('transform-out').addClass('transform-in');
        }

        $('.popup-close-success').click(function(e) {
            $('.popup-wrap-success').fadeOut(500);
            $('.popup-box-success').removeClass('transform-in').addClass('transform-out');

            e.preventDefault();
        });
        if (uploadOk == 0) {
            $('.popup-wrap-fail').fadeIn(500);
            $('.popup-box-fail').removeClass('transform-out').addClass('transform-in');
        }

        $('.popup-close-fail').click(function(e) {
            $('.popup-wrap-fail').fadeOut(500);
            $('.popup-box-fail').removeClass('transform-in').addClass('transform-out');

            e.preventDefault();
        });
    });
</script>
<!-- Smooth Scroll JS -->
<script src="js/SmoothScroll.js"></script>

<!-- Jquery Easing Plugin -->
<script src="js/jquery.easing.min.js"></script>

<!-- Meanmenu Plugin -->
<script src="js/jquery.meanmenu.js"></script>

<!-- Jquery Scroll To Top Plugin -->
<script src="js/jquery.scrollToTop.min.js"></script>

<!-- Jquery Form Validation Plugin -->
<script src="js/jqBootstrapValidation.js"></script>

<!-- Magnific Popup Plugin JS -->
<script src="js/magnific-popup.min.js"></script>

<!-- Owl Carousel Plugin -->
<script src="js/owl.carousel.min.js"></script>

<!-- Isotope JS -->
<script src="js/isotope.pkgd.min.js"></script>

<!-- parallax Plugin -->
<script src="js/parallax.min.js"></script>

<!-- waypoints Plugin -->
<script src="js/waypoints.min.js"></script>

<!-- Coverter Plugin -->
<script src="js/converter.js"></script>

<!-- Contact Form Javascript -->
<script src="js/contact.js"></script>

<!-- CounterUp Plugin -->
<script src="js/jquery.counterup.js"></script>

<!-- Main Javascript -->
<script src="js/main.js"></script>

<script src="js/file_upload.js"></script>

</body>

</html>

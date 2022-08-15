<?php
include_once 'layout/header.php';
?>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution="setup_tool"
  page_id="1547673565358465">
</div>
<div id="owl-home" class="owl-carousel owl-theme home-slider">
    <div class="item">
        <div class="h-slider-bg">
            <img class="slide-bg" src="media/home-slider/slide-1.jpg" alt="banner-1">
        </div>
        <div class="wrapper s-custom">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="b-s-desc main-slider_fadeInLeft ">CREATING THE BEST NATURAL EXPERIENCE</div>
                <h1 class="s-custom-3">We Craft Your Farming<br />With Art & Technology</h1>
                <a class="btn-1 h-slide-btn" href="#">GET IN TOUCH</a>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="h-slider-bg">
            <img class="slide-bg" src="media/home-slider/slide-2.jpg" alt="banner-2">
        </div>
        <div class="wrapper">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>We Craft Your Farming<br />With Art & Technology</h1>
                <div class="b-s-text">
                </div>
            </div>
        </div>
    </div>
</div>

<section class="tools-bg border-top-line dash-top-line">
    <div class="top-icon-block"></div>
    <div class="wrapper text-center circle-box circle-box-3">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                <div class="c-link-box lb-left wow fadeInLeft">
                    <a class="btn big-circle" href="#">
                        <span class="c-content-block">
                            <span class="ef icon_clock"></span>
                            <span class="b-text">Working Hours</span>
                        </span>
                    </a>
                    <div class="c-box-info">
                        <div class="c-info">Monday - Friday : 9AM to 6PM</div>
                        <div class="c-info">Saturday : 10AM to 3PM</div>
                        <div class="c-info">Sunday : 11AM to 3PM</div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="c-link-box lb-center wow fadeInUp">
                    <a class="btn big-circle" href="#">
                        <span class="c-content-block">
                            <span class="ef icon_phone"></span>
                            <span class="b-text">Support Helpline</span>
                        </span>
                    </a>
                    <div class="c-box-info">
                        <div class="big-info">+91 7982472119</div>
                        <div class="b-info">We offer our customers 24 hrs helpline.<br />Got a question? Call Us Now</div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="c-link-box lb-right wow fadeInRight">
                    <a class="btn big-circle" href="#">
                        <span class="c-content-block">
                            <span class="ef icon_globe-2"></span>
                            <span class="b-text">Get In Touch NOW</span>
                        </span>
                    </a>
                    <div class="c-box-info">
                        <div class="b-info">IEC college of Engg.<br />Greater Noida, UP</div>
                        <div class="c-info">+91 7982472119</div>
                        <div class="c-info">info@crozeal.com</div>
                    </div>
                </div>

            </div>
        </div>
        <div class="el-image-left hidden-xs hidden-sm"></div>
        <div class="el-image-right hidden-xs hidden-sm"></div>
    </div>
    <div class="tooth-color-w"></div>
</section>
<?php
include_once 'includes/product_block_section2.php';
?>
<section class="b-row-3-el custom-8">
    <div class="wrapper">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="listing l-row-3">
                    <ul>
                        <li class="wow bounce">
                            <span class="fl-ic flaticon-gardening4"></span>
                            <div class="list-content">
                                <h4>Excellent Services</h4>
                                <div>We provide Excellent Services to the customer.</div>
                            </div>
                        </li>
                        <li class="wow bounce">
                            <span class="fl-ic flaticon-plants5"></span>
                            <div class="list-content">
                                <h4>All Quotes Free</h4>
                                <div>We provide quotes free of cost.</div>
                            </div>
                        </li>
                        <li class="wow bounce">
                            <i class="fl-ic flaticon-cutting8"></i>
                            <div class="list-content">
                                <h4>Insured Operators</h4>
                                <div>Nam lobortis fringilla felis sce sed utpat mi at urna cras ut nec.</div>
                            </div>
                        </li>
                        <li class="wow bounce">
                            <span class="fl-ic flaticon-sunny23"></span>
                            <div class="list-content">
                                <h4>Satisfied Customers</h4>
                                <div>Nam lobortis fringilla felis sce sed utpat mi at urna cras ut nec.</div>
                            </div>
                        </li>
                        <li class="wow bounce">
                            <span class="fl-ic flaticon-shower5"></span>
                            <div class="list-content">
                                <h4>Guaranteed Work</h4>
                                <div>Nam lobortis fringilla felis sce sed utpat mi at urna cras ut nec.</div>
                            </div>
                        </li>
                        <li class="wow bounce">
                            <span class="fl-ic flaticon-shovel16"></span>
                            <div class="list-content">
                                <h4>Quality and Reliability</h4>
                                <div>Nam lobortis fringilla felis sce sed utpat mi at urna cras ut nec.</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="color-bg extra-color-bg">
    <div class="wrapper">
        <div class="row-4">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wow bounceInDown center">
                <div class="row-2-blocks row-2-blocks-2">
                    <div class="r-block-1">
                        <div class="c-content-block">
                            <h2>We Have Over 1000 Satisfied Customers & Growing ..</h2>
                            <div>Friendly customer service staff for your all questions!</div>
                        </div>
                    </div>
                    <div class="r-block-2">
                        <div class="btn big-circle">
                            <div class="big-text">
                                GET in touch today!
                            </div>
                            <div class="sm-text">
                                We'll fix all your Problems!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tooth-color-gr"></div>
</section>

<?php
include_once 'includes/product_block_section.php';
?>

<?php
//                  include_once 'includes/product_block_section2.php';
?>
<section class="box-tools-bg block-bg">
    <div class="wrapper">
        <div class="row-1">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wow fadeInDown top__element">
                <div class="row-2-blocks">
                    <div class="r-block-1">
                        <div class="c-content-block">
                            <h2>We Provide 24 Hours Helpline</h2>
                            <div>Friendly customer service staff for your all questions!</div>
                        </div>
                    </div>
                    <div class="r-block-2">
                        <div class="btn big-circle very-big-circle">
                            <span class="ef icon_phone"></span>
                            <span class="v-center">+91 120 416 3900</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tooth-color-gr"></div>
</section>

<script src="js/pages/product_block_section.js"/>

<?php
include_once 'layout/footer.php';
?>

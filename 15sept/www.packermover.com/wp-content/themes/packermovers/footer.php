<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Packer_movers
 * @since Packer Movers 1.0
 */
?>

<section class="advisory style-2">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="text-wrapper">
          <h2>Not sure which solution fits you business needs?</h2>
        </div>
      </div>
      <div class="col-md-6 text-xs-right">
        <div class="btn-wrapper">
          <button type="button" class="btn btn-primary bg-dark">CONTACT US<i class="fa fa-map-marker"></i></button>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <aside class="widget widget_text"><h3 class="widget-title"><span>About Us</span></h3>
          <div class="textwidget footerlogo_style">
            <p>
               <?php the_custom_logo(); ?><br>
              Transport offers a host of logistic management services and supply chain solutions. We provide innovative solutions with the best people, processes, and technology.
            </p>
          </div>
        </aside>
        <div class="social-menu">
            <ul id="social-menu-footer" class="menu">
              <li class="menu-item">
                <a href="http://facebook.com"><i class="fa fa-facebook"></i></a>
              </li>
              <li class="menu-item">
                <a href="http://twitter.com"><i class="fa fa-google-plus"></i></a>
              </li>
              <li class="menu-item">
                <a href="http://plus.google.com"><i class="fa fa-twitter"></i></a>
              </li>
              <li class="menu-item">
                <a href="http://linkedin.com"><i class="fa fa-youtube-play"></i></a></li>
              <li class="menu-item">
                <a href="http://foursquare.com"><i class="fa fa-vimeo-square"></i></a></li>
              <li class="menu-item">
                <a href="/feed"><i class="fa fa-dribbble"></i></a>
              </li>
            </ul>
          </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <aside id="better-menu-widget-2" class="widget better-menu-widget">
          <h3 class="widget-title"><span>Information</span></h3>
          <div class="menu-information-container">
            <ul id="menu-information" class="menu">
              <li><a href="">About Us</a></li>
              <li><a href="">Classic Blog</a></li>
              <li><a href="">Cart</a></li>
              <li><a href="">Checkout</a></li>
              <li><a href="">Contact</a></li>
              <li><a href="">My Account</a></li>
              <li><a href="">Our Services</a></li>
              <li><a href="">Shop</a></li>
              <li><a href="">Contact</a></li>
              <li><a href="">Classic Blog</a></li>
            </ul>
          </div>
        </aside>
      </div>
      <div class="col-sm-6 col-md-4">
        <aside class="widget widget_text">
          <h3 class="widget-title"><span>Transport Office</span></h3>
          <div class="textwidget">
            <div class="office">
              <p><i class="fa fa-map-marker"></i> 5050 Surya vihar - 2, Faridabad, haryana.
              </p>
              <p><i class="fa fa-phone"></i> (+91) 8587 8584 258 </p>
              <p><i class="fa fa-envelope"></i> info@nationalcargo.in </p>
              <p><i class="fa fa-fax"></i> (+91) 8587 8584 258 </p>
              <p><i class="fa fa-clock-o"></i> Mon - Sat: 9:00 - 18:00</p>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</footer>

<div class="copyright">
  <div class="container">
    <div class="row">
      <div class="col-md-4 left">
          Thanks for visit.
      </div>
      <div class="col-md-8">
        <div class="right">
          © Copyrights 2018 National Cargo. All rights reserved.
        </div>
      </div>
    </div>
  </div>
</div>


  </div>

  <script src="<?php bloginfo("template_directory"); ?>/components/owl.carousel/dist/owl.carousel.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/countUp.js/dist/countUp.min.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/jQuery.mmenu/dist/core/js/jquery.mmenu.min.all.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/tether/tether.min.js"></script><!-- Tether for Bootstrap -->
  <script src="<?php bloginfo("template_directory"); ?>/components/bootstrap/dist/js/bootstrap.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/parallax.js/parallax.min.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/sliphover/src/jquery.sliphover.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/lightslider/dist/js/lightslider.min.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/lightgallery/dist/js/lightgallery.min.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/components/lightgallery/dist/js/lightgallery-all.min.js"></script>

  <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
  <script src="<?php bloginfo("template_directory"); ?>/js/vendor/gmap3.min.js"></script>
  <script src="<?php bloginfo("template_directory"); ?>/js/vendor/jquery.elevateZoom-3.0.8.min.js"></script>

  <script src="<?php bloginfo("template_directory"); ?>/js/main.js"></script>
  <?php wp_footer(); ?>
</body>
</html>

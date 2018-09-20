<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Packer_movers
 * @since Packer Movers 1.0
 */
?>
<!DOCTYPE html>
<html lang="" class="page-home">
<head>

  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HTML</title>

  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/owl.carousel/dist/assets/owl.carousel.css" />
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/jQuery.mmenu/dist/core/css/jquery.mmenu.all.css" />
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/lightslider/dist/css/lightslider.min.css" />
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/lightgallery/dist/css/lightgallery.css" />
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/owl.carousel/dist/assets/owl.theme.default.min.css" />

  <!-- Slider -->
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/slider/css/settings.css" />
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/components/slider/css/slider.css" />

  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/css/main.css">
  <link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/css/mystyle.css">

  <script src="<?php bloginfo("template_directory"); ?>/components/jquery/dist/jquery.js"></script>

  <!-- REVOLUTION JS FILES -->
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/jquery.themepunch.tools.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/jquery.themepunch.revolution.min.js"></script>

  <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.actions.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.carousel.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.kenburn.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.migration.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.navigation.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.parallax.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.slideanims.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo("template_directory"); ?>/components/slider/js/extensions/revolution.extension.video.min.js"></script>

</head>
<body>

  <div id="page" class="hfeed site">
    
<nav id="mobile-menu">
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#about">About us</a>
      <ul>
        <li><a href="#about/history">History</a></li>
        <li><a href="#about/team">The team</a>
          <ul>
            <li><a href="#about/team/management">Management</a></li>
            <li><a href="#about/team/sales">Sales</a></li>
            <li><a href="#about/team/development">Development</a></li>
          </ul>
        </li>
        <li><a href="#about/address">Our address</a></li>
      </ul>
    </li>
    <li><a href="#contact">Contact</a></li>
  </ul>
</nav>

<header class="site-header style-1">
  <div class="container">
    <div class="row">
      <div class="col-xs-10 col-lg-2 site-branding">
        
		  <?php the_custom_logo(); ?>
        
      </div>
      <div class="col-lg-10 hidden-md-down">
        <div class="site-info">
          <div class="top-menu-bar">
            <div class="row">
              <div class="col-md-8 col-xl-9">
                <div class="top-menu">
                  <ul id="top-menu" class="menu">
                    <li class="menu-item menu-item-has-children">
                      <a href="#">Sitemap</a>
                    </li>
                    <li class="menu-item menu-item-has-children">
                      <a href="#">Disclaimer</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-md-4 col-xl-3">
                <div class="social-menu">
                  <ul id="social-menu-top" class="menu">
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
                    <li id="menu-item680" class="menu-item">
                      <a href="http://foursquare.com"><i class="fa fa-vimeo-square"></i></a></li>
                    <li id="menu-item681" class="menu-item">
                      <a href="/feed"><i class="fa fa-dribbble"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="contact-bar">
            <div class="row">
              <div class="col-lg-10 col-xl-11">
                <div class="contact-detail">
                  <div class="row">
                    <div class="col-md-4 col-xl-3 col-xl-offset-1">
                      <i class="fa fa-phone"></i>
                      <h3>1-775-97-377</h3>
                      <span>info@thememove.com</span>
                    </div>
                    <div class="col-md-4">
                      <i class="fa fa-home"></i>
                      <h3>14 Tottenham Road</h3>
                      <span>London, England.</span>
                    </div>
                    <div class="col-md-4">
                      <i class="fa fa-clock-o"></i>
                      <h3>Mon - Sat : 9AM - 6PM</h3>
                      <span>Opening Time</span>
                    </div>
                  </div>
                </div>
              </div>
              <!--<div class="col-lg-1 hidden-xs hidden-sm hidden-md search-box">
                <a href="#search"><i class="fa fa-search"></i></a>
              </div>
              <div class="col-xs-2 col-lg-1 hidden-xl-up">
                <a class="trigger-menu" href="#mobile-menu"></a>
              </div>-->
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-2 col-lg-1 hidden-lg-up">
        <a class="trigger-menu" href="#mobile-menu"></a>
      </div>
    </div>
  </div>
</header>

<div id="search">
  <button type="button" class="close">×</button>
  <form>
    <input type="search" value="" placeholder="type keyword(s) here" />
    <button type="submit" class="btn btn-primary">SEARCH</button>
  </form>
</div>

<nav class="navbar mega navbar-dark bg-dark hidden-lg-down">
  <div class="container">
  
	<?php
		

		
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container' => 'ul',
			'menu_class'=> 'nav navbar-nav'
		 ) );
	
	
	?>
  
    <!--<ul class="nav navbar-nav">

      <li class="nav-item dropdown active">
        <a class="nav-link" href="index.html" role="button" aria-haspopup="true" aria-expanded="false">HOME <span class="sr-only">(current)</span></a>
        </li>

      <li class="nav-item dropdown active">
        <a class="nav-link" href="index.html" role="button" aria-haspopup="true" aria-expanded="false">ABOUT <span class="sr-only">(current)</span></a>
       </li>

      <li class="nav-item dropdown mega-fw">
        <a class="nav-link rttAngl" role="button" aria-haspopup="true" aria-expanded="false" href="javascript:;">OUR SERVICES</a>
        <div class="dropdown-menu" style="display:" >
          <div class="mega-content megamenu_cstm">
            <div class="row">

              <img class="mega-menu-img" src="<?php bloginfo('template_url'); ?>/images/menu/menu-img.png" alt="Transport Menu Image">

              <ul class="col-sm-8 col-sm-offset-3  list-unstyled megahrzl_menu">
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">Home Shifting</a></h6></li>
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">Office Relocation Services</a></h6></li>
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">Long & Short-term Storage</a></h6></li>
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">Vehicle Moving</a></h6></li>
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">International Relocations</a></h6></li>
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">Insurance Services</a></h6></li>
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">Home Assist</a></h6></li>
                <li class="feature-list-item"><h6 class="feature-list-title"><a href="#">Fine Art Move Experts</a></h6></li>
              </ul>
             
            </div>
          </div>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" href="javascript:;">REVIEWS</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="contact.html">CONTACT US</a>
      </li>

    </ul>-->
    

  </div>
</nav>

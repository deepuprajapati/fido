<?php
ob_start();
session_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$fileBasePath = dirname(__FILE__);
include_once($fileBasePath.'/config.php');
include_once($config['DOC_ROOT'].'include/functions.php');

include_once($config['DOC_ROOT'].'model/admin.class.php');
include_once($config['DOC_ROOT'].'model/user.class.php');
include_once($config['DOC_ROOT'].'model/category.class.php');
include_once($config['DOC_ROOT'].'model/project.class.php');
include_once($config['DOC_ROOT'].'model/commonClass.php');
include_once($config['DOC_ROOT'].'model/mailerClass.php');

if(!isset($_COOKIE['client_info'])){
	header('Location: logout.php');
	exit();
}

$userinfo = json_decode($_COOKIE['client_info'],true);
//dd($userinfo);

?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="Flat, Clean, Responsive, application admin template built with bootstrap 3">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->
    <link rel="stylesheet" href="asset/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- /page level plugin styles -->
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    <!-- core styles -->
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/font-awesome.css">
    <link rel="stylesheet" href="asset/css/themify-icons.css">
    <link rel="stylesheet" href="asset/css/animate.min.css">
    <link rel="stylesheet" href="asset/plugins/datepicker/datepicker.css">
    <link rel="stylesheet" href="asset/plugins/timepicker/jquery.timepicker.css">
    <link rel="stylesheet" href="asset/plugins/colorpicker/css/colorpicker.css">
    <link rel="stylesheet" href="asset/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="asset/plugins/bootstrap-colorpalette/bootstrap-colorpalette.css">
    <!-- /core styles -->
    <link href="asset/css/bootstrap-switch.css" rel="stylesheet">
    <!-- template styles -->
    <link rel="stylesheet" href="asset/css/skins/palette.css" id="skin">
    <link rel="stylesheet" href="asset/css/fonts/font.css">
    <link rel="stylesheet" href="asset/css/main.css">
    <link rel="stylesheet" href="asset/css/pnotify.custom.min.css">
    <!-- template styles -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- load modernizer -->
    <style>
    .btn-block{
        height: 110px;
      }
    </style>
    <script src="asset/plugins/modernizr.js"></script>

</head>
<!-- body -->

<body class="skin-black" >

    <div class="overlay bg-color"></div>
    <div class="app horizontal-layout boxed">
        <!-- top header -->
        <header class="header header-fixed navbar">

            <div class="brand">
                <!-- toggle offscreen menu -->
                <a href="javascript:;" class="ti-menu navbar-toggle off-left visible-xs" data-toggle="collapse" data-target="#hor-menu"></a>
                <!-- /toggle offscreen menu -->

                <!-- logo -->
                <a href="javascript:;" class="navbar-brand">
                    <img src="img/logo.png" alt="">
                    <span class="heading-font">
                        FIDO
                    </span>
                </a>
                <!-- /logo -->
            </div>

            <div class="collapse navbar-collapse pull-left" id="hor-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown">
                            <span>Components</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:;">
                                    <span>Buttons</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>General Elements</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Typography</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Tabs and Accordions</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Fontawesome Icons</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Themify Icons</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Grid Layout</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Widgets</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown">
                            <span>Layouts</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:;">
                                    <span>Small Menu</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Right Side Menu</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Chat Sidebar</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Language Switcher</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Layout With Footer</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Horizontal Menu</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Boxed Layout</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Horizontal Boxed</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Fixed Header &amp; Scrollable Layout</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Blank Page</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown">
                            <span>Pages</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:;">
                                    <span>Mailbox</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Mail View</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Compose</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Invoice</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Signin</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Signup</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Forgot Password</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Lock Screen</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>404 Page</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>500 Page</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Change Log</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Timeline</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Catalog</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span>Chat</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>

            <ul class="nav navbar-nav">
                <li class="header-search">
                    <!-- toggle search -->
                    <a href="javascript:;" class="toggle-search">
                        <i class="ti-search"></i>
                    </a>
                    <!-- /toggle search -->
                    <div class="search-container">
                        <form role="search">
                            <input type="text" class="form-control search" placeholder="type and press enter">
                        </form>
                    </div>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown hidden-xs">
                    <a href="javascript:;" data-toggle="dropdown">
                        <i class="ti-more-alt"></i>
                    </a>
                    <ul class="dropdown-menu animated zoomIn">
                        <li class="dropdown-header">Quick Links</li>
                        <li>
                            <a href="javascript:;">Start New Campaign</a>
                        </li>
                        <li>
                            <a href="javascript:;">Review Campaigns</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:;">Settings</a>
                        </li>
                        <li>
                            <a href="javascript:;">Wish List</a>
                        </li>
                        <li>
                            <a href="javascript:;">Purchases History</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:;">Activity Log</a>
                        </li>
                        <li>
                            <a href="javascript:;">Settings</a>
                        </li>
                        <li>
                            <a href="javascript:;">System Reports</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:;">Help</a>
                        </li>
                        <li>
                            <a href="javascript:;">Report a Problem</a>
                        </li>
                    </ul>
                </li>

                <li class="notifications dropdown">
                    <a href="javascript:;" data-toggle="dropdown">
                        <i class="ti-bell"></i>
                        <div class="badge badge-top bg-danger animated flash">
                            <span>3</span>
                        </div>
                    </a>
                    <div class="dropdown-menu animated fadeInLeft">
                        <div class="panel panel-default no-m">
                            <div class="panel-heading small"><b>Notifications</b>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="javascript:;">
                                        <span class="pull-left mt5 mr15">
                                            <img src="img/faceless.jpg" class="avatar avatar-sm img-circle" alt="">
                                        </span>
                                        <div class="m-body">
                                            <div class="">
                                                <small><b>CRYSTAL BROWN</b></small>
                                                <span class="label label-danger pull-right">ASSIGN AGENT</span>
                                            </div>
                                            <span>Opened a support query</span>
                                            <span class="time small">2 mins ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javascript:;">
                                        <div class="pull-left mt5 mr15">
                                            <div class="circle-icon bg-danger">
                                                <i class="ti-download"></i>
                                            </div>
                                        </div>
                                        <div class="m-body">
                                            <span>Upload Progress</span>
                                            <div class="progress progress-xs mt5 mb5">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                </div>
                                            </div>
                                            <span class="time small">Submited 23 mins ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javascript:;">
                                        <span class="pull-left mt5 mr15">
                                            <img src="img/faceless.jpg" class="avatar avatar-sm img-circle" alt="">
                                        </span>
                                        <div class="m-body">
                                            <em>Status Update:</em>
                                            <span>All servers now online</span>
                                            <span class="time small">5 days ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>

                            <div class="panel-footer">
                                <a href="javascript:;">See all notifications</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="off-right">
                    <a href="javascript:;" data-toggle="dropdown">
                        <img src="img/faceless.jpg" class="header-avatar img-circle" alt="" title="">
                        <span class="hidden-xs ml10"><?php echo (isset($userinfo['name']))?ucfirst($userinfo['name']):'';?></span>
                        <i class="ti-angle-down ti-caret hidden-xs"></i>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
                        <li>
                            <a href="javascript:;">
                                <div class="badge bg-danger pull-right">3</div>
                                <span>Notifications</span>
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
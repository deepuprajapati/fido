<?php
ob_start();
session_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

// check for time is user inactive

if(!isset($_COOKIE['isActive']))
{ 
    $currentPage =  $_SERVER['SCRIPT_FILENAME'];
    $query = '';
    if ($_SERVER['QUERY_STRING'] != '') {
        $query = "?".$_SERVER['QUERY_STRING'];
    }
    
    header('Location: logout.php?redirect='.end(explode("/", $currentPage)).$query);
    exit();
}
else{
    setcookie("isActive", true, time() + (60 * 30));
}

if(!isset($_COOKIE['user_info'])){
    header('Location: logout.php');
    exit();
}

$userinfo = json_decode($_COOKIE['user_info'],true);
if(isset($_COOKIE['permission_info'])){
$permissioninfo = json_decode($_COOKIE['permission_info'],true);
}


$fileBasePath = dirname(__FILE__);
include_once($fileBasePath.'/config.php');
include_once($config['DOC_ROOT'].'include/functions.php');

include_once($config['DOC_ROOT'].'model/admin.class.php');
include_once($config['DOC_ROOT'].'model/user.class.php');
include_once($config['DOC_ROOT'].'model/category.class.php');
include_once($config['DOC_ROOT'].'model/project.class.php');
include_once($config['DOC_ROOT'].'model/commonClass.php');
include_once($config['DOC_ROOT'].'model/mailerClass.php');

if(isset($_GET['search'])){
    $search_for_datables = trim($_GET['search']);
}
else{
    $search_for_datables='';
}

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>#ARM FIDO</title>
        <!-- page level plugin styles -->
        <link rel="stylesheet" href="asset/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- /page level plugin styles -->
        <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
        <!-- core styles --> 
        <link rel="stylesheet" href="asset/plugins/chosen/chosen.min.css">
        <link rel="stylesheet" href="asset/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="asset/plugins/datatables/jquery.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.bootstrap.min.css">

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
        <link rel="stylesheet" href="asset/css/mystyle_inner.css?ver<?php echo time(); ?>">
        
        
        <link rel="icon" type="image/png" href="asset/img/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="asset/img/favicon-16x16.png" sizes="16x16" />
        
        <!-- template styles -->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <!-- load modernizer -->
      <script src="asset/plugins/modernizr.js"></script>
        <style>
        .redd{
        color: #d53817;
        }
        .greens{
        color: #20d415;
        }
        #usertable_filter > label{
        position: relative;
        }
        #usertable_filter > label:after{
        content: "\f002";
        font-family: fontawesome;
        position: absolute;
        left: 15px;
        top: 7px;
        font-size: 14px;
        }
        #usertable_filter > label > input{
        padding-left: 26px;
        }

        .nav>li>a:hover, .nav>li>a:focus {
        text-decoration: none;
        background-color: #4f5061;
        }
        .app .sidebar ul>li {
        position: relative;
        display: block;
        z-index: 9;
        }
        .nav>li>a.toggle-sidebar:hover i, .nav>li>a.toggle-sidebar:focus i{
        color : #fff;
        }
        .p18{
        font-size: 18px !important;
        }
        .menu-red{
            font-size: 10px;
            width: 350px;
        }
        .menu-green{
            font-size: 10px;
            width: 350px;
        }
    
        </style>
       <!-- Hotjar Tracking Code for https://armworldwide.com/fido/ -->
        <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:871718,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118803472-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-118803472-1');
</script>
        <script>
        
        var data_search = '<?php echo $search_for_datables; ?>';
        </script>
    </head>

    <body class="skin-black">
        <div class="app small-menu">
            <!-- top header -->
            <header class="header header-fixed navbar">
                <div class="brand">
                    <!-- toggle offscreen menu -->
                    <a href="javascript:;" class="ti-menu off-left visible-xs" data-toggle="offscreen" data-move="ltr"></a>
                    <!-- /toggle offscreen menu -->
                    <!-- logo -->
                    <a href="<?php echo $_COOKIE['url_info']; ?>" class="navbar-brand" style="text-align:center;">
                        <img src="asset/img/LogoPNG.png" alt=""> <span class="heading-font">
                    </span> </a>
                    <!-- /logo -->
                </div>
                
                <!-- Notification area -->
                <ul class="nav navbar-nav navbar-right">
                    
                        <li class="notifications dropdown clckIcon_ntcn">
                            <a data-toggle="dropdown" class="red_noti" href="javascript:;"> <i class="redd fa fa-bell fa-2x" aria-hidden="true"></i>
                                <div class="badge badge-top bg-danger animated flash"> 
                                    <span class="count-red">0</span> 
                                </div> 
                    
                            </a>
                          <div class="dropdown-menu animated  ntfction_custmStyle">
                            <div class="panel panel-default no-m">
                            <div class="panel-heading small"><b>Notifications</b>
                            </div>
                             <ul class="list-group menu-red cstmUl_Scrl">
                                    
                            </ul>
                            <div class="panel-footer" style="padding: 0px;">
                                &nbsp;
                             </div>
                        </div>
                          </div>
                            
                        </li>
                    <li class="notifications dropdown">
                        
                            <a data-toggle="dropdown" href="javascript:;" class="green_noti"> 
                                
                                    <i class="greens fa fa-bell fa-2x" aria-hidden="true"></i>
                                    
                               
                                <div class="badge badge-top bg-success animated flash"> 
                                    <span class="count-green">0</span> 
                                </div> 
                            </a>
                    <div class="dropdown-menu  animated  ntfction_custmStyle">
                        <div class="panel panel-default no-m">
                            <div class="panel-heading small"><b>Notifications</b>
                            </div>
                             <ul class="list-group menu-green cstmUl_Scrl">
                                    
                            </ul>
                            <div class="panel-footer" style="padding: 0px;">
                                &nbsp;
                             </div>
                        </div>
                    </div>   
                        </li>
                    <?php
                        $userarray=array(1,6,5);
                        if(in_array($userinfo['type'], $userarray)){
    ?>
                        <li class="notifications dropdown">
                            <a data-toggle="dropdown" href="javascript:;"> <i class="fa fa-cog fa-2x" aria-hidden="true"></i>
                            </a>
                            <!--<div class="dropdown-menu animated fadeInLeft">
                                <div class="panel panel-default no-m">
                                    <div class="list-group">
                                      <a href="managePartner.php" class="list-group-item">Client Management</a>
                                    </div>
                            <div class="list-group">
                                <a href="partner.php" class="list-group-item">Publisher Management</a>
                            </div>
                            <div class="list-group">
                                <a href="userManagement.php" class="list-group-item">User Management</a>
                            </div>
                            <div class="list-group">
                                <a href="category.php" class="list-group-item">Manage Services</a>
                            </div>
                            <div class="list-group">
                                <a href="finance.php" class="list-group-item">Finance Management</a>
                            </div>
                            <div class="list-group">
                                <a href="payment.php" class="list-group-item">Client Payment</a>
                            </div>
                            <div class="list-group">
                                <a href="saleRegister.php" class="list-group-item">Sale Register</a>
                            </div>
                            <div class="list-group">
                                <a href="javascript:;" class="list-group-item">Purchase Register</a>
                            </div>
                             <div class="list-group">
                                <a href="projection.php" class="list-group-item">AOP </a>
                            </div>
                                </div>
                            </div>-->
                           
                            <ul class="dropdown-menu animated fadeInLeft cstmDropdwn_stle">
                                <?php 
                             $usermediaarray=array(5);
                            if(in_array($userinfo['type'], $usermediaarray)){?>
                            <li><a href="partner.php" >Publisher Management</a></li>
                                <?php }else{ ?>
                            <li><a href="managePartner.php" >Client Management</a></li>
                            <li><a href="partner.php" >Publisher Management</a></li>
                            <li><a href="userManagement.php" >User Management</a> </li>
                            <li><a href="category.php" >Manage Services</a></li>
                            <li><a href="finance.php" >Finance Management</a></li>
                            <li><a href="payment.php" >Client Payment</a></li>
                            <li><a href="saleRegister.php" >Sale Register</a></li>
                            <li><a href="javascript:;" >Purchase Register</a></li>
                            <li><a href="projection.php" >AOP </a></li>
                            <?php }?>
                            </ul>
                        </li>
                        <?php } ?>
                            <li class="off-right">
                                <a href="javascript:;" data-toggle="dropdown"> <img src="asset/img/faceless.jpg" class="header-avatar img-circle" alt="user" title="user"> <span class="hidden-xs ml10">
                                    <?php echo (isset($userinfo['name']))?ucfirst($userinfo['name']):'';?></span> <i class="ti-angle-down ti-caret hidden-xs"></i> </a>
                                <ul class="dropdown-menu animated fadeInLeft cstmDropdwn_stle">
                                     <li> <a href="profile.php">Profile</a> </li>
                                      <li> <a href="profile.php">Change Password</a> </li>
                                    <li> <a href="logout.php">Logout</a> </li>
                                </ul>
                            </li>
                </ul>
            </header>
            <!-- /top header -->
            <section class="layout">

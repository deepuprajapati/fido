<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// check for time is user inactive

if(!isset($_COOKIE['isActive']))
{ 
    $currentPage =  $_SERVER['SCRIPT_FILENAME'];
    header('Location: logout.php?redirect='.end(explode("/", $currentPage)));
    exit();
}
else{
    setcookie("isActive", true, time() + (60 * 20));
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
<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="theme-color" content="#1C2B36" />
    <title>#ARM FIDO</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="asset-new/img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="asset-new/img/favicon-16x16.png" sizes="16x16" />
    <!-- /Favicon -->
    <!-- Global stylesheets -->
    <link type="text/css" rel="stylesheet" href="asset-new/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="asset-new/css/animate.min.css">
    <link type="text/css" rel="stylesheet" href="asset-new/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="asset-new/css/butterfly-iconic.css">
    <!-- /Global stylesheets -->
    <!-- Page css -->
    <!--<link type="text/css" rel="stylesheet" href="asset-new/assets/icons/weather/weather-icons.min.css">
    <link type="text/css" rel="stylesheet" href="asset-new/assets/icons/weather/weather-icons-wind.min.css">-->
    <link type="text/css" rel="stylesheet" href="asset-new/css/theme.css">
    <link type="text/css" rel="stylesheet" href="asset-new/css/style.css">
<!-- /Global stylesheets -->
<?php
ob_start();
session_start();

/**
*	THIS FILE IS FOR USER HEADER	3/10/2014
**/
$fileBasePath = dirname(__FILE__).'/';
include_once($fileBasePath.'config.php');
include_once($fileBasePath.'functions.php');
include_once($config['DOC_ROOT'].'model/admin.class.php');
include_once($config['DOC_ROOT'].'include/functions.php');

?><!doctype html>
<html class="signin no-js" lang="">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="Flat, Clean, Responsive, application admin template built with bootstrap 3">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->

    <title>#ARM FIDO</title>

    <!-- page level plugin styles -->
    <!-- /page level plugin styles -->
      <link rel="icon" type="image/png" href="asset/img/favicon-32x32.png" sizes="32x32" />
    <!-- core styles -->
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset//bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset/css/animate.min.css">
    <!-- /core styles -->

    <!-- template styles -->
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset/css/skins/palette.css">
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset/css/fonts/font.css">
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset/css/main.css">
    <link rel="stylesheet" href="<?php echo $config['SITE_URL'] ?>asset/css/mystyle.css">
    <!-- template styles -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- load modernizer -->
    <script src="<?php echo $config['SITE_URL'] ?>asset/plugins/modernizr.js"></script>
</head>

<body class="backGrnd_image">

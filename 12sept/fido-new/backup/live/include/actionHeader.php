<?php
ob_start();
session_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$fileBasePath = dirname(__FILE__);
include_once($fileBasePath.'/config.php');
include_once($fileBasePath.'/functions.php');
include_once($config['DOC_ROOT'].'include/functions.php');
/*
function addclass($classname)
{
    include_once($config['DOC_ROOT'].'classes/'.$classname.'class.php');
 return    $obj=new $classname;
}*/
include_once($config['DOC_ROOT'].'model/category.class.php');
include_once($config['DOC_ROOT'].'model/project.class.php');
include_once($config['DOC_ROOT'].'model/commonClass.php');
include_once($config['DOC_ROOT'].'model/admin.class.php');
include_once($config['DOC_ROOT'].'model/user.class.php');
include_once($config['DOC_ROOT'].'model/page.class.php');
//require_once($config['DOC_ROOT'].'classes/bussiness.class.php');
//require($config['DOC_ROOT'].'classes/review.class.php');
//require($config['DOC_ROOT'].'classes/gallery.class.php');
//require($config['DOC_ROOT'].'classes/contact.class.php');
include_once($config['DOC_ROOT'].'model/setting.class.php');
//include_once($config['DOC_ROOT'].'classes/page.class.php');
?>

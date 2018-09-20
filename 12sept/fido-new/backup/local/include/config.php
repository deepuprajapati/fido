<?php
/*
*	Config Array stores project's config data
*/
$config = array();
$config['DB_HOST'] = 'localhost';
$config['DB_USER'] = 'newuser';
$config['DB_PASSWORD'] = 'password';
$config['DB_NAME'] = 'fido';
$config['SITE_HOST'] = $_SERVER['HTTP_HOST'];
$config['PROJECT_NAME'] = 'fido';
$config['SITE_URL'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$config['PROJECT_NAME'].'/';
$config['DOC_ROOT'] = $_SERVER['DOCUMENT_ROOT'].'/'.$config['PROJECT_NAME'].'/';
$config['ADMIN_DOCROOT'] = $_SERVER['DOCUMENT_ROOT'].'/'.$config['PROJECT_NAME'].'/admin/';
$config['ADMIN_URL'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$config['PROJECT_NAME'].'/admin/';
$config['API_BASE_URL']='http://18.232.80.137/roleapi/api/api/';
$URL_SITE = $config['SITE_URL'];
include_once($config['DOC_ROOT'].'model/setting.class.php');
include_once($config['DOC_ROOT'].'include/permission.php');
$user_type_category = array('I'=>'Internal','E'=>'External'); // used in select box to show user type category
$settings = new Setting();
$allSettings = $settings->all();
?>

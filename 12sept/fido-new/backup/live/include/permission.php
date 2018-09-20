<?php
// FILE IS USED TO ADD PERMISSION FOR DIFFRENT SECTION IN WEBSITE

$permissions = array(
	'user_managment'=>array(	// User managment array for permission
		'create_user'=>'Can make new user',
		'dlt_user'=>'Can delete user from system',
		'set_permission'=>'Can set permissions for other users',
		'partners_login'=>'Can create new partner login',
		'manage_type'=>'Can manage user types'
	),
	'project_category' => array(	// project category permission array.
		'create_category'=>'Can create project category',
		'delete_category'=>'Can delete category'
	),
	'campaign_management' => array(	// project category permission array.
		'create_campaign'=>'Can create campaign ',
		'delete_campaign'=>'Can delete campaign ',
		'edit_campaign'=>'Can Edit campaign'
	)
	
)	// main array ends here 
?>

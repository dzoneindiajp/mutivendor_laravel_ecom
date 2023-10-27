<?php
$WEBSITE_URL				=	env("APP_URL");  
return [
    'PRODUCTS_IMAGES' => 'products/images',
    'ROOT'     				=> base_path(),
	'APP_PATH'     			=> app_path(),
    'DS'     				=> '/',
    'WEBSITE_URL'							=> $WEBSITE_URL,

    'ACL' => [
		'ACLS_TITLE' => "Acl",
		'ACL_TITLE' => "Acl Management",
	],
    'ROLE_ID' => [
		'STAFF_ROLE_ID' 			=> 3,
		'SUPER_ADMIN_ROLE_ID' 		=> 1,
		'CLIENT_ROLE_ID' 			=> 2,
	],
    'DESIGNATION' => [
		'DESIGNATIONS_TITLE' 	=> "Designations",
		'DESIGNATION_TITLE' 	=> "Designation",
	],

	'DEPARTMENT' => [
		'DEPARTMENTS_TITLE' 	=> "Departments",
		'DEPARTMENT_TITLE' 		=> "Department",
	]

];
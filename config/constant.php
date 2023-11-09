<?php
$WEBSITE_URL				=	env("APP_URL");  
return [
    'PRODUCTS_IMAGES' => 'products/images',
    'ROOT'     				=> base_path(),
	'APP_PATH'     			=> app_path(),
    'DS'     				=> '/',
    'WEBSITE_URL'							=> $WEBSITE_URL,

	'USER_IMAGE_PATH'                       => $WEBSITE_URL.'public/uploads/users/',
	'USER_IMAGE_ROOT_PATH'                       => 'public/uploads/users/',
	'USER_IMAGE_URL'                       => url('/').'/public/uploads/users/',

	'STAFF_IMAGE_PATH'                       => $WEBSITE_URL.'public/uploads/staffs/',
	'STAFF_IMAGE_ROOT_PATH'                       => 'public/uploads/staffs/',
	'STAFF_IMAGE_URL'                       => url('/').'/public/uploads/staffs/',

	'CATEGORY_IMAGE_PATH'                       => $WEBSITE_URL.'public/uploads/categories/',
	'CATEGORY_IMAGE_ROOT_PATH'                       => 'public/uploads/categories/',
	'CATEGORY_IMAGE_URL'                       => url('/').'/public/uploads/categories/',
	
	'BANNER_IMAGE_PATH'                       => $WEBSITE_URL.'public/uploads/banners/',
	'BANNER_IMAGE_ROOT_PATH'                       => 'public/uploads/banners/',
	'BANNER_IMAGE_URL'                       => url('/').'/public/uploads/banners/',
	
	'BANNER_VIDEO_PATH'                       => $WEBSITE_URL.'public/uploads/banners-video/',
	'BANNER_VIDEO_ROOT_PATH'                       => 'public/uploads/banners-video/',
	'BANNER_VIDEO_URL'                       => url('/').'/public/uploads/banners-video/',

	'SETTINGS_IMAGE_PATH'                       => $WEBSITE_URL.'public/uploads/settings/',
	'SETTINGS_IMAGE_ROOT_PATH'                       => 'public/uploads/settings/',
	'SETTINGS_IMAGE_URL'                       => url('/').'/public/uploads/settings/',
	
	'PRODUCT_IMAGE_PATH'                       => $WEBSITE_URL.'public/uploads/products/',
	'PRODUCT_IMAGE_ROOT_PATH'                       => 'public/uploads/products/',
	'PRODUCT_IMAGE_URL'                       => url('/').'/public/uploads/products/',
	

    'ACL' => [
		'ACLS_TITLE' => "Acl",
		'ACL_TITLE' => "Acl Management",
	],
    'ROLE_ID' => [
		'STAFF_ROLE_ID' 			=> 3,
		'SUPER_ADMIN_ROLE_ID' 		=> 1,
		'CUSTOMER_ROLE_ID' 			=> 2,
	],
    'DESIGNATION' => [
		'DESIGNATIONS_TITLE' 	=> "Designations",
		'DESIGNATION_TITLE' 	=> "Designation",
	],

	'DEPARTMENT' => [
		'DEPARTMENTS_TITLE' 	=> "Departments",
		'DEPARTMENT_TITLE' 		=> "Department",
	],
	'VARIANT' => [
		'VARIANTS_TITLE' 	=> "Variants",
		'VARIANT_TITLE' 		=> "Variant",
	],
	'SPECIFICATION' => [
		'SPECIFICATIONS_TITLE' 	=> "Specifications",
		'SPECIFICATION_TITLE' 		=> "Specification",
	],
	'SPECIFICATION_GROUP' => [
		'SPECIFICATION_GROUPS_TITLE' 	=> "Specification Groups",
		'SPECIFICATION_GROUP_TITLE' 		=> "Specification Group",
	],
	
	'SETTING_FILE_PATH'	=> base_path() . "/" .'config'."/". 'settings.php',
];
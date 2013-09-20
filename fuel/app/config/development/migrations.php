<?php
return array(
	'version' => 
	array(
		'app' => 
		array(
			'default' => 0,
		),
		'module' => 
		array(
			'invoice' => 
			array(
				0 => '001_create_invoice',
			),
			'cdrimport' => 
			array(
				0 => '001_create_cdr',
				1 => '002_create_cdr_content',
			),
			'clients' => 
			array(
				0 => '001_create_client',
				1 => '002_create_client_server',
				2 => '003_create_client_sip_rate',
			),
		),
		'package' => 
		array(
			'auth' => 
			array(
				0 => '001_auth_create_usertables',
				1 => '002_auth_create_grouptables',
				2 => '003_auth_create_roletables',
				3 => '004_auth_create_permissiontables',
				4 => '005_auth_create_authdefaults',
				5 => '006_auth_add_authactions',
				6 => '007_auth_add_permissionsfilter',
				7 => '008_auth_create_providers',
				8 => '009_auth_create_oauth2tables',
			),
		),
	),
	'folder' => 'migrations/',
	'table' => 'migration',
);

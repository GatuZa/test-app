<?php
return [
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Application',
	'preload' => ['log'],
	'components' => [
		'db' => require(dirname(__FILE__) . '/database.php'),
		'test_db' => [
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=test_app',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8'
		],
		'log' => [
			'class' => 'CLogRouter',
			'routes' => [
				[
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning'
				]
			]
		]
	]
];

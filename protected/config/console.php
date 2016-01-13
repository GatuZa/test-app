<?php
return [
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Application',
	'preload' => ['log'],
	'components' => [
		'db' => require(dirname(__FILE__) . '/database.php'),
		'unit_tests' => require(dirname(__FILE__) . '/database-tests.php'),
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
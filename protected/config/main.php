<?php
return [
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Application',
	'preload' => ['log'],
	'import' => [
		'application.models.*',
		'application.components.*',
		'ext.giix-components.*'
	],
	'modules' => [
		'gii' => [
			'class' => 'system.gii.GiiModule',
			'generatorPaths' => ['ext.giix-core'],
			'password' => "qwerty"
		]
	],
	'components' => [
		'user' => [
			'class' => 'CWebUser',
			'allowAutoLogin' => true,
			'loginUrl' => ['login']
		],
		'urlManager' => [
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => [
				'/' => 'accounting',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>'
			]
		],
		'db' => require(dirname(__FILE__) . '/database.php'),
		'errorHandler' => ['errorAction' => 'error'],
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
<?php
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'My Test Application',
	// pre-loading 'log' component
	'preload' => array('log'),

	// autoLoading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'ext.giix-components.*',
	),
//	'session' => array(
//		'autoStart'=>true,
//	),
	'modules' => array(
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'generatorPaths' => array(
				'ext.giix-core'
			),
			'password' => "qwerty"
		),
	),

	// application components
	'components' => array(
		'user' => array(
			'class' => 'CWebUser',
			'allowAutoLogin' => true,
			'loginUrl' => ['login'],
		),
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'/' => 'accounting',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),

		// database settings are configured in database.php
		'db' => require(dirname(__FILE__) . '/database.php'),

		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => 'site/error',
		),

		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				['class' => 'CWebLogRoute'],
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
	),
);

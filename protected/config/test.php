<?php
return CMap::mergeArray(
	require(dirname(__FILE__) . '/main.php'), [
		'components' => [
			'urlManager' => [
				'urlFormat' => 'path',
				'showScriptName' => true
			],
			'assetManager' => [
				'basePath' => dirname(__FILE__) . '/../../assets',
			],
			'fixture' => [
				'class' => 'system.test.CDbFixtureManager',
				'basePath' => dirname(__FILE__) . '/../tests/fixtures/'
			],
			'db' => [
				'connectionString' => 'mysql:host=localhost;dbname=test_app',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8'
			],
		],
	]
);
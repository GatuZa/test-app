<?php
return CMap::mergeArray(
	require(dirname(__FILE__) . '/main.php'), [
		'components' => [
			'urlManager' => [
				'urlFormat' => 'path',
				'showScriptName' => true
			],
			'assetManager' => [
				'basePath' => dirname(__FILE__) . '/../../assets'
			],
			'fixture' => [
				'class' => 'system.test.CDbFixtureManager',
				'basePath' => dirname(__FILE__) . '/../tests/fixtures/'
			],
			'db' => require(dirname(__FILE__) . '/database-tests.php')
		]
	]
);
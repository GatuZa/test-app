<?php
/**
 * @var SettingController $this
 * @var CActiveDataProvider $dataProvider
 * @var Setting $model
 */
$this->pageTitle = 'Setting';
$this->actionButtons = ['create'];

$this->renderPartial('../components/_list_generator', [
	'model' => $model,
	'columns' => [
		'intSettingID',
		'varName',
		'varValue'
	]
]);

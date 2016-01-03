<?php
/**
 * @var UserController $this
 * @var CActiveDataProvider $dataProvider
 * @var User $model
 */
$this->pageTitle = 'Users';
$actions = '';

if ($this->isAdmin()) {
	$this->actionButtons = ['create'];
	$actions = '{edit} {delete}';
}

$this->renderPartial('../components/_list_generator', [
	'model' => $model,
	'columns' => [
		'intUserID',
		'varName',
		'intRoleID',
		'isActive'
	],
	'actions' => $actions,
	'relations' => ['intRoleID' => ['intRole' => 'varName']]
]);

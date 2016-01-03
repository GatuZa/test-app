<?php
/**
 * @var UserController $this
 * @var CActiveDataProvider $dataProvider
 * @var User $model
 * @var CActiveForm $form
 */
$this->pageTitle = $model->isNewRecord ? 'Create user' : 'Edit user';
$this->actionButtons = ['back'];

$columns = [
	'varName',
	'varPassword'
];

// Administrator can activate/inactivate all users, but not himself
if (!$this->isCurrentUser($model->intUserID) && $this->isAdmin()) {
	array_unshift($columns, 'isActive');
}

// Administrator can update own role
if ($this->isAdmin()) {
	$columns[] = 'intRoleID';
}
?>

<div class="row">
	<div class="col-lg-12">
		<?= $this->renderPartial('../components/_form_generator', [
			'model' => $model,
			'columns' => $columns,
			'types' => ['varPassword' => 'password'],
			'relations' => ['intRoleID' => ['Role' => ['intRoleID', 'varName']]]
		]); ?>
	</div>
</div>
<?php
/**
 * @var SettingController $this
 * @var CActiveDataProvider $dataProvider
 * @var Setting $model
 * @var CActiveForm $form
 */
$this->pageTitle = $model->isNewRecord ? 'Create new setting' : 'Edit exist setting';
$this->actionButtons = ['back'];
?>

<div class="row">
	<div class="col-lg-12">
		<?= $this->renderPartial('../components/_form_generator', [
			'model' => $model,
			'columns' => [
				'varName',
				'varValue'
			]
		]); ?>
	</div>
</div>
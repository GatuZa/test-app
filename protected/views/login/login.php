<?php
/**
 * @var User $model
 * @var CActiveForm $form
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" />
	<meta name="language" content="ru" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta content="" name="description">
	<meta content="" name="author">

	<title><?= CHtml::encode($this->pageTitle); ?></title>
	<?php
		$cs = Yii::app()->clientScript;

		$cs->registerCSSFile('/themes/bootstrap/css/bootstrap.css');
		$cs->registerCSSFile('/themes/bootstrap/css/bootstrap-theme.css');
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile('/themes/default/js/scripts.js');
		$cs->registerScriptFile('/themes/bootstrap/js/bootstrap-lightbox.js');
		$cs->registerCSSFile('/themes/default/css/styles.css');
	?>
	<style type="text/css">
		body {
			background: #efefef;
		}
	</style>
</head>
<body data-ng-app="app" id="app">
<br>
<br>
<div class="container login-container">
	<div class="panel panel-default page-signin">
		<div class="panel-heading">
			<b>Авторизация</b>
		</div>
		<div class="panel-body">
			<div class="col-lg-12">
				<div class="form-container">
					<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'login-form',
						'clientOptions' => array(
							'validateOnSubmit' => true,
						),
						'htmlOptions' => array(
							'class' => 'form-horizontal',
						)
					)); ?>
					<fieldset>
						<div class="form-group">
							<?= $form->error($model, 'varName', array('class' => 'alert alert-danger')); ?>
							<?= $form->error($model, 'varPassword', array('class' => 'alert alert-danger')); ?>
						</div>
						<div class="form-group">
							<div class="input-group input-group-lg">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-envelope"></span>
							</span>
								<?=
								$form->textField($model, 'varName', array(
									'class' => 'form-control',
									'placeholder' => 'Login'
								)) ?>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group input-group-lg">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-lock"></span>
							</span>

								<?=
								$form->passwordField($model, 'varPassword', array(
									'class' => 'form-control',
									'placeholder' => 'Password'
								)) ?>
							</div>
						</div>

						<div class="form-group">
							<?=
							CHtml::submitButton('Logon', array(
								'id' => 'Logon',
								'class' => 'btn btn-primary btn-lg btn-block'
							)); ?>
						</div>
					</fieldset>
					<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
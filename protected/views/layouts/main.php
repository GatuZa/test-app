<?php
/**
 * @var string $content
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" />
	<meta name="language" content="ru" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta content="" name="description">
	<meta content="" name="author">
	<link href="/themes/bootstrap/images/miritec.ico" rel="shortcut icon" type="image/x-icon" />
	<title><?= CHtml::encode($this->pageTitle); ?> | <?= Yii::app()->name ?></title>

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">

	<?php
		$cs = Yii::app()->clientScript;
		$cs->registerCSSFile('/themes/bootstrap/css/bootstrap-lightbox.css');
		$cs->registerCSSFile('/themes/bootstrap/css/bootstrap.css');
		$cs->registerCSSFile('/themes/bootstrap/css/bootstrap-theme.css');
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile('/themes/bootstrap/js/bootstrap.js');
		$cs->registerScriptFile('/themes/bootstrap/js/bootstrap-lightbox.js');
		$cs->registerScriptFile('/themes/default/js/scripts.js');
		$cs->registerCSSFile('/themes/default/css/styles.css');
	?>
</head>
<body>
<div class="container theme-showcase">
	<div>
		<section id="header" class="top-header"><?= $this->renderPartial('../components/_header', ['isAdmin' => $this->isAdmin()]); ?></section>
	</div>
	<br class="clear">
	<br class="clear">
	<div class="view-container margin-top-25">
		<section id="content" >
			<?php
				$pages = array(
					'error',
					'dashboard'
				);

				foreach (Yii::app()->user->getFlashes() as $key => $message)
				{
					printf('<div class="row"><div class="alert alert-%s alert-outside-page">%s</div><br></div>', $key, $message);
				}
			?>

			<?php if (!in_array(Yii::app()->controller->id, $pages)) : ?>
			<div class="page">
				<section class="panel panel-default">
					<div class="panel-heading">
						<strong>
							<span class="glyphicon glyphicon-th"></span>
							<?= $this->pageTitle ?>
						</strong>

						<?= $this->renderPartial('../components/_buttons', ['buttons' => $this->actionButtons]); ?>
					</div>
					<div class="panel-body" data-ng-controller="RatingDemoCtrl">
						<?php endif; ?>
							<?= $content ?>
						<?php if (!in_array(Yii::app()->controller->id, $pages)): ?>
					</div>
				</section>
			</div>
		<?php endif; ?>
		</section>
	</div>
</div>
</body>
</html>
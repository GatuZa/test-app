<?php
/* @var $this ErrorController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';

if (defined('YII_DEBUG') && YII_DEBUG)
{
?>
	<h2>Error <?= $code ?></h2>

	<div class="error"><?= CHtml::encode($message) ?></div>
<?php } else { ?>
	<h2>Error</h2>

	<div class="error">There must be some error :(. Maybe you try to go to a page that does not exist. Contact site administrator.</div>
<?php } ?>
<?php
/* @var $this ErrorController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
?>

<h2>Error <?= $code ?></h2>

<div class="error">
<?= CHtml::encode($message) ?>
</div>
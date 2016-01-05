<?php

/**
 * Class ErrorController
 */
class ErrorController extends SiteController
{
	/**
	 * Default action
	 */
	public function actionIndex()
	{
		if ($error = Yii::app()->errorHandler->error) {
			$this->render('index', $error);
		}
	}
}
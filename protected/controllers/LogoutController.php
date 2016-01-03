<?php

/**
 * Class LogoutController
 */
class LogoutController extends SiteController
{
	/**
	 * Default action
	 */
	public function actionIndex()
	{
		Yii::app()->user->logout();
		$this->redirect('/');
	}
}
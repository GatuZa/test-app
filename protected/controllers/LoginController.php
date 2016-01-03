<?php

/**
 * Class LoginController
 */
class LoginController extends SiteController
{
	/**
	 * @var bool
	 */
	public $layout = false;

	/**
	 * @return array
	 */
	public function accessRules()
	{
		return [['allow']];
	}

	/**
	 * Default action
	 */
	public function actionIndex()
	{
		if (Yii::app()->user->id) {
			$this->redirect('/');
		}

		if (stristr(Yii::app()->user->returnUrl, 'logout')) {
			Yii::app()->user->setReturnUrl('login');
		}

		$model = new LoginForm();

		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];

			if ($model->validate() && $model->login()) {
				$url = Yii::app()->user->returnUrl;
				$this->redirect($url);
			} else {
				$model->addError('varPassword', 'Wrong login or password.');
			}
		}

		$this->render('login', ['model' => $model]);
	}
}
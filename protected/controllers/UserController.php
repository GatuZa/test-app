<?php
/**
 * Class UserController
 */
class UserController extends ActionController
{
	/**
	 * @var string
	 */
	protected $model = 'User';

	/**
	 * @param string $provider
	 */
	public function actionIndex($provider = 'search')
	{
		parent::actionIndex($provider);
	}

	/**
	 * Updates a new model.
	 * If updating is successful, the browser will be refreshed
	 *
	 * @param $id
	 * @param $scenario
	 */
	public function actionEdit($id, $scenario = null)
	{
		if (!$this->isCurrentUser($id)) {
			$this->accessGranted(User::ROLE_ADMIN);
		}

		parent::actionEdit($id, 'update');
	}

	/**
	 * @param $id
	 */
	public function actionDelete($id)
	{
		if ($this->isCurrentUser($id)) {
			Yii::app()->user->setFlash('danger', 'You can\'t delete yourself.');
			$this->redirect('/');
		}

		$this->accessGranted(User::ROLE_ADMIN);
		parent::actionDelete($id);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param $scenario
	 */
	public function actionCreate($scenario = null)
	{
		$this->accessGranted(User::ROLE_ADMIN);
		parent::actionCreate('create');
	}

	/**
	 * @param User $model
	 */
	public function beforeSave(&$model)
	{
		if ($model->varPassword) {
			$model->varPassword = $model->encryptPassword($model->varPassword);
		} else {
			unset($model->varPassword);
		}
	}

	/**
	 * If user updated himself -> refresh session data
	 *
	 * @param User $model
	 */
	public function afterSave(&$model)
	{
		if ($this->isCurrentUser($model->intUserID)) {
			Yii::app()->user->setState('title', $model->varName);
			Yii::app()->user->setState('role', $model->intRoleID);
		}
	}

	/**
	 * @param $id
	 * @return bool
	 */
	public function isCurrentUser($id)
	{
		return Yii::app()->user->id == $id;
	}
}
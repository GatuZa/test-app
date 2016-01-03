<?php

/**
 * Class ActionController
 */
class ActionController extends SiteController
{
	/**
	 * @var string
	 */
	protected $model;

	/**
	 * @var array
	 */
	private $template_vars = [];

	/**
	 * @var null|CActiveRecord
	 */
	protected $oldModel = null;

	/**
	 * @var CActiveForm $form
	 */
	protected $form;

	/**
	 * @throws Exception
	 */
	public function init()
	{
		parent::init();

		if (empty($this->model)) {
			throw new Exception('Model is not implemented');
		}
	}

	/**
	 * @param $key
	 * @param $var
	 */
	public function setTemplateVars($key, $var)
	{
		$this->template_vars[$key] = $var;
	}

	/**
	 * @return array
	 */
	public function getTemplateVars()
	{
		return $this->template_vars;
	}

	/**
	 * @param string $provider
	 */
	public function actionIndex($provider = 'search')
	{
		/**
		 * @var CActiveRecord $model
		 */
		$model = new $this->model($provider);
		$model->unsetAttributes();
		$this->afterLoadModel($model);

		if (isset($_GET[$this->model])) {
			$model->attributes = $_GET[$this->model];
		}

		$dataProvider = new CActiveDataProvider($this->model);

		$this->beforeView($model);
		$this->setTemplateVars('model', $model);
		$this->setTemplateVars('provider', $provider);
		$this->setTemplateVars('dataProvider', $dataProvider);

		$this->render('index', $this->template_vars);
	}

	/**
	 * @param $message
	 */
	protected function addMessage($message)
	{
		Yii::app()->user->setFlash('success', $message);
	}

	/**
	 * @param $message
	 */
	protected function addErrorMessage($message)
	{
		Yii::app()->user->setFlash('danger', $message);
	}

	/**
	 * @param $message
	 */
	protected function addWarningMessage($message)
	{
		Yii::app()->user->setFlash('warning', $message);
	}

	/**
	 * @param $id
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		try {
			if ($model->delete()) {
				$this->addWarningMessage('Successfully deleted.');
				$this->redirect('/' . Yii::app()->controller->id);
			}
		} catch (CDbException $e) {
			$this->addErrorMessage('Failure to remove.');
		}

		$this->redirect(':back');
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
		$model = $this->loadModel($id);

		if ($scenario) {
			$model->scenario = $scenario;
		}

		if (isset($_POST[$this->model])) {
			$model->attributes = $_POST[$this->model];

			$this->beforeSave($model);

			$validModel = $model->validate();

			if ($validModel) {
				$model->save();
				$this->afterSave($model);
				$this->addMessage('Saved successfully.');
				$this->redirect(['edit', 'id' => $model->primaryKey]);
			}
		}

		$this->beforeView($model);
		$this->setTemplateVars('model', $model);
		$this->render('edit', $this->template_vars);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param $scenario
	 */
	public function actionCreate($scenario = null)
	{
		/**
		 * @var CActiveRecord $model
		 */
		$model = new $this->model;
		$this->afterLoadModel($model);

		if ($scenario) {
			$model->scenario = $scenario;
		}

		if (isset($_POST[$this->model])) {
			$model->attributes = $_POST[$this->model];
			$this->beforeSave($model);
			$validModel = $model->validate();

			if ($validModel) {
				$model->save();
				$this->afterSave($model);
				$this->addMessage('Saved successfully.');
				$this->redirect(['edit', 'id' => $model->primaryKey]);
			}
		}

		$this->beforeView($model);
		$this->setTemplateVars('model', $model);
		$this->render('edit', $this->template_vars);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id the ID of the model to be loaded
	 *
	 * @return CActiveRecord the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		/**
		 * @var CActiveRecord $model
		 */
		$model = new $this->model;
		$model = $model::model();

		$this->beforeLoadModel($model);
		$model = $model->findByPk($id);

		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$this->oldModel = $model;
		$this->afterLoadModel($model);

		return $model;
	}

	/**
	 * @param CActiveRecord $model
	 */
	public function beforeView(&$model) {}

	/**
	 * @param CActiveRecord $model
	 */
	public function beforeSave(&$model) {}

	/**
	 * @param CActiveRecord $model
	 */
	public function afterSave(&$model) {}

	/**
	 * @param CActiveRecord $model
	 */
	public function beforeLoadModel(&$model) {}

	/**
	 * @param CActiveRecord $model
	 */
	public function afterLoadModel(&$model) {}
}
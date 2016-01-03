<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class SiteController extends CController
{
	/**
	 * @var array
	 */
	protected $actionButtons = [];

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/main';

	/**
	 * @var array
	 */
	static $availableRoles = [
		'Administrator' => 1,
		'Manager' => 2
	];

	/**
	 * Perform access control for CRUD operations.
	 * @return array
	 */
	public function filters()
	{
		return array('accessControl' );
	}

	/**
	 * Guests can access only login page by default.
	 * @return array
	 */
	public function accessRules()
	{
		return [['deny', 'users' => ['?']]];
	}

	/**
	 * Specific rules for user roles located in init() function of controllers or in actions.
	 * @return bool
	 */
	public function accessGranted()
	{
		$roles = array_intersect(func_get_args(), SiteController::$availableRoles);

		if (!in_array(Yii::app()->user->getState('role'), $roles)) {
			Yii::app()->user->setFlash('danger', 'You don\'t have access to this section.');
			$this->redirect('/');
		}
	}

	/**
	 * @param mixed $url
	 * @param bool $terminate
	 * @param int $statusCode
	 */
	public function redirect($url, $terminate = true, $statusCode = 302)
	{
		if ($url == ':back' && isset($_SERVER['HTTP_REFERER'])) {
			$url = $_SERVER['HTTP_REFERER'];
		}

		parent::redirect($url, $terminate, $statusCode);
	}

	/**
	 * @return bool
	 */
	public function isAdmin()
	{
		return Yii::app()->user->getState('role') == self::$availableRoles['Administrator'];
	}
}
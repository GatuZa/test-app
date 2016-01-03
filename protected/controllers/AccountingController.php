<?php

/**
 * Class AccountingController
 */
class AccountingController extends SiteController
{
	/**
	 * @var bool
	 */
	protected $check_admin = false;

	/**
	 * Default action
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
}
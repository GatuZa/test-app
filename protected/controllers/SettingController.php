<?php
/**
 * Class SettingController
 */
class SettingController extends ActionController
{
	/**
	 * @var string
	 */
	protected $model = 'Setting';

	/**
	 * Init function.
	 * Only administrators have access to the module.
	 */
	public function init()
	{
		parent::init();
		$this->accessGranted(User::ROLE_ADMIN);
	}
}
<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	/**
	 * @var
	 */
	public $varName;

	/**
	 * @var
	 */
	public $varPassword;

	/**
	 * @var bool
	 */
	public $rememberMe = true;

	/**
	 * @var
	 */
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return [
			['varName, varPassword', 'required'],
			['varPassword', 'authenticate']
		];
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return [
			'varName' => 'Login',
			'varPassword' => 'Password'
		];
	}

	/**
	 * Authenticate the user
	 */
	public function authenticate()
	{
		if (!$this->hasErrors()) {
			$this->_identity = new UserIdentity($this->varName, $this->varPassword);

			if (!$this->_identity->authenticate()) {
				if ($this->_identity->errorCode === UserIdentity::ERROR_ACCESS_DENIED) {
					$this->addError('varPassword', 'Доступ запрещен');
				} else {
					$this->addError('varPassword', 'Пароль введен неверно');
				}
			}
		}
	}

	/**
	 * @return bool
	 */
	public function login()
	{
		if ($this->_identity === null) {
			$this->_identity = new UserIdentity($this->varName, $this->varPassword);
			$this->_identity->authenticate();
		}

		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			Yii::app()->user->login($this->_identity, 3600*24*30);
			return true;
		} else {
			return false;
		}
	}
}
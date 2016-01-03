<?php

/**
 * Class UserIdentity
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * @var int $_id
	 */
	private $_id;

	/**
	 * Error code when access denied
	 */
	const ERROR_ACCESS_DENIED = 666;

	/**
	 * @return bool
	 */
	public function authenticate()
	{
		/**
		 * @var User $user
		 */
		$user = User::model()->findByAttributes([
			'varName' => $this->username,
			'isActive' => User::STATUS_ACTIVE
		]);

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			if (!$user->validatePassword($this->password)) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			} else {
				$this->_id = $user->intUserID;
				$this->setState('title', $user->varName);
				$this->setState('role', $user->intRoleID);
				$this->errorCode = $this::ERROR_NONE;
			}
		}

		return !$this->errorCode;
	}

	/**
	 * @return mixed|string
	 */
	public function getId()
	{
		return $this->_id;
	}
}
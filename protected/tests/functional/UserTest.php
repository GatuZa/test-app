<?php

/**
 * Class UserTest
 */
class UserTest extends WebTestCase
{
	/**
	 * @var array
	 */
	public $fixtures = [
		'users' => 'User',
		'roles' => 'Role'
	];

	/**
	 * @var string
	 */
	public $passwordAdmin = 'admin';

	/**
	 * @var string
	 */
	public $passwordManager = 'manager';

	/**
	 * Test is OK when guest can login as admin.
	 */
	public function testGuestCanLoginAsAdmin()
	{
		$this->login($this->users['sample1']['varName'], $this->passwordAdmin);
	}

	/**
	 * Test is ok when guest login as manager.
	 */
	public function testGuestCanLoginAsManager()
	{
		$this->login($this->users['sample2']['varName'], $this->passwordManager);
	}
}
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

	/**
	 * Test is ok when administrator can create the user.
	 */
	public function testCreateUser()
	{
		$this->login($this->users['sample1']['varName'], $this->passwordAdmin);
		$this->open('user');
		$this->clickAndWait('id=action_create');
		$this->type('id=User_varName', 'User1');
		$this->type('id=User_varPassword', 'user1password');
		$this->select('id=User_intRoleID', 'value=2');
		$this->clickAndWait('css=input[type=submit]');
		$this->assertTextPresent('Saved successfully.');
		$this->open('user');
		$this->assertTextPresent('User1');
	}
}
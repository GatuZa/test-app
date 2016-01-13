<?php

/**
 * Checks access rules.
 *
 * Class AccessTest
 */
class AccessTest extends WebTestCase
{
	/**
	 * @var array
	 */
	public $fixtures = [
		'users' => 'User',
		'roles' => 'Role'
	];

	/**
	 * Test is ok when guest can't access home page.
	 */
	public function testGuestNotAccessHomePage()
	{
		$this->open('/');
		$this->assertTextNotPresent('Home');
	}

	/**
	 * Test is ok when guest can't access home page.
	 */
	public function testGuestNotAccessUsersPage()
	{
		$this->open('user');
		$this->assertTextNotPresent('Users');
	}

	/**
	 * Test is ok when guest can't access settings page.
	 */
	public function testGuestNotAccessSettingsPage()
	{
		$this->open('setting');
		$this->assertTextNotPresent('Settings');
	}

	/**
	 * Test is ok when guest can't access admin profile page.
	 */
	public function testGuestNotAccessProfilePage()
	{
		$this->open('/user/edit/' . $this->users['sample1']['intUserID']);
		$this->assertTextNotPresent('Edit');

		$this->open('/user/edit/' . $this->users['sample2']['intUserID']);
		$this->assertTextNotPresent('Edit');
	}

	/**
	 * Test is ok when manager can't access settings page
	 */
	public function testManagerNotAccessSettingsPage()
	{
		$this->login($this->users['sample2']['varName'], $this->passwordManager);
		$this->open('/setting/');
		$this->assertTextPresent('You don\'t have access to this section.');
	}

	/**
	 * Test is ok when manager can't access another user profile page
	 */
	public function testManagerNotAccessProfileUser()
	{
		$this->login($this->users['sample2']['varName'], $this->passwordManager);
		$this->open('/user/edit/' . $this->users['sample1']['intUserID']);
		$this->assertTextPresent('You don\'t have access to this section.');
	}

	/**
	 * Test is ok when administrator can access all available pages.
	 */
	public function testAdministratorAccessAllPages()
	{
		$this->login($this->users['sample1']['varName'], $this->passwordAdmin);

		$this->open('accounting');
		$this->assertTextNotPresent('You don\'t have access to this section.');
		$this->assertTextNotPresent('Unable to resolve the request');

		$this->open('user');
		$this->assertTextNotPresent('You don\'t have access to this section.');
		$this->assertTextNotPresent('Unable to resolve the request');

		$this->open('setting');
		$this->assertTextNotPresent('You don\'t have access to this section.');
		$this->assertTextNotPresent('Unable to resolve the request');

		// edit himself information
		$this->open('/user/edit/' . $this->users['sample1']['intUserID']);
		$this->assertTextNotPresent('You don\'t have access to this section.');
		$this->assertTextNotPresent('Unable to resolve the request');
		$this->assertTextPresent('Edit user');

		// edit manager information
		$this->open('/user/edit/' . $this->users['sample2']['intUserID']);
		$this->assertTextNotPresent('You don\'t have access to this section.');
		$this->assertTextNotPresent('Unable to resolve the request');
		$this->assertTextPresent('Edit user');
	}
}
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
	public function testGuestNotAccessHomeUsersPage()
	{
		$this->open('/');
		$this->assertTextNotPresent('Home');
	}

	/**
	 * Test is ok when guest can't access home page.
	 */
	public function testGuestNotAccessToUsersPage()
	{
		$this->open('user');
		$this->assertTextNotPresent('Users');
	}

	/**
	 * Test is ok when guest can't access settings page.
	 */
	public function testGuestNotAccessToSettingsPage()
	{
		$this->open('setting');
		$this->assertTextNotPresent('Settings');
	}

	/**
	 * Test is ok when guest can't access admin profile page.
	 */
	public function testGuestNotAccessToProfilePage()
	{
		$this->open('/user/edit/' . $this->users['sample1']['intUserID']);
		$this->assertTextNotPresent('Edit');
	}
}
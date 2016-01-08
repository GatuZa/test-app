<?php

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
define('TEST_BASE_URL', 'http://test-app.com/index-test.php/');

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase
{
	/**
	 * @var string
	 */
	public $passwordAdmin = 'admin';

	/**
	 * @var string
	 */
	public $passwordManager = 'manager';

	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->setBrowserUrl(TEST_BASE_URL);
	}

	/**
	 * Login method.
	 *
	 * @param $name
	 * @param $password
	 */
	protected function login($name, $password)
	{
		$this->open('logout');
		sleep(100);
		$this->assertTextPresent('Авторизация');
		$this->type('id=LoginForm_varName', $name);
		$this->type('id=LoginForm_varPassword', $password);
		$this->clickAndWait("//input[@value='Logon']");
		$this->assertTextPresent('Home');
	}
}
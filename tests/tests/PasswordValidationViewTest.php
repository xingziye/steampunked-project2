<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class PasswordValidationViewTest extends \PHPUnit_Extensions_Database_TestCase
{
	private static $site;

	public static function setUpBeforeClass()
	{
		self::$site = new Steampunked\Site();
		$localize = require 'localize.inc.php';
		if (is_callable($localize)) {
			$localize(self::$site);
		}
	}
	/**
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	public function getConnection()
	{
		return $this->createDefaultDBConnection(self::$site->pdo(), 'santor10');
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataSet()
	{
		return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/game.xml');
	}

	public function test_construct(){
		$get = array();

		$view = new Steampunked\PasswordValidationView(self::$site,$get);

		$this->assertInstanceOf('Steampunked\PasswordValidationView', $view);
	}


	public function test_present(){
		$get = array();

		$view = new Steampunked\PasswordValidationView(self::$site,$get);

		$this->assertContains('<form method="post" action="post/password-validate.php">', $view->present());
		$this->assertContains('<input type="hidden" name="validator" value=', $view->present());

	}


}

/// @endcond
?>

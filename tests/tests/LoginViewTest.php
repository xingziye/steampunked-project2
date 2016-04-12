<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class GamesViewTest extends \PHPUnit_Extensions_Database_TestCase
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

		$view = new Steampunked\GamesView(self::$site,$get);

		$this->assertInstanceOf('Steampunked\GamesView', $view);
	}


	public function test_present(){
		$get = array();

		$view = new Steampunked\LoginView(self::$site,$get);

		$this->assertContains('<form method="post" action="post/login.php">', $view->createLogin());
		$this->assertContains('<input type="submit" name="ok" id="ok" value="OK"> <input type="submit" id="cancel" name="cancel" value="Cancel">', $view->createLogin());
		$this->assertContains('<a href="signup.php" >Sign Up</a><p>-OR-</p><input type="submit" name="guest" id="guest" value="Play as Guest">', $view->createLogin());

	}


}

/// @endcond
?>

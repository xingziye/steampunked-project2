<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class GamesControllerTest extends \PHPUnit_Extensions_Database_TestCase
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
		$row = array('id' => 12,
			'email' => 'dude@ranch.com',
			'name' => 'Dude, The',
			'gameid' => 'Some Notes',
			'password' => '12345678',
		);
		$user = new Steampunked\User($row);

		$session = array();	// Fake session

		$controller = new Steampunked\GamesController(self::$site, $user, $session);

		$this->assertInstanceOf('Steampunked\GamesController', $controller);
	}

}

/// @endcond
?>

<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class CreateGameViewTest extends \PHPUnit_Extensions_Database_TestCase
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

		$view = new Steampunked\CreateGameView(self::$site);

		$this->assertInstanceOf('Steampunked\CreateGameView', $view);
	}

	public function test_present(){

		$view = new Steampunked\CreateGameView(self::$site);

		$this->assertContains('<div class="screen">', $view->present());
		$this->assertContains('<form method="post" action="post/create-game-post.php">', $view->present());
		$this->assertContains('</form>', $view->present());
		$this->assertContains('</div>', $view->present());

	}


}

/// @endcond
?>

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

	public function test_header(){
		$get = array();

		$view = new Steampunked\GamesView(self::$site,$get);

		$this->assertContains('<ul class="left">', $view->header());
		$this->assertContains('<ul class="right">', $view->header());
		$this->assertContains('<li><a href="post/logout.php">Log out</a></li>', $view->header());
		$this->assertContains('<li><a href="./gametable.php">Game Lobby</a></li>', $view->header());

	}

	public function test_present(){
		$get = array();

		$view = new Steampunked\GamesView(self::$site,$get);

		$this->assertContains('<input type="submit" name="create" id="create" value="Create Game">', $view->present());
		$this->assertContains('<input type="submit" name="join" id="join" value="Join Game">', $view->present());
		$this->assertContains('<form class="table" action="post/games-post.php" method="post">', $view->present());

	}


}

/// @endcond
?>

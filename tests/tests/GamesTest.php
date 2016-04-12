<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class GamesTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Steampunked\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }
	/**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {

        return $this->createDefaultDBConnection(self::$site->pdo(), 'xingziye');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/game.xml');
    }

    public function test_construct() {
        $games = new Steampunked\Games(self::$site);
        $this->assertInstanceOf('Steampunked\Games', $games);
    }

    /**
     * Test to ensure Cases::get is working.
     */
    public function test_get() {
        $games = new Steampunked\Games(self::$site);

        $case = $games->get(22);
    }

    public function test_insert() {
        $games = new Steampunked\Games(self::$site);

        $id = $games->insert(1931, 1009, 16);
        $game = $games->get($id);
        $this->assertNotNull($game);
        $this->assertEquals(16, $game->getSize());
        $this->assertEquals(1931, $game->getPlayer(1));
        $this->assertEquals(1009, $game->getPlayer(2));
;
    }

    public function test_updateTurn() {
        $games = new Steampunked\Games(self::$site);
        $id = $games->insert(1931, 1009, 16);
        $game = $games->get($id);
        $this->assertEquals(0, $game->getTurn());

        $turn = $game->nextTurn();
        $game = $games->get($id);
        $this->assertEquals(0, $game->getTurn());
    }



}

/// @endcond
?>

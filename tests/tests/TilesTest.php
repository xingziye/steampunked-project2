<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class TilesTest extends \PHPUnit_Extensions_Database_TestCase
{
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
        $tiles = new \Steampunked\Tiles(self::$site);
        $this->assertInstanceOf('Steampunked\Tiles', $tiles);
    }

    /**
     * Test to ensure Cases::get is working.
     */
    public function test_getByGame() {
        $tiles = new \Steampunked\Tiles(self::$site);
        $tile_lists = $tiles->getByGame(7);

        $tile_array = array();
        foreach ($tile_lists as $entry) {
            $tile = new \Steampunked\Tile($entry['type'], $entry['player']);
            $open = $tile->orient($entry['orientation']);
            $tile->setOpenArray($open);
            $tile_array[] = $tile;
        }

        $this->assertEquals(1, $tile_array[0]->getId());
        $this->assertEquals(0, $tile_array[0]->getType());
        //$this->assertEquals($tiles->open(4), $tile_array[0]->open());
        $this->assertEquals(0, $tile_array[1]->getId());
        $this->assertEquals(0, $tile_array[1]->getType());
        //$this->assertEquals($tiles->open(2), $tile_array[1]->open());
        $this->assertEquals(1, $tile_array[2]->getId());
        $this->assertEquals(0, $tile_array[2]->getType());
        //$this->assertEquals($tiles->open(1), $tile_array[2]->open());
    }

    public function test_insert() {
        $tiles = new \Steampunked\Tiles(self::$site);

        $id = $tiles->insert(4, 1, 2, array("N"=>false, "E"=>true, "S"=>false, "W"=>true), 0, 8);
        $ent = $tiles->get($id);
        $this->assertNotNull($ent);
        $this->assertEquals(4, $ent['type']);
        $this->assertEquals(1, $ent['row']);
        $this->assertEquals(2, $ent['col']);
        $this->assertEquals(5, $ent['orientation']);
        $this->assertEquals(0, $ent['player']);
        $this->assertEquals(8, $ent['gameid']);
    }

    public function test_insertSelection() {
        $selection1 = array();
        for ($col = 0; $col < 5; $col++) {
            $selection1[] = new \Steampunked\Tile(\Steampunked\Tile::PIPE_TO_SELECT, 1234);
        }

        $tiles = new \Steampunked\Tiles(self::$site);
        $tiles->insertSelection($selection1, 1234, 233);
        //$this->assertEquals(array(), $selection1);
    }

    public function test_updateSelection() {
        $tiles = new \Steampunked\Tiles(self::$site);
        $tile = new \Steampunked\Tile(\Steampunked\Tile::PIPE_TO_SELECT, 1);
        $open = $tile->open();
        $newTile = $tile;
        $newTile->rotate();
        $open2 = $newTile->open();
        $this->assertNotEquals($open, $open2);
    }

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Steampunked\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }
}

/// @endcond
?>

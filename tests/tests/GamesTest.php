<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class GamesTest extends \PHPUnit_Extensions_Database_TestCase
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
        $games = new Steampunked\Games(self::$site);
        $this->assertInstanceOf('Steampunked\Games', $games);
    }

    /**
     * Test to ensure Cases::get is working.
     */
    public function test_get() {
        $games = new Steampunked\Games(self::$site);

        //$case = $games->get(22);
    }

    public function test_insert() {
        $games = new Steampunked\Games(self::$site);

        $id = $games->insert(1931, 1009, 16);
        $entry = $games->get($id);
        $this->assertNotNull($entry);
        $this->assertEquals(16, $entry['size']);
        $this->assertEquals(1931, $entry['player1']);
        $this->assertEquals(1009, $entry['player2']);

        //$id = $cases->insert(9, 8, "16-5544");
        //$this->assertNull($id);
    }

    public function test_getCases() {
        /*
        $cases = new Felis\Cases(self::$site);

        $all = $cases->getCases();
        $this->assertEquals(3, count($all));
        $c1 = $all[0];
        $this->assertInstanceOf('Felis\ClientCase', $c1);
        $this->assertEquals(23, $c1->getId());
        $this->assertEquals(10, $c1->getClient());
        $this->assertEquals("Simpson, Marge", $c1->getClientName());
        $this->assertEquals(8, $c1->getAgent());
        $this->assertEquals("Owen, Charles", $c1->getAgentName());
        $this->assertEquals("16-1234", $c1->getNumber());
        $this->assertEquals("case summary", $c1->getSummary());
        $this->assertEquals(Felis\ClientCase::STATUS_OPEN, $c1->getStatus());

        $c2 = $all[1];
        $this->assertInstanceOf('Felis\ClientCase', $c2);
        $this->assertEquals(22, $c2->getId());
        $this->assertEquals(9, $c2->getClient());
        $this->assertEquals("Simpson, Bart", $c2->getClientName());
        $this->assertEquals(8, $c2->getAgent());
        $this->assertEquals("Owen, Charles", $c2->getAgentName());
        $this->assertEquals("16-9876", $c2->getNumber());

        $c3 = $all[2];
        $this->assertInstanceOf('Felis\ClientCase', $c3);
        $this->assertEquals(25, $c3->getId());
        $this->assertEquals(9, $c3->getClient());
        $this->assertEquals("Simpson, Bart", $c3->getClientName());
        $this->assertEquals(8, $c3->getAgent());
        $this->assertEquals("Owen, Charles", $c3->getAgentName());
        $this->assertEquals("15-0011", $c3->getNumber());
        */
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

<?php

/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";

class ValidatorTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Felis\Site();
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
        return $this->createDefaultDBConnection(self::$site->pdo(), 'santor10');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/validator.xml');
    }
    public function test_construct() {
        $v = new Felis\Validators(self::$site);
        $this->assertInstanceOf('Felis\Validators', $v);
    }

    public function test_newValidator() {
        $validators = new Felis\Validators(self::$site);

        $validator = $validators->newValidator(27);
        $this->assertEquals(32, strlen($validator));

        $table = $validators->getTableName();
        $sql = <<<SQL
select * from $table
where userid=? and validator=?
SQL;

        $stmt = $validators->pdo()->prepare($sql);
        $stmt->execute(array(27, $validator));
        $this->assertEquals(1, $stmt->rowCount());
    }

    public function test_getOnce() {
        $validators = new Felis\Validators(self::$site);

        // Test a not-found condition
        $this->assertNull($validators->getOnce(""));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(27);
        $validator2 = $validators->newValidator(27);

        $this->assertEquals(27, $validators->getOnce($validator1));
        $validators->deleteValidator($validator1);
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(33);
        $validator2 = $validators->newValidator(33);

        $this->assertEquals(33, $validators->getOnce($validator2));
        $validators->deleteValidator($validator1);
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));
    }



}

/// @endcond
?>

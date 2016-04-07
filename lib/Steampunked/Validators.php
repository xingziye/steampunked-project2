<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 5:38 PM
 */

namespace Steampunked;


class Validators extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "validator");
    }

    /**
     * Create a new validator and add it to the table.
     * @param $userid User this validator is for.
     * @return The new validator.
     */
    public function newValidator($userid) {
        $validator = $this->createValidator();

        $sql = <<<SQL
insert into $this->tableName(userid, validator, date)
values(?,?,?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid, $validator,  date("Y-m-d H:i:s")));

        return $validator;
    }

    /**
     * @brief Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @returns Validator string
     */
    private function createValidator($len = 32) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
     * Determine if a validator is valid. If it is,
     * get the user ID for that validator. Then destroy any
     * validator records for that user ID. Return the
     * user ID.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     */
    public function getOnce($validator) {

        $sql =<<<SQL
SELECT userid from $this->tableName
where validator=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        $userid = $arr['userid'];
        if($statement->rowCount() === 0) {
            return Null;
        }

//        $sql = <<<SQL
//DELETE FROM $this->tableName
//WHERE userid =?
//SQL;
//
//        $pdo = $this->pdo();
//        $statement = $pdo->prepare($sql);
//        $statement->execute(array($userid));

        return $userid;

    }

    public function deleteValidator($validator){
        $sql =<<<SQL
SELECT userid from $this->tableName
where validator=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        $userid = $arr['userid'];
        if($statement->rowCount() === 0) {
            return Null;
        }

        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE userid =?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/8/16
 * Time: 2:33 PM
 */

namespace Steampunked;


class Games extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "game");
    }

    public function getGames(){

        $sql =<<<SQL
SELECT id, player1name, player2name, size from $this->tableName
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array());

        return $arr = $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function createGame($size, $name){

        $sql =<<<SQL
INSERT into $this->tableName(player1name, size)
VALUES(?,?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($name, $size));


    }
}
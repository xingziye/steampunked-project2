<?php

namespace Steampunked;

class Tiles extends Table
{
    /**
     * Constructor
     * @param Site $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "tile");
    }

    public function insert($type, $row, $col, $open, $player, $gameid) {
        $sql = <<<SQL
INSERT INTO $this->tableName (`type`, row, col, orientation, player, gameid)
VALUES (?, ?, ?, ?, ?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $orient = self::orient($open);
            if($statement->execute(array($type, $row, $col, $orient, $player, $gameid)) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            print_r($e->getMessage());
            return null;
        }

        return $pdo->lastInsertId();
    }

    public function getByGame($gameid) {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE gameid=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($gameid));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get a case by id
     * @param int $id The game by ID
     * @returns array entry if successful, null otherwise.
     */
    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function open($orient) {
        switch($orient) {
            case 0:
                return array("N"=>true, "E"=>false, "S"=>false, "W"=>false);
            case 1:
                return array("N"=>false, "E"=>true, "S"=>false, "W"=>false);
            case 2:
                return array("N"=>false, "E"=>false, "S"=>true, "W"=>false);
            case 3:
                return array("N"=>false, "E"=>false, "S"=>false, "W"=>true);
            case 4:
                return array("N"=>true, "E"=>false, "S"=>true, "W"=>false);
            case 5:
                return array("N"=>false, "E"=>true, "S"=>false, "W"=>true);
            case 6:
                return array("N"=>true, "E"=>true, "S"=>false, "W"=>false);
            case 7:
                return array("N"=>false, "E"=>true, "S"=>true, "W"=>false);
            case 8:
                return array("N"=>false, "E"=>false, "S"=>true, "W"=>true);
            case 9:
                return array("N"=>true, "E"=>false, "S"=>false, "W"=>true);
            case 10:
                return array("N"=>false, "E"=>true, "S"=>true, "W"=>true);
            case 11:
                return array("N"=>true, "E"=>false, "S"=>true, "W"=>true);
            case 12:
                return array("N"=>true, "E"=>true, "S"=>false, "W"=>true);
            case 13:
                return array("N"=>true, "E"=>true, "S"=>true, "W"=>false);
        }
    }

    public function orient($open) {
        switch($open) {
            case array("N"=>true, "E"=>false, "S"=>false, "W"=>false):
                return 0;
            case array("N"=>false, "E"=>true, "S"=>false, "W"=>false):
                return 1;
            case array("N"=>false, "E"=>false, "S"=>true, "W"=>false):
                return 2;
            case array("N"=>false, "E"=>false, "S"=>false, "W"=>true):
                return 3;
            case array("N"=>true, "E"=>false, "S"=>true, "W"=>false):
                return 4;
            case array("N"=>false, "E"=>true, "S"=>false, "W"=>true):
                return 5;
            case array("N"=>true, "E"=>true, "S"=>false, "W"=>false):
                return 6;
            case array("N"=>false, "E"=>true, "S"=>true, "W"=>false):
                return 7;
            case array("N"=>false, "E"=>false, "S"=>true, "W"=>true):
                return 8;
            case array("N"=>true, "E"=>false, "S"=>false, "W"=>true):
                return 9;
            case array("N"=>false, "E"=>true, "S"=>true, "W"=>true):
                return 10;
            case array("N"=>true, "E"=>false, "S"=>true, "W"=>true):
                return 11;
            case array("N"=>true, "E"=>true, "S"=>false, "W"=>true):
                return 12;
            case array("N"=>true, "E"=>true, "S"=>true, "W"=>false):
                return 13;
        }
    }
}
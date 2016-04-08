<?php

namespace Steampunked;

class Games extends Table
{
    /**
     * Constructor
     * @param Site $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "game");
    }

    public function insert($player1, $player2, $size) {
        $sql = <<<SQL
INSERT INTO $this->tableName (player1, player2, size)
VALUES (?, ?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($player1, $player2, $size)) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    /**
     * Get a case by id
     * @param int $id The case by ID
     * @returns array entry if successful, null otherwise.
     */
    public function get($id) {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
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
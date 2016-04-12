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
INSERT INTO $this->tableName (player1, player2, `size`, turn)
VALUES (?, ?, ?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($player1, $player2, $size, $player1)) === false) {
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
     * @returns Steampunked object if successful, null otherwise.
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

        return new Steampunked($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function getGames(){
        $users = new Users($this->site);
        $usersTable = $users->getTableName();

        $sql = <<<SQL
SELECT game.id, game.size, user1.name as user1
from $this->tableName game,
     $usersTable user1
where game.player1 = user1.id and game.player2=0
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array());

        return $arr = $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getGameByUser($userid) {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE player1=? OR player2=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid, $userid));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Steampunked($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function createGame($size, $id){

        $sql =<<<SQL
INSERT into $this->tableName(player1, `size`, turn)
VALUES(?, ?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id, $size, $id));

        return $pdo->lastInsertId();
    }

    public function joinGame($gameid, $id){

        $sql =<<<SQL
UPDATE $this->tableName
SET player2=?
WHERE id=$gameid
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));


    }

    public function updateTurn($turn, $gameid) {
        $sql =<<<SQL
UPDATE $this->tableName
SET turn=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($turn, $gameid));
    }
}
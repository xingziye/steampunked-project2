<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/12/16
 * Time: 1:55 PM
 */

namespace Steampunked;


class Controller
{
    public function __construct(Site $site, array $post) {
        /*
        if (isset($post['player1']) and isset($post['player2']) and isset($post['gamesize'])) {
            $games = new Games($site);
            $id = $games->insert(strip_tags($post['player1']), strip_tags($post['player2']), $post['gamesize']);
            $users = new Users($site);
            $user0 = $users->get(strip_tags($post['player1']));
            $user1 = $users->get(strip_tags($post['player2']));
            $player0 = new Player($user0->getName(), 0);
            $player1 = new Player($user1->getName(), 1);
            $steampunked->createGame($id, $post['gamesize'], $player0, $player1);
        }*/
        $games = new Games($site);
        $gameid = strip_tags($post['gameid']);
        $game = $games->get($gameid);

        $tiles = new Tiles($site);
        $all = $tiles->getByGame($gameid);
        $game->createGame($all);

        if(isset($post['leak']) and isset($post['radio'])){
            $split = explode(',', strip_tags($post['leak']));
            $row = intval($split[0]);
            $col = intval($split[1]);

            $turn = $game->getTurn();
            $ndx = intval($post['radio']);
            $pipe = clone $game->getPlayer($turn)->getSelections()[$ndx];
            $result = $game->addPipe($pipe, $row, $col);
            if ($result == Steampunked::SUCCESS) {
                $pipe = new Tile(Tile::PIPE, $turn);
                $game->getPlayer($turn)->setSelection($pipe, $ndx);
                $game->nextTurn();

                //update database;
                $tiles = new Tiles($site);
                $tiles->insert(Tile::PIPE, $row, $col, $pipe->open(), $turn, $game->getId());
            }
        }
        else if(isset($post['rotate']) and isset($post['radio'])){
            $turn = $game->getTurn();
            $ndx = intval($post['radio']);
            $game->getPlayer($turn)->getSelections()[$ndx]->rotate();
        }
        else if(isset($post['discard']) and isset($post['radio'])){
            $turn = $game->getTurn();
            $ndx = intval($post['radio']);
            $pipe = new Tile(Tile::PIPE, $turn);
            $game->getPlayer($turn)->setSelection($pipe, $ndx);
            $game->nextTurn();
        }
        else if(isset($post['open'])){
            $turn = $game->getTurn();
            if ($game->openValve($turn)) {
                $game->nextTurn();
                $game->setContinued(false);
            } else {
                $game->setContinued(false);
            }
        }
        else if(isset($post['giveup'])){
            $game->nextTurn();
            $game->setContinued(false);
        }
        else if(isset($post['newgame'])){
            $this->page = './';
            $game->setContinued(true);
            $this->reset = true;
        }
    }

    public function isReset()
    {
        return $this->reset;
    }

    public function getPage()
    {
        return $this->page;
    }

    private $page = 'game.php';     // The next page we will go to
    private $reset = false;
}
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
    public function __construct(Site $site ,Steampunked $steampunked, $post) {
        if (isset($post['player1']) and isset($post['player2']) and isset($post['gamesize'])) {
            $games = new Games($site);
            $id = $games->insert(strip_tags($post['player1']), strip_tags($post['player2']), $post['gamesize']);
            $player0 = new Player(strip_tags($post['player1']), 0);
            $player1 = new Player(strip_tags($post['player2']), 1);
            $steampunked->createGame($id, $post['gamesize'], $player0, $player1);
        }

        if(isset($post['leak']) and isset($post['radio'])){
            $split = explode(',', strip_tags($post['leak']));
            $row = intval($split[0]);
            $col = intval($split[1]);

            $turn = $steampunked->getTurn();
            $ndx = intval($post['radio']);
            $pipe = clone $steampunked->getPlayer($turn)->getSelections()[$ndx];
            $result = $steampunked->addPipe($pipe, $row, $col);
            if ($result == Steampunked::SUCCESS) {
                $pipe = new Tile(Tile::PIPE, $turn);
                $steampunked->getPlayer($turn)->setSelection($pipe, $ndx);
                $steampunked->nextTurn();

                //update database;
                $tiles = new Tiles($site);
                $tiles->insert(Tile::PIPE, $row, $col, $pipe->open(), $turn, $steampunked->getId());
            }
        }
        else if(isset($post['rotate']) and isset($post['radio'])){
            $turn = $steampunked->getTurn();
            $ndx = intval($post['radio']);
            $steampunked->getPlayer($turn)->getSelections()[$ndx]->rotate();
        }
        else if(isset($post['discard']) and isset($post['radio'])){
            $turn = $steampunked->getTurn();
            $ndx = intval($post['radio']);
            $pipe = new Tile(Tile::PIPE, $turn);
            $steampunked->getPlayer($turn)->setSelection($pipe, $ndx);
            $steampunked->nextTurn();
        }
        else if(isset($post['open'])){
            $turn = $steampunked->getTurn();
            if ($steampunked->openValve($turn)) {
                $steampunked->nextTurn();
                $steampunked->setContinued(false);
            } else {
                $steampunked->setContinued(false);
            }
        }
        else if(isset($post['giveup'])){
            $steampunked->nextTurn();
            $steampunked->setContinued(false);
        }
        else if(isset($post['newgame'])){
            $this->page = './';
            $steampunked->setContinued(true);
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
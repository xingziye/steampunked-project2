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
        $root = $site->getRoot();
        $this->page = "$root/game.php";

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
            $selection = $game->getSelection($turn);
            $pipe = clone $selection[$ndx];
            if ($game->check($pipe, $row, $col) == Steampunked::SUCCESS) {
                $newSelect = new Tile(Tile::PIPE_TO_SELECT, $turn);
                $tiles->updateSelection($newSelect, $ndx, $gameid);
                $tiles->insert(Tile::PIPE, $row, $col, $pipe->open(), $turn, $game->getId());

                $turn = $game->nextTurn();
                $games->updateTurn($turn, $gameid);

                /*
                 * PHP code to cause a push on a remote client.
                 */
                $msg = json_encode(array('key'=>'Lill'.$turn, 'cmd'=>'reload'));

                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

                $sock_data = socket_connect($socket, '127.0.0.1', 8078);
                if(!$sock_data) {
                    echo "Failed to connect";
                } else {
                    socket_write($socket, $msg, strlen($msg));
                }
                socket_close($socket);
            }
        }
        else if(isset($post['rotate']) and isset($post['radio'])){
            $turn = $game->getTurn();
            $ndx = intval($post['radio']);
            $selection = $game->getSelection($turn);
            $newSelect = $selection[$ndx];
            $newSelect->rotate();
            $tiles->updateSelection($newSelect, $ndx, $gameid);
        }
        else if(isset($post['discard']) and isset($post['radio'])){
            $turn = $game->getTurn();
            $ndx = intval($post['radio']);
            $newSelect = new Tile(Tile::PIPE_TO_SELECT, $turn);
            $tiles->updateSelection($newSelect, $ndx, $gameid);

            $turn = $game->nextTurn();
            $games->updateTurn($turn, $gameid);

            /*
                * PHP code to cause a push on a remote client.
                */
            $msg = json_encode(array('key'=>'Lill'.$turn, 'cmd'=>'reload'));

            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            $sock_data = socket_connect($socket, '127.0.0.1', 8078);
            if(!$sock_data) {
                echo "Failed to connect";
            } else {
                socket_write($socket, $msg, strlen($msg));
            }
            socket_close($socket);
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

    public function push($key, $cmd) {
        /*
             * PHP code to cause a push on a remote client.
             */
        $msg = json_encode(array('key'=>'Lill'.$key, 'cmd'=>$cmd));

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $sock_data = socket_connect($socket, '127.0.0.1', 8078);
        if(!$sock_data) {
            echo "Failed to connect";
        } else {
            socket_write($socket, $msg, strlen($msg));
        }
        socket_close($socket);
    }

    public function isReset()
    {
        return $this->reset;
    }

    public function getPage()
    {
        return $this->page;
    }

    private $page;     // The next page we will go to
    private $reset = false;
}
<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/8/16
 * Time: 3:13 PM
 */

namespace Steampunked;


class GamesController
{
    /**
     * GamesController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, User $user, array $post) {


        $root = $site->getRoot();

        if(isset($post['create'])){
            ///CREATE GAME
            $this->redirect = "$root/creategame.php";

        }
        else{
            ///JOIN GAME
            if(isset($post['game'])){
                $gameid = strip_tags($post['game']);
            }
            else{
                $this->redirect = "$root/gametable.php";
                return;
            }

            $games = new Games($site);
            $id = $user->getId();
            $games->joinGame($gameid, $id);
            $this->redirect = "$root/game.php";

            $key = $games->get($gameid)['player1'];
            /*
             * PHP code to cause a push on a remote client.
             */
            $msg = json_encode(array('key'=>'Lill'.$key, 'cmd'=>'start'));

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

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }



    private $redirect;	///< Page we will redirect the user to.

}
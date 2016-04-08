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


//        $player1 = strip_tags($post['player1name']);
//        $player2 = strip_tags($post['player2name']);

        $root = $site->getRoot();

        if(isset($post['create'])){
            ///CREATE GAME
            $this->redirect = "$root/creategame.php";

        }
        else{
            $gameid=0;
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
            $this->redirect = "$root/gametable.php";


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
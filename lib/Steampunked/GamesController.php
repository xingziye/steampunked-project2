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
    public function __construct(Site $site, array &$session, array $post) {

        $id = strip_tags($post['game']);
//        $player1 = strip_tags($post['player1name']);
//        $player2 = strip_tags($post['player2name']);

        $root = $site->getRoot();

        if(isset($post['create'])){
            $this->redirect = "$root/creategame.php";

        }
        else{
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
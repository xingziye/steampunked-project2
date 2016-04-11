<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/8/16
 * Time: 3:23 PM
 */

namespace Steampunked;


class CreateGameController
{
    /**
     * GamesController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param array $post $_POST
     */
    public function __construct(Site $site, User $user, array $post) {;

        $root = $site->getRoot();

        if(isset($post['gamesize'])){
            $size = strip_tags($post['gamesize']);

            $games = new Games($site);
            $id = $user->getId();
            $gameid = $games->createGame($size, $id);

            // initialize player1 selections
            $game = $games->getGameByUser($id);
            $game->createGame(array());
            $tiles = new Tiles($site);
            $selection1 = $game->getSelection($id);
            $tiles->insertSelection($selection1, $gameid);

            $this->redirect = "$root/wait.php";
        }
        else{
            $this->redirect = "$root/index.php";

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
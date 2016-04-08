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
     * @param assay $post $_POST
     */
    public function __construct(Site $site, User $user, array $post) {;

        $root = $site->getRoot();

        if(isset($post['gamesize'])){
            $size = strip_tags($post['gamesize']);

            $games = new Games($site);
            $id = $user->getId();
            $games->createGame($size, $id);
            $this->redirect = "$root/gametable.php";

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
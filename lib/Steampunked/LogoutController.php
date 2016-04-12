<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/11/16
 * Time: 7:12 PM
 */

namespace Steampunked;


class LogoutController
{
    public function __construct(Site $site, User $user, array &$session) {

        if($user !=null){
            $id = $user->getId();

            $game = new Games($site);

            $game->removeFromGame($id);

            if(isset($session[User::SESSION_NAME])) {
                unset($session[User::SESSION_NAME]);

            }
        }


    }


}
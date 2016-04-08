<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 2:47 PM
 */

namespace Steampunked;


class LoginController
{
    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post) {
        // Create a Users object to access the table
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);

        $root = $site->getRoot();

        if(isset($post['guest'])){
            $id = 0;
            $row = array('id' => $id,
                'email' => null,
                'name' => 'Guest',
                'gameid' => null,
                'password' => null
            );

            $guestuser = new User($row);
            $user = $users->addGuest($guestuser);
            $users->updateGuestName($user);
            $session[User::SESSION_NAME] = $user;
            $this->redirect = "$root/gametable.php";

        }
        else{
            $session[User::SESSION_NAME] = $user;

            if($user === null) {
                // Login failed
                $this->redirect = "$root/index.php?e";
            }
            else{
                $this->redirect = "$root/gametable.php";
            }
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
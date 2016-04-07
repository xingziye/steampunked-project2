<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 5:27 PM
 */

namespace Steampunked;


class SignUpController
{
    public function __construct(Site $site, array $post) {
        $root = $site->getRoot();

        $this->redirect = "$root/index.php";
        //
        // Determine if this is new user or editing an
        // existing user. We determine that by looking for
        // a hidden form element named "id". If there, it
        // gives the ID for the user we are editing. Otherwise,
        // we have no user, so I'll use an ID of 0 to indicate
        // that we are adding a new user.
        //

        if(isset($post['cancel'])) {
            return;
        }

//        if(isset($post['id'])) {
//            $id = strip_tags($post['id']);
//        }else {
//            $id = 0;
//        }

        //
        // Get all of the stuff from the form
        //
        $email = strip_tags($post['email']);
        $name = strip_tags($post['name']);
        $id = 0;
        $row = array('id' => $id,
            'email' => $email,
            'name' => $name,
            'gameid' => null,
            'password' => null
        );

        $user = new User($row);

        $users = new Users($site);
        if($id == 0) {
            // This is a new user
            $mailer = new Email();
            $users->add($user, $mailer);
        }
        else{
            return;

        }
    }

    /**
     * @return mixed
     */
    public function getRedirect() {
        return $this->redirect;
    }


    private $redirect;	///< Page we will redirect the user to.

}
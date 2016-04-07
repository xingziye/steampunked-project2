<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 6:12 PM
 */

namespace Steampunked;


class PasswordValidationController
{
    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();
        //
        // 1. Ensure the validator is correct! Use it to get the user ID.
        // 2. Destroy the validator record so it can't be used again!
        //
        $validators = new Validators($site);
        $userid = $validators->getOnce($post['validator']);
        $val = $post['validator'];
        if($userid === null) {
            $this->redirect = "$root/";
            $validators->deleteValidator($post['validator']);
            return;
        }

        if(isset($post['cancel'])){
            $this->redirect = "$root/";
            return;
        }

        $users = new Users($site);
        $editUser = $users->get($userid);
        if($editUser === null) {
            // User does not exist!
            $this->redirect = "$root/";
            $validators->deleteValidator($post['validator']);
            return;
        }

        $email = trim(strip_tags($post['email']));
        if($email !== $editUser->getEmail()) {
            // Email entered is invalid
            $this->redirect = "$root/password-validate.php?e&v=$val";
            return;
        }

        $password1 = trim(strip_tags($post['password']));
        $password2 = trim(strip_tags($post['password2']));
        if($password1 !== $password2) {
            // Passwords do not match
            $this->redirect = "$root/password-validate.php?pe&v=$val";
            return;
        }

        if(strlen($password1) < 8) {
            // Password too short
            $this->redirect = "$root/password-validate.php?sh&v=$val";
            return;
        }


        $users->setPassword($userid, $password1);
        $validators->deleteValidator($post['validator']);
        $this->redirect = "$root/";


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
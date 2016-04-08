<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 2:47 PM
 */

namespace Steampunked;


class LoginView
{

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct($session, $get)
    {

        $this->session = $session;
        if(isset($get['e'])) {
            $this->wrong = true;
        }


    }

    public function createLogin(){
        $html = <<<HTML
<div class="login">
    <div class ="logo">
        <p><img src="images/title.png" alt="Steampunked Logo"></p>
    </div>
    <form method="post" action="post/login-post.php">
        <fieldset class="login">

HTML;

                if($this->wrong === true){
            $html .= "<p class=\"wrong\" >Wrong Email/Password</p>";
        }

        $html .=<<<HTML

            <legend>Login</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Enter Email" >
            </p>
            <p>
                <label for="password">Password</label><br>
                <input type="text" id="password" name="password" placeholder="Enter Password">
            </p>

            <p>
                <input type="submit" name="ok" id="ok" value="OK"> <input type="submit" id="cancel" name="cancel" value="Cancel">
                <a href="signup.php" >Sign Up</a><p>-OR-</p><input type="submit" name="guest" id="guest" value="Play as Guest">
            </p>

        </fieldset>
    </form>
    </div>

HTML;

        return $html;

    }

    private $get;
    private $session;
    private $wrong = false;
    private $site;

}
<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 5:04 PM
 */

namespace Steampunked;


class SignUpView extends View
{

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct()
    {

    }

    public function present(){
        $html = <<<HTML
        <div class ="logo">
        <p><img src="images/title.png" alt="Steampunked Logo"></p>
    </div>
    <form method="post" action="signup-post.php">
        <fieldset class="login">
            <legend>Registration</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Enter Email" >
            </p>
            <p>
                <label for="name">Name</label><br>
                <input type="text" id="name" name="name" placeholder="Enter Name" >
            </p>
            <p>

            <p>
                <input type="submit" name="ok" id="ok" value="OK"> <input type="submit" id="cancel" name="cancel" value="Cancel">
            </p>

        </fieldset>
    </form>

HTML;

        return $html;
    }

}
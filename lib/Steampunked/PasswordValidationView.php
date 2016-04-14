<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 6:07 PM
 */

namespace Steampunked;


class PasswordValidationView
{
    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site, array $get)
    {
        $this->site = $site;
        $this->get = $get;

        if(isset($get['v'])) {
            $this->validator = strip_tags($get['v']);
        }

        if(isset($get['e'])) {
            $this->wrongEmail = true;
        }
        if(isset($get['sh'])) {
            $this->shortPassword = true;
        }
        if(isset($get['pe'])) {
            $this->noMatch = true;
        }
    }



    public function present()
    {
        $html = <<< HTML
    <div class ="logo">
        <p><img src="images/title.png" alt="Steampunked Logo"></p>
    </div>
    <form method="post" action="post/password-validate.php">
    <input type="hidden" name="validator" value="$this->validator">
        <fieldset class="login">
HTML;

        if ($this->wrongEmail === true) {
            $html .= "<p class='wrong'>Incorrect email</p>";
        }
        if ($this->shortPassword === true) {
            $html .= "<p class='wrong'>Password must be 8 characters</p>";
        }
        if ($this->noMatch === true) {
            $html .= "<p class='wrong'>Password do not match</p>";
        }

        $html .= <<<HMTL
            <legend>Validation</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Enter Email" >
            </p>
            <p>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Enter Password">
            </p>
            <p>
                <label for="password">Re-enter Password</label><br>
                <input type="password" id="password2" name="password2" placeholder="Enter Password">
            </p>

            <p>
                <input type="submit" name="ok" id="ok" value="OK"> <input type="submit" id="cancel" name="cancel" value="Cancel">
            </p>

        </fieldset>
    </form>
HMTL;

        return $html;

    }

    private $wrongEmail = false;
    private $shortPassword = false;
    private $noMatch = false;
    private $site;	///< The Site object
    private $get;
    private $validator;
}
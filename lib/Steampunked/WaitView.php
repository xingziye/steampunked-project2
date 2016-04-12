<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/11/16
 * Time: 6:35 PM
 */

namespace Steampunked;


class WaitView
{
    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site)
    {
        $this->site = $site;

    }

    public function present()
    {
        $html=<<<HTML
<div class="login">
    <div class ="logo">
        <p><img src="images/title.png" alt="Steampunked Logo"></p>
            <br>
            <p>Waiting for other player to join your game...</p>
            <img src="images/steamsplash2.png">
    </div>
</div>
HTML;
        return $html;
    }

    private $site;

}
<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/8/16
 * Time: 3:20 PM
 */

namespace Steampunked;


class CreateGameView
{
    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site)
    {
        $this->site = $site;

    }

    public function present(){
        $html = <<<HTML
        <div class="screen">
    <p><img src="images/title.png" alt="Steampunked Logo"></p>
    <form method="post" action="post/create-game-post.php">
        <fieldset>
            <legend>Game Size</legend>
            <br>
            <p>
                <label for="6x6">6x6</label>
                <input type="radio" name="gamesize" id="6x6" value="6" checked="checked" >
                <label for="10x10">10x10</label>
                <input type="radio" name="gamesize" id="10x10" value="10">
                <label for="20x20">20x20</label>
                <input type="radio" name="gamesize" id="20x20" value="20">
            </p>
            <br>
            <p>
                <input type="submit">
            </p>
        </fieldset>
    </form>
</div>

HTML;

        return $html;
    }

    private $site;	///< The Site object


}
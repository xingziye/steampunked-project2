<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/8/16
 * Time: 2:38 PM
 */

namespace Steampunked;


class GamesView
{
    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site, $get)
    {
        $this->site = $site;

        if(isset($get['lo'])){
            $this->logout= true;
        }

    }

    public function header(){

        $html = <<<HTML
        <nav>
            <ul class="left">
                <li><a href="./gametable.php">Game Lobby</a></li>
            </ul>
            <ul class="right">
                <li><a href="post/logout.php">Log out</a></li>
            </ul>
        </nav>
HTML;
        return $html;

    }

    public function present()
    {
        $html = <<<HTML
<div class="login">
    <div class ="logo">
        <p><img src="images/title.png" alt="Steampunked Logo"></p>
    </div>
<form class="table" action="post/games-post.php" method="post">
HTML;
        if($this->logout == true){
           $html .= "<p class='loggedout'>Opponenet Logged Out</p>";

        }

        $html .= <<<HTML
    <h1>Active Open Games</h1>
	<p>
	<input type="submit" name="create" id="create" value="Create Game">
	<input type="submit" name="join" id="join" value="Join Game">
	</p>
	<table>
		<tr>
			<th>Join</th>
			<th>Player1</th>
			<th>Player2</th>
			<th>Game Size</th>
		</tr>
HTML;
        $games = new Games($this->site);
        $games = $games->getGames();
        if ($games != null) {
            $name1='';
            $name2='';
            foreach ($games as $game) {
                if(isset($game['user1'])){
                    $name1 = $game['user1'];
                }
                if(isset($game['user2'])){
                    $name2 = $game['user2'];
                }
                $size = $game['size'];
                $id = $game['id'];

                $html .= <<<HTML
		<tr>
			<td><input type="radio" id="game" name="game" value="$id"></td>
			<td>$name1</td>
			<td>$name2</td>
			<td>$size</td>
		</tr>
HTML;
            }

                $html .= <<<HTML

	</table>
</form>
</div>
HTML;


        }
        return $html;

    }
    private $site;	///< The Site object
    private $logout;

}
<?php
require 'lib/game.inc.php';
$view = new Steampunked\View($steampunked);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php //echo $view->createStartPage(); ?>

<div class="login">
    <div class ="logo">
        <p><img src="images/title.png" alt="Steampunked Logo"></p>
    </div>
    <form method="post" action="game-post.php">
        <fieldset class="login">
            <legend>Password Recovery</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Enter Email" >
            </p>

            <p>
                <input type="submit" name="ok" id="ok" value="OK"> <input type="submit" id="cancel" name="cancel" value="Cancel">
            </p>

        </fieldset>
    </form>
</div>
</body>
</html>
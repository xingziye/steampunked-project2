<?php
require 'lib/game.inc.php';
$view = new Steampunked\View($steampunked);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="project1.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php //echo $view->createStartPage(); ?>

<div class="login">
    <div class ="logo">
        <p><img src="images/title.png" alt="Steampunked Logo"></p>
    </div>
    <form method="post" action="game-post.php">
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
                <label for="password">Password</label><br>
                <input type="text" id="password" name="password" placeholder="Enter Password">
            </p>
            <p>
                <label for="password">Re-enter Password</label><br>
                <input type="text" id="password2" name="password2" placeholder="Enter Password">
            </p>

            <p>
                <input type="submit" name="ok" id="ok" value="OK"> <input type="submit" id="cancel" name="cancel" value="Cancel">
            </p>

        </fieldset>
    </form>
</div>
</body>
</html>
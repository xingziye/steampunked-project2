<?php
require 'lib/game.inc.php';
$view = new Steampunked\View($site, $user);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
    <script src="reload.js"></script>
</head>
<body>
    <?php echo $view->createGrid(); ?>
    <?php echo $view->presentTurn(); ?>
    <?php echo $view->createRadioButtons(); ?>
    <?php echo $view->createOptionButtons(); ?>
</body>
</html>
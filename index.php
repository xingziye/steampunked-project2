<?php
require 'lib/game.inc.php';
$view = new Steampunked\LoginView($_SESSION, $_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="project1.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php echo $view->createLogin(); ?>

</body>
</html>
<?php
require '../lib/game.inc.php';

$controller = new Steampunked\CreateGameController($site, $user, $_POST);
header("location: " . $controller->getRedirect());
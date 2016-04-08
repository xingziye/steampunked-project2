<?php
require '../lib/game.inc.php';

$controller = new Steampunked\CreateGameController($site, $_SESSION, $_POST);

header("location: " . $controller->getRedirect());
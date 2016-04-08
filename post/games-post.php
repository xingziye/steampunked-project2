<?php
require '../lib/game.inc.php';

$controller = new Steampunked\GamesController($site, $_SESSION, $_POST);

header("location: " . $controller->getRedirect());
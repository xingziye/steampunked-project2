<?php
require __DIR__ . '/lib/game.inc.php';

$controller = new Steampunked\LoginController($site, $_SESSION, $_POST);

header("location: " . $controller->getRedirect());
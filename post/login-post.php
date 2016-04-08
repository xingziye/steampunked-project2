<?php
require '../lib/game.inc.php';

$controller = new Steampunked\LoginController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());
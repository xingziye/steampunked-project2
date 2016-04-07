<?php
require '../lib/game.inc.php';

$controller = new Steampunked\SignUpController($site, $_POST);
header("location: " . $controller->getRedirect());
<?php
require '../lib/game.inc.php';

$controller = new Steampunked\PasswordValidationController($site, $_POST);

header("location: " . $controller->getRedirect());
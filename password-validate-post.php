<?php
require __DIR__ . '/lib/game.inc.php';

$controller = new Steampunked\PasswordValidationController($site, $_POST);

header("location: " . $controller->getRedirect());
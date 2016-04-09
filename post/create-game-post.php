<?php
require '../lib/site.inc.php';

$controller = new Steampunked\CreateGameController($site, $user, $_POST);
header("location: " . $controller->getRedirect());
<?php
require '../lib/site.inc.php';

$controller = new Steampunked\GamesController($site, $user, $_POST);
header("location: " . $controller->getRedirect());
<?php
require '../lib/site.inc.php';

$controller = new Steampunked\PasswordValidationController($site, $_POST);

header("location: " . $controller->getRedirect());
<?php
require '../lib/site.inc.php';

$controller = new Steampunked\Controller($site, $_POST);

if($controller->isReset()) {
    //unset($_SESSION[STEAMPUNKED_SESSION]);

}

header("location: " . $controller->getPage());
exit;
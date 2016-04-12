<?php
$open = false;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new Steampunked\LogoutController($site, $user, $_SESSION);



header("location: " . $site->getRoot());

exit;
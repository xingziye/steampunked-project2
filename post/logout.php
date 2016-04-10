<?php
require '../lib/site.inc.php';
unset($_SESSION[Steampunked\User::SESSION_NAME]);
header("location: " . $site->getRoot());
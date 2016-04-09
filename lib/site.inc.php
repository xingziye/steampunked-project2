<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 2/5/16
 * Time: 9:25 PM
 */

require __DIR__ . "/../vendor/autoload.php";

$site = new Steampunked\Site();
$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}

// Start the PHP session system
session_start();

$user = null;
if(isset($_SESSION[Steampunked\User::SESSION_NAME])) {
    $user = $_SESSION[Steampunked\User::SESSION_NAME];
}

// If there is a session, use that. Otherwise, create one
//if(!isset($_SESSION[STEAMPUNKED_SESSION])) {
//    $_SESSION[STEAMPUNKED_SESSION] = new Steampunked\Steampunked();
//}

//$steampunked = $_SESSION[STEAMPUNKED_SESSION];


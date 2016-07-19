<?php
/**
* Univerzální Upload fotek
* */
//require_once dirname(__FILE__) . "/../inc/init_admin.php";
/*   */
if (isset($_POST["PHPSESSID"])) {
session_id($_POST["PHPSESSID"]);
}

session_start();
header('Content-type: text/html; charset=utf-8');
require_once dirname(__FILE__) . "/../inc/init_spolecne.php";
//$userController->islogIn();

if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
	//print "Location: " . URL_HOME . "login.php";
	header("Location: " . URL_HOME . "login.php");
	exit();
} else {
	define('LOGIN_STATUS', 'ON');
}
/**/
$fotoController = new FotoController();
$fotoController->createAction();

$filesController = new FilesController();
$filesController->createAction();
?>
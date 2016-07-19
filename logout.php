<?php
/*
* logout.php
* 12.4.11 Pridani presmerovani pomoci redirect
*/
session_start();
header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache');
header('Pragma: nocache');
include dirname(__FILE__) . "/inc/init_spolecne.php";
//$userController = new UserController();

$redirect = isset($_GET["redirect"])? $_GET["redirect"] : $_SERVER["HTTP_REFERER"];
$redirect = !empty($redirect) ? $redirect : URL_HOME;

if ($GAuth->logOut()) {
	print '<meta content="2; URL=' . URL_HOME2 . '" http-equiv="Refresh">';
	print 'Byly jste odhlášeni. Probíhá přesměrování. Pokud nedojde k přesměrování <a href="' . URL_HOME2 . 'login.php?redirect='.$redirect.'">klikněte zde</a>';

	//@header("Refresh: 2;url=" . URL_HOME2 . "login.php?redirect=".$redirect);
	@header("Refresh: 0;url=" . URL_HOME2 . "");
	exit();
}

?>
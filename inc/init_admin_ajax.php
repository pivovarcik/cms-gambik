<?php
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");

define('ADMIN', 'YES');
//define('URL_HOME', "/admin/");   // pro Url
//define('URL_HOME_REL', "/admin/");   // pro Url
include dirname(__FILE__) . "/init_spolecne.php";
define('URL_HOME_SITE', $settings->get("URL_HOME_REL"));   // pro Url
if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
	//print "Location: " . URL_HOME . "login.php";
	//header("Location: /../login.php");

	exit();
} else {
	define('LOGIN_STATUS', 'ON');
}

?>
<?php
session_start();
define('URL_HOME', "/admin/");   // pro Url
define('URL_HOME_REL', "/admin/");   // pro Url
include dirname(__FILE__) . "/../../inc/init_spolecne.php";

$result = array();
if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
	$result["status"] = "unautorized";
	$result["message"] = "Neautorizovaný přístup";
	$json = json_encode($result);
	print_r($json);
	exit;

} else {
	define('LOGIN_STATUS', 'ON');
}


if (!isset($_GET["action"])) {
	$result["status"] = "noaction";
	$json = json_encode($result);
	print_r($json);
	exit;
}
switch ($_GET["action"]) {
	case "AdminSettings":
		$SettingsController = new SettingsController();
		if ($SettingsController->saveAjaxAction()) {
			$result["status"] = "success";
			$result["message"] = "Data byla uložena";
			$json = json_encode($result);
			print_r($json);
			exit;
		}
		break;
} // switch




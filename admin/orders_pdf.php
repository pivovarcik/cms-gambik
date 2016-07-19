<?php
/**
 * Add song my favorite
 * */
/**/
session_start();
/*
header("Content-type: text/pdf; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
*/
define('PATH_ROOT2', dirname(__FILE__));
//error_reporting(E_ALL);
$data =array();
$data["status"] = "wrong";

require_once PATH_ROOT2.'/../inc/init_spolecne_lite.php';
if (isset($_GET["id"]) && is_numeric($_GET["id"]))
{
	/**/
		/*
	error_reporting(E_ERROR);
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
*/
	require_once PATH_ROOT . "core/controller/OrderController.php";
	require_once PATH_ROOT . "core/controller/EshopController.php";
	require_once PATH_ROOT . "core/controller/TranslatorController.php";
	require_once PATH_ROOT . "core/library/Gambik/G_Translator.php";

	$orderController = new OrderController();
	print	$orderController->createPDF($_GET["id"],"I");

} else {
	exit();
}?>
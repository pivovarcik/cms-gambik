<?php
/**
 * Add song my favorite
 * */
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));
define('PATH_TEMP', PATH_ROOT2 . '/../template/');

$data =array();
$data["status"] = "wrong";

	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
$orderController = new OrderController();
$orderController->createAction();

?>

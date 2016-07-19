<?php
/**
 * Add song my favorite
 * */
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));


	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
	/*
error_reporting(E_ERROR);
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/
$id = isset($_GET["order_id"]) ?  $_GET["order_id"] : 0;
	$heureka = new HeurekaController();
	$detail = $heureka->postRequestHeureka($id);

//	print_r($detail);

	//print_r($heureka->order_details);

?>

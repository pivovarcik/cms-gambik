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


//require_once PATH_ROOT2.'/../inc/init_spolecne.php';
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$requestController = new models_RequestTicket();

$params = array();
$params["limit"] = 10000;
$params["page"] = 1;
/*
if (isset($_GET["year"]) && !empty($_GET["year"]) && isset($_GET["month"])&& !empty($_GET["month"])) {
	$od = strtotime("1.".$_GET["month"].".".$_GET["year"]);
	$params["dateFrom"] = date("Ymd",$od);

	$do = strtotime(days_in_month($_GET["year"],$_GET["month"]) .".".$_GET["month"].".".$_GET["year"]);
	$params["dateTo"] = date("Ymd",$do);
}
*/
$mesic = date("m");
$rok = date("Y");

if (isset($_GET["year"]) && !empty($_GET["year"]) && isset($_GET["month"])&& !empty($_GET["month"])) {
	$mesic = $_GET["month"];
	$rok = $_GET["year"];
}

$Kalendar = new GCalender($mesic,$rok);
$params["dateFrom"] = date("Ymd",strtotime($Kalendar->getPrvniZobrazenyDatum()));
$params["dateTo"] = date("Ymd",strtotime($Kalendar->getPosledniZobrazenyDatum()));

//print_r($params);

$list = $requestController->getList($params);
if (is_null($list)) {
	$list =array();
}
for ($i=0;$i < count($list);$i++)
{
	 $list[$i]->start_date = date("Y-m-d",strtotime($list[$i]->TimeStamp));
}
$json = json_encode($list);
print_r($json);
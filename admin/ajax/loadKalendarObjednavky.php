<?php
/**
 * Add song my favorite
 * */
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");

include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$requestController = new models_Orders();

$params = new ListArgs();
$params->limit = 10000;
$params->page = 1;
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
$params->dateFrom = date("Ymd",strtotime($Kalendar->getPrvniZobrazenyDatum()));
$params->dateTo = date("Ymd",strtotime($Kalendar->getPosledniZobrazenyDatum()));

//print_r($params);

$list = $requestController->getList($params);
if (is_null($list)) {
	$list =array();
}

$list2 =array();
for ($i=0;$i < count($list);$i++)
{
	$list2[$i]->start_date = date("Y-m-d",strtotime($list[$i]->TimeStamp));
	$list2[$i]->title =  $list[$i]->code;
	$list2[$i]->status_class =  $list[$i]->stav;
	$list2[$i]->doklad_id =  $list[$i]->id;
	$list2[$i]->link_edit =  $list[$i]->link_edit;
	$list2[$i]->description =  $list[$i]->description;
	$list2[$i]->cost_total =  "Celkem: " . numberFormat($list[$i]->cost_total);

}
$json = json_encode($list2);
print_r($json);
<?php
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$uliceController = new models_MestaObce();


$params = array();
$params["mesto"] = isset($_GET["term"]) ? $_GET["term"] : "";
$params["limit"] = 10;
$params["order"] = "score DESC, mo.obec asc, mo.okres";
$mestaList = $uliceController->getList($params);
$data = array();
for ($i=0; $i < count($mestaList);$i++){
	$data[$i]["id"] = $mestaList[$i]->id;
	$data[$i]["latitude"] = $mestaList[$i]->latitude;
	$data[$i]["longitude"] = $mestaList[$i]->longitude;

	$perex = $mestaList[$i]->mesto;

	$data[$i]["value"] = $mestaList[$i]->obec . ", " . $mestaList[$i]->okres . "";
}
$json = json_encode($data);
print_r($json);
exit;
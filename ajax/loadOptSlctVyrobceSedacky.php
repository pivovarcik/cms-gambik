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

if (isset($_POST["id"])) {
	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
	$parent_value = $_POST["id"];
	$productVyrobceModel = new models_ProductVyrobce();
	$productVyrobceList = $productVyrobceModel->get_value_from_parent($parent_value);
	$data=array();

	$data[0] = "-- vyberte --";
	foreach ($productVyrobceList as $key => $value)
	{

		$data[$value->id] = $value->name;
	//	$slct .= '<option value="'.$key.'">'.$value["name"].'</option>';
	}
	//$slct .='</select>';$json = json_encode($result);
	$json = json_encode($data);
	print_r($json);
}
//print "hotovo";
?>

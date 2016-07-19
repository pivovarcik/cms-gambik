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

	$_attribs = new models_Attributes();

	if (!empty($_POST["parent"])) {
		if ($_POST["combo"] == "prumerKolaSlct") {
			$profilDleSirky = $_attribs->get_attribute_value_from_category($_POST["parent"],$_POST["id"]);
			//$profilDleSirky = $_attribs->get_attribute_value_from_parents($_POST["parent"],$_POST["id"]);
		} else {
			$profilDleSirky = $_attribs->get_attribute_value_from_parents($_POST["parent"],$_POST["id"]);
		}

	} else {
		$profilDleSirky = $_attribs->get_attribute_value_from_parent(0,$_POST["id"]);
	}
	$data =array();
	$data[0] = "-- vyberte --";
	foreach ($profilDleSirky as $key => $value)
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
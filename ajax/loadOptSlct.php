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

	$tree = new G_Tree();
	$rubrikyList = $tree->categoryTree(array(
			"parent"=>$_POST["id"],
			"vnoreni"=>0,
			"debug"=>0,
			));
	/*
	   print "<pre>";
	   print_r($rubrikyList);
	   print "</pre>";
	*/
	/*
		$slct = '<label>Typ auta:</label><select name="typecar" id="typeCarSlct">';
		$slct .= '<option value="0">-- vyberte --</option>';
*/
	$data=array();

	$data[0] = "-- vyberte --";
	foreach ($rubrikyList as $key => $value)
	{

		$data[$value->id] = $value->title;
	//	$slct .= '<option value="'.$key.'">'.$value["name"].'</option>';
	}
	//$slct .='</select>';$json = json_encode($result);
	$json = json_encode($data);
	print_r($json);
}
//print "hotovo";
?>

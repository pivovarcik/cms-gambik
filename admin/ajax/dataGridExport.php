<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

if (isset($_GET["model"])) {

	$model = $_GET["model"];

	$params = array();

	$registerQuery = array("df","dt","order","status","q","sort","user","limit","sirka", "profil","car","typecar","motorcar","prumer","pg");

	foreach ($registerQuery as $key => $val){
		//	print $val;
		if (isset($_GET[$val])) {

			$params[$val] = (int)$_GET[$val];
		/*	if (is_array($_GET[$val])) {
				foreach ($_GET[$val] as $key2 => $val2){
					//	print $key2 . "<br />";
					$querys[] = $val . "[" . $key2 . "]=";
				}
			} else {
				$querys[$val] = $val."=".$_GET[$val];
			}*/


		}
	}

	$args = new ListArgs();
	foreach ($_GET as $key => $val)
	{
		$args->$key = $val;
	}



	$params = $_GET;

	//	print_r($args);

	//exit;
	$DataGridProvider = new DataGridProvider($model,$args);



	if (isset($_GET["export"])) {

	}
	if (isset($_GET["export"])) {

		if (strtolower($_GET["export"]) == "xls" ) {
			$DataGridProvider->exportDataToXls();
		}
		if (strtolower($_GET["export"]) == "csv" ) {
			$DataGridProvider->exportDataToCsv();
		}
	}
}
?>

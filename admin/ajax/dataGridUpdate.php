<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
//error_reporting(E_ALL);

$result = array();
if (isset($_GET["model"])) {

//print "tudy";


	//print_r($_POST);
//	exit;
	$modelName = "models_" . $_GET["model"];
	$controllerName =  $_GET["model"] . "Controller";
	$model = new $modelName;


	if (isset($model->formNameEdit)) {
		$form = (string) $model->formNameEdit;
		$formName = 'Application_Form_' . ucfirst($form);
		$formclass = new $formName();
	//	$formclass->setKontext(true);

	//	$postdata = $formclass->getValues();

	//	print_r($postdata);

		//exit;



		$controller = new $controllerName();

		if ($controller->saveAction()) {
			$result["status"] = "saved";
		} else {
			$result["status"] = "notsaved";
		}

	/*	if ($controller->saveMethod()) {
			$result["status"] = "saved";
		} else {
			$result["status"] = "notsaved";
		}*/
	//	print $postdata[$_POST["name"]];
	}/* else {
		$data = array();
		$data[$_POST["name"]] = $_POST["value"];
		$model->updateRecords($model->getTableName(),$data,"id=".$_POST["id"]);
		print $model->getLastQuery();
	}*/







/*	$data = array();
	$data[$_POST["name"]] = $_POST["value"];
	$model->updateRecords($model->getTableName(),$data,"id=".$_POST["id"]);
	print $model->getLastQuery();*/
	//print "hotovo";
} else {

	//print "nehotovo";
}
$json = json_encode($result);
print_r($json);
?>

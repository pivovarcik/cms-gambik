<?php
session_start();
define('URL_HOME', "/admin/");   // pro Url
define('URL_HOME_REL', "/admin/");   // pro Url
include dirname(__FILE__) . "/../../inc/init_spolecne.php";


if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
	//print "Location: " . URL_HOME . "login.php";
	//	header("Location: /login.php?redirect=".$_SERVER["REQUEST_URI"]);
	exit();
} else {
	define('LOGIN_STATUS', 'ON');
}

if (isset($_GET["model"])) {

	$model = $_GET["model"];

	$params = array();

	$registerQuery = array("df","dt","order","status","q","sort","user","limit","sirka", "profil","car","typecar","motorcar","prumer","pg");

	foreach ($registerQuery as $key => $val){
		//	print $val;
		if (isset($_GET[$val])) {

			$params[$val] = (int)$_GET[$val];
		}
	}

	$args = new ListArgs();


	$args->isAjaxTable = true;
/*	foreach ($_GET as $key => $val)
	{
		$args->$key = $val;
	}

*/

	$params = $_GET;

	//	print_r($args);

	//exit;
	$isWrapper = isset($_GET["wrapper"]) && !empty($_GET["wrapper"]) ? $_GET["wrapper"] : false;
	$gridId = isset($_GET["gridId"]) && !empty($_GET["gridId"]) ? $_GET["gridId"] : null;
	$DataGridProvider = new AjaxDataGridProvider($model,null, $isWrapper,$gridId);

	$isModal = isset($_GET["isModal"]) ? true : false;
	$DataGridProvider->setModalForm($isModal);



	if (isset($_GET["do"])) {

		$data = array();
		if ($DataGridProvider->saveFilterDefinitionAjaxAction() === true) {
			$data["status"] = "success";

		}


		$action = $_GET["do"];

	//	$DataGridProvider->saveFilterDefinitionAction();

	/*	if ($ciselnikController->saveAjaxAction() === true) {
			$data["status"] = "success";
		}*/

	/*	if ($ciselnikController->createAjaxAction() === true) {
			$data["status"] = "success";

		}*/

		$formName = "Application_Form_DataGridDefinitionEdit";
		$form = new $formName();
		$modalForm = new BootrapModalForm("myModal",$form);


		foreach ($form->getElement() as $key => $element ) {
			if (get_class($element) != "G_Form_Element_Submit" && get_class($element) != "G_Form_Element_Button") {
				$modalForm->addElement($element);
			}

		}

		 $modalForm->setBody($form->filterDefinitionRender());

		$data["html"] = $modalForm->render();

		//$data["html"] = $form->filterDefinitionRender();
		$data["control"] = $name;
		$data["action"] = $action;


		$data["pageCount"] =	$DataGridProvider->getTotal();

		$data["fd_id"] =	$DataGridProvider->filterDefinitionSelectedId;

		$json = json_encode($data);
		print_r($json);
		exit;
	}


$result = array();

$result["html"] =	$DataGridProvider->table();
$result["data"] =	$DataGridProvider->getDataLoaded();
$result["allowedOrder"] =	$DataGridProvider->getAllowedOrder();
$result["columns"] =	$DataGridProvider->getColumnsName();
$result["pageCount"] =	$DataGridProvider->getTotal();

$result["fd_id"] =	$DataGridProvider->filterDefinitionSelectedId;
	$json = json_encode($result);
	print_r($json);

}
?>

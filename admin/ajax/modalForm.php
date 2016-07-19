<?php

/*
ini_set("display_errors", 1);
error_reporting(E_ERROR);
error_reporting(E_ALL);*/
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";


$name = "Mj";
$action = "Create";

$name = $_POST["control"];
$action = $_POST["load-action"];

$controlerName = $name."Controller";
$ciselnikController = new $controlerName();

$actionName = $action."AjaxAction";
$data = $ciselnikController->$actionName();

//$data = array();

$formName = "Application_Form_" . $name. $action;
$form = new $formName();

$modalForm = new BootrapModalForm("myModal",$form->formName, $form->submitButtonName, $form->submitButtonTitle);


foreach ($form->getElement() as $key => $element ) {

//	print get_class($element);
	if (get_class($element) != "G_Form_Element_Submit") {
		$modalForm->addElement($element);
	}

}

//$modalForm->setBody($form->getElement("name")->render().$form->getElement("parent")->render().$form->getElement("description")->render().$form->getElement("action")->render());
$data["html"] = $modalForm->render();
$data["control"] = $name;
$data["action"] = $action;
$json = json_encode($data);
print_r($json);
?>
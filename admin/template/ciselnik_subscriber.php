<?php
if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();
	if ($ciselnikController->saveAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;
	}

	if ($ciselnikController->createAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	if ($ciselnikController->deleteAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	$formName = "Application_Form_" . $ciselnikController->pageModel . $action;
	$form = new $formName();
	$modalForm = new BootrapModalForm("myModal",$form);


	foreach ($form->getElement() as $key => $element ) {
		if (get_class($element) != "G_Form_Element_Submit" && get_class($element) != "G_Form_Element_Button") {
			$modalForm->addElement($element);
		}

	}

	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}
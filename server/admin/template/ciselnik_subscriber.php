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

//	print substr($action,-6);
	if ( substr($action,-6) == "Delete") {
		$modelName = str_replace("Delete", "", $action);
	//	$modalForm = new CiselnikDeleteConfirm($modelName);
		$form = new CiselnikDeleteConfirm($modelName);
		$modalForm = new BootrapModalForm("myModal",$form);
		$body = $form->getElement("action")->render();
		$modalForm->setBody($body);


	} else {

		$formName = "F_" . $ciselnikController->pageModel . $action;
		$form = new $formName();



		$modalForm = new BootrapModalForm("myModal",$form, $form->modalSize);

    $tabName = $ciselnikController->pageModel . "Tabs";
   // print $tabName;
    if (class_exists($tabName)) {
   
		      $tabs = new $tabName($form);
    
        $modalForm->setBody($tabs->makeTabs());
    } else {
    
    		foreach ($form->getElement() as $key => $element ) {
			if (get_class($element) != "G_Form_Element_Submit" && get_class($element) != "G_Form_Element_Button") {
				$modalForm->addElement($element);
			}

		}
    }
    


	}


	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}
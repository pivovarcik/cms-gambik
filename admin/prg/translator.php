<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);

$ciselnikController = new TranslatorController();

$ciselnikController->deleteAction();

if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();


	if ($ciselnikController->createAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	if ($ciselnikController->saveAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;
	}

	/*
	   if ($ciselnikController->deleteAjaxAction() === true) {
	   $data["status"] = "success";
	   $json = json_encode($data);
	   print_r($json);
	   exit;

	   }
	*/

	$formName = "Application_Form_Translator" . $action;




	$form = new $formName();
	//Nová sms zpráva
	$modalForm = new BootrapModalForm("myModal",$form);


	$res .= '<div class="form-group">';
//	$res .= '<label for="message-text" class="control-label">Mobilní číslo:</label>';
	$res .= $form->getElement("keyword")->render();
	$res .= '</div>';


	$first = true;
	$res .= '<div class="form-group">';
	foreach ($languageList as $key => $val)
	{
$res .= $form->getElement("name_$val->code")->render();

		$first = false;
	}
	$res .= '</div>';

	$res .= $form->getElement("action")->render();

//	$res .= $form->getElement("action")->render();

//	$res .= '</div>';


//	$res .= '<p class="text-warning"><small>K odeslání SMS je nutné mít dostatečný kredit</small></p>';
	$modalForm->setBody($res);


	/*	foreach ($form->getElement() as $key => $element ) {
	   if (get_class($element) != "G_Form_Element_Submit" && get_class($element) != "G_Form_Element_Button") {
	   $modalForm->addElement($element);
	   }

	   }*/

	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}


//$translatorController->createAction();


//$form = new Application_Form_TranslatorCreate();

$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();

$args = new ListArgs();
$args->lang = LANG_TRANSLATOR;
$DataGridProvider = new DataGridProvider("Translator",$args);
$DataGridProvider->setModalForm(true);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a class="btn btn-sm btn-info" class="btn-add" href="'.  URL_HOME . 'add_key"> Nový</a>';
$pageButtons[] = $DataGridProvider->addButton("Nové", '/admin/translator?do=create');
//$pageButtons[] = '<a class="btn btn-sm btn-info add-modal" href="#">Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
	<?php // print $form->Result();?>
<?php //print getResultMessage();?>
<?php print $DataGridProvider->ajaxTable();?>


<?php
include PATH_TEMP . "admin_body_footer.php";
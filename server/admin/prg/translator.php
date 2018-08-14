<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);

$ciselnikController = new TranslatorController();

//$ciselnikController->deleteAction();

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

	if ($ciselnikController->deleteAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	if ( substr($action,-6) == "Delete") {
		$modelName = str_replace("Delete", "", $action);
		//	$modalForm = new CiselnikDeleteConfirm($modelName);
		$form = new CiselnikDeleteConfirm($modelName);
		$modalForm = new BootrapModalForm("myModal",$form);
		$body = $form->getElement("action")->render();
		$modalForm->setBody($body);


	} else {
		$formName = "F_Translator" . ucfirst($action);


		$modalForm = new TranslatorBootstrapModalForm($formName);

		$modalForm->setBody();
	}
	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}

include PATH_TEMP . "ciselnik_subscriber.php";

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
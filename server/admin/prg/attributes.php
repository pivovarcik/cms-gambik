<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',URL_HOME . 'attributes');

$attrController = new AttributeController();


if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();


	if ($attrController->createAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	if ($attrController->saveAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;
	}

	if ($attrController->deleteAjaxAction() === true) {
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
		$formName = "F_Attrib" . ucfirst($action);


		$modalForm = new ProductAttributesBootstrapModalForm($formName);

		$modalForm->setBody();
	}
	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}


$attrController->deleteAction();

$DataGridProvider = new DataGridProvider("ProductAttributes");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a  class="btn btn-sm btn-info" href="/admin'.   $cat->link . '/add_attrib">Nový</a>';
$pageButtons[] = 	$DataGridProvider->addButton("Nový", '/admin/attributes?do=Create');
?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->ajaxTable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";
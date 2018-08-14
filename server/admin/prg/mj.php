<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;



define('AKT_PAGE',URL_HOME . 'mj');
$ciselnikController = new MjController();
//$ciselnikController->createAjaxAction();
//PRINT_R($_SERVER);



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
		$formName = "F_Mj" . $action;


		$modalForm = new MjBootstrapModalForm($formName);

		$modalForm->setBody();
	}
	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}



//include PATH_TEMP . "ciselnik_subscriber.php";

//$ciselnikController->createAction();
//$ciselnikController->saveAction();
//$ciselnikController->deleteAction();
//$form = new F_MjCreate();
$DataGridProvider = new DataGridProvider("Mj");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();

$pageButtons[] = $DataGridProvider->addButton("Nová","/admin/mj?do=Create");

?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print getResultMessage();?>
	<?php // print $form->Result(); ?>
<?php //print $DataGridProvider->table();?>

<?php print $DataGridProvider->ajaxTable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";
<?php


if (isset($_GET["do"])) {

	switch ($_GET["do"]) {

		case "UserEdit":
		//	$ProductVariantyController = new CarReservartionController();
			//	error_reporting(E_ALL);
			if ($userController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}

			$modalForm = new UserBootrapModalFormEdit();


			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
		default:
			exit;

	} // switch



}

$userController->saveAction();
$userController->deleteAction();
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;
define('AKT_PAGE',$cat->link);



$args = new ListArgs();
$DataGridProvider = new DataGridProvider("User",$args);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'user_add">Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php
print getResultMessage();
?>
<?php print $DataGridProvider->ajaxtable();?>
<?php
include PATH_TEMP . "admin_body_footer.php";
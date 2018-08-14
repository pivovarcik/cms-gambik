<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);
$pagetitle = "Číselník dostupností produktů";

//define('AKT_PAGE',URL_HOME . 'product_dostupnost');

$ciselnikController = new ProductDostupnostController();

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
		$formName = "F_ProductDostupnost" . $action;


		$modalForm = new ProductDostupnostBootstrapModalForm($formName);

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
//$productCategoryController->saveAction();
//$productCategoryController->deleteAction();

$DataGridProvider = new DataGridProvider("ProductDostupnost");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a  class="btn btn-sm btn-info" href="'.   $cat->link . '/product_dostupnost_create">Nový</a>';

$pageButtons[] = $DataGridProvider->addButton("Nová","?do=Create");

?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>


<?php print $DataGridProvider->ajaxTable(); ?>

<?php
include PATH_TEMP . "admin_body_footer.php";
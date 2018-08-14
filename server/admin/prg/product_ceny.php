<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);

$ProductCenaController = new ProductCenaController();
//$productVyrobceController->deleteAction();

if (isset($_GET["do"])) {

	if ($ProductCenaController->deleteAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}
	switch ($_GET["do"]) {
		case "ProductCenaEdit":
			if ($ProductCenaController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
      $formName = "F_ProductCenaEdit";
			$modalForm = new ProductCenaBootstrapModalForm($formName);

			$modalForm->setBody();


			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
      
    case "ProductCenaDelete":


			if ($ProductCenaController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}

			$formName = "F_ProductCenaDeleteConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
			$modalForm->setBody($body);

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;

      
      
      
  }

}



$args = new ProductCenaListArgs();
$DataGridProvider = new DataGridProvider("ProductCena",$args);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a href="'.   $cat->link . '/add_product_cenik"><i class="fa fa-plus-square"></i> Nový</a>';

$pageButtons[] = '<a class="btn btn-sm btn-warning" href="/admin/eshop/product_ceniky/generator_cen">Generátor cen</a>';
?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->ajaxtable();?>
<?php
include PATH_TEMP . "admin_body_footer.php";
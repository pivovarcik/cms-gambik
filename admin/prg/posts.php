<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;


define('AKT_PAGE',$cat->link);

if (isset($_GET["do"])) {

	$ProductVariantyController = new PublishController();
	if ($ProductVariantyController->deleteAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	switch ($_GET["do"]) {
		case "PublishDelete":
			$ProductVariantyController = new ProductController();

			if ($ProductVariantyController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}

			$formName = "Application_Form_PostDeleteConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
			$modalForm->setBody($body);;

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
	}
}

$publishController = new PublishController();
$publishController->deleteAction();

$params = new ListArgs();
$params->lang = LANG_TRANSLATOR;
$params->all_public_date = true;
$DataGridProvider = new DataGridProvider("Publish",$params);


$GHtml->setPagetitle($cat->pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//  data-rel="do=PublishCreate"
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_post">Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php print $DataGridProvider->ajaxtable();?>


<?php
include PATH_TEMP . "admin_body_footer.php";
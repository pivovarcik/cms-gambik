<?php

if (isset($_GET["do"])) {

  $Controller = new GdprController();
	if ($Controller->deleteAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}
	switch ($_GET["do"]) {
  
  		case "GdprCreate":
			if ($Controller->createAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
      $formName = "F_GdprCreate";
			$modalForm = new GdprBootstrapModalForm($formName);

			$modalForm->setBody();


			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
      
		case "GdprEdit":
			if ($Controller->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
      $formName = "F_GdprEdit";
			$modalForm = new GdprBootstrapModalForm($formName);

			$modalForm->setBody();


			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
      
    case "GdprDelete":


			if ($Controller->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}

			$formName = "F_GdprDeleteConfirm";

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

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;


define('AKT_PAGE',$cat->link);


$DataGridProvider = new DataGridProvider("Gdpr");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();
//$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_role">Nová</a>';
$pageButtons[] = $DataGridProvider->addButton("Nová", "gdpr?do=GdprCreate");
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->ajaxtable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";


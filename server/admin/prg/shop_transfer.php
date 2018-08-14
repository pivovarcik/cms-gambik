<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);


$shopTransferController = new ShopTransferController();


if (isset($_GET["do"])) {

	$action = $_GET["do"];



	$data = array();
/*	if ($ciselnikController->saveAjaxAction() === true) {
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

	}   */

	if ($shopTransferController->deleteAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

//	print substr($action,-6);
	if ( substr($action,-6) == "Delete") {

		$form = new ShopTransferDeleteConfirm($modelName);
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

//$shopTransferController->deleteAction();


$args = new ListArgs();
$args->lang = LANG_TRANSLATOR;
$DataGridProvider = new DataGridProvider("Doprava",$args);


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="/admin'.   $cat->link . '/add_shop_transfer">Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->ajaxtable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";
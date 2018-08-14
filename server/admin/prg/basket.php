<?php

if (isset($_GET["do"])) {

	switch ($_GET["do"]) {
		case "BasketDelete":
			$ProductVariantyController = new BasketController();

			if ($ProductVariantyController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "F_BasketDeleteConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			//	$body .= $form->getElement("action")->render();
			$body .= $form->getElement("action")->render();
			/*			$body .= '<div class="row">';
			   $body .= '<div class="col-xs-12">';
			   //	$body .= $form->getElement("delete")->render();
			   $body .= '</div>';
			   $body .= '</div>';*/
			$modalForm->setBody($body);

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;

		case "BasketEdit":
			$ProductVariantyController = new BasketController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "F_BasketEdit";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			//		$body .= $form->getElement("action")->render();
			$body .= $form->getElement("action")->render();

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("qty")->render();
			$body .= '</div>';
			$body .= '</div>';

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("sleva")->render();
			$body .= '</div>';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("typ_slevy")->render();
			$body .= '</div>';
			$body .= '</div>';
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


$pagetitle = "Katalog";

$catalogController = new CatalogFiremController();
$catalogController->saveAction();
//$catalogController->copyAction();
$catalogController->deleteAction();
$catalogController->recycleAction();

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);
$args = new ListArgs();
$DataGridProvider = new DataGridProvider("Basket", $args);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>

<div class="buttons"></div>

</div>

<?php
print getResultMessage();
?>

<?php print $DataGridProvider->ajaxTable(); ?>

</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";


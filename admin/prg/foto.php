<?php


if (isset($_GET["do"])) {

	switch ($_GET["do"]) {
		case "ImageDelete":
		$ProductVariantyController = new FotoController();

		if ($ProductVariantyController->deleteAjaxAction() === true) {
			$data["status"] = "success";
			$json = json_encode($data);
			print_r($json);
			exit;

		}


		$formName = "Application_Form_ImageDeleteConfirm";

		$form = new $formName();
		$modalForm = new BootrapModalForm("myModal",$form);

	//	$body .= $form->getElement("action")->render();
			$body .= $form->getElement("action")->render();
			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("delete")->render();
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

		case "ImageEdit":
			$ProductVariantyController = new FotoController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "Application_Form_ImageEdit";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

	//		$body .= $form->getElement("action")->render();
			$body .= $form->getElement("action")->render();


			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("file")->render();
			$body .= '</div>';
			$body .= '</div>';

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("description")->render();
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
$fotoController = new FotoController();
$fotoController->deleteAction();

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);

$DataGridProvider = new DataGridProvider("FotoGallery",null,"FotoGalleryAdminWrapper");

//$filter = new Application_Form_FilterList();

$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/js/handlers.js');

$script = swfUploadInit(null,null,array("uploadComplete" => "loadFullPhotoGallery();"));
$GHtml->setCokolivToHeader($script);


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>
<?php echo getResultMessage(); ?>
<form class="standard_form" method="post" enctype="multipart/form-data">


		<div class="fieldset flash" id="fsUploadProgress">
		<span class="legend">Fronta nahrávaných souborů</span>
		</div>
	<div id="divStatus">0 Nahraných souborů</div>
		<div>
			<span id="spanButtonPlaceHolder"></span>

			<input id="btnCancel" type="button" value="Přerušit nahrávání" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />

		</div>
</form>
</div>







<?php print $DataGridProvider->ajaxTable();?>

</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
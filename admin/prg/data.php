<?php


if (isset($_GET["do"])) {

	switch ($_GET["do"]) {
		case "FileDelete":
			$ProductVariantyController = new FilesController();

			if ($ProductVariantyController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "Application_Form_FileDeleteConfirm";

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

		case "FileEdit":
			$ProductVariantyController = new FilesController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "Application_Form_FileEdit";

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


$filesController = new FilesController();
$filesController->deleteAction();

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;


$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);


$DataGridProvider = new DataGridProvider("Files");

define('AKT_PAGE',$cat->link);
$filter = new Application_Form_FilterList();



$GHtml->setServerJs('/js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs('/js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs('/js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs('/js/SWFUpload/js/handlers.js');


$script = swfUploadInit(null,null,array("create" => "upload_file","uploadComplete" => "loadFullDataGallery();"));
$GHtml->setCokolivToHeader($script);

$script = '
<script type="text/javascript">
var swfu;

window.onload = function() {
/**/
		var settings2 = {
		flash_url : "' . URL_HOME . 'js/SWFUpload/swfupload/swfupload.swf",
		upload_url: "' . URL_HOME . 'admin/upload.php",
		post_params: {
			"PHPSESSID" : "' . session_id() . '","upload_file" : "true"
		},
		file_size_limit : "100 MB",
		file_types : "*.*",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button settings
		button_image_url: "images/TestImageNoText_65x29.png",
		button_width: "65",
		button_height: "29",
		button_placeholder_id: "spanButtonPlaceHolder",
		button_text: \'<span class="theFont">Nahrát</span>\',
		button_text_style: ".theFont { font-size: 16; }",
		button_text_left_padding: 12,
		button_text_top_padding: 3,

		// The event handler functions are defined in handlers.js
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event
	};
	swfu = new SWFUpload(settings2);


};

	     /**
	      *
	      * @access public
	      * @return void
	      **/
	     function uploadComplete(){
			loadFullDataGallery();
	     }
</script>
';



$form = new Application_Form_FileUpload();

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>





<form class="standard_form" action="<?php print URL_HOME . "admin/"; ?>" method="post" enctype="multipart/form-data">

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php
print getResultMessage();
?>



								<div class="fieldset flash" id="fsUploadProgress">
								<span class="legend">Fronta nahrávaných souborů</span>
								</div>
							<div id="divStatus">0 Nahraných souborů</div>
								<div>
									<span id="spanButtonPlaceHolder"></span>

									<input id="btnCancel" type="button" value="Přerušit nahrávání" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />

								</div>

</form>

<?php print $DataGridProvider->ajaxtable();?>




<?php
include PATH_TEMP . "admin_body_footer.php";
?>


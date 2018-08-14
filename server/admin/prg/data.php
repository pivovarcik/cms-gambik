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


			$formName = "F_FileDeleteConfirm";

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


			$formName = "F_FileEdit";

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
$filter = new F_FilterList();

     /*

$GHtml->setServerJs('/js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs('/js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs('/js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs('/js/SWFUpload/js/handlers.js');
        */

$script = swfUploadInit(null,null,array("create" => "upload_file","uploadComplete" => "loadFullDataGallery();"));




$form = new F_FileUpload();

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>






<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php
print getResultMessage();
?>



    <span class="btn btn-success fileinput-button">
        <i class="fa fa-plus"></i>
        <span>Vyberte soubory...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="Filedata" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
<?php print $DataGridProvider->ajaxtable();?>


<script>
$(function () {
    'use strict';
    
    var url = "/admin/upload.php";
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
            });
        },
        formData : {upload_file: true},
        stop : function (e) {
    console.log('Uploads finished');
    loadFullDataGallery();
},
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>

<?php
include PATH_TEMP . "admin_body_footer.php";
?>


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


		$formName = "F_ImageDeleteConfirm";

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


			$formName = "F_ImageEdit";

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

//$filter = new F_FilterList();
     /*
$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs(URL_HOME_SITE . 'js/SWFUpload/js/handlers.js');
 */
//$GHtml->setServerCss(URL_HOME_SITE . 'js/fileupload/jquery.fileupload.css');
     /*
$script = swfUploadInit(null,null,array("uploadComplete" => "loadFullPhotoGallery();"));
$GHtml->setCokolivToHeader($script);
   */

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

</div>



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



<?php print $DataGridProvider->ajaxTable();?>



    
    
</div>
</section>

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
        formData : {create_foto: true},
        stop : function (e) {
    console.log('Uploads finished');
    loadFullPhotoGallery();
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
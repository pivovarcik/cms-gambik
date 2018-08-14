<?php



function jqueryUploadInit($pageId = null,$table = null, $params = array()){



	$controller = NULL;
	$myClass = $table . "Controller";

	if (class_exists($myClass)) {
		$pageController = new $myClass();

		$controller = $pageController->getTableName();
		$modelName = $table;
		$table = NULL;

	}

	$instanceId = rand();
	//' . URL_HOME . '
  
  
  $elemName = "fileupload"; 
  
	$script = '';
  
  
  
$script .= '<span class="btn btn-success fileinput-button">';
$script .= '<i class="fa fa-plus"></i>';
$script .= ' <span>Vyberte soubory...</span>';

$script .= '<input id="' . $elemName . '" type="file" name="Filedata" multiple> ';
$script .= '</span>';
$script .= '<br>';
$script .= '<br> ';
$script .= '<div id="progress" class="progress">';
$script .= '<div class="progress-bar progress-bar-success"></div> ';
$script .= '</div>      ';

$script .= '<div id="files" class="files"></div>  ';
    
   
    
     //fileupload
    
    
    
$script .= '<script>';
$script .= '$(function () {';
$script .= '"use strict";';
$script .= '';    
$script .= '    var url = "/admin/upload.php";';
$script .= '    $("#' . $elemName . '").fileupload({ ';
$script .= '        url: url, ';
$script .= '        dataType: "json",  ';
$script .= '        done: function (e, data) {   ';
$script .= '            $.each(data.result.files, function (index, file) {     ';
$script .= '                $("<p/>").text(file.name).appendTo("#files");   ';
$script .= '            });   ';
$script .= '        },       ';
//$script .= '        formData : {create_foto: true},   ';


$script .= 'formData: {';

 	if (isset($params["create"])) {
		$script .= '"'.$params["create"].'" : true';
	} else {
		$script .= 'create_foto : true';
	}

	if ($pageId != NULL) {
		$script .= ',"id" : "'.$pageId.'"';
	}
	if ($table != NULL) {
		$script .= ',"table" : "'.$table.'"';
	}

	if ($controller != NULL) {
		$script .= ',"controller" : "'.$modelName.'"';
	}



$script .= '},';


$script .= '        stop : function (e) {';
$script .= '    console.log("Uploads finished");   ';


	if ($pageId != NULL) {
	
		if ($controller != NULL) {
			$script .= 'loadPhotoGallery(' . $pageId . ',"' . $modelName . '");';
		} else {
			$script .= 'loadPhotoGallery(' . $pageId . ',"' . $table . '");';
		}



		$script .= 'reloadLogo(' . $pageId . ');';

	}   else {
$script .= '    loadFullPhotoGallery();  ';
  }
  

$script .= '},          ';
$script .= '        progressall: function (e, data) { ';
$script .= '            var progress = parseInt(data.loaded / data.total * 100, 10);';
$script .= '            $("#progress .progress-bar").css(  ';
$script .= '                "width",        ';
$script .= '                progress + "%"  ';
$script .= '            ); ';
 $script .= '       }    ';
$script .= '    }).prop("disabled", !$.support.fileInput)   ';
$script .= '        .parent().addClass($.support.fileInput ? undefined : "disabled");     ';




	if ($pageId != NULL) {
	
		if ($controller != NULL) {
			$script .= 'loadPhotoGallery(' . $pageId . ',"' . $modelName . '");';
		} else {
			$script .= 'loadPhotoGallery(' . $pageId . ',"' . $table . '");';
		}



		$script .= 'reloadLogo(' . $pageId . ');';

	} 
  
  
$script .= '});  ';




$script .= '</script>  ';

	return $script;
}




function swfUploadInit($pageId = null,$table = null, $params = array()){



	$controller = NULL;
	$myClass = $table . "Controller";

	if (class_exists($myClass)) {
		$pageController = new $myClass();

		$controller = $pageController->getTableName();
		$modelName = $table;
		$table = NULL;

	}

	$instanceId = rand();
	//' . URL_HOME . '
	$script = '';
$script .= '<script type="text/javascript">';
$script .=' var swfu'.$instanceId.';';

$script .= 'window.onload = function() {';

$script .= 'var settings'.$instanceId.' = {';
$script .= 'flash_url : "' .URL_HOME_SITE . 'js/SWFUpload/swfupload/swfupload.swf",';
$script .= 'upload_url: "' . URL_HOME_SITE . 'admin/upload.php",';
$script .= 'post_params: {';
$script .= '"PHPSESSID" : "' . session_id() . '"';

	if ($pageId != NULL) {
		$script .= ',"id" : "'.$pageId.'"';
	}
	if ($table != NULL) {
		$script .= ',"table" : "'.$table.'"';
	}

	if ($controller != NULL) {
		$script .= ',"controller" : "'.$modelName.'"';
	}

	if (isset($params["create"])) {
		$script .= ',"'.$params["create"].'" : "true"';
	} else {
		$script .= ',"create_foto" : "true"';
	}

$script .= '},';
$script .= 'file_size_limit : "100 MB",';

if (isset($params["file_types"]) && !empty($params["file_types"])) {
	$script .= 'file_types : "'.$params["file_types"].'",';
} else {
	$script .= 'file_types : "*.*",';
}


$script .= 'file_types_description : "All Files",';

if (isset($params["file_upload_limit"]) && !empty($params["file_upload_limit"])) {
	$script .= 'file_upload_limit : "'.$params["file_upload_limit"].'",';
} else {
	$script .= 'file_upload_limit : 100,';
}

$script .= 'file_queue_limit : 0,';
$script .= 'custom_settings : {';
$script .= 'progressTarget : "fsUploadProgress",';
$script .= 'cancelButtonId : "btnCancel"';
$script .= '},';
$script .= 'debug: false,';

		// Button settings
$script .= 'button_image_url: "images/TestImageNoText_65x29.png",';
$script .= 'button_width: "65",';
$script .= 'button_height: "29",';
$script .= 'button_placeholder_id: "spanButtonPlaceHolder",';
$script .= 'button_text: \'<span class="theFont">Nahrát</span>\',';
$script .= 'button_text_style: ".theFont { font-size: 16; }",';
$script .= 'button_text_left_padding: 12,';
$script .= 'button_text_top_padding: 3,';

		// The event handler functions are defined in handlers.js';
$script .= 'file_queued_handler : fileQueued,';
$script .= 'file_queue_error_handler : fileQueueError,';
$script .= 'file_dialog_complete_handler : fileDialogComplete,';
$script .= 'upload_start_handler : uploadStart,';
$script .= 'upload_progress_handler : uploadProgress,';
$script .= 'upload_error_handler : uploadError,';
$script .= 'upload_success_handler : uploadSuccess,';
$script .= 'upload_complete_handler : uploadComplete,';
$script .= 'queue_complete_handler : queueComplete';
$script .= '};';
$script .= 'swfu'.$instanceId.' = new SWFUpload(settings'.$instanceId . ');';


$script .= '};';




	if ($pageId != NULL) {
		$script .= 'function uploadComplete(){';
		if ($controller != NULL) {
			$script .= 'loadPhotoGallery(' . $pageId . ',"' . $modelName . '");';
		} else {
			$script .= 'loadPhotoGallery(' . $pageId . ',"' . $table . '");';
		}
		$script .= '}';


		$script .= 'function uploadComplete2(){';
		$script .= 'reloadLogo(' . $pageId . ');';
		$script .= '}';
	} else {

	}

	if (isset($params["uploadComplete"])) {
		$script .= 'function uploadComplete(){';
		$script .= $params["uploadComplete"];
		$script .= '}';
	}
$script .= '</script>';

	return $script;
}
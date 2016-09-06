<?php

class AllowedExtensionHelper{
	static function get($string) {
		$whiteList = explode(",",$string);
		$whiteList2 = array();
		foreach ($whiteList as $key => $extension) {
			array_push($whiteList2, "*.".$extension);
		}
		return implode(";",$whiteList2 );
	}
}
class PageUploaderAdapter extends SWFUploadAdapter {
	function __construct($pageId, $modelName){
		parent::__construct();

		$myClass = $modelName . "Controller";

		if (class_exists($myClass)) {
			$pageController = new $myClass();
			$tableName = $pageController->getTableName();
		}

		//$this->handlers["uploadComplete"] = 'loadFilesGallery(' . $pageId . ',"' . $tableName . '");';
		$params = array();
		$params["id"] = $pageId;
		$params["controller"] = $modelName;
	//	$params["upload_file"] = "true";
		$this->setPostParams($params);


		$this->file_size_limit = "5";
		$this->file_size_limit_decription = "5 MB";

	}

	public function beforeScriptRender()
	{
		return $this->handlers["uploadComplete"];
	}
}

class PageFotoUploaderAdapter extends PageUploaderAdapter {
	function __construct($pageId, $modelName){
		parent::__construct($pageId, $modelName);

		$myClass = $modelName . "Controller";

		if (class_exists($myClass)) {
			$pageController = new $myClass();
			$tableName = $pageController->getTableName();
		}

		$this->handlers["uploadComplete"] = 'loadPhotoGallery(' . $pageId . ',"' . $modelName . '");';
		$params = array();
		$params["id"] = $pageId;
		$params["controller"] = $modelName;
		$params["create_foto"] = "true";

		$this->setPostParams($params);

	//	$this->file_types_allowed = "*.jpg;*.png;*.gif";
		$this->file_types_allowed = AllowedExtensionHelper::get(DefaultSetting::get("IMAGE_EXTENSION_WHITELIST"));
		$this->file_types_description = "obrázky";


		$settings = G_Setting::instance();
		$this->file_size_limit = $settings->get("FOTO_SIZE_LIMIT");
		$this->file_size_limit_decription = $settings->get("FOTO_SIZE_LIMIT") . " MB";
	}
	public function beforeScriptRender()
	{
		return $this->handlers["uploadComplete"];
	}
}


class PageFileUploaderAdapter extends SWFUploadAdapter {
	function __construct($pageId, $modelName){
		parent::__construct();

		$myClass = $modelName . "Controller";

		if (class_exists($myClass)) {
			$pageController = new $myClass();
			$tableName = $pageController->getTableName();
		}

		$this->handlers["uploadComplete"] = 'loadFilesGallery(' . $pageId . ',"' . $modelName . '");';
		$params = array();
		$params["id"] = $pageId;
		$params["controller"] = $modelName;
		$params["upload_file"] = "true";
		$this->setPostParams($params);


		$settings = G_Setting::instance();
		$this->file_size_limit = $settings->get("FILE_SIZE_LIMIT");
		$this->file_size_limit_decription = $settings->get("FILE_SIZE_LIMIT") . " MB";

	}

	public function beforeScriptRender()
	{
		return $this->handlers["uploadComplete"];
	}
}


class SWFUploadAdapter {

	protected $instanceId;
	protected $flash_url =  null;
	protected $upload_url = null;
	protected $file_types_allowed = "*.*";
	protected $file_types_description = "All Files";
	protected $file_size_limit = "100";
	protected $file_size_limit_decription = "100 MB";
	protected $file_upload_limit = "100";
	protected $debug = "false";

	protected $handlers = array();

	protected $postParams = array();

	function __construct(){

		$this->flash_url = URL_HOME_SITE . "js/SWFUpload/swfupload/swfupload.swf";
		$this->upload_url = URL_HOME_SITE . "admin/upload.php";

		$this->file_types_allowed = AllowedExtensionHelper::get(DefaultSetting::get("DATA_EXTENSION_WHITELIST"));
		$this->instanceId = rand();
	}

	public function setPostParams($params = array())
	{
		$this->postParams = $params;
	}

	public function getInstanceId()
	{
		return $this->instanceId;
	}

	public function getPostParams()
	{
		return $this->postParams;
	}
	private function postParamsRender()
	{
		$script = 'post_params: {';
		$script .= '"PHPSESSID" : "' . session_id() . '"';

		foreach ($this->getPostParams() as $key => $val) {
			$script .= ',"'.$key.'" : "'.$val.'"';
		}
		$script .= '},';
		return $script;
	}


	private function customSettingsRender()
	{
		$script = 'custom_settings : {';
		$script .= 'progressTarget : "fsUploadProgress'.$this->getInstanceId() . '",';
		$script .= 'divStatusId : "divStatus'.$this->getInstanceId() . '",';
		$script .= 'cancelButtonId : "btnCancel'.$this->getInstanceId() . '"';
		$script .= '},';
		return $script;
	}



	protected function swfSettings()
	{
		$script = 'var settings'.$this->getInstanceId().' = {';
		$script .= 'flash_url : "'.$this->flash_url.'",';
		$script .= 'upload_url: "'.$this->upload_url.'",';
		$script .= $this->postParamsRender();

		$script .= 'file_upload_limit : '.$this->file_upload_limit.',';
		$script .= 'file_size_limit : "'.$this->file_size_limit_decription.'",';

		$script .= 'file_types : "'.$this->file_types_allowed.'",';
		$script .= 'file_types_description : "'.$this->file_types_description.'",';

		$script .= 'file_queue_limit : 0,';
		$script .= $this->customSettingsRender();
		$script .= 'debug: '.$this->debug.',';



		// Button settings
		$script .= 'button_image_url: "images/TestImageNoText_65x29.png",';
		$script .= 'button_width: "65",';
		$script .= 'button_height: "29",';
		$script .= 'button_placeholder_id: "spanButtonPlaceHolder'.$this->getInstanceId() . '",';
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

		// The event handler functions are defined in handlers.js';
		/*	$script .= 'file_queued_handler : fileQueued'.$this->getInstanceId() . ',';
		   $script .= 'file_queue_error_handler : fileQueueError'.$this->getInstanceId() . ',';
		   $script .= 'file_dialog_complete_handler : fileDialogComplete'.$this->getInstanceId() . ',';
		   $script .= 'upload_start_handler : uploadStart'.$this->getInstanceId() . ',';
		   $script .= 'upload_progress_handler : uploadProgress'.$this->getInstanceId() . ',';
		   $script .= 'upload_error_handler : uploadError'.$this->getInstanceId() . ',';
		   $script .= 'upload_success_handler : uploadSuccess'.$this->getInstanceId() . ',';*/
		$script .= 'upload_complete_handler : uploadComplete'.$this->getInstanceId() . ',';
		$script .= 'queue_complete_handler : queueComplete';
		$script .= '};';

		return $script;
	}
	public function beforeScriptRender()
	{

	}
	public function scriptRender()
	{
		$script = '';
		$script .= '<script type="text/javascript">';
		$script .=' var swfu'.$this->getInstanceId().';';

		//window.onload =
		//$script .= 'window.onload =function() {';
$script .= $this->swfSettings();
		$script .= '$(document).ready(function(){';

		$script .= 'swfu'.$this->getInstanceId().' = new SWFUpload(settings'.$this->getInstanceId() . ');';

		$script .= $this->beforeScriptRender();
		$script .= '});';

		//$script .= '};';


/*
			$script .= 'function fileQueued'.$this->getInstanceId() . '(){';
			$script .= $this->handlers["fileQueued"];
			$script .= '}';

		$script .= 'function fileQueueError'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["fileQueueError"];
		$script .= '}';




		$script .= 'function fileDialogComplete'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["fileDialogComplete"];
		$script .= '}';


		$script .= 'function uploadStart'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["uploadStart"];
		$script .= '}';

		$script .= 'function uploadProgress'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["uploadProgress"];
		$script .= '}';
		$script .= 'function uploadError'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["uploadError"];
		$script .= '}';
		$script .= 'function uploadSuccess'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["uploadSuccess"];
		$script .= '}';


		$script .= 'function queueComplete'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["queueComplete"];
		$script .= '}';

		*/

		$script .= 'function uploadComplete'.$this->getInstanceId() . '(){';
		$script .= $this->handlers["uploadComplete"];
		$script .= '}';

		$script .= '</script>';

		return $script;
	}

	public function handlerRegister($handler, $content)
	{
		$this->handlers[$handler] = $content;
	}
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
$script .= 'flash_url : "' . URL_HOME_SITE . 'js/SWFUpload/swfupload/swfupload.swf",';
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
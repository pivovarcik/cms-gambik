<?php

class SWFUploadAdapter {

	protected $instanceId;
	protected $flash_url = "/js/SWFUpload/swfupload/swfupload.swf";
	protected $upload_url = "/admin/upload.php";
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
		$this->upload_url = URL_HOME_SITE ."admin/upload.php";


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
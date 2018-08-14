<?php

require_once("SWFUploadAdapter.php");

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

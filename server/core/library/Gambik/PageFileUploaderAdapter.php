<?php
require_once("SWFUploadAdapter.php");
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

<?php
require_once("PageUploaderAdapter.php");
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

<?php
// Obecnı potvrzovací formuláø
abstract class ConfirmForm  extends G_Form{

	public $pageModel;
	public $page;
	public $page_id;

	function __construct($modelName, $page_id = null)
	{
		parent::__construct();
		$this->loadModel($modelName);

		if (is_null($page_id)) {
			$page_id = (int) $this->Request->getQuery("id",null);
		}
		$this->loadPage($page_id);
		$this->setStyle(BootstrapForm::getStyle());

	}
	// naète datovı model
	public function loadModel($modelName)
	{
		$model = "models_" . $modelName;
		$this->pageModel = new $model;

	}

	// naète datovı model
	public function loadPage($page_id)
	{
		$this->page = $this->pageModel->getDetailById($page_id);

		$this->page_id = $page_id;
	}
}

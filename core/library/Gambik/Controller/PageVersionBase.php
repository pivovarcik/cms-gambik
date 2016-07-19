<?php
require_once("APageVersionBase.php");
class PageVersionBase extends APageVersionBase {


	function __construct($pageModel, $pageVersionModel)
	{
		parent::__construct($pageModel, $pageVersionModel);
	}

	#region Akce Page

	/**
	 * Založení nové entity typu Page přes PostData
	 * */
	public function createAction()
	{

	}
	/**
	 * Aktualizace entity typu Page přes PostData
	 * */
	public function saveAction()
	{
	}

	#endregion

	public function akcePredUlozenim()
	{
		return;
	}

	public function akcePredSmazanim()
	{
		return;
	}

	public function setResultError($chybovaHlaska = "")
	{
		$this->chybovaHlaska = $chybovaHlaska;
	}

	// Možnost připojit vlastní logiku
	protected function akcePoUlozeni()
	{
		return "Data byla uložena.";
	}

	// Možnost připojit vlastní logiku
	public function akcePoUlozeniSChybou()
	{
		//print "tudy";
		return $this->chybovaHlaska;
	}

	public function akcePredUlozenimSChybou()
	{
		return $this->chybovaHlaska;
	}



	// Provede zápis do DB
	protected function deleteData($pageSaveData, $form = false)
	{
		//	parent::saveData($pageSaveData, $pageVersionSaveData);

		if (!parent::deleteData($pageSaveData, $form)) {

			if ($form) {
				$form->setResultError(self::akcePredUlozenimSChybou());
			}

			if ($form) {
				$form->setResultError(self::akcePoUlozeniSChybou());
			}/**/
			return false;
		}
		if ($form) {
			$form->setResultSuccess(self::akcePoUlozeni());
		}
		return true;

	}



	// Provede zápis do DB
	protected function saveData($pageSaveData, $pageVersionSaveData, $form = false)
	{
	//	parent::saveData($pageSaveData, $pageVersionSaveData);

		if (!parent::saveData($pageSaveData, $pageVersionSaveData, $form)) {

			if ($form) {
				$form->setResultError(self::akcePredUlozenimSChybou());
			}

			if ($form) {
				$form->setResultError(self::akcePoUlozeniSChybou());
			}/**/
			return false;
		}
		if ($form) {
			$form->setResultSuccess(self::akcePoUlozeni());
		}
		return true;

	}
	public function formLoad($form)
	{
		$form = (string) $form;
		$formName = 'Application_Form_' . ucfirst($form);
		$class = new $formName();
		return $class;
	}

	public function orderFromQuery($querys, $default, $order = 'order', $sort = 'sort')
	{

		$result = "";
		foreach ($querys as $key => $value){
			if ($value['url'] == self::$getRequest->getQuery($order, '')) {

				$sort_default = isset($value[$sort]) ? $value[$sort] : '';
				if (self::$getRequest->getQuery($sort, $sort_default) == 'desc') {
					$sort = 'desc';
				} else {
					$sort = 'asc';
				}


				$result = $value['sql'] . " " . $sort;
			}
		}
		if (empty($result) && !empty($default)) {
			$result = $default;
		}
		return $result;
	}


	public function getNextPrevButton($id,$url)
	{
		$params = array();
		$urlParse = parse_url($url);
		if (isset($urlParse["query"])) {
			parse_str($urlParse['query'], $params);
		}
	//	$catalogModel = new models_CatalogPodniku();

		$nextPrev = self::$model->getNextPrevById($params,$id);



		$nextLink = '';

		$prevLink = '';

		if (isset($nextPrev["next"]->link_edit)) {
			$nextLink = '<a title="'.$nextPrev["next"]->title.'" href="'.$nextPrev["next"]->link_edit.'"><i class="fa fa-chevron-right"></i></a>';
		}
		if (isset($nextPrev["prev"]->link_edit)) {
			$prevLink = '<a title="'.$nextPrev["prev"]->title.'" href="'.$nextPrev["prev"]->link_edit.'"><i class="fa fa-chevron-left"></i></a>';
		}


		return '<div class="btn-group btn-nextprev">' . $prevLink . ' ' . $nextLink . '</div>';
	}



}
?>
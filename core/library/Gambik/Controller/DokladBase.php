<?php
require_once("ADokladBase.php");
class DokladBase extends ADokladBase {

	function __construct($TDokladEntita, $TRadkyEntita,$TRozpisDphEntita = null)
	{
		parent::__construct($TDokladEntita, $TRadkyEntita,$TRozpisDphEntita);
	}

	public function akcePredUlozenim()
	{

	}

	// Možnost připojit vlastní logiku
	public function akcePoUlozeni()
	{

	}

	// Možnost připojit vlastní logiku
	public function akcePoUlozeniSChybou()
	{

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

	/***
	 *  Kopie dokladu stejného typu
	 * */
	public function copyDoklad($doklad_id)
	{
		$doklad = self::$model->getDetailById($doklad_id);

		$params = new ListArgs();
		$params->doklad_id= (int) $doklad_id;
		$radky = self::$modelRadky->getList($params);

		for ($i=0;$i<count($radky);$i++) {
			$radky[$i]->id = null;
			$radky[$i]->doklad_id = null;
			$radky[$i]->radek_added = 1;
		}
		$doklad->id = null;
		$doklad->code = null;

		return self::createDoklad($doklad, $radky);

	}

	/***
	 *  Obecná metoda pro založení dokladu
	 * */
	public function createDoklad($doklad, $radky)
	{

		$doklad->ip_address = $_SERVER["REMOTE_ADDR"];

		$dokladSaveData = self::setDokladData($doklad);

	//	print_R($dokladSaveData);
		$code =  $dokladSaveData->getCode();

		if (empty($code)) {

			$nextIdModel = new models_NextId();
			$order_code = $nextIdModel->vrat_nextid(array(
						"tabulka"=> self::$model->getTableName(),
						"polozka"=> "code",
					));
			$dokladSaveData->code = $order_code;
		}

		$radkySaveData = self::setRadkyData($radky);
//print_r($radky);
//		print_r($radkySaveData);
//		exit;
		if (self::saveData($dokladSaveData, $radkySaveData)) {
			return self::getDokladSaveData();
		}
		return false;
	}

/*
	public function getNextPrevButton($id,$url)
	{
		$params = array();
		$urlParse = parse_url($url);
		if (isset($urlParse["query"])) {
			parse_str($urlParse['query'], $params);
		}
		//	$catalogModel = new models_CatalogPodniku();

		$nextPrev = self::$model->getNextPrevById($params,$_GET["id"]);

		$nextLink = '';$prevLink = '';
		if (isset($nextPrev["next"]->link_edit)) {
			$nextLink = '<a title="'.$nextPrev["next"]->title.'" href="'.$nextPrev["next"]->link_edit.'">další <i class="fa fa-chevron-right"></i></a>';
		}
		if (isset($nextPrev["prev"]->link_edit)) {
			$prevLink = '<a title="'.$nextPrev["prev"]->title.'" href="'.$nextPrev["prev"]->link_edit.'"><i class="fa fa-chevron-left"></i> předchozí</a>';
		}

		return $prevLink . ' ' . $nextLink;
	}
	*/

	public function getNextPrevButton($id,$url)
	{
		$params = array();
		$urlParse = parse_url($url);
		if (isset($urlParse["query"])) {
			parse_str($urlParse['query'], $params);
		}
		//	$catalogModel = new models_CatalogPodniku();

		$nextPrev = self::$model->getNextPrevById($params,$_GET["id"]);



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
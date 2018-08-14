<?php
abstract class ACiselnikBase {

	public static $model;
	public static $getRequest;
	private $pageSaveData = array();
	private $total = 0;

	private static $entitaCiselnik;
	public $pageModel;
	private $chybovaHlaska = "";
	protected $saveEntity;

	/**
	 * Constructor
	 */
	function __construct($pageModel){


		if (empty($pageModel)) {

			print get_parent_class($this) . " - chybí parametry v konstruktoru!";
			return false;
		}
		$name = "models_" . $pageModel;
		self::$model = new $name;

		$name = $pageModel . "Entity";
		self::$entitaCiselnik = $name;

		$this->pageModel = $pageModel;
		self::$getRequest = new G_Html();
	}

	// Nastavení version dat k uložení
	protected function setPageData($postdata, $originalData = null)
	{

		// naplní se objekt entity Doklad
		$dokladOut = new self::$entitaCiselnik($originalData);

	//	print_r($dokladOut);

	//	print_r($postdata);
		$dokladOut->naplnEntitu($postdata);
		$dokladData = $dokladOut->vratEntitu();

	//	print_r($dokladData);
	//	print $dokladOut->getId();
	//	exit;
		if (defined("USER_ID")) {
		//	$dokladOut->user_id = USER_ID;
		}
		return $dokladOut;
	}



	// Akce před uložením v transakci
	private function beforeSaveData()
	{
		//	print("beforeSaveData()" . "\n");
		return $this->akcePredUlozenim();
	}

	private function validaceMazanehoZaznamu()
	{
		$data = self::getPageSaveData();

		if (isset($data["isDeleted"]) && $data["isDeleted"] == 1) {
			// označení smazaného záznamu
			if ($data["user_id"] != USER_ID) {
				return false;
			}
		}
		return true;
	}

	abstract function akcePredUlozenim();

	// Akce po uložení v transakci, ještě než proběhne commit do DB
	// např. validace
	private function afterSaveData()
	{
	//	print("afterSaveData()" . "\n");
		//return $this->akcePoUlozeni();

		if ($this->akcePoUlozeni() === false) {
			return false;
		}
		return $this->validaceMazanehoZaznamu();
	}

	private function afterSaveDataWithError()
	{
	//	print("afterSaveDataWithError()" . "\n");
		return $this->akcePoUlozeniSChybou();
	}

	// vrací počet záznamů listu
	public function getTotalList()
	{
		return $this->total;
	}

	public function getPageSaveData()
	{
		return $this->pageSaveData;
	}

	// Možnost připojit vlastní logiku
	abstract function akcePoUlozeni();

	// Možnost připojit vlastní logiku
	abstract function akcePoUlozeniSChybou();

	abstract function setResultError();


	private function validPageSaveData($pageSaveData)
	{

		// bez toho dochází k duplicitám!
		/*
		if (!isset($pageSaveData["version"])) {

			print "pageSaveData neobsahují atribut Version!";
			return false;
		}
*/
		return true;
	}
	// Provede zápis do DB
	protected function saveData($TCiselnikEntita, $callback = null)
	{


		$saveData = $TCiselnikEntita->getChangedData();

		if (self::validPageSaveData($saveData) === false) {
			return false;
		}

		$doklad_id = (int) $TCiselnikEntita->getId();


		$all_query_ok = true;
		self::$model->start_transakce();

		$this->saveEntity = $TCiselnikEntita;
		if (self::beforeSaveData() === false) {
			//print "chyba";
			//call_user_func(array($obj, 'myCallbackMethod'));
			call_user_func($callback);
			$all_query_ok = false;
		}

		$isAdded = false;
		if (is_int($doklad_id) && $doklad_id > 0) {
			self::$model->updateRecords(self::$model->getTableName() ,$saveData, "id=".$doklad_id);
		} else {
			self::$model->insertRecords(self::$model->getTableName(), $saveData);
			$page_id = self::$model->insert_id;
			$isAdded = true;
		}

		//	print self::$model->getLastQuery();
		self::$model->commit ? null : $all_query_ok = false;


		if ($all_query_ok !== false) {
			//	print "tudy";

			if (self::afterSaveData() === false) {
			//	print "chyba";
				$all_query_ok = false;
			}
			//self::afterSaveData() ? null : $all_query_ok = false;
		}
		//$all_query_ok = false;
		if (self::$model->konec_transakce($all_query_ok)) {

			return true;
		} else {
			self::afterSaveDataWithError();
			return false;
		}

	}


	// Obecný list
	protected function getList($params = array())
	{


		$limit 	= (int) self::$getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		$params['limit'] = $limit;

		$page 	= (int) self::$getRequest->getQuery('pg', 1);
		if (isset($params['page']) && is_numeric($params['page'])) {
			$page = $params['page'];
		}
		$params['page'] = $page;

		$l = self::$model->getList($params);
		$this->total = self::$model->total;
		return $l;

	}
}
?>
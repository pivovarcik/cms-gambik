<?php
/**
 * Generická třída typu Page version
 * */
/*
error_reporting(E_ERROR);
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/

/**
 Obecná třída pro Tabs typu Page
 */


interface IPageVersion {

	public function getPageSaveData();

	public function getPageVersionSaveData();

}
abstract class APageVersionBase implements IPageVersion {

	public static $model;
	public static $modelVersion;
	public static $isVersioning = false;
	public static $getRequest;
	private $pageSaveData = array();
	private $pageVersionSaveData = array();
	private $total = 0;
	private $limit = 0;

	private $chybovaHlaska = "";

	public $pageEntity;
	public $pageVersionEntity;

	public static $TPage;
	public static $TPageVersion;

	protected $tags_assoc = array();

	/**
	 * Constructor
	 */
	function __construct($TPageModel, $TPageVersionModel){


		if (empty($TPageModel) || empty($TPageVersionModel)) {

			print get_parent_class($this) . " - chybí parametry v konstruktoru!";
			return false;
		}


		self::$TPage = $TPageModel;
		self::$TPageVersion = $TPageVersionModel;

		$name = "models_" . $TPageModel;
		self::$model = new $name;

		$name = "models_" . $TPageVersionModel;
		self::$modelVersion = new $name;

		$this->pageEntity = $TPageModel . "Entity";
		$this->pageVersionEntity = $TPageVersionModel . "Entity";

		self::$getRequest = new G_Html();
	}

	public function getModel()
	{
		return self::$model;
	}

	public function getTableName()
	{
		return self::$model->getTableName();
	}
	// Nastavení version dat k uložení
	protected function setPageData($postdata, $originalData = null)
	{

		if (is_object($postdata)) {
			$postdata = object_to_array($postdata);
		}
		//print "tudy";
		//print_r($postdata);
	//	print_r($originalData);
	//	exit;
		$data = array();

		$version = 0;
		$page_id = 0;
		if ( $originalData != null && isset($originalData->version)) {
			$version = $originalData->version;
		}

		// Pozor při mazání záznamu se nemění verze!!!
		// v případě verzování navýším verzi.
		if (self::$isVersioning) {
			$version = $version + 1;
		}
		if ( $originalData != null && isset($originalData->id)) {
			$page_id = $originalData->id;
		}


		$name = "pristup";
		if (array_key_exists($name, $postdata)) {
			$data[$name] = $postdata[$name];
		}

		$name = "foto_id";
		if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
			$data[$name] = $postdata[$name];
		}

		$data["version"] = $version;
		$data["id"] = $page_id;

		$name = 'user_id';
		if (defined("USER_ID")) {
			$data[$name] = USER_ID;
		}
		if ( $originalData != null && isset($originalData->$name)) {
			$data[$name] = $originalData->$name;
		}

		$name = 'category_id';

		// musí jít dát 0 jako nezařazené !
		// && $postdata[$name] > 0
		if (array_key_exists($name, $postdata)) {

			$data[$name] = $postdata[$name];
			if ($postdata[$name] == 0) {
				$data[$name] = NULL;
			}

		}


	//	print_r($_POST);

		$this->accessUsers = $postdata["user_assoc_id"];

	//	print_r($this->accessUsers);
	//	exit;
		return $data;
	}

	// Nastavení version dat k uložení
	protected function setPageVersionData($postdata, $page_id, $version, $languageList = array())
	{

		if (is_object($postdata)) {
			$postdata = object_to_array($postdata);
		}

		$this->tags_assoc = array();
		$versionData = array();
		// Verzování dle jazyků
		$i = 0;
		foreach ($languageList as $key => $val){

			$versionData[$i]["lang_id"] = $val->id;
			$versionData[$i]["page_id"] = $page_id;

			if (defined("USER_ID")) {
				$versionData[$i]["user_id"] = USER_ID;
			}
			$versionData[$i]["version"] = $version;


			// TODO Pozůstatek, tam kde není category_id
			// && $postdata[$name] > 0
			$name = 'category';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i]["category_id"] = $postdata[$name];
			}
			$name = 'category_id';
			// && $postdata[$name] > 0
			if (array_key_exists($name, $postdata)) {

				$versionData[$i]["category_id"] = $postdata[$name];
				$data[$name] = $postdata[$name];
				if ($postdata[$name] == 0) {
					$versionData[$i]["category_id"] = NULL;
				}


			}

			$name = "title";
			if (isset($postdata["{$name}_{$val->code}"])) {
				$versionData[$i][$name] = $postdata["{$name}_{$val->code}"];
			}

			$name = "perex";
			if (isset($postdata["{$name}_{$val->code}"])) {
				$versionData[$i][$name] = $postdata["{$name}_{$val->code}"];
			}

			$name = "description";
			if (isset($postdata["{$name}_{$val->code}"])) {
				$versionData[$i][$name] = $postdata["{$name}_{$val->code}"];
			}

			$name = "pagetitle";
			if (isset($postdata["{$name}_{$val->code}"])) {
				$versionData[$i][$name] = $postdata["{$name}_{$val->code}"];
			}

			$name = "pagedescription";
			if (isset($postdata["{$name}_{$val->code}"])) {
				$versionData[$i][$name] = $postdata["{$name}_{$val->code}"];
			}

			$name = "pagekeywords";
			if (isset($postdata["{$name}_{$val->code}"])) {
				$versionData[$i][$name] = $postdata["{$name}_{$val->code}"];
			}

			$name = "tags";
			if (isset($postdata["{$name}_{$val->code}"])) {
				$versionData[$i][$name] = $postdata["{$name}_{$val->code}"];


				$this->tags_assoc[$val->id] = explode(",",$versionData[$i][$name]);
			}

			$name = "url";
			if (array_key_exists("{$name}_{$val->code}", $postdata) && !empty($postdata["{$name}_{$val->code}"])) {

				if (!isUrl($postdata["{$name}_{$val->code}"])) {
					$url = strToUrl($postdata["{$name}_{$val->code}"]);
				} else {
					$url = ($postdata["{$name}_{$val->code}"]);
				}

			} else {
				$url = strToUrl($postdata["title_$val->code"]);
			}

			$versionData[$i][$name] = $this->checkDuplicityUrl($url, $val->code, $page_id);
			$i++;
		}
		return $versionData;
	}

	protected function checkDuplicityUrl($url, $lang, $page_id = null)
	{
		/*if ($url == "root") {
			return $url;
		}*/
		$args = new PageListArgs();

		$args->lang = $lang;
		$args->url = $url;
		$args->page = 1;
		$args->limit = 1;
		$args->not_page_id = $page_id;
		$list = self::$model->getList($args);
	//	print self::$model->getLastQuery();
	//	exit;
		if (count($list) == 1) {
			// duplicita -> doplnim -1
			$url .= "-1";
		}
		return $url;
	}

	// Akce před započetím ukládání v transakci
	private function beforeSaveData($form = false)
	{
		//	print("beforeSaveData()" . "\n");

		if ($this->akcePredUlozenim($form) === false) {
			//$this->akcePredUlozenimSChybou();
			$this->akcePredUlozenimSChybou();
			return false;
		}
		return true;
	}


	private function beforeDeleteData($form = false)
	{
		//	print("beforeSaveData()" . "\n");

		if ($this->akcePredSmazanim() === false) {
			//$this->akcePredUlozenimSChybou();
			$this->akcePredUlozenimSChybou();
			return false;
		}
		return true;
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

	abstract function akcePredSmazanim();

	abstract function akcePredUlozenim();

	abstract function akcePredUlozenimSChybou();

	abstract function setResultError();

	// Akce po uložení v transakci, ještě než proběhne commit do DB
	// např. validace
	private function afterSaveData()
	{
	//	print("afterSaveData()" . "\n");
		//return $this->akcePoUlozeni();

		$all_query_ok = true;
		$page_id = $this->pageSaveData["id"];
		self::$model->deleteRecords(T_USERS_ACCESS_ASSOC, "page_id=".$page_id." and page_type='".self::$model->getTableName(). "'");
		//	$model->getLastQuery();
		//	$model->query($query);
		self::$model->commit ? null : $all_query_ok = false;

		$categoryId = $this->getAccessUsers();
		if (isset($categoryId) && is_array($categoryId)) {


			//	print_r($_POST["category_id"]);
			foreach ($categoryId as $key => $value ){
				$data2 = array();
				$data2["page_id"] = $page_id;
				$data2["page_type"] = self::$model->getTableName();
				$data2["user_id"] = $value;

				//	print_r($data2);
				self::$model->insertRecords(T_USERS_ACCESS_ASSOC, $data2);

				self::$model->commit ? null : $all_query_ok = false;
			}
		}

		// asociace značek
		self::$model->deleteRecords(T_TAGS_ASSOC, "page_id=".$page_id." and page_type='".self::$model->getTableName(). "'");


		foreach ($this->tags_assoc as $lang_id => $tagy )
		{
		//	print $lang_id;
			for ($i=0;$i<count($tagy);$i++)
			{
				$tag = trim($tagy[$i]);
				if (!empty($tag)) {
					// zjistím jestli je tag založen v db
					$tag_id = $this->getTagId($tag, $lang_id);
					self::$model->insertRecords(T_TAGS_ASSOC,array("page_id" => $page_id, "tag_id" => $tag_id, "page_type" => self::$model->getTableName()));
				}
			//	print $tagy[$i];
			}
		}
	//	print_r($this->tags_assoc);
	//	exit;


		if ($this->akcePoUlozeni() === false) {
			return false;
		}
		return $this->validaceMazanehoZaznamu();
	}

	private function getTagId($tag, $lang_id){


		$row = self::$model->get_row("select id from " . T_TAGS . " where lang_id=".$lang_id." and name='".$tag. "'");


		if ($row->id > 0) {
			return $row->id;
		}
		self::$model->insertRecords(T_TAGS,array("lang_id" => $lang_id, "name" => $tag));
	//	print self::$model->getLastQuery();
		return self::$model->insert_id;
	}
	private function getAccessUsers()
	{
		return $this->accessUsers;
	}

	// Akce po uložení do DB s chybou
	private function afterSaveDataWithError()
	{


	//	print("afterSaveDataWithError()" . "\n");
		$result = "Omlouváme se, ale nastal problém při ukládání dat do Databáze. Tato chyba byla automaticky odeslána administrátorovi k urychlenému odstranění.";
		$this->setResultError($result);
		return $this->akcePoUlozeniSChybou();
	}

	// vrací počet záznamů listu
	public function getTotalList()
	{
		return $this->total;
	}
	// vrací počet záznamů listu
	public function getLimitQuery()
	{
		return $this->limit;
	}


	public function getPageSaveData()
	{
		return $this->pageSaveData;
	}

	public function getPageVersionSaveData()
	{
		return $this->pageVersionSaveData;
	}
	// Možnost připojit vlastní logiku
	abstract protected function akcePoUlozeni();

	// Možnost připojit vlastní logiku
	// ukládání do BD neprošlo
	abstract function akcePoUlozeniSChybou();

	/**
	 * Přiřazení fotky k page jako hlavní
	 * */
	public function setMainFoto($page_id, $foto_id)
	{
		return self::$model->setMainFoto($page_id, $foto_id);
	}

	private function validPageSaveData($pageSaveData)
	{

		// bez toho dochází k duplicitám!
		if (!isset($pageSaveData["version"])) {

			print "pageSaveData neobsahují atribut Version!";
			return false;
		}

		return true;
	}


	protected function deleteData($pageSaveData, $form = false)
	{
		$this->pageSaveData = $pageSaveData;
		//$this->pageVersionSaveData = $pageVersionSaveData;

		if (self::validaceMazanehoZaznamu() === false) {
			return false;
		}
		//print_r($this->pageVersionSaveData);
		if (isset($pageSaveData["id"])) {
			$page_id = (int) $pageSaveData["id"];
		}


		if (self::beforeDeleteData($form) === false) {
			$all_query_ok = false;
			self::$model->konec_transakce($all_query_ok);
			//	print "chyba";

			return false;

		}


		$all_query_ok = true;
		self::$model->start_transakce();

		$pageSaveData = array();
		$pageSaveData["isDeleted"] = 1;
		//self::beforeSaveData() ? null : $all_query_ok = false;



		if (is_int($page_id) && $page_id > 0) {
			self::$model->updateRecords(self::$model->getTableName() ,$pageSaveData, "id=".$page_id);
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

	// Provede zápis do DB
	protected function saveData($pageSaveData, $pageVersionSaveData, $form = false)
	{
		$this->pageSaveData = $pageSaveData;
		$this->pageVersionSaveData = $pageVersionSaveData;

		if (self::validPageSaveData($pageSaveData) === false) {
			return false;
		}
		//print_r($this->pageVersionSaveData);
		if (isset($pageSaveData["id"])) {
			$page_id = (int) $pageSaveData["id"];
		}



		$all_query_ok = true;
		self::$model->start_transakce();

		//self::beforeSaveData() ? null : $all_query_ok = false;
		if (self::beforeSaveData($form) === false) {
			$all_query_ok = false;
			self::$model->konec_transakce($all_query_ok);
			//	print "chyba";

			return false;

		}


		$isAdded = false;
		if (is_int($page_id) && $page_id > 0) {
			self::$model->updateRecords(self::$model->getTableName() ,$pageSaveData, "id=".$page_id);
		} else {
			//	unset($pageSaveData["id"]);
			self::$model->insertRecords(self::$model->getTableName(), $pageSaveData);
			$page_id = self::$model->insert_id;
			$isAdded = true;
		}

		$this->pageSaveData["id"] = $page_id;

		//	print self::$model->getLastQuery();
		self::$model->commit ? null : $all_query_ok = false;


		foreach ($this->pageVersionSaveData as $key => $savedata)
		{
		//		print "_*_ " . self::$modelVersion->getTableName();
			$this->pageVersionSaveData[$key]["page_id"] = $page_id;
			$savedata["page_id"] = $page_id;
			$lang_id = $savedata["lang_id"];
			$version = $pageSaveData["version"];

			if (self::$isVersioning || $isAdded) {
				self::$model->insertRecords(self::$modelVersion->getTableName(),$savedata);
			} else{
				self::$model->updateRecords(self::$modelVersion->getTableName(),$savedata,
					"page_id={$page_id} and lang_id={$lang_id} and version={$version}");
			}
		//	print self::$model->getLastQuery();
			self::$model->commit ? null : $all_query_ok = false;

		}

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
	protected function getList(IListArgs $args = null)
	{

		if (is_null($args)) {
			$args = new ListArgs();
		}
		/*

		$limit 	= (int) self::$getRequest->getQuery('limit', defined("DEFAULT_LIMIT") ? DEFAULT_LIMIT : 10 );
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		$params['limit'] = $limit;

		$page 	= (int) self::$getRequest->getQuery('pg', 1);
		if (isset($params['page']) && is_numeric($params['page'])) {
			$page = $params['page'];
		}
		$params['page'] = $page;
*/

	//	print_r($params);

		$l = self::$model->getList($args);
		$this->total = self::$model->total;

		$this->limit = self::$model->getLimitQuery();
		return $l;

	}
}
?>
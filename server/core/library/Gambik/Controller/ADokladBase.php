<?php
/**
 * Generická třída typu Page version
 * */
/*
error_reporting(E_ERROR);
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/
interface IDoklad {

	public function getDokladSaveData();

	public function getRadkyDokladuSaveData();

}

// Doklad

require_once("G_Controller_Action.php");
abstract class ADokladBase extends G_Controller_Action implements IDoklad {

	public static $model;
	public static $modelRadky;

	public static $modelRozpisDph;

	public static $entitaDoklad;
	public static $entitaRadky;

	public static $isVersioning = false;
	public static $getRequest;
	private $dokladSaveData = array();
	private $radkyDokladuSaveData = array();
	private $radkySaveData;
	private $total = 0;

	protected $isAdded;

	private $doklad_id;

	public static $poleDph = array();
	/**
	 * Constructor
	 */
	function __construct($TDokladEntita, $TRadkyEntita, $TRozpisDphEntita = null){


		if (empty($TDokladEntita) || empty($TRadkyEntita)) {

			trigger_error(get_parent_class($this) . " - chybí parametry v konstruktoru!", E_USER_ERROR);
			return false;
		}



		$name = "models_" . $TDokladEntita;
		self::$model = new $name;

		$name = $TDokladEntita . "Entity";
		self::$entitaDoklad = $name;

		if (!is_subclass_of(self::$entitaDoklad,"DokladEntity")) {
			trigger_error(self::$entitaDoklad . " není typu DokladEntity!", E_USER_ERROR);
		}



		$name = "models_" . $TRadkyEntita;
		self::$modelRadky = new $name;

		$name = $TRadkyEntita . "Entity";
		self::$entitaRadky = $name;

		if (!is_subclass_of(self::$entitaRadky,"RadekEntity")) {
			trigger_error(self::$entitaRadky . " není typu RadekEntity!", E_USER_ERROR);
		}


		$name = "models_" . $TRozpisDphEntita;
		self::$modelRozpisDph = new $name;


		self::$getRequest = new G_Html();


		$dph_model = new models_Dph();
		$dphList = $dph_model->getList();
		self::$poleDph = array();
		$poleValue = array();

		foreach ($dphList as $key => $value)
		{
			$value->value = ($value->value <> 0) ? $value->value/100 : $value->value;
			self::$poleDph[$value->id] = $value->value;
		}

	}

	protected function setUpdatedRadkyData($radkyDokladu = array(), $radkyDokladuOriginal = array())
	{
		$radky = array();
		//print_r($radkyDokladuOriginal);
	//	$radkyDokladu = postToArray($radkyDokladu);


		foreach ($radkyDokladuOriginal as $key => $radek) {
			//print_r($radek);
			// řádek musím ho najít v post datech !!!
			foreach ($radkyDokladu as $key => $radekUpdated) {
				if ($radekUpdated->radek_id == $radek->id) {

					$radekDokladu = new self::$entitaRadky($radek);

					$radekDokladu->naplnEntitu($radekUpdated);
					array_push($radky, $radekDokladu);
					break;
				}
			}

		}
		/*
		for($i=0;$i<count($radkyDokladu);$i++)
		{
			if (is_int($radkyDokladu[$i]->radek_id * 1) && ($radkyDokladu[$i]->radek_id * 1)> 0)
			{
				$radkyDokladu[$i]->mj_id = $radkyDokladu[$i]->mj;

				$radkyDokladu[$i]->id = $radkyDokladu[$i]->radek_id;

				if (defined("USER_ID")) {
					$radkyDokladu[$i]->user_id = USER_ID;
				}

				$radekDokladu = new self::$entitaRadky($radkyDokladu[$i]);
				//$radky[] = $radekDokladu->vratEntitu();
				array_push($radky, $radekDokladu);
			}

			//print_r($radekDokladu->vratEntitu());
		}
		*/
		//print_r($radky);
		return $radky;

	}

	protected function setDeletedRadkyData($radkyDokladu = array(), $radkyOriginal = array())
	{
		$seznamIdRadku = array();
		$seznamMazanychId = array();
		$radky = array();
		for($i=0;$i<count($radkyDokladu);$i++)
		{

			if (is_int($radkyDokladu[$i]->radek_id * 1) && ($radkyDokladu[$i]->radek_id * 1)> 0)
			{

				$seznamIdRadku[] = $radkyDokladu[$i]->radek_id;
			}
		}

		for ($i=0;$i < count($radkyOriginal);$i++)
		{
			if (!in_array($radkyOriginal[$i]->id,$seznamIdRadku)) {
				$seznamMazanychId[] = $radkyOriginal[$i]->id;
			}
		}

	//	print_r($radkyDokladu);

//print_r($seznamMazanychId);
//		exit;
		return $seznamMazanychId;
	}

	protected function setAddedRadkyData($radkyDokladu = array())
	{
		$radky = array();

//		print "tudy7";

	//	$radkyDokladu = postToArray($radkyDokladu);

	//	print_r($radkyDokladu);
//	exit;
		for($i=0;$i<count($radkyDokladu);$i++)
		{


		//	if (is_int($radkyDokladu[$i]->radek_added * 1) && ($radkyDokladu[$i]->radek_added * 1) == 1)
			if (empty($radkyDokladu[$i]->radek_id))
			{
				//$radkyDokladu[$i]->mj_id = $radkyDokladu[$i]->mj;

				//$radkyDokladu[$i]->id = $radkyDokladu[$i]->radek_id;


				// kvůli košíku, kde je uloženo číslo řádku košíku!
				unset($radkyDokladu[$i]->id);
				if (defined("USER_ID")) {
					$radkyDokladu[$i]->user_id = USER_ID;
				}

				$radekDokladu = new self::$entitaRadky();
				$radekDokladu->naplnEntitu($radkyDokladu[$i]);

				//print_r($radekDokladu);
				//$radky[] = $radekDokladu->vratEntitu();
				array_push($radky, $radekDokladu);
			}

			//print_r($radekDokladu->vratEntitu());
		}
		//print_r($radky);

		return $radky;

	}

	protected Function setRadkyData($radkyDokladu = array(), $radkyOriginal = array())
	{


		$radky = new stdClass();
		$radky->radkyAdded = $this->setAddedRadkyData($radkyDokladu);

		$radky->radkyUpdated = $this->setUpdatedRadkyData($radkyDokladu, $radkyOriginal);
		$radky->radkyDeleted = $this->setDeletedRadkyData($radkyDokladu, $radkyOriginal);

		$this->radkySaveData = $radky;
		return $radky;
	}

	protected Function getRadkyData()
	{
		return $this->radkySaveData;
	}

	// Vytvoří objekt typu Doklad
	// TODO - do budoucna by bylo dobré přes new IDoklad()
	// né typu array ale Object, pracovat s polem až při ukládání do DB!

	/**
	 * @param object/array $doklad
	 * @param array $dokladOriginal
	 * @return object TDoklad
	 */
	protected function setDokladData($doklad, $dokladOriginal = array())
	{

		// naplní se objekt entity Doklad
		$dokladOut = new self::$entitaDoklad($dokladOriginal,false);

	//	print_r($doklad);
	//	exit;
		$dokladOut->naplnEntitu($doklad);
		$dokladData = $dokladOut->vratEntitu();
	//	print_r($dokladData);
	//	exit;
		if (defined("USER_ID")) {
			$dokladOut->user_id = USER_ID;
		}
    
    
    if (is_null($dokladOut->download_hash)) {
			$dokladOut->download_hash = strtolower(substr(md5(rand()),0,50)); // Vytvořím unikátní ID
		}
    if (is_null($dokladOut->ip_address)) {
			$dokladOut->ip_address = $_SERVER["REMOTE_ADDR"];
		}    
   
  // 		print_r($dokladOut);
	//	exit; 
		$this->doklad_id = $dokladOut->getId();
	//	print_r($dokladOut->vratEntitu()) ;
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
		$data = self::getDokladSaveData();

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
		print("afterSaveDataWithError()" . "\n");
		return $this->akcePoUlozeniSChybou();
	}

	// vrací počet záznamů listu
	public function getTotalList()
	{
		return $this->total;
	}

	public function getDokladSaveData()
	{
		return $this->dokladSaveData;
	}

	public function getRadkyDokladuSaveData()
	{
		return $this->radkyDokladuSaveData;
	}
	// Možnost připojit vlastní logiku
	abstract function akcePoUlozeni();

	// Možnost připojit vlastní logiku
	abstract function akcePoUlozeniSChybou();



	private function validDokladSaveData($pageSaveData)
	{

		// bez toho dochází k duplicitám!
		if (!isset($pageSaveData["version"])) {

		//	print "pageSaveData neobsahují atribut Version!";
		//	return false;
		}

		return true;
	}

	// zajistí výpočet celkových částek
	protected function prepocetCastekDokladu($ODoklad, $ORadkyDokladu)
	{

		$dph_model = new models_Dph();
		$dphList = $dph_model->getList();
		$poleDph = array();
		$poleValue = array();






		//	$kurzList = $kurz_model->getList();

		$ODoklad->kurz = 1;
		$ODoklad->kurz_mnoz = 1;

		if ( !is_null($ODoklad->kurz_id)) {
			$kurz_model = new models_Kurz();
			$kurzDetail = $kurz_model->getDetailById((int)$ODoklad->kurz_id);
			if (isset($kurzDetail)) {
				$ODoklad->kurz = $kurzDetail->kurz;
				$ODoklad->kurz_mnoz = $kurzDetail->mnozstvi;
				$ODoklad->mena = $kurzDetail->kod;
				$ODoklad->kurz_datum = $kurzDetail->datum;
			}
		}
		$rozpisDphDokladu = array();

		foreach ($dphList as $key => $value)
		{
			$value->value = ($value->value <> 0) ? $value->value/100 : $value->value;
			$poleDph[$value->id] = $value->value;
		}


		$sum_castka= 0;
		$celkova_castka_dph = 0;
		$sum_castka_Kc = 0;

		$addedRadkySaveData = $ORadkyDokladu->radkyAdded;

		foreach ($addedRadkySaveData as $key => $entita)
		{

			$vyse_slevy = 0;
			if ($entita->sleva <> 0 && $entita->price <> 0) {
				if ($entita->typ_slevy == "%") {
					$vyse_slevy = $entita->price * $entita->sleva / 100;
				} else {
					$vyse_slevy = $entita->price + $entita->sleva;
				}
			}


			// částka v měně dokladu
			$celk_castka_radek = $entita->qty * ($entita->price+$vyse_slevy);
			$celk_castka_radekKc = $celk_castka_radek;
			// korunova castka
			if ($celk_castka_radek * $ODoklad->kurz <> 0) {
				$celk_castka_radekKc = $celk_castka_radek * $ODoklad->kurz / $ODoklad->kurz_mnoz;
			}

			$sum_castka_Kc += $celk_castka_radekKc;

			$sum_castka += $celk_castka_radek;

			// DPH !
			$sazbaDphRadek = 0;
			$radek_castka_Dph = 0;
			$dphKey = $entita->tax_id;


			if (!isset($rozpisDphDokladu[$dphKey])) {
				$rozpisDphDokladu[$dphKey] = new stdClass();
				$rozpisDphDokladu[$dphKey]->tax_id = $dphKey;
				$rozpisDphDokladu[$dphKey]->doklad_id;
				$rozpisDphDokladu[$dphKey]->zaklad_dph = 0;
				$rozpisDphDokladu[$dphKey]->vyse_dph = 0;
			}

			$rozpisDphDokladu[$dphKey]->zaklad_dph += $celk_castka_radekKc;

			if (isset(self::$poleDph[$dphKey])) {
				$sazbaDphRadek = $poleDph[$dphKey];
			}
			$radek_castka_Dph = $sazbaDphRadek * $celk_castka_radekKc;
			$celkova_castka_dph += $radek_castka_Dph;

			$rozpisDphDokladu[$dphKey]->vyse_dph += $radek_castka_Dph;

		}


		$updatedRadkySaveData = $ORadkyDokladu->radkyUpdated;
		//	print_r($ORadkyDokladu);
		//	exit;

		//	print_r($updatedRadkySaveData);
		//	exit;
		foreach ($updatedRadkySaveData as $key => $entita)
		{

			//print $entita->kurz_id;
			$vyse_slevy = 0;
			if ($entita->sleva <> 0 && $entita->price <> 0) {
				if ($entita->typ_slevy == "%") {
					$vyse_slevy = $entita->price * $entita->sleva / 100;
				} else {
					$vyse_slevy = $entita->price + $entita->sleva;
				}
			}

			// částka v měně dokladu
			$celk_castka_radek = $entita->qty * ($entita->price+$vyse_slevy);
			$celk_castka_radekKc = $celk_castka_radek;


			// korunova castka
			if ($celk_castka_radek * $ODoklad->kurz <> 0) {
				$celk_castka_radekKc = $celk_castka_radek * $ODoklad->kurz / $ODoklad->kurz_mnoz;
			}

			$sum_castka_Kc += $celk_castka_radekKc;

			$sum_castka += $celk_castka_radek;






			// DPH !
			$sazbaDphRadek = 0;
			$radek_castka_Dph = 0;
			$dphKey = $entita->tax_id;
			if (isset(self::$poleDph[$dphKey])) {
				$sazbaDphRadek = $poleDph[$dphKey];
			}
			$radek_castka_Dph = $sazbaDphRadek * $celk_castka_radekKc;
			$celkova_castka_dph += $radek_castka_Dph;



			if (!isset($rozpisDphDokladu[$dphKey])) {
				$rozpisDphDokladu[$dphKey] = new stdClass();
				$rozpisDphDokladu[$dphKey]->tax_id = $dphKey;
				$rozpisDphDokladu[$dphKey]->doklad_id;
				$rozpisDphDokladu[$dphKey]->zaklad_dph = 0;
				$rozpisDphDokladu[$dphKey]->vyse_dph = 0;
			}

			$rozpisDphDokladu[$dphKey]->zaklad_dph += $celk_castka_radekKc;

			$rozpisDphDokladu[$dphKey]->vyse_dph += $radek_castka_Dph;
		}
	//	print $sum_castka_Kc . "<>";
		//exit;



		$ODoklad->cost_subtotal 		= $sum_castka_Kc;
		$ODoklad->cost_tax 				= $celkova_castka_dph;
		$ODoklad->cost_total 			= $ODoklad->cost_subtotal + $ODoklad->cost_tax ;


		$ODoklad->cost_subtotal_mena 	= $sum_castka;

		if ($celkova_castka_dph <> 0 && $ODoklad->kurz <> 0) {
			$celkova_castka_dph = $celkova_castka_dph / $ODoklad->kurz * $ODoklad->kurz_mnoz;
		}
		$ODoklad->cost_tax_mena 		= $celkova_castka_dph;
		$ODoklad->cost_total_mena 		= $ODoklad->cost_subtotal_mena + $ODoklad->cost_tax_mena;


	//	print $ODoklad->cost_subtotal;
	//	print($sum_castka_Kc);
	//	exit;
		//	print $sum_castka;
		//print_r($ODoklad);
		//exit;

		return $rozpisDphDokladu;

	}

	// zajistí výpočet celkových částek
	protected function prepocetCastekDokladuOld($ODoklad, $ORadkyDokladu)
	{

		$dph_model = new models_Dph();
		$dphList = $dph_model->getList();
		$poleDph = array();
		$poleValue = array();


		$kurz_model = new models_Kurz();
	//	$kurzList = $kurz_model->getList();


		$rozpisDphDokladu = array();

		foreach ($dphList as $key => $value)
		{
			$value->value = ($value->value <> 0) ? $value->value/100 : $value->value;
			$poleDph[$value->id] = $value->value;
		}


		$sum_castka= 0;
		$celkova_castka_dph = 0;

		$addedRadkySaveData = $ORadkyDokladu->radkyAdded;


		foreach ($addedRadkySaveData as $key => $entita)
		{

			$vyse_slevy = 0;
			if ($entita->sleva <> 0 && $entita->price <> 0) {
				if ($entita->typ_slevy == "%") {
					$vyse_slevy = $entita->price * $entita->sleva / 100;
				} else {
					$vyse_slevy = $entita->price + $entita->sleva;
				}
			}



			$celk_castka_radek = $entita->qty * ($entita->price+$vyse_slevy);

			if ( !is_null($entita->kurz_id)) {
				//	print "tudy".$entita->kurz_id;
				$kurzDetail = $kurz_model->getDetailById((int)$entita->kurz_id);

				if (isset($kurzDetail)) {
					$kurzDetail->kurz;
					$kurzDetail->mnozstvi;
				}
				if ($celk_castka_radek * $kurzDetail->kurz <> 0) {
					$celk_castka_radek = $celk_castka_radek * $kurzDetail->kurz / $kurzDetail->mnozstvi;
				}
			}

			$sum_castka += $celk_castka_radek;

			// DPH !
			$sazbaDphRadek = 0;
			$radek_castka_Dph = 0;
			$dphKey = $entita->tax_id;


			if (!isset($rozpisDphDokladu[$dphKey])) {
				$rozpisDphDokladu[$dphKey] = new stdClass();
				$rozpisDphDokladu[$dphKey]->tax_id = $dphKey;
				$rozpisDphDokladu[$dphKey]->doklad_id;
				$rozpisDphDokladu[$dphKey]->zaklad_dph = 0;
				$rozpisDphDokladu[$dphKey]->vyse_dph = 0;
			}

			$rozpisDphDokladu[$dphKey]->zaklad_dph += $celk_castka_radek;

			if (isset(self::$poleDph[$dphKey])) {
				$sazbaDphRadek = $poleDph[$dphKey];
			}
			$radek_castka_Dph = $sazbaDphRadek * $celk_castka_radek;
			$celkova_castka_dph += $radek_castka_Dph;

			$rozpisDphDokladu[$dphKey]->vyse_dph += $radek_castka_Dph;

		}


		$updatedRadkySaveData = $ORadkyDokladu->radkyUpdated;
	//	print_r($ORadkyDokladu);
	//	exit;

	//	print_r($updatedRadkySaveData);
	//	exit;
		foreach ($updatedRadkySaveData as $key => $entita)
		{

			//print $entita->kurz_id;
			$vyse_slevy = 0;
			if ($entita->sleva <> 0 && $entita->price <> 0) {
				if ($entita->typ_slevy == "%") {
					$vyse_slevy = $entita->price * $entita->sleva / 100;
				} else {
					$vyse_slevy = $entita->price + $entita->sleva;
				}
			}

			$celk_castka_radek = $entita->qty * ($entita->price+$vyse_slevy);

			if ( !is_null($entita->kurz_id)) {
			//	print "tudy".$entita->kurz_id;
				$kurzDetail = $kurz_model->getDetailById((int)$entita->kurz_id);

				if (isset($kurzDetail)) {
					$kurzDetail->kurz;
					$kurzDetail->mnozstvi;
				}
				if ($celk_castka_radek * $kurzDetail->kurz <> 0) {
					$celk_castka_radek = $celk_castka_radek * $kurzDetail->kurz / $kurzDetail->mnozstvi;
				}
			}


			$sum_castka += $celk_castka_radek;





			// DPH !
			$sazbaDphRadek = 0;
			$radek_castka_Dph = 0;
			$dphKey = $entita->tax_id;
			if (isset(self::$poleDph[$dphKey])) {
				$sazbaDphRadek = $poleDph[$dphKey];
			}
			$radek_castka_Dph = $sazbaDphRadek * $celk_castka_radek;
			$celkova_castka_dph += $radek_castka_Dph;



			if (!isset($rozpisDphDokladu[$dphKey])) {
				$rozpisDphDokladu[$dphKey] = new stdClass();
				$rozpisDphDokladu[$dphKey]->tax_id = $dphKey;
				$rozpisDphDokladu[$dphKey]->doklad_id;
				$rozpisDphDokladu[$dphKey]->zaklad_dph = 0;
				$rozpisDphDokladu[$dphKey]->vyse_dph = 0;
			}

			$rozpisDphDokladu[$dphKey]->zaklad_dph += $celk_castka_radek;

			$rozpisDphDokladu[$dphKey]->vyse_dph += $radek_castka_Dph;
		}
//exit;


		$ODoklad->cost_total 	= $sum_castka+$celkova_castka_dph;
		$ODoklad->cost_subtotal 	= $sum_castka;
		$ODoklad->cost_tax 		= $celkova_castka_dph;


		//	print $sum_castka;
		//print_r($ODoklad);
		//exit;

		return $rozpisDphDokladu;

	}

	// Provede zápis do DB
	protected function saveData($TDokladEntita, $TRadkyDokladu = array())
	{

		$addedRadkySaveData = $TRadkyDokladu->radkyAdded;
		$updatedRadkySaveData = $TRadkyDokladu->radkyUpdated;
		$deletedRadkySaveData = $TRadkyDokladu->radkyDeleted;

//$TDokladEntita =
		$rozpisDphDokladu = self::prepocetCastekDokladu($TDokladEntita, $TRadkyDokladu);

		$saveData = $TDokladEntita->getChangedData();
	//	print_r($rozpisDphDokladu);
	//	print_r($saveData);
	//	exit;

		$this->dokladSaveData = $saveData;
		$this->addedRadkySaveData = $addedRadkySaveData;
		$this->updatedRadkySaveData = $updatedRadkySaveData;
		$this->deletedRadkySaveData = $deletedRadkySaveData;

	//	print_r($updatedRadkySaveData);

	//	print_r($dokladSaveData);
	//	exit;
		if (self::validDokladSaveData($saveData) === false) {
			return false;
		}

		$doklad_id = (int) $TDokladEntita->getId();

		$all_query_ok = true;
		self::$model->start_transakce();

		//self::beforeSaveData() ? null : $all_query_ok = false;

		if (self::beforeSaveData() === false) {
			//print "chyba";
			$all_query_ok = false;
		}





		$this->isAdded = false;
		if (is_int($doklad_id) && $doklad_id > 0) {
			self::$model->updateRecords(self::$model->getTableName() ,$saveData, "id=".$doklad_id);
		} else {
			//	unset($pageSaveData["id"]);
			self::$model->insertRecords(self::$model->getTableName(), $saveData);
			$doklad_id = self::$model->insert_id;
			$this->isAdded = true;
		}

		$this->dokladSaveData["id"] = $doklad_id;

		//	print self::$model->getLastQuery();
		self::$model->commit ? null : $all_query_ok = false;


		$radkySaveData = array();

		$orderRadku = 1; // číslování řádku
		foreach ($updatedRadkySaveData as $key => $saveEntita)
		{
			$savedata = $saveEntita->getChangedData();
			$savedata["order"] = $orderRadku;

			array_push($radkySaveData, $saveEntita->vratEntitu());


			$radek_id = $saveEntita->getId();

			self::$model->updateRecords(self::$modelRadky->getTableName(),$savedata,
					"id={$radek_id} and doklad_id={$doklad_id}");

			//print self::$model->getLastQuery();
			self::$model->commit ? null : $all_query_ok = false;
      
      
      
      
      
    //  $radekDetail = self::$model->get_row("select top1 * from " . self::$modelRadky->getTableName() . " where id=".$radek_id); 
      
      if ($saveEntita->product_id > 0)
      {
        
        $qty = $saveEntita->qtyOriginal - $saveEntita->qty;
        
        // pouze je-li zmena mnozstvi
        if ($qty <> 0)
        {
        
          $savedataPohyb = array();
    			$savedataPohyb["doklad_id"] = $doklad_id;
    			$savedataPohyb["radek_id"] = $radek_id;
    			$savedataPohyb["product_id"] = $saveEntita->product_id;
    			$savedataPohyb["varianty_id"] = $saveEntita->varianty_id;
    			$savedataPohyb["sleva"] = $saveEntita->sleva;
    			$savedataPohyb["typ_slevy"] = $saveEntita->typ_slevy;
    			$savedataPohyb["price"] = $saveEntita->price;
    			$savedataPohyb["price_sdani"] = $saveEntita->price_sdani;
    			$savedataPohyb["celkem"] = $saveEntita->celkem;
    			$savedataPohyb["celkem_sdani"] = $saveEntita->celkem_sdani;
    			$savedataPohyb["tax_id"] = $saveEntita->tax_id;
    			$savedataPohyb["description"] = "update";
    			$savedataPohyb["mnozstvi"] = $qty;
    			$savedataPohyb["datum"] = date("Y-m-d H:i:s");
          
          if (defined("USER_ID")){
              $savedataPohyb["user_id"] = USER_ID;
          }
    			
          self::$model->insertRecords(T_PRODUCT_POHYB,$savedataPohyb);
    		  //	print self::$model->getLastQuery();
    			self::$model->commit ? null : $all_query_ok = false;
          if ($saveEntita->varianty_id > 0)
          {
              //stav_qty
              self::$model->updateRecords(T_SHOP_PRODUCT_VARIANTY,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $saveEntita->varianty_id);
              self::$model->commit ? null : $all_query_ok = false;    
  
          } else {
          
             // self::$model->updateRecords(T_SHOP_PRODUCT,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $saveEntita->product_id);
          }
          // [14.6.2018] menim stav na hlavni karte vzdy i u variant
          self::$model->updateRecords(T_SHOP_PRODUCT,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $saveEntita->product_id);
    		  //	print self::$model->getLastQuery();
    			self::$model->commit ? null : $all_query_ok = false;  
        }    
      
      }

			$orderRadku++;

		}

		foreach ($addedRadkySaveData as $key => $saveEntita)
		{
		//	print_r($saveEntita);
			$savedata = $saveEntita->getChangedData();

			//$this->updatedRadkySaveData[$key]->doklad_id = $doklad_id;
			$savedata["doklad_id"] = $doklad_id;
			$savedata["order"] = $orderRadku;
			array_push($radkySaveData, $saveEntita->vratEntitu());

			self::$model->insertRecords(self::$modelRadky->getTableName(),$savedata);
      $radek_id = self::$model->insert_id;
		//	print self::$model->getLastQuery();
			self::$model->commit ? null : $all_query_ok = false;
      
      
     // $product_id = $savedata["product_id"];
     //mnozstvi,product_id,varianty_id,user_id,sleva,typ_slevy,price,price_sdani,celkem, celkem_sdani,datum,tax_id,TimeStamp,ChangeTimeStamp,doklad_id,radek_id 
     
     // qty*-1,product_id,varianty_id,user_id,sleva,typ_slevy,price,price_sdani,celkem, celkem_sdani,TimeStamp,tax_id,now(),now(),doklad_id,id
      if ($savedata["product_id"] > 0)
      {
       
        $qty = $savedata["qty"]*-1;
        $savedataPohyb = array();
  			$savedataPohyb["doklad_id"] = $doklad_id;
  			$savedataPohyb["radek_id"] = $radek_id;
  			$savedataPohyb["product_id"] = $savedata["product_id"];
  			$savedataPohyb["varianty_id"] = $savedata["varianty_id"];
  			$savedataPohyb["sleva"] = $savedata["sleva"];
  			$savedataPohyb["typ_slevy"] = $savedata["typ_slevy"];
  			$savedataPohyb["price"] = $savedata["price"];
  			$savedataPohyb["price_sdani"] = $savedata["price_sdani"];
  			$savedataPohyb["celkem"] = $savedata["celkem"];
  			$savedataPohyb["celkem_sdani"] = $savedata["celkem_sdani"];
  			$savedataPohyb["tax_id"] = $savedata["tax_id"];
  			$savedataPohyb["description"] = "new";
  			$savedataPohyb["mnozstvi"] = $qty;
  			$savedataPohyb["datum"] = date("Y-m-d H:i:s");
        
        if (defined("USER_ID")){
            $savedataPohyb["user_id"] = USER_ID;
        }
  			
        self::$model->insertRecords(T_PRODUCT_POHYB,$savedataPohyb);
  
  		//	print self::$model->getLastQuery();
  			self::$model->commit ? null : $all_query_ok = false;  
        
        
        if ($savedata["varianty_id"] > 0)
        {
            //stav_qty
            self::$model->updateRecords(T_SHOP_PRODUCT_VARIANTY,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $savedata["varianty_id"]);
            self::$model->commit ? null : $all_query_ok = false;    
        } else {
        
         //   self::$model->updateRecords(T_SHOP_PRODUCT,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $savedata["product_id"]);
        }
        // [14.6.2018] menim stav na hlavni karte vzdy i u variant
        self::$model->updateRecords(T_SHOP_PRODUCT,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $savedata["product_id"]);
        
  		  //	print self::$model->getLastQuery();
  			self::$model->commit ? null : $all_query_ok = false;  
           
      
      }

      
			$orderRadku++;

		}

		$this->radkyDokladuSaveData = $radkySaveData;

		foreach ($deletedRadkySaveData as $key => $radek_id)
		{

      
			$savedata = array();
			$savedata["isDeleted"] = 1;

			self::$model->updateRecords(self::$modelRadky->getTableName(),$savedata,
				"id={$radek_id} and doklad_id={$doklad_id}");

		//	print self::$model->getLastQuery();
			self::$model->commit ? null : $all_query_ok = false;
      
      
      $radekDetail = self::$model->get_row("select top1 * from " . self::$modelRadky->getTableName() . " where id=".$radek_id); 
      
      if ($radekDetail->product_id > 0)
      {
        
        $qty = $radekDetail->qty;
        $savedataPohyb = array();
  			$savedataPohyb["doklad_id"] = $doklad_id;
  			$savedataPohyb["radek_id"] = $radek_id;
  			$savedataPohyb["product_id"] = $radekDetail->product_id;
  			$savedataPohyb["varianty_id"] = $radekDetail->varianty_id;
  			$savedataPohyb["sleva"] = $$radekDetail->sleva;
  			$savedataPohyb["typ_slevy"] = $radekDetail->typ_slevy;
  			$savedataPohyb["price"] = $radekDetail->price;
  			$savedataPohyb["price_sdani"] = $radekDetail->price_sdani;
  			$savedataPohyb["celkem"] = $radekDetail->celkem;
  			$savedataPohyb["celkem_sdani"] = $radekDetail->celkem_sdani;
  			$savedataPohyb["tax_id"] = $radekDetail->tax_id;
  			$savedataPohyb["description"] = "delete";
  			$savedataPohyb["mnozstvi"] = $qty;
  			$savedataPohyb["datum"] = date("Y-m-d H:i:s");
        
        if (defined("USER_ID")){
            $savedataPohyb["user_id"] = USER_ID;
        }
  			
        self::$model->insertRecords(T_PRODUCT_POHYB,$savedataPohyb);
  
  		//	print self::$model->getLastQuery();
  			self::$model->commit ? null : $all_query_ok = false;   
        
        if ($radekDetail->varianty_id > 0)
        {
            //stav_qty
            self::$model->updateRecords(T_SHOP_PRODUCT_VARIANTY,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $radekDetail->varianty_id);
            self::$model->commit ? null : $all_query_ok = false;    
        } else {
        
           // self::$model->updateRecords(T_SHOP_PRODUCT,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $radekDetail->product_id);
        }
        
        // [14.6.2018] menim stav na hlavni karte vzdy i u variant
        self::$model->updateRecords(T_SHOP_PRODUCT,array("stav_qty" =>"{IFNULL(stav_qty,0)+" . $qty . "}"),"id=" . $radekDetail->product_id);
        
 
  		  //	print self::$model->getLastQuery();
  			self::$model->commit ? null : $all_query_ok = false;    
      
      }
      

		}

		self::$model->deleteRecords(self::$modelRozpisDph->getTableName(),"doklad_id=".$doklad_id);
		self::$model->commit ? null : $all_query_ok = false;
		foreach ($rozpisDphDokladu as $key => $dph)
		{

			$savedata = array();

			//$this->updatedRadkySaveData[$key]->doklad_id = $doklad_id;
			$savedata["doklad_id"] = $doklad_id;
			$savedata["tax_id"] = $dph->tax_id;
			$savedata["zaklad_dph"] = $dph->zaklad_dph;
			$savedata["vyse_dph"] = $dph->vyse_dph;

			self::$model->insertRecords(self::$modelRozpisDph->getTableName(),$savedata);
			self::$model->commit ? null : $all_query_ok = false;
		}


		if ($all_query_ok !== false) {


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


	//	print_r($params);

		$l = self::$model->getList($params);
		$this->total = self::$model->total;
		return $l;

	}
}
?>
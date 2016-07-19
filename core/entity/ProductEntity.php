<?php
/*************
* Třída ProductEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("PageEntity.php");
class ProductEntity extends PageEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_products";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_products";
		$this->metadata["cislo"] = array("type" => "varchar(30)","default" => "NULL","index" => "1");
		$this->metadata["cis_skladu"] = array("type" => "varchar(5)","default" => "NULL");
		$this->metadata["typ_sort"] = array("type" => "varchar(1)","default" => "NULL");
		$this->metadata["hl_mj_id"] = array("type" => "int","default" => "NULL","reference" => "Mj");
		$this->metadata["mj_id"] = array("type" => "int","default" => "NULL","reference" => "Mj");
		$this->metadata["dph_id"] = array("type" => "int","default" => "NULL","reference" => "Dph");
		$this->metadata["skupina_id"] = array("type" => "int","default" => "NULL","reference" => "ProductCategory");
		$this->metadata["vyrobce_id"] = array("type" => "int","default" => "NULL","reference" => "ProductVyrobce");
		$this->metadata["aktivni"] = array("type" => "int","default" => "0","index" => "1");
		$this->metadata["min_prodcena"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["min_prodcena_sdph"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["max_prodcena"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["max_prodcena_sdph"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["nakupni_cena"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["bazar"] = array("type" => "int","default" => "0","index" => "1");
		$this->metadata["isVarianty"] = array("type" => "int","default" => "0","index" => "1");
		$this->metadata["qty"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["code01"] = array("type" => "varchar(150)","default" => "NULL","index" => "1");
		$this->metadata["code02"] = array("type" => "varchar(150)","default" => "NULL","index" => "1");
		$this->metadata["code03"] = array("type" => "varchar(150)","default" => "NULL","index" => "1");
		$this->metadata["neexportovat"] = array("type" => "int","default" => "0");
		$this->metadata["dostupnost_id"] = array("type" => "int","default" => "NULL","reference" => "ProductDostupnost");
		$this->metadata["zaruka_id"] = array("type" => "int","default" => "NULL","reference" => "ProductZaruka");
	}
	#endregion

	#region Property
	// varchar(30)
	protected $cislo = NULL;
	protected $cisloOriginal = NULL;

	// varchar(5)
	protected $cis_skladu = NULL;
	protected $cis_skladuOriginal = NULL;

	// varchar(1)
	protected $typ_sort = NULL;
	protected $typ_sortOriginal = NULL;

	// int
	protected $hl_mj_id = NULL;
	protected $hl_mj_idOriginal = NULL;

	protected $hl_mjMjEntity;

	// int
	protected $mj_id = NULL;
	protected $mj_idOriginal = NULL;

	protected $mjMjEntity;

	// int
	protected $dph_id = NULL;
	protected $dph_idOriginal = NULL;

	protected $dphDphEntity;

	// int
	protected $skupina_id = NULL;
	protected $skupina_idOriginal = NULL;

	protected $skupinaProductCategoryEntity;

	// int
	protected $vyrobce_id = NULL;
	protected $vyrobce_idOriginal = NULL;

	protected $vyrobceProductVyrobceEntity;

	// int
	protected $aktivni = 0;
	protected $aktivniOriginal = 0;

	// decimal(10,2)
	protected $min_prodcena = 0;
	protected $min_prodcenaOriginal = 0;

	// decimal(10,2)
	protected $min_prodcena_sdph = 0;
	protected $min_prodcena_sdphOriginal = 0;

	// decimal(10,2)
	protected $max_prodcena = 0;
	protected $max_prodcenaOriginal = 0;

	// decimal(10,2)
	protected $max_prodcena_sdph = 0;
	protected $max_prodcena_sdphOriginal = 0;

	// decimal(10,2)
	protected $nakupni_cena = 0;
	protected $nakupni_cenaOriginal = 0;

	// int
	protected $bazar = 0;
	protected $bazarOriginal = 0;

	// int
	protected $isVarianty = 0;
	protected $isVariantyOriginal = 0;

	// decimal(10,2)
	protected $qty = NULL;
	protected $qtyOriginal = NULL;

	// varchar(150)
	protected $code01 = NULL;
	protected $code01Original = NULL;

	// varchar(150)
	protected $code02 = NULL;
	protected $code02Original = NULL;

	// varchar(150)
	protected $code03 = NULL;
	protected $code03Original = NULL;

	// int
	protected $neexportovat = 0;
	protected $neexportovatOriginal = 0;

	// int
	protected $dostupnost_id = NULL;
	protected $dostupnost_idOriginal = NULL;

	protected $dostupnostProductDostupnostEntity;

	// int
	protected $zaruka_id = NULL;
	protected $zaruka_idOriginal = NULL;

	protected $zarukaProductZarukaEntity;

	#endregion

	#region Method
	// Setter cislo
	protected function setCislo($value)
	{
		$this->cislo = $value;
	}
	// Getter cislo
	public function getCislo()
	{
		return $this->cislo;
	}
	// Getter cisloOriginal
	public function getCisloOriginal()
	{
		return $this->cisloOriginal;
	}
	// Setter cis_skladu
	protected function setCis_skladu($value)
	{
		$this->cis_skladu = $value;
	}
	// Getter cis_skladu
	public function getCis_skladu()
	{
		return $this->cis_skladu;
	}
	// Getter cis_skladuOriginal
	public function getCis_skladuOriginal()
	{
		return $this->cis_skladuOriginal;
	}
	// Setter typ_sort
	protected function setTyp_sort($value)
	{
		$this->typ_sort = $value;
	}
	// Getter typ_sort
	public function getTyp_sort()
	{
		return $this->typ_sort;
	}
	// Getter typ_sortOriginal
	public function getTyp_sortOriginal()
	{
		return $this->typ_sortOriginal;
	}
	// Setter hl_mj_id
	protected function setHl_mj_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->hl_mj_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->hl_mjMjEntity = new MjEntity($value,false);
		} else {
			$this->hl_mjMjEntity = null;
		}
	}
	// Getter hl_mj_id
	public function getHl_mj_id()
	{
		return $this->hl_mj_id;
	}
	// Getter hl_mj_idOriginal
	public function getHl_mj_idOriginal()
	{
		return $this->hl_mj_idOriginal;
	}
	// Setter mj_id
	protected function setMj_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->mj_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->mjMjEntity = new MjEntity($value,false);
		} else {
			$this->mjMjEntity = null;
		}
	}
	// Getter mj_id
	public function getMj_id()
	{
		return $this->mj_id;
	}
	// Getter mj_idOriginal
	public function getMj_idOriginal()
	{
		return $this->mj_idOriginal;
	}
	// Setter dph_id
	protected function setDph_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->dph_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->dphDphEntity = new DphEntity($value,false);
		} else {
			$this->dphDphEntity = null;
		}
	}
	// Getter dph_id
	public function getDph_id()
	{
		return $this->dph_id;
	}
	// Getter dph_idOriginal
	public function getDph_idOriginal()
	{
		return $this->dph_idOriginal;
	}
	// Setter skupina_id
	protected function setSkupina_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->skupina_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->skupinaProductCategoryEntity = new ProductCategoryEntity($value,false);
		} else {
			$this->skupinaProductCategoryEntity = null;
		}
	}
	// Getter skupina_id
	public function getSkupina_id()
	{
		return $this->skupina_id;
	}
	// Getter skupina_idOriginal
	public function getSkupina_idOriginal()
	{
		return $this->skupina_idOriginal;
	}
	// Setter vyrobce_id
	protected function setVyrobce_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->vyrobce_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->vyrobceProductVyrobceEntity = new ProductVyrobceEntity($value,false);
		} else {
			$this->vyrobceProductVyrobceEntity = null;
		}
	}
	// Getter vyrobce_id
	public function getVyrobce_id()
	{
		return $this->vyrobce_id;
	}
	// Getter vyrobce_idOriginal
	public function getVyrobce_idOriginal()
	{
		return $this->vyrobce_idOriginal;
	}
	// Setter aktivni
	protected function setAktivni($value)
	{
		if (isInt($value) || is_null($value)) { $this->aktivni = $value; }
	}
	// Getter aktivni
	public function getAktivni()
	{
		return $this->aktivni;
	}
	// Getter aktivniOriginal
	public function getAktivniOriginal()
	{
		return $this->aktivniOriginal;
	}
	// Setter min_prodcena
	protected function setMin_prodcena($value)
	{
		if (is_null($value)) { return; }
		$this->min_prodcena = strToNumeric($value);
	}
	// Getter min_prodcena
	public function getMin_prodcena()
	{
		return $this->min_prodcena;
	}
	// Getter min_prodcenaOriginal
	public function getMin_prodcenaOriginal()
	{
		return $this->min_prodcenaOriginal;
	}
	// Setter min_prodcena_sdph
	protected function setMin_prodcena_sdph($value)
	{
		if (is_null($value)) { return; }
		$this->min_prodcena_sdph = strToNumeric($value);
	}
	// Getter min_prodcena_sdph
	public function getMin_prodcena_sdph()
	{
		return $this->min_prodcena_sdph;
	}
	// Getter min_prodcena_sdphOriginal
	public function getMin_prodcena_sdphOriginal()
	{
		return $this->min_prodcena_sdphOriginal;
	}
	// Setter max_prodcena
	protected function setMax_prodcena($value)
	{
		if (is_null($value)) { return; }
		$this->max_prodcena = strToNumeric($value);
	}
	// Getter max_prodcena
	public function getMax_prodcena()
	{
		return $this->max_prodcena;
	}
	// Getter max_prodcenaOriginal
	public function getMax_prodcenaOriginal()
	{
		return $this->max_prodcenaOriginal;
	}
	// Setter max_prodcena_sdph
	protected function setMax_prodcena_sdph($value)
	{
		if (is_null($value)) { return; }
		$this->max_prodcena_sdph = strToNumeric($value);
	}
	// Getter max_prodcena_sdph
	public function getMax_prodcena_sdph()
	{
		return $this->max_prodcena_sdph;
	}
	// Getter max_prodcena_sdphOriginal
	public function getMax_prodcena_sdphOriginal()
	{
		return $this->max_prodcena_sdphOriginal;
	}
	// Setter nakupni_cena
	protected function setNakupni_cena($value)
	{
		if (is_null($value)) { return; }
		$this->nakupni_cena = strToNumeric($value);
	}
	// Getter nakupni_cena
	public function getNakupni_cena()
	{
		return $this->nakupni_cena;
	}
	// Getter nakupni_cenaOriginal
	public function getNakupni_cenaOriginal()
	{
		return $this->nakupni_cenaOriginal;
	}
	// Setter bazar
	protected function setBazar($value)
	{
		if (isInt($value) || is_null($value)) { $this->bazar = $value; }
	}
	// Getter bazar
	public function getBazar()
	{
		return $this->bazar;
	}
	// Getter bazarOriginal
	public function getBazarOriginal()
	{
		return $this->bazarOriginal;
	}
	// Setter isVarianty
	protected function setIsVarianty($value)
	{
		if (isInt($value) || is_null($value)) { $this->isVarianty = $value; }
	}
	// Getter isVarianty
	public function getIsVarianty()
	{
		return $this->isVarianty;
	}
	// Getter isVariantyOriginal
	public function getIsVariantyOriginal()
	{
		return $this->isVariantyOriginal;
	}
	// Setter qty
	protected function setQty($value)
	{
		$this->qty = strToNumeric($value);
	}
	// Getter qty
	public function getQty()
	{
		return $this->qty;
	}
	// Getter qtyOriginal
	public function getQtyOriginal()
	{
		return $this->qtyOriginal;
	}
	// Setter code01
	protected function setCode01($value)
	{
		$this->code01 = $value;
	}
	// Getter code01
	public function getCode01()
	{
		return $this->code01;
	}
	// Getter code01Original
	public function getCode01Original()
	{
		return $this->code01Original;
	}
	// Setter code02
	protected function setCode02($value)
	{
		$this->code02 = $value;
	}
	// Getter code02
	public function getCode02()
	{
		return $this->code02;
	}
	// Getter code02Original
	public function getCode02Original()
	{
		return $this->code02Original;
	}
	// Setter code03
	protected function setCode03($value)
	{
		$this->code03 = $value;
	}
	// Getter code03
	public function getCode03()
	{
		return $this->code03;
	}
	// Getter code03Original
	public function getCode03Original()
	{
		return $this->code03Original;
	}
	// Setter neexportovat
	protected function setNeexportovat($value)
	{
		if (isInt($value) || is_null($value)) { $this->neexportovat = $value; }
	}
	// Getter neexportovat
	public function getNeexportovat()
	{
		return $this->neexportovat;
	}
	// Getter neexportovatOriginal
	public function getNeexportovatOriginal()
	{
		return $this->neexportovatOriginal;
	}
	// Setter dostupnost_id
	protected function setDostupnost_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->dostupnost_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->dostupnostProductDostupnostEntity = new ProductDostupnostEntity($value,false);
		} else {
			$this->dostupnostProductDostupnostEntity = null;
		}
	}
	// Getter dostupnost_id
	public function getDostupnost_id()
	{
		return $this->dostupnost_id;
	}
	// Getter dostupnost_idOriginal
	public function getDostupnost_idOriginal()
	{
		return $this->dostupnost_idOriginal;
	}
	// Setter zaruka_id
	protected function setZaruka_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->zaruka_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->zarukaProductZarukaEntity = new ProductZarukaEntity($value,false);
		} else {
			$this->zarukaProductZarukaEntity = null;
		}
	}
	// Getter zaruka_id
	public function getZaruka_id()
	{
		return $this->zaruka_id;
	}
	// Getter zaruka_idOriginal
	public function getZaruka_idOriginal()
	{
		return $this->zaruka_idOriginal;
	}
	#endregion

}

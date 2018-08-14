<?php
/*************
* Třída ProductVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("PageVersionEntity.php");
class ProductVersionEntity extends PageVersionEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_products_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_products_version";
		$this->metadata["page_id"]["reference"] = "Product";
		$this->metadata["hl_mj_id"] = array("type" => "int","default" => "NULL","reference" => "Mj");
		$this->metadata["mj_id"] = array("type" => "int","default" => "NULL","reference" => "Mj");
		$this->metadata["skupina_id"] = array("type" => "int","default" => "NULL","reference" => "ProductCategory");
		$this->metadata["vyrobce_id"] = array("type" => "int","default" => "NULL","reference" => "ProductVyrobce");
		$this->metadata["prodcena"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["prodcena_sdph"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["bezna_cena"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["sleva"] = array("type" => "decimal(4,2)","default" => "NULL");
		$this->metadata["druh_slevy"] = array("type" => "varchar(1)","default" => "NULL");
		$this->metadata["netto"] = array("type" => "decimal(8,2)","default" => "NULL");
		$this->metadata["cislo1"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo2"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo3"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo4"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo5"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo6"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo7"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo8"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo9"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["cislo10"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["polozka1"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka2"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka3"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka4"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka5"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka6"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka7"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka8"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka9"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["polozka10"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["dostupnost"] = array("type" => "varchar(100)","default" => "NULL");
		$this->metadata["ppc_zbozicz"] = array("type" => "decimal(10,2)","default" => "NULL");
	}
	#endregion

	#region Property
	// int
	protected $hl_mj_id = NULL;
	protected $hl_mj_idOriginal = NULL;

	protected $hl_mjMjEntity;

	// int
	protected $mj_id = NULL;
	protected $mj_idOriginal = NULL;

	protected $mjMjEntity;

	// int
	protected $skupina_id = NULL;
	protected $skupina_idOriginal = NULL;

	protected $skupinaProductCategoryEntity;

	// int
	protected $vyrobce_id = NULL;
	protected $vyrobce_idOriginal = NULL;

	protected $vyrobceProductVyrobceEntity;

	// decimal(10,2)
	protected $prodcena = 0;
	protected $prodcenaOriginal = 0;

	// decimal(10,2)
	protected $prodcena_sdph = 0;
	protected $prodcena_sdphOriginal = 0;

	// decimal(10,2)
	protected $bezna_cena = 0;
	protected $bezna_cenaOriginal = 0;

	// decimal(4,2)
	protected $sleva = NULL;
	protected $slevaOriginal = NULL;

	// varchar(1)
	protected $druh_slevy = NULL;
	protected $druh_slevyOriginal = NULL;

	// decimal(8,2)
	protected $netto = NULL;
	protected $nettoOriginal = NULL;

	// decimal(10,2)
	protected $cislo1 = NULL;
	protected $cislo1Original = NULL;

	// decimal(10,2)
	protected $cislo2 = NULL;
	protected $cislo2Original = NULL;

	// decimal(10,2)
	protected $cislo3 = NULL;
	protected $cislo3Original = NULL;

	// decimal(10,2)
	protected $cislo4 = NULL;
	protected $cislo4Original = NULL;

	// decimal(10,2)
	protected $cislo5 = NULL;
	protected $cislo5Original = NULL;

	// decimal(10,2)
	protected $cislo6 = NULL;
	protected $cislo6Original = NULL;

	// decimal(10,2)
	protected $cislo7 = NULL;
	protected $cislo7Original = NULL;

	// decimal(10,2)
	protected $cislo8 = NULL;
	protected $cislo8Original = NULL;

	// decimal(10,2)
	protected $cislo9 = NULL;
	protected $cislo9Original = NULL;

	// decimal(10,2)
	protected $cislo10 = NULL;
	protected $cislo10Original = NULL;

	// varchar(100)
	protected $polozka1 = NULL;
	protected $polozka1Original = NULL;

	// varchar(100)
	protected $polozka2 = NULL;
	protected $polozka2Original = NULL;

	// varchar(100)
	protected $polozka3 = NULL;
	protected $polozka3Original = NULL;

	// varchar(100)
	protected $polozka4 = NULL;
	protected $polozka4Original = NULL;

	// varchar(100)
	protected $polozka5 = NULL;
	protected $polozka5Original = NULL;

	// varchar(100)
	protected $polozka6 = NULL;
	protected $polozka6Original = NULL;

	// varchar(100)
	protected $polozka7 = NULL;
	protected $polozka7Original = NULL;

	// varchar(100)
	protected $polozka8 = NULL;
	protected $polozka8Original = NULL;

	// varchar(100)
	protected $polozka9 = NULL;
	protected $polozka9Original = NULL;

	// varchar(100)
	protected $polozka10 = NULL;
	protected $polozka10Original = NULL;

	// varchar(100)
	protected $dostupnost = NULL;
	protected $dostupnostOriginal = NULL;

	// decimal(10,2)
	protected $ppc_zbozicz = NULL;
	protected $ppc_zboziczOriginal = NULL;

	#endregion

	#region Method
	// Setter page_id
	protected function setPage_id($value)
	{
		$this->page_id = $value;
	}
	// Getter page_id
	public function getPage_id()
	{
		return $this->page_id;
	}
	// Getter page_idOriginal
	public function getPage_idOriginal()
	{
		return $this->page_idOriginal;
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
	// Setter prodcena
	protected function setProdcena($value)
	{
		if (is_null($value)) { return; }
		$this->prodcena = strToNumeric($value);
	}
	// Getter prodcena
	public function getProdcena()
	{
		return $this->prodcena;
	}
	// Getter prodcenaOriginal
	public function getProdcenaOriginal()
	{
		return $this->prodcenaOriginal;
	}
	// Setter prodcena_sdph
	protected function setProdcena_sdph($value)
	{
		if (is_null($value)) { return; }
		$this->prodcena_sdph = strToNumeric($value);
	}
	// Getter prodcena_sdph
	public function getProdcena_sdph()
	{
		return $this->prodcena_sdph;
	}
	// Getter prodcena_sdphOriginal
	public function getProdcena_sdphOriginal()
	{
		return $this->prodcena_sdphOriginal;
	}
	// Setter bezna_cena
	protected function setBezna_cena($value)
	{
		if (is_null($value)) { return; }
		$this->bezna_cena = strToNumeric($value);
	}
	// Getter bezna_cena
	public function getBezna_cena()
	{
		return $this->bezna_cena;
	}
	// Getter bezna_cenaOriginal
	public function getBezna_cenaOriginal()
	{
		return $this->bezna_cenaOriginal;
	}
	// Setter sleva
	protected function setSleva($value)
	{
		$this->sleva = strToNumeric($value);
	}
	// Getter sleva
	public function getSleva()
	{
		return $this->sleva;
	}
	// Getter slevaOriginal
	public function getSlevaOriginal()
	{
		return $this->slevaOriginal;
	}
	// Setter druh_slevy
	protected function setDruh_slevy($value)
	{
		$this->druh_slevy = $value;
	}
	// Getter druh_slevy
	public function getDruh_slevy()
	{
		return $this->druh_slevy;
	}
	// Getter druh_slevyOriginal
	public function getDruh_slevyOriginal()
	{
		return $this->druh_slevyOriginal;
	}
	// Setter netto
	protected function setNetto($value)
	{
		$this->netto = strToNumeric($value);
	}
	// Getter netto
	public function getNetto()
	{
		return $this->netto;
	}
	// Getter nettoOriginal
	public function getNettoOriginal()
	{
		return $this->nettoOriginal;
	}
	// Setter cislo1
	protected function setCislo1($value)
	{
		$this->cislo1 = strToNumeric($value);
	}
	// Getter cislo1
	public function getCislo1()
	{
		return $this->cislo1;
	}
	// Getter cislo1Original
	public function getCislo1Original()
	{
		return $this->cislo1Original;
	}
	// Setter cislo2
	protected function setCislo2($value)
	{
		$this->cislo2 = strToNumeric($value);
	}
	// Getter cislo2
	public function getCislo2()
	{
		return $this->cislo2;
	}
	// Getter cislo2Original
	public function getCislo2Original()
	{
		return $this->cislo2Original;
	}
	// Setter cislo3
	protected function setCislo3($value)
	{
		$this->cislo3 = strToNumeric($value);
	}
	// Getter cislo3
	public function getCislo3()
	{
		return $this->cislo3;
	}
	// Getter cislo3Original
	public function getCislo3Original()
	{
		return $this->cislo3Original;
	}
	// Setter cislo4
	protected function setCislo4($value)
	{
		$this->cislo4 = strToNumeric($value);
	}
	// Getter cislo4
	public function getCislo4()
	{
		return $this->cislo4;
	}
	// Getter cislo4Original
	public function getCislo4Original()
	{
		return $this->cislo4Original;
	}
	// Setter cislo5
	protected function setCislo5($value)
	{
		$this->cislo5 = strToNumeric($value);
	}
	// Getter cislo5
	public function getCislo5()
	{
		return $this->cislo5;
	}
	// Getter cislo5Original
	public function getCislo5Original()
	{
		return $this->cislo5Original;
	}
	// Setter cislo6
	protected function setCislo6($value)
	{
		$this->cislo6 = strToNumeric($value);
	}
	// Getter cislo6
	public function getCislo6()
	{
		return $this->cislo6;
	}
	// Getter cislo6Original
	public function getCislo6Original()
	{
		return $this->cislo6Original;
	}
	// Setter cislo7
	protected function setCislo7($value)
	{
		$this->cislo7 = strToNumeric($value);
	}
	// Getter cislo7
	public function getCislo7()
	{
		return $this->cislo7;
	}
	// Getter cislo7Original
	public function getCislo7Original()
	{
		return $this->cislo7Original;
	}
	// Setter cislo8
	protected function setCislo8($value)
	{
		$this->cislo8 = strToNumeric($value);
	}
	// Getter cislo8
	public function getCislo8()
	{
		return $this->cislo8;
	}
	// Getter cislo8Original
	public function getCislo8Original()
	{
		return $this->cislo8Original;
	}
	// Setter cislo9
	protected function setCislo9($value)
	{
		$this->cislo9 = strToNumeric($value);
	}
	// Getter cislo9
	public function getCislo9()
	{
		return $this->cislo9;
	}
	// Getter cislo9Original
	public function getCislo9Original()
	{
		return $this->cislo9Original;
	}
	// Setter cislo10
	protected function setCislo10($value)
	{
		$this->cislo10 = strToNumeric($value);
	}
	// Getter cislo10
	public function getCislo10()
	{
		return $this->cislo10;
	}
	// Getter cislo10Original
	public function getCislo10Original()
	{
		return $this->cislo10Original;
	}
	// Setter polozka1
	protected function setPolozka1($value)
	{
		$this->polozka1 = $value;
	}
	// Getter polozka1
	public function getPolozka1()
	{
		return $this->polozka1;
	}
	// Getter polozka1Original
	public function getPolozka1Original()
	{
		return $this->polozka1Original;
	}
	// Setter polozka2
	protected function setPolozka2($value)
	{
		$this->polozka2 = $value;
	}
	// Getter polozka2
	public function getPolozka2()
	{
		return $this->polozka2;
	}
	// Getter polozka2Original
	public function getPolozka2Original()
	{
		return $this->polozka2Original;
	}
	// Setter polozka3
	protected function setPolozka3($value)
	{
		$this->polozka3 = $value;
	}
	// Getter polozka3
	public function getPolozka3()
	{
		return $this->polozka3;
	}
	// Getter polozka3Original
	public function getPolozka3Original()
	{
		return $this->polozka3Original;
	}
	// Setter polozka4
	protected function setPolozka4($value)
	{
		$this->polozka4 = $value;
	}
	// Getter polozka4
	public function getPolozka4()
	{
		return $this->polozka4;
	}
	// Getter polozka4Original
	public function getPolozka4Original()
	{
		return $this->polozka4Original;
	}
	// Setter polozka5
	protected function setPolozka5($value)
	{
		$this->polozka5 = $value;
	}
	// Getter polozka5
	public function getPolozka5()
	{
		return $this->polozka5;
	}
	// Getter polozka5Original
	public function getPolozka5Original()
	{
		return $this->polozka5Original;
	}
	// Setter polozka6
	protected function setPolozka6($value)
	{
		$this->polozka6 = $value;
	}
	// Getter polozka6
	public function getPolozka6()
	{
		return $this->polozka6;
	}
	// Getter polozka6Original
	public function getPolozka6Original()
	{
		return $this->polozka6Original;
	}
	// Setter polozka7
	protected function setPolozka7($value)
	{
		$this->polozka7 = $value;
	}
	// Getter polozka7
	public function getPolozka7()
	{
		return $this->polozka7;
	}
	// Getter polozka7Original
	public function getPolozka7Original()
	{
		return $this->polozka7Original;
	}
	// Setter polozka8
	protected function setPolozka8($value)
	{
		$this->polozka8 = $value;
	}
	// Getter polozka8
	public function getPolozka8()
	{
		return $this->polozka8;
	}
	// Getter polozka8Original
	public function getPolozka8Original()
	{
		return $this->polozka8Original;
	}
	// Setter polozka9
	protected function setPolozka9($value)
	{
		$this->polozka9 = $value;
	}
	// Getter polozka9
	public function getPolozka9()
	{
		return $this->polozka9;
	}
	// Getter polozka9Original
	public function getPolozka9Original()
	{
		return $this->polozka9Original;
	}
	// Setter polozka10
	protected function setPolozka10($value)
	{
		$this->polozka10 = $value;
	}
	// Getter polozka10
	public function getPolozka10()
	{
		return $this->polozka10;
	}
	// Getter polozka10Original
	public function getPolozka10Original()
	{
		return $this->polozka10Original;
	}
	// Setter dostupnost
	protected function setDostupnost($value)
	{
		$this->dostupnost = $value;
	}
	// Getter dostupnost
	public function getDostupnost()
	{
		return $this->dostupnost;
	}
	// Getter dostupnostOriginal
	public function getDostupnostOriginal()
	{
		return $this->dostupnostOriginal;
	}
	// Setter ppc_zbozicz
	protected function setPpc_zbozicz($value)
	{
		$this->ppc_zbozicz = strToNumeric($value);
	}
	// Getter ppc_zbozicz
	public function getPpc_zbozicz()
	{
		return $this->ppc_zbozicz;
	}
	// Getter ppc_zboziczOriginal
	public function getPpc_zboziczOriginal()
	{
		return $this->ppc_zboziczOriginal;
	}
	#endregion

}

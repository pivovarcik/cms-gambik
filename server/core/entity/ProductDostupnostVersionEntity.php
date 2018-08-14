<?php
/*************
* Třída ProductDostupnostVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProductDostupnostVersionEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_dostupnost_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_dostupnost_version";
		$this->metadata["name"] = array("type" => "longtext");
		$this->metadata["lang_id"] = array("type" => "int(11)");
		$this->metadata["dostupnost_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "ProductDostupnost");
	}
	#endregion

	#region Property
	// longtext
	protected $name;

	protected $nameOriginal;
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
	// int(11)
	protected $dostupnost_id;

	protected $dostupnost_idOriginal;
	protected $dostupnostProductDostupnostEntity;

	#endregion

	#region Method
	// Setter name
	protected function setName($value)
	{
		$this->name = $value;
	}
	// Getter name
	public function getName()
	{
		return $this->name;
	}
	// Getter nameOriginal
	public function getNameOriginal()
	{
		return $this->nameOriginal;
	}
	// Setter lang_id
	protected function setLang_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->lang_id = $value; }
	}
	// Getter lang_id
	public function getLang_id()
	{
		return $this->lang_id;
	}
	// Getter lang_idOriginal
	public function getLang_idOriginal()
	{
		return $this->lang_idOriginal;
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
	#endregion

}

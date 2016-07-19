<?php
/*************
* Třída ShopPaymentVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class ShopPaymentVersionEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_zpusob_platby_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_zpusob_platby_version";
		$this->metadata["name"] = array("type" => "varchar(50)");
		$this->metadata["description"] = array("type" => "longtext");
		$this->metadata["price"] = array("type" => "decimal(12,2)");
		$this->metadata["lang_id"] = array("type" => "int(11)");
		$this->metadata["page_id"] = array("type" => "int(11)");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $name;

	protected $nameOriginal;
	// longtext
	protected $description;

	protected $descriptionOriginal;
	// decimal(12,2)
	protected $price;

	protected $priceOriginal;
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
	// int(11)
	protected $page_id;

	protected $page_idOriginal;
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
	// Setter description
	protected function setDescription($value)
	{
		$this->description = $value;
	}
	// Getter description
	public function getDescription()
	{
		return $this->description;
	}
	// Getter descriptionOriginal
	public function getDescriptionOriginal()
	{
		return $this->descriptionOriginal;
	}
	// Setter price
	protected function setPrice($value)
	{
		$this->price = strToNumeric($value);
	}
	// Getter price
	public function getPrice()
	{
		return $this->price;
	}
	// Getter priceOriginal
	public function getPriceOriginal()
	{
		return $this->priceOriginal;
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
	// Setter page_id
	protected function setPage_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->page_id = $value; }
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
	#endregion

}

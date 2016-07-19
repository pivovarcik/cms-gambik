<?php
/*************
* Třída OrderStatusEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class OrderStatusEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_orders_stavy";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_orders_stavy";
		$this->metadata["name"] = array("type" => "varchar(25)");
		$this->metadata["description"] = array("type" => "varchar(255)");
		$this->metadata["order"] = array("type" => "int(11)");
	}
	#endregion

	#region Property
	// varchar(25)
	protected $name;

	protected $nameOriginal;
	// varchar(255)
	protected $description;

	protected $descriptionOriginal;
	// int(11)
	protected $order;

	protected $orderOriginal;
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
	// Setter order
	protected function setOrder($value)
	{
		if (isInt($value) || is_null($value)) { $this->order = $value; }
	}
	// Getter order
	public function getOrder()
	{
		return $this->order;
	}
	// Getter orderOriginal
	public function getOrderOriginal()
	{
		return $this->orderOriginal;
	}
	#endregion

}

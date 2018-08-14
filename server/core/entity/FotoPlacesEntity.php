<?php
/*************
* Třída FotoPlacesEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class FotoPlacesEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_umisteni_foto";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_umisteni_foto";
		$this->metadata["table"] = array("type" => "varchar(50)");
		$this->metadata["uid_source"] = array("type" => "int","default" => "null");
		$this->metadata["uid_target"] = array("type" => "int","default" => "null");
		$this->metadata["order"] = array("type" => "int","default" => "0");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $table;

	protected $tableOriginal;
	// int
	protected $uid_source = null;
	protected $uid_sourceOriginal = null;

	// int
	protected $uid_target = null;
	protected $uid_targetOriginal = null;

	// int
	protected $order = 0;
	protected $orderOriginal = 0;

	#endregion

	#region Method
	// Setter table
	protected function setTable($value)
	{
		$this->table = $value;
	}
	// Getter table
	public function getTable()
	{
		return $this->table;
	}
	// Getter tableOriginal
	public function getTableOriginal()
	{
		return $this->tableOriginal;
	}
	// Setter uid_source
	protected function setUid_source($value)
	{
		if (isInt($value) || is_null($value)) { $this->uid_source = $value; }
	}
	// Getter uid_source
	public function getUid_source()
	{
		return $this->uid_source;
	}
	// Getter uid_sourceOriginal
	public function getUid_sourceOriginal()
	{
		return $this->uid_sourceOriginal;
	}
	// Setter uid_target
	protected function setUid_target($value)
	{
		if (isInt($value) || is_null($value)) { $this->uid_target = $value; }
	}
	// Getter uid_target
	public function getUid_target()
	{
		return $this->uid_target;
	}
	// Getter uid_targetOriginal
	public function getUid_targetOriginal()
	{
		return $this->uid_targetOriginal;
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

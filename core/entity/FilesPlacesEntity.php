<?php
/*************
* Třída FilesPlacesEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class FilesPlacesEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_umisteni_files";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_umisteni_files";
		$this->metadata["table"] = array("type" => "varchar(50)");
		$this->metadata["source_id"] = array("type" => "int","default" => "null");
		$this->metadata["target_id"] = array("type" => "int","default" => "null");
		$this->metadata["order"] = array("type" => "int","default" => "0");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $table;

	protected $tableOriginal;
	// int
	protected $source_id = null;
	protected $source_idOriginal = null;

	// int
	protected $target_id = null;
	protected $target_idOriginal = null;

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
	// Setter source_id
	protected function setSource_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->source_id = $value; }
	}
	// Getter source_id
	public function getSource_id()
	{
		return $this->source_id;
	}
	// Getter source_idOriginal
	public function getSource_idOriginal()
	{
		return $this->source_idOriginal;
	}
	// Setter target_id
	protected function setTarget_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->target_id = $value; }
	}
	// Getter target_id
	public function getTarget_id()
	{
		return $this->target_id;
	}
	// Getter target_idOriginal
	public function getTarget_idOriginal()
	{
		return $this->target_idOriginal;
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

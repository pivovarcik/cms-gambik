<?php
/*************
* Třída RadekEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
abstract class RadekEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["doklad_id"] = array("type" => "int(11)","default" => "NOT NULL");
		$this->metadata["user_id"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["order"] = array("type" => "int(11)","default" => "0");
	}
	#endregion

	#region Property
	// int(11)
	protected $doklad_id;

	protected $doklad_idOriginal;
	// int(11)
	protected $user_id = NULL;
	protected $user_idOriginal = NULL;

	// int(11)
	protected $order = 0;
	protected $orderOriginal = 0;

	#endregion

	#region Method
	// Setter doklad_id
	protected function setDoklad_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->doklad_id = $value; }
	}
	// Getter doklad_id
	public function getDoklad_id()
	{
		return $this->doklad_id;
	}
	// Getter doklad_idOriginal
	public function getDoklad_idOriginal()
	{
		return $this->doklad_idOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->user_id = $value; }
	}
	// Getter user_id
	public function getUser_id()
	{
		return $this->user_id;
	}
	// Getter user_idOriginal
	public function getUser_idOriginal()
	{
		return $this->user_idOriginal;
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

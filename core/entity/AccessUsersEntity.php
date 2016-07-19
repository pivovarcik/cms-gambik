<?php
/*************
* Třída AccessUsersEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class AccessUsersEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_users_accsess_assoc";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_users_accsess_assoc";
		$this->metadata["page_type"] = array("type" => "varchar(100)","default" => "null");
		$this->metadata["page_id"] = array("type" => "int","default" => "null");
		$this->metadata["user_id"] = array("type" => "int","default" => "null");
	}
	#endregion

	#region Property
	// varchar(100)
	protected $page_type = null;
	protected $page_typeOriginal = null;

	// int
	protected $page_id = null;
	protected $page_idOriginal = null;

	// int
	protected $user_id = null;
	protected $user_idOriginal = null;

	#endregion

	#region Method
	// Setter page_type
	protected function setPage_type($value)
	{
		$this->page_type = $value;
	}
	// Getter page_type
	public function getPage_type()
	{
		return $this->page_type;
	}
	// Getter page_typeOriginal
	public function getPage_typeOriginal()
	{
		return $this->page_typeOriginal;
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
	#endregion

}

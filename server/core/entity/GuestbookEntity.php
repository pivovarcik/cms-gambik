<?php
/*************
* Třída GuestbookEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class GuestbookEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_guestbook";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_guestbook";
		$this->metadata["user_id"] = array("type" => "int");
		$this->metadata["ip"] = array("type" => "varchar(25)");
		$this->metadata["nick"] = array("type" => "varchar(25)");
		$this->metadata["parent_id"] = array("type" => "int");
		$this->metadata["text"] = array("type" => "longtext");
	}
	#endregion

	#region Property
	// int
	protected $user_id;

	protected $user_idOriginal;
	// varchar(25)
	protected $ip;

	protected $ipOriginal;
	// varchar(25)
	protected $nick;

	protected $nickOriginal;
	// int
	protected $parent_id;

	protected $parent_idOriginal;
	// longtext
	protected $text;

	protected $textOriginal;
	#endregion

	#region Method
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
	// Setter ip
	protected function setIp($value)
	{
		$this->ip = $value;
	}
	// Getter ip
	public function getIp()
	{
		return $this->ip;
	}
	// Getter ipOriginal
	public function getIpOriginal()
	{
		return $this->ipOriginal;
	}
	// Setter nick
	protected function setNick($value)
	{
		$this->nick = $value;
	}
	// Getter nick
	public function getNick()
	{
		return $this->nick;
	}
	// Getter nickOriginal
	public function getNickOriginal()
	{
		return $this->nickOriginal;
	}
	// Setter parent_id
	protected function setParent_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->parent_id = $value; }
	}
	// Getter parent_id
	public function getParent_id()
	{
		return $this->parent_id;
	}
	// Getter parent_idOriginal
	public function getParent_idOriginal()
	{
		return $this->parent_idOriginal;
	}
	// Setter text
	protected function setText($value)
	{
		$this->text = $value;
	}
	// Getter text
	public function getText()
	{
		return $this->text;
	}
	// Getter textOriginal
	public function getTextOriginal()
	{
		return $this->textOriginal;
	}
	#endregion

}

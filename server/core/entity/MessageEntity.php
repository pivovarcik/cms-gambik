<?php
/*************
* Třída MessageEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class MessageEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_messages";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_messages";
		$this->metadata["ReadTimeStamp"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["autor_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "User");
		$this->metadata["message"] = array("type" => "longtext","default" => "NULL");
		$this->metadata["adresat_id"] = array("type" => "int(11)","default" => "NULL","reference" => "User");
	}
	#endregion

	#region Property
	// datetime
	protected $ReadTimeStamp = NULL;
	protected $ReadTimeStampOriginal = NULL;

	// int(11)
	protected $autor_id;

	protected $autor_idOriginal;
	protected $autorUserEntity;

	// longtext
	protected $message = NULL;
	protected $messageOriginal = NULL;

	// int(11)
	protected $adresat_id = NULL;
	protected $adresat_idOriginal = NULL;

	protected $adresatUserEntity;

	#endregion

	#region Method
	// Setter ReadTimeStamp
	protected function setReadTimeStamp($value)
	{
		$this->ReadTimeStamp = strToDatetime($value);
	}
	// Getter ReadTimeStamp
	public function getReadTimeStamp()
	{
		return $this->ReadTimeStamp;
	}
	// Getter ReadTimeStampOriginal
	public function getReadTimeStampOriginal()
	{
		return $this->ReadTimeStampOriginal;
	}
	// Setter autor_id
	protected function setAutor_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->autor_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->autorUserEntity = new UserEntity($value,false);
		} else {
			$this->autorUserEntity = null;
		}
	}
	// Getter autor_id
	public function getAutor_id()
	{
		return $this->autor_id;
	}
	// Getter autor_idOriginal
	public function getAutor_idOriginal()
	{
		return $this->autor_idOriginal;
	}
	// Setter message
	protected function setMessage($value)
	{
		$this->message = $value;
	}
	// Getter message
	public function getMessage()
	{
		return $this->message;
	}
	// Getter messageOriginal
	public function getMessageOriginal()
	{
		return $this->messageOriginal;
	}
	// Setter adresat_id
	protected function setAdresat_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->adresat_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->adresatUserEntity = new UserEntity($value,false);
		} else {
			$this->adresatUserEntity = null;
		}
	}
	// Getter adresat_id
	public function getAdresat_id()
	{
		return $this->adresat_id;
	}
	// Getter adresat_idOriginal
	public function getAdresat_idOriginal()
	{
		return $this->adresat_idOriginal;
	}
	#endregion

}

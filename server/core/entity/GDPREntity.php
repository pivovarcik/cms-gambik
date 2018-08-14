<?php
/*************
* Třída GDPREntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class GDPREntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_gdpr_souhlas";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_gdpr_souhlas";
		$this->metadata["email"] = array("type" => "varchar(150)");
		$this->metadata["ip"] = array("type" => "varchar(50)");
		$this->metadata["subject"] = array("type" => "varchar(255)");
		$this->metadata["user_id"] = array("type" => "int");
		$this->metadata["souhlas_text"] = array("type" => "longtext");
		$this->metadata["souhlas_od"] = array("type" => "datetime");
		$this->metadata["souhlas_do"] = array("type" => "datetime");
		$this->metadata["zpusob_overeni"] = array("type" => "varchar(255)");
	}
	#endregion

	#region Property
	// varchar(150)
	protected $email;

	protected $emailOriginal;
	// varchar(50)
	protected $ip;

	protected $ipOriginal;
	// varchar(255)
	protected $subject;

	protected $subjectOriginal;
	// int
	protected $user_id;

	protected $user_idOriginal;
	// longtext
	protected $souhlas_text;

	protected $souhlas_textOriginal;
	// datetime
	protected $souhlas_od;

	protected $souhlas_odOriginal;
	// datetime
	protected $souhlas_do;

	protected $souhlas_doOriginal;
	// varchar(255)
	protected $zpusob_overeni;

	protected $zpusob_overeniOriginal;
	#endregion

	#region Method
	// Setter email
	protected function setEmail($value)
	{
		$this->email = $value;
	}
	// Getter email
	public function getEmail()
	{
		return $this->email;
	}
	// Getter emailOriginal
	public function getEmailOriginal()
	{
		return $this->emailOriginal;
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
	// Setter subject
	protected function setSubject($value)
	{
		$this->subject = $value;
	}
	// Getter subject
	public function getSubject()
	{
		return $this->subject;
	}
	// Getter subjectOriginal
	public function getSubjectOriginal()
	{
		return $this->subjectOriginal;
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
	// Setter souhlas_text
	protected function setSouhlas_text($value)
	{
		$this->souhlas_text = $value;
	}
	// Getter souhlas_text
	public function getSouhlas_text()
	{
		return $this->souhlas_text;
	}
	// Getter souhlas_textOriginal
	public function getSouhlas_textOriginal()
	{
		return $this->souhlas_textOriginal;
	}
	// Setter souhlas_od
	protected function setSouhlas_od($value)
	{
		$this->souhlas_od = strToDatetime($value);
	}
	// Getter souhlas_od
	public function getSouhlas_od()
	{
		return $this->souhlas_od;
	}
	// Getter souhlas_odOriginal
	public function getSouhlas_odOriginal()
	{
		return $this->souhlas_odOriginal;
	}
	// Setter souhlas_do
	protected function setSouhlas_do($value)
	{
		$this->souhlas_do = strToDatetime($value);
	}
	// Getter souhlas_do
	public function getSouhlas_do()
	{
		return $this->souhlas_do;
	}
	// Getter souhlas_doOriginal
	public function getSouhlas_doOriginal()
	{
		return $this->souhlas_doOriginal;
	}
	// Setter zpusob_overeni
	protected function setZpusob_overeni($value)
	{
		$this->zpusob_overeni = $value;
	}
	// Getter zpusob_overeni
	public function getZpusob_overeni()
	{
		return $this->zpusob_overeni;
	}
	// Getter zpusob_overeniOriginal
	public function getZpusob_overeniOriginal()
	{
		return $this->zpusob_overeniOriginal;
	}
	#endregion

}

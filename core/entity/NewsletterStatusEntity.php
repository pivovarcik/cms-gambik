<?php
/*************
* Třída NewsletterStatusEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class NewsletterStatusEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_newsletter_email_status";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_newsletter_email_status";
		$this->metadata["email"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["mailing_id"] = array("type" => "int(11)","default" => "NULL","reference" => "Mail");
		$this->metadata["visitor"] = array("type" => "varchar(150)","default" => "NULL");
		$this->metadata["ReadTimeStamp"] = array("type" => "datetime","default" => "NULL");
	}
	#endregion

	#region Property
	// varchar(255)
	protected $email = NULL;
	protected $emailOriginal = NULL;

	// int(11)
	protected $mailing_id = NULL;
	protected $mailing_idOriginal = NULL;

	protected $mailingMailEntity;

	// varchar(150)
	protected $visitor = NULL;
	protected $visitorOriginal = NULL;

	// datetime
	protected $ReadTimeStamp = NULL;
	protected $ReadTimeStampOriginal = NULL;

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
	// Setter mailing_id
	protected function setMailing_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->mailing_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->mailingMailEntity = new MailEntity($value,false);
		} else {
			$this->mailingMailEntity = null;
		}
	}
	// Getter mailing_id
	public function getMailing_id()
	{
		return $this->mailing_id;
	}
	// Getter mailing_idOriginal
	public function getMailing_idOriginal()
	{
		return $this->mailing_idOriginal;
	}
	// Setter visitor
	protected function setVisitor($value)
	{
		$this->visitor = $value;
	}
	// Getter visitor
	public function getVisitor()
	{
		return $this->visitor;
	}
	// Getter visitorOriginal
	public function getVisitorOriginal()
	{
		return $this->visitorOriginal;
	}
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
	#endregion

}

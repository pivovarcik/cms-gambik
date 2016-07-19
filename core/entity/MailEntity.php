<?php
/*************
* Třída MailEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class MailEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_email";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_email";
		$this->metadata["isDeleted"] = array("type" => "int(11)");
		$this->metadata["subject"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["user_id"] = array("type" => "int(11)","default" => "NULL","reference" => "User");
		$this->metadata["description"] = array("type" => "longtext","default" => "NULL");
	}
	#endregion

	#region Property
	// int(11)
	protected $isDeleted;

	protected $isDeletedOriginal;
	// varchar(255)
	protected $subject = NULL;
	protected $subjectOriginal = NULL;

	// int(11)
	protected $user_id = NULL;
	protected $user_idOriginal = NULL;

	protected $userUserEntity;

	// longtext
	protected $description = NULL;
	protected $descriptionOriginal = NULL;

	#endregion

	#region Method
	// Setter isDeleted
	protected function setIsDeleted($value)
	{
		if (isInt($value) || is_null($value)) { $this->isDeleted = $value; }
	}
	// Getter isDeleted
	public function getIsDeleted()
	{
		return $this->isDeleted;
	}
	// Getter isDeletedOriginal
	public function getIsDeletedOriginal()
	{
		return $this->isDeletedOriginal;
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
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->user_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->userUserEntity = new UserEntity($value,false);
		} else {
			$this->userUserEntity = null;
		}
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
	#endregion

}

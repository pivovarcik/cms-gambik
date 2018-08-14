<?php
/*************
* Třída CategoryEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("PageEntity.php");
class CategoryEntity extends PageEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_category";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_category";
		$this->metadata["showPosted"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["role"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["classLi"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["classA"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["icon_class"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["logo_url"] = array("type" => "varchar(255)","default" => "NULL");
	}
	#endregion

	#region Property
	// tinyint(1)
	protected $showPosted = 0;
	protected $showPostedOriginal = 0;

	// tinyint(1)
	protected $role = 0;
	protected $roleOriginal = 0;

	// varchar(25)
	protected $classLi = NULL;
	protected $classLiOriginal = NULL;

	// varchar(25)
	protected $classA = NULL;
	protected $classAOriginal = NULL;

	// varchar(25)
	protected $icon_class = NULL;
	protected $icon_classOriginal = NULL;

	// varchar(255)
	protected $logo_url = NULL;
	protected $logo_urlOriginal = NULL;

	#endregion

	#region Method
	// Setter showPosted
	protected function setShowPosted($value)
	{
		$this->showPosted = $value;
	}
	// Getter showPosted
	public function getShowPosted()
	{
		return $this->showPosted;
	}
	// Getter showPostedOriginal
	public function getShowPostedOriginal()
	{
		return $this->showPostedOriginal;
	}
	// Setter role
	protected function setRole($value)
	{
		$this->role = $value;
	}
	// Getter role
	public function getRole()
	{
		return $this->role;
	}
	// Getter roleOriginal
	public function getRoleOriginal()
	{
		return $this->roleOriginal;
	}
	// Setter classLi
	protected function setClassLi($value)
	{
		$this->classLi = $value;
	}
	// Getter classLi
	public function getClassLi()
	{
		return $this->classLi;
	}
	// Getter classLiOriginal
	public function getClassLiOriginal()
	{
		return $this->classLiOriginal;
	}
	// Setter classA
	protected function setClassA($value)
	{
		$this->classA = $value;
	}
	// Getter classA
	public function getClassA()
	{
		return $this->classA;
	}
	// Getter classAOriginal
	public function getClassAOriginal()
	{
		return $this->classAOriginal;
	}
	// Setter icon_class
	protected function setIcon_class($value)
	{
		$this->icon_class = $value;
	}
	// Getter icon_class
	public function getIcon_class()
	{
		return $this->icon_class;
	}
	// Getter icon_classOriginal
	public function getIcon_classOriginal()
	{
		return $this->icon_classOriginal;
	}
	// Setter logo_url
	protected function setLogo_url($value)
	{
		$this->logo_url = $value;
	}
	// Getter logo_url
	public function getLogo_url()
	{
		return $this->logo_url;
	}
	// Getter logo_urlOriginal
	public function getLogo_urlOriginal()
	{
		return $this->logo_urlOriginal;
	}
	#endregion

}

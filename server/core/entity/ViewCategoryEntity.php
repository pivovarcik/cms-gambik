<?php
/*************
* Třída ViewCategoryEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ViewCategoryEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "view_category";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "view_category";
		$this->metadata["lang_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "Language");
		$this->metadata["parent_id"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["level"] = array("type" => "int(11)","default" => "NOT NULL");
		$this->metadata["category_id"] = array("type" => "int(11)","default" => "NULL","reference" => "Category");
		$this->metadata["title"] = array("type" => "varchar(255)","default" => "NOT NULL");
		$this->metadata["serial_cat_id"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["serial_cat_url"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["serial_cat_title"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["icon_class"] = array("type" => "varchar(25)","default" => "NULL");
	}
	#endregion

	#region Property
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
	protected $langLanguageEntity;

	// int(11)
	protected $parent_id = NULL;
	protected $parent_idOriginal = NULL;

	// int(11)
	protected $level;

	protected $levelOriginal;
	// int(11)
	protected $category_id = NULL;
	protected $category_idOriginal = NULL;

	protected $categoryCategoryEntity;

	// varchar(255)
	protected $title;

	protected $titleOriginal;
	// varchar(255)
	protected $serial_cat_id = NULL;
	protected $serial_cat_idOriginal = NULL;

	// varchar(255)
	protected $serial_cat_url = NULL;
	protected $serial_cat_urlOriginal = NULL;

	// varchar(255)
	protected $serial_cat_title = NULL;
	protected $serial_cat_titleOriginal = NULL;

	// varchar(25)
	protected $icon_class = NULL;
	protected $icon_classOriginal = NULL;

	#endregion

	#region Method
	// Setter lang_id
	protected function setLang_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->lang_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->langLanguageEntity = new LanguageEntity($value,false);
		} else {
			$this->langLanguageEntity = null;
		}
	}
	// Getter lang_id
	public function getLang_id()
	{
		return $this->lang_id;
	}
	// Getter lang_idOriginal
	public function getLang_idOriginal()
	{
		return $this->lang_idOriginal;
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
	// Setter level
	protected function setLevel($value)
	{
		if (isInt($value) || is_null($value)) { $this->level = $value; }
	}
	// Getter level
	public function getLevel()
	{
		return $this->level;
	}
	// Getter levelOriginal
	public function getLevelOriginal()
	{
		return $this->levelOriginal;
	}
	// Setter category_id
	protected function setCategory_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->category_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->categoryCategoryEntity = new CategoryEntity($value,false);
		} else {
			$this->categoryCategoryEntity = null;
		}
	}
	// Getter category_id
	public function getCategory_id()
	{
		return $this->category_id;
	}
	// Getter category_idOriginal
	public function getCategory_idOriginal()
	{
		return $this->category_idOriginal;
	}
	// Setter title
	protected function setTitle($value)
	{
		$this->title = $value;
	}
	// Getter title
	public function getTitle()
	{
		return $this->title;
	}
	// Getter titleOriginal
	public function getTitleOriginal()
	{
		return $this->titleOriginal;
	}
	// Setter serial_cat_id
	protected function setSerial_cat_id($value)
	{
		$this->serial_cat_id = $value;
	}
	// Getter serial_cat_id
	public function getSerial_cat_id()
	{
		return $this->serial_cat_id;
	}
	// Getter serial_cat_idOriginal
	public function getSerial_cat_idOriginal()
	{
		return $this->serial_cat_idOriginal;
	}
	// Setter serial_cat_url
	protected function setSerial_cat_url($value)
	{
		$this->serial_cat_url = $value;
	}
	// Getter serial_cat_url
	public function getSerial_cat_url()
	{
		return $this->serial_cat_url;
	}
	// Getter serial_cat_urlOriginal
	public function getSerial_cat_urlOriginal()
	{
		return $this->serial_cat_urlOriginal;
	}
	// Setter serial_cat_title
	protected function setSerial_cat_title($value)
	{
		$this->serial_cat_title = $value;
	}
	// Getter serial_cat_title
	public function getSerial_cat_title()
	{
		return $this->serial_cat_title;
	}
	// Getter serial_cat_titleOriginal
	public function getSerial_cat_titleOriginal()
	{
		return $this->serial_cat_titleOriginal;
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
	#endregion

}

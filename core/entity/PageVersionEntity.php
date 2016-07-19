<?php
/*************
* Třída PageVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
abstract class PageVersionEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["lang_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "Language");
		$this->metadata["page_id"] = array("type" => "int(11)","default" => "NOT NULL");
		$this->metadata["user_id"] = array("type" => "int(11)","default" => "NULL","reference" => "User");
		$this->metadata["version"] = array("type" => "int(11)","default" => "0","index" => "1");
		$this->metadata["category_id"] = array("type" => "int(11)","default" => "NULL","reference" => "Category");
		$this->metadata["title"] = array("type" => "varchar(255)","default" => "NOT NULL");
		$this->metadata["description"] = array("type" => "longtext");
		$this->metadata["perex"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["pagetitle"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["pagedescription"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["pagekeywords"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["tags"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["url"] = array("type" => "varchar(255)","default" => "NULL","index" => "1");
	}
	#endregion

	#region Property
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
	protected $langLanguageEntity;

	// int(11)
	protected $page_id;

	protected $page_idOriginal;
	// int(11)
	protected $user_id = NULL;
	protected $user_idOriginal = NULL;

	protected $userUserEntity;

	// int(11)
	protected $version = 0;
	protected $versionOriginal = 0;

	// int(11)
	protected $category_id = NULL;
	protected $category_idOriginal = NULL;

	protected $categoryCategoryEntity;

	// varchar(255)
	protected $title;

	protected $titleOriginal;
	// longtext
	protected $description;

	protected $descriptionOriginal;
	// varchar(255)
	protected $perex = NULL;
	protected $perexOriginal = NULL;

	// varchar(255)
	protected $pagetitle = NULL;
	protected $pagetitleOriginal = NULL;

	// varchar(255)
	protected $pagedescription = NULL;
	protected $pagedescriptionOriginal = NULL;

	// varchar(255)
	protected $pagekeywords = NULL;
	protected $pagekeywordsOriginal = NULL;

	// varchar(255)
	protected $tags = NULL;
	protected $tagsOriginal = NULL;

	// varchar(255)
	protected $url = NULL;
	protected $urlOriginal = NULL;

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
	// Setter version
	protected function setVersion($value)
	{
		if (isInt($value) || is_null($value)) { $this->version = $value; }
	}
	// Getter version
	public function getVersion()
	{
		return $this->version;
	}
	// Getter versionOriginal
	public function getVersionOriginal()
	{
		return $this->versionOriginal;
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
	// Setter perex
	protected function setPerex($value)
	{
		$this->perex = $value;
	}
	// Getter perex
	public function getPerex()
	{
		return $this->perex;
	}
	// Getter perexOriginal
	public function getPerexOriginal()
	{
		return $this->perexOriginal;
	}
	// Setter pagetitle
	protected function setPagetitle($value)
	{
		$this->pagetitle = $value;
	}
	// Getter pagetitle
	public function getPagetitle()
	{
		return $this->pagetitle;
	}
	// Getter pagetitleOriginal
	public function getPagetitleOriginal()
	{
		return $this->pagetitleOriginal;
	}
	// Setter pagedescription
	protected function setPagedescription($value)
	{
		$this->pagedescription = $value;
	}
	// Getter pagedescription
	public function getPagedescription()
	{
		return $this->pagedescription;
	}
	// Getter pagedescriptionOriginal
	public function getPagedescriptionOriginal()
	{
		return $this->pagedescriptionOriginal;
	}
	// Setter pagekeywords
	protected function setPagekeywords($value)
	{
		$this->pagekeywords = $value;
	}
	// Getter pagekeywords
	public function getPagekeywords()
	{
		return $this->pagekeywords;
	}
	// Getter pagekeywordsOriginal
	public function getPagekeywordsOriginal()
	{
		return $this->pagekeywordsOriginal;
	}
	// Setter tags
	protected function setTags($value)
	{
		$this->tags = $value;
	}
	// Getter tags
	public function getTags()
	{
		return $this->tags;
	}
	// Getter tagsOriginal
	public function getTagsOriginal()
	{
		return $this->tagsOriginal;
	}
	// Setter url
	protected function setUrl($value)
	{
		$this->url = $value;
	}
	// Getter url
	public function getUrl()
	{
		return $this->url;
	}
	// Getter urlOriginal
	public function getUrlOriginal()
	{
		return $this->urlOriginal;
	}
	#endregion

}

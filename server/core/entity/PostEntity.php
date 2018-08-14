<?php
/*************
* Třída PostEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("PageEntity.php");
class PostEntity extends PageEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_articles";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_articles";
		$this->metadata["PublicDate"] = array("type" => "datetime");
		$this->metadata["PublicDate_end"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["logo_url"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["source_url"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["source_id"] = array("type" => "varchar(255)","default" => "NULL");
	}
	#endregion

	#region Property
	// datetime
	protected $PublicDate;

	protected $PublicDateOriginal;
	// datetime
	protected $PublicDate_end = NULL;
	protected $PublicDate_endOriginal = NULL;

	// varchar(255)
	protected $logo_url = NULL;
	protected $logo_urlOriginal = NULL;

	// varchar(255)
	protected $source_url = NULL;
	protected $source_urlOriginal = NULL;

	// varchar(255)
	protected $source_id = NULL;
	protected $source_idOriginal = NULL;

	#endregion

	#region Method
	// Setter PublicDate
	protected function setPublicDate($value)
	{
		$this->PublicDate = strToDatetime($value);
	}
	// Getter PublicDate
	public function getPublicDate()
	{
		return $this->PublicDate;
	}
	// Getter PublicDateOriginal
	public function getPublicDateOriginal()
	{
		return $this->PublicDateOriginal;
	}
	// Setter PublicDate_end
	protected function setPublicDate_end($value)
	{
		$this->PublicDate_end = strToDatetime($value);
	}
	// Getter PublicDate_end
	public function getPublicDate_end()
	{
		return $this->PublicDate_end;
	}
	// Getter PublicDate_endOriginal
	public function getPublicDate_endOriginal()
	{
		return $this->PublicDate_endOriginal;
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
	// Setter source_url
	protected function setSource_url($value)
	{
		$this->source_url = $value;
	}
	// Getter source_url
	public function getSource_url()
	{
		return $this->source_url;
	}
	// Getter source_urlOriginal
	public function getSource_urlOriginal()
	{
		return $this->source_urlOriginal;
	}
	// Setter source_id
	protected function setSource_id($value)
	{
		$this->source_id = $value;
	}
	// Getter source_id
	public function getSource_id()
	{
		return $this->source_id;
	}
	// Getter source_idOriginal
	public function getSource_idOriginal()
	{
		return $this->source_idOriginal;
	}
	#endregion

}

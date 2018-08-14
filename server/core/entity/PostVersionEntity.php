<?php
/*************
* Třída PostVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("PageVersionEntity.php");
class PostVersionEntity extends PageVersionEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_articles_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_articles_version";
		$this->metadata["page_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "Post");
	}
	#endregion

	#region Property
	// int(11)
	protected $page_id;

	protected $page_idOriginal;
	protected $pagePostEntity;

	#endregion

	#region Method
	// Setter page_id
	protected function setPage_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->page_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->pagePostEntity = new PostEntity($value,false);
		} else {
			$this->pagePostEntity = null;
		}
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
	#endregion

}

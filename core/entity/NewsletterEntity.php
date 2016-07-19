<?php
/*************
* Třída NewsletterEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class NewsletterEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_newsletter";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_newsletter";
		$this->metadata["html"] = array("type" => "longtext","default" => "null");
		$this->metadata["html_footer"] = array("type" => "longtext","default" => "null");
	}
	#endregion

	#region Property
	// longtext
	protected $html = null;
	protected $htmlOriginal = null;

	// longtext
	protected $html_footer = null;
	protected $html_footerOriginal = null;

	#endregion

	#region Method
	// Setter html
	protected function setHtml($value)
	{
		$this->html = $value;
	}
	// Getter html
	public function getHtml()
	{
		return $this->html;
	}
	// Getter htmlOriginal
	public function getHtmlOriginal()
	{
		return $this->htmlOriginal;
	}
	// Setter html_footer
	protected function setHtml_footer($value)
	{
		$this->html_footer = $value;
	}
	// Getter html_footer
	public function getHtml_footer()
	{
		return $this->html_footer;
	}
	// Getter html_footerOriginal
	public function getHtml_footerOriginal()
	{
		return $this->html_footerOriginal;
	}
	#endregion

}

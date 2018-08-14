<?php
/*************
* Třída LanguageEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class LanguageEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_language";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_language";
		$this->metadata["code"] = array("type" => "varchar(2)");
		$this->metadata["currency"] = array("type" => "varchar(3)");
		$this->metadata["kurz"] = array("type" => "decimal(8,3)","default" => "1");
		$this->metadata["active"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["content_language"] = array("type" => "varchar(10)");
	}
	#endregion

	#region Property
	// varchar(2)
	protected $code;

	protected $codeOriginal;
	// varchar(3)
	protected $currency;

	protected $currencyOriginal;
	// decimal(8,3)
	protected $kurz = 1;
	protected $kurzOriginal = 1;

	// tinyint(1)
	protected $active = 0;
	protected $activeOriginal = 0;

	// varchar(10)
	protected $content_language;

	protected $content_languageOriginal;
	#endregion

	#region Method
	// Setter code
	protected function setCode($value)
	{
		$this->code = $value;
	}
	// Getter code
	public function getCode()
	{
		return $this->code;
	}
	// Getter codeOriginal
	public function getCodeOriginal()
	{
		return $this->codeOriginal;
	}
	// Setter currency
	protected function setCurrency($value)
	{
		$this->currency = $value;
	}
	// Getter currency
	public function getCurrency()
	{
		return $this->currency;
	}
	// Getter currencyOriginal
	public function getCurrencyOriginal()
	{
		return $this->currencyOriginal;
	}
	// Setter kurz
	protected function setKurz($value)
	{
		if (is_null($value)) { return; }
		$this->kurz = strToNumeric($value);
	}
	// Getter kurz
	public function getKurz()
	{
		return $this->kurz;
	}
	// Getter kurzOriginal
	public function getKurzOriginal()
	{
		return $this->kurzOriginal;
	}
	// Setter active
	protected function setActive($value)
	{
		$this->active = $value;
	}
	// Getter active
	public function getActive()
	{
		return $this->active;
	}
	// Getter activeOriginal
	public function getActiveOriginal()
	{
		return $this->activeOriginal;
	}
	// Setter content_language
	protected function setContent_language($value)
	{
		$this->content_language = $value;
	}
	// Getter content_language
	public function getContent_language()
	{
		return $this->content_language;
	}
	// Getter content_languageOriginal
	public function getContent_languageOriginal()
	{
		return $this->content_languageOriginal;
	}
	#endregion

}

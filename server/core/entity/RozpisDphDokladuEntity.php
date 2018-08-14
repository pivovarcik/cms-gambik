<?php
/*************
* Třída RozpisDphDokladuEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
abstract class RozpisDphDokladuEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["tax_id"] = array("type" => "int");
		$this->metadata["doklad_id"] = array("type" => "int","default" => "NULL");
		$this->metadata["zaklad_dph"] = array("type" => "numeric(12,2)");
		$this->metadata["vyse_dph"] = array("type" => "numeric(12,2)");
	}
	#endregion

	#region Property
	// int
	protected $tax_id;

	protected $tax_idOriginal;
	// int
	protected $doklad_id = NULL;
	protected $doklad_idOriginal = NULL;

	// numeric(12,2)
	protected $zaklad_dph;

	protected $zaklad_dphOriginal;
	// numeric(12,2)
	protected $vyse_dph;

	protected $vyse_dphOriginal;
	#endregion

	#region Method
	// Setter tax_id
	protected function setTax_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->tax_id = $value; }
	}
	// Getter tax_id
	public function getTax_id()
	{
		return $this->tax_id;
	}
	// Getter tax_idOriginal
	public function getTax_idOriginal()
	{
		return $this->tax_idOriginal;
	}
	// Setter doklad_id
	protected function setDoklad_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->doklad_id = $value; }
	}
	// Getter doklad_id
	public function getDoklad_id()
	{
		return $this->doklad_id;
	}
	// Getter doklad_idOriginal
	public function getDoklad_idOriginal()
	{
		return $this->doklad_idOriginal;
	}
	// Setter zaklad_dph
	protected function setZaklad_dph($value)
	{
		$this->zaklad_dph = strToNumeric($value);
	}
	// Getter zaklad_dph
	public function getZaklad_dph()
	{
		return $this->zaklad_dph;
	}
	// Getter zaklad_dphOriginal
	public function getZaklad_dphOriginal()
	{
		return $this->zaklad_dphOriginal;
	}
	// Setter vyse_dph
	protected function setVyse_dph($value)
	{
		$this->vyse_dph = strToNumeric($value);
	}
	// Getter vyse_dph
	public function getVyse_dph()
	{
		return $this->vyse_dph;
	}
	// Getter vyse_dphOriginal
	public function getVyse_dphOriginal()
	{
		return $this->vyse_dphOriginal;
	}
	#endregion

}

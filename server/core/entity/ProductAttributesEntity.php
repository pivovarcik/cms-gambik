<?php
/*************
* Třída ProductAttributesEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class ProductAttributesEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_attributes";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_attributes";
		$this->metadata["pohoda_id"] = array("type" => "int(11)");
		$this->metadata["public_filter"] = array("type" => "tinyint(1)");
		$this->metadata["multi_select"] = array("type" => "tinyint(1)");
		$this->metadata["secret"] = array("type" => "tinyint(1)","default" => "0");
	}
	#endregion

	#region Property
	// int(11)
	protected $pohoda_id;

	protected $pohoda_idOriginal;
	// tinyint(1)
	protected $public_filter;

	protected $public_filterOriginal;
	// tinyint(1)
	protected $multi_select;

	protected $multi_selectOriginal;
	// tinyint(1)
	protected $secret = 0;
	protected $secretOriginal = 0;

	#endregion

	#region Method
	// Setter pohoda_id
	protected function setPohoda_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->pohoda_id = $value; }
	}
	// Getter pohoda_id
	public function getPohoda_id()
	{
		return $this->pohoda_id;
	}
	// Getter pohoda_idOriginal
	public function getPohoda_idOriginal()
	{
		return $this->pohoda_idOriginal;
	}
	// Setter public_filter
	protected function setPublic_filter($value)
	{
		$this->public_filter = $value;
	}
	// Getter public_filter
	public function getPublic_filter()
	{
		return $this->public_filter;
	}
	// Getter public_filterOriginal
	public function getPublic_filterOriginal()
	{
		return $this->public_filterOriginal;
	}
	// Setter multi_select
	protected function setMulti_select($value)
	{
		$this->multi_select = $value;
	}
	// Getter multi_select
	public function getMulti_select()
	{
		return $this->multi_select;
	}
	// Getter multi_selectOriginal
	public function getMulti_selectOriginal()
	{
		return $this->multi_selectOriginal;
	}
	// Setter secret
	protected function setSecret($value)
	{
		$this->secret = $value;
	}
	// Getter secret
	public function getSecret()
	{
		return $this->secret;
	}
	// Getter secretOriginal
	public function getSecretOriginal()
	{
		return $this->secretOriginal;
	}
	#endregion

}

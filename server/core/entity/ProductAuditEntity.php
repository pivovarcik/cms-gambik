<?php
/*************
* Třída ProductAuditEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProductAuditEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_products_audit";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_products_audit";
		$this->metadata["product_id"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["ip_adresa"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["user_id"] = array("type" => "int(11)","default" => "NULL");
	}
	#endregion

	#region Property
	// int(11)
	protected $product_id = NULL;
	protected $product_idOriginal = NULL;

	// varchar(25)
	protected $ip_adresa = NULL;
	protected $ip_adresaOriginal = NULL;

	// int(11)
	protected $user_id = NULL;
	protected $user_idOriginal = NULL;

	#endregion

	#region Method
	// Setter product_id
	protected function setProduct_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->product_id = $value; }
	}
	// Getter product_id
	public function getProduct_id()
	{
		return $this->product_id;
	}
	// Getter product_idOriginal
	public function getProduct_idOriginal()
	{
		return $this->product_idOriginal;
	}
	// Setter ip_adresa
	protected function setIp_adresa($value)
	{
		$this->ip_adresa = $value;
	}
	// Getter ip_adresa
	public function getIp_adresa()
	{
		return $this->ip_adresa;
	}
	// Getter ip_adresaOriginal
	public function getIp_adresaOriginal()
	{
		return $this->ip_adresaOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->user_id = $value; }
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
	#endregion

}

<?php
/*************
* Třída ProductFavoriteEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProductFavoriteEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_favorite";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_favorite";
		$this->metadata["product_id"] = array("type" => "int","default" => "null");
		$this->metadata["user_id"] = array("type" => "int","default" => "null");
		$this->metadata["ip_adresa"] = array("type" => "varchar(30)");
		$this->metadata["basket_id"] = array("type" => "varchar(50)","default" => "not null");
	}
	#endregion

	#region Property
	// int
	protected $product_id = null;
	protected $product_idOriginal = null;

	// int
	protected $user_id = null;
	protected $user_idOriginal = null;

	// varchar(30)
	protected $ip_adresa;

	protected $ip_adresaOriginal;
	// varchar(50)
	protected $basket_id;

	protected $basket_idOriginal;
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
	// Setter basket_id
	protected function setBasket_id($value)
	{
		$this->basket_id = $value;
	}
	// Getter basket_id
	public function getBasket_id()
	{
		return $this->basket_id;
	}
	// Getter basket_idOriginal
	public function getBasket_idOriginal()
	{
		return $this->basket_idOriginal;
	}
	#endregion

}

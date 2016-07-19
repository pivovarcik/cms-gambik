<?php
/*************
* Třída SlevoveKuponyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class SlevoveKuponyEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_kupony";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_kupony";
		$this->metadata["platnost"] = array("type" => "datetime");
		$this->metadata["typ_slevy"] = array("type" => "int");
		$this->metadata["sleva"] = array("type" => "numeric(12,2)");
		$this->metadata["customer_id"] = array("type" => "int");
		$this->metadata["pouzito"] = array("type" => "int","default" => "0");
	}
	#endregion

	#region Property
	// datetime
	protected $platnost;

	protected $platnostOriginal;
	// int
	protected $typ_slevy;

	protected $typ_slevyOriginal;
	// numeric(12,2)
	protected $sleva;

	protected $slevaOriginal;
	// int
	protected $customer_id;

	protected $customer_idOriginal;
	// int
	protected $pouzito = 0;
	protected $pouzitoOriginal = 0;

	#endregion

	#region Method
	// Setter platnost
	protected function setPlatnost($value)
	{
		$this->platnost = strToDatetime($value);
	}
	// Getter platnost
	public function getPlatnost()
	{
		return $this->platnost;
	}
	// Getter platnostOriginal
	public function getPlatnostOriginal()
	{
		return $this->platnostOriginal;
	}
	// Setter typ_slevy
	protected function setTyp_slevy($value)
	{
		if (isInt($value) || is_null($value)) { $this->typ_slevy = $value; }
	}
	// Getter typ_slevy
	public function getTyp_slevy()
	{
		return $this->typ_slevy;
	}
	// Getter typ_slevyOriginal
	public function getTyp_slevyOriginal()
	{
		return $this->typ_slevyOriginal;
	}
	// Setter sleva
	protected function setSleva($value)
	{
		$this->sleva = $value;
	}
	// Getter sleva
	public function getSleva()
	{
		return $this->sleva;
	}
	// Getter slevaOriginal
	public function getSlevaOriginal()
	{
		return $this->slevaOriginal;
	}
	// Setter customer_id
	protected function setCustomer_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->customer_id = $value; }
	}
	// Getter customer_id
	public function getCustomer_id()
	{
		return $this->customer_id;
	}
	// Getter customer_idOriginal
	public function getCustomer_idOriginal()
	{
		return $this->customer_idOriginal;
	}
	// Setter pouzito
	protected function setPouzito($value)
	{
		if (isInt($value) || is_null($value)) { $this->pouzito = $value; }
	}
	// Getter pouzito
	public function getPouzito()
	{
		return $this->pouzito;
	}
	// Getter pouzitoOriginal
	public function getPouzitoOriginal()
	{
		return $this->pouzitoOriginal;
	}
	#endregion

}

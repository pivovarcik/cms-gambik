<?php
/*************
* Třída FakturaEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("DokladEntity.php");
class FakturaEntity extends DokladEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_faktury";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_faktury";
		$this->metadata["order_code"] = array("type" => "varchar(50)");
		$this->metadata["duzp_date"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["maturity_date"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["faktura_date"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["pay_date"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["pay_account"] = array("type" => "varchar(150)","default" => "NULL");
		$this->metadata["amount_paid"] = array("type" => "decimal(8,2)","default" => "NULL");
		$this->metadata["faktura_type_id"] = array("type" => "int(11)","default" => "NULL","reference" => "TypyFaktur");
		$this->metadata["order_id"] = array("type" => "int(11)","default" => "NULL");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $order_code;

	protected $order_codeOriginal;
	// datetime
	protected $duzp_date = NULL;
	protected $duzp_dateOriginal = NULL;

	// datetime
	protected $maturity_date = NULL;
	protected $maturity_dateOriginal = NULL;

	// datetime
	protected $faktura_date = NULL;
	protected $faktura_dateOriginal = NULL;

	// datetime
	protected $pay_date = NULL;
	protected $pay_dateOriginal = NULL;

	// varchar(150)
	protected $pay_account = NULL;
	protected $pay_accountOriginal = NULL;

	// decimal(8,2)
	protected $amount_paid = NULL;
	protected $amount_paidOriginal = NULL;

	// int(11)
	protected $faktura_type_id = NULL;
	protected $faktura_type_idOriginal = NULL;

	protected $faktura_typeTypyFakturEntity;

	// int(11)
	protected $order_id = NULL;
	protected $order_idOriginal = NULL;

	#endregion

	#region Method
	// Setter order_code
	protected function setOrder_code($value)
	{
		$this->order_code = $value;
	}
	// Getter order_code
	public function getOrder_code()
	{
		return $this->order_code;
	}
	// Getter order_codeOriginal
	public function getOrder_codeOriginal()
	{
		return $this->order_codeOriginal;
	}
	// Setter duzp_date
	protected function setDuzp_date($value)
	{
		$this->duzp_date = strToDatetime($value);
	}
	// Getter duzp_date
	public function getDuzp_date()
	{
		return $this->duzp_date;
	}
	// Getter duzp_dateOriginal
	public function getDuzp_dateOriginal()
	{
		return $this->duzp_dateOriginal;
	}
	// Setter maturity_date
	protected function setMaturity_date($value)
	{
		$this->maturity_date = strToDatetime($value);
	}
	// Getter maturity_date
	public function getMaturity_date()
	{
		return $this->maturity_date;
	}
	// Getter maturity_dateOriginal
	public function getMaturity_dateOriginal()
	{
		return $this->maturity_dateOriginal;
	}
	// Setter faktura_date
	protected function setFaktura_date($value)
	{
		$this->faktura_date = strToDatetime($value);
	}
	// Getter faktura_date
	public function getFaktura_date()
	{
		return $this->faktura_date;
	}
	// Getter faktura_dateOriginal
	public function getFaktura_dateOriginal()
	{
		return $this->faktura_dateOriginal;
	}
	// Setter pay_date
	protected function setPay_date($value)
	{
		$this->pay_date = strToDatetime($value);
	}
	// Getter pay_date
	public function getPay_date()
	{
		return $this->pay_date;
	}
	// Getter pay_dateOriginal
	public function getPay_dateOriginal()
	{
		return $this->pay_dateOriginal;
	}
	// Setter pay_account
	protected function setPay_account($value)
	{
		$this->pay_account = $value;
	}
	// Getter pay_account
	public function getPay_account()
	{
		return $this->pay_account;
	}
	// Getter pay_accountOriginal
	public function getPay_accountOriginal()
	{
		return $this->pay_accountOriginal;
	}
	// Setter amount_paid
	protected function setAmount_paid($value)
	{
		$this->amount_paid = strToNumeric($value);
	}
	// Getter amount_paid
	public function getAmount_paid()
	{
		return $this->amount_paid;
	}
	// Getter amount_paidOriginal
	public function getAmount_paidOriginal()
	{
		return $this->amount_paidOriginal;
	}
	// Setter faktura_type_id
	protected function setFaktura_type_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->faktura_type_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->faktura_typeTypyFakturEntity = new TypyFakturEntity($value,false);
		} else {
			$this->faktura_typeTypyFakturEntity = null;
		}
	}
	// Getter faktura_type_id
	public function getFaktura_type_id()
	{
		return $this->faktura_type_id;
	}
	// Getter faktura_type_idOriginal
	public function getFaktura_type_idOriginal()
	{
		return $this->faktura_type_idOriginal;
	}
	// Setter order_id
	protected function setOrder_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->order_id = $value; }
	}
	// Getter order_id
	public function getOrder_id()
	{
		return $this->order_id;
	}
	// Getter order_idOriginal
	public function getOrder_idOriginal()
	{
		return $this->order_idOriginal;
	}
	#endregion

}

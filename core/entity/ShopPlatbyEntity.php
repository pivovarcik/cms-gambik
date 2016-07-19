<?php
/*************
* Třída ShopPlatbyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class ShopPlatbyEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_platby";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_platby";
		$this->metadata["code"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["amount"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["method"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["status"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["label"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["transId"] = array("type" => "varchar(50)","default" => "NULL");
	}
	#endregion

	#region Property
	// varchar(25)
	protected $code = NULL;
	protected $codeOriginal = NULL;

	// decimal(10,2)
	protected $amount = NULL;
	protected $amountOriginal = NULL;

	// varchar(25)
	protected $method = NULL;
	protected $methodOriginal = NULL;

	// varchar(25)
	protected $status = NULL;
	protected $statusOriginal = NULL;

	// varchar(50)
	protected $label = NULL;
	protected $labelOriginal = NULL;

	// varchar(50)
	protected $transId = NULL;
	protected $transIdOriginal = NULL;

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
	// Setter amount
	protected function setAmount($value)
	{
		$this->amount = strToNumeric($value);
	}
	// Getter amount
	public function getAmount()
	{
		return $this->amount;
	}
	// Getter amountOriginal
	public function getAmountOriginal()
	{
		return $this->amountOriginal;
	}
	// Setter method
	protected function setMethod($value)
	{
		$this->method = $value;
	}
	// Getter method
	public function getMethod()
	{
		return $this->method;
	}
	// Getter methodOriginal
	public function getMethodOriginal()
	{
		return $this->methodOriginal;
	}
	// Setter status
	protected function setStatus($value)
	{
		$this->status = $value;
	}
	// Getter status
	public function getStatus()
	{
		return $this->status;
	}
	// Getter statusOriginal
	public function getStatusOriginal()
	{
		return $this->statusOriginal;
	}
	// Setter label
	protected function setLabel($value)
	{
		$this->label = $value;
	}
	// Getter label
	public function getLabel()
	{
		return $this->label;
	}
	// Getter labelOriginal
	public function getLabelOriginal()
	{
		return $this->labelOriginal;
	}
	// Setter transId
	protected function setTransId($value)
	{
		$this->transId = $value;
	}
	// Getter transId
	public function getTransId()
	{
		return $this->transId;
	}
	// Getter transIdOriginal
	public function getTransIdOriginal()
	{
		return $this->transIdOriginal;
	}
	#endregion

}

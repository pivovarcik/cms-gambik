<?php
/*************
* Třída HeurekaReportEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class HeurekaReportEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_heureka_report";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_heureka_report";
		$this->metadata["name"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["summary"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["plus"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["minus"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["rating_id"] = array("type" => "int","default" => "null");
		$this->metadata["order_code"] = array("type" => "varchar(25)","default" => "null");
		$this->metadata["order_id"] = array("type" => "int","default" => "null");
		$this->metadata["total_rating"] = array("type" => "float");
		$this->metadata["delivery_time"] = array("type" => "float");
		$this->metadata["transport_quality"] = array("type" => "float");
		$this->metadata["web_usability"] = array("type" => "float");
		$this->metadata["communication"] = array("type" => "float");
		$this->metadata["report_timestamp"] = array("type" => "datetime");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $name = NULL;
	protected $nameOriginal = NULL;

	// varchar(255)
	protected $summary = NULL;
	protected $summaryOriginal = NULL;

	// varchar(255)
	protected $plus = NULL;
	protected $plusOriginal = NULL;

	// varchar(255)
	protected $minus = NULL;
	protected $minusOriginal = NULL;

	// int
	protected $rating_id = null;
	protected $rating_idOriginal = null;

	// varchar(25)
	protected $order_code = null;
	protected $order_codeOriginal = null;

	// int
	protected $order_id = null;
	protected $order_idOriginal = null;

	// float
	protected $total_rating;

	protected $total_ratingOriginal;
	// float
	protected $delivery_time;

	protected $delivery_timeOriginal;
	// float
	protected $transport_quality;

	protected $transport_qualityOriginal;
	// float
	protected $web_usability;

	protected $web_usabilityOriginal;
	// float
	protected $communication;

	protected $communicationOriginal;
	// datetime
	protected $report_timestamp;

	protected $report_timestampOriginal;
	#endregion

	#region Method
	// Setter name
	protected function setName($value)
	{
		$this->name = $value;
	}
	// Getter name
	public function getName()
	{
		return $this->name;
	}
	// Getter nameOriginal
	public function getNameOriginal()
	{
		return $this->nameOriginal;
	}
	// Setter summary
	protected function setSummary($value)
	{
		$this->summary = $value;
	}
	// Getter summary
	public function getSummary()
	{
		return $this->summary;
	}
	// Getter summaryOriginal
	public function getSummaryOriginal()
	{
		return $this->summaryOriginal;
	}
	// Setter plus
	protected function setPlus($value)
	{
		$this->plus = $value;
	}
	// Getter plus
	public function getPlus()
	{
		return $this->plus;
	}
	// Getter plusOriginal
	public function getPlusOriginal()
	{
		return $this->plusOriginal;
	}
	// Setter minus
	protected function setMinus($value)
	{
		$this->minus = $value;
	}
	// Getter minus
	public function getMinus()
	{
		return $this->minus;
	}
	// Getter minusOriginal
	public function getMinusOriginal()
	{
		return $this->minusOriginal;
	}
	// Setter rating_id
	protected function setRating_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->rating_id = $value; }
	}
	// Getter rating_id
	public function getRating_id()
	{
		return $this->rating_id;
	}
	// Getter rating_idOriginal
	public function getRating_idOriginal()
	{
		return $this->rating_idOriginal;
	}
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
	// Setter total_rating
	protected function setTotal_rating($value)
	{
		$this->total_rating = strToNumeric($value);
	}
	// Getter total_rating
	public function getTotal_rating()
	{
		return $this->total_rating;
	}
	// Getter total_ratingOriginal
	public function getTotal_ratingOriginal()
	{
		return $this->total_ratingOriginal;
	}
	// Setter delivery_time
	protected function setDelivery_time($value)
	{
		$this->delivery_time = strToNumeric($value);
	}
	// Getter delivery_time
	public function getDelivery_time()
	{
		return $this->delivery_time;
	}
	// Getter delivery_timeOriginal
	public function getDelivery_timeOriginal()
	{
		return $this->delivery_timeOriginal;
	}
	// Setter transport_quality
	protected function setTransport_quality($value)
	{
		$this->transport_quality = strToNumeric($value);
	}
	// Getter transport_quality
	public function getTransport_quality()
	{
		return $this->transport_quality;
	}
	// Getter transport_qualityOriginal
	public function getTransport_qualityOriginal()
	{
		return $this->transport_qualityOriginal;
	}
	// Setter web_usability
	protected function setWeb_usability($value)
	{
		$this->web_usability = strToNumeric($value);
	}
	// Getter web_usability
	public function getWeb_usability()
	{
		return $this->web_usability;
	}
	// Getter web_usabilityOriginal
	public function getWeb_usabilityOriginal()
	{
		return $this->web_usabilityOriginal;
	}
	// Setter communication
	protected function setCommunication($value)
	{
		$this->communication = strToNumeric($value);
	}
	// Getter communication
	public function getCommunication()
	{
		return $this->communication;
	}
	// Getter communicationOriginal
	public function getCommunicationOriginal()
	{
		return $this->communicationOriginal;
	}
	// Setter report_timestamp
	protected function setReport_timestamp($value)
	{
		$this->report_timestamp = strToDatetime($value);
	}
	// Getter report_timestamp
	public function getReport_timestamp()
	{
		return $this->report_timestamp;
	}
	// Getter report_timestampOriginal
	public function getReport_timestampOriginal()
	{
		return $this->report_timestampOriginal;
	}
	#endregion

}

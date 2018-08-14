<?php
/*************
* Třída LogSearchEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class LogSearchEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_logsearch";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_logsearch";
		$this->metadata["ip"] = array("type" => "varchar(50)");
		$this->metadata["search"] = array("type" => "varchar(100)");
		$this->metadata["form"] = array("type" => "varchar(50)");
		$this->metadata["results"] = array("type" => "int");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $ip;

	protected $ipOriginal;
	// varchar(100)
	protected $search;

	protected $searchOriginal;
	// varchar(50)
	protected $form;

	protected $formOriginal;
	// int
	protected $results;

	protected $resultsOriginal;
	#endregion

	#region Method
	// Setter ip
	protected function setIp($value)
	{
		$this->ip = $value;
	}
	// Getter ip
	public function getIp()
	{
		return $this->ip;
	}
	// Getter ipOriginal
	public function getIpOriginal()
	{
		return $this->ipOriginal;
	}
	// Setter search
	protected function setSearch($value)
	{
		$this->search = $value;
	}
	// Getter search
	public function getSearch()
	{
		return $this->search;
	}
	// Getter searchOriginal
	public function getSearchOriginal()
	{
		return $this->searchOriginal;
	}
	// Setter form
	protected function setForm($value)
	{
		$this->form = $value;
	}
	// Getter form
	public function getForm()
	{
		return $this->form;
	}
	// Getter formOriginal
	public function getFormOriginal()
	{
		return $this->formOriginal;
	}
	// Setter results
	protected function setResults($value)
	{
		if (isInt($value) || is_null($value)) { $this->results = $value; }
	}
	// Getter results
	public function getResults()
	{
		return $this->results;
	}
	// Getter resultsOriginal
	public function getResultsOriginal()
	{
		return $this->resultsOriginal;
	}
	#endregion

}

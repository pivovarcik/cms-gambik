<?php

abstract class DataPicker {

	protected $modelName;

	protected $columnName;
	protected $columnLabel = "";
	protected $columnNameId;

	protected $columnLikeName;
	protected $page;
	protected $limit;
	protected $args;

	// jmeno parametru vracející hledaný řetězec z query
	protected $queryLikeName = "q";

	public function __construct($modelName, $args)
	{
		$this->modelName = "models_" . $modelName;
		$this->columnName = $args->columnName;
		$this->columnLabel = $args->columnLabel;
		$this->columnNameId = $args->columnNameId;

		$this->columnLikeName = "like_" . $this->columnName;
		if (isset($args->columnLikeName)) {
			$this->columnLikeName = $args->columnLikeName;
		}

		$this->page = 1;
		$this->limit = 10;
		if (isset($args->page)) {
			$this->page = (int) $args->page;
		}
		if (isset($args->limit)) {
			$this->limit = (int) $args->limit;
		} 
    
    $this->args = new ListArgs();
	}

  public function getArgs()
  {
      return  $this->args;
  }
  public function getRowData($obj)
  {
  
  }
	public function getData($page, $limit)
	{
		$columnNameLike = $this->columnLikeName;
		$columnNameId = $this->columnNameId;
		$columnName = $this->columnName;
		$columnLabel = $this->columnLabel;

		$model = new $this->modelName;
	//	$args = new ListArgs();
		$args = $this->args;

		$args->page = $page;
		$args->limit = $limit;
		$args->$columnNameLike = $_GET[$this->queryLikeName];
		$args->orderBy = $columnName;
		$list = $model->getList($args);

		$total = $model->total;
		//	print $model->getLastQuery();

		$data = array();

		$data["total_count"] = $model->total;

		$incomplete_results = true;
		if ($model->total == count($list)) {
			$incomplete_results = false;
		}
		$data["incomplete_results"] = $incomplete_results;

		$data["items"] = array();
		foreach ($list as $key => $row) {
      
			//PRINT_R($row);
			$obj = new stdClass();
			//	$obj->id = $row->id;
			//	$obj->value = $row->value;

			$obj->id = $row->$columnNameId;
			$obj->value = $row->$columnName;
      if (isset($row->$columnLabel)){
         $obj->label = $row->$columnLabel;
      }
      
      
      $this->getRowData($obj);
      
			array_push($data["items"], $obj);
		}

		return $data;
	}
}


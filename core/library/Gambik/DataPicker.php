<?php

abstract class DataPicker {

	protected $modelName;

	protected $columnName;
	protected $columnNameId;

	protected $columnLikeName;

	// jmeno parametru vracející hledaný řetězec z query
	protected $queryLikeName = "term";

	public function __construct($modelName, $args)
	{
		$this->modelName = "models_" . $modelName;
		$this->columnName = $args->columnName;
		$this->columnNameId = $args->columnNameId;

		$this->columnLikeName = "like_" . $this->columnName;
		if (isset($args->columnLikeName)) {
			$this->columnLikeName = $args->columnLikeName;
		}

	}


	public function getData()
	{
		$columnNameLike = $this->columnLikeName;
		$columnNameId = $this->columnNameId;
		$columnName = $this->columnName;

		$model = new $this->modelName;
		$args = new ListArgs();

		$args->page = 1;
		$args->limit = 100000;
		$args->$columnNameLike = $_GET[$this->queryLikeName];
		$args->orderBy = $columnName;
		$list = $model->getList($args);
		//	print $model->getLastQuery();

		$data = array();
		foreach ($list as $key => $row) {

			//PRINT_R($row);
			$obj = new stdClass();
			//	$obj->id = $row->id;
			//	$obj->value = $row->value;

			$obj->id = $row->$columnNameId;
			$obj->value = $row->$columnName;
			array_push($data, $obj);
		}

		return $data;
	}
}


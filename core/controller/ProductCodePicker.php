<?php


class ProductCodePicker extends DataPicker {


	public function __construct($modelName, $args)
	{
		$modelName = "Products";

		$args = new stdClass();

		$args->columnName = "code";
		$args->columnNameId = "code";

		parent::__construct($modelName, $args);

	}
}
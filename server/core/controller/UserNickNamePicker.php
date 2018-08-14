<?php



class UserNickNamePicker extends DataPicker {


	public function __construct()
	{
		$modelName = "Users";

		$args = new stdClass();

		$args->columnName = "nick";
		$args->columnNameId = "id";

		parent::__construct($modelName, $args);

	}
}
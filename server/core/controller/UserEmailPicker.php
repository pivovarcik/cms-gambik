<?php



class UserEmailPicker extends DataPicker {


	public function __construct()
	{
		$modelName = "Users";

		$args = new stdClass();

		$args->columnName = "email";
		$args->columnNameId = "email";

		parent::__construct($modelName, $args);

	}
}
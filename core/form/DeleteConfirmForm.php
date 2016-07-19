<?php
require_once("ConfirmForm.php");
// univerání potvrzovací formulář pro mazání
abstract class DeleteConfirmForm extends ConfirmForm
{

	function __construct($modelName, $page_id = null)
	{
		parent::__construct($modelName, $page_id);
	}
}


<?php
require_once("ConfirmForm.php");
// univerání potvrzovací formulář pro kopírování
abstract class CopyConfirmForm extends ConfirmForm
{

	function __construct($modelName, $page_id = null)
	{
		parent::__construct($modelName, $page_id);
	}
}
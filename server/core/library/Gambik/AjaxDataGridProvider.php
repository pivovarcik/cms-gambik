<?php

class AjaxDataGridProvider extends DataGridProvider {
	public function __construct($modelName, IListArgs $listArgs = null, $wrapper = false, $gridId)
	{
		$this->isAjaxTable = true;
		parent::__construct($modelName, $listArgs, $wrapper, $gridId);
	}
}
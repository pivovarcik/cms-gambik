<?php

class DataGridCommand {
	public $name;
	public $label;
	public $data_url;
	public $link;
	public function __construct($name){
		$this->name = $name;
	}
}

class EditDataGridCommandModal extends DataGridCommand {

	public function __construct($data_url = null){
		$this->name = "edit";
		$this->data_url = $data_url;
		$this->label = '<i class="fa fa-pencil"></i> editovat';
	}
}

class EditDataGridCommand extends DataGridCommand {

	public function __construct($link = null){
		$this->name = "edit";
		$this->link = $link;
		$this->label = '<i class="fa fa-pencil"></i> editovat';
	}
}

class DeleteDataGridCommand extends DataGridCommand {

	public function __construct($data_url = null){
		$this->name = "delete";
		$this->data_url = $data_url;
		$this->label = '<i class="fa fa-trash-o"></i> smazat';
	}
}

class CopyDataGridCommand extends DataGridCommand {

	public function __construct($data_url = null){
		$this->name = "copy";
		$this->data_url = $data_url;
		$this->label = '<i class="fa fa-files-o"></i> kopírovat';
	}
}

class PrintDataGridCommand extends DataGridCommand {

	public function __construct($link = null){
		$this->name = "print";
		$this->link = $link;
		$this->label = '<i class="fa fa-print"></i> tisk';
	}
}

class StornoDataGridCommand extends DataGridCommand {

	public function __construct($data_url = null){
		$this->name = "storno";
		$this->data_url = $data_url;
		$this->label = '<i class="fa fa-times"></i> stornovat';
	}
}



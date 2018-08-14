<?php
class EditDataGridCommandModal extends DataGridCommand {

	public function __construct($data_url = null){
		$this->name = "edit";
		$this->data_url = $data_url;
		$this->label = '<i class="fa fa-pencil"></i> editovat';
	}
}
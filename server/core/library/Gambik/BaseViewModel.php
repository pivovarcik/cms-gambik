<?php

abstract class BaseViewModel {

	public $pagetitle;
	public $pagedescription;
	public $formName;
	public $body;

	public function __construct()
	{
		$this->load();
	}
	protected function header(){}

	protected function footer(){}

	protected function body(){}

	protected function load(){

	}

	public function viewRender()
	{
		$res = '';
		$res .= $this->header();
		$res .= $this->body();
		$res .= $this->footer();
		return $res;
	}
}



?>
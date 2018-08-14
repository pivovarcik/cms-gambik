<?php

require_once("ListArgs.php");
class PageListArgs extends ListArgs{

	public $title = "";
	public function __construct()
	{
		parent::__construct();

		$name = "title";
		$this->$name = $this->request->getQuery($name, $this->$name);
	}
}

?>
<?php

class PageComposite{

  	public $pagetitle;
	public $pagedescription;
	public function __construct($page = null)
	{
		if ($page != null) {
			$this->pagetitle = $page->pagetitle;
			$this->pagedescription = $page->pagedescription;
		}
	}
}

?>
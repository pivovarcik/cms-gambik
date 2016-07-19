<?php

require_once("ProductListHtmlVypis.php");
class AkceProductListHtmlVypis extends ProductListHtmlVypis {

	public function __construct($radky, $page, $celkovyPocetRadku, $limitNaStranku)
	{
		parent::__construct($radky, $page, $celkovyPocetRadku, $limitNaStranku);
		$this->wrapClass = 'itemsList-akce';
	}
}
?>
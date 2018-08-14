<?php

require_once("ProductListHtmlVypis.php");
class AkceProductListHtmlVypis extends ProductListHtmlVypis {

	public function __construct($radky, $page, $celkovyPocetRadku, $limitNaStranku, $position)
	{
		if ($position == "RIGHT") {
			$this->itemClass = 'col-xs-12';
		}

		parent::__construct($radky, $page, $celkovyPocetRadku, $limitNaStranku);

		$this->wrapClass = 'itemsList-akce';

	}
}
?>
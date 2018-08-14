<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

require_once("RadekDokladu.php");
class models_RadekFaktury extends models_RadekDokladu{

	function __construct()
	{
		parent::__construct("Faktura", "RadekFaktury");
	}
}
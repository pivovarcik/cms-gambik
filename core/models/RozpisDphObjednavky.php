<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("RozpisDphDokladu.php");
class models_RozpisDphObjednavky extends models_RozpisDphDokladu{

	function __construct()
	{
		parent::__construct(T_ROZPIS_DPH_OBJEDNAVKY);
	}
}
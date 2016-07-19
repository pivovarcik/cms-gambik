<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ProductVyrobceController extends CiselnikBase
{

	function __construct()
	{
		parent::__construct("ProductVyrobce");
	}


	public function vyrobceList($params = array())
	{
		return parent::ciselnikList($params);
	}
}
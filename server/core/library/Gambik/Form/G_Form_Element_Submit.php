<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Form_Element_Submit extends G_Form_Element
{
	function __construct($name)
	{
		parent::__construct($name);
		$this->setIgnore(true);
	}
}
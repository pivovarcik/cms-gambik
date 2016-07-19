<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Form_Element_Datetime extends G_Form_Element
{
	function __construct($name)
	{
		parent::__construct($name);
		$this->setAttribs(array("date_format" => "d.m.yyyy HH:MM"));
	}
}
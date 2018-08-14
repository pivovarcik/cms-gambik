<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Form_Element_Password extends G_Form_Element
{
	function __construct($name)
	{
		parent::__construct($name);
		$this->setAttribs(array("dd_decorator" => "dd",
						"dt_decorator" => "dt",
						"dl_decorator" => "dl"));
	}
}
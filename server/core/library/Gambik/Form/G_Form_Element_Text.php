<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include "G_Form_Element.php";
//require_once("G_Form_Element.php");
class G_Form_Element_Text extends G_Form_Element
{
	function __construct($name, $namespace = null)
	{
		if (!is_null($namespace) && !empty($namespace)) {
			$name = $namespace . "[" . $name . "]";
		}
		parent::__construct($name);
	/*	$this->setAttribs(array("dd_decorator" => "dd",
								"dt_decorator" => "dt",
								"dl_decorator" => "dl",
								"placeholder" => "",
								));*/
	}
}
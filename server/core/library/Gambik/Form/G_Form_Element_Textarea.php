<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Form_Element_Textarea extends G_Form_Element
{
	function __construct($name, $namespace = null)
	{
		if (!is_null($namespace) && !empty($namespace)) {
			$name = $namespace . "[" . $name . "]";
		}

		parent::__construct($name);

		// defaultní hodnoty
		$this->setAttribs(array("cols" => "10"));
		$this->setAttribs(array("rows" => "3"));
		/*$this->setAttribs(array("dd_decorator" => "dd",
						"dt_decorator" => "dt",
						"dl_decorator" => "dl"));*/

	}
}
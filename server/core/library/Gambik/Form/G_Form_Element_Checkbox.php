<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Form_Element_Checkbox extends G_Form_Element
{
	// způsob zobrazení: 1 = checkbox vně labelu, 2 = checkbox vedle labelu
	public $viewType = 1;
	function __construct($name, $namespace = null)
	{
		if (!is_null($namespace) && !empty($namespace)) {
			$name = $namespace . "[" . $name . "]";
		}
		parent::__construct($name);
	}
}
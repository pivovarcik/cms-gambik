<?php


class G_Form_Element_Number extends G_Form_Element
{
	function __construct($name, $value = null, $namespace = null)
	{

		if (!is_null($namespace) && !empty($namespace)) {
			$name = $namespace . "[" . $name . "]";
		}
		parent::__construct($name, false, $value);

		$this->setNumeric();
	}
}
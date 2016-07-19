<?php


class G_Form_Element_Number extends G_Form_Element
{
	function __construct($name, $value)
	{
		parent::__construct($name, false, $value);

		$this->setNumeric();
	}
}
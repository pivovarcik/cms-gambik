<?php


class G_Form_Element_Email extends G_Form_Element
{
	function __construct($name, $value = null)
	{
		$this->setEmail();
		parent::__construct($name, false, $value);


	}
}
?>
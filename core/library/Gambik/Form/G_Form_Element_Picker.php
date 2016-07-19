<?php


class G_Form_Element_Picker extends G_Form_Element
{
	function __construct($name)
	{
		parent::__construct($name);

		array_push($this->attrib_list, "data-model");
		array_push($this->attrib_list, "data-col");
		array_push($this->attrib_list, "data-id");
		array_push($this->attrib_list, "value-alias");
		array_push($this->attrib_list, "data-picker");

	//	$this->setAttribs(array("data-model" => "10"));
	//	$this->setAttribs(array("rows" => "3"));
	}
}
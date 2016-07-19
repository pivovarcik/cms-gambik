<?php
/**
 * Definice základních funkcí na entitě
 *
 */

abstract class Template {


	public $_name = '';
	public $_primary = 'id';
	public $_attributtes = array();
	public $parent = 'Entity';
	public $path = '';
	public $metadata = array();

	function __construct()
	{



		/**/
	}

	public function addReference($attribute_name,$target_name)
	{
		if (isset($this->_attributtes[$attribute_name])) {
			$this->_attributtes[$attribute_name]["reference"] = $target_name;
		}
	}
}
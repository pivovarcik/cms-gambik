<?php
/**
 * Definice základních funkcí na entitě
 *
 */

require_once("Template.php");
class EntityTemplate extends Template {

	function __construct()
	{

		parent::__construct();
		$this->parent = 'AEntity';
		// veškeré entity budou mít atribut Id jako primární klíč
		$this->_attributtes["id"] = array("type" => "int(11)", "scope" => "public");

		$this->_attributtes["isDeleted"] = array("type" => "tinyint(1)", "default" => "0");

		// časová značka při založení entity
		$this->_attributtes["TimeStamp"] = array("type" => "datetime", "default" => "NULL", "scope" => "private");

		// časová značka změny v entitě
		$this->_attributtes["ChangeTimeStamp"] = array("type" => "datetime", "default" => "NULL", "scope" => "private");
	}
}
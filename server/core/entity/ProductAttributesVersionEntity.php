<?php
/*************
* Třída ProductAttributesVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProductAttributesVersionEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_attributes_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_attributes_version";
		$this->metadata["name"] = array("type" => "varchar(255)");
		$this->metadata["description"] = array("type" => "longtext");
		$this->metadata["lang_id"] = array("type" => "int(11)");
		$this->metadata["attrib_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "ProductAttributes");
	}
	#endregion

	#region Property
	// varchar(255)
	protected $name;

	protected $nameOriginal;
	// longtext
	protected $description;

	protected $descriptionOriginal;
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
	// int(11)
	protected $attrib_id;

	protected $attrib_idOriginal;
	protected $attribProductAttributesEntity;

	#endregion

	#region Method
	// Setter name
	protected function setName($value)
	{
		$this->name = $value;
	}
	// Getter name
	public function getName()
	{
		return $this->name;
	}
	// Getter nameOriginal
	public function getNameOriginal()
	{
		return $this->nameOriginal;
	}
	// Setter description
	protected function setDescription($value)
	{
		$this->description = $value;
	}
	// Getter description
	public function getDescription()
	{
		return $this->description;
	}
	// Getter descriptionOriginal
	public function getDescriptionOriginal()
	{
		return $this->descriptionOriginal;
	}
	// Setter lang_id
	protected function setLang_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->lang_id = $value; }
	}
	// Getter lang_id
	public function getLang_id()
	{
		return $this->lang_id;
	}
	// Getter lang_idOriginal
	public function getLang_idOriginal()
	{
		return $this->lang_idOriginal;
	}
	// Setter attrib_id
	protected function setAttrib_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->attrib_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->attribProductAttributesEntity = new ProductAttributesEntity($value,false);
		} else {
			$this->attribProductAttributesEntity = null;
		}
	}
	// Getter attrib_id
	public function getAttrib_id()
	{
		return $this->attrib_id;
	}
	// Getter attrib_idOriginal
	public function getAttrib_idOriginal()
	{
		return $this->attrib_idOriginal;
	}
	#endregion

}

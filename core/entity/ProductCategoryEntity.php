<?php
/*************
* Třída ProductCategoryEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class ProductCategoryEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_skupiny";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_skupiny";
		$this->metadata["cenik_id"] = array("type" => "int","default" => "NULL","reference" => "ProductCenik");
	}
	#endregion

	#region Property
	// int
	protected $cenik_id = NULL;
	protected $cenik_idOriginal = NULL;

	protected $cenikProductCenikEntity;

	#endregion

	#region Method
	// Setter cenik_id
	protected function setCenik_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->cenik_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->cenikProductCenikEntity = new ProductCenikEntity($value,false);
		} else {
			$this->cenikProductCenikEntity = null;
		}
	}
	// Getter cenik_id
	public function getCenik_id()
	{
		return $this->cenik_id;
	}
	// Getter cenik_idOriginal
	public function getCenik_idOriginal()
	{
		return $this->cenik_idOriginal;
	}
	#endregion

}

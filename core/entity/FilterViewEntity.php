<?php
/*************
* Třída FilterViewEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class FilterViewEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_filter_view";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_filter_view";
		$this->metadata["name"] = array("type" => "varchar(30)");
		$this->metadata["definition"] = array("type" => "longtext","default" => "NULL");
		$this->metadata["sorting"] = array("type" => "longtext","default" => "NULL");
		$this->metadata["modelname"] = array("type" => "varchar(30)");
		$this->metadata["user_id"] = array("type" => "int","default" => "NULL");
		$this->metadata["isDefault"] = array("type" => "int","default" => "0");
		$this->metadata["selected"] = array("type" => "tinyint","default" => "0");
		$this->metadata["show_head"] = array("type" => "tinyint","default" => "1");
		$this->metadata["show_foot"] = array("type" => "tinyint","default" => "1");
		$this->metadata["isSelectable"] = array("type" => "tinyint","default" => "1");
	}
	#endregion

	#region Property
	// varchar(30)
	protected $name;

	protected $nameOriginal;
	// longtext
	protected $definition = NULL;
	protected $definitionOriginal = NULL;

	// longtext
	protected $sorting = NULL;
	protected $sortingOriginal = NULL;

	// varchar(30)
	protected $modelname;

	protected $modelnameOriginal;
	// int
	protected $user_id = NULL;
	protected $user_idOriginal = NULL;

	// int
	protected $isDefault = 0;
	protected $isDefaultOriginal = 0;

	// tinyint
	protected $selected = 0;
	protected $selectedOriginal = 0;

	// tinyint
	protected $show_head = 1;
	protected $show_headOriginal = 1;

	// tinyint
	protected $show_foot = 1;
	protected $show_footOriginal = 1;

	// tinyint
	protected $isSelectable = 1;
	protected $isSelectableOriginal = 1;

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
	// Setter definition
	protected function setDefinition($value)
	{
		$this->definition = $value;
	}
	// Getter definition
	public function getDefinition()
	{
		return $this->definition;
	}
	// Getter definitionOriginal
	public function getDefinitionOriginal()
	{
		return $this->definitionOriginal;
	}
	// Setter sorting
	protected function setSorting($value)
	{
		$this->sorting = $value;
	}
	// Getter sorting
	public function getSorting()
	{
		return $this->sorting;
	}
	// Getter sortingOriginal
	public function getSortingOriginal()
	{
		return $this->sortingOriginal;
	}
	// Setter modelname
	protected function setModelname($value)
	{
		$this->modelname = $value;
	}
	// Getter modelname
	public function getModelname()
	{
		return $this->modelname;
	}
	// Getter modelnameOriginal
	public function getModelnameOriginal()
	{
		return $this->modelnameOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->user_id = $value; }
	}
	// Getter user_id
	public function getUser_id()
	{
		return $this->user_id;
	}
	// Getter user_idOriginal
	public function getUser_idOriginal()
	{
		return $this->user_idOriginal;
	}
	// Setter isDefault
	protected function setIsDefault($value)
	{
		if (isInt($value) || is_null($value)) { $this->isDefault = $value; }
	}
	// Getter isDefault
	public function getIsDefault()
	{
		return $this->isDefault;
	}
	// Getter isDefaultOriginal
	public function getIsDefaultOriginal()
	{
		return $this->isDefaultOriginal;
	}
	// Setter selected
	protected function setSelected($value)
	{
		$this->selected = $value;
	}
	// Getter selected
	public function getSelected()
	{
		return $this->selected;
	}
	// Getter selectedOriginal
	public function getSelectedOriginal()
	{
		return $this->selectedOriginal;
	}
	// Setter show_head
	protected function setShow_head($value)
	{
		$this->show_head = $value;
	}
	// Getter show_head
	public function getShow_head()
	{
		return $this->show_head;
	}
	// Getter show_headOriginal
	public function getShow_headOriginal()
	{
		return $this->show_headOriginal;
	}
	// Setter show_foot
	protected function setShow_foot($value)
	{
		$this->show_foot = $value;
	}
	// Getter show_foot
	public function getShow_foot()
	{
		return $this->show_foot;
	}
	// Getter show_footOriginal
	public function getShow_footOriginal()
	{
		return $this->show_footOriginal;
	}
	// Setter isSelectable
	protected function setIsSelectable($value)
	{
		$this->isSelectable = $value;
	}
	// Getter isSelectable
	public function getIsSelectable()
	{
		return $this->isSelectable;
	}
	// Getter isSelectableOriginal
	public function getIsSelectableOriginal()
	{
		return $this->isSelectableOriginal;
	}
	#endregion

}

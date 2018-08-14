<?php



class CategoryPicker extends DataPicker {


	public function __construct()
	{
		$modelName = "Category";

		$args = new stdClass();

		$args->columnName = "title";
		$args->columnLabel = "serial_cat_title";
		$args->columnNameId = "page_id";

		parent::__construct($modelName, $args);
    
    $args = $this->args;
    $args->lang = "cs";
    //$this->getArgs();
	}
  
  public function getRowData($obj)
  {
     parent::getRowData($obj);
     
     $obj->label = str_replace("|||","",$obj->label);
     $obj->label = str_replace("||","",$obj->label);
     
     $labelA = explode("|",$obj->label);
     $labelA2 = array();
     foreach ($labelA as $key=>$val)
     {
      if (!empty($val))
      {
         array_push($labelA2,trim($val));
      }
     }
     $obj->label = implode(">",$labelA2);
     
  }
}
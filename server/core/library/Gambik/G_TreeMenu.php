<?php



class Node {
	public $start_uroven;

	/**
	 * Pole obsahující kompletní list
	 * */
	public $list_A=array();
	public $select_uroven;
	public $vnoreni = 0;
	public $max_vnoreni=2;
	public $rozbalit=false;
	public $rozbalit_dalsi;
	public $isMenu;
	public $class_ul_selected="";
	public $class_ul_noselected="menu_hide";
	public $class_li_selected="";
	public $class_li_noselected="menu_hide";
	public $class_ul_root="";
	public $ignore_parent=array();
	public $selected_parent=array();
	public $id_ul = "";
}
class G_Tree2 {
	public $nodes = array();

	public $childTree = array();
	public function addNode($node)
	{
		array_push($this->nodes, $node);
	}
}
class G_TreeMenu {

	public $tree = array();
	function __construct($TEntita = "Category")
	{


		// načtu pouze jednou
		$modelName = "models_" . $TEntita;

		$viewName = "view_" . strtolower($TEntita);
		//		print $modelName;
		$category = new $modelName;
		$params = array();
		$params['lang'] = LANG_TRANSLATOR;
		$params['page'] = 1;
		$params['limit'] = 1000000;
		$params["order"] = "c.level DESC";
	//	$params["order"] = "c.c1, c.c2, c.c3, c.c4, c.c5, c.c6, c.c7, c.c8, c.c9, c.10, c.11, c.level DESC";
		$params['lite'] = true;
		//$this->completeStructureSite = $category->getList($params);

		$model = new G_Service("");
		$model->setLimit(1, $params['limit']);
		$model->setOrderBy($params['order'], "c.level DESC,c.title ASC,c.parent_id ASC");


		$select = "c.*,c.category_id as page_id, c.category_id as id,c.parent_id as category_id,c.level,c.title";
		$model->setSelect($select);

		$from = $viewName . " c LEFT JOIN " . T_LANGUAGE . " l on l.id=c.lang_id";


		$model->addWhere("l.code='".LANG_TRANSLATOR."'");

		$model->setFrom($from);
		$this->completeStructureSite = $model->getRows();

		$parentId = 1;
		$strom = new stdClass();
		$tree = new G_Tree();
		foreach ($this->completeStructureSite as $key => $row) {

			if ($row->parent_id == $parentId) {
				$tree->addNode($row->category_id);
			}


		}

		//	print $category->getLastQuery();
		//	print_r($this->completeStructureSite );
	}

	// řídí jeden průchod celou kolekcí,
	private function sestavTree($completeStructureSiteTemp,$treePredka)
	{

		if (count($completeStructureSiteTemp) == 0) {
			return;
		}
		$parentId = $completeStructureSiteTemp[0]->category_id;

		//$childTree
		$tree = new G_Tree();
		$tree->category_id = $parentId;
	//	$tree->addNode($row->category_id);
		unset($completeStructureSiteTemp[$i]);
		// zapamatuju si kolekci před promazáním
		//$completeStructureSiteTemp = $this->completeStructureSite;
		for ($i=0;$i<count($completeStructureSiteTemp);$i++) {

			$row = $completeStructureSiteTemp[$i];
			if ($row->parent_id == $parentId) {
				$tree->addNode($row->category_id);

				$treePotomka = new G_Tree();
				$treePotomka->category_id = $row->category_id;

				array_push($treePredka, $treePotomka);

				// odeber ho z listu
				unset($completeStructureSiteTemp[$i]);
			//	$strom->radek =
			}
		}

		//$this->sestavTree($completeStructureSiteTemp);
	}
	  private function getPageId($get_url)
	  {
	  	$model = new G_Service("");
	  	//$model->setLimit(1, $params['limit']);
	  	//	$model->setOrderBy($params['order'], "c.level DESC,c.title ASC,c.parent_id ASC");

	  	$select = "c.category_id";
	  	$model->setSelect($select);
	  	$from = $this->viewName . " c LEFT JOIN " . T_LANGUAGE . " l on l.id=c.lang_id";
	  	$model->setFrom($from);

	  	$model->addWhere("c.serial_cat_url like '%".$get_url."'");

	  	$row = $model->getRows();
	  	if (count($row) >0) {
	  		$this->page_id = $row[0]->category_id;
	  	}
	  }
}
/**
 * Tree menu , nahrazuje zastaralé get_tree+set_tree
 *
 */

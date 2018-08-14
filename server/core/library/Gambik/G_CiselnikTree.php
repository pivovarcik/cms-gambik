<?php


class G_CiselnikTree{
	/**
	 * Constructor
	 */
	private $model;
	function __construct($TCiselnikEntity){

		$name = "models_" . $TCiselnikEntity;
		$this->model = new $name;

	}
	private $data = array();


	public function categoryTree($params = array())
	{

		$this->data = array();
		$select = isset($params["select"]) ? $params["select"] : "";
		if (isset($params["pole"]) && is_array($params["pole"])) {
			$pole = $params["pole"];
		} else {
			$lang = '';
			$offset = '';
			$max_vnoreni = (isset($params["vnoreni"])) ? $params["vnoreni"] : 100;
			$limit = (isset($params["limit"])) ? $params["limit"] : 10000;
			$pole = $this->treeList();


		}
		//print_r($pole);

		$parent = isset($params["parent"]) ? $params["parent"] : null;
		$this->data = $this->webTree($pole, $parent,0,$max_vnoreni);
		/*
		   print "<pre>";
		   print_r($this->data);
		   print "</pre>";
		*/
		return $this->data;
	}
	public function isChild($pole, $select_id){
		$webTree = array();
		for ($i=0;$i<count($pole);$i++)
		{

			if ($pole[$i]->parent == $select_id)
			{
				$pole_temp = new stdClass();
				$pole_temp->id = $pole[$i]->id;
				$pole_temp->title = $pole[$i]->name;
				$pole_temp->category_id = $pole[$i]->parent;
				$pole_temp->level = $pole[$i]->order;
				array_push($webTree, $pole_temp);
			}
		}
		return $webTree;
	}
	public function webTree($pole, $select_id, $vnoreni = -1, $maxvnoreni = 200, $result = array()){

		if (count($result) > 0) {

		}

		$select_id = (int) $select_id;

		$searched_child = $this->isChild($pole, $select_id);

		//array_push($result, $result);
		if ( count($searched_child) > 0 ) {

			for ($i=0;$i<count($searched_child);$i++)
			{
				//	print "hledám : " . ($vnoreni+1) ." - " .  $searched_child[$i]->title . "<br />";

				/*
				   print "<pre>";
				   print_r($result);
				   print "</pre>";
				*/
				$searched_child[$i]->vnoreni = $vnoreni;
				array_push($result, $searched_child[$i]);
				if ($maxvnoreni > $vnoreni) {

					$result = $this->webTree($pole, $searched_child[$i]->id,$vnoreni+1, $maxvnoreni,$result);
				}

			/*	if (isset($mezi_result) && is_array($mezi_result) && count($mezi_result)>0) {
					//	array_push($result, $mezi_result);
				}*/
				/*	*/


			}
			//	}
		}
		return $result;
	}





	public function treeList(IListArgs $params = null)
	{
		$model = $this->model;


		if (is_null($params)) {
			$params = new ListArgs();
		}
		$list = $model->getList($params);

		return $list;
	}

}
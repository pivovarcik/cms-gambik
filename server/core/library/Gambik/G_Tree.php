<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

/**
 *
 *
 */
class G_Tree{
	/**
	 * Constructor
	 */
	private $g;

	private $modelName;
	private $viewName= "";
	public $linkEdit;
	function __construct($TEntita = "Category"){
	//	print "cccc";
	//	$this->g = new Gambik();
	//		print "dddddd";

		// načtu pouze jednou
	//	$this->modelName = "models_" . ucfirst($TEntita);
		$this->modelName = "models_" . ($TEntita);
		$this->viewName = "view_" . strtolower($TEntita);

	}
	private $data = array();

	public function getTreeMenu($params = array())
	{
		$data = $this->categoryTree($params);
		$res = '';

		if (count($data) > 0) {

			$pocet = count($data)-1;
			$res .= '<ul>
';
			$parent = 0;
			$vnoreni = $data[0]->vnoreni;
			$prvni_vnoreni = $data[0]->vnoreni;
			$poprvy = true;
			for ($i=0;$i<count($data);$i++)
			{

				if ( $data[$i]->vnoreni < $vnoreni ) {
					// jdu dolu o jeden
					$res .= '</li>
</ul>
';
					$res .= '</li>
';
				}
				if ( $data[$i]->vnoreni == $vnoreni && !$poprvy) {
					// jdu dolu o jeden
					$res .= '</li>
';
				}
				if ( $data[$i]->vnoreni > $vnoreni ) {
					// jdu dolu o jeden
					$res .= '
<ul>
';
				}
				$res .= '<li>';
				$res .= '<a href="#">' . $data[$i]->nazev . '</a>';
				if ($vnoreni == $data[$i]->vnoreni) {
					// stejná úroveň - mohu ukončit
				//	$res .= '</li>
//';
				}



				$parent = $data[$i]->parent_uid;
				$vnoreni = $data[$i]->vnoreni;
				$poprvy = false;
				//$data[$i]->uid;
			}
			if ($prvni_vnoreni <> $data[$pocet]->vnoreni) {
				$cyklus = $data[$pocet]->vnoreni - $prvni_vnoreni;
				for ($b=0; $b<$cyklus;$b++)
				{
					$res .= '</li>
</ul>
';
					$res .= '</li>
';
				}
			}
			$res .= '</ul>';
		}

		return $res;
	}
	public function categoryTree($params = array())
	{


	//	return array();
		$this->data = array();
		$select = isset($params["select"]) ? $params["select"] : "";
		/*
		$this->tree(array(
						"parent"=>$params["parent"],
						"select"=>$select,
						"debug"=>$params["debug"],
						"vnoreni"=>$params["vnoreni"],
						));
		*/
		if (isset($params["pole"]) && is_array($params["pole"])) {
			$pole = $params["pole"];
		} else {
			//$pole = TREE_MENU;

			//$pole = $this->treeList();
			$lang = '';
			$offset = '';
			$max_vnoreni = (isset($params["vnoreni"])) ? $params["vnoreni"] : 100;
			$limit = (isset($params["limit"])) ? $params["limit"] : 10000;

			$pole = $this->treeList(array(
					'offset'=>$offset,

			  		'limit'=>$limit,
			  		"debug"=>$params["debug"],
			  		'lang'=>$lang,
			  		));


		}
		//print_r($pole);

		$this->data = $this->webTree($pole, $params["parent"],0,$max_vnoreni);
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

			if ($pole[$i]->category_id == $select_id)
			{
				$pole_temp = new stdClass();
				$pole_temp->id = $pole[$i]->id;
				$pole_temp->title = $pole[$i]->title;
				$pole_temp->category_id = $pole[$i]->category_id;
				$pole_temp->level = $pole[$i]->level;
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

				//	if (count($mezi_result)>0) {
						//	array_push($result, $mezi_result);
				//	}
					/*	*/


				}
		//	}
		}
		return $result;
	}


	public function categoryTree2($params = array())
	{


		//	return array();
		$this->data = array();
		$select = isset($params["select"]) ? $params["select"] : "";
		$this->tree(array(
							"parent"=>$params["parent"],
							"select"=>$select,
							"debug"=>$params["debug"],
							"vnoreni"=>$params["vnoreni"],
							));
		return $this->data;
	}

	private function setDataTree($value, $name, $vnoreni, $parent, $selected)
	{
		$this->data[$value] = array("name" => $name, "vnoreni" => $vnoreni, "parent" => $parent, "selected" => $selected);
		//$this->data[$value] = $name;
	}

	public function treeList($params = array())
	{
	//	$model = new G_Service("");

		$model = new $this->modelName;

		$this->linkEdit = $model->linkEdit;
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
			$model->addWhere("l.code='" . LANG_TRANSLATOR."'");
		}

		if(isset($params['parent']) && is_numeric($params['parent']))
		{
			$model->addWhere("c.category_id=".$params['parent']);
		}

		if(isset($params['id_menu']))
		{
			$model->addWhere("t1.uid_menu=".$params['id_menu']);
		}



		if (isset($params['id_cat']) && is_numeric($params['id_cat']))
		{
			$model->addWhere("concat(
			    (case when sql11.uid is null then '' else sql11.uid end),'|',
			    (case when sql10.uid is null then '' else sql10.uid end),'|',
			    (case when sql9.uid is null then '' else sql9.uid end),'|',
			    (case when sql8.uid is null then '' else sql8.uid end),'|',
			    (case when sql7.uid is null then '' else sql7.uid end),'|',
			    (case when sql6.uid is null then '' else sql6.uid end),'|',
			    (case when sql5.uid is null then '' else sql5.uid end),'|',
			    (case when sql4.uid is null then '' else sql4.uid end),'|',
			    (case when sql3.uid is null then '' else sql3.uid end),'|',
			    (case when sql2.uid is null then '' else sql2.uid end),'|',
		     	t1.uid,'|'
			    ) like '%|" . $params['id_cat'] . "|%'");

		}


		$page =	(int) isset($params['page']) ? $params['page'] : 1 ;


		$model->setLimit($page, $params['limit']);

		$order = "c.level DESC,c.title ASC,c.parent_id ASC";
		if (isset($params['order'])) {
			$order = $params['order'];
		}
		$model->setOrderBy($order, "c.level DESC,c.title ASC,c.parent_id ASC");

	//	print $model->getOrderBy();
		$select = "c.id,cv.category_id,c.level,cv.title

		 ";
		$select = "c.category_id as id,c.parent_id as category_id,c.level,c.title";
		if(isset($params['pristup'])) {
		//	$select .= ", t3.pristup ";
		}
		$model->setSelect($select);
		$from = $model->getTableName() . " c LEFT JOIN " . $model->getTableName() . "_version cv on c.id=cv.page_id and
		c.version=cv.version LEFT JOIN " . T_LANGUAGE . " l on l.id=cv.lang_id";


		$from = $this->viewName . " c LEFT JOIN " . T_LANGUAGE . " l on l.id=c.lang_id";

		if(isset($params['pristup'])) {
		//	$from .= " left join " . T_PERMS . " t3 on t1.uid=t3.uid_category and t3.uid_user=" .$params['pristup'] . " ";
		}
		$model->setFrom($from);
/*
		$query = "select count(*) from "
			. $model->getFrom() . " "
			. $model->getWhere() . " "
			. $model->getGroupBy();
		*/
		//print $query;
	//	$this->total = $model->get_var($query);
		$list = $model->getRows();
//print $model->getLastQuery();
		return $list;

/*

		$sql = "SELECT " . $this->select . " FROM " . $this->from . " " . $this->where ." " . $this->order . " " . $this->limit;
		//print $sql  ."<br />";

		if (isset($params['debug']) && $params['debug']==1) {
			print $sql."<br/>";
		}
		$total = $this->generuj_pagelist();
		if ($total>0)
		{
			$list = $this->sql->get_results($sql);
			//print $sql ;
		} else
		{
			$list=array();
		}
		return $list;
		*/
	}
	private function tree($params = array())
	{
		//return;
		$lang = '';
		$offset = '';
		$max_vnoreni = (isset($params["vnoreni"])) ? $params["vnoreni"] : 100;
		$limit = (isset($params["limit"])) ? $params["limit"] : 100;

		$list = $this->treeList(array(
							'offset'=>$offset,
					  		'parent'=>$params["parent"],
					  		'limit'=>$limit,
					  		"debug"=>$params["debug"],
					  		'lang'=>$lang,
					  		));
		/*
		$list = $this->g->category_list(array(
							'offset'=>$offset,
					  		'parent'=>$params["parent"],
					  		'limit'=>$limit,
					  		"debug"=>$params["debug"],
					  		'lang'=>$lang,
					  		));
		*/
		//print_r($list);
		if (count($list)>0)
		{
			// $this->html_select .='<ul>';
			for($i=0;$i<count($list);$i++)
			{
				//$uroven =0;
				$url ="";
				$odrazka ="";
				if (!empty($params["parent"])) {
					$odrazka = "";
					$this->vnoreni = $this->vnoreni+1;
				} else {
					$this->vnoreni =0;
				}
				$selected = 0;
				if ($list[$i]->uid==$params["select"])
				{
					$selected = 1;
				}
				$this->setDataTree($list[$i]->uid, $list[$i]->nazev, $this->vnoreni, $params["parent"], $selected);

				if(is_numeric($list[$i]->uid) && $list[$i]->uid>0 && $max_vnoreni > $this->vnoreni)
				{
					$this->tree(array(
					"parent"=>$list[$i]->uid,
					"select"=>$params["select"],
					"url_parent"=>'',
					));
				}
				//$this->html_strom .='</li>';
				/*if (empty($params["parent"])) {
				   $this->vnoreni =0;
				   }  */
				$this->vnoreni =$this->vnoreni-1;
			}
			//$this->html_strom .='</ul>';
		}
	}
}



function Tree($params = array())
{


	//	return array();
	$data = array();

	if (isset($params["pole"]) && is_array($params["pole"])) {
		$pole = $params["pole"];
	} else {
		$pole = TREE_MENU;
	}
	$data = $this->webTree($params["pole"], $pole);

	return $data;
}

function isChild($pole, $select_id){
	$webTree = array();
	for ($i=0;$i<count($pole);$i++)
	{

		if ($pole[$i]->category_id == $select_id)
		{
			$pole_temp = new stdClass();
			$pole_temp->id = $pole[$i]->id;
			$pole_temp->title = $pole[$i]->title;
			$pole_temp->category_id = $pole[$i]->category_id;
			array_push($webTree, $pole_temp);
		}
	}
	return $webTree;
}
function webTree($pole, $select_id, $vnoreni = 0, $maxvnoreni = 200, $result = array()){

	if (count($result) > 0) {

	}
	if ($maxvnoreni > $vnoreni) {

		$select_id = (int) $select_id;
		$searched_child = isChild($pole, $select_id);

		//array_push($result, $result);
		if ( count($searched_child) > 0 ) {

			for ($i=0;$i<count($searched_child);$i++)
			{
				//	print "hledám : " . ($vnoreni+1) ." - " .  $searched_child[$i]->nazev_cs . "<br />";
				$searched_child[$i]->vnoreni = $vnoreni+1;
				array_push($result, $searched_child[$i]);
				/*
				   print "<pre>";
				   print_r($result);
				   print "</pre>";
				*/
				if ($searched_child[$i]->id > 0) {
					$result = webTree($pole, $searched_child[$i]->id,$vnoreni+1, $maxvnoreni,$result);
				}


				if (count($mezi_result)>0) {
					//	array_push($result, $mezi_result);
				}
				/*	*/


			}
		}
	}
	return $result;
}


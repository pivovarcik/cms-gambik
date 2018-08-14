<?php

require_once(PATH_CORE . "models/SysCategory.php");
require_once(PATH_CORE . "entity/SysCategoryVersionEntity.php");
class TreeMenu {
	/**
	 * Constructor
	 */
	// Kompletní struktura webu
	private $completeStructureSite = array();
	private $completeStructureSiteObj = array();

	// skládá html
	private $print_li = "";
	// počet průchodů
	private $iterace = 0;

	private $pole_rozdrobene_url = array();

	private $poprve = false;

	private $viewName= "";
	public $page_id = 0;
	public $pathA = array();

	private $get_url;



	public $class_ul_root = "nav navbar-nav";
	public $class_li_selected = "navSelected2";
	public $class_a_selected = "navSelected2";

	public $class_li_parent_selected = "navSelected";
	public $class_a_parent_selected = "navSelected";

	public $class_li_prefix = "li-";
	public $class_a_prefix = "a-";

	public $id_ul_root = "";
	public $max_vnoreni = 2;
	public $home = false;
	public $home_label = "Úvod";


	public function getcompleteStructureSiteObj(){
		return $this->completeStructureSiteObj;
	}
	public function getPageId($get_url)
	{
		$model = new G_Service("");
		//$model->setLimit(1, $params['limit']);
		//	$model->setOrderBy($params['order'], "c.level DESC,c.title ASC,c.parent_id ASC");

		//$get_url = "/" . (isset($_GET['url']) ? $_GET['url'] : "") ;

		$get_url = "" . $get_url;
		$this->get_url =$get_url;
		$select = "c.category_id, c.serial_cat_id";
		$model->setSelect($select);
		$from = $this->viewName . " c LEFT JOIN " . T_LANGUAGE . " l on l.id=c.lang_id";
		$model->setFrom($from);

		$model->addWhere("c.serial_cat_url like '%".$get_url."'");

		$row = $model->getRows();

	//	print $model->getLastQuery();
		if (count($row) >0) {
			$this->page_id = $row[0]->category_id;
			$this->setPath($row[0]);
			$this->pathA = $row[0]->pathA;
		//	Print $model->getLastQuery();

		//	print_r($row[0]);
		//	print $this->path;
		}
	}

	public function getUrl()
	{

		// musím provést ošetření url
	//	$get_url = str_replace("|","/" ,$this->get_url);
		$get_url = str_replace("||","|" ,$this->get_url);
		$get_url = str_replace("||","|" ,$get_url);
		$get_url = str_replace("||","|" ,$get_url);
		$get_url = str_replace("||","|" ,$get_url);
		$get_url = str_replace("root|","" ,$get_url);
		$get_url = str_replace("|","/" ,$get_url);

		return $get_url;
	}


	protected function setStructureSite()
	{
		$this->completeStructureSiteObj = new stdClass();
		$this->completeStructureSiteObj->childern = array();

		foreach ($this->completeStructureSite as $key => $row) {

			$this->setNode($row);
		//	if (!is_null($row->category_id)) {

		//	}
		}

	}


	private function setPath($row)
	{
		$serial_cat_idA = str_replace("||", "" , $row->serial_cat_id);
		$serial_cat_idA = explode("|", $serial_cat_idA);

		$row->pathA = array();
		$row->childern = array();
		$row->path = "";
		foreach ($serial_cat_idA as $key => $val) {

			if (!empty($val)) {
				array_push($row->pathA, $val);
			}
		}
		$row->path = implode("|", $row->pathA);
	}

	private function orderByTree($childern = array())
	{
		$levels = array();
		foreach ($childern as $child) {
			array_push($levels, $child->level);

		}
	}
	private function getNode($pathA)
	{
		$path = "";
		$obj =  $this->completeStructureSiteObj;
		foreach ($pathA as $key => $id) {
			$obj = $this->getNodeId($obj, $id);


			if (count($pathA) > 1 && $key == count($pathA) - 2) {
				$this->parentNode = $obj;
			}
		//	$obj->orderList[] = $id;
		//	$obj = $this->getNodeId2($obj, $id);
		}


		return $obj;
	}

	private function getNodeId2($obj, $id)
	{



		foreach ($obj->childern as $child ) {

			if ($child->id == $id) {
				return $child;
			}
		}
		 $child  = new stdClass();
		//$obj->childern[$id];


		return $child;
	}
	private function getNodeId($obj, $id)
	{

		if (!isset($obj->childern[$id])) {
			$obj->childern[$id] = new stdClass();
			$obj->childern[$id]->orderList = array();
		//	$obj->orderList = array();
		}
		return $obj->childern[$id];
	}


	private function setNode($row){

	//	print "setNode";
	//	$this->setPath($row);
		new CategoryWrapper($row);
		$obj = $this->getNode($row->pathA);

	/*	if (count($row->pathA)) {

		}*/
	//	$obj2 = $this->getNode($row->pathA);


		$obj->data = $row;
		$this->parentNode->orderList[] = $row->id;
	}

	private function findParentId($id)
	{

	}
	public function getPageIdFromQuery()
	{
	//	print_r($_GET);
		if (isset($_GET["url"])) {
			$get_url = "/" .  $_GET['url'];


			$get_url = str_replace("/eshop/","",$get_url);
			$get_url = str_replace("/","|",$get_url);
			$get_url = str_replace("||","|",$get_url);

			$get_url = str_replace("'","",$get_url);
		//	print $get_url;

			return $this->getPageId($get_url);
/*
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
			}*/
			//print $model->getLastQuery();
			//print_r($row);

		}
		return $this->page_id;
	}

	function __construct($TEntita = "Category")
	{


		// načtu pouze jednou
		$modelName = "models_" . ($TEntita);

		$this->viewName = "view_" . strtolower($TEntita);
//		print $modelName;
		$category = new $modelName;
		$params = array();
		$params['lang'] = LANG_TRANSLATOR;
		$params['page'] = 1;
		$params['limit'] = 1000000;
		$params["order"] = "c.serial_cat_id ASC ,c.level DESC,c.title ASC,c.parent_id ASC";
		$params["order"] = "c.parent_id ASC,c.id ASC";
		$params['lite'] = true;
		//$this->completeStructureSite = $category->getList($params);

		$model = new G_Service("");
		$model->setLimit(1, $params['limit']);
		$model->setOrderBy($params['order'], "c.serial_cat_id ASC ,c.level DESC,c.title ASC,c.parent_id ASC");

		$select = "c.*,c.category_id as page_id, c.category_id as id,c.parent_id as category_id,c.level,c.title";
		$model->setSelect($select);

		$from = $this->viewName . " c LEFT JOIN " . T_LANGUAGE . " l on l.id=c.lang_id";


		$model->addWhere("l.code='".LANG_TRANSLATOR."'");

		$model->setFrom($from);
		$this->completeStructureSite = $model->getRows(60);
		$this->setStructureSite();



	// 	serial_cat_id


		//	print $category->getLastQuery();
	//	print_r($this->completeStructureSiteObj );
	}

	// volám pro každý menu
	public function getMenu($params = array())
	{

		$parent_url = "";
		$isMenu = (isset($params["is_menu"])) ? $params["is_menu"] : false;

		if($isMenu)
		{
			//print "je menu";
		}
		$rozbalit_vse = (isset($params["rozbalit_vse"])) ? $params["rozbalit_vse"] : false;
		$rozbalit_dalsi = (isset($params["rozbalit_dalsi"])) ? $params["rozbalit_dalsi"] : true;



		if (isset($params["home"])) {
			$this->home = $params["home"];
		}
		if (isset($params["home_label"])) {
			$this->home_label = $params["home_label"];
		}

		if (isset($params["class_ul_root"])) {
			$this->class_ul_root = $params["class_ul_root"];
		}

		if (isset($params["id_ul_root"])) {
			$this->id_ul_root = $params["id_ul_root"];
		}



		if (isset($params["class_li_selected"])) {
			$this->class_li_selected = $params["class_li_selected"];
		}

		if (isset($params["class_li_parent_selected"])) {
			$this->class_li_parent_selected = $params["class_li_parent_selected"];
		}



	//	$class_ul_root = (isset($params["class_ul_root"])) ? $params["class_ul_root"] : "";
		$class_ul_selected = (isset($params["class_ul_selected"])) ? $params["class_ul_selected"] : "";
		$class_ul_noselected = (isset($params["class_ul_noselected"])) ? $params["class_ul_noselected"] : "";
	//	$class_li_selected = (isset($params["class_li_selected"])) ? $params["class_li_selected"] : "";



		$class_li_noselected = (isset($params["class_li_noselected"])) ? $params["class_li_noselected"] : "";
	//	$id_ul = (isset($params["id_ul_root"])) ? $params["id_ul_root"] : "";

		$ignore_parent = (isset($params["ignore_parent"]) && is_array($params["ignore_parent"])) ? $params["ignore_parent"] : array();

		$selected_parent = (isset($params["selected_parent"]) && is_array($params["selected_parent"])) ? $params["selected_parent"] : array();
		if (isset($params["start_uroven"]) && is_numeric($params["start_uroven"]))
		{
			$start_uroven = $params["start_uroven"];
		} else
		{
			$start_uroven = 1;
		}



		if (isset($params["max_vnoreni"]) && !empty($params["max_vnoreni"]))
		{
			$this->max_vnoreni = $params["max_vnoreni"];
		}
		$this->iterace = 0;
		//print_r($list_A);
		$this->print_li = "";
		$oddelovac  =" / ";
		$ignore_url = isset($params["ignore_url"]) ? $params["ignore_url"] : "";
		$this->pole_rozdrobene_url =array();
		if (isset($params["get_url"]) && !empty($params["get_url"])) {
			$get_url = isset($params["get_url"]) ? $params["get_url"] : "";
			$get_url = str_replace("||","|" ,$get_url);
			$get_url = str_replace("||","|" ,$get_url);
			$get_url = str_replace("||","|" ,$get_url);
			$get_url = str_replace("||","|" ,$get_url);
			$get_url = str_replace("root|","" ,$get_url);
			$get_url = str_replace("|","/" ,$get_url);
		} else {
			$get_url = "/" . (isset($_GET['url']) ? $_GET['url'] : "") ;

			$get_url = $this->getUrl();

	//		print $this->getUrl() . "=" . $get_url;


			$get_url = str_replace($ignore_url,"/",$get_url);


		}
	//	print "tudy";
		//	print $get_url;
		//PRINT $get_url;
		$temp_pole_rozdrobene_url = explode('/', $get_url);

		//$temp_pole_rozdrobene_url = explode('|', $get_url);
		for($i=0;$i<count($temp_pole_rozdrobene_url);$i++)
		{
			if(!empty($temp_pole_rozdrobene_url[$i]))
			{
				array_push($this->pole_rozdrobene_url,$temp_pole_rozdrobene_url[$i]);
			}

		}
		//zkracovač

		//$this->pole_rozdrobene_url = explode('/', $_GET['url']);
	//	print_r($this->pole_rozdrobene_url);
		if (count($this->pole_rozdrobene_url)>0 && !empty($this->pole_rozdrobene_url[0]))
		{
			// $this->drobecky = '<a title="Přejít na hlavní stránku" href="/">Titulní strana</a>' . $oddelovac;
		} else
		{
			//$this->drobecky = 'Titulní strana';
		}
		/*
		   $prvni = $pole_url[0];
		   $posledni = $pole_url[count($pole_url)-1];
		*/
		$menu_tree_A = array();
		$list_A = $this->completeStructureSite;
		/*
		   print "<pre>";
		   print_r($list_A);
		   print "</pre>";
		*/
		$this->menu_tree_A = array();
		$this->poprve = true;


		if (isset($params["select_uroven"]) && is_numeric($params["select_uroven"]))
		{
			$select_uroven = $params["select_uroven"];
		} else
		{
			$select_uroven = ""; //$prvni;
		}

	//	print_R($list_A);
		// print '<ul>';
		$this->setMenu(
					$start_uroven,
					$list_A,
					$select_uroven,
					0,
					$rozbalit_vse,
					$rozbalit_dalsi,
					$isMenu,
                    $class_ul_selected,
                    $class_ul_noselected,
                    $class_li_noselected,
                    $ignore_parent,
                    $selected_parent
                  );
		//print '<pre>';
		//print_r($this->menu_tree_A);
		//print '</pre>';
		//print $this->iterace;
		return $this->print_li;
	}

	private function setMenu($start_uroven,
		$list_A,
		$select_uroven,
		$vnoreni=0,
		$rozbalit=false,
		$rozbalit_dalsi,
		$isMenu,
		$class_ul_selected="",
		$class_ul_noselected="menu_hide",
		$class_li_noselected="menu_hide",
		$ignore_parent=array(),
		$selected_parent=array()
		)
	{

		//print_r($ignore_parent);
		$vnoreni++;
		if (!empty($params['lang']))
		{
			$znak = "_".$params['lang'] ;
		} else {
			$znak = "_" . LANG_TRANSLATOR ;
		}
		$nasel_prvni = false;
		$hledam_prvni = true;
		//print_r($list_A);
		for($i=0;$i<count($list_A);$i++)
		{

			if (!in_array($list_A[$i]->page_id,$ignore_parent)) {
			//	!in_array($list_A[$i]->page_id,$ignore_parent)

			if (count($selected_parent) == 0 || in_array($list_A[$i]->page_id,$selected_parent)) {

		//	}
			$url = "";
			$cat_aktual_link  = "";
			$class_ul = $class_ul_noselected;
			$class_li = "";

			$class_url =	isset($list_A[$i]->url) && !empty($list_A[$i]->url) ? strtolower($list_A[$i]->url) : "" ;

			$class_li =	isset($list_A[$i]->class_li) && !empty($list_A[$i]->class_li) ?$list_A[$i]->class_li : $class_url;

				$serial_cat_urlA = explode("|",$list_A[$i]->serial_cat_url);
				if (count($serial_cat_urlA)>0) {
					$class_li = $this->class_li_prefix . $serial_cat_urlA[(count($serial_cat_urlA)-1)];
					$list_A[$i]->url = $serial_cat_urlA[(count($serial_cat_urlA)-1)];
				}
			$class_li = trim($class_li);
			if (!empty($class_li)) {
				$class_li = ' ' . $class_li;
			}
		//	print $class_ul . " - " . $class_ul_noselected. ":" . $list_A[$i]->title . "<br />";
			// Našel Root
			//	print $list_A[$i]->category_id . " == " . $start_uroven . "-" . $rozbalit_dalsi . "<br />";
			if ($list_A[$i]->category_id == $start_uroven && $rozbalit_dalsi)
			{


			//	print "test";
				$nasel_shodu_posledni = false;

				array_push($this->menu_tree_A, $list_A[$i]);

				$typ_url = ""; // proč ? nikde se neinicializuje
				$parent_url = "";    // proč ? nikde se neinicializuje
				if ($typ_url=="admin")
				{
					$url = URL_HOME . "admin/cat.php?id=" . $list_A[$i]->id;

				} else
				{
					$url .= $parent_url . "/" . $list_A[$i]->url;
				}

				$titulek = $list_A[$i]->title;
				// print "Pouštím pro : " . $list_A[$i]->nazev_cs . " >> " . $list_A[$i]->serial_cat_url . "<br />";
				if (isUrl($list_A[$i]->serial_cat_url)) {
					$cat_aktual_link  = $list_A[$i]->serial_cat_url;
				} else {
					$cat_aktual_link  = URL_HOME_REL . str_replace("root/","",get_categorytourl($list_A[$i]->serial_cat_url,$list_A[$i]->serial_cat_id));
				}
				//$cat_aktual_link = substr($cat_aktual_link, 0, -1);
				$cat_aktual_link = strtolower($cat_aktual_link);

				$class= ' class="navChildren'.$class_li.'"';


				$class_ul = (!empty($class_ul_root)) ? $class_ul_root : $class_li_noselected;
				//print $class_ul . "<br />";
				//	print_r($this->pole_rozdrobene_url);
				// Pokud se první (zbývající) část url = url rubriky
				$prvni_url = isset($this->pole_rozdrobene_url[0]) ? $this->pole_rozdrobene_url[0] : "";
				//   	print $this->pole_rozdrobene_url[0] . "<br />";
				//	print strtolower($prvni_url) . "==" . strtolower($list_A[$i]->url_friendly) . "<br />";
				if (strtolower($prvni_url) == strtolower($list_A[$i]->url) && !empty($list_A[$i]->url))
				{

					$class_ul = $class_ul_selected;

					// Aktuálně vabraná sekce
					//print $class_ul . " - " . $class_ul_noselected. ":" . $list_A[$i]->title . "<br />";

					//print $class_ul . "<br />";
					// Předchůdce byl true
					if ($rozbalit)
					{
						if(!empty($class_ul_root))
						{
							$class_ul = $class_ul_root;
						} else {

							$class_ul = $class_ul_selected;
						}
					}
					$class_ul = (!empty($class_ul_root)) ? $class_ul_root : $class_ul_selected;
					// je rovnost -> selected
					if(count($this->pole_rozdrobene_url)==1)
					{
						$nasel_shodu_posledni = true;
						$class= ' class="'.$this->class_li_selected . $class_li.'"';
						//print $this->id_page . " - shoda<br />";
					}
					$this->pole_rozdrobene_url = array_reverse($this->pole_rozdrobene_url);

					// Odeberu z pole shodný záznam
					array_pop($this->pole_rozdrobene_url);

					$this->pole_rozdrobene_url = array_reverse($this->pole_rozdrobene_url);
					$oddelovac = " / ";
					if (count($this->pole_rozdrobene_url)>0 )
					{
						// $this->drobecky .= '<a title="' . $titulek . '" href="' . $url . '">' . $list_A[$i]->nazev . '</a>' . $oddelovac;
						$class_ul = $class_ul_selected;
						$class= ' class="'.$this->class_li_parent_selected . $class_li.'"';
						$class_ul = (!empty($class_ul_root)) ? $class_ul_root : $class_ul_selected;
						//$nasel_shodu_posledni = true;
					} else
					{

						//$this->drobecky .= '' . $list_A[$i]->nazev . '';
						if(!$nasel_shodu_posledni)
						{
							$class= ' class="'.$this->class_li_parent_selected . $class_li.'"';
						}

						$class_ul = $class_ul_selected;
						$class_ul = (!empty($class_ul_root)) ? $class_ul_root : $class_ul_selected;
						//$this->set_pagetitle($list_A[$i]->title);
						$this->page_id = $list_A[$i]->page_id;


					}
					$nasel_shodu = true;
				} else
				{
					// Předchůdce byl true
					if ($rozbalit)
					{
						if(!empty($class_ul_root))
						{
							$class_ul = $class_ul_root;
						} else {

							$class_ul = $class_ul_selected;
						}

					}
					else
					{
						if(!empty($class_ul_root))
						{
							$class_ul = $class_ul_root;
						} else {

							$class_ul = $class_ul_noselected;
						}
						//$class_ul = $class_ul_noselected;
					}	   /* */

					//$tagClass =
					//$class = ' class="navChildren"';
					$class = '';
					if (!empty($class_li)) {
						$class_li = trim($class_li);
						$class= ' class="'.$class_li.'"';
					}

					// 18.4.2012 skrýt druhou uroven
					if ($this->iterace > 0) {
						$class_ul = $class_ul_noselected;
						$class_ul = "level" . $this->iterace;
					}
					//$class = ' class="navChildren ' . $class_ul_noselected . '"';
					$nasel_shodu = false;
				}
				$class_ul = $class_ul_noselected;
			//	$class_ul = "level" . $this->iterace;
				$class_ul = "level" . $vnoreni;

				$ul_id = "";
				// Rootový uzel
				if ($this->iterace == 0) {
					//$class_ul = $class_ul_noselected;
				//	$class_ul = "nav navbar-nav";
					if (!empty($this->class_ul_root)) {
						$class_ul = $this->class_ul_root;
					}

					if (!empty($this->id_ul_root)) {
						$ul_id = ' id="' . $this->id_ul_root . '"';
					}


				}
				if($hledam_prvni)
				{
					// provede se pokaždé pokud najde nový uzel

					$this->iterace++;
					if (!empty($class_ul) && $this->poprve)
					{
						$this->poprve = false;
						//$class= ' class="' . $class_ul . '"';
					}


					$class2= '';
					if (!empty($class_ul)) {
						$class2= ' class="' . $class_ul . '"';

					}


					$this->print_li .= '
							<ul' . $ul_id . $class2 . '>
							';
					//' . $class2 . '
					// id="' . $vnoreni . '"
					$nasel_prvni = true;
					$hledam_prvni = false;


					if ($vnoreni == 1 && $this->home) {

					//	print_r($this->pole_rozdrobene_url);
					//	print $this->getUrl();
						$classRoot = '';
						//if (count($this->pole_rozdrobene_url) == 0) {
						if ($this->getUrl() == "/") {
							$classRoot= ' class="'.$this->class_li_selected.'"';
						}
						$this->print_li .= '<li' . $classRoot .'>';
						$this->print_li .= '<a' . $classRoot .' href="' . URL_HOME_REL . '">';
						$this->print_li .= '<span>';
						$this->print_li .=  $this->home_label;
						$this->print_li .= '</span>';
						$this->print_li .= '</a>';
						$this->print_li .= '</li>';

					}


				}




				if($nasel_prvni)
				{
					//print '<ul>';
					$nasel_prvni = false;




				}
				$isTitle = false;
				$title = ($isTitle) ? ' title="' . $titulek . '"' : '';

				$nasel_prvni =true;
//$nasel_shodu
				$this->print_li .= '<li' . $class .'>';

				$this->print_li .= '<a' . $class .'' . $title .' href="' . $this->getUserUrlQuery($cat_aktual_link) . '">';


				if (isset($list_A[$i]->icon_class) && !empty($list_A[$i]->icon_class)) {
					$this->print_li .= '<i class="fa ' . $list_A[$i]->icon_class . ' fa-fw">';
					$this->print_li .= '</i>';
				}


				$this->print_li .= '<span>';
				$this->print_li .=  $titulek;
				$this->print_li .= '</span>';
				$this->print_li .= '</a>';
				$rozbalit_vse = true;

				//print "" . $vnoreni . "<" . $max_vnoreni . "<br />";
				//if (($nasel_shodu || $rozbalit_vse) && ($nasel_shodu || $vnoreni<$max_vnoreni))
				// if (($nasel_shodu || $rozbalit_vse) && ($nasel_shodu || $vnoreni<$max_vnoreni))
				//($rozbalit_vse) ||
				//   $isMenu = false;
				if (isset($isMenu2) && $isMenu2)
				{
					if (($nasel_shodu || $rozbalit_vse) && ($nasel_shodu || $vnoreni < $this->max_vnoreni))
					{
						//  print "" . $vnoreni . "<" . $max_vnoreni . " " . count($this->pole_rozdrobene_url) . "<br />";
						//if (count($this->pole_rozdrobene_url)==0)
						if ($nasel_shodu)
						{
							$rozbal_dalsi= true;
						} else
						{
							$rozbal_dalsi= false;
						}
						//print "" . $vnoreni . "<" . $max_vnoreni . "<br />";
						//$this->set_tree($list_A[$i]->uid,$list_A,$select_uroven,$class_ul,$vnoreni,$max_vnoreni);

						$this->setMenu(
						         $list_A[$i]->page_id,
								$list_A,
						         $select_uroven,
						         $vnoreni,
						         $nasel_shodu_posledni,
						         $rozbal_dalsi,
						         $class_ul_selected,
						         $class_ul_noselected,
						         $class_li_noselected,
						         $ignore_parent
						         );

					}

				} else {

					if (($rozbalit) || ($nasel_shodu && $vnoreni<$this->max_vnoreni) || ($isMenu && $vnoreni<$this->max_vnoreni) )
					{

						if (($nasel_shodu || $isMenu) && !in_array($list_A[$i]->page_id,$ignore_parent))
						{
							$rozbal_dalsi= true;
						} else
						{
							$rozbal_dalsi= false;
						}
						 //print $list_A[$i]->page_id . "-" . $vnoreni . "<" . $max_vnoreni . "<br />";
						//$this->set_tree($list_A[$i]->uid,$list_A,$select_uroven,$class_ul,$vnoreni,$max_vnoreni);
						if ($vnoreni<$this->max_vnoreni)
						{
							$this->setMenu(
								$list_A[$i]->page_id,
								$list_A,
								$select_uroven,
								$vnoreni,

								$nasel_shodu_posledni,
								$rozbal_dalsi,
								$isMenu,
								$class_ul_selected,
								$class_ul_noselected,
								$class_li_noselected,
								$ignore_parent
								);
						}
					}
				}


				$this->print_li .=  '</li>
					';


			}
			}
		}

		}

	//////////////////////////////
		if($nasel_prvni)
		{
			//$this->print_li .= '<ul>' . $print_li2 . '</ul>';
			$this->print_li .= '</ul>';
		}
		//$this->print_li .= '</ul>';

	}

	public function setUserUrlQuery(){
		if (!isset($_SESSION["url_query"]) || !is_array($_SESSION["url_query"])) {
			$_SESSION["url_query"] =array();
		}

		if (!isset($_GET['do'])) {
			$pole =	explode("?",$_SERVER["REQUEST_URI"]);
			$parametry = isset($pole[1]) ? $pole[1] : "";
			$_SESSION["url_query"][$_SERVER["REDIRECT_URL"]]=$parametry;
		}
	}

	/*
	   * přiřadí paramatry dle URL
	   * */
	public function getUserUrlQuery($key = null){
		if ($key == null) {
			return $_SESSION["url_query"];
		}
		$keyTest = str_replace(URL_HOME,"/",$key);
		//	print $key . "<br />";
		if (isset($_SESSION["url_query"][$key])) {
			return $key . "?" . $_SESSION["url_query"][$key];
		} else {
			return $key;
		}

	}
}

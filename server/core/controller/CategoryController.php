<?php


/**
 * CategoryController
 *
 * @version 4.80
 * @copyright 2013 Pivovarcik.cz
 */

class CategoryController extends PageVersionBase
{
	public $formEditName = "CategoryEdit";
	public $formCreateName = "CategoryCreate";
	function __construct($TCategory = "Category", $TCategoryVersion ="CategoryVersion")
	{
		parent::__construct($TCategory,$TCategoryVersion);

		$settings = G_Setting::instance();
		$isVersioning = ($settings->get("VERSION_CATEGORY") == 1) ? true : false;
		self::$isVersioning = $isVersioning;
		self::$saveEntity = true;
	}

	/**
	 * Založení nové rubriky přes PostData
	 * */
	public function createAction()
	{

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins_cat', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad($this->formCreateName);
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				$postdata = $form->getValues();

				$PageEntity = self::setPageData($postdata);
				$pageVersionEntities = self::setPageVersionData($postdata, $form->page->versionList, $PageEntity->version);

				$PageEntity->level = self::$model->getMinLevelCategory($PageEntity->category_id) - 1;

				if (self::saveData($PageEntity, $pageVersionEntities, $form)) {

					$pageSaveData = self::getPageSaveData();

					$form->setResultSuccess("Rubrika byla přidána.");
				//	self::$getRequest->goBackRef();
					self::$getRequest->goBackRef(URL_HOME . "category/cat?id="  .$pageSaveData->id);

				}

			}
		}
	}

	/**
	 * Aktualizace rubriky přes PostData
	 * */


	public function saveAction()
	{

		//&& false !== self::$getRequest->getPost('id', false)
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('upd_cat', false) )
		{
			$form = $this->formLoad($this->formEditName);
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{


				$postdata = $form->getValues();

				$PageEntity = self::setPageData($postdata, $form->page);

				$pageVersionEntities = self::setPageVersionData($postdata, $form->page->versionList, $PageEntity->version);

				if (self::saveData($PageEntity, $pageVersionEntities, $form)) {
					$form->setResultSuccess("Rubrika byla aktualizována.");
					self::$getRequest->goBackRef();
				}

			}
		}
	}


	public function deleteAction()
	{
		// kontrola zda je možné provést smazání

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('del_cat', false) )
		{
			$form = $this->formLoad($this->formEditName);
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				$postdata = $form->getValues();

				$pageSaveData = self::setPageData($postdata, $form->page);
			//	$pageSaveData->id = $form->page->id;
			//	$pageSaveData["isDeleted"] = 0;
			//	$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData["id"], $pageSaveData["version"]);

				if (self::deleteData($pageSaveData, $form)) {
					$form->setResultSuccess("Rubrika byla smazána.");
					self::$getRequest->goBackRef(URL_HOME . "category");
				}

			}
		}

	}
/*	public function setPageData($postdata, $originalData = null)
	{
		$data = parent::setPageData($postdata, $originalData);

		$name = "category_id";
		if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
			$data["category_id"] = (int) $postdata[$name];
			// při každém uložení se změnil i level !!!
		//	$data["level"] = self::$model->getMinLevelCategory($data["category_id"]) - 1;
		}


		$name = "icon_class";
		if (array_key_exists($name, $postdata)) {
			$data["icon_class"] = (string) $postdata[$name];
			// při každém uložení se změnil i level !!!
			//	$data["level"] = self::$model->getMinLevelCategory($data["category_id"]) - 1;
		}


		//print_r($data);
		//exit;
		return $data;
	}*/
/*
	public function setPageVersionData($postdata, $pageVersionList, $version)
	{

		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$versionEntityList = parent::setPageVersionData($postdata, $pageVersionList, $version, $languageList);
		return $versionEntityList;
	}
*/
	private function validacePredUlozenim()
	{

		$data = self::getPageSaveData();



		//if (isset($data->category_id)) {


		//	print_r($data);
		//	exit;
	//	print $data->category_id . "==" . $data->id	;
	//	exit;
		// Pro novy záznam musí být povoleno !!
			if ($data->category_id == $data->id && !is_null($data->id) ) {
				$this->setResultError("Nelze vybrat jako umístění sám sebe!");
				return false;
			}
			$categoryParent = self::$model->getDetailById($data->category_id);

			//print_r($categoryParent);
			if (strpos($categoryParent->serial_cat_id . "|", "|" . $data->id . "|" )) {
				$this->setResultError("Nelze vybrat jako umístění kategorii, která je vně této rubriky!");
				return false;
			}

			// Kontrola max 10 úrovní vnoření !!!!

			// u systémových sekcí nesmí jít změnit url (root a seccret) a nesmí se jinam umístit!!

			// ostatní rubriky nesmí obsahovat stejnou url (root+secret)

			// duplicitní url ve stejné větvi a jazykové verzi nesmí nastat!!!

			//exit;
			// validace zda category není náhodou potomkem


	//	}
		return true;
	}


	private function validacePredSmazanim()
	{

		$data = self::getPageSaveData();

		if (isset($data->id)) {

			$args = new ListArgs();
			$args->cat = $data->id;
			$categoryParent = self::$model->getList($args);

			if (count($categoryParent) > 0) {

				$seznamId = array();

				foreach($categoryParent as $page)
				{
					array_push($seznamId, $page->page_id);
				}
				$this->setResultError("Rubrika obsahuje podrubriky (id:" . implode(",", $seznamId). ")");

				//	print_r($categoryParent);
				return false;
			}

		}
		return true;
	}


	public function akcePredSmazanim()
	{
		return self::validacePredSmazanim();
	}
	public function akcePredUlozenim()
	{
		return self::validacePredUlozenim();
	}

	/**
	 * Po každé aktualizaci rubriky je třeba vygenerovat nové Tree
	 * */
	protected function akcePoUlozeni()
	{
		return self::$model->generateCategoryTree();
	}


	public function getCategory($id)
	{
		//	print "tudy " . $id;
		//$id = self::$getRequest->getQuery("id",0);
		$id = (int) $id;
		$url = self::$getRequest->getQuery("item","");
		if ($id >0) {
		//		print "tudy " . $id;

		//	$model = new models_Category();
			$detail = self::$model->getDetailById($id);

		//	print self::$model->getLastQuery();
		} elseif (!empty($url)) {
			//$model = new models_Category();
			$detail = self::$model->getPublishByUrl($url);
		} else {
		//	print "{CategoryController} nebyl specifkován požadavek!";
			return false;
		}
    

		if ($detail) {
    
        if (strpos($detail->serial_cat_url,"|secret|") !== false) {
         return false;
    }

			$detail->pagetitle = !empty($detail->pagetitle) ? $detail->pagetitle : $detail->title;
			//$detail->pagekeywords = !empty($detail->pagekeywords) ? $detail->pagekeywords : $detail->titulek;

			// RP - lepší je nechat pagedescription prázdné
			//$detail->pagedescription = !empty($detail->pagedescription) ? $detail->pagedescription : $detail->description;
			return $detail;
		}

	}
	public function categoryListEdit($params = array())
	{
		$l = $this->categoryList($params);
		/*		*/
		$tree = new G_Tree();
		//	print "test123";
		$rubrikyList = $tree->categoryTree(array(
			"parent"=>0,
			"debug"=>0,
		));

		//	print_r($rubrikyList);
		for($i=0;$i<count($l);$i++)
		{

			$url= URL_HOME . 'admin/post.php?id=' . $l[$i]->page_id;

			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{
				$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$elem->setAttribs('value', $l[$i]->id);
				$elem->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elem->render();
				if (!empty($l[$i]->thumbs))
				{
					//$PreviewUrl = $g->get_thumb(array('file'=>$l[$i]->thumbs,'sirka'=>'70','vyska'=>'70'));

					//$image = '<img class="imgobal"' . $v[3] . ' src="' . $PreviewUrl . '" title="' . $l[$i]->titulek . '" alt="' . $l[$i]->titulek . '"/>';
					//$print_image = '<a href="' . $url . '" title="' . $l[$i]->titulek . '">' . $image .'</a>';
				}

				$elem = new G_Form_Element_Text("title[" . $i . "]");
				$value = self::$getRequest->getPost("title[" . $i . "]", $l[$i]->title);
				$elem->setAttribs('value',$value);
				$titulek = $elem->render();

				$elem = new G_Form_Element_Textarea("perex[" . $i . "]");
				$value = self::$getRequest->getPost("perex[" . $i . "]", $l[$i]->perex);
				$elem->setAttribs('value',$value);
				$podtitulek = $elem->render();
				//$elemDescription->setAttribs('class','mceEditorX');

				$l[$i]->title = $titulek . $podtitulek;

				//$l[$i]->titulek = $titulek;
				/**
				 * Umístění v TREE
				 * */
				$elemUmisteni = new G_Form_Element_Select("category_id[" . $i . "]");
				$value = self::$getRequest->getPost("category_id[" . $i . "]", $l[$i]->category_id);
				$elemUmisteni->setAttribs('value',$value);
				$elemUmisteni->setAttribs('style','width:100px;');

				$pole = array();
				$attrib =array();
				$pole[0] = " -- none -- ";
				foreach ($rubrikyList as $key => $value)
				{
					$pole[$value->id] = $value->title;
					$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
				}
				$elemUmisteni->setMultiOptions($pole,$attrib);
				$l[$i]->category_nazev = $elemUmisteni->render();
				$l[$i]->edit_label ='';
				if (!is_null($l[$i]->last_edit)) {
					$l[$i]->edit_label = '<a href="' . URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->user_edit . '">' . $l[$i]->editor . '</a><br />' . date("j.n.Y H:i:s",strtotime($l[$i]->last_edit));
				}

				$l[$i]->add_label = '<a href="' . URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->uid_user . '">' . $l[$i]->autor . '</a><br />' . date("j.n.Y H:i:s",strtotime($l[$i]->caszapsani));

				$l[$i]->cmd = '';
			} else {
				$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$elem->setAttribs('value', $l[$i]->id);
				//$elem->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elem->render();

				$titulek = '<a href="' . $url . '"><strong>' . $l[$i]->title . '</strong></a>';

				$titulek .= '<br /><span class="trunc_text">';
				if (!empty($l[$i]->perex))
				{
					$titulek .= trim(substr(trim(strip_tags($l[$i]->perex)),0,150)); }
				else {
					$titulek .= trim(substr(trim(strip_tags($l[$i]->description)),0,150));
				}
				$titulek .= '</span>';

				$l[$i]->title = $titulek;

				if ($l[$i]->category_id==0)
				{
					$category =  '<span>None</span>';
				} else {
					$link_item = categoryToUrl($l[$i]->serial_cat_title,"/");
					$category = '<a title="'.$link_item.'" href="' . URL_HOME . 'admin/cat.php?id=' . $l[$i]->category_id . '">' . $link_item . '</a>';
				}

				$l[$i]->category_nazev = $category;

				$l[$i]->edit_label ='';
				if ($l[$i]->PageTimeStamp != $l[$i]->PageChangeTimeStamp) {
					$l[$i]->edit_label = '<a href="' . URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->user_edit . '">' . $l[$i]->editor . '</a><br />' . date("j.n.Y H:i:s",strtotime($l[$i]->PageChangeTimeStamp));
				}

				$l[$i]->add_label = '<a href="' . URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->uid_user . '">' . $l[$i]->autor . '</a><br />' . date("j.n.Y H:i:s",strtotime($l[$i]->PageTimeStamp));
				$commnad ='<a href="' . $url. '">Zobrazit</a> <a href="' . URL_HOME . 'admin/post_edit.php?id=' . $l[$i]->page_id . '">Upravit</a> <a href="' . $url . '">Smazat</a>';

				$l[$i]->cmd = $commnad;
			}

		}
		return $l;
	}
	public function categoryList(IListArgs $args)
	{

	/*	$params2 = $params;
		if (isset($params['stop_search']) && !empty($params['stop_search'])) {

		} else {
			$search_string 	= self::$getRequest->getQuery('q', '');
			if (isset($params['fulltext']) && !empty($params['fulltext'])) {
				$search_string = $params['fulltext'];
			}
			$params2["fulltext"] = $search_string;
		}


		if(isset($params['id_cat']) && is_numeric($params['id_cat']))
		{
			$params2["id_cat"] = $params['id_cat'];
		}

		if(isset($params['subcat']) && is_numeric($params['subcat']))
		{
			$params2["cat"] = $params['subcat'];
		}
		$querys = array();

		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'v.title');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'v.description');
		$orderFromQuery = $this->orderFromQuery($querys, 'p.TimeStamp DESC');
		$params2["order"] = $orderFromQuery;

		if(isset($params['order']) && !empty($params['order']))
		{
			$params2["order"] = $params['order'];
		}

*/

		$l = self::getList($args);
		$this->total = self::getTotalList();

		for($i=0;$i<count($l);$i++)
		{
			$l[$i]->link = URL_HOME . get_categorytourl($l[$i]->serial_cat_url);
		}
		return $l;
	}


	public function categoryListSitemap(IListArgs $params)
	{

		$list = $this->categoryList($params);
		$res='<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">
';

		//$root = $xml->add_node(0, 'SHOP');

		for ($i=0;$i<count($list);$i++)
		{
			//$item  = $xml->add_node($root, 'SHOPITEM');
			$res.='<url>
';
			$res.='<loc>' . $list[$i]->link . '</loc>
';
			$res.='</url>
';
		}
		$res.='</urlset>';
		return $res;
		//return $xml->create_xml();
	}


/*
	public function setMainFoto($catalog_id, $foto_id)
	{
		$model = new models_Category();
		$model->setMainFoto($catalog_id, $foto_id);
	}*/
}
?>
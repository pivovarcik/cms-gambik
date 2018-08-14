<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */


class PublishController extends PageVersionBase
{
	function __construct()
	{
		parent::__construct("Publish", "PublishVersion");


		$this->pageEntity = "PostEntity";
		$this->pageVersionEntity = "PostVersionEntity";

		//	self::$isVersioning = (VERSION_POST == 1) ? true : false;
		$settings = G_Setting::instance();
		$isVersioning = ($settings->get("VERSION_POST") == 1) ? true : false;
		self::$isVersioning = $isVersioning;
		self::$saveEntity = true;
	}

	public function setPageData($postdata, $originalData = null)
	{
		$data = parent::setPageData($postdata, $originalData);

		$name = "public_date";
		if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
			$public_date = date("Y-m-d H:i:s",strtotime($postdata["public_date"]));
			$data->PublicDate = $public_date;
		}

		$name = "public_date_end";
		if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
			$public_date = date("Y-m-d H:i:s",strtotime($postdata["public_date_end"]));
			$data->PublicDate_end = $public_date;
		}

		return $data;
	}
/*
	public function setPageVersionData($postdata, $page_id, $version)
	{

		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$versionData = parent::setPageVersionData($postdata, $page_id, $version, $languageList);

		return $versionData;
	}
*/
	public function saveAction()
	{
		//&& false !== self::$getRequest->getPost('id', false)
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('upd_post', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('PublishPostEdit');


			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();


				$PageEntity = self::setPageData($postdata, $form->page);

				$pageVersionEntities = self::setPageVersionData($postdata, $form->page->versionList, $PageEntity->version);

				if (self::saveData($PageEntity, $pageVersionEntities, $form)) {
					$form->setResultSuccess("Článek byl aktualizován.");
					self::$getRequest->goBackRef();
				}



/*
				$pageSaveData = self::setPageData($postdata, $form->page);
				$pageSaveData["id"] = $form->page->id;
				$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData["id"], $pageSaveData["version"]);

				if (self::saveData($pageSaveData, $pageVersionSaveData, $form)) {

					$form->setResultSuccess("Článek byl aktualizován.");

					self::$getRequest->goBackRef();
				}*/

			}

		}
	}

	public function createAction()
	{

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins_post', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('PublishPostCreate');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				$postdata = $form->getValues();

				$PageEntity = self::setPageData($postdata);
				$pageVersionEntities = self::setPageVersionData($postdata, $form->page->versionList, $PageEntity->version);


				if (self::saveData($PageEntity, $pageVersionEntities, $form)) {

					$pageSaveData = self::getPageSaveData();

					$form->setResultSuccess('Článek byl přidán. <a href="'.URL_HOME.'post_edit?id='.$pageSaveData->id.'">Přejít na právě pořízený záznam.</a>');
					self::$getRequest->goBackRef();

				}

/*
				$pageSaveData = self::setPageData($postdata);
				$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData["id"], $pageSaveData["version"]);

				if (self::saveData($pageSaveData, $pageVersionSaveData, $form)) {

					//$form->setResultSuccess("Článek byl přidán.");

					$pageData = self::getPageSaveData();

					$page_id = $pageData["id"];
					$form->setResultSuccess('Článek byl přidán. <a href="'.URL_HOME.'post_edit?id='.$page_id.'">Přejít na právě pořízený záznam.</a>');

					self::$getRequest->goBackRef();
				}*/
			}
		}
	}



	public function sendNewsletterTestAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('send_newsletter_test', false))
		{
			$form = $this->formLoad('PublishPostEdit');


			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();


				$komu = $_POST["email_test"];

				$zprava = $postdata["description_cs"];
				$predmet = $postdata["title_cs"]; //"Newsletter";
				if (empty($postdata["description_cs"])) {
					return false;
				}

				//$link_clanek = str_replace("//","/" ,URL_HOME2 . $form->page->link );

				$link_clanek = $form->page->link;
				if (substr($link_clanek,0,1) == "/") {
					$link_clanek = substr($link_clanek,1,strlen($link_clanek));
				}
				$link_clanek = URL_HOME2 . $link_clanek; //str_replace("//","/" ,URL_HOME2 . $link_clanek );

				//$link_clanek = str_replace("//","/" ,URL_HOME2 . $form->page->link );
				//	$link_clanek = $form->page->link;

				//$komu = "info@svetfirem.cz";

				//$komu = "rudik.gambik@seznam.cz";
				//$komu = "rudolf.pivovarcik@centrum.cz";
				$res = "";


				$MailingController = new MailingController();



				$pocetNewsletteru = 0;


				if ($MailingController->odeslatNewsletter($komu,$predmet,$zprava,$link_clanek)) {
					$pocetNewsletteru++;
				}

				$form->setResultSuccess("Testovací článek odeslán " . $pocetNewsletteru .  ".");
				self::$getRequest->goBackRef();
			}
		}
	}

  
  	public function sendNewsletterAjaxAction()
	{
		if(self::$getRequest->isPost() && "send_news" === self::$getRequest->getPost('F_NewsletterCreate_action', false))
		{
			// načtu Objekt formu

			$form = $this->formLoad('NewsletterCreate');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{
				$model = new models_Mailing();
				$postdata = $form->getValues();
         		//		$zprava = $postdata["description_cs"];
         				$zprava = $form->page->description;
				$predmet = $postdata["title_cs"]; //"Newsletter";
				if (empty($postdata["description_cs"])) {
					return false;
				}
        
       				$link_clanek = $form->page->link;
				if (substr($link_clanek,0,1) == "/") {
					$link_clanek = substr($link_clanek,1,strlen($link_clanek));
				}
				$link_clanek = URL_HOME2 . $link_clanek; //str_replace("//","/" ,URL_HOME2 . $link_clanek );


				$res = "";


				$MailingController = new MailingController();


				$modelUser = new models_Users();

				$args = new ListArgs();
				$args->limit = 10000;
				$args->page = 1;
				$args->newsletter = 1;
				$args->aktivni = 1;
				$newsletterList = $modelUser->getList($args);

				$pocetNewsletteru = 0;
				//print_r($newsletterList);

				//	exit;
				foreach ($newsletterList as $key => $user) {

					if (!empty($user->email) && isEmail($user->email)) {
						$komu = strtolower($user->email);

						//	print $komu . "<br />";
						if ($MailingController->odeslatNewsletter($komu,$predmet,$zprava,$link_clanek)) {
							$pocetNewsletteru++;
  					}	else {
  					$form->setResultError($MailingController->exception_text);
  				}
					}

				} 
        
        
        					$form->setResultSuccess("SMS zpráva byla odeslána.");
					return true;
        



			}
		}
	}
	public function sendNewsletterAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('send_newsletter', false))
		{
			$form = $this->formLoad('PublishPostEdit');


			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();



				$zprava = $postdata["description_cs"];
				$predmet = $postdata["title_cs"]; //"Newsletter";
				if (empty($postdata["description_cs"])) {
					return false;
				}


				//$link_clanek = str_replace("//","/" ,URL_HOME2 . $form->page->link );
				//$link_clanek = $form->page->link;
				/*
				   if (substr($link_clanek,0,1) == "/") {
				   $link_clanek = substr($link_clanek,1,strlen($link_clanek));
				   }
				   $link_clanek = URL_HOME2 . $link_clanek; //str_replace("//","/" ,URL_HOME2 . $link_clanek );
				*/

				$link_clanek = $form->page->link;
				if (substr($link_clanek,0,1) == "/") {
					$link_clanek = substr($link_clanek,1,strlen($link_clanek));
				}
				$link_clanek = URL_HOME2 . $link_clanek; //str_replace("//","/" ,URL_HOME2 . $link_clanek );

				$komu = "info@svetfirem.cz";

				$komu = "rudik.gambik@seznam.cz";
				$komu = "rudolf.pivovarcik@centrum.cz";
				$res = "";


				$MailingController = new MailingController();


				$modelUser = new models_Users();

				$args = new ListArgs();
				$args->limit = 10000;
				$args->page = 1;
				$args->newsletter = 1;
				$args->aktivni = 1;
				$newsletterList = $modelUser->getList($args);

				$pocetNewsletteru = 0;
				//print_r($newsletterList);

				//	exit;
				foreach ($newsletterList as $key => $user) {

					if (!empty($user->email) && isEmail($user->email)) {
						$komu = strtolower($user->email);

						//	print $komu . "<br />";
						if ($MailingController->odeslatNewsletter($komu,$predmet,$zprava,$link_clanek)) {
							$pocetNewsletteru++;
						}
					}

				}

				$form->setResultSuccess("Článek odeslán " . $pocetNewsletteru .  " odběratelům newslleteru.");
				self::$getRequest->goBackRef();
			}
		}
	}

	public function recoveryAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('recovery_post', false))
		{
			$tenzin = self::$getRequest->getPost('recovery_post', false);

			if (is_array($tenzin)) {
				list($key,$value) = each($tenzin);
				//	print $key;
				$catalog_id = $_POST['id'][$key];
			} else {
				$catalog_id = $_POST['id'];
			}


			if ($catalog_id) {
				$catalog_id = (int) $catalog_id;

				$model = new models_Publish();
				$catalog = $model->getDetailDeletedById($catalog_id);
				if ($catalog) {
					// ověřím vlastníka
					if ($catalog->user_id != USER_ID) {
						// Nejsi vlastník


						if (USER_ROLE_ID != 2) {
							// Ani správce
							return false;
						}

					}

					$data = array();
					$data["isDeleted"] = 0;

					if($model->updateRecords($model->getTableName(),$data,"id=" . $catalog_id))
					{
						$protokolController = new ProtokolController();
						$protokolController->setProtokol("Obnoven článek","Článek <strong>" . $catalog->titulek_cs . "</strong> (" . $catalog_id . ") byl obnoven.");
					}
				} else {
					print "článek nenalezen";
				}

			}

		}
	}


	public function deleteAjaxAction()
	{

		if(self::$getRequest->isPost()
			&& "PublishDelete" == self::$getRequest->getPost('action', false))
		{
			$doklad_id = (int) self::$getRequest->getQuery('id', 0);

			if ($doklad_id) {
				$model = new models_Publish();
				$obj = $model->getDetailById($doklad_id);

				if ($obj) {
					$data = array();
					$data["isDeleted"] = 1;
					if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
					{
						array_push($seznamCiselObjednavek,$obj->id );
						return true;
					}
				}

			}
		}
	}

	public function deleteAction()
	{

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "deletePublish" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Publish();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {

							if ($obj->user_id != USER_ID) {
								// Nejsi vlastník
								if (USER_ROLE_ID != 2) {
									// Ani správce
									$_SESSION["statusmessage"]= "Smazat článek může pouze vlastník nebo správce.";
									$_SESSION["classmessage"]="errors";
									return false;
								}
							}

							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,"#".$obj->id );
							}
						}
					}
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Článek " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}

		}
	}
	public function deleteActionOld()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('delete_post', false))
		{
			$tenzin = self::$getRequest->getPost('delete_post', false);

			if (is_array($tenzin)) {
				list($key,$value) = each($tenzin);
				//	print $key;
				$catalog_id = $_POST['id'][$key];
			} else {
				$catalog_id = $_POST['id'];
			}


			if ($catalog_id) {
				$catalog_id = (int) $catalog_id;

				$model = new models_Publish();
				$catalog = $model->getDetailById($catalog_id);
				if ($catalog) {
					// ověřím vlastníka
					if ($catalog->user_id != USER_ID) {
						// Nejsi vlastník
						if (USER_ROLE_ID != 2) {
							// Ani správce
							$_SESSION["statusmessage"]= "Smazat článek může pouze vlastník nebo správce.";
							$_SESSION["classmessage"]="errors";
							return false;
						}
					}

					$data = array();
					$data["isDeleted"] = 1;

					if($model->updateRecords($model->getTableName(),$data,"id=" . $catalog_id))
					{
						$protokolController = new ProtokolController();
						$protokolController->setProtokol("Smazán článek","Článek <strong>" . $catalog->titulek_cs . "</strong> (" . $catalog_id . ") byl označen jako smazaný.");
						$_SESSION["statusmessage"]="Článek byl přesunut do koše.";
						$_SESSION["classmessage"]="success";
						self::$getRequest->goBackRef();
					}
				}
			}

		}
	}
	public function getPublish()
	{
		$id = self::$getRequest->getQuery("id",0);
		$url = self::$getRequest->getQuery("item","");
		if ($id >0) {
			$model = new models_Publish();
			$detail = $model->getDetailById($id);
		} elseif (!empty($url)) {
			$model = new models_Publish();
			$settings = G_Setting::instance();
			if ($settings->get("POST_URL_ID_PREFIX") == "1") {

				$pole = explode("-", $url);
				$detail = $model->getDetailById((int) $pole[0]);
			} else {
				$detail = $model->getDetailByUrl($url);
			}
		} else {
			print "nebyl specifkován požadavek!";
			return false;
		}
		if ($detail) {
    
        if (strpos($detail->serial_cat_url,"|secret|") !== false) {
         return false;
    }
    
		//	print_r($detail);
			$detail->pagetitle = !empty($detail->pagetitle) ? $detail->pagetitle : $detail->title;
			//$detail->pagekeywords = !empty($detail->pagekeywords) ? $detail->pagekeywords : $detail->titulek;
			$detail->pagedescription = !empty($detail->pagedescription) ? $detail->pagedescription : $detail->description;
/*
			$detail->url_friendly = URL_HOME . get_categorytourl($detail->serial_cat_url) . $detail->url_friendly . '.html';
			$detail->url_friendly_cs = URL_HOME . get_categorytourl($detail->serial_cat_url_cs) . $detail->url_friendly_cs . '.html';
			$detail->url_friendly_en = URL_HOME . get_categorytourl($detail->serial_cat_url_en) . $detail->url_friendly_en . '.html';
			$detail->url_friendly_de = URL_HOME . get_categorytourl($detail->serial_cat_url_de) . $detail->url_friendly_de . '.html';
			$detail->url_friendly_ru = URL_HOME . get_categorytourl($detail->serial_cat_url_ru) . $detail->url_friendly_ru . '.html';
*/
			return $detail;
		}

	}
	public function publishListEdit($params = array())
	{
		$l = $this->publishList($params);
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

				$title2 = $l[$i]->title;

				if (!empty($l[$i]->perex))
				{
					$titulek .= trim(truncateUtf8(trim(strip_tags($l[$i]->perex)),150,true,true)); }
				else {
					$titulek .= trim(truncateUtf8(trim(strip_tags($l[$i]->description)),150,true,true));
				}
				$titulek .= '</span><br /><a style="font-size:90%;" target="_blank" href="'.$l[$i]->link.'">' . $l[$i]->link . '</a>';

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

				if ($l[$i]->isDeleted == 1) {
					$command = '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu OBNOVIT článek: '.$title2.'?\')" type="image" src="'.URL_HOME . 'admin/recycle.gif" value="<>" name="recovery_post[' . $i . ']"/>';
					$command .= '<input type="hidden" value="' . $l[$i]->page_id . '" name="id[' . $i . ']"/>';

				} else {
					$command ='<a href="' . $url. '">Zobrazit</a> <a href="' . URL_HOME . 'admin/post_edit.php?id=' . $l[$i]->page_id . '">Upravit</a>';
					$command .= '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu SMAZAT článek: '.$title2.'?\')" type="image" src="'.URL_HOME . 'admin/action_delete.gif" value="X" name="delete_post[' . $i . ']"/>';
					$command .= '<input type="hidden" value="' . $l[$i]->page_id . '" name="id[' . $i . ']"/>';
				}



				$l[$i]->cmd = $command;
			}

		}
		return $l;
	}
	public function publishRecycledListEdit($params = array())
	{
		$params["deleted"] = 1;

		return $this->publishListEdit($params);
	}
	public function publishList($params = array())
	{


		$params2 = $params;

		if(isset($params['deleted']) && is_int($params['deleted']))
		{
			$params2['deleted'] = $params['deleted'];
		}


		$params2['lang'] = LANG_TRANSLATOR;

		if (isset($params['stop_search']) && !empty($params['stop_search'])) {

		} else {
			$search_string 	= self::$getRequest->getQuery('q', '');
			if (isset($params['fulltext']) && !empty($params['fulltext'])) {
				$search_string = $params['fulltext'];
			}
			$params2["fulltext"] = $search_string;
		}


		$cat	= (int) self::$getRequest->getQuery('cat', 0);
		if (isset($params['cat'])) {
			$cat = $params['cat'];
		}
		$params2["cat"] = $cat;


		if (isset($params['id_cat']) && is_numeric($params['id_cat'])) {
			$params2['id_cat'] = $params['id_cat'];
		}

		$user	= (int) self::$getRequest->getQuery('user', 0);
		if (isset($params['user']) && is_numeric($params['user'])) {
			$user = $params['user'];
		}

		if (isset($params['all_public_date']) && is_numeric($params['all_public_date'])) {
			$params2["all_public_date"] = $params['all_public_date'];
		}

		$params2["user"] = $user;


		$querys = array();

		$querys[] = array('title'=>'Název','url'=>'title','sql'=>'v.title');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'v.description');
		$querys[] = array('title'=>'Popis','url'=>'date','sql'=>'p.TimeStamp');
		$querys[] = array('title'=>'Popis','url'=>'last','sql'=>'p.ChangeTimeStamp');
		$querys[] = array('title'=>'Popis','url'=>'edit','sql'=>'ue.nick');
		$querys[] = array('title'=>'Popis','url'=>'nick','sql'=>'ua.nick');
		$orderFromQuery = $this->orderFromQuery($querys, 'p.TimeStamp DESC');
		$params2["order"] = $orderFromQuery;
		//print $orderFromQuery;
		if (isset($params['order']) && !empty($params['order'])) {
			$params2["order"] = $params['order'];
		}


		$l = self::getList($params2);
		$this->total = self::getTotalList();


		return $l;
	}


}
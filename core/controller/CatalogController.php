<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 *
 * status,
 * vip,
 * description,
 * address1,
 * address1,
 * psc
 * telefon
 * poznamka
 * lng, lat
 */



class CatalogController extends PageVersionBase
{
	public $photos = array();
	public $total = 0;
	public $programs = array();
	public $services = array();



	function __construct($TCatalog = "Catalog", $TCatalogVersion = "CatalogVersion")
	{
		parent::__construct($TCatalog, $TCatalogVersion);
		//	self::$isVersioning = (VERSION_POST == 1) ? true : false;
		$settings = G_Setting::instance();
		$isVersioning = ($settings->get("VERSION_CATALOG") == 1) ? true : false;
		self::$isVersioning = $isVersioning;
	}


	public function catalogListTable($params = array())
	{

		$l = $this->catalogListEdit($params);

		//print_r($l);
		$sorting = new G_Sorting("num","desc");

		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
	//	$column["preview"] = '';
		$column["title"] = $sorting->render("Název", "num");
		$column["nazev_category"] = $sorting->render("Kategorie", "cat");
		$column["kontakt"] = $sorting->render("Kontakt", "kontakt");
		$column["registrace_expirace"] = $sorting->render("Registrace", "reg");
		//$column["skupina_nazev"] = $headCat;
		$column["vlozeno_zmeneno"] = $sorting->render("Založen", "add");

		$column["cmd"] = '';

		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["preview"]["class"] = "column-thumb";

		$th_attrib["cislo_mat"]["class"] = "column-num";
		$th_attrib["skupina_nazev"]["class"] = "column-cat";
		$th_attrib["category_nazev"]["class"] = "column-cat";
		$th_attrib["nazev_vyrobce"]["class"] = "column-cat";
		$th_attrib["prodcena"]["class"] = "column-price";
		$th_attrib["qty"]["class"] = "column-qty";

		$th_attrib["cmd"]["class"] = "column-cmd";


		$td_attrib["qty"]["class"] = "column-qty";
		$td_attrib["prodcena"]["class"] = "column-price";

		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
								"class" => "widefat fixed",
								"id" => "data_grid",
								"cellspacing" => "0",
								);
		return $table->makeTable($table_attrib);

	}

	public function catalogListEdit($params = array())
	{
		$l = $this->catalogList($params);

		$imageController = new ImageController();

		for ($i=0;$i < count($l);$i++)
		{
			$url = URL_HOME . "admin/edit_catalog.php?id=" . $l[$i]->page_id;

				if (!empty($l[$i]->file)) {

					$PreviewUrl = '<img alt="" title="" src="' . $imageController->get_thumb($l[$i]->file) . '" class="imgobal">';
				} else {
					$PreviewUrl = '';
				}
				$l[$i]->preview = $PreviewUrl;


				$uid = $l[$i]->page_id;
				$elemUid = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->page_id;
				$elemUid->setAttribs('value', $value);
				//$elemUid->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemUid->render();




				$command = "";
				if ($l[$i]->status_id <> 3) {


					$command .= '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu SMAZAT podnik: '.$titulek.'?\')" type="image" src="'.URL_HOME . 'admin/action_delete.gif" value="X" name="hide_catalog[' . $i . ']"/>';

					$command .= '<input type="hidden" value="' . $l[$i]->page_id . '" name="catalog_id[' . $i . ']"/>';
				}

				if ($l[$i]->status_id == 3) {
					$command .= '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu OBNOVIT podnik: '.$titulek.'?\')" type="image" src="'.URL_HOME . 'admin/recycle.gif" value="<>" name="recycle_catalog[' . $i . ']"/>';

					$command .= '<input type="hidden" value="' . $l[$i]->page_id . '" name="catalog_id[' . $i . ']"/>';
				}
				$l[$i]->cmd = $command . ' <a href="'.$url.'">edit</a>';

				$elemStatus = new G_Form_Element_Checkbox("status[" . $i . "]");
				$value = 1;
				$elemStatus->setAttribs('value', $value);
				$elemStatus->setAttribs('disabled', 'disabled');
				if ($l[$i]->status == 1) {
					$elemStatus->setAttribs('checked', 'checked');
				}

				$l[$i]->status = $elemStatus->render();

				$datum_registrace = date("j.n.Y", strtotime($l[$i]->registrace));
				$datum_expirace = date("j.n.Y", strtotime($l[$i]->expirace));
				$l[$i]->registrace_expirace = $datum_registrace . '<br />' . $datum_expirace;

				$datum_vlozeni = date("j.n.Y H:i", strtotime($l[$i]->TimeStamp)) . ' <a title="Zobrazit detail uživatele: ' . $l[$i]->user_add . '" href="'.URL_HOME.'admin/user_detail.php?id='.$l[$i]->uid_user.'">' . $l[$i]->user_add . '</a>';
				if (!empty($l[$i]->ChangeTimeStamp)) {
					$datum_editace = date("j.n.Y H:i", strtotime($l[$i]->ChangeTimeStamp)) . ' <a title="Zobrazit detail uživatele: ' . $l[$i]->user_edit . '" href="'.URL_HOME.'admin/user_detail.php?id='.$l[$i]->uid_user_edit.'">' . $l[$i]->user_edit . '</a>';
				} else {
					$datum_editace = '';
				}
				$l[$i]->mesto_nazev = $l[$i]->mesto_nazev . ", " . $l[$i]->address1;
				$l[$i]->vlozeno_zmeneno = $datum_vlozeni . '<br />' . $datum_editace;

				$l[$i]->kontakt = $l[$i]->kontaktni_osoba . "<br />" . $l[$i]->email . "<br />" . $l[$i]->telefon;



				$nazevMat = '<h4><a href="' . $url . '">' . $l[$i]->title . '</a></h4>';
				$nazevMat .= $l[$i]->mesto_nazev;
				$l[$i]->td_title = $nazevMat;

				$l[$i]->td_description = trim(truncate(trim(strip_tags($l[$i]->description)),150));



		}
		return $l;
	}
	public function catalogList($params = array())
	{
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}

	//	$model = new models_Catalog();

		$limit 	= self::$getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		$params['limit'] = $limit;

		$page 	= self::$getRequest->getQuery('pg', 1);
		$params['page'] = $page;

		$search_string = self::$getRequest->getQuery('q', '');
		$params['search'] = $search_string;


		$skupina = self::$getRequest->getQuery('grp', '');
		$category = (int) self::$getRequest->getQuery('cat', 0);

		$category = (int) self::$getRequest->getQuery('cat2', $category);
		if ($category == 0) {
			$category = '';
		}
		if (isset($_GET["cat2"]) && is_array($_GET["cat2"])) {
			$category = $_GET["cat2"];
			//	print "poleeeeeeeeeeee";
		}
		$params['cat'] = $category;




		$tree = self::$getRequest->getQuery('tree', '');
		if (isset($params['tree']) && is_numeric($params['tree'])) {
			$tree = $params['tree'];
		}
		$params['tree'] = $tree;


		//print $tree;
		$kraj = self::$getRequest->getQuery('kr', '');
		if (isset($params['kraj']) && is_numeric($params['kraj']) && $params['kraj']>0) {
			$kraj = $params['kraj'];
		}
		$params['kraj'] = $kraj;

		$mesto = self::$getRequest->getQuery('city', '');
		if (isset($params['city']) && is_numeric($params['city']) && $params['city']>0) {
			$mesto = $params['city'];
		}
		$params['city'] = $mesto;


		$vlastnik = "";
		if (isset($params['vlastnik']) && is_numeric($params['vlastnik']) && $params['vlastnik']>0) {
			$vlastnik = $params['vlastnik'];
		}
		$params['vlastnik'] = $vlastnik;

		$status = (int)self::$getRequest->getQuery('status', 1);
		if (isset($params['status']) && is_numeric($params['status']) && $params['status']>0) {
			$status = (int) $params['status'];
		}

		switch($status){
			case 1:
				$status = 1;
				break;
			case 2:
				$status = 0;
				break;
			case 3:
				$status = 3;
				break;
			default:
				$status = '';
		}
		if (isset($params['status']) && is_array($params['status'])) {
			$status = $params['status'];
		}
		$params['status'] = $status;

		$querys = array();
		$querys[] = array('title'=>'Název','url'=>'title','sql'=>'v.title');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'v.description');
		$querys[] = array('title'=>'Zařazení','url'=>'cat','sql'=>'t5.nazev_' . $znak);
		$querys[] = array('title'=>'Město','url'=>'city','sql'=>'t2.mesto');

		$querys[] = array('title'=>'Vloženo','url'=>'add','sql'=>'p.TimeStamp');
		$querys[] = array('title'=>'Editace','url'=>'edit','sql'=>'p.ChangeTimeStamp');
		$querys[] = array('title'=>'Registrace','url'=>'reg','sql'=>'v.registrace');
		$querys[] = array('title'=>'Expirace','url'=>'exp','sql'=>'v.expirace');

		$random = self::$getRequest->getSession('rand', false);
		$orderFromQuery = $this->orderFromQuery($querys, 'RAND(' . $random . ')');
		//print $orderFromQuery;
		if (empty($orderFromQuery)) {

			$orderFromQuery = 'RAND(' . $random . ')';
			if (isset($params['order_default']) && !empty($params['order_default']))
			{
				$orderFromQuery = $params['order_default'];
			}
		}


		if (isset($params['order']) && !empty($params['order'])) {
			$orderFromQuery = $params['order'];
		}


		$trideni = self::$getRequest->getQuery('ord', '');

		switch($trideni){
			case 'ta':
				$orderFromQuery = 'v.title ASC';
				break;
			case 'td':
				$orderFromQuery = 'v.title DESC';
				break;
			case 'old':
				$orderFromQuery = 'p.TimeStamp ASC';
				break;
			case 'nws':
				$orderFromQuery = 'p.TimeStamp DESC';
				break;
			case 'ran':
				// Možnost náhodného třídění

				if ($random !== false) {
					$random = (float) $random;
					$orderFromQuery = 'RAND(' . $random . ')';

				}
				break;
		}
		$params['order'] = $orderFromQuery;

		$l = self::$model->getList($params);

	//	print self::$model->getLastQuery();
		$this->total = self::$model->total;
		return $l;
	}

/*	public function setMainFoto($catalog_id, $foto_id)
	{
		$model = new models_Catalog();
		$model->setMainFoto($catalog_id, $foto_id);
	}*/
	public function setMainLogo($catalog_id, $foto_id)
	{
		$model = new models_Catalog();
		$model->setMainLogo($catalog_id, $foto_id);
	}


	public function setPageData($postdata, $originalData = null)
	{
		$data = parent::setPageData($postdata, $originalData);

		$name = 'vlastnik_id';
		if (array_key_exists($name, $postdata) && USER_ROLE_ID == 2) {
			//ošetření 0
			if ($postdata[$name]==0) {
				$postdata[$name] = null;
			}
			$data[$name] = $postdata[$name];
		}


		$name = 'status_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			$data[$name] = $postdata[$name];
		}

		return $data;
	}

	public function setPageVersionData($postdata, $page_id, $version)
	{

		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$versionData = parent::setPageVersionData($postdata, $page_id, $version, $languageList);

		$i = 0;
		foreach ($languageList as $key => $val){


			$name = 'interni_poznamka';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$name = 'status_id';
			if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$i++;
		}

	//	print_r($versionData);
	//	exit;
		return $versionData;
	}

	public function akcePoUlozeni()
	{
		//print "akce po uložení";

		$data = self::getPageSaveData();

		$page_id = (int) $data["id"];
		$all_query_ok = true;


		if (isset($_POST["vybaveni"]) && is_array($_POST["vybaveni"])) {

			self::$model->deleteRecords(T_CATALOG_VYBAVENI_ASSOC,"catalog_id={$page_id}");
			self::$model->commit ? null : $all_query_ok = false;

			foreach ($_POST["vybaveni"] as $key => $value ){
				$data2 = array();
				$data2["catalog_id"] = $page_id;
				$data2["vybaveni_id"] = $value;

				//print_r($data2);
				self::$model->insertRecords(T_CATALOG_VYBAVENI_ASSOC, $data2);

				self::$model->commit ? null : $all_query_ok = false;
			}
		}




		if (isset($_POST["program"]) && is_array($_POST["program"])) {

			self::$model->deleteRecords(T_CATALOG_PROGRAM_ASSOC,"catalog_id={$page_id}");
			self::$model->commit ? null : $all_query_ok = false;

			foreach ($_POST["program"] as $key => $value ){
				$data2 = array();
				$data2["catalog_id"] = $page_id;
				$data2["program_id"] = $value;

				//print_r($data2);
				self::$model->insertRecords(T_CATALOG_PROGRAM_ASSOC, $data2);

				self::$model->commit ? null : $all_query_ok = false;
			}
		}
		return $all_query_ok;
	}

	public function saveAction()
	{
		// Je odeslán formulář
		//	&& false !== self::$getRequest->getPost('id', false)
		if(self::$getRequest->isPost()
			&& false !== self::$getRequest->getPost('upd_catalog', false)
			)
		{

			// načtu Objekt formu
			$form = $this->formLoad('CatalogEdit');
				// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();


				$pageSaveData = self::setPageData($postdata, $form->page);
				$pageSaveData["id"] = $form->page->page_id;
				$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData["id"], $pageSaveData["version"]);


				if (self::saveData($pageSaveData, $pageVersionSaveData)) {

					$form->setResultSuccess("Detail byl uložen.");
					$protokolController = new ProtokolController();
					$protokolController->setProtokol("Editace podniku","Byl uživatelem upraven podnik <strong><a href=\"/admin/edit_catalog.php?id=" . $id . "\">" . $postdata["title"] . "</a></strong> (" . $id . ").");

					self::$getRequest->goBackRef();
				} else {
					$form->setResultError(self::akcePoUlozeniSChybou());
				}

			}
		}

	}

	/*
	protected function deleteCatalog()
	{

		$actionName = self::$TPage;
	//	print str_replace("Entity", "" ,$this->pageEntity);
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "delete" . $actionName == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {

						$obj = self::$model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if(self::$model->updateRecords(self::$model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$doklad_id );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="záznam " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}

		}
	}*/

	public function deleteAction()
	{
		$actionName = self::$TPage;
		//PRINT $actionName;
		//	print str_replace("Entity", "" ,$this->pageEntity);
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "delete" . $actionName == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {

						$obj = self::$model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if(self::$model->updateRecords(self::$model->getTableName(),$data,"id=".$doklad_id))
							{
							//	print self::$model->getLastQuery();
								//print self::$model->getTableName();
								array_push($seznamCiselObjednavek,$doklad_id );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="záznam " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}

		}
	}

	// Zobecnit mazání pro potomky
/*	public function deleteActionOld()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('hide_catalog', false))
		{

			$tenzin = self::$getRequest->getPost('hide_catalog', false);

			if (is_array($tenzin)) {
				list($key,$value) = each($tenzin);
				//	print $key;
				$catalog_id = $_POST['catalog_id'][$key];
			} else {
				$catalog_id = $_POST['catalog_id'];
			}
			if ($catalog_id) {
				$catalog_id = (int) $catalog_id;
				$model = new models_Catalog();


				//$row = $model->getRow($product_id);

				//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
				//if ($row) {
				//$_fotoPlaces->setData($data);

				$catalog = $model->getDetailById($catalog_id);
				if ($catalog) {

					// ověřím vlastníka
					if ($catalog->user_id != USER_ID || $catalog->vlastnik_id != USER_ID) {
						// Nejsi vlastník


						if (USER_ROLE_ID != 2) {
							// Ani správce
							return false;
						}

					}

					$data = array();
					$data["status_id"] = 3;
					$data["isDeleted"] = 1;

					if($model->updateRecords($model->getTableName(),$data,"id=" . $catalog_id))
					{

						mail("registrace@sexvemeste.cz","Smazani profilu - podnik","Profil podniku byl smazan <strong><a href=\"http://www.sexvemeste.cz/admin/edit_catalog.php?id=" . $catalog_id . "\">" . $postdata["titulek_cs"] . "</a></strong> do katalogu  (" . $catalog_id . ").");


						$protokolController = new ProtokolController();
						//$protokolController->setProtokol("Smazání podniku","Dívka <strong>" . $catalog->titulek_cs . "</strong> (" . $catalog_id . ") byl označen jako smazaný.");

						$protokolController->setProtokol("Smazání podniku","Podnik <strong><a href=\"http://www.sexvemeste.cz/admin/edit_catalog.php?id=" . $catalog_id . "\">" . $catalog->titulek_cs . "</a></strong> (" . $catalog_id . ") byla označen jako smazaný.");

						$message ='Podnik <strong>' . $catalog->title . '</strong></a> byl smazán.';
						$modelMessage = new models_Message();
						$modelMessage->setMessage(3, USER_ID, $message);
						//self::$getRequest->goBackRef();
					}
				}
				//}
			}

		}
	}*/

	public function auditAction($catalog_id)
	{
		$model = new models_Catalog();
		$catalog = $model->getDetailById($catalog_id);
		$data = array();
		$data["counter"] = $catalog->counter +1;
		if($model->updateRecords($model->getTableName(),$data,"id=" . $catalog_id))
		{
			$insertData = array();
			$insertData["catalog_id"] = $catalog_id;
			if (USER_ID > 0) {
				$insertData["user_id"] = USER_ID;
			}
			$insertData["ip"] = $_SERVER["REMOTE_ADDR"];
		/*	if($model->insertRecords("mm_catalog_audit",$insertData))
			{
				return true;
			}*/

		}
	}

	public function recycleAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('recycle_catalog', false))
		{
			//print "mažu";
			//print
			/*
			   foreach(self::$getRequest->getPost('del_product', false) as $key => $value)
			   {
			   list($key,$value);
			   }*/
			$tenzin = self::$getRequest->getPost('recycle_catalog', false);

			if (is_array($tenzin)) {
				list($key,$value) = each($tenzin);
				//	print $key;
				$catalog_id = $_POST['catalog_id'][$key];
			} else {
				$catalog_id = $_POST['catalog_id'];
			}

			//	print_r(self::$getRequest->getPost('product_id[$key]', false));
			//	$product_id = self::$getRequest->getPost('product_id['.$key.']', false);
			/*
			   print $catalog_id;
			   exit;
			*/



			if ($catalog_id) {
				$catalog_id = (int) $catalog_id;
				//	$model = new models_Catalog();

				$model = new models_Catalog();
				$catalog = $model->getCatalog($catalog_id);
				if ($catalog) {
					// ověřím vlastníka
					if ($catalog->uid_user != USER_ID) {
						// Nejsi vlastník


						if (USER_ROLE_ID != 2) {
							// Ani správce
							return false;
						}

					}

					$data = array();
					$data["status"] = 1;
					//$row = $model->getRow($product_id);

					//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
					//if ($row) {
					//$_fotoPlaces->setData($data);

					if($model->updateRecords($model->getTableName(),$data,"uid=" . $catalog_id))
					{
						$protokolController = new ProtokolController();
						$protokolController->setProtokol("Obnoven podnik","Podnik <strong>" . $catalog->titulek_cs . "</strong> (" . $catalog_id . ") byl obnoven.");
					}
				}

				//}
			}

		}
	}

	public function createAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins_catalog', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('CatalogCreate');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				$model = new models_Catalog();

				$postdata = $form->getValues();




				$pageSaveData = self::setPageData($postdata);
				$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData["id"], $pageSaveData["version"]);


				if (self::saveData($pageSaveData, $pageVersionSaveData)) {

					$pageData = self::getPageSaveData();
					$page_id = $pageData["id"];

					$_SESSION["statusmessage"]='<a href="'.URL_HOME.'edit_catalog?id='.$page_id.'">Přejít na právě pořízený záznam.</a>';
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}

			} else {
				foreach($form->getError() as $key => $value)
				{
					$_SESSION["err_elem"][$key] = $value;
					$_SESSION["statusmessage"]= $key . ": ". $value;

				}
				//print_r($form->getError());
				$_SESSION["statusmessage"]= "Nebyla vyplněna všechna povinná pole!";
				$_SESSION["classmessage"]="errors";
			}
		}
	}



	public function getCatalog($catalog_id){
		//$model = new models_Catalog();
		$catalog = self::$model->getDetailById($catalog_id);

	//	print_r($catalog);
		return $catalog;

	}

	public function sendRegisterUserInfo($data)
	{
		$subject = "Registrace podniku do erotického katalogu ZDARMA!";
		$visit = strtolower(substr(md5(rand()),0,50));
		$mail = new PHPMailer();
		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server

		$eshopController = new EshopController();

		$email_address = $data["email"];


		$mail->Host = $eshopController->setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($eshopController->setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;
		$mail->Username = $eshopController->setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $eshopController->setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci
		$mail->From = $eshopController->setting["EMAIL_ORDER"];
		$mail->FromName = $eshopController->setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele
		$mail->AddAddress($email_address);  // přidáme příjemce

		if (isset($data["email2"])) {
			$mail->AddBCC($data["email2"]);
		}


		$mail->Subject = $subject;
		$mail->AddBCC("registrace@sexvemeste.cz");
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);

		$mail->Body ='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs-CZ" lang="cs-CZ">';
		$mail->Body .='<head>';
		$mail->Body .='<title>' . $subject . '</title>';
		$mail->Body .='<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
		$mail->Body .='</head>';
		$mail->Body .='<body>';


		$mail->Body .='<div style="font-family: Arial, Tahoma, sans-serif; font-size: 16px;color:#000;width:600px;display:block;">';
		$mail->Body .='<a style="float: left;display:block;border:0 none;" href="http://www.sexvemeste.cz/?v=' . $visit . '"><img src="http://www.sexvemeste.cz/logo.png?v=' . $visit . '"></a>';

		$mail->Body .='<h1 style="padding: 0 0 0 5px; margin:0;height:35px;line-height:35px;float: left;font-size:20px;">' . $subject . '</h1>';
		$mail->Body .='<hr style="clear: both;border:0;border-top: 1px solid #aaa; margin: 5px 0;">';

		$mail->Body .='<div style="clear:both;background-color:#fff;border-top:0;padding:15px 15px 25px;">';
		$mail->Body .='<p style="font-size: 0.8em; margin: 5px 0px;">Rádi bychom Vás informovali o přidání Vašeho podniku <a href="'.$data["link"].'?='.$visit.'"><strong>' . $data["podnik"] . '</strong></a> do největšího erotického online katalogu podniků v ČR.</p>';
		$mail->Body .='<p style="font-size: 0.8em; margin: 5px 0px;">Žádáme Vás o kontrolu zadaných údajů a případné další doplnění chybějících informací k Vašemu podniku (kontakty, nabízené služby, otevírací doba, fotogalerie, dívky a jiné).</p>';

		$mail->Body .='<div>';
		$mail->Body .='<h2 style="font-size: 0.9em;margin: 0 0 10px 0;text-decoration: underline;">Přihlašovací údaje:</h2>';

		$mail->Body .='<p style="font-size: 0.8em; margin: 5px 0px;"><span style="color: #5c3a53;">Email:&nbsp;</span>' . $data["email"] . '</p>';
		$mail->Body .='<p style="font-size: 0.8em; margin: 5px 0px;"><span style="color: #5c3a53;">Heslo:&nbsp;</span>' . $data["password"] . '</p>';

		$mail->Body .='<p></p>';
		$mail->Body .='<p style="font-size: 0.8em; margin: 5px 0px;">Pro přihlášení k Vašemu účtu navštivte prosím následující odkaz: <a target="_blank" href="http://www.sexvemeste.cz/login?v=' . $visit . '">přihlášení k účtu</a>';
		$mail->Body .='</p>';
		$mail->Body .='</div>';
		$mail->Body .='<hr style="clear: both;border:0;border-top: 1px solid #aaa; margin: 5px 0;">';
		$mail->Body .='<div style="padding:5px 0 10px;height:150px;width: 585px;color:#000;">';

		$mail->Body .='<div>';
		$mail->Body .='<h2 style="font-size: 0.9em;font-weight:bold;padding:10px 0 10px;margin:0px;">Potřebujete poradit?</h2>';
		$mail->Body .='<div>';
		$mail->Body .='<a target="_blank" href="mailto:info@sexvemeste.cz" style="font-size: 0.8em;text-decoration:underline;cursor:pointer;">info@sexvemeste.cz</a>';
		$mail->Body .='</div>';
		$mail->Body .='<div style="white-space: nowrap;font-size: 0.8em;">+420 606 06 06 08</div>';
		$mail->Body .='<div><a target="_blank" style="font-size: 0.8em;text-decoration:underline;cursor:pointer;" href="http://www.sexvemeste.cz/reklama?v=' . $visit . '">Inzerce na SexVeMěstě.cz</a></div>';
		$mail->Body .='</div>';

		$mail->Body .='<div style="padding:15px 0 10px;"><span style="font-size: 0.7em;color: #5c3a53;">Nepřejete-li si být nadále uvedeni zdarma v erotickém katalogu SexVeMěstě.cz, navštivte prosím následující <a href="http://www.sexvemeste.cz/vyrazeni-podniku?v=' . $visit . '">odkaz</a>.</span></div>';
		$mail->Body .='</div>';
		$mail->Body .='</div>';
		$mail->Body .='</div>';
		$mail->Body .='</body>';
		$mail->Body .='</html>';

		//return $mail->Send();

		if ($mail->Send()) {
			//print "odesláno";
			$model = new models_Mailing();

			$data2 = array();

			$data2["subject"] = $subject;


			$data2["description"] = $mail->Body;


			$data2["user_id"] = USER_ID;

			$model->setData($data2);
			if($model->insert())
			{

				$data2= array();
				$data2["email"] = $email_address;
				$data2["visitor"] = $visit;
				$data2["mailing_id"] = $model->insert_id;
				$model->insertRecords(T_NEWSLETTER_STATUS,$data2);

				return true;
			}

		} else {
			return false;
		}





	}
	public function sendInfoEmail($data)
	{
		//$eshop = new Eshop();
		$mail = new PHPMailer();
		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru
		$this->eshop = new Eshop();

		$cat = $this->eshop->get_category(array("id" => $data["category"]));
		//$data["kr"];


	//	print_R($this->eshop->eshop_setting);
		$mail->Host = $this->eshop->eshop_setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($this->eshop->eshop_setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;

		$mail->Username = $this->eshop->eshop_setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $this->eshop->eshop_setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci

		$mail->From = $this->eshop->eshop_setting["EMAIL_ORDER"];
		//$mail->From = "objednavky@kolakv.cz";   // adresa odesílatele skriptu
		//$mail->FromName = "Objednávka kolaKV.cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $this->eshop->eshop_setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele
		$mail->AddAddress($this->eshop->eshop_setting["INFO_EMAIL"]);  // přidáme příjemce
	//print 	$this->eshop->eshop_setting["INFO_EMAIL"];
		//$mail->AddAddress("rudolf.pivovarcik@centrum.cz");  // přidáme příjemce
		$mail->Subject = "Přidán podnik";
		//$mail->AddBCC($eshop->eshop_setting["BCC_EMAIL"]);
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);
		//$mail->AddAttachment($this->order_pdf, "objednavka.pdf");

		//$mail->AddAttachment($this->createPDF($_orders->insert_id), "objednavka.pdf");
		//	$mail->AddAttachment(dirname(__FILE__) . "/../../public/data/2011060024.pdf", "objednavka.pdf");
		//$this->createPDF($_orders->insert_id);
		//$mail->AddAttachment(dirname(__FILE__) . "/../../admin/2011060024.pdf", "objednavka.pdf");

		//	$mail->AddAttachment("/public/data/2011060024.pdf", "objednavka.pdf");
		//$mail->AddAttachment("admin/order_pdf.php?id=" . $_orders->insert_id, "objednavka.pdf");


		$mail->Body ='';
		$mail->Body .="<html>";
		$mail->Body .="<head></head>";
		$mail->Body .="<body>";

		//					$mail->Body .='Dobrý den,<br />Vaší objednávku jsme přijali ke zpracování.<br />V příloze naleznete detail objednávky<br />';
		$mail->Body .='Byl přidán nový podnik <strong>' . $data["titulek_cs"] . '</strong> z webu <strong>' . URL_DOMAIN . '</strong>.';
		$mail->Body .='<br /><br />';

		$mail->Body .="<p><label>Název podniku:</label> <strong>" . $data["titulek_cs"] . "</strong></p>";
		$mail->Body .="<p><label>Typ podniku:</label> <strong>" . $cat->nazev . "</strong></p>";
		$mail->Body .="<p><label>Kraj:</label> <strong>" . $data["kr"] . "</strong></p>";
		$mail->Body .="<p><label>Ulice, číslo:</label> <strong>" . $data["address1"] . "</strong></p>";
		$mail->Body .="<p><label>Město:</label> <strong>" . $data["address2"] . "</strong></p>";
		$mail->Body .="<p><label>Psč:</label> <strong>" . $data["zip_code"] . "</strong></p>";
		$mail->Body .="<p><label>Telefon:</label> <strong>" . $data["telefon"] . "</strong></p>";
		$mail->Body .="<p><label>Kontaktní telefon:</label> <strong>" . $data["ftelefon"] . "</strong></p>";
		$mail->Body .="<p><label>Email:</label> <strong>" . $data["titulek_cs"] . "</strong></p>";
		$mail->Body .="<p><label>WWW:</label> <strong>" . $data["www"] . "</strong></p>";
		$mail->Body .="<p><label>Vstupné:</label> <strong>" . $data["vstupne"] . "</strong></p>";

		$mail->Body .="<p><label>Otevírací doba:</label></p>";
		$mail->Body .="<p><label>Po-Pá:</label> <strong>" . $data["popa_start"] . " - " . $data["popa_end"] . "</strong></p>";
		$mail->Body .="<p><label>Út:</label> <strong>" . $data["ut_start"] . " - " . $data["ut_end"] . "</strong></p>";
		$mail->Body .="<p><label>St:</label> <strong>" . $data["st_start"] . " - " . $data["st_end"] . "</strong></p>";
		$mail->Body .="<p><label>Čt:</label> <strong>" . $data["ct_start"] . " - " . $data["ct_end"] . "</strong></p>";
		$mail->Body .="<p><label>Pá:</label> <strong>" . $data["pa_start"] . " - " . $data["pa_end"] . "</strong></p>";
		$mail->Body .="<p><label>So-Ne:</label> <strong>" . $data["sone_start"] . " - " . $data["sone_end"] . "</strong></p>";
		$mail->Body .="<p><label>Ne:</label> <strong>" . $data["ne_start"] . " - " . $data["ne_end"] . "</strong></p>";

		$mail->Body .="<p><label>Popis podniku:</label> <strong>" . $data["description_cs"] . "</strong></p>";


		/*	*/

		/*
		   $mail->Body .="<table>";


		   $mail->Body .= $mail_text;
		   $mail->Body .="</table>";
		*/
		//	$mail->Body .='děkujeme Vám za vytvoření objednávky v internetovém obchodě <a href="http://www.kolakv.cz">www.kolakv.cz</a>. Vaše objednávka byla přijata ke zpracování. V příloze Vám zasíláme kopii objednávky.';
		//	$mail->Body .='<br /><br />';
		$mail->Body .='<br /><br />Tato zpráva byla vygenerována systémem automaticky, neodpovídejte na ní!';
		$mail->Body .='<br />';
		$mail->Body .=URL_DOMAIN; // 'www.humboldt.cz';


		//					$mail->Body .='<p><a href="http://www.kolakv.cz">www.kolakv.cz</a></p>';
		$mail->Body .="</body></html>";

		return $mail->Send();
	}

	public function sendInfoEmail2($catalog_id,$data)
	{
		//$eshop = new Eshop();
		$mail = new PHPMailer();
		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru
		$this->eshop = new Eshop();

		$cat = $this->eshop->get_category(array("id" => $data["category"]));
		//$data["kr"];


		//	print_R($this->eshop->eshop_setting);
		$mail->Host = $this->eshop->eshop_setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($this->eshop->eshop_setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;

		$mail->Username = $this->eshop->eshop_setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $this->eshop->eshop_setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci

		$mail->From = $this->eshop->eshop_setting["EMAIL_ORDER"];
		//$mail->From = "objednavky@kolakv.cz";   // adresa odesílatele skriptu
		//$mail->FromName = "Objednávka kolaKV.cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $this->eshop->eshop_setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele
		$mail->AddAddress($this->eshop->eshop_setting["INFO_EMAIL"]);  // přidáme příjemce
		//print 	$this->eshop->eshop_setting["INFO_EMAIL"];
		//$mail->AddAddress("rudolf.pivovarcik@centrum.cz");  // přidáme příjemce
		$mail->Subject = "Přidán podnik";
		//$mail->AddBCC($eshop->eshop_setting["BCC_EMAIL"]);
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);
		//$mail->AddAttachment($this->order_pdf, "objednavka.pdf");

		//$mail->AddAttachment($this->createPDF($_orders->insert_id), "objednavka.pdf");
		//	$mail->AddAttachment(dirname(__FILE__) . "/../../public/data/2011060024.pdf", "objednavka.pdf");
		//$this->createPDF($_orders->insert_id);
		//$mail->AddAttachment(dirname(__FILE__) . "/../../admin/2011060024.pdf", "objednavka.pdf");

		//	$mail->AddAttachment("/public/data/2011060024.pdf", "objednavka.pdf");
		//$mail->AddAttachment("admin/order_pdf.php?id=" . $_orders->insert_id, "objednavka.pdf");


		$mail->Body ='';
		$mail->Body .="<html>";
		$mail->Body .="<head></head>";
		$mail->Body .="<body>";

		//					$mail->Body .='Dobrý den,<br />Vaší objednávku jsme přijali ke zpracování.<br />V příloze naleznete detail objednávky<br />';
		$mail->Body .='Byl přidán nový podnik <strong>' . $data["titulek_cs"] . '</strong> z webu <strong>' . URL_DOMAIN . '</strong>.';
		$mail->Body .='<br /><br />';

		$mail->Body .="<p><label>Popis služby:</label> <strong>" . $data["description2_cs"] . "</strong></p>";


		$program = new models_CatalogProgram();
		$programsList = $program->get_catalogProgramTempList2($catalog_id);

		$vybaveni = new models_CatalogVybaveni();
		$servicesList = $vybaveni->get_catalogVybaveniTempList2($catalog_id);

		$mail->Body .='<table>
			<tr>
			<td style="vertical-align:top">';


		if (count($programsList)>0)
		{

			$mail->Body .="<h4>Program</h4>
			<ul>";

			$sudy = false;
			for ($i=0;$i < count($programsList);$i++)
			{
				$mail->Body .="<li>" . $programsList[$i]->hodnota . "</li>";
			}

		$mail->Body .="</ul>";

		}
		$mail->Body .='</td>
		<td style="vertical-align:top">';

		if (count($servicesList)>0)
		{

		$mail->Body .="<h4>Vybavení</h4>
			<ul>";

			$sudy = false;
			for ($i=0;$i < count($servicesList);$i++)
			{
				$mail->Body .="<li>" . $servicesList[$i]->hodnota . "</li>";

			}

		$mail->Body .="</ul>";
		}
		$mail->Body .="</td>
		</tr>
		</table>";

	//	$mail->Body .="<p><label>Popis podniku:</label> <strong>" . $data["description_cs"] . "</strong></p>";


		/*	*/

		/*
		   $mail->Body .="<table>";


		   $mail->Body .= $mail_text;
		   $mail->Body .="</table>";
		*/
		//	$mail->Body .='děkujeme Vám za vytvoření objednávky v internetovém obchodě <a href="http://www.kolakv.cz">www.kolakv.cz</a>. Vaše objednávka byla přijata ke zpracování. V příloze Vám zasíláme kopii objednávky.';
		//	$mail->Body .='<br /><br />';
		$mail->Body .='<br /><br />Tato zpráva byla vygenerována systémem automaticky, neodpovídejte na ní!';
		$mail->Body .='<br />';
		$mail->Body .=URL_DOMAIN; // 'www.humboldt.cz';


		//					$mail->Body .='<p><a href="http://www.kolakv.cz">www.kolakv.cz</a></p>';
		$mail->Body .="</body></html>";

		return $mail->Send();
	}

}
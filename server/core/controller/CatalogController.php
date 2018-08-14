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



	public function setMainLogo($catalog_id, $foto_id)
	{
		$model = new models_Catalog();
		$model->setMainLogo($catalog_id, $foto_id);
	}

	public function akcePoUlozeni()
	{
		//print "akce po uložení";

		$data = self::getPageSaveData();
/*
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
		*/
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



}
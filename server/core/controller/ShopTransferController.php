<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ShopTransferController extends G_Controller_Action
{


	public function shopTransferList(IListArgs $params = null)
	{
		$model = new models_Doprava();


		$this->total = $model->total;

		$l = $model->getList($params);
		return $l;
	}

	public function saveAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_transfer', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ShopTransferEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				//print_r($form->getValues());
				//print_r($form->getValues());
				$model = new models_Doprava();




				$page_id = (int) $form->getPost('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID!");
					return false;
				}
				$versionEntity = new ShopTransferVersionEntity();
				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$postdata = $form->getValues();


				$data = array();
				//$data["keyword"] = $postdata["keyword"];
				$name = "order";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}

				$name = 'osobni_odber';
				if (array_key_exists($name, $postdata)) {
					$data[$name] = $postdata[$name];
				} else {
					$data[$name] = 0;
				}
        
        
        				$name = "aktivni";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}
        
				$name = 'vypocet_id';
				if (array_key_exists($name, $postdata)) {
					$data[$name] = $postdata[$name];
				}
				$name = 'odberne_misto';
				if (array_key_exists($name, $postdata)) {
					$data[$name] = $postdata[$name];
				}
				$name = 'address1';
				if (array_key_exists($name, $postdata)) {
					$data[$name] = $postdata[$name];
				}
				$name = 'city';
				if (array_key_exists($name, $postdata)) {
					$data[$name] = $postdata[$name];
				}
				$name = 'zip_code';
				if (array_key_exists($name, $postdata)) {
					$data[$name] = $postdata[$name];
				}
        
        				$name = 'kod_dopravce';
				if (array_key_exists($name, $postdata)) {
					$data[$name] = $postdata[$name];
				}
        
				$all_query_ok=true;
				$model->start_transakce();

				//print_r($_POST["platba"]);


			//	exit;
				// Verzování dle jazyků
				foreach ($languageList as $key => $val){


					$name = 'name_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["name"] = $postdata[$name];
					}

					$name = 'price_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["price"] = strToNumeric($postdata[$name]);
					}

					$name = 'price_value_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["price_value"] = $postdata[$name];
					}

					$name = 'tax_id_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["tax_id"] = $postdata[$name];
					}

					$name = 'mj_id_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["mj_id"] = $postdata[$name];
					}
					if (isset($postdata["description_$val->code"])) {
						$versionData["description"] = $postdata["description_$val->code"];
					}

				//	$model->updateRecords($versionEntity->getTablename(),$versionData,"page_id=" . $page_id . " and lang_id=" . $val->id);
				//	$model->commit ? null : $all_query_ok = false;




					$args = new ListArgs();

					$args->page_id = (int) $page_id;
					$args->lang = $val->code;
					$row = $model->getList($args);

					//	print_r($row);

					if (count($row) > 0) {
						$model->updateRecords($versionEntity->getTablename(),$versionData,"page_id=" . $page_id . " and lang_id=" . $val->id);
					} else {
						$versionData["page_id"] = $page_id;
						$versionData["lang_id"] = $val->id;
						$model->insertRecords($versionEntity->getTablename(),$versionData);
					}


				}

				$model->updateRecords($model->getTableName(), $data, "id={$page_id}");
				$model->commit ? null : $all_query_ok = false;

/*
				print_r($_POST["platba"]);
				print_r($_POST["platba_id"]);
				print_r($_POST["pdprice"]);
				exit;
				*/
				/*
				// povolené platby
				$platbyA = array();
				foreach ($_POST["platba"] as $key => $val) {
					array_push($val,$platbyA);
				}
				*/
				$model->deleteRecords(T_SHOP_PLATBY_DOPRAVY, "doprava_id={$page_id}");
				$model->commit ? null : $all_query_ok = false;


				foreach ($_POST["platba_id"] as $key => $val) {

					if (in_array($val,$_POST["platba"])) {


						$dataPD = array();
						$dataPD["doprava_id"] = $page_id;
						$dataPD["platba_id"] = $val;

						$dataPD["price"] = strToNumeric($_POST["pdprice"][$key]);
						$dataPD["price_value"] = $_POST["pdprice_value"][$key];
            
            $dataPD["price_mj"] = strToNumeric($_POST["pdprice_mj"][$key]);
						$dataPD["price_mj_value"] = $_POST["pdprice_mj_value"][$key];
            
            $dataPD["price_m3"] = strToNumeric($_POST["pdprice_m3"][$key]);
						$dataPD["price_m3_value"] = $_POST["pdprice_m3_value"][$key];
            
            $dataPD["price_kg"] = strToNumeric($_POST["pdprice_kg"][$key]);
						$dataPD["price_kg_value"] = $_POST["pdprice_kg_value"][$key];
            
						$model->insertRecords(T_SHOP_PLATBY_DOPRAVY, $dataPD);
						$model->commit ? null : $all_query_ok = false;
											}
				}



				if($model->konec_transakce($all_query_ok))
				{
					$form->setResultSuccess("Záznam byl aktualizován.");
					$this->getRequest->goBackRef();
				}

			}
		}
	}
  
  public function deleteAjaxAction()
  {
      		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteShopTransfer" == $this->getRequest->getPost('action', false))
		

		{
    
   // print "tudy";
   // exit;
    			$doklad_id = (int)  $this->getRequest->getQuery('id', 0);

			if ($doklad_id) {
						$model = new models_Doprava();
						$obj = $model->getDetailById($doklad_id);
				//$obj = parent::$model->getDetailById($doklad_id);
         //  print_R($obj);
         //  exit;
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
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteDoprava" == $this->getRequest->getPost('action', false))
		{



			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Doprava();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->name );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Způsob dopravy " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}
			}
		}
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_transfer', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ShopTransferCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{


				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$versionEntity = new ShopTransferVersionEntity();

				$version = 0;
				$postdata = $form->getValues();

				// TODO ošetřit duplicitu !
				$data = array();
			//	$data["keyword"] = $postdata["keyword"];
				$name = "order";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}

				$model = new models_Doprava();

				$all_query_ok=true;
				$model->start_transakce();

				$model->insertRecords($model->getTablename(),$data);
				$model->commit ? null : $all_query_ok = false;

				if ($model->commit == false) {
					//print "chyba";
				}
				$page_id = $model->insert_id;



				foreach ($languageList as $key => $val){
					$versionData = array();
					//$versionData["caszapsani"] = $caszapsani;
					$versionData["lang_id"] = $val->id;
					$versionData["page_id"] = $page_id;
					//$versionData["user_id"] = USER_ID;
					//$versionData["version"] = $version;


					if (isset($postdata["name_$val->code"])) {
						$versionData["name"] = $postdata["name_$val->code"];
					}
					if (isset($postdata["description_$val->code"])) {
						$versionData["description"] = $postdata["description_$val->code"];
					}


					$name = 'price_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["price"] = strToNumeric($postdata[$name]);
					}

					$name = 'price_value_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["price_value"] = $postdata[$name];
					}

					$name = 'tax_id_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["tax_id"] = $postdata[$name];
					}

					$name = 'mj_id_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["mj_id"] = $postdata[$name];
					}

					$model->insertRecords($versionEntity->getTablename(),$versionData);
					$model->commit ? null : $all_query_ok = false;
					if ($model->commit == false) {
					//	print "chyba";
					}

				}
				if ($model->konec_transakce($all_query_ok)) {
					//	$_SESSION["statusmessage"]="Section was added.";
					$form->setResultSuccess('Záznam byl přidán. <a href="'.URL_HOME.'edit_shop_transfer?id='.$page_id.'">Přejít na právě pořízený záznam.</a>');
					$this->getRequest->goBackRef();
				}
			}
		}
	}

}
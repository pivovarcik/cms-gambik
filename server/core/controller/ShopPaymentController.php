<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ShopPaymentController extends G_Controller_Action
{
	private $slovnikList = array();
	public $total = 0;
	public function shopPaymentListTable($params = array())
	{
		$l = $this->shopPaymentEdit($params);

		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["name"] = $headKey;
		$column["description"] = $headKey;
		$column["cmd"] = '';

		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["cmd"]["class"] = "column-cmd";

		$table = new G_Table($l, $column, $th_attrib);


		$table_attrib = array(
						"class" => "widefat fixed",
						"id" => "data_grid",
						"cellspacing" => "0",
						);
		return $table->makeTable($table_attrib);

	}
	public function shopPaymentEdit($params = array())
	{
		$l = $this->shopPaymentList($params);

		for ($i=0;$i < count($l);$i++)
		{
			$url = URL_HOME . "admin/edit_shop_payment.php?id=" . $l[$i]->id;

			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{


				// Když je vybrán objekt
				$elemKlicCat = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$klicCatValue = $l[$i]->uid;
				$elemKlicCat->setAttribs('value', $klicCatValue);
				$elemKlicCat->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemKlicCat->render();

				$elemKeyId = new G_Form_Element_Text("keyid[" . $i . "]");
				$value = $this->getRequest->getPost("keyid[" . $i . "]", $l[$i]->keyid);
				$elemKeyId->setAttribs('value',$value);
				$l[$i]->keyid = $elemKeyId->render();

				$elemCs = new G_Form_Element_Text("cs[" . $i . "]");
				$value = $this->getRequest->getPost("cs[" . $i . "]", $l[$i]->cs);
				$elemCs->setAttribs('value',$value);
				$l[$i]->cs = $elemCs->render();

				$elemEn = new G_Form_Element_Text("en[" . $i . "]");
				$value = $this->getRequest->getPost("en[" . $i . "]", $l[$i]->en);
				$elemEn->setAttribs('value',$value);
				$l[$i]->en = $elemEn->render();

				$elemDe = new G_Form_Element_Text("de[" . $i . "]");
				$value = $this->getRequest->getPost("de[" . $i . "]", $l[$i]->de);
				$elemDe->setAttribs('value',$value);
				$l[$i]->de = $elemDe->render();

				$elemRu = new G_Form_Element_Text("ru[" . $i . "]");
				$value = $this->getRequest->getPost("ru[" . $i . "]", $l[$i]->ru);
				$elemRu->setAttribs('value',$value);
				$l[$i]->ru = $elemRu->render();

				$l[$i]->cmd = '';
			} else {
				$elemKlicMa = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemKlicMa->setAttribs('value', $value);
				$l[$i]->checkbox = $elemKlicMa->render();

				//$keyId = $l[$i]->keyword;


				$command = '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu SMAZAT slovo: '.$l[$i]->keyword.'?\')" type="image" src="'.URL_HOME . 'admin/action_delete.gif" value="X" name="delete_item[' . $i . ']"/>';

				$command .= '<input type="hidden" value="' . $l[$i]->id . '" name="item_id[' . $i . ']"/>';
				$l[$i]->cmd = $command;

				$l[$i]->name = '<a href="' . $url . '">' . $l[$i]->name . '</a>';

			}
		}
		return $l;
	}

	public function shopPaymentList(IListArgs $params = null)
	{
		$model = new models_Platba();
/*
		$limit 	= $this->getRequest->getQuery('limit', 100);
		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');

		$params2 = $params;
		$params2['lang'] = LANG_TRANSLATOR;

		$limit 	= $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		$params2['limit'] = $limit;


		$page 	= $this->getRequest->getQuery('pg', 1);
		if (isset($params['page']) && is_numeric($params['page'])) {
			$page = $params['page'];
		}
		$params2['page'] = $page;

		$search_string = $this->getRequest->getQuery('q', '');
		$params2['fulltext'] = $search_string;
		if (isset($params['search']))
		{
			$params2['fulltext'] = $params['search'];
		}

		$querys = array();
		$querys[] = array('title'=>'Klíčové slovo','url'=>'key','sql'=>'t1.keyid');
		$querys[] = array('title'=>'CS_cz','url'=>'cs','sql'=>'t1.cs');
		$querys[] = array('title'=>'US_en','url'=>'en','sql'=>'t1.en');
		$querys[] = array('title'=>'DE_de','url'=>'de','sql'=>'t1.de');
		$querys[] = array('title'=>'RU_ru','url'=>'ru','sql'=>'t1.ru');
		$orderFromQuery = $this->orderFromQuery($querys, 'p.keyword ASC');

*/
		$this->total = $model->total;

		$l = $model->getList($params);

		//print $model->getLastQuery();
		return $l;
	}

	public function saveAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_payment', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ShopPaymentEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				//print_r($form->getValues());
				//print_r($form->getValues());
				$model = new models_Platba();




				$page_id = (int) $form->getPost('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID!");
					return false;
				}

				$versionEntity = new ShopPaymentVersionEntity();
				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$postdata = $form->getValues();


				$data = array();
				//$data["keyword"] = $postdata["keyword"];

				$name = "order";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}
				$name = "brana";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}
        				$name = "aktivni";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}
				$all_query_ok=true;
				$model->start_transakce();

				// Verzování dle jazyků
				foreach ($languageList as $key => $val){


					$name = 'name_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["name"] = $postdata[$name];
					}
					if (isset($postdata["description_$val->code"])) {
						$versionData["description"] = $postdata["description_$val->code"];
					}

					$name = 'price_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["price"] = strToNumeric($postdata[$name]);
					}


					//$model->updateRecords($versionEntity->getTablename(),$versionData,"page_id=" . $page_id . " and lang_id=" . $val->id);
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

				if($model->konec_transakce($all_query_ok))
				{
					$form->setResultSuccess("Záznam byl aktualizován.");
					$this->getRequest->goBackRef();
				}

			}
		}

	}
	public function deleteAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deletePlatba" == $this->getRequest->getPost('action', false))
		{



			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Platba();
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
					$_SESSION["statusmessage"]="Způsob platby " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}
			}
		}
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_payment', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ShopPaymentCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{


				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$versionEntity = new ShopPaymentVersionEntity();

				$version = 0;
				$postdata = $form->getValues();

				// TODO ošetřit duplicitu !
				$data = array();
			//	$data["keyword"] = $postdata["keyword"];

				$name = "order";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}

        $name = "brana";
				if (isset($postdata[$name])) {
					$data[$name] = $postdata[$name];
				}
        
				$model = new models_Platba();

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
					$model->insertRecords($versionEntity->getTablename(),$versionData);
					$model->commit ? null : $all_query_ok = false;
					if ($model->commit == false) {
					//	print "chyba";
					}

				}

				if ($model->konec_transakce($all_query_ok)) {
					//	$_SESSION["statusmessage"]="Section was added.";
					$form->setResultSuccess('Záznam byl přidán. <a href="'.URL_HOME.'edit_shop_payment?id='.$page_id.'">Přejít na právě pořízený záznam.</a>');
					$this->getRequest->goBackRef();
				}

			}
		}
	}

}
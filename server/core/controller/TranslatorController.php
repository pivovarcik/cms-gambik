<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class TranslatorController extends G_Controller_Action
{
	private $slovnikList = array();
	public $total = 0;
	public $pageModel = "Translator";

	public function deleteAjaxAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteTranslator" == $this->getRequest->getPost('action', false))
		{



			$doklad_id = (int) $this->getRequest->getQuery('id', 0);

			if ($doklad_id) {
				$model = new models_Translator();
				//	$model = new models_Products();
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

	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "TranslatorEdit" == $this->getRequest->getPost('action', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('TranslatorEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$model = new models_Translator();
				$page_id = (int) $this->getRequest->getQuery('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID.");
					return false;
				}

				$versionEntity = new TranslatorVersionEntity();
				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$postdata = $form->getValues();


				$data = array();
				$data["keyword"] = $postdata["keyword"];


				$all_query_ok=true;
				$model->start_transakce();

				// Verzování dle jazyků
				foreach ($languageList as $key => $val){


					$name = 'name_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["name"] = $postdata[$name];
					}
					$args = new ListArgs();

					$args->page_id = (int) $page_id;
					$args->lang = $val->code;
					$row = $model->getList($args);

				//	print_r($row);

					if (count($row) > 0) {
						$model->updateRecords($versionEntity->getTablename(),$versionData,"keyword_id=" . $page_id . " and lang_id=" . $val->id);
					} else {
						$versionData["keyword_id"] = $page_id;
						$versionData["lang_id"] = $val->id;
						$model->insertRecords($versionEntity->getTablename(),$versionData);
					}


					$model->commit ? null : $all_query_ok = false;
				}

				//exit;
				$model->updateRecords($model->getTableName(), $data, "id={$page_id}");
				$model->commit ? null : $all_query_ok = false;

				if($model->konec_transakce($all_query_ok))
				{
					$form->setResultSuccess("Zaznam byl aktualizován.");
					return true;

				}

			}
		}
	}

	public function saveAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_keyword', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('TranslatorEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$model = new models_Translator();
				$page_id = (int) $form->getPost('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID.");
					return false;
				}

				$versionEntity = new TranslatorVersionEntity();
				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$postdata = $form->getValues();


				$data = array();
				$data["keyword"] = $postdata["keyword"];


				$all_query_ok=true;
				$model->start_transakce();

				// Verzování dle jazyků
				foreach ($languageList as $key => $val){


					$name = 'name_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionData["name"] = $postdata[$name];
					}


					$model->updateRecords($versionEntity->getTablename(),$versionData,"keyword_id=" . $page_id . " and lang_id=" . $val->id);
					$model->commit ? null : $all_query_ok = false;
				}

				$model->updateRecords($model->getTableName(), $data, "id={$page_id}");
				$model->commit ? null : $all_query_ok = false;

				if($model->konec_transakce($all_query_ok))
				{
					$form->setResultSuccess("Zaznam byl aktualizován.");
					$this->getRequest->goBackRef();

				}

			}
		}
	}
	public function deleteAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteTranslator" == $this->getRequest->getPost('action', false))
		{



			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Translator();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->keyword );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Slovo " . implode(",", $seznamCiselObjednavek) . " bylo smazáno.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}
			}
		}
	}


	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_keyword', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('TranslatorCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{


				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$versionEntity = new TranslatorVersionEntity();

				$version = 0;
				$postdata = $form->getValues();

				// TODO ošetřit duplicitu !
				$data = array();
				$data["keyword"] = $postdata["keyword"];

				$model = new models_Translator();

				$all_query_ok=true;
				$model->start_transakce();

				$model->insertRecords($model->getTablename(),$data);
				$model->commit ? null : $all_query_ok = false;

				if ($model->commit == false) {
				//	print "chyba";
				}
				$page_id = $model->insert_id;



				foreach ($languageList as $key => $val){
					$versionData = array();
					//$versionData["caszapsani"] = $caszapsani;
					$versionData["lang_id"] = $val->id;
					$versionData["keyword_id"] = $page_id;
					//$versionData["user_id"] = USER_ID;
					//$versionData["version"] = $version;


					if (isset($postdata["name_$val->code"])) {
						$versionData["name"] = $postdata["name_$val->code"];
					}

					$model->insertRecords($versionEntity->getTablename(),$versionData);
					$model->commit ? null : $all_query_ok = false;
					if ($model->commit == false) {
					//	print "chyba";
					}

				}

				if ($model->konec_transakce($all_query_ok)) {
					$form->setResultSuccess('Záznam byl přidán. <a href="'.URL_HOME.'admin/edit_key.php?id='.$page_id.'">Přejít na právě pořízený záznam.</a>');
					$this->getRequest->goBackRef();
				}

			}
		}
	}


	public function activeLanguageAction()
	{

		if($this->getRequest->isPost())
		{

			$model = new models_Language();

			$args = new ListArgs();
			$args->limit = 100;
			$list = $model->getList($args);

			for ($i=0;$i<count($list);$i++)
			{
			//	$lang = "en";
				$this->zpracujAktivaciJazyka($list[$i]->code);
			}
/*
			$lang = "en";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "de";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "ru";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "sk";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "pl";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "fr";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "ic";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "it";
			$this->zpracujAktivaciJazyka($lang);

			$lang = "cn";
			$this->zpracujAktivaciJazyka($lang);
			*/

		}

	}

	private function zpracujAktivaciJazyka($lang)
	{
		if ( false !== $this->getRequest->getPost('lang_active_'.$lang, false)) {

			if ($this->aktivujJazyk($lang)) {
				//$this->getRequest->goBackRef();

			}
		}
	}

	private function zpracujDeaktivaciJazyka($lang)
	{
		if ( false !== $this->getRequest->getPost('lang_deactive_'.$lang, false)) {

			if ($this->deaktivujJazyk($lang)) {
			//	$this->getRequest->goBackRef();
			}
		}
	}

	public function deactiveLanguageAction()
	{

		if($this->getRequest->isPost())
		{

			$model = new models_Language();

			$args = new ListArgs();
			$args->limit = 100;
			$list = $model->getList($args);

			for ($i=0;$i<count($list);$i++)
			{
				//	$lang = "en";
				$this->zpracujDeaktivaciJazyka($list[$i]->code);
			}
			/*
			$lang = "en";
			$this->zpracujDeaktivaciJazyka($lang);

			$lang = "de";
			$this->zpracujDeaktivaciJazyka($lang);

			$lang = "ru";
			$this->zpracujDeaktivaciJazyka($lang);

			$lang = "sk";
			$this->zpracujDeaktivaciJazyka($lang);

			$lang = "pl";
			$this->zpracujDeaktivaciJazyka($lang);


			$lang = "fr";
			$this->zpracujDeaktivaciJazyka($lang);

			$lang = "ic";
			$this->zpracujDeaktivaciJazyka($lang);

			$lang = "it";
			$this->zpracujDeaktivaciJazyka($lang);

			$lang = "cn";
			$this->zpracujDeaktivaciJazyka($lang);

*/
		}

	}

	private function deaktivujJazyk($lang)
	{
		$model = new models_Language();

		$args = new ListArgs();
		$args->lang = $lang;
		$list = $model->getList($args);

		//	print_r($list);
		if (count($list) != 1) {
			return;
		}

		if ($list[0]->active == 0) {
			return;
		}


		$model->updateRecords($model->getTablename(),array("active"=>0),"id=".$list[0]->id);

	//	$model->insertRecords(T_CATEGORY_VERSION,array("lang_id"=>$list[0]->id,"url" => "root", "title" =>"root","page_id"=>1));

	//	$model->insertRecords(T_CATEGORY_VERSION,array("lang_id"=>$list[0]->id,"url" => "secret", "title" =>"secret","page_id"=>2));

		return true;
	}


	private function aktivujJazyk($lang)
	{
		$model = new models_Language();

		$args = new ListArgs();
		$args->lang = $lang;
		$list = $model->getList($args);

	//	print_r($list);
		if (count($list) != 1) {
			return;
		}

		if ($list[0]->active == 1) {
			return;
		}


		$model->updateRecords($model->getTablename(),array("active"=>1),"id=".$list[0]->id);


		$modelCategory = new models_Category();

		$rootCategory = $modelCategory->getDetailById(1, "cs");

		$title = "title_" .$lang;
		if (!isset($rootCategory->$title)) {
			$model->insertRecords(T_CATEGORY_VERSION,array("lang_id"=>$list[0]->id,"url" => "root", "title" =>"root","page_id"=>1, "version" => $rootCategory->version));
		}



		$secretCategory = $modelCategory->getDetailById(2, "cs");
		if (!isset($secretCategory->$title)) {
			$model->insertRecords(T_CATEGORY_VERSION,array("lang_id"=>$list[0]->id,"url" => "secret", "title" =>"secret","page_id"=>2, "version" => $secretCategory->version));
		}
		return true;
	}

	public function createAjaxAction()
	{

		//	PRINT_R($_POST);
		// Je odeslán formulář
		if($this->getRequest->isPost() && "TranslatorCreate" == $this->getRequest->getPost('action', false))
		{
//print "tudy";

			// načtu Objekt formu
			$form = $this->formLoad('TranslatorCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{




				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$versionEntity = new TranslatorVersionEntity();

				$version = 0;
				$postdata = $form->getValues();

				// TODO ošetřit duplicitu !
				$data = array();
				$data["keyword"] = $postdata["keyword"];

				$model = new models_Translator();

				$all_query_ok=true;
				$model->start_transakce();

				$model->insertRecords($model->getTablename(),$data);
				$model->commit ? null : $all_query_ok = false;

				if ($model->commit == false) {
					//	print "chyba";
				}
				$page_id = $model->insert_id;



				foreach ($languageList as $key => $val){
					$versionData = array();
					//$versionData["caszapsani"] = $caszapsani;
					$versionData["lang_id"] = $val->id;
					$versionData["keyword_id"] = $page_id;
					//$versionData["user_id"] = USER_ID;
					//$versionData["version"] = $version;


					if (isset($postdata["name_$val->code"])) {
						$versionData["name"] = $postdata["name_$val->code"];
					}

					$model->insertRecords($versionEntity->getTablename(),$versionData);
					$model->commit ? null : $all_query_ok = false;
					if ($model->commit == false) {
						//	print "chyba";
					}

				}


				if ($model->konec_transakce($all_query_ok)) {
					$form->setResultSuccess('Záznam byl přidán.');
					return true;
				} else {
					$result = array();
					$result["status"] = "wrong";
					$json = json_encode($result);
					print_r($json);
					exit;
				}

			}
		}
	}

	public function languagePanelRender($params = array())
	{
		$box_id = 'langBox';
		$res = '';
		if (TRANSLATOR_EN == 1 || TRANSLATOR_DE == 1 || TRANSLATOR_RU == 1)
		{
			$res = '<div id="'.$box_id.'">';
			$res .= '<a id="'.$box_id.'_lnkLangCZ" href="' . URL_HOME2 . 'cs/<?php print $cat_aktual_link_cs; ?>"><span>česky</span></a>';
			if (TRANSLATOR_EN == 1)
			{
				$res .= '<a id="'.$box_id.'_lnkLangEN" href="' . URL_HOME2 . 'en/<?php print $cat_aktual_link_en; ?>"><span>english</span></a>';
			}
			if (TRANSLATOR_DE == 1)
			{
				$res .= '<a id="'.$box_id.'_lnkLangDE" href="' . URL_HOME2 . 'de/<?php print $cat_aktual_link_de; ?>"><span>deutsch</span></a>';
			}
			if (TRANSLATOR_RU == 1)
			{
				$res .= '<a id="'.$box_id.'_lnkLangRU" href="' . URL_HOME2 . 'ru/<?php print $cat_aktual_link_de; ?>"><span>по-русски</span></a>';
			}

			$res .= '</div>';
		}
		return $res;
	}
}
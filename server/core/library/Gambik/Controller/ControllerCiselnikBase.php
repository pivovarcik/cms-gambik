<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

/**
 *
 *
 */
require_once("G_Controller_Action.php");
class ControllerCiselnikBase  extends G_Controller_Action {
	/**
	 * Constructor
	 */
	protected $model;
	function __construct($model){
		$this->model = new $model;
	}

	public function deleteAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('delete_item', false))
		{
			$tenzin = $this->getRequest->getPost('delete_item', false);
			list($key,$value) = each($tenzin);

			$page_id = (int) $_POST['item_id'][$key];

			if ($page_id) {
				$data = array();
				$data["isDeleted"] = 1;
				$this->model->updateRecords($this->model->getTablename(),$data ,"id=". $page_id);

				$_SESSION["statusmessage"]='záznam byl označen jako smazaný.';
				$_SESSION["classmessage"]="success";
				$this->getRequest->goBackRef();
			}

		}
	}
	public function setSaveData()
	{

	}

	public function getFormData($formName)
	{
		return $this->validForm($formName);
	}
	public function validForm($formName)
	{
		$form = $this->formLoad($formName);
		// Provedu validaci formu
		if ($form->isValid($this->getRequest->getPost()))
		{
			return $form->getValues();
		} else {
			foreach($form->getError() as $key => $value)
			{
				$_SESSION["statusmessage"]= $key . ": ". $value;
			}
			//print_r($form->getError());

			$_SESSION["classmessage"]="errors";

		}
		return false;
	}

	public function validSavedata($formName)
	{

	}

	public function saveData($formName)
	{
		// zpracování formuláře - validace dat
		$formData = $this->getFormData($formName);
		if ($formData === false) {
			return false;
		}
		// prošla vadice formu, vrácena data z formu

		$page_id = (int) $form->page_id;



		$all_query_ok=true;
		$this->model->start_transakce();

		$added = false;
		if ($page_id > 0) {
			$this->model->updateRecords($this->model->getTableName(), $data, "id={$page_id}");
		} else {
			$this->model->insertRecords($this->model->getTablename(),$data);

			$page_id = $model->insert_id;
			$added = true;
		}

		$this->model->commit ? null : $all_query_ok = false;


		foreach ($languageList as $key => $val){
			$pageVersionData = array();

			$pageVersionData["lang_id"] = $val->id;
			$pageVersionData["page_id"] = $page_id;

			if (isset($postdata["name_$val->code"])) {
				$pageVersionData["name"] = $postdata["name_$val->code"];
			}
			if (isset($postdata["description_$val->code"])) {
				$pageVersionData["description"] = $postdata["description_$val->code"];
			}
			$this->model->insertRecords($versionEntity->getTablename(),$pageVersionData);
			$this->model->commit ? null : $all_query_ok = false;
		}
		$this->beforeTransactionSave();
		if ($this->model->konec_transakce($all_query_ok)) {
			$this->afterTransactionSave();

			$_SESSION["statusmessage"]='Transfer was added. <a href="'.URL_HOME.'admin/edit_shop_transfer.php?id='.$page_id.'">Přejít na právě pořízený záznam.</a>';
			$_SESSION["classmessage"]="success";
			$this->getRequest->goBackRef();
		} else {
			print "chyba";
		}




		// vlastní validace dat

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




				$page_id = (int) $this->getRequest->getPost('id', 0);

				if ($page_id == 0) {
					$_SESSION["statusmessage"]= "Není zadáno ID";
					$_SESSION["classmessage"]="errors";
					return false;
				}

				$versionEntity = new ShopTransferVersionEntity();
				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$postdata = $form->getValues();


				$data = array();
				//$data["keyword"] = $postdata["keyword"];


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

					$model->updateRecords($versionEntity->getTablename(),$versionData,"page_id=" . $page_id . " and lang_id=" . $val->id);
					$model->commit ? null : $all_query_ok = false;
				}

				$model->updateRecords($model->getTableName(), $data, "id={$page_id}");
				$model->commit ? null : $all_query_ok = false;

				if($model->konec_transakce($all_query_ok))
				{
					$_SESSION["statusmessage"]="Transfer has been updated.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				} else {
					print "chyba";
				}

			} else {
				//	print "Neprošel valid";
				//print_r($form->getValues());
				foreach($form->getError() as $key => $value)
				{
					$_SESSION["statusmessage"]= $key . ": ". $value;
				}
				//print_r($form->getError());

				$_SESSION["classmessage"]="errors";

				//	return $form;
			}
		}
	}

	public function beforeTransactionSave()
	{

	}

	public function afterTransactionSave()
	{

	}
}
?>
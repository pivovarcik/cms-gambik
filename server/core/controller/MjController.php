<?php


class MjController extends G_Controller_Action
{
	public $total = 0;
	public $pageModel = "Mj";

	public function deleteAjaxAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteMj" == $this->getRequest->getPost('action', false))
		{



			$doklad_id = (int) $this->getRequest->getQuery('id', 0);

			if ($doklad_id) {
				$model = new models_Mj();
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
		if($this->getRequest->isPost() && "MjEdit" == $this->getRequest->getPost('action', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('MjEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$page_id = (int) $this->getRequest->getQuery('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID.");
					return false;
				}

        $Entity = new MjEntity($page_id);
        
        $saveEntity = new SaveEntity();

				$saveEntity->addSaveEntity($Entity);


        

				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$postdata = $form->getValues();




				$data = array();
				//$data["keyword"] = $postdata["keyword"];

        $model = new models_Mj;

				// Verzování dle jazyků
				foreach ($languageList as $key => $val){



					$args = new ListArgs();

					$args->page_id = (int) $page_id;
					$args->lang = $val->code;
					$row = $model->getList($args);

				//	print_r($row);
        //exit;
					if (count($row) > 0) {
            $versionEntity = new MjVersionEntity($row[0]->version_id);
					} else {
            $versionEntity = new MjVersionEntity();
					}
          $versionEntity->lang_id = $val->id;
          $name = 'name_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionEntity->name = $postdata[$name];
					}
          
          $saveEntity->addSaveEntity($versionEntity);


				
				}

        if ($saveEntity->save()) {
          $form->setResultSuccess("Zaznam byl aktualizován.");
					return true;
        }
        


			}
		}
	}

	public function createAjaxAction()
	{

		//	PRINT_R($_POST);
		// Je odeslán formulář
		if($this->getRequest->isPost() && "MjCreate" == $this->getRequest->getPost('action', false))
		{
//print "tudy";

			// načtu Objekt formu
			$form = $this->formLoad('MjCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{




				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$versionEntity = new MjVersionEntity();

				$version = 0;
				$postdata = $form->getValues();

				// TODO ošetřit duplicitu !
				$data = array();
				//$data["keyword"] = $postdata["keyword"];

				$model = new models_Mj();

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
					$versionData["mj_id"] = $page_id;
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


}
/*
class MjController extends CiselnikBase
{

	function __construct()
	{
		parent::__construct("Mj");
	}
}  */
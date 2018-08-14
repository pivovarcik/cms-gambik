<?php

class GdprController extends G_Controller_Action
{


	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "GdprEdit" == $this->getRequest->getPost('action', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('GdprEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{


		     	$postdata = $form->getValues();
        
        				$entita = new GdprEntity($form->page);
				$entita->naplnEntitu($postdata);




				$saveEntity = new SaveEntity();

				$saveEntity->addSaveEntity($entita);

				if ($saveEntity->save()) {
					if ($this->getRequest->getPost('callback', false) == false) {
						$form->setResultSuccess("Záznam byl aktualizován.");
					//	$this->getRequest->goBackRef();
					}
					return true;
				} else {
					if ($this->getRequest->getPost('callback', false) == false) {
					}
					return false;
				}


        
       
			}
		}
	}
  
  
  public function createAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "GdprCreate" == $this->getRequest->getPost('action', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('GdprCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{


		     	$postdata = $form->getValues();
        
        				$entita = new GdprEntity();
				$entita->naplnEntitu($postdata);




				$saveEntity = new SaveEntity();

				$saveEntity->addSaveEntity($entita);

				if ($saveEntity->save()) {
					if ($this->getRequest->getPost('callback', false) == false) {
						$form->setResultSuccess("Záznam byl aktualizován.");
						//$this->getRequest->goBackRef();
					}
					return true;
				} else {
					if ($this->getRequest->getPost('callback', false) == false) {
					}
					return false;
				}


        
       
			}
		}
	}
  
    public function deleteAjaxAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteGdpr" == $this->getRequest->getPost('action', false))
		{



			$doklad_id = (int) $this->getRequest->getQuery('id', 0);

			if ($doklad_id) {
				$model = new models_Gdprs();
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
}
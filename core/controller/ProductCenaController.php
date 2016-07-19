<?php


class ProductCenaController extends G_Controller_Action
{


	public function generatorAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('generator', false))
		{
			$form = $this->formLoad('ProductCenyGenerator');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{
				$formdata = $form->getValues();

			//	print_r($formdata);
			//	exit;
				$args = new stdClass();

				$args->cenik_id = (int) $formdata["cenik_id"];
				$args->sleva = $formdata["sleva"];
				$args->skupina_id = $formdata["skupina_id"];
				$args->vyrobce_id = $formdata["vyrobce_id"];

				$args->skupina = $formdata["skupina"];
				$args->vyrobce = $formdata["vyrobce"];


				$args->typ_slevy = $formdata["typ_slevy"];
				$args->platnost_od = !empty($formdata["platnost_od"]) ? date("Y-m-d",strtotime($formdata["platnost_od"])) : null;
				$args->platnost_do = !empty($formdata["platnost_do"]) ? date("Y-m-d",strtotime($formdata["platnost_do"])) : null;
				$args->cenik_cena = null; //$formdata["cenik_cena"];
				$models = new models_ProductCena();

				if ($models->generatorCen($args)) {
					$form->setResultSuccess("Ceník byl vygenerován");
					$this->getRequest->goBackRef();
				}
			}
		}
	}

	public function saveAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false) && $this->getRequest->getPost('action', false) == 'ProductCenaEdit')
		{
			// načtu Objekt formu
			$form = $this->formLoad('ProductCenaEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$postdata = $form->getValues();



				$entita = new ProductCenaEntity($form->page);
				$entita->naplnEntitu($postdata);




				$saveEntity = new SaveEntity();

				$saveEntity->addSaveEntity($entita);

				if ($saveEntity->save()) {
					if ($this->getRequest->getPost('callback', false) == false) {
						$form->setResultSuccess("Záznam byl aktualizován.");
						$this->getRequest->goBackRef();
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

	public function neplatneCenyDeleteAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteNeplatneProductCena" == $this->getRequest->getPost('action', false))
		{


			$query = "update " . $model->getTableName() . " set isDeleted=1 where id in (select id from " . $model->getTableName() . " where isDeleted=0 and platnost_do<now()) ";
			if($model->query($query))
			{
				$_SESSION["statusmessage"]="Neplatné ceny byly smazány.";
				$_SESSION["classmessage"]="success";
				$this->getRequest->goBackRef();
			}

		}
	}

	public function deleteAction()
	{


		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteProductCena" == $this->getRequest->getPost('action', false))
		{

			$selectedItems = $this->getRequest->getPost('slct', array());



			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {

				$model = new models_ProductCena();


				$data = array();
				$data["isDeleted"] = 1;
				if($model->updateRecords($model->getTableName(),$data,"id in (".implode(",",$selectedItems) . ")"))
				{
					if (count($selectedItems)>0) {
						array_reverse($seznamCiselObjednavek);
						$_SESSION["statusmessage"]="Cena " . implode(",", $selectedItems) . " byl smazán.";
						$_SESSION["classmessage"]="success";
						$this->getRequest->goBackRef();
					}
				}


			}

		}
	}

}
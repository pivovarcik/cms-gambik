<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ProductStavyController extends G_Controller_Action
{

	public function zalozitStavyActionOld()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('napln_stavy', false))
		{

			$modelProduct = new models_Products();

			$params = array();
			$params["limit"] = 10000;
			$params["page"] = 1;
			$productlist = $modelProduct->getList($params);

			$model = new models_ProductStavy();
			for ($i=0;$i<count($productlist);$i++)
			{
			//	$productlist[$id]->page_id;

				$data = array();
				$data["qty"] = 0;
				$data["qty_min"] = 0;
				$data["qty_max"] = 0;
				$data["product_id"] = $productlist[$i]->page_id;
				$model->insert($data);
			}
			// smazat tabulku !!

			// načíst produkty


		}
	}


	public function zalozitStavyAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('create_stavy', false))
		{

			$model = new models_ProductStavy();

			$query = "insert into " . $model->getTableName() . " (qty,qty_min,qty_max,mj_id,product_id) values
			select (qty,0,0,mj_id,id) from " . T_SHOP_PRODUCT. " where isDeleted=0 and id not in (select product_id from " . $model->getTableName() . " where isDeleted=0)";
			if($model->query($query))
			{
				$_SESSION["statusmessage"]="Stavy byly naplněny.";
				$_SESSION["classmessage"]="success";
				$this->getRequest->goBackRef();
			}

			//print $model->getLastQuery();

		}
	}
	public function saveAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false) && $this->getRequest->getPost('action', false) == 'ProductStavyEdit')
		{
			// načtu Objekt formu
			$form = $this->formLoad('ProductStavyEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$postdata = $form->getValues();



				$entita = new ProductStavEntity($form->page);
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

	public function deleteAction()
	{


		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteProductStavy" == $this->getRequest->getPost('action', false))
		{

			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				$model = new models_ProductCena();
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {

						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->cislo );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Stav " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}
			}

		}
	}

}
<?php

class ProductVariantyController  extends G_Controller_Action {


	public function deleteAjaxAction()
	{

		if($this->getRequest->isPost()
			&& "ProductVariantyDelete" == $this->getRequest->getPost('action', false))
		{
			$doklad_id = (int) $this->getRequest->getQuery('id', 0);

			if ($doklad_id) {
				$model = new models_ProductVarianty();
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
		if($this->getRequest->isPost() && "ProductVariantyEdit" == $this->getRequest->getPost('action', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('ProductVariantyEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$page_id = (int) $this->getRequest->getQuery('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID.");
					return false;
				}

				$postdata = $form->getValues();

				$ProductVariantyEntity = new ProductVariantyEntity($form->page);

				$ProductVariantyEntity->naplnEntitu($postdata);
				$this->vypocetCeny($ProductVariantyEntity);

				/*
				$productVersionData = array();
				$zmenaCeny = false;
				if ($ProductVariantyEntity->price > $form->product->max_prodcena) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["max_prodcena"] = $ProductVariantyEntity->price;
				}
				if ($ProductVariantyEntity->price_sdani > $form->product->max_prodcena_sdph) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["max_prodcena_sdph"] = $ProductVariantyEntity->price_sdani;
				}

				if ($ProductVariantyEntity->price < $form->product->min_prodcena || $form->product->min_prodcena == 0) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["min_prodcena"] = $ProductVariantyEntity->price;
				}
				if ($ProductVariantyEntity->price_sdani < $form->product->min_prodcena_sdph || $form->product->min_prodcena_sdph == 0) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["min_prodcena_sdph"] = $ProductVariantyEntity->price_sdani;
				}
				*/

				$SaveEntity = new SaveEntity();
				if ($zmenaCeny) {
					// uloz

					$ProductEntity = new ProductEntity((int)$form->product_id);
				//	print $form->product_id;
				//	print_r($ProductEntity);
				//	exit;
					$ProductEntity->naplnEntitu($productVersionData);
					$SaveEntity->addSaveEntity($ProductEntity);
				}


				$SaveEntity->addSaveEntity($ProductVariantyEntity);

				$valueAttribute	= $_POST["Application_Form_ProductVariantyEdit_attribute_value_id"];

				$hasAttribute = $_POST["Application_Form_ProductVariantyEdit_has_attribute_id"];

			//	$hasAttributeOriginal = $_POST["Application_Form_ProductVariantyEdit_attribute_original_id"];



				// smažu varianty
				$model = new models_ProductVarianty();
				$model->deleteRecords("mm_product_varianty_value_association","varianty_id={$page_id}");

				// prohledavam jen vybrané atributy
				foreach ($hasAttribute as $key => $attribId)
				{
					// hledám k nim hodnoty
					$attribValueId = $valueAttribute[$attribId];

					$entita = new ProductVariantyValueAssociationEntity();
					$entita->varianty_id = $page_id;
					$entita->attribute_id = $attribValueId;
					$SaveEntity->addSaveEntity($entita);
				}

				if ($SaveEntity->save()) {


					// update min/max ceny ceny

					$model = new G_Service("");
					$sql = "update `mm_products` left join (
				SELECT product_id,max(price) as max_price,max(price_sdani) as max_price_sdani,
				min(price) as min_price, min(price_sdani) as min_price_sdani FROM `mm_product_varianty` where product_id=" . $form->product_id . " and isDeleted=0
				group by product_id) v on `mm_products`.id = v.product_id
				set max_prodcena = v.max_price,
				max_prodcena_sdph = v.max_price_sdani,
				min_prodcena = v.min_price,
				min_prodcena_sdph = v.min_price_sdani
				where v.product_id=" . $form->product_id;
					$model->query($sql);


					return true;
				}
			}
		}
	}

	private function vypocetCeny(ProductVariantyEntity $ProductVariantyEntity)
	{
		$dph_id = $ProductVariantyEntity->dph_id;
		$sazba = 0;
		if ($dph_id > 0) {
			$dph_model = new models_Dph();
			$dphDetail = $dph_model->getDetailById($dph_id);
			$sazba = $dphDetail->value;
		}

		$eshopSettings = G_EshopSetting::instance();

		$sazbaRadek = $sazba;
		if ($eshopSettings->get("PRICE_TAX") == 0) {
			// s daní se dopočítává
			if ($sazbaRadek > 0) {
				$sazbaRadek = $sazbaRadek / 100;
			}

			$sazbaRadek = 1 + $sazbaRadek;
			$ProductVariantyEntity->price_sdani = $sazbaRadek * $ProductVariantyEntity->price;
		} else {
			// bez dph se dopočítává
			//1 - 21/(100+21) = 0.8264
			//if ($sazba > 0) {
			$sazbaRadek = 1 - $sazbaRadek / (100 + $sazbaRadek);
			//	}
			$ProductVariantyEntity->price = $sazbaRadek * $ProductVariantyEntity->price_sdani;
		}
	}
	public function createAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "ProductVariantyCreate" == $this->getRequest->getPost('action', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('ProductVariantyCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$page_id = (int) $this->getRequest->getQuery('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID.");
					return false;
				}

				$postdata = $form->getValues();
				$postdata["product_id"] = $page_id;
				$ProductVariantyEntity = new ProductVariantyEntity();

				$ProductVariantyEntity->naplnEntitu($postdata);
				$this->vypocetCeny($ProductVariantyEntity);


	/*			$productVersionData = array();
				$zmenaCeny = false;
				if ($ProductVariantyEntity->price > $form->product->max_prodcena) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["max_prodcena"] = $ProductVariantyEntity->price;
				}
				if ($ProductVariantyEntity->price_sdani > $form->product->max_prodcena_sdph) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["max_prodcena_sdph"] = $ProductVariantyEntity->price_sdani;
				}

				if ($ProductVariantyEntity->price < $form->product->min_prodcena || $form->product->min_prodcena == 0) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["min_prodcena"] = $ProductVariantyEntity->price;
				}
				if ($ProductVariantyEntity->price_sdani < $form->product->min_prodcena_sdph || $form->product->min_prodcena_sdph == 0) {
					// cena varianty je větší než nejvyšší známá cena
					$zmenaCeny = true;
					$productVersionData["min_prodcena_sdph"] = $ProductVariantyEntity->price_sdani;
				}
*/
				$SaveEntity = new SaveEntity();
			/*	if ($zmenaCeny) {
					// uloz

					$ProductEntity = new ProductEntity($form->product);
					$ProductEntity->naplnEntitu($productVersionData);
					$SaveEntity->addSaveEntity($ProductEntity);
				}*/




				$valueAttribute	= $_POST["Application_Form_ProductVariantyCreate_attribute_value_id"];

				$hasAttribute = $_POST["Application_Form_ProductVariantyCreate_has_attribute_id"];

				//	$hasAttributeOriginal = $_POST["Application_Form_ProductVariantyEdit_attribute_original_id"];

				/*
				print_r($hasAttribute);
				print_r($valueAttribute);
				exit;
*/
				// smažu varianty
			//	$model = new models_ProductVarianty();
			//	$model->deleteRecords("mm_product_varianty_value_association","varianty_id={$page_id}");

				// prohledavam jen vybrané atributy



			//	$SaveEntity = new SaveEntity();

				$SaveEntity->addSaveEntity($ProductVariantyEntity);


				foreach ($hasAttribute as $key => $attribId)
				{
					// hledám k nim hodnoty
					$attribValueId = $valueAttribute[$attribId];

					$entita = new ProductVariantyValueAssociationEntity();
				//	$entita->varianty_id = $page_id;
					$entita->attribute_id = $attribValueId;
					$SaveEntity->addSaveEntity($entita);
				}



				if ($SaveEntity->save()) {

					// update min/max ceny ceny

					$model = new G_Service("");
					$sql = "update `mm_products` left join (
				SELECT product_id,max(price) as max_price,max(price_sdani) as max_price_sdani,
				min(price) as min_price, min(price_sdani) as min_price_sdani FROM `mm_product_varianty` where product_id=" . $form->product_id . " and isDeleted=0
				group by product_id) v on `mm_products`.id = v.product_id
				set max_prodcena = v.max_price,
				max_prodcena_sdph = v.max_price_sdani,
				min_prodcena = v.min_price,
				min_prodcena_sdph = v.min_price_sdani
				where v.product_id=" . $form->product_id;
					$model->query($sql);
					return true;
				}
			}
		}
	}
}

?>
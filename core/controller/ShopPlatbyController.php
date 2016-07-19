<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ShopPlatbyController extends G_Controller_Action
{
	public function saveAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_product', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ProductEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				//print_r($form->getValues());
				//print_r($form->getValues());
				$_product = new models_Products();
				$_product->setData($form->getValues());
				if($_product->update())
				{
					$_SESSION["statusmessage"]="Produkt byl aktualizován.";
					$_SESSION["classmessage"]="success";
					//$this->clear_post();
					$this->getRequest->clearPost();
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
	public function deleteAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('del_product', false))
		{
			//print "mažu";
			//print
			/*
			foreach($this->getRequest->getPost('del_product', false) as $key => $value)
			{
				list($key,$value);
			}*/
			$tenzin = $this->getRequest->getPost('del_product', false);
			list($key,$value) = each($tenzin);
		//	print $key;
			$product_id = $_POST['product_id'][$key];
		//	print_r($this->getRequest->getPost('product_id[$key]', false));
		//	$product_id = $this->getRequest->getPost('product_id['.$key.']', false);
			if ($product_id) {

				$_product = new models_ProductVyrobce();
				$row = $_product->getRow($product_id);

				//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
				if ($row) {
					//$_fotoPlaces->setData($data);

					if($_product->delete($product_id))
					{
						//$_SESSION["statusmessage"]="Foto bylo úspěšně přidáno k produktu.";
						//$_SESSION["classmessage"]="success";
						$this->getRequest->clearPost();
					}
				}
			}

		}
	}
	public function createAction()
	{
		if(false !== $this->getRequest->getPost('status', false))
		{


			/*

			   status = PAID, CANCELLED, PENDING


			   merchant=www_papiroverucniky_cz&test=true&price=1234&curr=CZK
			   &label=Payment+test&refId=27&cat=PHYSICAL&method=BANK_CZ_CSOB
			   &email=rudolf.pivovarcik%40centrum.cz
			   &transId=AVK7-1C7L-9OBV
			   &secret=WAdi305NpxXCoWtVIQkci6FXLOcXPtto
			   &status=PAID
			*/

			$status = $this->getRequest->getPost('status', false);
			$price = $this->getRequest->getPost('price', false) * 0.01;
			$method_code = $this->getRequest->getPost('method', false);
			$transId = $this->getRequest->getPost('transId', false);

			$label = $this->getRequest->getPost('label', false);

			$model = new models_ShopPlatby();
			$data = array();
			$data["amount"] = $price;
			$data["method"] = $method_code;
			$data["status"] = $status;


			/*
			if ($status == "PAID") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena.";
				$_SESSION["classmessage"]="success";
			}
			$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena.";
			$_SESSION["classmessage"]="success";
			if ($status == "CANCELLED") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena. Kontaktujte nás.";
				$_SESSION["classmessage"]="errors";
			}*/

			$data["label"] = $label;
			$data["transId"] = $transId;
			if ($model->insert($data)) {

			}

			print "code=0&message=OK";
			return $status;

		}
	}
	public function platbyList()
	{
		$ceniky = new models_ShopPlatby();

		$limit 	= $this->getRequest->getQuery('limit', 100);
		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');

		$querys = array();
		$querys[] = array('title'=>'Označení','url'=>'ozn','sql'=>'t1.oznaceni');
		$querys[] = array('title'=>'Platnost od','url'=>'from','sql'=>'t1.platnost_od');
		$querys[] = array('title'=>'Platnost do','url'=>'to','sql'=>'t1.platnost_do');
		$querys[] = array('title'=>'Marže','url'=>'mrz','sql'=>'t1.marze');
		//$querys[] = array('title'=>'RU_ru','url'=>'ru','sql'=>'t1.ru');
		$orderFromQuery = $this->orderFromQuery($querys, 't1.oznaceni ASC');

		$l = $ceniky->getList(array(
						'limit' => $limit,
						'fulltext' => $search_string,
						'page' => $page,
						'order' => $orderFromQuery,
						'debug' => 0,
						));

		//$this->categoryTable();
		return $l;
	}

}
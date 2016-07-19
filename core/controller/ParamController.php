<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ParamController extends G_Controller_Action
{
	public function saveAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('save_param', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ParamEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				//print_r($form->getValues());
				//print_r($form->getValues());
				$_productParam = new models_ProductParam();
				$_productParam->setData($form->getValues());
				if($_productParam->update())
				{
					$_SESSION["statusmessage"]="Parametr byl aktualizován.";
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
			$product_id = $this->getRequest->getPost('product_id', false);
			if ($product_id) {

				$_product = new models_Products();
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
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('add_param', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ParamCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				//$_product = new models_Products();
				$_productParam = new models_ProductParam();
				$_productParam->setData($form->getValues());
				if($_productParam->insert())
				{
					$_SESSION["statusmessage"]="Parametr byl přidán.";
					$_SESSION["classmessage"]="success";
					//$this->clear_post();
					$this->getRequest->clearPost();
				}
			} else {
				foreach($form->getError() as $key => $value)
				{
					$_SESSION["statusmessage"]= $key . ": ". $value;
				}
				//print_r($form->getError());

				$_SESSION["classmessage"]="errors";
			}
		}
	}
	public function detailAction($param_id)
	{
		$_productParam = new models_ProductParam();
		$row = $_productParam->getRow($param_id);

		//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
		if (!$row) {
			return false;
		}
		return $row;
	}

}
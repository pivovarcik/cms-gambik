<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class CustomerController extends G_Controller_Action
{
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('save_order', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('CustomerCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$_customer = new models_Customers();
				$_customer->setData($form->getValues());
				if($_customer->insert())
				{
					$_SESSION["statusmessage"]="Produkt byl přidán.";
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

}
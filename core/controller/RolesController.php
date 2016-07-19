<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class RolesController extends G_Controller_Action
{

	public function saveAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_role', false))
		{
			$form = $this->formLoad('AdminRoleEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();

				$models = new models_Roles();
				$role_id = $form->getPost('id', 0);
				$roleDetail = $models->getDetailById($role_id);
				if (!$roleDetail)
				{
					$form->setResultError("Uživatel s tímto ID neexistuje!");
					return false;
				}

				$entitaOut = new RolesEntity($roleDetail);
				$entitaOut->naplnEntitu($formdata);

				$saveEntity = new SaveEntity();
				$saveEntity->addSaveEntity($entitaOut);

				if ($saveEntity->save()) {


					$form->setResultSuccess("Uloženo");
					$this->getRequest->goBackRef();
				}
			}
		}
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_role', false))
		{
			$form = $this->formLoad('AdminRoleCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();

				$entitaOut = new RolesEntity();
				$entitaOut->naplnEntitu($formdata);

				$saveEntity = new SaveEntity();
				$saveEntity->addSaveEntity($entitaOut);

				if ($saveEntity->save()) {


					$form->setResultSuccess("Přidáno.");
					$this->getRequest->goBackRef();
				}
			}
		}
	}
}
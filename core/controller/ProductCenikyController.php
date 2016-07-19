<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ProductCenikyController extends G_Controller_Action
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
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_product_vyrobce', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ProductVyrobceCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$_product = new models_ProductVyrobce();
				$_product->setData($form->getValues());
				if($_product->insert())
				{
					$_SESSION["statusmessage"]="Výrobce byl přidán.";
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

	public function cenikyListEdit()
	{
		$l = $this->cenikyList();

		for ($i=0;$i < count($l);$i++)
		{
			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{


				// Když je vybrán objekt
				$elemKlicCat = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$klicCatValue = $l[$i]->uid;
				$elemKlicCat->setAttribs('value', $klicCatValue);
				$elemKlicCat->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemKlicCat->render();

				$elemOznaceni = new G_Form_Element_Text("oznaceni[" . $i . "]");
				$value = $this->getRequest->getPost("oznaceni[" . $i . "]", $l[$i]->oznaceni);
				$elemOznaceni->setAttribs('value',$value);
				$l[$i]->oznaceni = $elemOznaceni->render();

				$elemPopis = new G_Form_Element_Text("popis[" . $i . "]");
				$value = $this->getRequest->getPost("popis[" . $i . "]", $l[$i]->popis);
				$elemPopis->setAttribs('value',$value);
				$l[$i]->popis = $elemPopis->render();

				$elemPlatnostOd = new G_Form_Element_Text("platnost_od[" . $i . "]");
				$value = $this->getRequest->getPost("platnost_od[" . $i . "]", $l[$i]->platnost_od);
				$elemPlatnostOd->setAttribs('value',$value);
				$l[$i]->platnost_od = $elemPlatnostOd->render();

				$elemPlatnostDo = new G_Form_Element_Text("platnost_do[" . $i . "]");
				$value = $this->getRequest->getPost("platnost_do[" . $i . "]", $l[$i]->platnost_do);
				$elemPlatnostDo->setAttribs('value',$value);
				$l[$i]->platnost_do = $elemPlatnostDo->render();

				$elemMarze = new G_Form_Element_Text("marze[" . $i . "]");
				$value = $this->getRequest->getPost("marze[" . $i . "]", $l[$i]->marze);
				$elemMarze->setAttribs('value',$value);
				$l[$i]->marze = $elemMarze->render();

				$l[$i]->cmd = '';
			} else {
				$elemKlicMa = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemKlicMa->setAttribs('value', $value);
				$l[$i]->checkbox = $elemKlicMa->render();
/*
				$keyId = $l[$i]->keyid;
				$cs = $l[$i]->cs;
				$en = $l[$i]->en;
				$de = $l[$i]->de;
				$ru = $l[$i]->ru;
*/
				$command = '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu SMAZAT slovo: '.$l[$i]->keyid.'?\')" type="image" src="'.URL_HOME . 'admin/action_delete.gif" value="X" name="delete_item[' . $i . ']"/>';

				$command .= '<input type="hidden" value="' . $l[$i]->uid . '" name="item_id[' . $i . ']"/>';
				$l[$i]->cmd = $command;
			}
		}
		return $l;
	}
	public function cenikyList()
	{
		$ceniky = new models_Ceniky();

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
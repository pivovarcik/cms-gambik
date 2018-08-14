<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class CityController extends G_Controller_Action
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
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('del_city', false))
		{
			//print "mažu";
			//print
			/*
			foreach($this->getRequest->getPost('del_product', false) as $key => $value)
			{
				list($key,$value);
			}*/
			$tenzin = $this->getRequest->getPost('del_city', false);
			list($key,$value) = each($tenzin);
		//	print $key;
			$city_id = $_POST['city_id'][$key];
		//	print_r($this->getRequest->getPost('product_id[$key]', false));
		//	$product_id = $this->getRequest->getPost('product_id['.$key.']', false);
			if ($city_id) {

				$model = new models_Mesta();
				if($model->delete($city_id))
				{
					//$_SESSION["statusmessage"]="Foto bylo úspěšně přidáno k produktu.";
					//$_SESSION["classmessage"]="success";
					$this->getRequest->clearPost();
				}
			}

		}
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_city', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('CityCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$model = new models_Mesta();
				$model->setData($form->getValues());
				if($model->insert())
				{
					$_SESSION["statusmessage"]="Město bylo přidáno.";
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
	public function mestaListEdit($params = array())
	{
		$l = $this->mestaList($params);

		$mesta = new models_Mesta();
		$krajeList = $mesta->get_Krajelist();

		//$imageController = new ImageController();

		for ($i=0;$i < count($l);$i++)
		{
			//$url = URL_HOME . "admin/edit_catalog.php?id=" . $l[$i]->uid;

			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{

				$uid = $l[$i]->uid;
				$elemUid = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemUid->setAttribs('value', $value);
				$elemUid->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemUid->render();

				$titulek = $l[$i]->mesto;
				//	$l[$i]->name = '<a href="' . $url . '">' . $l[$i]->name . '</a>';

				$elemMesto = new G_Form_Element_Text("mesto[" . $i . "]");
				$value = $this->getRequest->getPost("mesto[" . $i . "]", $titulek);
				$elemMesto->setAttribs('value',$value);
				$l[$i]->mesto = $elemMesto->render();


				$elemKraj = new G_Form_Element_Select("kraj[" . $i . "]");
				$elemKraj->setAttribs(array("id"=>"kraj[" . $i . "]","required"=>false));
				$value = $this->getRequest->getPost("kraj[" . $i . "]", $l[$i]->okres);
				$elemKraj->setAttribs('value',$value);
				$pole = array();
				$pole[0] = " -- neuvedeno -- ";
				$attrib = array();
				foreach ($krajeList as $key => $value)
				{
						$pole[$value->uid] = $value->kraj;
				}
				$elemKraj->setMultiOptions($pole,$attrib);
				$l[$i]->kraj = $elemKraj->render();

				$l[$i]->cmd = '';

			} else {

				$klic_ma = $l[$i]->uid;
				$titulek = $l[$i]->mesto;

				$uid = $l[$i]->uid;
				$elemUid = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemUid->setAttribs('value', $value);
				//$elemUid->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemUid->render();


				//$l[$i]->kraj = $l[$i]->okres_nazev;

				$nazevMat = '<h4><a href="' . $url . '">' . $l[$i]->mesto . '</a></h4>';

				//$nazevMat .= '<br /><span class="desc">' . trim($eshop->truncate(trim(strip_tags($l[$i]->popis)),150)) . '</span>';
				$l[$i]->mesto = $nazevMat;
				//$nazevSkupiny = $l[$i]->skupina_nazev;
				//	$l[$i]->prodcena = number_format($l[$i]->prodcena, 2, ',', ' ');


				//$l[$i]->description_cs = trim(truncate(trim(strip_tags($l[$i]->description_cs)),150));

				$command = '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu SMAZAT '.$titulek.'?\')" type="image" src="'.URL_HOME . 'admin/action_delete.gif" value="X" name="del_city[' . $i . ']"/>';

				$command .= '<input type="hidden" value="' . $klic_ma . '" name="city_id[' . $i . ']"/>';


				$l[$i]->cmd = $command;
				//$l[$i]->cmd = 'nic';
			}
		}
		return $l;
	}
	public function mestaList($params = array())
	{
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}

		$model = new models_Mesta();

		$limit 	= $this->getRequest->getQuery('limit', 50);
		if (isset($params["limit"]) && is_numeric($params["limit"])) {
			$limit = (int) $params["limit"];
		}
		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');
		$search_string = $this->getRequest->getQuery('term', $search_string);
		$city = $this->getRequest->getQuery('city', '');
		$kraj = $this->getRequest->getQuery('kraj', '');

		$tree = $this->getRequest->getQuery('tree', '');
		if (isset($params['tree']) && is_numeric($params['tree'])) {
			$tree = $params['tree'];
		}
		$bezsouradnic = 0;
		if (isset($params['bezsouradnic'])) {
			$bezsouradnic = 1;
		}
		$querys = array();
		$querys[] = array('title'=>'Zařazení','url'=>'kraj','sql'=>'t2.kraj');
		$querys[] = array('title'=>'Město','url'=>'city','sql'=>'t1.mesto');

		$orderFromQuery = $this->orderFromQuery($querys, 't1.mesto ASC');
		if (isset($params["order"]) && !empty($params["order"])) {
			$orderFromQuery = $params["order"];
		}
		$l = $model->getList(array(
						'limit' => $limit,
						'fulltext' => $search_string,
						'page' => $page,
						'city' => $city,
						'kraj' => $kraj,
						'order' => $orderFromQuery,
						'debug' => 0,
						'bezsouradnic' => $bezsouradnic,
						));
		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}

	public function uliceList($params = array())
	{
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}

		$model = new models_Ulice();

		$limit 	= $this->getRequest->getQuery('limit', 50);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}

		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');
		$city = $this->getRequest->getQuery('city', '');
		$kraj = $this->getRequest->getQuery('kraj', '');

		$tree = $this->getRequest->getQuery('tree', '');
		if (isset($params['tree']) && is_numeric($params['tree'])) {
			$tree = $params['tree'];
		}
		$bezsouradnic = 0;
		if (isset($params['bezsouradnic'])) {
			$bezsouradnic = 1;
		}
		$querys = array();
		$querys[] = array('title'=>'Zařazení','url'=>'kraj','sql'=>'t2.kraj');
		$querys[] = array('title'=>'Město','url'=>'city','sql'=>'t1.mesto');

		$orderFromQuery = $this->orderFromQuery($querys, 't1.mesto ASC');
		if (isset($params["order"]) && !empty($params["order"])) {
			$orderFromQuery = $params["order"];
		}
		$l = $model->getList(array(
						'limit' => $limit,
						'fulltext' => $search_string,
						'page' => $page,
						'city' => $city,
						'kraj' => $kraj,
						'order' => $orderFromQuery,
						'debug' => 0,
						'bezsouradnic' => $bezsouradnic,
						));
		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}
	public function mestaListAutoComplete($params = array())
	{
		$l = $this->mestaList($params);

	//	$mesta = new models_Mesta();
		//$krajeList = $mesta->get_Krajelist();

		//$imageController = new ImageController();

		for ($i=0;$i < count($l);$i++)
		{


			$klic_ma = $l[$i]->uid;

			$l[$i]->value = $l[$i]->mesto . "(" . $l[$i]->okres . ")";

		}
		return $l;
	}
	public function mestaCatalogList()
	{


		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}

		$model = new models_Mesta();

		$limit 	= $this->getRequest->getQuery('limit', 50);
		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');
		$city = $this->getRequest->getQuery('city', '');
		$kraj = $this->getRequest->getQuery('kraj', '');

		$tree = $this->getRequest->getQuery('tree', '');
		if (isset($params['tree']) && is_numeric($params['tree'])) {
			$tree = $params['tree'];
		}

		$querys = array();
		$querys[] = array('title'=>'Zařazení','url'=>'kraj','sql'=>'t2.kraj');
		$querys[] = array('title'=>'Město','url'=>'city','sql'=>'t1.mesto');

		$orderFromQuery = $this->orderFromQuery($querys, 't1.mesto ASC');

		$l = $model->get_mestaCaloglist(array(
						'limit' => $limit,
						'fulltext' => $search_string,
						'page' => $page,
						'city' => $city,
						'kraj' => $kraj,
						'order' => $orderFromQuery,
						'debug' => 0,
						));
		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}
}
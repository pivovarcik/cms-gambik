<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 *
 * status,
 * vip,
 * description,
 * address1,
 * address1,
 * psc
 * telefon
 * poznamka
 * lng, lat
 */

class AdsController extends G_Controller_Action
{
	public $total = 0;

	public function getAd($id)
	{
		$model = new models_Ads();
		return $model->getAd($id);
	}

	public function renderAds($id)
	{
		$model = new models_Ads();
		$ad = $model->getAd($id);
		$res='<a rel="nofollow" target="' . $ad->target . '" href="' . $ad->code_url . '">';

		$res .='<img alt="Banner' . $id . '" src="' . $ad->banner . '" />';

		$res .= '</a>';

		return $res;

	}

	public function adAudit($id)
	{
		$model = new models_Ads();
		return $model->adAudit($id);
	}

	public function adsListEdit($params = array())
	{
		$l = $this->adsList($params);

		for ($i=0;$i < count($l);$i++)
		{
			$url = URL_HOME . "admin/edit_ad.php?id=" . $l[$i]->uid;

			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{

				$uid = $l[$i]->uid;
				$elemUid = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemUid->setAttribs('value', $value);
				$elemUid->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemUid->render();

				$titulek = $l[$i]->nazev;
			//	$l[$i]->name = '<a href="' . $url . '">' . $l[$i]->name . '</a>';

				$elemTitulek = new G_Form_Element_Text("nazev[" . $i . "]");
				$value = $this->getRequest->getPost("nazev[" . $i . "]", $titulek);
				$elemTitulek->setAttribs('value',$value);
				$l[$i]->titulek_cs = $elemTitulek->render();

				$url = $l[$i]->url;
				$elemUrl = new G_Form_Element_Text("url[" . $i . "]");
				$value = $this->getRequest->getPost("url[" . $i . "]", $url);
				$elemUrl->setAttribs('value',$value);
				$l[$i]->url = $elemUrl->render();

				$banner = $l[$i]->banner;
				$elemBanner = new G_Form_Element_Text("banner[" . $i . "]");
				$value = $this->getRequest->getPost("banner[" . $i . "]", $banner);
				$elemBanner->setAttribs('value',$value);
				$l[$i]->banner = $elemBanner->render();

				$l[$i]->cmd = '';

			} else {

				$klic_ma = $l[$i]->uid;
				$titulek = $l[$i]->nazev;

				$uid = $l[$i]->uid;
				$elemUid = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemUid->setAttribs('value', $value);
				$elemUid->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemUid->render();

				//$l[$i]->status = $elemStatus->render();

				$datum_registrace = date("j.n.Y", strtotime($l[$i]->registrace));
				$datum_expirace = date("j.n.Y", strtotime($l[$i]->expirace));
				$l[$i]->registrace_expirace = $datum_registrace . '<br />' . $datum_expirace;

				$datum_vlozeni = date("j.n.Y H:i", strtotime($l[$i]->caszapsani));
				if (!empty($l[$i]->casnaposledy)) {
					$datum_editace = date("j.n.Y H:i", strtotime($l[$i]->casnaposledy));
				} else {
					$datum_editace = '-';
				}



				//$qty = $l[$i]->qty;

				/*
				   if ( $l[$i]->typ_sort =='A') {
				   $url = URL_HOME . "admin/edit_product_alukola.php?id=" . $l[$i]->klic_ma;
				   } else {
				   $url = URL_HOME . "admin/edit_product.php?id=" . $l[$i]->klic_ma;
				   }

				*/
				//$l[$i]->cislo_mat = '<a href="' . $url . '">' . $l[$i]->cislo_mat . '</a>';

				$nazevMat = '<h4><a href="' . $url . '">' . $l[$i]->nazev . '</a></h4>';

				//$nazevMat .= '<br /><span class="desc">' . trim($eshop->truncate(trim(strip_tags($l[$i]->popis)),150)) . '</span>';
				$l[$i]->nazev = $nazevMat;

				$l[$i]->cmd = $command;
				//$l[$i]->cmd = 'nic';
			}
		}
		return $l;
	}
	public function adsList($params = array())
	{
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}

		$model = new models_Ads();

		$limit 	= $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}


		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');

		$querys = array();
		$querys[] = array('title'=>'Název','url'=>'titul','sql'=>'t1.titulek_cs');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'t1.description_cs');
		$querys[] = array('title'=>'Zařazení','url'=>'cat','sql'=>'t5.nazev_' . $znak);
		$querys[] = array('title'=>'Město','url'=>'city','sql'=>'t2.mesto');

		$querys[] = array('title'=>'Vloženo','url'=>'add','sql'=>'t1.caszapsani');
		$querys[] = array('title'=>'Editace','url'=>'edit','sql'=>'t1.casnaposledy');
		$querys[] = array('title'=>'Registrace','url'=>'reg','sql'=>'t1.registarce');
		$querys[] = array('title'=>'Expirace','url'=>'exp','sql'=>'t1.expirace');


		$orderFromQuery = 't1.nazev ASC';
		$l = $model->getList(array(
						'limit' => $limit,
						'search' => $search_string,
						'page' => $page,
						'tree' => $tree,
						'vip' => $vip,
						'status' => $status,
						'order' => $orderFromQuery,
						'kraj' => $kraj,
						'city' => $mesto,
						'debug' => 0,
						));
		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}

	public function saveAction()
	{
		// Je odeslán formulář

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('save_ad', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('AdEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				//print_r($form->getValues());
				//print_r($form->getValues());

				$model = new models_Ads();
/*
				$changes = array();
				$changes["titulek_cs"] = $this->getRequest->getPost('titulek_cs', '');
				$changes["description_cs"] = $this->getRequest->getPost('description_cs', '');
*/
				$postdata = $form->getValues();
				if (isset($postdata["nazev"])) {
					$data["nazev"] = $postdata["nazev"];
				}

				if (isset($postdata["url"])) {
					$data["url"] = $postdata["url"];
				}

				if (isset($postdata["banner"])) {
					$data["banner"] = $postdata["banner"];
				}
				if (isset($postdata["target"])) {
					$data["target"] = $postdata["target"];
				}

				//$data["casnaposledy"] = date('Y-m-d H:i:s');
				//$data["uid_user_edit"] = USER_ID;
				$id = $this->getRequest->getPost('uid', 0);

				if($model->updateRecords($model->getTableName(), $data, "uid={$id}"))
				{
				//	print $model->last_query;
				//	exit;
					$_SESSION["statusmessage"]="Záznam byl aktualizován.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->clearPost();

				}
				//$this->getRequest->clearPost();
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


		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action_hromadne', false) && false !== $this->getRequest->getPost('edit', false))
		{

			if($this->getRequest->isPost() && 'edit_finish' == $this->getRequest->getPost('action', ''))
			{


				$model = new models_Attributes();
				$vybranePolozky = $this->getRequest->getPost('slct', array());


				$data = array();
				if (false !== $this->getRequest->getPost('name', false)) {
					$data["name"] = $this->getRequest->getPost('name', array());
				}
				if (false !== $this->getRequest->getPost('description', false)) {
					$data["description"] = $this->getRequest->getPost('description', array());
				}
				$pocitadlo = 0;
				$pocet = count($vybranePolozky);
				for($i=0;$i<100;$i++)
				{
					if (isset($vybranePolozky[$i]))
					{
						$changes = array();
						foreach ($data as $key => $value)
						{
						//	print_r($key);
						//	print_r($value);

							$changes[$key] = $value[$i];

						}
						$changes["casnaposledy"] = date('Y-m-d H:i:s');
						$changes["uid_user_edit"] = USER_ID;
						//print_r($changes);
						$model->updateRecords($model->getTableName(), $changes, "ID={$vybranePolozky[$i]}");
						$pocitadlo++;
					}
					if ($pocitadlo==$pocet)
					{
						break;
					}
				}

				$this->getRequest->clearPost();
			}
		}


		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('clear', false))
		{
			$this->getRequest->clearPost();
		}
	}




}

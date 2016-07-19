<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ProtokolController extends G_Controller_Action
{

	public function getProtokol($id)
	{
		$_fotoGallery = new models_FotoGallery();
		return $_fotoGallery->getRow($foto_id);
	}
	public function protokolListEdit($params = array())
	{
		$l = $this->getProtokolList($params);
		for ($i=0;$i < count($l);$i++)
		{
			$l[$i]->TimeStamp = date("j.n.Y H:i:s", strtotime($l[$i]->TimeStamp));
			$l[$i]->counter = ($i+1) . ".";
			$l[$i]->nick = '<a title="Přejít na detail uživatele" href="'.URL_HOME.'admin/user_detail.php?id=' . $l[$i]->user_id . '">' . $l[$i]->nick . '</a>, ' . $l[$i]->ip;
		}
		return $l;
	}
	public function getProtokolList($params = array())
	{
		//$product = new models_Predfaktury();

		//	$l = $this->prenosPredfaktur($params);
		//	return $l;

		$model = new models_Protokol();
		$limit 	= $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		} else {
			$params['limit'] = $limit;
		}
		//	$params["uid_user"] = USER_ID;
		$page 	= $this->getRequest->getQuery('pg', 1);
		$params['page'] = $page;
		$search_string = $this->getRequest->getQuery('q', '');
		if ( !empty($search_string) ) {
			$params['fulltext'] = $search_string;
			//print $date_from;
		}
/*
   $child = $this->getRequest->getQuery('child', '');
   if (isset($params['child']) && is_numeric($params['child'])) {
   $child = $params['child'];
   }
*/
		//$aktivni = $this->getRequest->getQuery('akt', '1');
		$date_from = $this->getRequest->getQuery('df', '');
		if ( !empty($date_from) ) {
			$date_from = strtotime($date_from);
			$date_from = date("Y-m-d H:i:s",$date_from);
			$params['date_from'] = $date_from;
			//print $date_from;
		}
		$date_to = $this->getRequest->getQuery('dt', '');
		if ( !empty($date_to) ) {
			$date_to = strtotime($date_to);
			$date_to = date("Y-m-d",$date_to) . " 23:59:59";
			$params['date_to'] = $date_to;
			//print $date_to;
		}

		$zadatel = $this->getRequest->getQuery('user', '');
		if ( !empty($zadatel) ) {
			$zadatel = (int) $zadatel;
			$params['zadatel'] = $zadatel;
			//print $zadatel;
		}

		$stav = $this->getRequest->getQuery('stav', '');
		if ( !empty($stav) ) {
			$stav = (int) $stav;
			$params['stav'] = $stav;
			//print $zadatel;
		}

		$stredisko = $this->getRequest->getQuery('str', '');
		if ( !empty($stredisko) ) {
			//$zadatel = (int) $zadatel;
			$params['stredisko'] = $stredisko;
			//print $zadatel;
		}

		$querys = array();
		$querys[] = array('title'=>'Název','url'=>'prod','sql'=>'t1.nazev_mat_cs');
		$querys[] = array('title'=>'Číslo','url'=>'num','sql'=>'t1.cislo_mat');
		$querys[] = array('title'=>'Kategorie','url'=>'cat','sql'=>'t3.nazev_cs');
		$querys[] = array('title'=>'Skupina','url'=>'grp','sql'=>'t2.nazev_cs');
		$querys[] = array('title'=>'Cena','url'=>'prc','sql'=>'t1.prodcena');
		$querys[] = array('title'=>'Množ.','url'=>'qty','sql'=>'t1.qty');
		if (isset($params['order']) && !empty($params['order'])) {

		} else {
			$orderFromQuery = $this->orderFromQuery($querys, 't1.caszapsani DESC');
			$params['order'] = $orderFromQuery;
		}
		$comapany = isset($_SESSION["uid_company"]) ? $_SESSION["uid_company"] : 0;
		if ($comapany > 0) {
			$comapany = (int) $comapany;
			$params['company'] = $comapany;
		}
/*
   $l = $model->get_list(array(
   'limit' => $limit,
   'fulltext' => $search_string,
   'page' => $page,
   'order' => $orderFromQuery,
   'debug' => 0,
   'company' => $comapany,
   ));
*/
		//PRINT_R($params);
		$l = $model->getList($params);

		//print_r($l);
		$this->total = $model->total;
		//$this->categoryTable();

		return $l;
	}

	public function setProtokol($akce, $note)
	{
		$model = new models_Protokol();
		$data = array();
		$data["akce"] = $akce;
		$data["protokol"] = $note;
		if (defined("USER_ID")) {
			$data["user_id"] = USER_ID;
		}

		$data["url"] = $this->getRequest->getServer("REQUEST_URI");
		//$data["caszapsani"] = date('Y-m-d H:i:s');
		$data["ip"] = $this->getRequest->getServer("REMOTE_ADDR");
		$model->insertRecords($model->getTableName(), $data);

		if ($akce == "SQL error") {
			$message = $_SERVER["SERVER_NAME"] . '\n' . $note;

		//	mail("rudolf.pivovarcik@centrum.cz",$akce,$message);

		}

	//	print $model->getTableName();
	//	print_r($data);
	//	exit;
	}
}
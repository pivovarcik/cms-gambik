<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_FotoGallery extends G_Service{

	function __construct()
	{
		parent::__construct(T_FOTO);
	}


	public function getDetailById($id)
	{
		$params = new ListArgs();
		$params->id = (int) $id;
		$params->page = 1;
		$params->limit = 1;
		$list = $this->getList($params);

		if (count($list) == 1) {
			return $list[0];
		}
	}
	public function getList(IListArgs $params=null)
	{

		$this->clearWhere();
		if (is_null($params)) {
			$params = new ListArgs();
		}

		if (isset($params->id) && isInt($params->id)) {
			$this->addWhere("t1.id = " . $params->id);
		}
		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 't1.TimeStamp DESC');


		$this->setSelect("t1.*,u.nick");
		$this->setFrom($this->getTableName() . " AS t1
		LEFT JOIN " . T_USERS . " u ON t1.user_id = u.id");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();


		if(isset($params->thumb_width) && !empty($params->thumb_height))
		{
			$imageController = new ImageController();
		}
		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->thumb = '';
			if (!empty($list[$i]->file) && isset($params->thumb_width) && isset($params->thumb_height)) {

				if (isset($params->thumb_width)) {
					$thumb_width = $params->thumb_width;
				}

				if (isset($params->thumb_height)) {
					$thumb_height = $params->thumb_height;
				}

				$list[$i]->thumb = '<a href="' . URL_IMG . $list[$i]->file . '"><img src="' . $imageController->get_thumb($list[$i]->file,$thumb_width,$thumb_height,null,false,true) . '" class="imgobal" /></a>';
			}
		}

	//	print_r($list);
		return $list;
	}
	public function get_umisteni_list($params=array())
	{
		$this->clearWhere();
		if (isset($params['catalog']) && is_numeric($params['catalog'])) {
			$this->addWhere("t1.uid_catalog=" . $params['catalog']);
		}
		if (isset($params['product']) && is_numeric($params['product'])) {
			$this->addWhere("t2.table='" . T_SHOP_PRODUCT . "'");
			$this->addWhere("t2.uid_target=" . $params['product']);
		}
		if (isset($params['game']) && is_numeric($params['game'])) {
			$this->addWhere("t2.table='mm_catalog_games'");
			$this->addWhere("t2.uid_target=" . $params['game']);
		}

		if (isset($params['game']) && is_numeric($params['game'])) {
			$this->addWhere("t2.table='mm_catalog_games'");
			$this->addWhere("t2.uid_target=" . $params['game']);
		}
		// univerzální
		if (isset($params['gallery_id']) && isset($params['gallery_type'])) {
			$this->addWhere("t2.table='" . $params['gallery_type'] . "'");
			$this->addWhere("t2.uid_target=" . $params['gallery_id']);
		}
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$aktPage = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($aktPage, $limit);
		$this->setOrderBy($params['order'], 't2.order ASC, t1.TimeStamp DESC');

		$this->setSelect("t1.*,t2.id as place_id");
		$this->setFrom(T_FOTO. " AS t1
				LEFT JOIN " . T_FOTO_PLACES . " t2 ON t1.id = t2.uid_source");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $this->getWhere();
		$this->total = $this->get_var($query);
		$list = $this->getRows();

		//Print $this->getLastQuery();
		return $list;
	}


	public function convertClankyToPages()
	{

		$this->start_transakce();
		$query = "select * from " . $this->getTableName() . "_back order by uid ASC ";
		print $query;
		// where uid=12
		$clanky = $this->get_results($query);
		$fotoPlacesModel = new models_FotoPlaces();

		//$query = "delete from " . $this->_name . "";
		$this->deleteRecords($this->getTableName());

		$this->deleteRecords($fotoPlacesModel->getTableName());

		$all_query_ok = true;
		//print_R($clanky);
		print "Počet záznamů:" . count($clanky). "<br />";
		for ($i = 0; $i < count($clanky);$i++)
		{
			print "" . ($i+1) . ":";
			$data = array();
			$version = 0;
			$data["id"] = $clanky[$i]->uid;
			$data["user_id"] =  $clanky[$i]->uid_user;
			$data["file"] = $clanky[$i]->file;
			$data["TimeStamp"] = $clanky[$i]->caszapsani;
			$data["ChangeTimeStamp"] = $clanky[$i]->caszapsani;
			$data["description"] = $clanky[$i]->popis;
			$this->insertRecords($this->getTableName(),$data);
			$this->commit ? null : $all_query_ok = false;

			if ($clanky[$i]->uid_category > 0) {

				$data = array();
				$data["uid_source"] = $this->insert_id;
				$data["uid_target"] = $clanky[$i]->uid_category;
				$data["table"] = T_CATEGORY;

				$fotoPlacesModel->insertRecords($fotoPlacesModel->getTableName(), $data);
				$this->commit ? null : $all_query_ok = false;
			}

		}
		//$this->konec_transakce($this->all_query_ok);
		$this->konec_transakce($all_query_ok);
	}
}
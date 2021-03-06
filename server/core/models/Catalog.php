<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("Pages.php");
abstract class models_Catalog extends models_Pages{

	function __construct($table)
	{
		//parent::__construct(T_CATALOG_FIREM);$table
		parent::__construct($table);
	}



	protected function getCatalog($list)
	{
		$obj = $this->getPage($list);
		if (count($list)>0) {

			for($i=0;$i<count($list);$i++)
			{
				$name = "link_" . $list[$i]->code;
				$obj->$name = URL_HOME2 . $list[$i]->code . "/" . get_categorytourl($list[$i]->serial_cat_url) . '/'. $list[$i]->page_id . '-' . strToUrl($list[$i]->title) . '.html';



				if ($list[$i]->code == LANG_TRANSLATOR) {

					$obj->pagetitle = !empty($list[$i]->pagetitle) ? $list[$i]->pagetitle : $list[$i]->title;
					//	$obj->pagekeywords = $list[$i]->pagekeywords;
					$obj->pagekeywords = !empty($list[$i]->pagekeywords) ? $list[$i]->pagekeywords : $list[$i]->nazev_category;
					$obj->pagedescription = $list[$i]->pagedescription;
				}
			}

			return $obj;
		}
		return false;

	}
	public function getDetailById($catalog_id)
	{

		$params = new ListArgs();
		$params->id = (int) $catalog_id;

		$list = $this->getList($params);
		if (count($list) > 0) {
			return $this->getCatalog($list);
		}
		return false;
	}

	public function getDetailByVlastnikId($vlastnik_id)
	{
		//$subdomain = strtolower($subdomain);

		$params = new ListArgs();
		$params->vlastnik_id = (int) $vlastnik_id;

		//$params['status'] = 1;
		$list = $this->getList($params);
		if (count($list) > 0) {
			return $this->getCatalog($list);
		}
		return false;
	}

	public function setMainLogo($catalog_id, $foto_id)
	{
		$data = array();
		$data["logo_id"] = $foto_id;
		if($this->updateRecords($this->getTableName(), $data, "id={$catalog_id}"))
		{
			return true;
		}
	}

	public function getCatalogBySubDomain($subdomain)
	{
		$subdomain = strtolower($subdomain);

		$params = array();
		$params["subdomena"] =$subdomain;

		$params['status'] = 1;
		$list = $this->getList($params);


		if (count($list) == 1) {


			/**
			 * Photo Gallery
			 * */

			$this->clearWhere();
			//	$this->addWhere("t2.table='" . $this->_name . "'");

			$catalog_id =$list[0]->uid;

			$this->addWhere("t1.uid_catalog=" . $catalog_id);
			//	$this->addWhere("t1.status=1");
			$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
			$aktPage = (int) isset($params['page']) ? $params['page'] : 1;
			$this->setLimit($aktPage, $limit);
			$this->setOrderBy($params['order'], 't1.caszapsani ASC');

			$this->setSelect("t1.*");
			$this->setFrom(T_FOTO. " AS t1");
			$query = "select count(*) from "
				. $this->getFrom() . " "
				. $this->getWhere() . " "
				. $this->getGroupBy();
			//print $this->getWhere();
			//print $query;
			$this->totalPhotos = $this->get_var($query);
			$this->photos = $this->getRows();

			return $list[0];
		}


		/*	*/
		//print_r($this->attributes);
		return false;
	}

/*	public function getCatalogTemp($id)
	{
		if (is_numeric($id)) {
			$id = (int) $id;
			$where = "t1.uid=" . $id;
		} else {
			$where = "t1.hash='" . $id . "'";
		}


		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}
		//	, a.description
		$productQuery = "
		SELECT t1.*,logo.file as logo_file,
				t2.mesto AS mesto_nazev,t2.okres AS kraj,
				t4.file,t4.popis as popis_foto,
		sql2.nazev_" . $znak ." AS category_nazev,

		            concat(
    (case when sql11.nazev_" . $znak . " is null then '' else sql11.nazev_" . $znak . " end),'|',
    (case when sql10.nazev_" . $znak . " is null then '' else sql10.nazev_" . $znak . " end),'|',
    (case when sql9.nazev_" . $znak . " is null then '' else sql9.nazev_" . $znak . " end),'|',
    (case when sql8.nazev_" . $znak . " is null then '' else sql8.nazev_" . $znak . " end),'|',
    (case when sql7.nazev_" . $znak . " is null then '' else sql7.nazev_" . $znak . " end),'|',
    (case when sql6.nazev_" . $znak . " is null then '' else sql6.nazev_" . $znak . " end),'|',
    (case when sql5.nazev_" . $znak . " is null then '' else sql5.nazev_" . $znak . " end),'|',
    (case when sql4.nazev_" . $znak . " is null then '' else sql4.nazev_" . $znak . " end),'|',
    (case when sql3.nazev_" . $znak . " is null then '' else sql3.nazev_" . $znak . " end),'|',
    (case when sql2.nazev_" . $znak . " is null then '' else sql2.nazev_" . $znak . " end)
    ) as serial_cat_nazev,
    concat(
    (case when sql11.url_friendly_" . $znak . " is null then '' else sql11.url_friendly_" . $znak . " end),'|',
    (case when sql10.url_friendly_" . $znak . " is null then '' else sql10.url_friendly_" . $znak . " end),'|',
    (case when sql9.url_friendly_" . $znak . " is null then '' else sql9.url_friendly_" . $znak . " end),'|',
    (case when sql8.url_friendly_" . $znak . " is null then '' else sql8.url_friendly_" . $znak . " end),'|',
    (case when sql7.url_friendly_" . $znak . " is null then '' else sql7.url_friendly_" . $znak . " end),'|',
    (case when sql6.url_friendly_" . $znak . " is null then '' else sql6.url_friendly_" . $znak . " end),'|',
    (case when sql5.url_friendly_" . $znak . " is null then '' else sql5.url_friendly_" . $znak . " end),'|',
    (case when sql4.url_friendly_" . $znak . " is null then '' else sql4.url_friendly_" . $znak . " end),'|',
    (case when sql3.url_friendly_" . $znak . " is null then '' else sql3.url_friendly_" . $znak . " end),'|',
    (case when sql2.url_friendly_" . $znak . " is null then '' else sql2.url_friendly_" . $znak . " end)
    ) as serial_cat_url
		FROM mm_catalog_temp t1
		LEFT JOIN " . T_MESTA . " AS t2 ON t1.mesto = t2.uid
		left join " . T_CATEGORY . " sql2 on t1.category = sql2.uid
	    left join " . T_CATEGORY . " sql3 on sql2.parent_uid=sql3.uid
	    left join " . T_CATEGORY . " sql4 on sql3.parent_uid=sql4.uid
	    left join " . T_CATEGORY . " sql5 on sql4.parent_uid=sql5.uid
	    left join " . T_CATEGORY . " sql6 on sql5.parent_uid=sql6.uid
	    left join " . T_CATEGORY . " sql7 on sql6.parent_uid=sql7.uid
	    left join " . T_CATEGORY . " sql8 on sql7.parent_uid=sql8.uid
	    left join " . T_CATEGORY . " sql9 on sql8.parent_uid=sql9.uid
	    left join " . T_CATEGORY . " sql10 on sql9.parent_uid=sql10.uid
	    left join " . T_CATEGORY . " sql11 on sql10.parent_uid=sql11.uid
	    LEFT JOIN " . T_FOTO . " AS t4 ON t1.uid_foto = t4.uid
	    LEFT JOIN " . T_FOTO . " AS logo ON t1.uid_logo = logo.uid
		 WHERE " . $where;
		//print $productQuery;
		$data = $this->get_row($productQuery);
		$catalog_id = $data->uid;

		return $data;
	}

*/

	public function getListArgs(IListArgs $args = null)
	{
		$args = parent::getListArgs($args);

		if(isset($args->lang) && !empty($args->lang))
		{
			$this->addWhere("l.code='" . $args->lang . "'");
		}

		if (isset($args->child) && isInt($args->child))
		{
			$this->addWhere("concat(vc.serial_cat_id,'|') like '%|" . $args->child . "|%'");
		}
		$this->setOrderBy($args->getOrderBy(), 'v.title ASC');

		$this->addWhere(" p.isDeleted=" . $args->isDeleted);

		if (isset($args->id) && isInt($args->id)) {
			$this->addWhere(" p.id=" . $args->id);
		}

		if (isset($args->id) && is_array($args->id) && count($args->id)>0 ) {
			$this->addWhere(" p.id in (" . implode(",",$args->id) . ") ");
		}


		if (isset($args->ignore_id) && isInt($args->ignore_id)) {
			$this->addWhere("p.id <> " . $args->ignore_id);
		}


		if (isset($args->tree) && isInt($args->tree) && $args->tree > 0) {
			$this->addWhere(" p.category_id=" . $args->tree);
		}

		if (isset($args->cat) && isInt($args->cat) && $args->cat > 0) {
			$this->addWhere(" p.category_id=" . $args->cat . " ");
		}

		// seznam kategorií
		if (isset($args->cat) && is_array($args->cat) && count($args->cat) > 0) {
			$this->addWhere(" p.category_id in (" . implode(",",$args->cat) . ") ");
		}

		if (isset($args->user_add) && isInt($args->user_add) && $args->user_add > 0) {
			$this->addWhere(" v.user_id=" . $args->user_add);
		}
		if (isset($args->not_cat) && isInt($args->not_cat) && $args->not_cat > 0) {
			$this->addWhere(" p.category_id <> " . $args->not_cat);
		}
		if (isset($args->fulltext) && !empty($args->fulltext)) {
			$this->addWhere(" v.title like '%" . $args->fulltext . "%' ");
		}


		if (isset($args->status) && isInt($args->status)) {
			$this->addWhere(" p.status_id=" . $args->status);
		}

		if (isset($args->status) && is_array($args->status)&& count($args->status) > 0) {
			$this->addWhere("p.status_id in (" . implode(",",$args->status) . ")");
		}

		if (isset($args->search) && !empty($args->search)) {
			$this->addWhere(" v.title like '%" . $args->search . "%' ");
		}


		if(isset($args->page_id) && isInt($args->page_id))
		{
			$this->addWhere("v.page_id=" . $args->page_id);
		}


		if (isset($args->cat) && is_array($args->cat)) {
			$this->addWhere("p.category_id in (" . implode(",",$args->cat) . ")");
		}


		if(isset($args->user) && isInt($args->user))
		{
			$this->addWhere("v.user_id=" . $args->user);
		}

		if(isset($args->vlastnik_id) && isInt($args->vlastnik_id))
		{
			$this->addWhere("p.vlastnik_id=" . $args->vlastnik_id);
		}

		return $args;


	}

	public function getList(IListArgs $args = null)
	{

		$params = $this->getListArgs($params);

		$language1 = " and cv.lang_id=v.lang_id";


		// moznost vytažení konkrétní verze stránky
		if(isset($params->version) && isInt($params->version))
		{
			$this->addWhere("v.version=" . $params->version);
			$version = "and v.version=" . $params->version;
		} else {
			$version = "and v.version=p.version";
			$version1 = "and cv.version=c.version";
		}


		$this->setSelect("p.*,p.TimeStamp as PageTimeStamp,p.ChangeTimeStamp as PageChangeTimeStamp,v.*,
		ua.nick as autor,ue.nick as editor,
		l.code,cv.title as nazev_category,
		t4.file,t4.description as popis_foto,
    		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url,p.foto_id

		");

		$CategoryVersionEntity = new CatalogFiremVersionEntity();

		$this->setFrom($CategoryVersionEntity->getTableName() . " v
		left join " . $this->getTableName() . " p on v.page_id = p.id " . $version . "
		left join " . T_USERS . " ue on v.user_id=ue.id
		left join " . T_USERS . " ua on p.user_id=ua.id
		left join " . T_LANGUAGE . " l on v.lang_id=l.id
		LEFT JOIN " . T_CATEGORY . " c ON (v.category_id = c.id)
		left join " . T_CATEGORY_VERSION . " cv on c.id = cv.page_id " . $version1 . $language1 . "

	   	left join view_category vc on vc.category_id=v.category_id and vc.lang_id=l.id

		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id
");


	//	$this->setFrom($this->getTableName() . " AS t1");

		//$list = $this->getRows();

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
	//	print $this->getWhere();
	//	print $this->getOrderBy();

	//	print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
	//	print $this->getLastQuery();

		for ($i=0;$i < count($list);$i++)
		{
		//	$list[$i]->link = URL_HOME2 . 'podnik2?id=' . $list[$i]->id;


			$list[$i]->link = URL_HOME2 . "podnik/" . $list[$i]->page_id . "-" . strToUrl($list[$i]->title) . ".html";

			$list[$i]->link_edit =  "edit_catalog?id=" . $list[$i]->page_id;
		}

		//print_r($list);
		return $list;

		//return $list;

	}

}
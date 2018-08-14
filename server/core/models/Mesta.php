<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Mesta extends G_Service{

	function __construct()
	{
		parent::__construct(T_MESTA);
	}

	public $total = 0;

	public function getList($params=array())
	{

		$znak = "cs";

		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['bezsouradnic']) && is_numeric($params['bezsouradnic']) && $params['bezsouradnic']== 1) {
			$this->addWhere("t1.lat is null or t1.lng is null");
		}
		if (isset($params['kraj']) && is_numeric($params['kraj']) && $params['kraj']>0) {
			$this->addWhere("t1.okres=" . $params['kraj']);
		}
		if (isset($params['fulltext']) && !empty($params['fulltext'])) {
			$this->addWhere("t1.mesto like '" . $params['fulltext'] . "%'");
		}
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'],'t1.okres ASC,t1.id ASC');

		//print $this->getOrderBy();
		$this->setSelect("t1.*");
		//	$this->setFrom($this->getTableName() . " AS t1 LEFT JOIN mm_kraje t2 on t1.okres=t2.uid");
		$this->setFrom($this->getTableName() . " AS t1");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_categoryFromCitylist($params=array())
	{

		$znak = "cs";
		$znak = "cs";
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}

		$language1 = "";
		$language2 = "";


		$language1 = " and cv.lang_id=v.lang_id";
		$language2 = " and cv2.lang_id=v.lang_id";

	/*	*/

		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['city']) && is_numeric($params['city']) && $params['city']>0) {
			$this->addWhere("cg.mesto_id=" . $params['city']);
		}
		$this->addWhere("cg.category_id > 0");

		$this->setLimit($page, $limit);
		$order = isset($params['order']) ? $params['order'] : "";
		$this->setOrderBy($order,'cv2.title');
		$this->setGroupBy('cg.category_id');
		//print $this->getOrderBy();
		//	$this->setSelect("m.*");

		// moznost vytažení konkrétní verze stránky
		if(isset($params['version']) && is_int($params['version']))
		{
			$this->addWhere("v.version=" . $params['version']);
			$version = "and v.version=" . $params['version'];
			$version2 = "and cv2.version=" . $params['version'];

		} else {
			$version = "and v.version=cg.version";
			$version2 = "and cv2.version=c2.version";
		}


		$this->setSelect("cv2.*,
    		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url
			");

		//	$this->setFrom("`mm_catalog` c LEFT JOIN " . T_CATEGORY . " m on c.CATEGORY=m.uid");
		$CategoryVersionEntity = new CatalogFiremVersionEntity();

		$this->setFrom($CategoryVersionEntity->getTableName() . " v
		left join `" . T_CATALOG_FIREM . "` cg on v.page_id = cg.id " . $version . "
	   	left join " . T_CATEGORY . " c2 on cg.category_id=c2.id
		left join " . T_LANGUAGE . " l on v.lang_id=l.id
		left join " . T_CATEGORY_VERSION . " cv2 on c2.id = cv2.page_id " . $version2 . $language2 . "
	   	left join view_category vc on vc.category_id=cg.category_id
");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_categoryFromKrajlist($params=array())
	{

		$znak = "cs";
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}

		$language1 = " and cv.lang_id=v.lang_id";
		$language2 = " and cv2.lang_id=v.lang_id";


		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['kr']) && is_numeric($params['kr']) && $params['kr']>0) {
			$this->addWhere("k.okres=" . $params['kr']);
		}
		$this->addWhere("k.okres is not null");
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'],'cv2.title');
		$this->setGroupBy('cg.category_id');
		//print $this->getOrderBy();

		// moznost vytažení konkrétní verze stránky
		if(isset($params['version']) && is_int($params['version']))
		{
			$this->addWhere("v.version=" . $params['version']);
			$version = "and v.version=" . $params['version'];
			$version2 = "and cv2.version=" . $params['version'];

		} else {
			$version = "and v.version=cg.version";
			$version2 = "and cv2.version=c2.version";
		}

		//	$this->setSelect("m.*");
		/*			*/
		$this->setSelect("cv2.*,
    		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url
			");

		/*
		   $this->setFrom("`mm_catalog` c LEFT JOIN " . T_MESTA . " k on k.uid=c.mesto
		   LEFT JOIN " . T_CATEGORY . " m on c.CATEGORY=m.uid");
		*/
		$CategoryVersionEntity = new CatalogFiremVersionEntity();

		$this->setFrom($CategoryVersionEntity->getTableName() . " v
		left join `" . T_CATALOG_FIREM . "` cg on v.page_id = cg.id " . $version . "
		LEFT JOIN " . T_MESTA . " k on k.id=cg.mesto_id
	   	left join " . T_CATEGORY . " c2 on cg.category_id=c2.id
		left join " . T_CATEGORY_VERSION . " cv2 on c2.id = cv2.page_id " . $version2 . $language2 . "
	   	left join view_category vc on vc.category_id=cg.category_id

");



		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_mestaCaloglist($params=array())
	{

		$znak = "cs";

		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['kraj']) && is_numeric($params['kraj']) && $params['kraj']>0) {
			$this->addWhere("m.okres=" . $params['kraj']);
		}
		$this->addWhere("m.okres is not null");

		$this->setLimit($page, $limit);
		$order = isset($params['order']) ? $params['order'] : "";
		$this->setOrderBy($order,'c.mesto_id');
		$this->setGroupBy('c.mesto_id');
		//print $this->getOrderBy();
		$this->setSelect("m.*,o.name");
		$this->setFrom(" `" . T_CATALOG_FIREM . "` c LEFT JOIN " . $this->getTableName() . " m on c.mesto_id=m.id LEFT JOIN " . T_KRAJE . " o on m.okres=o.id");



		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_krajeList($params=array())
	{

		$znak = "cs";

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>''");
		//	print "limit:" . $limit;
		$this->setLimit($page, $limit);
		$this->setOrderBy('t1.name ASC,t1.order ASC');

		$this->setSelect("t1.*");
		$this->setFrom(T_KRAJE . " t1");

		$list = $this->getRows();
		$this->total = count($list);
		return $list;

	}

}
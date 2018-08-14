<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("Pages.php");

abstract class models_ACategory extends models_Pages{

	public $entityName;
	function __construct($TEntity)
	{
		parent::__construct($TEntity);
    
    
        		$name = str_replace(DB_PREFIX,"" ,$TEntity);
        
        switch ($name) {
      	case "post":
      		$model = new models_Publish();
      		break;
      	case  "category":
      		$this->entityName = "Category";
      		break;
      	case  "syscategory":
      		$this->entityName = "SysCategory";
      		break;
      	default:
      		$this->entityName = $name;
      
      } 
 //   print $name;

    
	//	PRINT "[" . $this->getTableName() . "]";
	}

	public function getPublishByUrl($url,$lang=LANG_TRANSLATOR)
	{
		$params = new ListArgs();
		$params->url = $url;
		$params->lang = $lang;
		$params->page = 1;
		$params->limit = 1;

		$list = $this->getList($params);

		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}

	// TODO Tady je chyba pouští se 2x getList()
	public function getDetailByUrl($url,$lang=LANG_TRANSLATOR)
	{
		$params = new ListArgs();
		$params->url = $url;
		$params->lang = $lang;
		$params->page = 1;
		$params->limit = 1;

		$list = $this->getList($params);
		if (count($list) == 1) {
    
      	$obj = $this->getPage($list);
        		$obj->uroven = urovenCategory($obj->serial_cat_id);
      return  $obj;    
		//	return $this->getDetailById($list[0]->page_id);
		}
		return false;
	}



	public function getDetailById($id,$lang=LANG_TRANSLATOR)
	{
		$params = new ListArgs();
		$params->page_id = (int) $id;
	//	$params['lang'] = $lang;
		$params->page = 1;
		$params->limit = 1000;


		$list = $this->getList($params);
      //      print_R($list);
		$obj = $this->getPage($list);


		$obj->uroven = urovenCategory($obj->serial_cat_id);
	/*	if (!defined('ADMIN')) {


			if ($obj->pristup == 0) {

				if (LOGIN_STATUS == "ON") {


					$params = array();
					$params["user_id"] = (int) USER_ID;
					$params["page_id"] = (int) $obj->page_id;
					$params["page_type"] = $this->getTableName();
					$model = new models_AccessUsers();
					$userAccess =  $model->getAssociationList($params);

					if (!isset($userAccess) || $userAccess[0]->selected == 0 ) {
						return false;
					}

				} else {
					return false;
				}

			}
		}*/
	//	print_r($obj);
		//print_r($list);
if (count($list) > 0) {
		/*
			for($i=0;$i<count($list);$i++)
			{
				if ($list[$i]->code == LANG_TRANSLATOR)
				{

					$link = "link";

					if (!defined("ADMIN")) {
						$obj->$link = URL_HOME . get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);
					} ELSE {
						$obj->$link = "/" . get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);
					}
				}

				$lang = $list[$i]->code . "/";
			//	$link = "link_" . $list[$i]->code;
			//	$obj->$link = URL_HOME2 . $lang . get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);



				if (!defined("ADMIN")) {

					$link = "link_" . $list[$i]->code;
					$obj->$link = URL_HOME2 . $lang . get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);
				} else {
				//	$list[$i]->$link = "/" . $lang . $categoryUrl . (!empty($categoryUrl) ? "/" : "") . $url . $url_konec;
				//	$list[$i]->link = "/" . $categoryUrl . (!empty($categoryUrl) ? "/" : "") . $url . $url_konec;


					$link = "link_" . $list[$i]->code;
					$obj->$link = "/" . $lang . get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);

				}


			}*/
			return $obj;
		}
		//print_r($obj);


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}

	public function getList(IListArgs $params=null)
	{
$this->clearWhere();
		$params = $this->getListArgs($params);

		$language1 = "";
		$language2 = "";
		$language3 = "";
		$language4 = "";
		$language5 = "";
		$language6 = "";
		$language7 = "";
		$language8 = "";
		$language9 = "";
		$language10 = "";
		$language11 = "";
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}

		$language1 = " and cv.lang_id=v.lang_id";
		$language2 = " and cv2.lang_id=v.lang_id";
		$language3 = " and cv3.lang_id=v.lang_id";
		$language4 = " and cv4.lang_id=v.lang_id";
		$language5 = " and cv5.lang_id=v.lang_id";
		$language6 = " and cv6.lang_id=v.lang_id";
		$language7 = " and cv7.lang_id=v.lang_id";
		$language8 = " and cv8.lang_id=v.lang_id";
		$language9 = " and cv9.lang_id=v.lang_id";
		$language10 = " and cv10.lang_id=v.lang_id";
		$language11 = " and cv11.lang_id=v.lang_id";

		if(isset($params->tags) && !empty($params->tags))
		{
			$this->addWhere("v.tags like '%" . $params->tags . "%'");
		}

		if(isset($params->not_tags) && !empty($params->not_tags))
		{
			$this->addWhere("v.tags not like '%" . $params->not_tags . "%'");
		}

		if(isset($params->now))
		{
			$this->addWhere("p.PublicDate <= now()");
		}

		if(isset($params->tags) && !empty($params->tags))
		{
			$this->addWhere("v.tags like '%" . $params->tags . "%'");
		}
    
    if(isset($params->like_title) && !empty($params->like_title))
		{
			$this->addWhere("v.title like '%" . $params->like_title . "%'");
		}
    
		$this->addWhere("p.isDeleted =0");
		if(isset($params->cat) && isInt($params->cat) && $params->cat > 0)
		{
			$this->addWhere("p.category_id=".$params->cat);
		}

		if (isset($params->title) && !empty($params->title))
		{
			$this->addWhere("LCASE(v.title) like '" . trim(strToLower($params->title))."%'");
		}

		if (isset($params->fulltext) && !empty($params->fulltext))
		{
			$this->addWhere("(LCASE(v.title) like '%" . trim(strToLower($params->fulltext))."%'
                       OR LCASE(v.description) like '%" . trim(strToLower($params->fulltext))."%'
                       OR LCASE(cv.title) like '%" . trim(strToLower($params->fulltext))."%')");
		}

		if (isset($params->id_cat) && isInt($params->id_cat))
		{
			$this->addWhere("concat(vc.serial_cat_id,'|') like '%|" . $params->id_cat . "|%'");
		}

		if(isset($params->page_id) && isInt($params->page_id))
		{
			$this->addWhere("v.page_id=" . $params->page_id);

			$this->addWhere("v.page_id = p.id and v.version=p.version");
		}

		if(isset($params->page_id) && is_array($params->page_id) && count($params->page_id) > 0)
		{
			
      $vyrobceA = array();
			foreach ($params->page_id as $key =>$val) {
      
        if(!empty($val))
        {
            array_push($vyrobceA,$val);
        }
				
			}
      if (count($vyrobceA) > 0){
      
      $this->addWhere("v.page_id in (" . implode(",",$vyrobceA ).")");

			$this->addWhere("v.page_id = p.id and v.version=p.version");      
      }

		}


		if(isset($params->not_page_id) && is_array($params->not_page_id) && count($params->not_page_id) > 0)
		{
			$this->addWhere("v.page_id not in (" . implode(",",$params->not_page_id ).")");

			$this->addWhere("v.page_id = p.id and v.version=p.version");
		}


		if(isset($params->user) && isInt($params->user))
		{
			$this->addWhere("v.user_id=" . $params->user);
		}

		if(isset($params->url) && !empty($params->url))
		{
			$this->addWhere("v.url='" . $this->escape($params->url) . "'");
		}


		// moznost vytažení konkrétní verze stránky
		if(isset($params->version) && isInt($params->version))
		{
			$this->addWhere("v.version=" . $params->version);
			$version = "and v.version=" . $params->version;
			$version1 = "and cv.version=" . $params->version;
		} else {

			$version = "and v.version=p.version";
			$version1 = "and cv.version=c.version";
		}

		$this->setOrderBy($params->getOrderBy(), 'p.level ASC,p.TimeStamp DESC');

if (isset($params->lite)) {


	$this->setSelect("p.*,p.TimeStamp as PageTimeStamp,
p.ChangeTimeStamp as PageChangeTimeStamp,
v.title,v.page_id,v.lang_id,v.id,v.url,
	l.code,cv.title as nazev_category,
	ua.nick as autor,ue.nick as editor,
	t4.file,t4.description as popis_foto,t4.dir,
	vc.serial_cat_id,
	vc.serial_cat_title,
	vc.serial_cat_url
");
} else {
	$this->setSelect("p.*,p.TimeStamp as PageTimeStamp,p.ChangeTimeStamp as PageChangeTimeStamp,v.*,
	l.code,cv.title as nazev_category,
		ua.nick as autor,ue.nick as editor,
		t4.file,t4.description as popis_foto,t4.dir,
		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url
");
}

		$name = str_replace(DB_PREFIX,"" ,$this->getTableName());
  //  print $name;
		$nameVersionEntity = ($this->entityName) . "VersionEntity";
	//	$nameVersionEntity = ucfirst($name) . "VersionEntity";

		$CategoryVersionEntity = new $nameVersionEntity;

		$this->setFrom($CategoryVersionEntity->getTableName() . " v
		   left join " . $this->getTableName() . " p on v.page_id = p.id " . $version . "
		   left join " . T_LANGUAGE . " l on v.lang_id=l.id
		   left join " . T_USERS . " ue on v.user_id=ue.id
			left join " . T_USERS . " ua on p.user_id=ua.id
			LEFT JOIN " . $this->getTableName() . " c ON (v.category_id = c.id)
			left join " . $CategoryVersionEntity->getTableName() . " cv on c.id = cv.page_id " . $version1 . $language1 . "
		   	left join view_" . $name . " vc on vc.category_id=p.id and vc.lang_id=l.id
			LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id
		   ");

		if(isset($params->lite))
		{
			//$this->addWhere("v.page_id=" . $params['page_id']);
			$total = 1;
		} else {
			$query = "select count(*) from "
				. $this->getFrom() . " "
				. $this->getWhere() . " "
				. $this->getGroupBy();
			$total = $this->get_var($query);
		}



		$this->total = $total;


		$list = array();
		if ($total > 0) {
			$stopky = new GStopky();
		//	$stopky->start();
			$list = $this->getRows();
		//	print $stopky->konec();
		}


//print $this->getLastQuery();
		if ($_SERVER["REMOTE_ADDR"] == "90.177.76.16") {
			//	print $this->getLastQuery();
		}
		//	print $this->getLastQuery();
		//print_r($list);
		return $list;
	}

	public function getMinLevelCategory($category_id)
	{
		$query = "select min(level) from "
		. $this->getTableName(). " where category_id=" . $category_id;
	//	print $query;
		return $this->get_var($query);
	}

	public function convertCategoryToPages()
	{

		$this->start_transakce();
		$query = "select * from " . $this->getTableName() . "_back order by uid ASC ";
		print $query;
		print "tudy";
		// where uid=12
		$clanky = $this->get_results($query);

		$this->deleteRecords($this->getTableName() . "_version");

		//$query = "delete from " . $this->_name . "";
		$this->deleteRecords($this->getTableName());

		$all_query_ok = true;

		for ($i = 0; $i < count($clanky);$i++)
		{

			print $i;
			$data = array();
			$version = 0;
			$data["id"] = $clanky[$i]->uid;
			$data["user_id"] = $clanky[$i]->user_edit;
			$data["user_id"] = 3; // admin
			$data["version"] = $version;
			$data["level"] = $clanky[$i]->poradi;
			$data["category_id"] = $clanky[$i]->parent_uid;


			$data["logo_url"] = $clanky[$i]->logo_url;
			//	$data["last_modified_date"] = $clanky[$i]->caszapsani;
			//$data["status"] = ($clanky[$i]->kos == 1) ? 0 : 1;
			//$data["type_id"] = 1;

			if ($this->insertRecords($this->getTableName(),$data)) {
				$this->commit ? null : $all_query_ok = false;
				$page_id = $this->insert_id;
				$versionData = array();
				$versionData["page_id"] = $page_id;
				$versionData["version"] = $version;
				$versionData["user_id"] = 3; // admin
				//	$versionData["caszapsani"] = $clanky[$i]->caszapsani;

				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

			//	print_r($languageList);
				foreach ($languageList as $key => $val)
				{

					print $val->code;
					// Title
					$versionData["page_id"] = $page_id;
					$versionData["version"] = $version;

					// CZ version
					$versionData["lang_id"] = $val->id;

					/*
					   $name = "podtitulek_$val->code";
					   $versionData["perex"] = $clanky[$i]->$name;
					*/
					$name = "nazev_$val->code";
					$versionData["title"] = $clanky[$i]->$name;

					$name = "text_$val->code";
					$versionData["description"] = $clanky[$i]->$name;

					$name = "pagetitle_$val->code";
					$versionData["pagetitle"] = $clanky[$i]->$name;

					$name = "description_$val->code";
					$versionData["pagedescription"] = strip_tags($clanky[$i]->$name);

					$name = "keywords_$val->code";
					$versionData["pagekeywords"] = $clanky[$i]->$name;


					$versionData["category_id"] = $clanky[$i]->parent_uid;




					$name = "url_friendly_$val->code";
					$versionData["url"] = $clanky[$i]->$name;


					if ($clanky[$i]->uid == 1) {
						$versionData["url"] = "root";
					}
					if ($clanky[$i]->uid == 2) {
						$versionData["url"] = "secret";
					}
					$this->insertRecords($this->getTableName() . "_version",$versionData);

					if (!$this->commit) {

						print_r($versionData);
						print $this->getLastQuery() . "<br />";
						exit;
					}

					$this->commit ? null : $all_query_ok = false;

				}
			}
		}
		$this->konec_transakce($all_query_ok);
	}

	public function generateCategoryTree()
	{


		$name = $this->getTableName();
		$name = str_replace(DB_PREFIX,"" ,$name);


		$name = str_replace(DB_PREFIX,"" ,$this->getTableName());
		$nameVersionEntity = $name . "VersionEntity";

		$CategoryVersionEntity = new $nameVersionEntity;

	//	$all_query_ok=true;
	//	$this->start_transakce();
		//TRUNCATE TABLE view_category
		$query="delete from view_" . $name;
		$this->query($query);
		$this->commit ? null : $all_query_ok = false;

		$query="
		insert into view_" . $name . " (title,level,category_id,parent_id,lang_id,serial_cat_id,serial_cat_title,serial_cat_url,icon_class,TimeStamp,ChangeTimeStamp)
		SELECT distinct 
		v.title,
		p.level,
		p.id as category_id,
		case when v.category_id=0 then null else v.category_id end as parent_id,
		v.lang_id,

		concat(
		ifnull(c11.id,''),'|',
		ifnull(c10.id,''),'|',
		ifnull(c9.id,''),'|',
		ifnull(c8.id,''),'|',
		ifnull(c7.id,''),'|',
		ifnull(c6.id,''),'|',
		ifnull(c5.id,''),'|',
		ifnull(c4.id,''),'|',
		ifnull(c3.id,''),'|',
		ifnull(c2.id,''),'|',
		ifnull(p.id,'')
		) as serial_cat_id,
		concat(
		ifnull(cv11.title,''),'|',
		ifnull(cv10.title,''),'|',
		ifnull(cv9.title,''),'|',
		ifnull(cv8.title,''),'|',
		ifnull(cv7.title,''),'|',
		ifnull(cv6.title,''),'|',
		ifnull(cv5.title,''),'|',
		ifnull(cv4.title,''),'|',
		ifnull(cv3.title,''),'|',
		ifnull(cv2.title,''),'|',
		ifnull(v.title,'')
		) as serial_cat_title,
		case when (v.url like 'https://%' or v.url like 'http://%') then v.url else
		concat(
		ifnull(cv11.url,''),'|',
		ifnull(cv10.url,''),'|',
		ifnull(cv9.url,''),'|',
		ifnull(cv8.url,''),'|',
		ifnull(cv7.url,''),'|',
		ifnull(cv6.url,''),'|',
		ifnull(cv5.url,''),'|',
		ifnull(cv4.url,''),'|',
		ifnull(cv3.url,''),'|',
		ifnull(cv2.url,''),'|',
		v.url
		) end as serial_cat_url,
		p.icon_class,
		now(),now()
		FROM " . $CategoryVersionEntity->getTableName() . " v
		left join " . T_LANGUAGE . " l on v.lang_id=l.id
		left join " . $this->getTableName() . " p on v.page_id = p.id and v.version=p.version
		left join " . T_USERS . " ue on v.user_id=ue.id
		left join " . T_USERS . " ua on p.user_id=ua.id
		left join " . $this->getTableName() . " c2 on v.category_id=c2.id
		left join " . $CategoryVersionEntity->getTableName() . " cv2 on c2.id = cv2.page_id and cv2.version=c2.version and cv2.lang_id=v.lang_id
		left join " . $this->getTableName() . " c3 on c2.category_id=c3.id
		left join " . $CategoryVersionEntity->getTableName() . " cv3 on c3.id = cv3.page_id and cv3.version=c3.version and cv3.lang_id=v.lang_id
		left join " . $this->getTableName() . " c4 on c3.category_id=c4.id
		left join " . $CategoryVersionEntity->getTableName() . " cv4 on c4.id = cv4.page_id and cv4.version=c4.version and cv4.lang_id=v.lang_id
		left join " . $this->getTableName() . " c5 on c4.category_id=c5.id
		left join " . $CategoryVersionEntity->getTableName() . " cv5 on c5.id = cv5.page_id and cv5.version=c5.version and cv5.lang_id=v.lang_id
		left join " . $this->getTableName() . " c6 on c5.category_id=c6.id
		left join " . $CategoryVersionEntity->getTableName() . " cv6 on c6.id = cv6.page_id and cv6.version=c6.version and cv6.lang_id=v.lang_id
		left join " . $this->getTableName() . " c7 on c6.category_id=c7.id
		left join " . $CategoryVersionEntity->getTableName() . " cv7 on c7.id = cv7.page_id and cv7.version=c7.version and cv7.lang_id=v.lang_id
		left join " . $this->getTableName() . " c8 on c7.category_id=c8.id
		left join " . $CategoryVersionEntity->getTableName() . " cv8 on c8.id = cv8.page_id and cv8.version=c8.version and cv8.lang_id=v.lang_id
		left join " . $this->getTableName() . " c9 on c8.category_id=c9.id
		left join " . $CategoryVersionEntity->getTableName() . " cv9 on c9.id = cv9.page_id and cv9.version=c9.version and cv9.lang_id=v.lang_id
		left join " . $this->getTableName() . " c10 on c9.category_id=c10.id
		left join " . $CategoryVersionEntity->getTableName() . " cv10 on c10.id = cv10.page_id and cv10.version=c10.version and cv10.lang_id=v.lang_id
		left join " . $this->getTableName() . " c11 on c10.category_id=c11.id
		left join " . $CategoryVersionEntity->getTableName() . " cv11 on c11.id = cv11.page_id and cv11.version=c11.version and cv11.lang_id=v.lang_id
		LEFT JOIN " . $this->getTableName() . " c ON (v.category_id = c.id)
		left join " . $CategoryVersionEntity->getTableName() . " cv on c.id = cv.page_id and cv.version=c2.version and cv.lang_id=v.lang_id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id
		WHERE (p.isDeleted=0)
		ORDER BY p.level DESC,c.category_id ASC LIMIT 0, 1000000";
		$this->query($query);

	//	print $query;
   // exit;
		$this->commit ? null : $all_query_ok = false;
/*
		if ($this->konec_transakce($all_query_ok)) {

		}
		*/
		return true;
		return false;



	}
}
<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("Pages.php");
class models_Publish extends models_Pages{

	function __construct()
	{
		parent::__construct(T_CLANKY);
	}
	public function levelUp($page_id)
	{
		$page = $this->getDetailById($page_id);

		if ($page) {
			$data = array();
			$data["level"] = $page->level+1;

			$this->updateRecords($this->getTableName(),$data ,"id={$page_id}");
		}

	}
	public function levelDown($page_id)
	{
		$page = $this->getDetailById($page_id);

		if ($page) {
			$data = array();
			$data["level"] = $page->level-1;

			$this->updateRecords($this->getTableName(),$data ,"id={$page_id}");
		}
	}

	public function getDetailByUrl($url,$lang=LANG_TRANSLATOR)
	{
		$params = new ListArgs();
		$params->url = $url;
		$params->lang = $lang;
		$params->page = 1;
		$params->limit = 1;
		$params->all_public_date = 1;
		$list = $this->getList($params);
		if (count($list) == 1) {
			return $this->getDetailById($list[0]->page_id);
		}
		return false;

		return $this->getDetail($params);

		$list = $this->getList($params);

		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}

	public function getDetailById($id,$lang=LANG_TRANSLATOR)
	{

		$params = new ListArgs();
		$params->page_id = (int) $id;
		//	$params->lang'] = $lang;
		$params->page = 1;
		$params->all_public_date = 1;
		$params->limit = 1000;

		return $this->getDetail($params);
	}

	public function setMainFoto($catalog_id, $foto_id)
	{
		$data = array();
		$data["foto_id"] = $foto_id;
		if($this->updateRecords(T_CLANKY, $data, "id={$catalog_id}"))
		{
			return true;
		}
	}

	public function getDetailDeletedById($id,$lang=LANG_TRANSLATOR)
	{
		$params = new ListArgs();
		$params->page_id = (int) $id;
		//	$params->lang'] = $lang;
		$params->page = 1;
		$params->deleted = 1;
		$params->limit = 1000;

		return $this->getDetail($params);
	}
	// obecné volání detailu
	protected function getDetail(IListArgs $params)
	{


		$list = $this->getList($params);

		$obj = $this->getPage($list);
	//	print_r($list);
		if (count($list) > 0) {
			$obj->publicDate = $list[0]->PublicDate;
			$obj->publicDate_end = $list[0]->PublicDate_end;
			return $obj;
		}
		return false;
	}


	public function getList(IListArgs $params = null)
	{

		$params = parent::getListArgs($params);

		//print_r($params);
		//exit;
		$this->addWhere("p.isDeleted=" . $params->isDeleted);

		$language1 = "";
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}


		if(isset($params->tags) && !empty($params->tags))
		{
			$this->addWhere("v.tags like '%" . $params->tags . "%'");
		}

		if(isset($params->not_tags) && !empty($params->not_tags))
		{
			$this->addWhere("v.tags not like '%" . $params->not_tags . "%'");
		}

		$language1 = " and cv.lang_id=v.lang_id";



		if(!isset($params->all_public_date))
		{
			// pouze příspěvky s datem publikace menším než aktuální čas
			$this->addWhere("p.PublicDate <= now()");
			$this->addWhere("(p.PublicDate_end >= now() or p.PublicDate_end is null)");
		}


		if(isset($params->public_date_from) && !empty($params->public_date_from))
		{
			//	$this->addWhere("p.PublicDate >= " . $params->public_date_from);

			$this->addWhere("(p.PublicDate >= " . $params->public_date_from . " or (p.PublicDate <= " . $params->public_date_from . " and p.PublicDate_end >= " . $params->public_date_from. " and p.PublicDate_end is not null))");
		}


		if(isset($params->public_date_to) && !empty($params->public_date_to))
		{
			$this->addWhere("p.PublicDate <= " . $params->public_date_to);

			//		$this->addWhere("(p.PublicDate >= " . $params->public_date_from . " and p.PublicDate_end is null)  or (p.PublicDate_end >= " . $params->public_date_from. " and p.PublicDate_end is not null))");

		}

		if(isset($params->cat))
		{
			if (isInt($params->cat) && $params->cat > 0) {
				$this->addWhere("p.category_id=".$params->cat);
			}
			// podpora pro načtení pole
			if (is_array($params->cat) && count($params->cat) > 0) {
				$this->addWhere("p.category_id in (". implode(",", $params->cat) . ")");
			}
		}


		if(isset($params->not_cat))
		{
			if (isInt($params->not_cat) && $params->not_cat > 0) {
				$this->addWhere("p.category_id <> ".$params->not_cat);
			}
			// podpora pro načtení pole
			if (is_array($params->not_cat) && count($params->not_cat) > 0) {
				$this->addWhere("p.category_id not in (". implode(",", $params->not_cat) . ")");
			}
		}

		if (isset($params->id_cat) && isInt($params->id_cat))
		{
			$this->addWhere("concat(vc.serial_cat_id,'|') like '%|" . $params->id_cat . "|%'");
		}

		if (!empty($params->fulltext))
		{

			$this->addWhere("(LCASE(v.title) like '%" . trim(strToLower($params->fulltext))."%'
                       OR LCASE(v.description) like '%" . trim(strToLower($params->fulltext))."%')
						");
		}






		if(isset($params->user) && isInt($params->user) && $params->user > 0)
		{
			$this->addWhere("v.user_id=" . $params->user);
		}

		// moznost vytažení konkrétní verze stránky
		if(isset($params->version) && isInt($params->version))
		{
			$this->addWhere("v.version=" . $params->version);
			$version = "and v.version=" . $params->version;
			$version = "";

		} else {
			$version = "and v.version=p.version";
			$version1 = "and cv.version=c.version";

		}

		$this->setSelect("p.*,p.TimeStamp as PageTimeStamp,
		p.ChangeTimeStamp as PageChangeTimeStamp,

		v.*,l.code,
		cv.title as nazev_category,
		ua.nick as autor,ue.nick as editor,
		t4.file,t4.description as popis_foto,t4.dir,
		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url,v.id
");
		$PostVersionEntity = new PostVersionEntity();

		$this->setFrom($PostVersionEntity->getTableName() . " v
		   left join " . $this->getTableName() . " p on v.page_id = p.id " . $version . "
		   left join mm_language l on v.lang_id=l.id
		   left join " . T_USERS . " ue on v.user_id=ue.id
			left join " . T_USERS . " ua on p.user_id=ua.id
			LEFT JOIN " . T_CATEGORY . " c ON (v.category_id = c.id)
			left join " . T_CATEGORY_VERSION . " cv on c.id = cv.page_id " . $version1 . $language1 . "

			left join view_category vc on vc.category_id=v.category_id and vc.lang_id=l.id
			LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id
		   ");


		$this->setOrderBy($params->getOrderBy(),  'p.level ASC,p.TimeStamp DESC');

		//	print $this->getOrderBy();
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		$this->total = $this->get_var($query);

		$query = "select " . $this->getSelect() . " from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $query;
		$list = $this->getRows();
		//	print $this->getLastQuery();

		$settings = G_Setting::instance();
		for ($i=0;$i < count($list);$i++)
		{

			$list[$i]->link_view = URL_HOME . "post?id=" . $list[$i]->page_id;
			$list[$i]->link_edit = URL_HOME . "post_edit?id=" . $list[$i]->page_id;
			//	$list[$i]->link_edit ="do=PublishEdit&id=" . $list[$i]->page_id;
			$lang = $list[$i]->code . "/";
			$link = "link_" . $list[$i]->code;



			$url = $list[$i]->url;
			if ($settings->get("POST_URL_ID_PREFIX") == "1") {
				$url = $list[$i]->page_id . "-" . $url;
			}
			$url_konec = "";
			if (isUrl($url)) {
				$list[$i]->$link = $url;

				$list[$i]->link = $url;
			} else {

				if ($list[$i]->url != "#") {
					$url_konec = ".html";
				}

				$categoryUrl = get_categorytourl($list[$i]->serial_cat_url);
				if (!defined("ADMIN")) {
					$list[$i]->$link = URL_HOME2 . $lang . $categoryUrl . (!empty($categoryUrl) ? "/" : "") . $url . $url_konec;
					$list[$i]->link = URL_HOME . $categoryUrl . (!empty($categoryUrl) ? "/" : "") . $url . $url_konec;
				} else {
					$list[$i]->$link = "/" . $lang . $categoryUrl . (!empty($categoryUrl) ? "/" : "") . $url . $url_konec;
					$list[$i]->link = "/" . $categoryUrl . (!empty($categoryUrl) ? "/" : "") . $url . $url_konec;
				}
			}

			//$link_item = categoryToUrl($list[$i]->serial_cat_title,"/");
			$list[$i]->category_path = categoryToUrl($list[$i]->serial_cat_title,"/");
			if (!defined("ADMIN")) {
				$list[$i]->description = constToText($list[$i]->description);
			}
		}
		//		print_r($list);
		//exit;
		return $list;
	}
}
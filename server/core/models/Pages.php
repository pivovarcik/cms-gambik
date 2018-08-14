<?php


class NextPrevComposite{

	public $page_id;
	public $title;
	public $link_edit;

}
/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */
define("T_PAGES","mm_pages");
abstract class models_Pages extends G_Service
{
	private $_name = '';
	protected $_primary = 'id';
	public $total = 0;
	public $photos = array();
	public $totalPhotos = 0;

	function __construct($name)
	{
		//print $name;
		parent::__construct($name);
		//PRINT "[" . $this->getTableName() . "]";
		$this->_name = $name;
	}

	public function getDetailById($id)
	{
		$args = new ListArgs();
		$args->id = (int) $id;
		$args->limit = 1;

		//print_r($args);
		//exit;
		return $this->getDetail($args);
	}

	protected function getDetail(IListArgs $args)
	{
		$list = $this->getList($args);

		$obj = $this->getPage($list);

		if (count($list) > 0) {
			return $obj;
		}
		return false;
	}

	protected function getPage($list = array())
	{
  

 // print_r($list);
		$obj = new stdClass();
		$versionList = array();
		if (count($list) > 0) {
			$obj = clone $list[0];
		//	$obj->id = isset($list[0]->page_id) ? $list[0]->page_id : $list[0]->id;
			$obj->version = isset($list[0]->version) ? $list[0]->version : 0;
			$obj->level = isset($list[0]->level) ? $list[0]->level : 0;
			$obj->TimeStamp = $list[0]->TimeStamp;
			$obj->ChangeTimeStamp = $list[0]->ChangeTimeStamp;
			$obj->category_id = isset($list[0]->category_id) ? $list[0]->category_id : null;
			$obj->views = isset($list[0]->views) ? $list[0]->views : 0;
		//	$obj->logo_url = $list[0]->logo_url;
			$obj->user_id = $list[0]->user_id;
			$obj->isDeleted = $list[0]->isDeleted;
		//	$obj->publicDate = $list[0]->PublicDate;
			//	$obj->poradi = $list[0]->poradi;
			//	$obj->link = $list[0]->link;
			$obj->title = isset($list[0]->title) ? $list[0]->title : null;
			$obj->description = $list[0]->description;

			$obj->pagedescription = isset($list[0]->pagedescription) ? $list[0]->pagedescription : null;
			$obj->pagekeywords = isset($list[0]->pagekeywords) ? $list[0]->pagekeywords : null;
			$obj->pagetitle = isset($list[0]->pagetitle) ? $list[0]->pagetitle : null;
			$obj->tags = isset($list[0]->tags) ? $list[0]->tags : null;
			$obj->pristup = isset($list[0]->pristup) ? $list[0]->pristup : null;
			$obj->reference = isset($list[0]->reference) ? $list[0]->reference : null;
			for($i=0;$i<count($list);$i++)
			{
				$versionList[$list[$i]->code] = $list[$i];
				if ($list[$i]->code == LANG_TRANSLATOR)
				{
					$title = "title";
					$obj->$title = $list[$i]->title;

					$perex = "perex";
					$obj->$perex = $list[$i]->perex;

					$description = "description";
					$obj->$description = $list[$i]->description;

					$url = "url";
					$obj->$url = $list[$i]->url;

					$url = "serial_cat_url";
					$obj->$url = $list[$i]->serial_cat_url;

					$url = "serial_cat_title";
					$obj->$url = $list[$i]->serial_cat_title;

					$url = "serial_cat_id";
					$obj->$url = $list[$i]->serial_cat_id;

					$name = "pagetitle";
					$obj->$name = $list[$i]->pagetitle;

					$name = "pagekeywords";
					$obj->$name = $list[$i]->pagekeywords;

					$name = "tags";
					$obj->$name = $list[$i]->tags;

					$pagedescription = "pagedescription";
					$obj->$pagedescription = $list[$i]->pagedescription;

					$name = "link";
					/*if (isset($list[$i]->$name)) {
						$obj->$name = $list[$i]->$name;
					} else {
            $name2 = "url";
            $obj->$name = $obj->$name2;
            
          }    */
          
          if (count($list) > 1){
             $obj->$name = URL_HOME2 .  $list[$i]->code ."/" .  get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);
             

          }  else {
            $obj->$name = URL_HOME2 .  get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);
          }
          
              if (get_class($this) == "models_Publish"){
                
                  if (get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id) !="")
                  {
                    $obj->$name .= "/";
                  } 
                 $obj->$name .=  $list[$i]->url . ".html";
             }
          
          
				}

				$title = "title_" . $list[$i]->code;
				$obj->$title = $list[$i]->title;

				$perex = "perex_" . $list[$i]->code;
				$obj->$perex = isset($list[$i]->perex) ? $list[$i]->perex : null;

				$description = "description_" . $list[$i]->code;
				$obj->$description = $list[$i]->description;

				$url = "url_" . $list[$i]->code;
				$obj->$url = isset($list[$i]->url) ? $list[$i]->url : null;

				$name = "pagetitle_" . $list[$i]->code;
				$obj->$name = $list[$i]->pagetitle;

				$name = "pagekeywords_" . $list[$i]->code;
				$obj->$name = $list[$i]->pagekeywords;

				$pagedescription = "pagedescription_" . $list[$i]->code;
				$obj->$pagedescription = $list[$i]->pagedescription;

				$pagedescription = "tags_" . $list[$i]->code;
				$obj->$pagedescription = $list[$i]->tags;

				$name = "link_" . $list[$i]->code;
				// 27.5.2016 - pokud již entita obsahuje link v daném jazyce, není třeba jej přepisovat!
				if (!isset($list[$i]->$name) ) {
					if (isset($list[$i]->link)) {
						$obj->$name = $list[$i]->link;
					}
					$name2 = "url_" . $list[$i]->code;
					if (isset($obj->$name2)) {
						$obj->$name = $obj->$name2;
					}

					$obj->$name = URL_HOME2 .  $list[$i]->code ."/" .  get_categorytourl($list[$i]->serial_cat_url, $list[$i]->serial_cat_id);


				} else {
					$obj->$name = $list[$i]->$name;
				}


				$name = "serial_cat_url_" . $list[$i]->code;
				$obj->$name = isset($list[$i]->serial_cat_url) ? $list[$i]->serial_cat_url : null;

				$name = "serial_cat_title_" . $list[$i]->code;
				$obj->$name = isset($list[$i]->serial_cat_title) ? $list[$i]->serial_cat_title : null;

			}
		}
		$obj->versionList = $versionList;
		return $obj;
	}



	// společný předek pro převod parametrů do wheru
	public function getListArgs(IListArgs $args = NULL)
	{
		if (is_null($args)) {
			$args = new PageListArgs();
			$this->clearWhere();
		}

		if(isset($args->page_id) && isInt($args->page_id))
		{
			$this->addWhere("v.page_id=" . $args->page_id);
		}

		if(isset($args->not_page_id) && isInt($args->not_page_id))
		{
			$this->addWhere("v.page_id<>" . $args->not_page_id);
		}

		if(isset($args->url) && !empty($args->url))
		{
			//$this->addWhere("v.url='" . $params['url'] . "'");
			$this->addWhere("v.url='" . $this->escape($args->url) . "'");
		}

		//	$this->clearWhere();
		$this->setLimit($args->getPage(), $args->getLimit());

		return $args;
	}

	public function getList(IListArgs $args = NULL)
	{

	}
	/**
	 * Posun nahoru
	 * */
	public function levelUp($page_id)
	{
		$page = $this->getDetailById($page_id);

		if ($page) {
			//print_r($page);
			$data = array();
			//print "level:".$page->level;
			$level = (int) $page->level;
			$level = $level + 1;
			$data["level"] = $level;

			$this->updateRecords($this->getTableName(),$data ,"id={$page_id}");
			return $level;
		}

	}
	/**
	 * Posun dolu
	 * */
	public function levelDown($page_id)
	{
		$page = $this->getDetailById($page_id);

		if ($page) {
			$data = array();
			$data["level"] = $page->level-1;

			$this->updateRecords($this->getTableName(),$data ,"id={$page_id}");
			return $data["level"];
		}
	}

	/**
	 * Obecné nastavení hlavní fotky k page
	 * */
	public function setMainFoto($catalog_id, $foto_id)
	{
		$data = array();
		$data["foto_id"] = $foto_id;

	//	print_r($data);
		if($this->updateRecords($this->getTableName(), $data, "id={$catalog_id}"))
		{
			return true;
		}
	}


	/**
	 * Obecné nastavení hlavního souboru k page
	 * */
	public function setMainFile($catalog_id, $file_id)
	{
		$data = array();
		$data["file_id"] = $file_id;
		if($this->updateRecords($this->getTableName(), $data, "id={$catalog_id}"))
		{
			return true;
		}
	}

	/**
	 * vrátí předchozí a následný záznam
	 * */
	public function getNextPrevById($params = array(),$id)
	{

	//	print_r($params);
		$obj = new stdClass();
		$nextPrev = array();
		$nextPrev["next"]  = new NextPrevComposite();
		$nextPrev["prev"]  = new NextPrevComposite();


		/*if (isset($params['sort']) && !empty($params['sort'])) {
			//	$order = $params['order'];
		} else {
			$params['sort'] = $sort;
		}*/
$args = new ListArgs();
		if (isset($params['order']) && !empty($params['order'])) {
			$args->orderBy = $params['order'] ." " . $params['sort'];
		}

		if (isset($params['pg']) && !empty($params['pg'])) {
			$args->page = $params['pg'];
		}





		$args->lang  = LANG_TRANSLATOR;
		$list = $this->getList($args);

	//	print_R($list);
	//	print $this->getLastQuery();
		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link = URL_HOME2 . 'divka2?id=' . $list[$i]->uid;

			if ((isset($list[$i]->page_id) ? $list[$i]->page_id : $list[$i]->id) == $id) {
				if (isset($list[($i-1)])) {
					$nextPrev["prev"]->page_id = isset($list[($i-1)]->page_id) ? $list[($i-1)]->page_id : $list[($i-1)]->id;
					$nextPrev["prev"]->title = isset($list[($i-1)]->code) ? $list[($i-1)]->code : "";
					$nextPrev["prev"]->link_edit = $list[($i-1)]->link_edit;
					$nextPrev["prev"]->link = $list[($i-1)]->link;
				}
				if (isset($list[($i+1)])) {
					$nextPrev["next"]->page_id = isset($list[($i+1)]->page_id) ? $list[($i+1)]->page_id : $list[($i+1)]->id;
					$nextPrev["next"]->link_edit = $list[($i+1)]->link_edit;
					$nextPrev["next"]->title = isset($list[($i+1)]->code) ? $list[($i+1)]->code : "";
					$nextPrev["next"]->link = $list[($i+1)]->link;
				}

				return $nextPrev;

			}

		}

		return $nextPrev;
	}
	/*
	public function getDetailById($id)
	{
		$params = array();
		$params["id"] = (int) $id;
		return $this->getList($params);
	}
*/
	/*
	 * insert into mm_pages (user_id,version,last_modified_date,type_id,status) select uid_user,0,caszapsani,1, case when kos = 1 then 0 else 1 end from mm_articles
	 *
	   // CZ version
	   insert into mm_versions (version,lang_id,title, description, pagetitle, pagedescription, pagekeywords, page_id, caszapsani, url)  select 0,1 from mm_articles

	   // EN 4

	   // de 3


	   // ru 5

	 */
	// vrací kolekci stránek

	public function createLanguageVersion()
	{

	}

	// Servisní metoda pro převod starých článků na nový model
	public function convertClankyToPages()
	{

		$this->start_transakce();
		$query = "select * from " . $this->getTableName() . "_back order by uid ASC ";
		print $query;
		// where uid=12
		$clanky = $this->get_results($query);




		$this->deleteRecords($this->getTableName() . "_version");

		//$query = "delete from " . $this->_name . "";
		$this->deleteRecords($this->getTableName());
		$all_query_ok = true;
		//print_R($clanky);
		print "Počet záznamů:" . count($clanky). "<br />";
		for ($i = 0; $i < count($clanky);$i++)
		{
			print "" . ($i+1) . ":";
			$data = array();
			$version = 0;
			$data["id"] = $clanky[$i]->uid;
			$data["user_id"] = ($clanky[$i]->uid_user > 0) ? $clanky[$i]->uid_user : $clanky[$i]->user_edit;
			$data["version"] = $version;
			$data["TimeStamp"] = $clanky[$i]->caszapsani;
			$data["ChangeTimeStamp"] = $clanky[$i]->last_edit;
			$data["PublicDate"] = $clanky[$i]->caszobrazeni;
			$data["status_id"] = ($clanky[$i]->koncept == 1) ? 0 : 1;
			$data["isDeleted"] = ($clanky[$i]->kos == 1) ? 1 : 0;
			$data["category_id"] = $clanky[$i]->category;
			$data["logo_url"] = $clanky[$i]->logo_url;
			$data["views"] = $clanky[$i]->views;

			$data["source_url"] = $clanky[$i]->zdroj_url;
			$data["source_id"] = $clanky[$i]->zdroj_uid;

		//	print_r($data);
			if ($this->insertRecords($this->getTableName(),$data)) {
				//	$this->getLastQuery() . "<br />";
				print "(".$clanky[$i]->uid. "/".$this->insert_id. ")" . "<br />";
				//	print "tudy2";
				//$page_id = $this->insert_id;
				$page_id = $clanky[$i]->uid;
				$versionData = array();
				$versionData["page_id"] = $page_id;
				$versionData["version"] = $version;
				$versionData["TimeStamp"] = $clanky[$i]->caszapsani;
				$versionData["ChangeTimeStamp"] = $clanky[$i]->last_edit;
				$versionData["user_id"] = $clanky[$i]->uid_user;
				if ($clanky[$i]->user_edit > 0) {
					$versionData["user_id"] = $clanky[$i]->user_edit;
				}


				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				foreach ($languageList as $key => $val)
				{
					// Title


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


					$versionData["category_id"] = $clanky[$i]->category;




					$name = "url_friendly_$val->code";
					$versionData["url"] = $clanky[$i]->$name;


					if ($clanky[$i]->uid == 1) {
						$versionData["url"] = "root";
					}
					if ($clanky[$i]->uid == 2) {
						$versionData["url"] = "secret";
					}

					$this->insertRecords($this->getTableName() . "_version",$versionData);

					print $this->getLastQuery() . "<br />";
					$this->commit ? null : $all_query_ok = false;

				}

			} else {
				print $this->getLastQuery() . "<br />";
			}
		}
		//$this->konec_transakce($this->all_query_ok);
		$this->konec_transakce($all_query_ok);
	}
	public function getPageVersion($id, $version)
	{
		$params = array();
		$params["id"]  = (int) $id;
		$params['version'] = (int) $version;
		return $this->getPageList($params);
	}
}
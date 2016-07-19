<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

class models_Language extends G_Service
{
	function __construct()
	{
		$language = new LanguageEntity();
		parent::__construct($language->getTableName());
	}

	//protected $this->sql->_name = T_LANGUAGE;


	private $selectLanguage;
	public $lang_url = '';
	public $activeLanguageCodeList = array();
	public $activeLanguageIdList = array();
	public $activeLanguageNameList = array();
	public $languageList = array();


	private function getLangIdFromCode($code)
	{
		foreach ($this->activeLanguageCodeList as $key => $language) {
			if ($code == $language) {
				return $this->activeLanguageIdList[$key];
				break;
			}
		}
		return 0;
	}

	private function getLangNameFromCode($code)
	{
		foreach ($this->activeLanguageCodeList as $key => $language) {
			if ($code == $language) {
				return $this->activeLanguageNameList[$key];
				break;
			}
		}
		return 0;
	}

	// metoda pro zavedení jazykového prostředí
	public function initLanguage()
	{
		$this->languageList = $this->getActiveLanguage();
		$this->activeLanguageCodeList = array();
		$this->activeLanguageIdList = array();
		$this->selectLanguage = new stdClass();
		foreach ($this->languageList as $key => $val)
		{
			$this->activeLanguageCodeList[] = $val->code;
			$this->activeLanguageIdList[] = $val->id;
			$this->activeLanguageNameList[] = $val->name;
			if (isset($_GET["lang"]) && (strtolower($_GET["lang"]) == $val->code))
			{
				$this->selectLanguage = $val;
			}
		}

		$this->lang_url =  "";
		if (isset($_GET["lang"]) && !empty($_GET["lang"]) && in_array(strtolower($_GET["lang"]), $this->activeLanguageCodeList)) {
			//LANG_TRANSLATOR = $_GET["lang"];
			if (!defined("LANG_TRANSLATOR"))
			{
				define('LANG_TRANSLATOR', strtolower($_GET["lang"]));

				define('LANG_TRANSLATOR_ID', $this->getLangIdFromCode(LANG_TRANSLATOR));

				define('LANG_TRANSLATOR_NAME', $this->getLangNameFromCode(LANG_TRANSLATOR));

				$this->lang_url = LANG_TRANSLATOR . "/";
			}
		} else {
			$availableLanguages = array();
			$availableLanguages = $this->activeLanguageCodeList;
			/*	foreach ($this->activeLanguageCodeList as $key => $code) {
			   //	$availableLanguages[$code] = $code;

			   //array_push($availableLanguages, $code);
			   }*/
			//print_r($availableLanguages);
			$autoDetectLanguage = getBrowserLanguage($availableLanguages,$this->activeLanguageCodeList[0]);


			foreach ($this->languageList as $key => $language) {
				if ($autoDetectLanguage == $language->code) {

					$this->selectLanguage = $language;
					break;
				}
			}




			//print $autoDetectLanguage;
			if (!defined("LANG_TRANSLATOR"))
			{
				define('LANG_TRANSLATOR', $autoDetectLanguage);
				define('LANG_TRANSLATOR_ID', $this->getLangIdFromCode($autoDetectLanguage));
				define('LANG_TRANSLATOR_NAME', $this->getLangNameFromCode(LANG_TRANSLATOR));
				//define('LANG_TRANSLATOR', $this->activeLanguageCodeList[0]);
			}
			//$this->selectLanguage = $autoDetectLanguage;
			$this->lang_url = LANG_TRANSLATOR . "/";

			//	print $this->lang_url;
		}

		if (!defined("SERVER_LANG"))
		{
			define('SERVER_LANG', $this->selectLanguage->content_language);
		}

		return $this->lang_url;
	}

	public function getSelectLanguage()
	{
		return $this->selectLanguage;
	}
	public function getLanguage($id)
	{
		$params = new ListArgs();
		$params->id  = (int) $id;
		return $this->getList($params);
	}
	public function getActiveLanguage()
	{
		$params = new ListArgs();
		$params->active  = 1;
		return $this->getList($params);
	}

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
	public function getList(ListArgs $params)
	{
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}
		/*
		   else {
		   $this->addWhere("l.code='" . LANG_TRANSLATOR . "'");
		   }
		*/
		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("l.id=" . $params->id);
		}

		if(isset($params->active) && isInt($params->active))
		{
			$this->addWhere("l.active=" . $params->active);
		}

		if(isset($params->order) && !empty($params->order))
		{
			$this->setOrderBy($params->order);
		} else {
			$this->setOrderBy('l.order ASC');
		}


		$this->setSelect("l.*");

		$this->setFrom($this->getTableName() . " l");

		$query = "select count(*) "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);

		$list = $this->getRows();
		//	print $this->sql->last_query;
		return $list;

	}
}
?>
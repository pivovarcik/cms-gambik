<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */
class models_CategoryPage extends G_Service {

	function __construct()
	{
		parent::__construct(T_CATEGORY_ASSOC);
	}
	public function getList($params=array())
	{
		$this->clearWhere();

		if(isset($params['lang']) && !empty($params['lang']))
		{
			$this->addWhere("l.code='" . $params['lang'] . "'");
			/**/
				/*
			$this->addWhere("cv2.lang_id=l.id");
			$this->addWhere("cv3.lang_id=l.id");
			$this->addWhere("cv4.lang_id=l.id");
			$this->addWhere("cv5.lang_id=l.id");
			$this->addWhere("cv6.lang_id=l.id");
			$this->addWhere("cv7.lang_id=l.id");
			$this->addWhere("cv8.lang_id=l.id");
			$this->addWhere("cv9.lang_id=l.id");
			$this->addWhere("cv10.lang_id=l.id");
			$this->addWhere("cv11.lang_id=l.id");
*/

		}

		$language1 = " and cv2.lang_id=l.id";
		//$language2 = " and cv2.lang_id=l.id";
		$language3 = " and cv3.lang_id=l.id";
		$language4 = " and cv4.lang_id=l.id";
		$language5 = " and cv5.lang_id=l.id";
		$language6 = " and cv6.lang_id=l.id";
		$language7 = " and cv7.lang_id=l.id";
		$language8 = " and cv8.lang_id=l.id";
		$language9 = " and cv9.lang_id=l.id";
		$language10 = " and cv10.lang_id=l.id";
		$language11 = " and cv11.lang_id=l.id";
		//$addWhere();
		//$this->where = "";
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		//print $limit;
		$page = (int) isset($params['page']) ? $params['page'] : 1;

		if(isset($params['page_id']) && is_int($params['page_id']))
		{
			$this->addWhere("ca.page_id=" . $params['page_id']);
		}

		if(isset($params['page_id']) && is_array($params['page_id']) && count($params['page_id'])>0)
		{
			$where = "(";
			foreach ($params['page_id'] as $key => $val){
				$where .= "ca.page_id=" . $val . " or ";
			}
			$where = substr($where,0,strLen($where)-3);
			$where .= ")";
			$this->addWhere($where);
		}
			/*	*/
		if(isset($params['page_type_id']) && is_int($params['page_type_id']))
		{
			$this->addWhere("ca.page_type_id=" . $params['page_type_id']);
		}

		// moznost vytaĹľenĂ­ konkrĂ©tnĂ­ verze strĂˇnky
		if(isset($params['version']) && is_int($params['version']))
		{
			$this->addWhere("v.version=" . $params['version']);
		//	$version = "and v.version=" . $params['version'];
			$version1 = "and cv2.version=" . $params['version'];
			$version2 = "and cv2.version=" . $params['version'];
			$version3 = "and cv3.version=" . $params['version'];
			$version4 = "and cv4.version=" . $params['version'];
			$version5 = "and cv5.version=" . $params['version'];
			$version6 = "and cv6.version=" . $params['version'];
			$version7 = "and cv7.version=" . $params['version'];
			$version8 = "and cv8.version=" . $params['version'];
			$version9 = "and cv9.version=" . $params['version'];
			$version10 = "and cv10.version=" . $params['version'];
			$version11 = "and cv11.version=" . $params['version'];

		} else {
			/*
			   $this->addWhere("v.version=p.version");
			   $this->addWhere("cv.version is not null");
			   $this->addWhere("cv11.version is not null");
			*/

			$version1 = "and cv2.version=c2.version";
			//$version2 = "and cv2.version=c2.version";
			$version3 = "and cv3.version=c3.version";
			$version4 = "and cv4.version=c4.version";
			$version5 = "and cv5.version=c5.version";
			$version6 = "and cv6.version=c6.version";
			$version7 = "and cv7.version=c7.version";
			$version8 = "and cv8.version=c8.version";
			$version9 = "and cv9.version=c9.version";
			$version10 = "and cv10.version=c10.version";
			$version11 = "and cv11.version=c11.version";
		}

		$this->setSelect("l.code,ca.*,cv2.title,cv2.url,
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
			    ifnull(c2.id,''),'|'
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
			    ifnull(cv2.title,'')
			    ) as serial_cat_title,
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
			    ifnull(cv2.url,'')
		    ) as serial_cat_url
		");
		$this->setFrom(T_CATEGORY_ASSOC . " ca
		LEFT JOIN " . T_CATEGORY . " c2 ON (ca.category_id = c2.id)
		left join " . T_CATEGORY_VERSION . " cv2 on c2.id = cv2.page_id " . $version1 ."
		left join " . T_LANGUAGE . " l on cv2.lang_id=l.id
		left join " . T_CATEGORY . " c3 on c2.category_id=c3.id
		left join " . T_CATEGORY_VERSION . " cv3 on c3.id = cv3.page_id " . $version3 . $language3."
		left join " . T_CATEGORY . " c4 on c3.category_id=c4.id
		left join " . T_CATEGORY_VERSION . " cv4 on c4.id = cv4.page_id " . $version4 . $language4."
		left join " . T_CATEGORY . " c5 on c4.category_id=c5.id
		left join " . T_CATEGORY_VERSION . " cv5 on c5.id = cv5.page_id " . $version5 . $language5."
		left join " . T_CATEGORY . " c6 on c5.category_id=c6.id
		left join " . T_CATEGORY_VERSION . " cv6 on c6.id = cv6.page_id " . $version6 . $language6."
		left join " . T_CATEGORY . " c7 on c6.category_id=c7.id
		left join " . T_CATEGORY_VERSION . " cv7 on c7.id = cv7.page_id " . $version7 . $language7."
		left join " . T_CATEGORY . " c8 on c7.category_id=c8.id
		left join " . T_CATEGORY_VERSION . " cv8 on c8.id = cv8.page_id " . $version8 . $language8."
		left join " . T_CATEGORY . " c9 on c8.category_id=c9.id
		left join " . T_CATEGORY_VERSION . " cv9 on c9.id = cv9.page_id " . $version9 . $language9."
		left join " . T_CATEGORY . " c10 on c9.category_id=c10.id
		left join " . T_CATEGORY_VERSION . " cv10 on c10.id = cv10.page_id " . $version10 . $language10."
		left join " . T_CATEGORY . " c11 on c10.category_id=c11.id
		left join " . T_CATEGORY_VERSION . " cv11 on c11.id = cv11.page_id " . $version11 . $language11);
/*
		$query = "select * from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
	print 	$query;
		*/
		$list = $this->getRows();
	//	print $this->getLastQuery();
		return $list;
	}


	public function get_association_list($params=array())
	{
		$this->clearWhere();

		if(isset($params['lang']) && !empty($params['lang']))
		{
			$this->addWhere("l.code='" . $params['lang'] . "'");

		}

		$this->addWhere("cv2.lang_id=l.id");
		/*		$this->addWhere("cv3.lang_id=l.id");
		   $this->addWhere("cv4.lang_id=l.id");
		   $this->addWhere("cv5.lang_id=l.id");
		   $this->addWhere("cv6.lang_id=l.id");
		   $this->addWhere("cv7.lang_id=l.id");
		   $this->addWhere("cv8.lang_id=l.id");
		   $this->addWhere("cv9.lang_id=l.id");
		   $this->addWhere("cv10.lang_id=l.id");
		   $this->addWhere("cv11.lang_id=l.id");
		*/
		$language1 = " and cv2.lang_id=l.id";
		//$language2 = " and cv2.lang_id=l.id";
		$language3 = " and cv3.lang_id=l.id";
		$language4 = " and cv4.lang_id=l.id";
		$language5 = " and cv5.lang_id=l.id";
		$language6 = " and cv6.lang_id=l.id";
		$language7 = " and cv7.lang_id=l.id";
		$language8 = " and cv8.lang_id=l.id";
		$language9 = " and cv9.lang_id=l.id";
		$language10 = " and cv10.lang_id=l.id";
		$language11 = " and cv11.lang_id=l.id";
		//$addWhere();
		//$this->where = "";
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		//print $limit;

		$page = (int) isset($params['page']) ? $params['page'] : 1;

		$pageId ="";
		if(isset($params['page_id']) && is_int($params['page_id']))
		{
			//$this->addWhere("ca.page_id=" . $params['page_id']);
			$pageId = " and ca.page_id=" . $params['page_id'];
		}
		$pageType = "";
		if(isset($params['page_type_id']) && is_int($params['page_type_id']))
		{
			//$this->addWhere("ca.page_type_id=" . $params['page_type_id']);
			$pageType = " and ca.page_type_id=" . $params['page_type_id'];
		}
		if(isset($params['category_parent_id']) && is_int($params['category_parent_id']))
		{
			$this->addWhere("c2.category_id=" . $params['category_parent_id']);
			//$pageType = " and ca.page_type_id=" . $params['page_type_id'];
		}

		if(isset($params['category_id']) && is_int($params['category_id']))
		{
			//$this->addWhere("ca.page_type_id=" . $params['page_type_id']);
			$this->addWhere(" ca.category_id=" . $params['category_id']);
		}

		// moznost vytaĹľenĂ­ konkrĂ©tnĂ­ verze strĂˇnky
		if(isset($params['version']) && is_int($params['version']))
		{
			$this->addWhere("v.version=" . $params['version']);
			//	$version = "and v.version=" . $params['version'];
			$version1 = " and cv2.version=" . $params['version'];

		} else {


			$version1 = " and cv2.version=c2.version";

		}

		$this->setSelect("l.code,ca.*,cv2.page_id,cv2.title,cv2.url,case when ca.category_id is not null then 1 else 0 end selected
		");
		$this->setFrom(T_CATEGORY . " c2
		left join " . T_CATEGORY_VERSION . " cv2 on c2.id = cv2.page_id " . $version1 . "
		left join " . T_LANGUAGE . " l on cv2.lang_id=l.id
		left join " .T_CATEGORY_ASSOC . " ca ON (ca.category_id = c2.id)".$pageType.$pageId);

		$list = $this->getRows();

		//	print $this->getLastQuery();
		return $list;
	}
}
?>
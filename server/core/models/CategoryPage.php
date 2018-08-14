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


		}

		$language1 = " and cv2.lang_id=l.id";

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

		} else {


			$version1 = "and cv2.version=c2.version";

		}

		$this->setSelect("l.code,ca.*,
			    vc.serial_cat_id,
			    	vc.serial_cat_title,
 vc.serial_cat_url
		");
		$this->setFrom(T_CATEGORY_ASSOC . " ca
    
    		LEFT JOIN " . T_CATEGORY . " c2 ON (ca.category_id = c2.id)
		left join " . T_CATEGORY_VERSION . " cv2 on c2.id = cv2.page_id " . $version1 ."
		left join " . T_LANGUAGE . " l on cv2.lang_id=l.id
    
left join view_category vc on vc.category_id=cv2.category_id and vc.lang_id=l.id");
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
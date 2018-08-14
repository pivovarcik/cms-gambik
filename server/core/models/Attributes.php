<?php

require_once("ACiselnikModel.php");
class models_Attributes extends ACiselnikModel{

	function __construct()
	{
		parent::__construct("mm_product_attributes");
	}

	public function existAttribName($name){
		$row = $this->get_row("select * from {$this->getTableName()} where name='{$name}' LIMIT 1");
		if ($this->num_rows == 0) {
			return false;
		}
		return true;
	}

  public function getDetailByName($name, $lang=null)
	{
		$params = new ListArgs();
		$params->name = (string) $name;
		//	$params['lang'] = $lang;
		if ($lang != null) {
			$params->lang = $lang;
		} else {
			$params->lang = "";
		}


		$params->page = 1;
		$params->limit = 1;

		//print_r($params);
		return $this->getDetail($params);
	}
  
  public function getDetailById($id,$lang=null)
	{
		$params = new ListArgs();
		$params->page_id = (int) $id;
		//	$params['lang'] = $lang;
		if ($lang != null) {
			$params->lang = $lang;
		} else {
			$params->lang = "";
		}


		$params->page = 1;
		$params->limit = 1000;

		//print_r($params);
		return $this->getDetail($params);
	}
  
  private function getDetail(IListArgs $params)
	{
		$obj = new stdClass();

		$list = $this->getList($params);
		//	print_r($list);
		if (count($list) > 0) {
			$obj->id = $list[0]->id;
			$obj->pohoda_id = $list[0]->pohoda_id;
			$obj->multi_select = $list[0]->multi_select;
			$obj->TimeStamp = $list[0]->TimeStamp;
			$obj->ChangeTimeStamp = $list[0]->ChangeTimeStamp;
			$obj->isDeleted = $list[0]->isDeleted;


		//	$obj->keyword = $list[0]->keyword;

				$title = "name";
				$obj->$title = $list[0]->name;

			//$obj->public_date = $list[0]->public_date;
			//$obj->poradi = $list[0]->poradi;
			for($i=0;$i<count($list);$i++)
			{
				$title = "name_" . $list[$i]->code;
				$obj->$title = $list[$i]->name;


				if ($list[$i]->code == LANG_TRANSLATOR) {

					$obj->name = $list[$i]->name;
				}
        
        
        $title = "description_" . $list[$i]->code;
				$obj->$title = $list[$i]->description;


				if ($list[$i]->code == LANG_TRANSLATOR) {

					$obj->description = $list[$i]->description;
				}


			}
			return $obj;
		}


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}
  
  	public function get_attribute_multi_values($product_id, $attribute_id = null)
	{

		if (is_array($product_id)) {
			$key_list = "";
			foreach ($product_id as $key => $val) {
				$key_list .= $val . ",";
			}

			if (!empty($key_list)) {
				$key_list = substr($key_list,0,-1);
			}

			$where = "ava.product_id in (" . $key_list . ")";
		} else {
			$where = "ava.product_id =" . $product_id . "";
		}
		//	$this->addWhere("t1.attribute_id=" . $id);
    $this->addWhere("a.isDeleted = 0");
    $this->addWhere("a.multi_select = 1");
	//	$this->addWhere("ava.product_id is not null");
	//	$this->addWhere("l.code = '" . $lang . "'");
  
  
    if (!is_null($attribute_id))
    {
		  $this->addWhere("a.id = " . $attribute_id . "");
      $this->setOrderBy('av.name ASC', 'av.name ASC');
    } else {
       $this->addWhere("ava.product_id is not null");
       $this->setOrderBy('a.id,av.name ASC', 'av.name ASC');
    }
		//$this->setLimit($params['page'], $params['limit']);
		

		$this->setSelect("a.id,a.multi_select,(ava.order) as `order`,(ava.attribute_id) as attribute_id,
    a.description,(av.id) as value,(av.name) as value_name,
(case when ava.product_id is null then 0 else 1 end) as has_attribute,product_id,a.pohoda_id");
		$this->setFrom("mm_product_attributes a
              
							left join mm_product_attribute_values av on av.attribute_id = a.id
							left join mm_product_attribute_value_association ava on av.id=ava.attribute_id
							and " . $where
		);
//		$this->setGroupBy('a.id,ava.product_id');
		$list = $this->getRows();
//		print $this->getLastQuery();

		/*
		   print "<pre>";
		   print_r($list);
		   print "</pre>";
		*/
		return $list;
	}
  
	public function get_attribute_value_association2($product_id, $lang)
	{

		if (is_array($product_id)) {
			$key_list = "";
			foreach ($product_id as $key => $val) {
				$key_list .= $val . ",";
			}

			if (!empty($key_list)) {
				$key_list = substr($key_list,0,-1);
			}

			$where = "ava.product_id in (" . $key_list . ")";
		} else {
			$where = "ava.product_id =" . $product_id . "";
		}
		//	$this->addWhere("t1.attribute_id=" . $id);
    $this->addWhere("a.isDeleted = 0");
		$this->addWhere("ava.product_id is not null");
		$this->addWhere("l.code = '" . $lang . "'");
		//$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy('ava.order,ava.product_id,a.name ASC', 'ava.order,ava.product_id,a.name ASC');

		$this->setSelect("a.id,a.multi_select,pav.name,max(ava.order) as `order`,max(ava.attribute_id) as attribute_id,a.description,min(av.id) as value,min(av.name) as value_name,
max(case when ava.product_id is null then 0 else 1 end) as has_attribute,product_id,a.pohoda_id");
		$this->setFrom("mm_product_attributes a
              
              left join " . T_SHOP_PRODUCT_ATTRIBUTES_VERSION . " pav on pav.attrib_id = a.id 
              left join " . T_LANGUAGE . " l on pav.lang_id=l.id
							left join mm_product_attribute_values av on av.attribute_id = a.id
							left join mm_product_attribute_value_association ava on av.id=ava.attribute_id
							and " . $where
		);
		$this->setGroupBy('a.id,ava.product_id');
		$list = $this->getRows();
//		print $this->getLastQuery();

		/*
		   print "<pre>";
		   print_r($list);
		   print "</pre>";
		*/
		return $list;
	}

	public function get_attribute_value_association($product_id, $lang)
	{
	//	$this->addWhere("t1.attribute_id=" . $id);
	//	$this->addWhere("ava.product_id is not null");
		//$this->setLimit($params['page'], $params['limit']);
    
    	$this->addWhere("a.isDeleted = 0");
    	$this->addWhere("l.code = '" . $lang . "'");
      
		$this->setOrderBy('a.name ASC', 'a.name ASC');

		$this->setSelect("a.id,pav.name,max(ava.order) as `order`, max(ava.attribute_id) as attribute_id,a.description,min(av.id) as value,
						max(case when ava.product_id is null then 0 else 1 end) as has_attribute");
		$this->setFrom("mm_product_attributes a
    left join " . T_SHOP_PRODUCT_ATTRIBUTES_VERSION . " pav on pav.attrib_id = a.id
    left join " . T_LANGUAGE . " l on pav.lang_id=l.id
						left join mm_product_attribute_values av on av.attribute_id = a.id
						left join mm_product_attribute_value_association ava on av.id=ava.attribute_id and ava.product_id = " . $product_id
		);
		$this->setGroupBy('a.id');
		$list = $this->getRows();
	//	print $this->getlastQuery();

		/*
		print "<pre>";
		print_r($list);
		print "</pre>";
		*/
		return $list;
	}
	// Vrací prvky vybraného atributu
	public function get_attributeValues($id)
	{
		//print "Jedu:";
		$this->clearWhere();

		$this->addWhere("t1.attribute_id=" . $id);

		//$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy('', 't1.name ASC');

		$this->setSelect("t1.*");
		$this->setFrom("mm_product_attribute_values  AS t1");

		$list = $this->getRows();

		return $list;
	}

	// Vrací prvky vybraného atributu
	public function get_attributeValueIdByAttributeNameAndValue($id, $name)
	{
		//print "Jedu:";
		$this->clearWhere();


       // 	$this->addWhere("a.isDeleted = 0");
    	//$this->addWhere("l.code = '" . $lang . "'");
      
		$this->addWhere("t1.attribute_id=" . $id);

		$this->addWhere("t1.name='" . $name . "'");
//		$this->addWhere("pav.name='" . $name . "'");

		$this->setLimit(1, 1);
		//$this->setOrderBy('', 't1.name ASC');

		$this->setSelect("t1.*");
	/*	$this->setFrom($this->getTableName() . " AS t1
        left join " . T_SHOP_PRODUCT_ATTRIBUTES_VERSION . " pav on pav.attrib_id = t1.id
    left join " . T_LANGUAGE . " l on pav.lang_id=l.id
    ");
      */
    
    
		$this->setFrom("mm_product_attribute_values  AS t1");

		$list = $this->getRows();
   // print $this->getLastQuery();
		if (count($list) == 1) {
			return $list[0];
		}
		return false;

	}
	// načte atributy pouze které jsou na použity na produktech
	public function get_attributeValues2($id)
	{
		//print "Jedu:";
		$this->clearWhere();

		/*
				select av.* from mm_product_attribute_value_association ava
				   left join mm_product_attribute_values av on ava.attribute_id=av.ID
				   left join mm_product_attributes a on av.attribute_id=a.ID
				   where a.ID=1 and ava.product_id is not null
		group by av.name
		*/

		$this->addWhere("ava.isDeleted=0");
		$this->addWhere("p.isDeleted=0");
		$this->addWhere("ava.product_id is not null");
		$this->addWhere("a.id=" . $id);

		//$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy('', 'av.name ASC');
		$this->setGroupBy('av.name');
		$this->setSelect("av.*");
		$this->setFrom("mm_product_attribute_value_association ava
left join mm_products p on p.id=ava.product_id
		   left join mm_product_attribute_values av on ava.attribute_id=av.id
		   left join mm_product_attributes a on av.attribute_id=a.id");

		$list = $this->getRows();

		return $list;
	}
	public function insertAttr($name,$desc){
		$data= array();
		$data["name"] = $name;
		$data["description"] = $desc;
		return $this->insertRecords($this->getTableName(),$data);
	}
/*
	public function getList($params=array())
	{

		//$addWhere();
		//$this->where = "";

		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}


		if (isset($params['fulltext']) && !empty($params['fulltext'])) {
			$this->addWhere("MATCH(t1.name, t1.description) AGAINST ('" . $params['fulltext'] . "' IN BOOLEAN MODE) ");
		}

		$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy($params['order'], 't1.name ASC');

		$this->setSelect("t1.*");
		$this->setFrom($this->getTableName() . " AS t1");

		$list = $this->getRows();

		return $list;

	}*/

	public function get_products_from_attribute_values($attribute_values = array()){
		/*
		   select ava.product_id from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where av.name='ANO' and a.ID=7
		   group by ava.product_id
		*/
		//$where = "("
		$where = array();
		foreach ($attribute_values as $key => $value){

			if (!empty($value)) {


				$where[] = "(a.id=" . $key . " and ava.attribute_id=" . $value . ")";
				$this->addWhere("(a.id=" . $key . " and ava.attribute_id=" . $value . ")");
			}
		}

		$where_str = implode("or", $where);

		print $where_str;
		//$this->addWhere($where_str);
	}
	public function get_attribute_value_from_category($category, $attribute)
	{
		/*
		   select av.* from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where a.ID=2 and ava.product_id in (select ava.product_id from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where av.ID=60
		   group by ava.product_id)
		   group by av.name
		   order by av.name asc

		*/
		$this->clearWhere();
		$this->addWhere("a.id=" . $attribute);
		$this->addWhere("s.category_id=" . $category);
		$this->addWhere("s.isDeleted=0");
		$this->addWhere("s.aktivni=1");


		$this->setLimit(1, 1000);
		$this->setOrderBy('av.name asc', 'av.name asc');
		$this->setGroupBy('av.name');
		$this->setSelect("av.*");

		$this->setFrom("mm_product_attribute_value_association ava
			left join mm_product_attribute_values av on ava.attribute_id=av.ID
			left join mm_product_attributes a on av.attribute_id=a.ID
			left join mm_products s on ava.product_id=s.id
			"
		);

		$list = $this->getRows();
		//print $this->getLastQuery();
		return $list;
	}
	public function get_attribute_value_from_parent($parent_attribute_value, $attribute)
	{
		/*
		   select av.* from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where a.ID=2 and ava.product_id in (select ava.product_id from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where av.ID=60
		   group by ava.product_id)
		   group by av.name
		   order by av.name asc

		*/
		$this->clearWhere();
		$this->addWhere("a.ID=" . $attribute);

		if ($parent_attribute_value>0) {

			$this->addWhere("ava.product_id in (select ava.product_id from mm_product_attribute_value_association ava
			left join mm_product_attribute_values av on ava.attribute_id=av.id
			left join mm_product_attributes a on av.attribute_id=a.id
			where av.ID=" . $parent_attribute_value . "
			group by ava.product_id)"
			);
		}
		$this->setLimit(1, 1000);
		$this->setOrderBy('av.name asc', 'av.name asc');
		$this->setGroupBy('av.name');
		$this->setSelect("av.*");

		$this->setFrom("mm_product_attribute_value_association ava
			left join mm_product_attribute_values av on ava.attribute_id=av.id
			left join mm_product_attributes a on av.attribute_id=a.id"
		);

		$list = $this->getRows();

		return $list;
	}
	public function get_attribute_value_from_parents($parent_attribute_values, $attribute)
	{
		/*
		   select av.* from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where a.ID=2 and ava.product_id in (select ava.product_id from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where av.ID=60
		   group by ava.product_id)
		   group by av.name
		   order by av.name asc

		*/

		$parent_attribute_values_A = explode(",",$parent_attribute_values);
		$this->clearWhere();
		//$value_where = "(";
		foreach ($parent_attribute_values_A as $value){
			$value_where .=" av.id=" . $value . " and";


			$this->addWhere("ava.product_id in (select ava.product_id from mm_product_attribute_value_association ava
		left join mm_product_attribute_values av on ava.attribute_id=av.id
		left join mm_product_attributes a on av.attribute_id=a.id
		where av.id=" . $value . "  and av.isDeleted=0
		group by ava.product_id)"
			);

		}
		/*
		if (substr($value_where, -3) =="and"){
			$value_where = substr($value_where, 0, strlen($value_where)-3);
		}
	*/
	//	$value_where .= ")";


		$this->addWhere("a.id=" . $attribute);
		$this->addWhere("p.isDeleted=0");
		$this->addWhere("ava.isDeleted=0");
/*
		$this->addWhere("ava.product_id in (select ava.product_id from mm_product_attribute_value_association ava
		left join mm_product_attribute_values av on ava.attribute_id=av.ID
		left join mm_product_attributes a on av.attribute_id=a.ID
		where " . $value_where . "
		group by ava.product_id)"
		);
*/
	//	print $this->getWhere();
		$this->setLimit(1, 1000);
		$this->setOrderBy('av.name asc', 'av.name asc');
		$this->setGroupBy('av.name');
		$this->setSelect("av.*");

		$this->setFrom("mm_product_attribute_value_association ava
			left join mm_products p on p.id=ava.product_id
			left join mm_product_attribute_values av on ava.attribute_id=av.id
			left join mm_product_attributes a on av.attribute_id=a.id"
		);

		$list = $this->getRows();
	//	print $this->getLastQuery();
		return $list;
	}

	public function getListold(IListArgs $params = NULL)
	{

		$list =  parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = URL_HOME . 'eshop/attributes/edit_attrib?id='.$list[$i]->id;
		}
		return $list;
	}

  public function getList(IListArgs $params=null)
	{

		$this->clearWhere();
		if (is_null($params)) {
			$params = new ListArgs();
		}

		$this->addWhere("p.isDeleted=0");
		if (isset($params->page_id) && isInt($params->page_id)) {
			$this->addWhere("p.id=" . $params->page_id);
		}

		if(isset($params->fulltext) && !empty($params->fulltext))
		{
			$this->addWhere("v.name like '%" . $params->fulltext . "%'");
		}
    
    if(isset($params->name) && !empty($params->name))
		{
			$this->addWhere("v.name = '" . $params->name . "'");
		}
    
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}

		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 'v.name ASC');


		$this->setSelect("p.*,v.name,v.description,l.code,v.id as version_id");
		$this->setFrom(T_SHOP_PRODUCT_ATTRIBUTES . " AS p
		LEFT JOIN " . T_SHOP_PRODUCT_ATTRIBUTES_VERSION . " v ON p.id=v.attrib_id
		LEFT JOIN " . T_LANGUAGE . " l ON l.id=v.lang_id
		");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

	//	print  $this->getLastQuery();
		return $list;

	}

	public function get_category_from_attribute_value($attribute)
	{
		$this->clearWhere();

		$attribute = explode(",",$attribute);

		if (is_array($attribute) && count($attribute) > 0) {
			$attribute = $attribute[(count($attribute)-1)];
		}
		//$this->addWhere("a.id=" . $attribute);


		//$this->addWhere("s.category_id=" . $category);

		$this->setLimit(1, 1000);
		$this->setOrderBy('cv.title asc');
		//	$this->setGroupBy('av.name');
		$this->setSelect("cv.title as name, c.id");

		$this->setFrom("mm_category c
			left join mm_category_version cv on cv.page_id=c.id and
			 cv.version=c.version and cv.lang_id=6");


		$this->addWhere("c.id in (select p.category_id from mm_product_attribute_value_association ava
			left join mm_product_attribute_values av on ava.attribute_id=av.ID
			left join mm_product_attributes a on av.attribute_id=a.ID
			left join mm_products p on ava.product_id=p.id
			where av.id=" . $attribute . " group by p.category_id)");

		/*
		   $this->setFrom("mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   left join mm_products s on ava.product_id=s.id
		   "
		   );*/

		$list = $this->getRows();
		//print $this->getLastQuery();
		return $list;
	}


}


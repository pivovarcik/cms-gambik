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


	public function get_attribute_value_association2($product_id)
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
		$this->addWhere("ava.product_id is not null");
		//$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy('ava.order,ava.product_id,a.name ASC', 'ava.order,ava.product_id,a.name ASC');

		$this->setSelect("a.id,a.name,max(ava.order) as `order`,max(ava.attribute_id) as attribute_id,a.description,min(av.id) as value,min(av.name) as value_name,
max(case when ava.product_id is null then 0 else 1 end) as has_attribute,product_id");
		$this->setFrom("mm_product_attributes a
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

	public function get_attribute_value_association($product_id)
	{
	//	$this->addWhere("t1.attribute_id=" . $id);
	//	$this->addWhere("ava.product_id is not null");
		//$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy('a.name ASC', 'a.name ASC');

		$this->setSelect("a.id,a.name,max(ava.order) as `order`, max(ava.attribute_id) as attribute_id,a.description,min(av.id) as value,
						max(case when ava.product_id is null then 0 else 1 end) as has_attribute");
		$this->setFrom("mm_product_attributes a
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

		$this->addWhere("t1.attribute_id=" . $id);

		$this->addWhere("t1.name='" . $name . "'");

		//$this->setLimit($params['page'], $params['limit']);
		//$this->setOrderBy('', 't1.name ASC');

		$this->setSelect("t1.*");
		$this->setFrom("mm_product_attribute_values  AS t1");

		$list = $this->getRows();
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

	public function getList(IListArgs $params = NULL)
	{

		$list =  parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = URL_HOME . 'eshop/attributes/edit_attrib?id='.$list[$i]->id;
		}
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
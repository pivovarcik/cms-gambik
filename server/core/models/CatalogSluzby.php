<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_CatalogSluzby extends G_Service{

	function __construct()
	{
		parent::__construct('mm_catalog_program');
	}

	public function get_catalogSluzbyList($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cv.hodnota ASC');

		$this->setSelect("cv.id,cv.hodnota,(case when cva.id is not null then 1 else 0 end) as checked");
		$this->setFrom($this->getTablename() . " cv left join " . 	T_CATALOG_DIVEK . "_sluzby_assoc cva on cv.id=cva.program_id and cva.catalog_id =" . $catalogId);

		$list = $this->getRows();

		return $list;
	}

	public function get_catalogSluzbyList2($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cma.id ASC');
		$this->addWhere("cma.catalog_id =" . $catalogId);
		$this->setSelect("cma.*,cm.*");
	//	$this->setFrom("mm_catalog_vybaveni_assoc cma");

		$this->setFrom(	T_CATALOG_DIVEK . "_sluzby_assoc cma left join mm_catalog_program cm on cm.id=cma.program_id");

		$list = $this->getRows();

		return $list;
	}

	public function get_catalogVybaveniTempList2($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cma.uid ASC');
		$this->addWhere("cma.uid_catalog =" . $catalogId);
		$this->setSelect("cma.*,cm.*");
		//	$this->setFrom("mm_catalog_vybaveni_assoc cma");

		$this->setFrom("mm_catalog_vybaveni_assoc_temp cma left join mm_catalog_vybaveni cm on cm.uid=cma.uid_vybaveni");

		$list = $this->getRows();

		return $list;
	}
	public function getList($params=array())
	{

		//$addWhere();
		//$this->where = "";
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 't1.hodnota ASC');

		$this->setSelect("t1.*");
		$this->setFrom($this->getTableName() . " AS t1");

		$list = $this->getRows();

		return $list;

	}

}
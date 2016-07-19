<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_CatalogVybaveni extends G_Service{

	function __construct()
	{
		parent::__construct('mm_catalog_vybaveni');
	}

	public function get_catalogVybaveniList($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cv.hodnota ASC');

		$this->setSelect("cv.id,cv.hodnota,(case when cva.id is not null then 1 else 0 end) as checked");
		$this->setFrom("mm_catalog_vybaveni cv left join mm_catalog_vybaveni_assoc cva on cv.id=cva.vybaveni_id and cva.catalog_id =" . $catalogId);

		$list = $this->getRows();

		return $list;
	}

	public function get_catalogVybaveniList2($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cma.uid ASC');
		$this->addWhere("cma.uid_catalog =" . $catalogId);
		$this->setSelect("cma.*,cm.*");
	//	$this->setFrom("mm_catalog_vybaveni_assoc cma");

		$this->setFrom("mm_catalog_vybaveni_assoc cma left join mm_catalog_vybaveni cm on cm.uid=cma.uid_vybaveni");

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
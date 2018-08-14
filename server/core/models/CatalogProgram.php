<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_CatalogProgram extends G_Service{

	function __construct()
	{
		parent::__construct('mm_catalog_program');
	}

	/*
	select cm.uid,cm.hodnota,(case when cma.uid is not null then 1 else 0 end) as checked
	   from mm_catalog_program cm left join mm_catalog_program_assoc cma on cm.uid=cma.uid_program and cma.uid_catalog =1
	where cma.uid_catalog =1
	*/
	public function get_catalogProgramList($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		//print $catalogId;
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cm.hodnota ASC');

		$this->setSelect("cm.id,cm.hodnota,(case when cma.id is not null then 1 else 0 end) as checked");
		$this->setFrom("mm_catalog_program cm left join mm_catalog_program_assoc cma on cm.id=cma.program_id and cma.catalog_id =" . $catalogId);

		$list = $this->getRows();
		//print $this->last_query;
		return $list;
	}

	public function get_catalogProgramList2($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cma.uid ASC');
		$this->addWhere("cma.uid_catalog =" . $catalogId);
		$this->setSelect("cma.*,cm.*");
		$this->setFrom("mm_catalog_program_assoc cma left join mm_catalog_program cm on cm.uid=cma.uid_program");

		$list = $this->getRows();
		//print "tudy";
	//	print $this->last_query;
	//	print $this->getWhere();

		return $list;
	}
	public function get_catalogProgramTempList2($catalogId)
	{
		//	$this->addWhere('cma.uid_catalog =' . $catalogId);

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 'cma.uid ASC');
		$this->addWhere("cma.uid_catalog =" . $catalogId);
		$this->setSelect("cma.*,cm.*");
		$this->setFrom("mm_catalog_program_assoc_temp cma left join mm_catalog_program cm on cm.uid=cma.uid_program");

		$list = $this->getRows();
		//print "tudy";
		//	print $this->last_query;
		//	print $this->getWhere();

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
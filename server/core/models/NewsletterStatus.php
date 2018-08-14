<?php

class models_NewsletterStatus extends G_Service{

	function __construct()
	{
		parent::__construct(T_NEWSLETTER_STATUS);
	}

	public $total = 0;

	public function getList(IListArgs $params = null)
	{

                
                
                
    if(isset($params->newsletter_id) && isInt($params->newsletter_id))
		{
			$this->addWhere("t1.newsletter_id=".$params->newsletter_id );
		}
		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy('t1.email ASC');

		$this->setSelect("t1.*");
		$this->setFrom($this->getTableName() . " AS t1");

		$list = $this->getRows();
		$this->total = count($list);
		return $list;

	}

}
<?php

interface IListArgs {

	/**
	 * Velikost kolekce sady
	 * */
	public function getLimit();
	/**
	 * Číslo sady
	 * */
	public function getPage();
	/*public $page;
	public $limit;
	public $isDeleted;
	public $orderBy;*/
}

/**
 * Předek pro všechny parametry pro getList
 * **/
class ListArgs implements IListArgs{
	public $page = 1;
	public $limit = DEFAULT_LIMIT;
	public $isDeleted = 0;
	public $orderBy = "";
	public $groupBy = "";
	public $select = "";

	/*
	   Slouží k předávání postovaných dat z klienta
	   datagrid tyto data zpracuje převede dynamicky na parametry
	*/
	public $postdata = null;

	public $search = "";
	protected $request;
	protected $isLimitByQuery = false;
	protected $isPageByQuery = false;
	protected $isOrderByQuery = false;
	public $allowedOrder = array();
	private $allowedSort = array();
	public function limitByQueryRegister($isLimit=true)
	{
		$this->isLimitByQuery = $isLimit;
	}

	public function orderByQueryRegister($isLimit=true)
	{
		$this->isOrderByQuery = $isLimit;
	}

	public function pageByQueryRegister($isPage=true)
	{
		$this->isPageByQuery = $isPage;
	}


	public function __construct()
	{
		$this->postdata = new stdClass();
		$this->request = new G_Html();
/*
	foreach ($_GET as $key => $val)
		{
			$this->$key = $val;
		}	*/


		if (defined("LANG_TRANSLATOR")) {
			// delalo to neplechu s prekladama
			//$this->lang = LANG_TRANSLATOR;
		}

		$this->allowedSort = array("asc","desc");
		$this->limit = DEFAULT_LIMIT;
	//	print DEFAULT_LIMIT;
	}

	public function getLimit()
	{
	//$this->allowedSort = array("asc","desc");
		if ($this->isLimitByQuery) {
			return (int)$this->request->getQuery('limit', $this->limit);
		}
		return $this->limit;
	}

	public function getPage()
	{
		if ($this->isPageByQuery) {
			return (int)$this->request->getQuery('pg', $this->page);
		}
		return $this->page;
	}

	public function getGroupBy()
	{
		return $this->groupBy;
	}

	public function getSelect()
	{
		return $this->select;
	}

	public function getOrderBy()
	{
		if ($this->isOrderByQuery) {
			$order = $this->request->getQuery('order', false);

			//print $order;
			$sort = $this->request->getQuery('sort', 'asc');

			if (!in_array($sort,$this->allowedSort)) {
				$sort = $this->allowedSort[0];
			}
			if ($order) {


				//!in_array($order, $this->allowedOrder)
				if ( count($this->allowedOrder)> 0  && !array_key_exists($order,$this->allowedOrder)) {

					return $this->orderBy;
				} else {
				//	print $order;
				//	print_r($this->allowedOrder);
					if (isset($this->allowedOrder[$order])) {
						return $this->allowedOrder[$order] . ' ' . $sort;
					}

				}
				if (!empty($order)) {
					return $order . ' ' . $sort;
				}

			}
			return $this->orderBy;
			//return $this->request->getQuery('order', $this->orderBy);
		}
		return $this->orderBy;
	}

}

?>
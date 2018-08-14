<?php

/**
 * Nastavení třídění pro hlavičku tabulky
 * 11.2.2012
 */
class G_Sorting{
	/**
	 * Constructor
	 */
	private $orderDefault = '';
	private $sortDefault = '';

	public $LabelSelected = "";
	public $orderSelected = "";
	private $ajax;
	function __construct($orderDefault = '', $sortDefault = '', $ajax = false){
		$this->orderDefault = $orderDefault;
		$this->sortDefault = $sortDefault;
		$this->ajax = $ajax;
	}
	public function get_konecek($params = array())
	{
		parse_str($_SERVER["QUERY_STRING"], $url_params);

		if(isset($params["ignore_list"]) && is_array($params["ignore_list"]))
		{
			$ignore_list = $params["ignore_list"];
		} else {
			$ignore_list = array('pg', 'id', 'cat', 'url', 'sort', 'order', 'lang');
		}



		$this->konecek="";
		foreach($url_params as $key=>$value)
		{
			//if($key !='pg' && $key !='id')
			//print_r($value);
			if(!in_array($key, $ignore_list))
			{
				// pouze když je nějaká hodnota

				if (!empty($value) or $value == 0)
				{
					//print_r($value);
					if (!empty($this->konecek) && substr($this->konecek, -1) !="&"){
						$this->konecek = $this->konecek . "&" . $key . "=" . $value;
					} else {
						$this->konecek = $key . "=" . $value;
					}
				}

			}
		}
		if (!empty($this->konecek)){
			if (isset($params["url_fiendly"]) && $params["url_fiendly"]==0)
			{
				$this->konecek = "&" . $this->konecek;
			}else {
				$this->konecek = "?" . $this->konecek;
			}
		}
		return $this->konecek;
	}
	public function setOrderBy()
	{

	}
	public function render($label, $orderBy, $sortim = '')
	{
		$konecek = $this->get_konecek();
		//$konecek = '';
		$orderByQuery = isset($_GET["order"]) ? $_GET["order"] : '';
		$sortByQuery = isset($_GET["sort"]) ? $_GET["sort"] : '';
		$orderBySql = '';
		//$this->get_konecek(array("ignore_list"=>array('order', 'sort')));
		// Url neobsahuje třídění
		if (empty($orderByQuery) && !empty($this->orderDefault))
		{

			// Url obsahuje třídění
			if ($this->orderDefault == $orderBy)// || isset($params["sort"])
			{
				if (strToLower($this->sortDefault) == 'desc')
				{
					$sort = 'asc';
					$sort2='desc';
				//	$sortImg = 'up.gif';
					$orderBySql .= ' DESC';
				} else
				{
					$sort = 'desc';
					$sort2='asc';
				//	$sortImg = 'down.gif';
					$orderBySql .= ' ASC';
				}
			//	$url = AKT_PAGE . '?order=' . $orderBy . '&amp;sort=' . $sort . $konecek;

			}else {
				//$orderBySql = $params["sql"];
				if (strToLower($sortim) == 'desc')
				{
					$sort = 'asc';
          $sort2='desc';
					$orderBySql .= ' DESC';
				} else
				{
					$sort = 'desc';
          $sort2='asc';
					$orderBySql .= ' ASC';
				}

			}
			if ($this->ajax) {
				$url = '#order=' . $orderBy . '&amp;sort=' . $sort;
			} else {
				$url = AKT_PAGE . '?order=' . $orderBy . '&amp;sort=' . $sort . $konecek;
			}

			$label = '<a class="sort-' . $sort . ' sort-' . $sort2 . '-hov" href="' . $url . '"><span>' . $label . '</span></a>';
			//$this->orderBySql = $orderBySql;
			return $label;

		}
		// Url obsahuje třídění
		if ($orderByQuery == $orderBy)// || isset($params["sort"])
		{
			if ($sortByQuery == 'asc')
			{
				$sort = 'desc';
				$sort2='asc';
			//	$sortImg = 'down.gif';
				$orderBySql .= ' ASC';
			} else
			{
				$sort = 'asc';
				$sort2='desc';
			//	$sortImg = 'up.gif';
				$orderBySql .= ' DESC';
			}

			$this->LabelSelected = $label;
			$this->orderSelected = $orderBy;


			if ($this->ajax) {
				$label = '<a class="sort-' . $sort . ' sort-' . $sort2 . '-hov" href="#order=' . $orderBy . '&amp;sort=' . $sort . '"><span>' . $label . '<i class="fa fa-sort-' . $sort2 . '"></i></span></a>';

			} else {
				$label = '<a class="sort-' . $sort . ' sort-' . $sort2 . '-hov" href="' . AKT_PAGE . '?order=' . $orderBy . '&amp;sort=' . $sort . $konecek . '"><span>' . $label . '<i class="fa fa-sort-' . $sort2 . '"></i></span></a>';

			}

			//$this->orderBySql = $orderBySql;
			return $label;
		}

		if (strToLower($sortim) == 'desc')
		{
			$sort = 'desc';
		} else
		{
			$sort = 'asc';
		}
		// Nebylo ještě kliknuto

		if ($this->ajax) {
			$label = '<a class="sort-' . $sort . '-hov" href="#order=' . $orderBy . '&amp;sort=' . $sort . '"><span>' . $label . '</span></a>';

		} else {
			$label = '<a class="sort-' . $sort . '-hov" href="' . AKT_PAGE . '?order=' . $orderBy . '&amp;sort=' . $sort . $konecek . '"><span>' . $label . '</span></a>';

		}

		return $label;

	}
}


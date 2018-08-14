<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Paginator {
	private $konecek;
	private $akt_page;
	private $total;
	private $count;
	private $perpage;
	private $ajax;
	public function __construct($akt, $total, $perpage, $ajax = false){

		$this->akt_page = $akt;
		$this->total = $total;
		//$this->count = $count;
		if ($perpage > 0 ) {
			$this->perpage = $perpage;

		} ELSE {
			$this->perpage = DEFAULT_LIMIT;
		}

		$this->ajax = $ajax;
		//	PRINT $this->perpage;

	}
	public function get_konecek($params = array())
	{
		parse_str($_SERVER["QUERY_STRING"], $url_params);

		//print_r($url_params);
		if(isset($params["ignore_list"]) && is_array($params["ignore_list"]))
		{
			$ignore_list = $params["ignore_list"];
		} else {
			$ignore_list = array('pg', 'id', 'cat', 'url','lang');
		}



		$this->konecek="";
		foreach($url_params as $key=>$value)
		{
			//if($key !='pg' && $key !='id')
			if(!in_array($key, $ignore_list))
			{
				// pouze když je nějaká hodnota
				if (!empty($value))
				{
					if (is_array($value) && count($value) > 0) {

						foreach ($value as $key2 => $val2) {

							if (!empty($this->konecek) && substr($this->konecek, -1) !="&"){
								$this->konecek = $this->konecek . "&" . $key. "[" . $key2 . "]=" . $val2;
							} else {
								$this->konecek = $key. "[" . $key2 . "]=" . $val2;
							}
						}
					} else {
						if (!empty($this->konecek) && substr($this->konecek, -1) !="&"){
							$this->konecek = $this->konecek . "&" . $key . "=" . $value;
						} else {
							$this->konecek = $key . "=" . $value;
						}
					}

				}

			}
		}
		if (!empty($this->konecek)){

			/*
			   if (isset($params["url_fiendly"]) && $params["url_fiendly"]==0)
			   {
			   $this->konecek = "&" . $this->konecek;
			   }else {
			   $this->konecek = "?" . $this->konecek;
			   }
			*/
			$this->konecek = "&" . $this->konecek;
			//print $this->konecek;
		}
		return $this->konecek;
	}

	public function prelozit_frazy($string)
	{
		return $string;
	}
	public function render2($params = array())
	{

		$print ="";
		$output ="";
		// 1,2,3 ... 9,[10],11 ... 55,56,57
		//$p = $this->pager;
		$this->get_konecek();
		//$page = 4;
		$page = $this->akt_page;

		if (isset($params["url_fiendly"]) && $params["url_fiendly"]==1)
		{
			$url_start = AKT_PAGE;
			$url_end = "/";
		} else
		{

			$url_start = AKT_PAGE . "?pg=";
			$url_end = "";
		}

		if (empty($page)|| $page==0 )
		{
			$page = 1;
		}

		$pager = ceil($this->total/$this->perpage);

		if ($pager > 0) {
			//$pager = $this->count;
			$maxPages = 3000;
			if ($pager > $maxPages){
				$maxPages = $maxPages;
			} else {
				$maxPages = $pager;
			}
			$output .='<div class="paging"><ul class="pglist">';
			$print .='<div class="paging"><ul class="pglist">';


			$tecky_po = false;
			$tecky_pred = false;

			for ($i=0;$i <$pager;$i++)
			{
				$num = $i+1;
				if ($num <= $maxPages)
				{
					if ($num == 1 && $page>1)
					{
						$print .='<li class="prvs"><a href="' . $url_start . ($page-1) . $url_end
						. $this->konecek .'" title="Přejít na ' . ($page-1) .'. stránku">'.$this->prelozit_frazy('předchozí').'</a></li>';
					}
					//  print $page . " " . $num;
					switch($num)
					{
						case $page:
							// Aktuální Page
							$print .= '<li class="slctpgnum"><span>' . ($num) . '</span></li>';
							break;
						case $page - 1:
							// Předchozí Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case $page + 1:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case 1:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case 2:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case 3:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;

						case count($pager)-2:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case count($pager)-1:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case count($pager):
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case $page+1 > $num:
							// Následující Page

							if (!$tecky_pred)
							{
								$print .= '<li class="tecky"><span>...</span></li>';
								$tecky_pred = true;
							}

							break;
						case $page+1 < $num:
							// Následující Page

							if (!$tecky_po)
							{
								$print .= '<li class="tecky"><span>...</span></li>';
								$tecky_po = true;
							}

							break;
						default:

							break;
					}

					if ($num == $maxPages && $page<$maxPages) {
						$print .='<li class="nxt"><a href="' . $url_start . ($page+1) . $url_end
						. $this->konecek . '" title="Přejít na ' . ($page+1) . '. stránku">'.$this->prelozit_frazy('další').'</a></li>';
					}




					if ($i+1 == 1 && $page>1)
					{
						$output .='<li class="prvs"><a href="' . $url_start . ($page-1) . $url_end
						. $this->konecek .'" title="Přejít na ' . ($page-1) .'. stránku">předchozí</a></li>';
					}
					if ($i+1 == $page) {
						// AKTUÁLNÍ PAGE
						$output .='<li class="slctpgnum"><span>' . ($i+1) . '</span></li>';
					} else {
						// PŘEDCHOZÍ PAGE
						if ($i+1 == $page-1)
						{

						} elseif($i+1 == $page+2)
						{

						} else {
							$output .='<li class="pgnum"><a href="' . $url_start . ($i+1) .  $url_end
							. $this->konecek . '" title="Přejít na ' . ($i+1) . '. stránku">' . ($i+1) . '</a></li>';
						}

					}
					if ($i+1 == $maxPages && $page<$maxPages) {
						$output .='<li class="nxt"><a href="' . $url_start . ($page+1) . $url_end
						. $this->konecek . '" title="Přejít na ' . ($page+1) . '. stránku">další</a></li>';
					}
				}
			}
			$output .='</ul></div><div class="endpaging"></div>';
		} else {
			$output ='';
		}
		$print .='</ul></div><div class="endpaging"></div>';
		return $print;
	}
	public function render($params = array())
	{

		$translator = G_Translator::instance();
		$print ="";
		$output ="";
		// 1,2,3 ... 9,[10],11 ... 55,56,57
		//$p = $this->pager;
		$this->get_konecek();
		//$page = 4;
   
    $aktPage = ""; 
    if (defined("AKT_PAGE"))
    {
       $aktPage = AKT_PAGE;
    }

		//print $this->konecek;
		$page = $this->akt_page;

		if (isset($params["url_fiendly"]) && $params["url_fiendly"]==1)
		{
			$url_start = $aktPage;
			$url_end = "/";
		} else
		{

			$q = "?";
			if (strpos($aktPage, "?")) {
				$q = "&";
			}
			$url_start = $aktPage . $q . "pg=";
			$url_end = "";
		}
		//print $url_start;
		if (empty($page)|| $page==0 )
		{
			$page = 1;
		}

		if ($this->ajax) {
			$url_start = "#";
			$url_end = "";
			$this->konecek = "";
		}
		$pager = ceil($this->total/$this->perpage);
		if ($pager == 0) {
			$pager = 1;
		}
		//	print $pager;
		if ($pager > 0) {
			//$pager = $this->count;
			$maxPages = 3000;
			if ($pager > $maxPages){
				$maxPages = $maxPages;
			} else {
				$maxPages = $pager;
			}
			$output .='<div class="paging"><ul class="pglist pagination">';
			$print .='<div class="paging"><ul class="pglist pagination">';


			$tecky_po = false;
			$tecky_pred = false;

			for ($i=0;$i <$pager;$i++)
			{
				$num = $i+1;
				if ($num <= $maxPages)
				{
					if ($num == 1 && $page>1)
					{
						$print .='<li class="prvs"><a href="' . $url_start . ($page-1) . $url_end
						. $this->konecek .'" title="Přejít na ' . ($page-1) .'. stránku">'.$translator->prelozitFrazy('předchozí').'</a></li>';
					}
					//  print $page . " " . $num;
					switch($num)
					{
						case $page:
							// Aktuální Page
							$print .= '<li class="slctpgnum active"><span>' . ($num) . '</span></li>';
							break;
						case $page - 1:
							// Předchozí Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case $page + 1:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case 1:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case 2:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case 3:
							// Následující Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;

						case $pager-2:
							// Před předposlední Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case $pager-1:
							// Předposlední Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case $pager:
							// Poslední Page
							$print .= '<li class="pgnum"><a href="' . $url_start . ($num) . $url_end
								. $this->konecek . '" title="Přejít na ' . ($num) . '. stránku">' . ($num) . '</a></li>';
							break;
						case $page+1 > $num:
							// Následující Page

							if (!$tecky_pred)
							{
								$print .= '<li class="tecky"><span>...</span></li>';
								$tecky_pred = true;
							}

							break;
						case $page+1 < $num:
							// Následující Page

							if (!$tecky_po)
							{
								$print .= '<li class="tecky"><span>...</span></li>';
								$tecky_po = true;
							}

							break;
						default:

							break;
					}

					if ($num == $maxPages && $page<$maxPages) {
						$print .='<li class="nxt"><a href="' . $url_start . ($page+1) . $url_end
						. $this->konecek . '" title="Přejít na ' . ($page+1) . '. stránku">'.$translator->prelozitFrazy('další').'</a></li>';
					}




					if ($i+1 == 1 && $page>1)
					{
						$output .='<li class="prvs"><a href="' . $url_start . ($page-1) . $url_end
						. $this->konecek .'" title="Přejít na ' . ($page-1) .'. stránku">'.$translator->prelozitFrazy('předchozí').'</a></li>';
					}
					if ($i+1 == $page) {
						// AKTUÁLNÍ PAGE
						$output .='<li class="slctpgnum active"><span>' . ($i+1) . '</span></li>';
					} else {
						// PŘEDCHOZÍ PAGE
						if ($i+1 == $page-1)
						{

						} elseif($i+1 == $page+2)
						{

						} else {
							$output .='<li class="pgnum"><a href="' . $url_start . ($i+1) .  $url_end
							. $this->konecek . '" title="Přejít na ' . ($i+1) . '. stránku">' . ($i+1) . '</a></li>';
						}

					}
					if ($i+1 == $maxPages && $page<$maxPages) {
						$output .='<li class="nxt"><a href="' . $url_start . ($page+1) . $url_end
						. $this->konecek . '" title="Přejít na ' . ($page+1) . '. stránku">'.$translator->prelozitFrazy('další').'</a></li>';
					}
				}
			}
			//$output .='</ul></div><div class="endpaging"></div>';
		} else {
			$output ='';
		}
		$print .='</ul></div><div class="endpaging"></div>';
		return $print;
	}
}

?>
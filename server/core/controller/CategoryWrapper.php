<?php



class CategoryWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);


		$serial_cat_idA = str_replace("||", "" , $radek->serial_cat_id);
		$serial_cat_idA = explode("|", $serial_cat_idA);

		$radek->pathA = array();
	//	$radek->childern = array();
		$radek->path = "";
		$radek->level = 0;
		foreach ($serial_cat_idA as $key => $val) {

			if (!empty($val)) {
				array_push($radek->pathA, $val);
			}
		}
		$radek->level = count($radek->pathA);
		$radek->path = implode("|", $radek->pathA);
	//	$radek->orderList = array();

  // Podpora cizí adresy
  if (isUrl($radek->serial_cat_url))
  {   $radek->link = get_categorytourl($radek->serial_cat_url);
  
  } else {
  
     $radek->link = URL_HOME . get_categorytourl($radek->serial_cat_url);
  }
	}
}
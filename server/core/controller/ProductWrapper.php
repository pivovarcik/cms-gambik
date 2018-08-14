<?php

class ProductWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "sortiment?do=ProductEdit&id=" . $radek->page_id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "sortiment?do=ProductDelete&id=" . $radek->page_id);
		array_push($radek->dg_commands, $command);
    
    $command = new CopyDataGridCommand(URL_HOME . "sortiment?do=ProductCopy&id=" . $radek->page_id);
		array_push($radek->dg_commands, $command);

		$radek->thumb = '';
		$radek->thumb_abs_link = '';
		$radek->img_abs_link = 'x';
		$radek->img_link = '';
		$radek->thumb_link = '';
    
    $radek->groups = array();
    
    $groups = explode("|",$radek->group_label);
    $groupIds = explode("|",$radek->group_id);
    for($i=0;$i<count($groups);$i++)
    {
       $obj = new StdClass();
       $obj->id = $groupIds[$i];
       $obj->name = $groups[$i];
       array_push($radek->groups,$obj);
    }
    
		if (!empty($radek->file)) {

			$imageController = new ImageController();
			$eshopSettings = G_EshopSetting::instance();
			$thumb_width= $eshopSettings->get("PRODUCT_THUMB_WIDTH"); // 190;
			$thumb_height= $eshopSettings->get("PRODUCT_THUMB_HEIGHT"); //200;

		//	$radek->thumb_link = $imageController->getZmensitOriginal($radek->dir . $radek->file,$thumb_width,$thumb_height);
			$radek->thumb_link = $imageController->getFileUrl($radek->dir . $radek->file,$thumb_width,$thumb_height);
      $radek->thumb_abs_link = URL_HOME_ABS;

			$radek->img_link = "public/foto/" . $radek->dir . $radek->file;
		//	$radek->img_link = $radek->dir . $radek->file;
      $radek->img_abs_link = URL_HOME_ABS;
           
      
      if (substr($radek->thumb_abs_link,-1) == "/")
      {
            $radek->thumb_abs_link = substr($radek->thumb_abs_link,0,strLen($radek->thumb_abs_link)-1);
            
      }
			$radek->thumb_abs_link .= $radek->thumb_link;
			$radek->img_abs_link .= $radek->img_link;
      
    //  print_r($radek);
    //  exit ;
			$radek->thumb = '<a class="lightbox" href="' . URL_IMG . $radek->dir . $radek->file . '" title="' . $radek->title . '"><img width="' . $thumb_width . '" height="' . $thumb_height . '" alt="' . $radek->title . '" src="' . $radek->thumb_link . '" class="imgobal" /></a>';
		}

    if ($radek->dostupnost_id > 0){
    
    } else {
      
      if ($radek->stav_qty > 0)
      {
         $radek->nazev_dostupnost = "Skladem";
      }  else {
         $radek->nazev_dostupnost = "Není skladem";
      }
    }
     // Neprodejne - neukazuji dostupnost
      if ($radek->neprodejne == 1)
      {
         $radek->nazev_dostupnost = "";
      }
    
    
//

//		$radek->link = URL_HOME . "product/" . $radek->page_id . '-' . strToUrl($radek->title) . '.html';

$url_home =  URL_HOME;
if (defined("ADMIN")){

    $url_home = str_replace("admin/","",$url_home);
}
		$radek->link = $url_home . "p" . $radek->page_id . '-' . strToUrl($radek->title) . '.html';

		$cenaOd = "";
		if ($radek->variantyPrice && $radek->min_prodcena <> $radek->max_prodcena) {
			$cenaOd = "od ";
			$pocetDesetin = 0;
			$radek->prodcena = $cenaOd . numberFormat($radek->min_prodcena, $pocetDesetin);

			$radek->prodcena_sdph = $cenaOd . numberFormat($radek->min_prodcena_sdph, $pocetDesetin);
		}
	//	$radek->size = sizeFormat($radek->size);//$filesize;
	}
}
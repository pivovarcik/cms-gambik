<?php

class ZboziCzController extends G_Controller_Action {

	public function feedGeneratorAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('zboziProductFeed', false))
		{
        
        if ($this->productListFeedGenerator())
        {
            $this->getRequest->goBackRef();
        }
    }
  }
  
  public function productListFeedGenerator()
  {
    //$ProductController = new ProductController();
    $params = new ListArgs();
    $params->limit = 1000000;
    $params->page = 1;
    $params->aktivni = 1;
  //  $params->neexportovat = 0;
    //$params->kategorie = 1;
    $params->child = 1;
    $params->lang = "cs";
    $params->order_default = "v.title ASC";
    $feed = $this->feedList($params);

  
    $ourFileName = PATH_ROOT . 'export/' . "zbozicz.xml";
    file_put_contents($ourFileName, ($feed));
    $key = "ZBOZICZ_XML_DATE";
    $data = array();
		$data["value"] = date("Y-m-d H:i:s");
          
    $model = new models_Eshop();
    $model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    return true;
    
  }
	public function feedList(IListArgs $params)
	{
		$params->neexportovat = 0;
		$params->skladem = 1;
    
    $ProductController = new ProductController();
		$list2 = $ProductController->productList($params);
		$imageController = new ImageController();
		$eshopSettings = G_EshopSetting::instance();
		//$eshopController = new EshopController();
		//$xml = new c_xml_generator;

   // print_r($list2);
   // exit;
		$res='<?xml version="1.0" encoding="utf-8"?';
    $res.='>
';
		$res.='<SHOP xmlns="http://www.zbozi.cz/ns/offer/1.0">
';
		//$root = $xml->add_node(0, 'SHOP');



    $list = array();
    for ($i=0;$i<count($list2);$i++)
		{
    
            new ProductsWrapper($list2[$i]);
        $obj = new StdClass;
        
        $obj->title = $list2[$i]->title;
        $obj->page_id = "p" . $list2[$i]->page_id;
        $obj->description = $list2[$i]->description;
        $obj->nazev_vyrobce = $list2[$i]->nazev_vyrobce;
        $obj->serial_cat_title = $list2[$i]->serial_cat_title;
        $obj->link = $list2[$i]->link;
        $obj->bazar = $list2[$i]->bazar;
        $obj->hodiny_dostupnost = $list2[$i]->hodiny_dostupnost;
        $obj->dostupnost = $list2[$i]->dostupnost;
        $obj->file = $list2[$i]->file;
        $obj->thumb_abs_link = $list2[$i]->thumb_abs_link;
        $obj->img_abs_link = $list2[$i]->img_abs_link;
        //$obj->prodcena = $list2[$i]->prodcena;
        $obj->prodcena = round($list2[$i]->cena_bezdph,2);
        //$obj->prodcena_sdph = round($list2[$i]->prodcena_sdph,0);
        $obj->prodcena_sdph = round($list2[$i]->cena_sdph,0);
        $obj->value_dph = $list2[$i]->value_dph;
        $obj->ppc_zbozicz = $list2[$i]->ppc_zbozicz;
        

        if (is_array($list2[$i]->variantyList) && count($list2[$i]->variantyList)>0)
        {
        
        //print_r($list2[$i]->variantyList);
        //exit;
          foreach ($list2[$i]->variantyList as $key => $varianta)
          {
          
          
            $obj = new StdClass;
        
            $obj->page_id = "p" . $list2[$i]->page_id . "v" . $varianta->id;
            $obj->title = $list2[$i]->title;
            $obj->description = $list2[$i]->description;
            $obj->nazev_vyrobce = $list2[$i]->nazev_vyrobce;
            $obj->serial_cat_title = $list2[$i]->serial_cat_title;
            $obj->link = $list2[$i]->link . "?varianta=" . $varianta->code;
            $obj->bazar = $list2[$i]->bazar;
            $obj->hodiny_dostupnost = $list2[$i]->hodiny_dostupnost;
            $obj->dostupnost = $list2[$i]->dostupnost;
            $obj->file = $list2[$i]->file;
            $obj->thumb_abs_link = $list2[$i]->thumb_abs_link;

            $obj->value_dph = $list2[$i]->value_dph;
            $obj->ppc_zbozicz = $list2[$i]->ppc_zbozicz;
            
            
            if (empty($varianta->name))
            {
               $obj->title .= " " . $varianta->code;
            } else {
              $obj->title = $varianta->name;
            }
            
                        $obj->prodcena =$varianta->price;
            $obj->prodcena_sdph =$varianta->price_sdani;
            
            
            $obj->dostupnost_hodiny = $varianta->dostupnost_hodiny;
            $obj->prodcena = $varianta->price;
              array_push($list,$obj);
          
          }
        
        } else {
        
            array_push($list,$obj);
        }
    
    }

       /*
    print "$list2:" . count($list2);
    print "$list:" . count($list);
           exit;  */
    
		for ($i=0;$i<count($list);$i++)
		{
    

			//$item  = $xml->add_node($root, 'SHOPITEM');
			$res.='<SHOPITEM>
';

			$res.='<ITEM_ID>' . $list[$i]->page_id . '</ITEM_ID>
';

			$nazev_mat = trim(strip_tags($list[$i]->title));

			$nazev_mat = "<![CDATA[" . $nazev_mat . "]]>";
			$res.='<PRODUCT>' . $nazev_mat . '</PRODUCT>
';

			$res.='<PRODUCTNAME>' . $nazev_mat . '</PRODUCTNAME>
';
			$popis = truncateUtf8(trim(strip_tags($list[$i]->description)),250,true,true);
			$popis = "<![CDATA[" . $popis . "]]>";
			$res.='<DESCRIPTION>' . $popis . '</DESCRIPTION>
';

			if (!empty($list[$i]->nazev_vyrobce)) {
				$nazev_vyrobce = trim(strip_tags($list[$i]->nazev_vyrobce));
				$res.='<MANUFACTURER>' . $nazev_vyrobce . '</MANUFACTURER>
';
			}
			if (!empty($list[$i]->serial_cat_title)) {

				$nazev_vyrobce = trim(strip_tags($list[$i]->serial_cat_title));
	//			$nazev_vyrobce = trim(($list[$i]->serial_cat_title));
  
				$nazev_vyrobce = str_replace("|||||","",$nazev_vyrobce);
				$nazev_vyrobce = str_replace("||||","",$nazev_vyrobce);
				$nazev_vyrobce = str_replace("|||","",$nazev_vyrobce);
				$nazev_vyrobce = str_replace("||","",$nazev_vyrobce);
        
        
         $nazev_vyrobceA = explode("|",$nazev_vyrobce);
        
      //  $nazev_vyrobce = "";
        $nazev_vyrobceA2 = array();
        for($i2=1;$i2<count($nazev_vyrobceA);$i2++)
        {
            if (!empty($nazev_vyrobceA[$i2]))
            {
                array_push($nazev_vyrobceA2,trim($nazev_vyrobceA[$i2]));
            }
        } 
        $nazev_vyrobce = implode("|",$nazev_vyrobceA2);
    
        $nazev_vyrobce = "<![CDATA[" . $nazev_vyrobce. "]]>";
				$res.='<CATEGORYTEXT>' . $nazev_vyrobce . '</CATEGORYTEXT>
';
			}

			$res.='<URL>' . $list[$i]->link . '</URL>
';

      if ($list[$i]->bazar == 1) {
      			$res.='<ITEM_TYPE>bazaar</ITEM_TYPE>
      ';
      } else	{
      	$res.='<ITEM_TYPE>new</ITEM_TYPE>
      ';
			}
			if ($list[$i]->hodiny_dostupnost >=1000 || $list[$i]->hodiny_dostupnost <0 ) {
				// není skladem / neznámá
				$delivery_date = "-1";
			} elseif ($list[$i]->hodiny_dostupnost > 0) {
				$delivery_date = round($list[$i]->hodiny_dostupnost/24);
			} elseif ($list[$i]->hodiny_dostupnost == 0) {
				$delivery_date = "0";
			} else {
				$delivery_date = "-1";
			}

			$res.='<DELIVERY_DATE>' . $delivery_date . '</DELIVERY_DATE>
';
/*
     $delivery_id = "DOPRAVCE_FOFR";
     $delivery_price = "0";
			$res.='<DELIVERY>
';
			$res.='<ID>' . $delivery_id . '</ID>
';
			$res.='<DELIVERY_PRICE>' . $delivery_price . '</DELIVERY_PRICE>
';

			$res.='</DELIVERY>
';
     */
      /*
print_r($list[$i]);
exit;   */
		//	$url_img = "<![CDATA[" . $list[$i]->thumb_abs_link . "]]>";
			$url_img = "<![CDATA[" . $list[$i]->img_abs_link . "]]>";
			$res.='<IMGURL>' .  $url_img . '</IMGURL>
';


			if ($eshopSettings->get("PLATCE_DPH") == "1" && $eshopSettings->get("PRICE_TAX") == "0") {

				$res.='<PRICE>' . $list[$i]->prodcena . '</PRICE>
';
				$res.='<VAT>' . $list[$i]->value_dph . '</VAT>
';

			} else {
				$res.='<PRICE_VAT>' . $list[$i]->prodcena_sdph . '</PRICE_VAT>
';
			}



			if (trim($eshopSettings->get("DOPRAVNE_ZDARMA")) == "1") {
				$res.='<EXTRA_MESSAGE>free_delivery</EXTRA_MESSAGE>
';
			}

			if ($list[$i]->ppc_zbozicz > 0) {
				$res.='<MAX_CPC>' . $list[$i]->ppc_zbozicz . '</MAX_CPC>
';
			}

			$res.='</SHOPITEM>
';
		}
		$res.='</SHOP>';
		return $res;
		//return $xml->create_xml();
	}
}


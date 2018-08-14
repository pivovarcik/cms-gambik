<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class HeurekaController extends G_Controller_Action
{
	public $order_details = array();
	private $heureka_id = "";

	private $heureka_enabled = false;
	function __construct()
	{

		parent::__construct();
		$eshopSettings = G_EshopSetting::instance();
		$this->heureka_id = $eshopSettings->get("HEUREKA_CODE");


	//	$eshopController = new EshopController();
	//	$this->heureka_id = $eshopController->setting["HEUREKA_CODE"];

		//$isEnabled = ($eshopController->setting["HEUREKA_ENABLED"] == "1") ? true : false;
		$isEnabled = ($eshopSettings->get("HEUREKA_ENABLED") == "1") ? true : false;
		if (!empty($this->heureka_id) && $isEnabled) {
			$this->heureka_enabled = true;
		}


	}
	public function getOrder($id)
	{
		$orderController = new OrderController();
		$order = $orderController->getOrder($id,false);

		$this->order_details = $orderController->order_details;
		return $order;
	}

	public function postRequestHeureka($id)
	{


	//	print "tudy" . $id;
		if (!$this->heureka_enabled) {

		//	print "Heureka je neaktivní";
			return;
		}

	//	exit;
		$order = $this->getOrder($id);

		//print_r($order);
		if ($order) {

			if ($order->heureka == 1) {
				// doatzník už byl odeslán
			//	print "dotazník už byl odeslán";
				return false;
			}
			$radky = $this->order_details;

			$produkty = array();
			for ($i=0; $i<count($radky);$i++)
			{
				// jen řádky s produkty bez dopravy a dalších položek
				if ($radky[$i]->product_id > 0) {
					$produkty[] = $radky[$i]->product_name;
				}

			}

		//	print_r($produkty);
		//	exit;
			$url = $this->getUrlRequest($order->code, $order->shipping_email, $produkty);

			$contents = $this->sendRequest($url);

		//	print $url;
		//	print_r($contents);
		//	exit;
			if (false === $contents) {
				throw new Exception ('Nepodarilo se odeslat pozadavek');
			} elseif ("ok" == $contents) {
				$model = new models_Orders();
				$data = array();
				$data["heureka"] = 1;
				$data["heurekaTimeStamp"] = date("Y-m-d H:i:s");
				$model->updateRecords($model->getTableName(),$data , "id=".$id);
				return true;
			} else {
				throw new Exception ($contents);
			}

			/*
			ob_start();
			//	ob_start(null, 4096, true);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			$res = curl_exec($ch);
			curl_close($ch);
			print $url;
			*/

		}


	}

	public function getUrlRequest($order_code, $email, $produkty = array())
	{
		$url = "http://www.heureka.cz/direct/dotaznik/objednavka.php?id=" . $this->heureka_id;

		$url .= "&email=" . $email;

		foreach ($produkty as $key => $val){
			$url .= "&produkt[]=" . urlencode($val);
		}


		$url .= "&orderid=" . $order_code;

		return $url;
	}


	private function sendRequest ($url) {
		$parsed = parse_url($url);
		$fp = fsockopen($parsed['host'], 80, $errno, $errstr, 5);
		if (!$fp) {
			throw new Exception ($errstr . ' (' . $errno . ')');
		} else {
			$return = '';
			$out = "GET " . $parsed['path'] . "?" . $parsed['query'] . " HTTP/1.1\r\n" .
			    "Host: " . $parsed['host'] . "\r\n" .
			    "Connection: Close\r\n\r\n";
			fputs($fp, $out);
			while (!feof($fp)) {
				$return .= fgets($fp, 128);
			}
			fclose($fp);
			$returnParsed = explode("\r\n\r\n", $return);

			return empty($returnParsed[1]) ? '' : trim($returnParsed[1]);
		}
	}


	public function importDotaznikReportAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('heureka-import', false))
		{
			$form = $this->formLoad('EshopSettings');
			if ($this->getDotaznikReport()) {

				$form->setResultSuccess("Import recenzí z heureky dokončen.");
				$this->getRequest->goBackRef();
			}
		}
	}
	public function getDotaznikReport()
	{

		if (!$this->heureka_enabled) {
			return;
		}

		$url = "http://www.heureka.cz/direct/dotaznik/export-review.php?key=" . $this->heureka_id;


		$items = simplexml_load_file($url);

		$reviews = $items->review;
		//print_r($reviews);
		//foreach ($reviews as $key => $value) {

		$model = new models_Orders();
		$model->deleteRecords(T_HEUREKA_REPORT);
		for($i=0;$i<count($reviews);$i++){

			$data = array();

			$data["rating_id"] = $reviews[$i]->rating_id;
			$data["name"] 		= isset($reviews[$i]->name) ? $reviews[$i]->name : NULL;
			$data["plus"] = $reviews[$i]->pros;
			$data["minus"] = $reviews[$i]->cons;
			$data["summary"] = $reviews[$i]->summary;
			$data["report_timestamp"] = date("Y-m-d H:i:s",trim($reviews[$i]->unix_timestamp));
			$data["order_code"] = $reviews[$i]->order_id;

			$obj = $model->getDetailByCode($reviews[$i]->order_id);
			if ($obj) {
				$data["order_id"] = $obj->id;
			}

			$data["total_rating"] = $reviews[$i]->total_rating;
			$data["delivery_time"] = $reviews[$i]->delivery_time;
			$data["transport_quality"] = $reviews[$i]->transport_quality;
			$data["web_usability"] = $reviews[$i]->web_usability;
			$data["communication"] = $reviews[$i]->communication;



			$model->insertRecords(T_HEUREKA_REPORT,$data);


			//	print ($reviews[$i]->unix_timestamp) . "-" .date("Y U",$reviews[$i]->unix_timestamp) . "<br />";

			//print date("Y-m-d H:i:s",strtotime($reviews[$i]->unix_timestamp)) . "<br />";

			//print_r($reviews[$i]->rating_id);
		}

			$model = new models_Eshop();
		$model->updateRecords($model->getTableName(), array("value"=>date("Y-m-d H:i:s")), "`key`='HEUREKA_CRON_DATE'");
		return true;

	}

	public function getRecenzeList($params = array())
	{
		$model = new models_HeurekaReport();

		$list = $model->getList($params);
		return $list;
	}
  
  	public function feedGeneratorAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('heurekaProductFeed', false))
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

  
    $ourFileName = PATH_ROOT . 'export/' . "heurekacz.xml";
    file_put_contents($ourFileName, ($feed));
    $key = "HEUREKA_XML_DATE";
    $data = array();
		$data["value"] = date("Y-m-d H:i:s");
          
    $model = new models_Eshop();
    $model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    return true;
    
  }
  
  public function feedList(IListArgs $params)
	{
  
    $productController = new ProductController();
    		$params->neexportovat = 0;
		$params->skladem = 1;
    $params->child = 1;
    $params->order_default = "v.title ASC";
    $params->limit = 1000000;
    $params->page = 1;
    $params->aktivni = 1;
		$list2 = $productController->productList($params);
		$imageController = new ImageController();
		$eshopSettings = G_EshopSetting::instance();
		//$eshopController = new EshopController();
		//$xml = new c_xml_generator;

   // print_r($list2);
   // exit;
		$res='<?xml version="1.0" encoding="utf-8"?' . '>
';
		$res.='<SHOP>
';
		//$root = $xml->add_node(0, 'SHOP');



    $list = array();
    for ($i=0;$i<count($list2);$i++)
		{
    
            new ProductsWrapper($list2[$i]);
        $obj = new StdClass;
        
        $obj->title = $list2[$i]->title;
        $obj->description = $list2[$i]->description;
        $obj->nazev_vyrobce = $list2[$i]->nazev_vyrobce;
        $obj->serial_cat_title = $list2[$i]->serial_cat_title;
        $obj->link = $list2[$i]->link;
        $obj->bazar = $list2[$i]->bazar;
        $obj->hodiny_dostupnost = $list2[$i]->hodiny_dostupnost;
        $obj->dostupnost = $list2[$i]->dostupnost;
        $obj->file = $list2[$i]->file;
        $obj->thumb_abs_link = $list2[$i]->thumb_abs_link;
        $obj->prodcena = $list2[$i]->prodcena;
        $obj->prodcena_sdph = $list2[$i]->prodcena_sdph;
        $obj->value_dph = $list2[$i]->value_dph;
        $obj->ppc_zbozicz = $list2[$i]->ppc_zbozicz;
        
        if (is_array($list2[$i]->variantyList) && count($list2[$i]->variantyList)>0)
        {
        
        //print_r($list2[$i]->variantyList);
        //exit;
          foreach ($list2[$i]->variantyList as $key => $varianta)
          {
          
          
            $obj = new StdClass;
        
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

			$url_img = "<![CDATA[" . $list[$i]->thumb_abs_link . "]]>";
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
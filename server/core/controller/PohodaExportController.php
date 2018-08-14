<?php

class PohodaExportController extends G_Controller_Action {

  public $feedProductFileName = "pohoda_export_produkty.xml";
  public $feedOrderFileName = "pohoda_export_objednavky.xml";
  public $feedFakturyFileName = "pohoda_export_faktury.xml";
  public $zipImagesFileName = "product_images.zip";
  
  	function __construct()
	{

		parent::__construct();
		//$this->getSettings();
	}
  public function exportProducts($args)
  {
    
    	$eshopSettings = G_EshopSetting::instance();
      $ico =    $eshopSettings->get("ICO");
      $model = new models_Products();
      

      
      $cislo_skladu =  $eshopSettings->get("POHODA_ZBOZI_XML_SKLAD");
 /*     $args = new ListArgs();

  		$args->limit = 1;
  		$args->lang = 'cs';
                                 */
      

  //  $params->orderBy = "rand(54545)";
    
    
  		$list = $model->getList($args); 
      
      if (daysToExpirateCms()<=0)
      {
          $list = array();
      }
     //    print $model->getLastQuery();
   /*  print $model->last_query_products;
      print_R($list);
      exit;     */
      
          /*  print_R($list);
      exit;   */
       		$res='<?xml version="1.0" encoding="UTF-8"?' . '>
';
$packId = "OBJ_WEB";
$packId = "zas_web";
//$ico = "88774066";
		// id
		$res.='<dat:dataPack id="' . strtolower($packId). '" ico="' . $ico. '" application="StwTest" version = "2.0" note="Import skladove zasoby"
';
		$res.='xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd"
';
		$res.='xmlns:stk="http://www.stormware.cz/schema/version_2/stock.xsd"
';
		$res.='xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd"
';
		$res.='xmlns:ftr="http://www.stormware.cz/schema/version_2/filter.xsd">
';
         

  /*
    <!-- import skladové položky -->
    <stk:stock version="2.0">
      <stk:stockHeader>
      <!-- typ skladove zasoby -->
      <stk:stockType>card</stk:stockType>
      <stk:code>111</stk:code>
      <stk:EAN></stk:EAN>
      <stk:isSales>false</stk:isSales>
      <stk:isInternet>true</stk:isInternet>
      <stk:news>true</stk:news>
      <stk:sale>false</stk:sale>
      <stk:recommended>true</stk:recommended>
      <stk:purchasingRateVAT>high</stk:purchasingRateVAT>
      <stk:sellingRateVAT>high</stk:sellingRateVAT>
      <stk:name>Fotoaparát OLYMPUS</stk:name>
      <stk:nameComplement></stk:nameComplement>
      <stk:unit>ks</stk:unit>
      <stk:storage>
      <typ:ids>/Hračky</typ:ids>
      </stk:storage><stk:typePrice>
      <typ:ids>SK</typ:ids></stk:typePrice>
      <stk:purchasingPrice>0.000</stk:purchasingPrice>
      <stk:sellingPrice>7064.4628099174</stk:sellingPrice>
      <stk:limitMin>0</stk:limitMin>
      <stk:limitMax>99999</stk:limitMax>
      <stk:mass>0.00</stk:mass>
      <stk:volume></stk:volume>
      <stk:orderName></stk:orderName>
      <stk:orderQuantity>0</stk:orderQuantity>
      <stk:shortName></stk:shortName>
      <stk:producer></stk:producer>
      <stk:yield></stk:yield>
      <stk:description></stk:description>
      <stk:description2></stk:description2>
    <!-- obrazky zasoby -->
    <stk:pictures>
      <stk:picture default="true"><stk:filepath>_vyr_1fotak05.jpg</stk:filepath><stk:description></stk:description></stk:picture>
      <stk:picture default="false"><stk:filepath>_vyrp11_1clothing.png</stk:filepath><stk:description></stk:description></stk:picture>
      <stk:picture default="false"><stk:filepath>_vyrp12_1clothing.png</stk:filepath><stk:description></stk:description></stk:picture>
      <stk:picture default="false"><stk:filepath>_vyrp13_1clothing.png</stk:filepath><stk:description></stk:description></stk:picture>
      <stk:picture default="false"><stk:filepath>_vyrp14_1clothing.png</stk:filepath><stk:description></stk:description></stk:picture>
    </stk:pictures>
    <stk:note>Načteno z XML.</stk:note>
  </stk:stockHeader>
</stk:stock>
</dat:dataPackItem>
*/

        /*  PRINT_R($list);
          EXIT; */
		for ($i=0;$i<count($list);$i++)
		{
    
    
    
        new ProductsWrapper($list[$i]);
        
        $productParams = array();
      /*  
        if ($list[$i]->netto > 0) {
        
          $param = new StdClass();
          $param->id = 10000;
          $param->name = "Hmotnost";
          $param->type = "numberValue";
          $param->value = numberFormat($list[$i]->netto,0);
          
          array_push($productParams,$param);

        }     */
        
        
        
        
        foreach ($list[$i]->attributes as $key => $attrib)
        {
          if (isInt($attrib->pohoda_id))
          {
            $param = new StdClass();
            $param->id = $attrib->pohoda_id;
            $param->name = $attrib->name;
            $param->type = "textValue";
            $param->value = $attrib->value_name;
            array_push($productParams,$param);          
          }

        }
        
        
        for($i2=1;$i2<=10;$i2++) {

        	$polozkaName = "cislo".$i2;
        	$napocet=$i2;
        	if ($i2<10) {
        		$napocet="0".$i2;
        	}
        	$polozkaCheck = "CISLO".$napocet."_CHECK";
        	$polozka2 = "CISLO".$napocet."";
        	$polozkaId = "CISLO".$napocet."_ID";
        	if ($eshopSettings->get($polozkaCheck) == "1" && ($list[$i]->$polozkaName <> 0) && ($eshopSettings->get($polozkaId))!="")
        	{
        		
            $param = new StdClass();
            $param->id = $eshopSettings->get($polozkaId);
            $param->name = $eshopSettings->get($polozka2); 
            $param->type = "numberValue";
            $param->value = numberFormat($list[$i]->$polozkaName,0);
            array_push($productParams,$param);
            
          //  $ParametryContent .= '<div class="row parameters"><div class="col-xs-6"><acronym title="' . $cat->$polozkaName . '" data="' . $value->name . '">' . $translator->prelozitFrazy($eshopSettings->get($polozka2)) . '</acronym>: </div><div class="col-xs-6"><strong>' . numberFormat($cat->$polozkaName,0) . '</strong></div></div>';
        	}
        }
        
        
        
        
        for($i2=1;$i2<=10;$i2++) {

        	$polozkaName = "polozka".$i2;
        	$napocet=$i2;
        	if ($i2<10) {
        		$napocet="0".$i2;
        	}
        	$polozkaCheck = "POLOZKA".$napocet."_CHECK";
        	$polozka2 = "POLOZKA".$napocet."";
          $polozkaId = "POLOZKA".$napocet."_ID";
        	if ($eshopSettings->get($polozkaCheck) == "1" && (!empty($list[$i]->$polozkaName)) && ($eshopSettings->get($polozkaId))!="" )
        	{
        		
            
            $param = new StdClass();
            $param->id = $eshopSettings->get($polozkaId);
            $param->type = "textValue";
            $param->name = $eshopSettings->get($polozka2); 
            $param->value = $list[$i]->$polozkaName;
            array_push($productParams,$param);
            
            //$ParametryContent .= '<div class="row parameters"><strong>' . ($cat->$polozkaName) . '</strong><div class="col-xs-6"><acronym title="' . $cat->$polozkaName . '" data="' . $value->name . '">' . $translator->prelozitFrazy($eshopSettings->get($polozka2)) . '</acronym>: </div></div>';
        	}
        }

         /*    
         print_r($list[$i]);
         print_r($productParams);
         exit;
                   
                    */
               $nazev_vyrobce = "10"; 

      



			$res.='<dat:dataPackItem id="' . strtoupper($packId). $list[$i]->page_id .'" version="2.0">
'; 


			$res.='<!-- import skladove polozky -->
      '; 
			$res.='<stk:stock version="2.0">
      ';
      
      
			$res.='<stk:actionType>
      ';
			$res.='<stk:add update="true">
      ';
			$res.='<ftr:filter>
      ';
              /*
      $res.='<ftr:id>' . strtoupper($packId). $list[$i]->page_id. '</ftr:id>
      ';
                    */
		/*	$res.='<ftr:code>' . $list[$i]->cislo . '</ftr:code>
      ';*/ 
      
      			$res.='<ftr:EAN>' . strtoupper($packId). $list[$i]->page_id . '</ftr:EAN>
      '; 
                              
			$res.='<ftr:storage>
      ';
			$res.='<typ:ids></typ:ids>
      ';
			$res.='</ftr:storage>
      ';
			$res.='</ftr:filter>
      ';
			$res.='</stk:add>
      ';
			$res.='</stk:actionType>
      ';
                
                 
			$res.='<stk:stockHeader>
      '; 
			$res.='<!-- typ skladove zasoby -->
      '; 
      
      
        /*
			$res.='<stk:actionType>update</stk:actionType>
      ';         */
			$res.='<stk:stockType>card</stk:stockType>
      '; 
			$res.='<stk:code>' . $list[$i]->cislo . '</stk:code>
      '; 
			$res.='<stk:EAN>' . strtoupper($packId). $list[$i]->page_id . '</stk:EAN>
      '; 
			$res.='<stk:isSales>false</stk:isSales>
      '; 
			$res.='<stk:isInternet>true</stk:isInternet>
      '; 
			$res.='<stk:news>true</stk:news>
      '; 
			$res.='<stk:sale>false</stk:sale>
      '; 
			$res.='<stk:recommended>true</stk:recommended>
      '; 
			$res.='<stk:purchasingRateVAT>high</stk:purchasingRateVAT>
      '; 
			$res.='<stk:sellingRateVAT>high</stk:sellingRateVAT>
      '; 
			$res.='<stk:name><![CDATA[' . $list[$i]->title . ']]></stk:name>
      '; 
			$res.='<stk:nameComplement><![CDATA[' . $list[$i]->perex . ']]></stk:nameComplement>
      '; 
			$res.='<stk:unit>' . $list[$i]->nazev_mj . '</stk:unit>'
      ; 
			$res.='<stk:storage>
      '; 
			$res.='<typ:ids>' . $cislo_skladu . '</typ:ids>'; 
			$res.='</stk:storage>
      ';
      $res.='<stk:typePrice>
      '; 
			$res.='<typ:ids>SK</typ:ids>
      '; 
      $res.='</stk:typePrice>
      ';                            
			$res.='<stk:purchasingPrice>' . $list[$i]->nakupni_cena . '</stk:purchasingPrice>
      '; 
			$res.='<stk:sellingPrice>' . $list[$i]->prodcena . '</stk:sellingPrice>
      '; 
			$res.='<stk:limitMin>0</stk:limitMin>
      '; 
			$res.='<stk:limitMax>99999</stk:limitMax>
      '; 
      
      if ($list[$i]->netto > 0) {
			$res.='<stk:mass>' . $list[$i]->netto . '</stk:mass>
      '; 
      
      }
			$res.='<stk:volume>' . $list[$i]->objem . '</stk:volume>
      '; 
      $res.='<stk:orderName></stk:orderName>
      '; 
      $res.='<stk:orderQuantity>0</stk:orderQuantity>
      '; 
      $res.='<stk:shortName></stk:shortName>
      '; 
      $res.='<stk:producer></stk:producer>
      '; 
      $res.='<stk:yield></stk:yield>
      '; 
      $res.='<stk:description><![CDATA[' . $list[$i]->description . ']]></stk:description>
      '; 
      $res.='<stk:description2></stk:description2>
      '; 
      
    /*  $res.='<stk:parameters>
      '; */
         
    $res.='<stk:intParameters>
    ';          

        /* <ipm:intParamDetail version="2.0">
         <ipm:intParam>
         <ipm:name>NAME</ipm:name>
         <ipm:parameterType>textValue</ipm:parameterType>
         <ipm:parameterSettings>
         <ipm:length>40</ipm:length>
         </ipm:parameterSettings>
         </ipm:intParam>
         </ipm:intParamDetail>   */
         
     foreach ($productParams as $key => $param)
     {
      
          $res.='<stk:intParameter>
    ';   
    

        $res.='<stk:intParameterID><![CDATA[' . $param->id . ']]></stk:intParameterID>
      ';        
        $res.='<stk:intParameterName><![CDATA[' . $param->name . ']]></stk:intParameterName>
      ';        
        $res.='<stk:intParameterType><![CDATA[' . $param->type . ']]></stk:intParameterType>
      ';       
      
      
    $res.='<stk:intParameterValues>
    ';            
    $res.='<stk:intParameterValue>
    ';          

      $res.='<stk:parameterValue><![CDATA[' . $param->value . ']]></stk:parameterValue>
    '; 
              $res.='</stk:intParameterValue>
    ';         
              $res.='</stk:intParameterValues>
    ';   
                $res.='</stk:intParameter>
    '; 
    
     /*
       <stk:intParameters>
        <stk:intParameter>
       <stk:intParameterID>1</stk:intParameterID>
       <stk:intParameterType>numberValue</stk:intParameterType>
       <stk:intParameterValues>
       <stk:intParameterValue>
        <stk:parameterValue>VALUE1</stk:parameterValue>
        </stk:intParameterValue>
        </stk:intParameterValues>
        </stk:intParameter>
        </stk:intParameters></stk:stockHeader></stk:stock>');   */
     }   


    /*
    
    $res.='<stk:intParameterID><![CDATA[' . $list[$i]->file . ']]></stk:intParameterID>
    '; 
    
    $res.='<stk:intParameterName><![CDATA[' . $list[$i]->file . ']]></stk:intParameterName>
    '; 
    
    
        $res.='<stk:intParameterValue><![CDATA[' . $list[$i]->file . ']]></stk:intParameterValue>
    '; 
        
      $res.='</stk:parameters>
      ';  */
      
          $res.='</stk:intParameters>
    '; 
    
        
     // <xsd:element name="parameters" type="typ:parametersType" minOccurs="0">
     //<xsd:annotation><xsd:documentation>Volitelný parametr.</xsd:documentation></xsd:annotation></xsd:element>
      
      
    $res.='<!-- obrazky zasoby -->
    '; 
    $res.='<stk:pictures>
    '; 
    //' . $list[$i]->dir . '
      $res.='<stk:picture default="true"><stk:filepath><![CDATA[' . $list[$i]->file . ']]></stk:filepath><stk:description><![CDATA[' . $list[$i]->thumb_abs_link . ']]></stk:description></stk:picture>
      '; 

    $res.='</stk:pictures>
    '; 
    $res.='<stk:note>Načteno z XML.</stk:note>
    '; 
  $res.='</stk:stockHeader>
  '; 
$res.='</stk:stock>
'; 
$res.='</dat:dataPackItem>
'; 


    }
    
    
     			$res.='</dat:dataPack>
';
		return $res;
    
  }
  
	public function productListPohodaFeedGeneratorAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('pohodaProductFeed', false))
		{
         /*
        		$model = new models_Eshop();

		$data = array();
		$data["value"] = date("Y-m-d H:i:s");
    $key = "POHODA_ZBOZI_XML_SKLAD";
		//print $value;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    */
       
        if ($this->productListPohodaFeedGenerator())
        {
            $this->getRequest->goBackRef();
        }
        
        
    }
  }
  
  
  public function productImagesZipGeneratorAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('productImagesZip', false))
		{
        
        if ($this->productImagesZipGenerator())
        {
            //$this->getRequest->goBackRef();
        }
        
        
    }
  }

  public function productImagesZipGenerator()
  {
   /* $params = new ListArgs();
    $params->limit = 1000000;
    $params->page = 1;
    $params->aktivni = 1;
    $params->neexportovat = 0;
    //$params->kategorie = 1;
    $params->child = 1;
    $params->lang = "cs";
    $params->order_default = "v.title ASC";
    */
    
    
    $args = new FotoPlacesListArgs();
    $args->limit = 100000;
    $feed = $this->exportImages($args);

    
 		$model = new models_Eshop();

		$data = array();
		$data["value"] = date("Y-m-d H:i:s");
    $key = "PRODUCT_IMG_ZIP_DATE";
		//print $value;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    return true;
  
  }
    
  public function productListPohodaFeedGenerator()
  {
          $params = new ListArgs();
    $params->limit = 100000;
    $params->page = 1;
    $params->aktivni = 1;
 //   $params->neexportovat = 0;
    //$params->kategorie = 1;
 //   $params->child = 1;
    $params->withAttribs = true;
    //$params->page_id = 1263;
    $params->lang = "cs";
    $params->order_default = "v.title ASC";
    $feed = $this->exportProducts($params);

  
    $ourFileName = PATH_ROOT . 'export/' . $this->feedProductFileName;
    file_put_contents($ourFileName, ($feed));
    
 		$model = new models_Eshop();

		$data = array();
		$data["value"] = date("Y-m-d H:i:s");
    $key = "POHODA_ZBOZI_XML_DATE";
		//print $value;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    return true;
  
  }
  
  public function objednavkyListPohodaFeedGeneratorAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('pohodaOrderFeed', false))
		{
        
        if ($this->objednavkyListPohodaFeedGenerator())
        {
            $this->getRequest->goBackRef();
        }
        
        
    }
  }
  
  public function fakturyListPohodaFeedGeneratorAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('pohodaFakturyFeed', false))
		{
        
        if ($this->fakturyListPohodaFeedGenerator())
        {
            $this->getRequest->goBackRef();
        }
        
        
    }
  }
  
  
  
  public function objednavkyListPohodaFeedGenerator()
  {
   /* $params = new ListArgs();
    $params->limit = 1000000;
    $params->page = 1;
    $params->aktivni = 1;
    $params->neexportovat = 0;
    //$params->kategorie = 1;
    $params->child = 1;
    $params->lang = "cs";
    $params->order_default = "v.title ASC";
    */
    
    $form = $this->formLoad('EshopSettings');

    
    $postdata = $form->getValues();
    
     $fcode = $postdata["POHODA_OBJ_XML_FCODE"];
     $args = new ObjednavkaListArgs();
      $args->limit = 10000;
     	$args->code_from = $postdata["POHODA_OBJ_XML_FCODE"];
     	$args->code_to = $postdata["POHODA_OBJ_XML_TCODE"];
     	$args->stav = $postdata["POHODA_OBJ_XML_STAV"];
     	$args->storno = 0;
        
     	$args->df = $postdata["POHODA_OBJ_XML_FDATE"];
     	$args->dt = $postdata["POHODA_OBJ_XML_TDATE"];
    
      //  print_r($args);
      //  exit;
    $feed = $this->exportObjednavek($args);

  
    $ourFileName = PATH_ROOT . 'export/' . $this->feedOrderFileName;
    file_put_contents($ourFileName, ($feed));
    
 		$model = new models_Eshop();

		$data = array();
		$data["value"] = date("Y-m-d H:i:s");
    $key = "POHODA_OBJ_XML_DATE";
		//print $value;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

    $name = "POHODA_OBJ_XML_STAV";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
        
    $name = "POHODA_OBJ_XML_FCODE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    $name = "POHODA_OBJ_XML_TCODE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    $name = "POHODA_OBJ_XML_FDATE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    $name = "POHODA_OBJ_XML_TDATE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
        
    return true;
  
  }
  
  public function fakturyListPohodaFeedGenerator()
  {
   /* $params = new ListArgs();
    $params->limit = 1000000;
    $params->page = 1;
    $params->aktivni = 1;
    $params->neexportovat = 0;
    //$params->kategorie = 1;
    $params->child = 1;
    $params->lang = "cs";
    $params->order_default = "v.title ASC";
    */
    
    $form = $this->formLoad('EshopSettings');

    
    $postdata = $form->getValues();
    
     $fcode = $postdata["POHODA_FAK_XML_FCODE"];
     $args = new ListArgs();
      $args->limit = 10000;
     	$args->code_from = $postdata["POHODA_FAK_XML_FCODE"];
     	$args->code_to = $postdata["POHODA_FAK_XML_TCODE"];
     	$args->stav = $postdata["POHODA_FAK_XML_STAV"];
     	$args->storno = 0;
        
     	$args->df = $postdata["POHODA_FAK_XML_FDATE"];
     	$args->dt = $postdata["POHODA_FAK_XML_TDATE"];
    
      //  print_r($args);
      //  exit;
    $feed = $this->exportFaktur($args);

  
    $ourFileName = PATH_ROOT . 'export/' . $this->feedFakturyFileName;
    file_put_contents($ourFileName, ($feed));
    
 		$model = new models_Eshop();

		$data = array();
		$data["value"] = date("Y-m-d H:i:s");
    $key = "POHODA_FAK_XML_DATE";
		//print $value;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

    $name = "POHODA_FAK_XML_STAV";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
        
    $name = "POHODA_FAK_XML_FCODE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    $name = "POHODA_FAK_XML_TCODE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    $name = "POHODA_FAK_XML_FDATE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
    
    $name = "POHODA_FAK_XML_TDATE";
    $data["value"] = $postdata[$name];
    $key = $name;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
        
    return true;
  
  }
  public function objednavkyListPohodaFeedOnlineGenerator($args)
  {

    $feed = $this->exportObjednavek($args);

    return $feed;
  
  }

  public function productListPohodaFeedOnlineGenerator($args)
  {
  
              $params = new ListArgs();
    $params->limit = 100000;
    $params->page = 1;
    $params->aktivni = 1;
 //   $params->neexportovat = 0;
    //$params->kategorie = 1;
 //   $params->child = 1;
    $params->withAttribs = true;
  //  $params->page_id = 8780;
    $params->lang = "cs";
    $params->order_default = "v.title ASC";

    $feed = $this->exportProducts($params);

    return $feed;
  
  }
  public function exportImages($args)
  {
     ini_set("max_execution_time", 900);
    // create object
    $zip = new ZipArchive();
    // open archive
    $ourFileName = PATH_ROOT . 'export/' . $this->zipImagesFileName;
    if ($zip->open($ourFileName, ZIPARCHIVE::CREATE) !== TRUE) {
    die ("Could not open archive");
    }

      $model = new models_FotoPlaces();
      $list = $model->getProductImagesList($args);
             if (daysToExpirateCms()<=0)
      {
          $list = array();
      }
      for ($i=0;$i<count($list);$i++){
  
             $file = PATH_IMG . $list[$i]->dir . $list[$i]->file;
           //     print $file . "<br />"; 
        if (file_exists($file) && is_file($file)){
      
         //$zip->addFile(realpath($key), $key) or die ("ERROR: Could not add file: $key");
         
         $zip->addFile($file,basename($file)) or die ("ERROR: Could not add file: $file");
        }
      }
      
      $zip->close();
      return count($list); 
      
  }  
	public function exportFaktur($args)
	{


		$model = new models_Faktury();
    
    $modelDetail = new models_RadekFaktury();

		$list = $model->getList($args);
    if (count($list) > 0)
    {
      
    } else {
      return false;
    }
    
          if (daysToExpirateCms()<=0)
      {
          $list = array();
      }
	//	print_r($list);
	//	exit;
		$res='<?xml version="1.0" encoding="UTF-8"?' . '>
';
$packId = "FAK_WEB";
    		$eshopSettings = G_EshopSetting::instance();
    $ico =    $eshopSettings->get("ICO");
		// id
		$res.='<dat:dataPack id="' . strtolower($packId). '" ico="' . $ico. '" application="StwTest" version = "2.0" note="Import Faktur"
';
		$res.='xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd"
';
		$res.='xmlns:inv="http://www.stormware.cz/schema/version_2/invoice.xsd"
';
		$res.='xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd"
';
		$res.='>
';



		for ($i=0;$i<count($list);$i++)
		{
    
			$res.='<dat:dataPackItem id="' . strtoupper($packId). $list[$i]->id .'" version="2.0">
';    
    
    		$params = new ListArgs();
		$params->doklad_id = (int) $list[$i]->id;
		$params->limit = 1000;
		$order_details = $modelDetail->getList($params);
     //  print_r($order_details);
    //   exit;
			//$item  = $xml->add_node($root, 'SHOPITEM');

      /*
      <inv:invoice version="2.0">
          <inv:invoiceHeader>
      <inv:invoiceType>issuedInvoice</inv:invoiceType>
      <inv:number>
        <typ:numberRequested>11000002</typ:numberRequested>
      </inv:number>
      <inv:symVar>10321</inv:symVar>
      <inv:date>2018-02-22</inv:date>
      <inv:dateTax>2018-02-22</inv:dateTax>
      <inv:dateDue>2018-02-22</inv:dateDue>
      <inv:accounting>
        <typ:ids>3Fv</typ:ids>
      </inv:accounting>
      <inv:classificationVAT>
        <typ:ids>UD</typ:ids>
      </inv:classificationVAT>
      <inv:text>Fakturujeme Vám zboží dle Vaší objednávky:</inv:text>
      <inv:paymentType>
        <typ:paymentType>delivery</typ:paymentType>
      </inv:paymentType>
      <inv:note>Načteno z XML</inv:note>
      <inv:intNote></inv:intNote>
      <inv:partnerIdentity>
      */

			$res.='<inv:invoice version="2.0">
';
			$res.='<inv:invoiceHeader>
';
			$res.='<inv:invoiceType>issuedInvoice</inv:invoiceType>
';
			$res.='<inv:number>
';
			$res.='<typ:numberRequested>' . $list[$i]->code. '</typ:numberRequested>
';
			$res.='</inv:number>
';



			$res.='<inv:symVar>' . $list[$i]->code. '</inv:symVar>
';
			//2014-10-14
			$res.='<inv:date>' . date("Y-m-d",strtotime($list[$i]->order_date)) . '</inv:date>
';
			//2014-10-14
			$res.='<inv:dateTax>' . date("Y-m-d",strtotime($list[$i]->order_date)) . '</inv:dateTax>
';
			//2014-10-14
			$res.='<inv:dateDue>' . date("Y-m-d",strtotime($list[$i]->order_date)) . '</inv:dateDue>
';
			//Objedn�v�me u V�s zbo�� dle �stn� dohody
			$res.='<inv:text>' . $list[$i]->description. '</inv:text>
';

			$res.='<inv:accounting>
';
			$res.='<typ:ids>3Fv</typ:ids>
';
			$res.='</inv:accounting>
';
			$res.='<inv:classificationVAT>
';
			$res.='<typ:ids>UD</typ:ids>
';
			$res.='</inv:classificationVAT>
';
      
			$res.='<inv:partnerIdentity>
';


			$res.='<typ:address>
';
			$res.='<typ:company><![CDATA[' . $list[$i]->shipping_first_name . ']]></typ:company>
';
			$res.='<typ:division></typ:division>
';
			$res.='<typ:name><![CDATA[' . $list[$i]->shipping_last_name . ']]></typ:name>
';
			$res.='<typ:city><![CDATA[' . $list[$i]->shipping_city . ']]></typ:city>
';
			$res.='<typ:street><![CDATA[' . $list[$i]->shipping_address_1 . ']]></typ:street>
';
			$res.='<typ:zip><![CDATA[' . $list[$i]->shipping_zip_code . ']]></typ:zip>
';
			$res.='<typ:ico><![CDATA[' . $list[$i]->shipping_ico . ']]></typ:ico>
';
			$res.='<typ:dic><![CDATA[' . $list[$i]->shipping_dic . ']]></typ:dic>
';


			$res.='<typ:phone><![CDATA[' . $list[$i]->shipping_phone . ']]></typ:phone>
';
			$res.='<typ:email><![CDATA[' . $list[$i]->shipping_email . ']]></typ:email>
';

			$res.='</typ:address>
';
			$res.='</inv:partnerIdentity>
';

			$res.='<inv:paymentType>
';
         /*
<![CDATA[Převodem z účtu]]></typ:paymentType>
Převodem z účtu porušuje omezení enumeration pro draft cash postal delivery creditcard advance encashment cheque compensation.
*/
			//hotově
      $res.='<typ:paymentType><![CDATA[' . $list[$i]->nazev_platby . ']]></typ:paymentType>
';
			$res.='</inv:paymentType>
';
/*
			$res.='<ord:priceLevel>
';
			$res.='<typ:ids>Sleva 1</typ:ids>
';
			$res.='</ord:priceLevel>
';    */
			$res.='</inv:invoiceHeader>
';


			$res.='<inv:invoiceDetail>
';
foreach ($order_details as $key => $row){


		//	<!--textova polozka-->
			$res.='<inv:invoiceItem>
';
			// Sestava PC
			$res.='<inv:text><![CDATA['.$row->product_name.']]></inv:text>
';
			// 1
			$res.='<inv:quantity>'.$row->qty.'</inv:quantity>
';
			$res.='<inv:delivered>0</inv:delivered>
';
 if ($row->tax_name == "21%"){
			$res.='<inv:rateVAT>high</inv:rateVAT>
';
  } 

			$res.='<inv:homeCurrency>
';
			// 200
      if (is_null($row->price))
      {
        $row->price = 0;
      }
			$res.='<typ:unitPrice>'.strToNumeric($row->price).'</typ:unitPrice>
';
			$res.='</inv:homeCurrency>
';

			$res.='<inv:unit><![CDATA['. $row->nazev_mj . ']]></inv:unit>
';
if ($row->sleva<>0)
{ 
      
        
			$res.='<inv:discountPercentage>' . ($row->sleva*-1) . '</inv:discountPercentage>
';
}
    

			$res.='</inv:invoiceItem>
';
  /*    if (is_null($row->price))
      {
			$res.='<ord:discountPercentage>10</ord:discountPercentage>
';
} */

     
}

		/*
			<!--skladova polozka-->
			<ord:orderItem>
			<ord:quantity>1</ord:quantity>
			<ord:delivered>0</ord:delivered>
			<ord:rateVAT>high</ord:rateVAT>
			<ord:homeCurrency>
			<typ:unitPrice>198</typ:unitPrice>
			</ord:homeCurrency>
			<ord:stockItem>
			<typ:stockItem>
			<typ:ids>STM</typ:ids>
			</typ:stockItem>
			</ord:stockItem>
			</ord:orderItem>
			</ord:orderDetail>
			*/


			$res.='</inv:invoiceDetail>
';
			$res.='<inv:invoiceSummary>
';
			$res.='<inv:roundingDocument>math2one</inv:roundingDocument>
';
			$res.='</inv:invoiceSummary>
';
			$res.='</inv:invoice>
';

			$res.='</dat:dataPackItem>
';
		}
    


 			$res.='</dat:dataPack>
';
		return $res;
	}
  
  
  	public function exportObjednavek($args)
	{


		$model = new models_Orders();
    
    $modelDetail = new models_OrderDetails();

		$list = $model->getList($args);
    if (count($list) > 0)
    {
      
    } else {
      return false;
    }
    
          if (daysToExpirateCms()<=0)
      {
          $list = array();
      }
	//	print_r($list);
	//	exit;
		$res='<?xml version="1.0" encoding="UTF-8"?' . '>
';
$packId = "OBJ_WEB";
$packId = "OBJ_WEB";
    		$eshopSettings = G_EshopSetting::instance();
    $ico =    $eshopSettings->get("ICO");
		// id
		$res.='<dat:dataPack id="' . strtolower($packId). '" ico="' . $ico. '" application="StwTest" version = "2.0" note="Import Objednávky"
';
		$res.='xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd"
';
		$res.='xmlns:ord="http://www.stormware.cz/schema/version_2/order.xsd"
';
		$res.='xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd">
';
/*
		$res.='xmlns:inv="http://www.stormware.cz/schema/version_2/invoice.xsd">
';
       */



		for ($i=0;$i<count($list);$i++)
		{
    
			$res.='<dat:dataPackItem id="' . $list[$i]->code .'" version="2.0">
';    
    
    		$params = new ListArgs();
		$params->doklad_id = (int) $list[$i]->id;
		$params->limit = 1000;
		$order_details = $modelDetail->getList($params);
     //  print_r($order_details);
    //   exit;
			//$item  = $xml->add_node($root, 'SHOPITEM');


			$res.='<ord:order version="2.0">
';
			$res.='<ord:orderHeader>
';
			$res.='<ord:orderType>receivedOrder</ord:orderType>
';
			$res.='<ord:number>
';
			$res.='<typ:numberRequested checkDuplicity="true">' . $list[$i]->code. '</typ:numberRequested>
';
			$res.='</ord:number>
';
			$res.='<ord:numberOrder>' . $list[$i]->code. '</ord:numberOrder>
';
			//2014-10-14
			$res.='<ord:date>' . date("Y-m-d",strtotime($list[$i]->order_date)) . '</ord:date>
';
			//2014-10-14
			$res.='<ord:dateFrom>' . date("Y-m-d",strtotime($list[$i]->order_date)) . '</ord:dateFrom>
';
			//2014-10-14
			$res.='<ord:dateTo>' . date("Y-m-d",strtotime($list[$i]->order_date)) . '</ord:dateTo>
';
			//Objedn�v�me u V�s zbo�� dle �stn� dohody
			$res.='<ord:text>' . $list[$i]->description. '</ord:text>
';
			$res.='<ord:partnerIdentity>
';


			$res.='<typ:address>
';
			$res.='<typ:company><![CDATA[' . $list[$i]->shipping_first_name . ']]></typ:company>
';
			$res.='<typ:division></typ:division>
';
			$res.='<typ:name><![CDATA[' . $list[$i]->shipping_last_name . ']]></typ:name>
';
			$res.='<typ:city><![CDATA[' . $list[$i]->shipping_city . ']]></typ:city>
';
			$res.='<typ:street><![CDATA[' . $list[$i]->shipping_address_1 . ']]></typ:street>
';
			$res.='<typ:zip><![CDATA[' . $list[$i]->shipping_zip_code . ']]></typ:zip>
';
			$res.='<typ:ico><![CDATA[' . $list[$i]->shipping_ico . ']]></typ:ico>
';
			$res.='<typ:dic><![CDATA[' . $list[$i]->shipping_dic . ']]></typ:dic>
';


			$res.='<typ:phone><![CDATA[' . $list[$i]->shipping_phone . ']]></typ:phone>
';
			$res.='<typ:email><![CDATA[' . $list[$i]->shipping_email . ']]></typ:email>
';

			$res.='</typ:address>
';

              
			$res.='<typ:shipToAddress>
';
			$res.='<typ:company><![CDATA[' . $list[$i]->shipping_first_name2 . ']]></typ:company>
';
			$res.='<typ:name><![CDATA[' . $list[$i]->shipping_last_name2 . ']]></typ:name>
';
			$res.='<typ:city><![CDATA[' . $list[$i]->shipping_city2 . ']]></typ:city>
';
			$res.='<typ:street><![CDATA[' . $list[$i]->shipping_address_12 . ']]></typ:street>
';
			$res.='<typ:zip><![CDATA[' . $list[$i]->shipping_zip_code2 . ']]></typ:zip>
';
			$res.='</typ:shipToAddress>
';
      
                    
                    
			$res.='</ord:partnerIdentity>
';

			$res.='<ord:paymentType>
';
			//hotově
      $res.='<typ:ids><![CDATA[' . substr($list[$i]->nazev_platby,0,20) . ']]></typ:ids>
';
			$res.='</ord:paymentType>
';
/*
			$res.='<ord:priceLevel>
';
			$res.='<typ:ids>Sleva 1</typ:ids>
';
			$res.='</ord:priceLevel>
';    */
			$res.='</ord:orderHeader>
';


			$res.='<ord:orderDetail>
';

               /*   
print_r($order_details);
exit;   */    
foreach ($order_details as $key => $row){
/*
print_r($row);
exit;
     */

		//	<!--textova polozka-->
			$res.='<ord:orderItem>
';
     
if ($row->product_id > 0) {

      $res.='<ord:stockItem>';
      $res.='<typ:stockItem>';
       $res.='<typ:ids><![CDATA['.$row->product_code.']]></typ:ids>';
       $res.='</typ:stockItem>';
       $res.='</ord:stockItem>';
                    
 		//	$res.='<typ:stockItem><![CDATA['.$row->product_code.']]></typ:stockItem>
//'; 
}   /**/

			// Sestava PC
			$res.='<ord:code><![CDATA['.$row->product_code.']]></ord:code>
';
			// Sestava PC
			$res.='<ord:text><![CDATA['.$row->product_name.']]></ord:text>
';
			// 1
			$res.='<ord:quantity>'.$row->qty.'</ord:quantity>
';

      // dodáno Ano/Ne 1/0
			$res.='<ord:delivered>0</ord:delivered>
';

 
 if ($row->tax_name == "21%"){
			$res.='<ord:rateVAT>high</ord:rateVAT>
';
  }      
			$res.='<ord:homeCurrency>
';

//carrier = dopravce

                  /*
			$res.='<ord:payVAT>true</ord:payVAT>
';     */
			// 200
      if (is_null($row->price))
      {
        $row->price = 0;
      }
			$res.='<typ:unitPrice>'.strToNumeric($row->price).'</typ:unitPrice>
';
			$res.='</ord:homeCurrency>
';

			$res.='<ord:unit><![CDATA['. $row->nazev_mj . ']]></ord:unit>
';
if ($row->sleva<>0)
{ 
      
        
			$res.='<ord:discountPercentage>' . ($row->sleva*-1) . '</ord:discountPercentage>
';
}



			$res.='</ord:orderItem>
';

}

		/*
			<!--skladova polozka-->
			<ord:orderItem>
			<ord:quantity>1</ord:quantity>
			<ord:delivered>0</ord:delivered>
			<ord:rateVAT>high</ord:rateVAT>
			<ord:homeCurrency>
			<typ:unitPrice>198</typ:unitPrice>
			</ord:homeCurrency>
			<ord:stockItem>
			<typ:stockItem>
			<typ:ids>STM</typ:ids>
			</typ:stockItem>
			</ord:stockItem>
			</ord:orderItem>
			</ord:orderDetail>
			*/


			$res.='</ord:orderDetail>
';
			$res.='<ord:orderSummary>
';
			$res.='<ord:roundingDocument>math2one</ord:roundingDocument>
';
			$res.='</ord:orderSummary>
';
			$res.='</ord:order>
';

			$res.='</dat:dataPackItem>
';
		}
    


 			$res.='</dat:dataPack>
';
		return $res;
	}
}

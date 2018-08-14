<?php

class ProductPublicTabs extends G_Tabs {

  public $product;
	public function __construct($product)
	{
		parent::__construct();


    $translator = G_Translator::instance();


		$this->product = $product;




	//	$tab = array("name" => "Param", "title" => "Parametry","content" => $this->ParametryTab() );
	//	$this->addTab($tab,true);

    $attributes = $this->product->attributes;
    
    
    
      $eshopSettings = G_EshopSetting::instance();
  //  $translator = G_Translator::instance();
		$cat = $this->product;  
    
     if (!is_array($attributes))
     {
          $attributes = array();
     }
    
       //print_r($attributes);
for($i=1;$i<=10;$i++) {

	$polozkaName = "cislo".$i;
	$napocet=$i;
	if ($i<10) {
		$napocet="0".$i;
	}
	$polozkaCheck = "CISLO".$napocet."_CHECK";
  $polozkaSecret = "CISLO".$napocet."_SECRET";
	$polozka2 = "CISLO".$napocet."";
	if ($eshopSettings->get($polozkaCheck) == "1" && $eshopSettings->get($polozkaSecret) == "0" &&  ($cat->$polozkaName <> 0))
	{
  
    $obj = new StdClass();
    $obj->name = $translator->prelozitFrazy($eshopSettings->get($polozka2)) ;
    $obj->value_name = numberFormat($cat->$polozkaName,0);
    array_push($attributes,$obj) ;
    
	//	$ParametryContent .= '<div class="row parameters"><div class="col-xs-6"><acronym title="' . $cat->$polozkaName . '" data="' . $value->name . '">' . $translator->prelozitFrazy($eshopSettings->get($polozka2)) . '</acronym>: </div><div class="col-xs-6"><strong>' . numberFormat($cat->$polozkaName,0) . '</strong></div></div>';
	}
}

for($i=1;$i<=10;$i++) {

	$polozkaName = "polozka".$i;
	$napocet=$i;
	if ($i<10) {
		$napocet="0".$i;
	}
	$polozkaCheck = "POLOZKA".$napocet."_CHECK";
	$polozkaSecret = "POLOZKA".$napocet."_SECRET";
	$polozka2 = "POLOZKA".$napocet."";

	if ($eshopSettings->get($polozkaCheck) == "1" && $eshopSettings->get($polozkaSecret) == "0" &&  ($cat->$polozkaName <> 0))
	{
  
      $obj = new StdClass();
    $obj->name = $translator->prelozitFrazy($eshopSettings->get($polozka2)) ;
    $obj->value_name = $cat->$polozkaName;
    array_push($attributes,$obj) ;
    
	//	$ParametryContent .= '<div class="row parameters"><div class="col-xs-6"><acronym title="' . $cat->$polozkaName . '" data="' . $value->name . '">' . $translator->prelozitFrazy($eshopSettings->get($polozka2)) . '</acronym>: </div><div class="col-xs-6"><strong>' . ($cat->$polozkaName) . '</strong></div></div>';
	}
}

   $this->product->attributes =   $attributes;


    $files = $this->product->files;
     //     print_r($attributes);
        if (count($files)>0)
    {
    		$tab = array("name" => "Files", "title" => $translator->prelozitFrazy("soubory"),"content" => $this->FilesTab() );
    		$this->addTab($tab,true);
    }
    
    if (count($attributes)>0)
    {
    		$tab = array("name" => "Main", "title" => $translator->prelozitFrazy("parametry"),"content" => $this->MainTab() );
    		$this->addTab($tab,true);
    }
        
    if (!empty($product->description)) {
    		$tab = array("name" => "Description", "title" => $translator->prelozitFrazy("popis"),"content" => $this->DescriptionTab() );
    		$this->addTab($tab,true);
    }
    

      
      





	}

  protected function FilesTab()
	{

		$files = $this->product->files;
    $contentMain = '';
    foreach ($files as $key => $file){
        new FilesWrapper($file);
        $contentMain .= $file->file;
    }

		
		return $contentMain;

	}
	protected function MainTab()
	{
    $eshopSettings = G_EshopSetting::instance();
    $translator = G_Translator::instance();
		$cat = $this->product;
		$attributes = $this->product->attributes;

$ParametryContent = '';
   
if ($cat->netto > 0) {
	$ParametryContent .= '<div class="row parameters"><div class="col-xs-6"><acronym title="' . $cat->netto . '" data="' . $cat->netto . '">' . $translator->prelozitFrazy("Hmotnost") . '</acronym>: </div><div class="col-xs-6"><strong>' . numberFormat($cat->netto,0) . ' Kg</strong></div></div>';
}

foreach ($attributes as $key => $value){

	/*	if ($value->id == 3) {
	   $relativesProductAttributeId = $value->attribute_id;
	   $relativesProductAttributeName = $value->value_name;
	   }*/
	if (!empty($value->value_name)) {

		$ParametryContent .= '<div class="row parameters"><div class="col-xs-6"><acronym class="" title="' . $value->value_name . '" data="' . $value->name . '">' . $value->name . '</acronym>: </div><div class="col-xs-6"><strong>' . $value->value_name . '</strong></div></div>';
	}
}
     /*
for($i=1;$i<=10;$i++) {

	$polozkaName = "cislo".$i;
	$napocet=$i;
	if ($i<10) {
		$napocet="0".$i;
	}
	$polozkaCheck = "CISLO".$napocet."_CHECK";
	$polozka2 = "CISLO".$napocet."";
	if ($eshopSettings->get($polozkaCheck) == "1" && ($cat->$polozkaName <> 0))
	{
		$ParametryContent .= '<div class="row parameters"><div class="col-xs-6"><acronym title="' . $cat->$polozkaName . '" data="' . $value->name . '">' . $translator->prelozitFrazy($eshopSettings->get($polozka2)) . '</acronym>: </div><div class="col-xs-6"><strong>' . numberFormat($cat->$polozkaName,0) . '</strong></div></div>';
	}
}

for($i=1;$i<=10;$i++) {

	$polozkaName = "polozka".$i;
	$napocet=$i;
	if ($i<10) {
		$napocet="0".$i;
	}
	$polozkaCheck = "POLOZKA".$napocet."_CHECK";
	$polozka2 = "POLOZKA".$napocet."";

	if ($eshopSettings->get($polozkaCheck) == "1" && ($cat->$polozkaName <> 0))
	{
		$ParametryContent .= '<div class="row parameters"><div class="col-xs-6"><acronym title="' . $cat->$polozkaName . '" data="' . $value->name . '">' . $translator->prelozitFrazy($eshopSettings->get($polozka2)) . '</acronym>: </div><div class="col-xs-6"><strong>' . ($cat->$polozkaName) . '</strong></div></div>';
	}
}
         */
		return $ParametryContent;
	}

	protected function DescriptionTab()
	{

		$cat = $this->product;

		$contentMain .= $cat->description;
		return $contentMain;

	}



	public function makeTabs($tabs = array()) {

		return parent::makeTabs($tabs);
	}

}
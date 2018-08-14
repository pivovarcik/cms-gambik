<?php
/**
 * Společný předek pro formuláře katalog firem
 * */


require_once("CatalogForm.php");
abstract class CatalogFiremForm extends CatalogForm
{

	function __construct($model)
	{
		$this->category_root = 1;
		$this->ignore_category = array(8,7,18,3,2,13,5,4,6,19,20,21,22,23,26,27,28);
		parent::__construct($model);

		$this->loadModel($model);



	   $this->categoryTreeList = array();
	   //	if ($this->category_root > 0) {
	   $tree = new G_Tree();
	   //	print $this->category_root . "<br />";
	   $this->categoryTreeList = $tree->categoryTree(array(
	   "parent"=>$this->category_root,
	   "debug"=>0,
	   ));

	//	print_r($this->categoryTreeList);


		//parent::loadModel($model);

		//$this->loadElements();

	}

	// načte datový model
	public function loadElements()
	{

		parent::loadElements();

		$catalog = $this->page;

		$page_id = 0;
		if ($this->page_id) {
			$page_id = $this->page_id;
		}

		$name = "mesto_id";
		$elem = new G_Form_Element_Hidden($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','mesto_id');

		$this->addElement($elem);



		$tree = new G_CiselnikTree("ProductCenik");
		$productCenikList = $tree->categoryTree();

		$name = "cenik_id";
		   $elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $catalog->$name);
		   $elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ceník:');
		$elem->setAttribs('class','selectbox');
		   $pole = array();
		$pole[0] = " -- neuveden -- ";
		foreach ($productCenikList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);


		$modelProgram = new models_CatalogProgram();
		$program = $modelProgram->get_catalogProgramList($page_id);

		//print_r($program);
		$modelVybaveni = new models_CatalogVybaveni();
		$vybaveni = $modelVybaveni->get_catalogVybaveniList($page_id);

		for($i=0; $i<count($vybaveni);$i++){
			$elem = new G_Form_Element_Checkbox("vybaveni[$i]");
			$elem->setAnonymous();
			$value2 = $this->Request->getPost("vybaveni[$i]", $vybaveni[$i]->checked);
			$elem->setAttribs('value', $vybaveni[$i]->id);

			if ($value2 > 0) {
				$elem->setAttribs('checked','checked');
			}
			$elem->setAttribs('label', $vybaveni[$i]->hodnota . '');

			$this->addElement($elem);
		}


		//print_r($program);
		for($i=0; $i<count($program);$i++){
			$elem = new G_Form_Element_Checkbox("program[$i]");
			$elem->setAnonymous();
			$value2 = $this->Request->getPost("program[$i]", $program[$i]->checked);
			$elem->setAttribs('value', $program[$i]->id);

			if ($value2 > 0) {
				$elem->setAttribs('checked','checked');
			}
			$elem->setAttribs('label', $program[$i]->hodnota . '');

			$this->addElement($elem);
		}

		// Kontaktní email
		$name = "email";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_email',1);
		$elem->setAttribs('label','Email:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "femail";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_email',1);
		$elem->setAttribs('label','Email:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "fnazev_firmy";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('required',true);
		$elem->setAttribs('label','Obchodní název firmy:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "kontaktni_osoba";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('required',true);
		$elem->setAttribs('label','Kontaktní osoba:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "firstname";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Jméno:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "lastname";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Příjmení:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "jazyky";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Jazyky:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "website";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','WEB:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "ico";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','IČ:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "dic";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','DIČ:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "lat";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Souřadnice X:');
		$elem->setAttribs('class','souradnice');
		//$elem->setAttribs('style','width:100px');
		$this->addElement($elem);

		$name = "lng";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Souřadnice Y:');
		$elem->setAttribs('class','souradnice');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "ftelefon";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Telefon:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "telefon";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Telefon:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "city";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Město:');
		$elem->setAttribs('class','textbox waypoint');
		$elem->setAttribs('required',true);
		$this->addElement($elem);

		$name = "city2";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Město:');
		$elem->setAttribs('class','textbox waypoint');
		$this->addElement($elem);

		$name = "address1";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ulice, číslo:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "address2";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('required',false);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ulice, číslo:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "paddress1";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ulice, číslo:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "faddress2";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Město:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "faddress1";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ulice, číslo:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "paddress2";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Město:');
		$this->addElement($elem);

		$name = "zip_code";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:100px;');
		$elem->setAttribs('class','zip_code');
		$elem->setAttribs('label','PSČ:');
		$this->addElement($elem);

		$name = "zip_code2";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:100px;');
		$elem->setAttribs('class','zip_code');
		$elem->setAttribs('label','PSČ:');
		$this->addElement($elem);

		$name = "fzip_code";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:100px;');
		$elem->setAttribs('class','zip_code');
		$elem->setAttribs('label','PSČ:');
		$this->addElement($elem);

		$name = "pzip_code";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:100px;');
		$elem->setAttribs('class','zip_code');
		$elem->setAttribs('label','PSČ:');
		$this->addElement($elem);

		$name = "expirace";
		// Musím převést na D.M.RRRR
		if (isset($catalog->$name)) {
			$datum_expirace = date("j.n.Y", strtotime($catalog->$name));
		} else {
			$nextYear = ((date("Y")*1)+1) . "";
			$datum_expirace = date("j"). "." . date("n"). "." .$nextYear;
			//	$versionData[$i][$name] = date("Y-m-d", strtotime($datum_expirace));

			//$datum_expirace = date("j.n.Y");
		}

		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum_expirace);
		$elem->setAttribs('id','date_expirace');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:100px;');
		$elem->setAttribs('class','textbox_small');
		$elem->setAttribs('label','Expirace:');
		$this->addElement($elem);

		$name = "registrace";
		// Musím převést na D.M.RRRR

		if (isset($catalog->$name)) {
			$datum_registrace = date("j.n.Y", strtotime($catalog->$name));
		} else {
			$datum_registrace = date("j.n.Y");
		}

		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum_registrace);
		$elem->setAttribs('id','date_registrace');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:100px;');
		$elem->setAttribs('class','textbox_small');
		$elem->setAttribs('label','Registrace:');
		$this->addElement($elem);


		/*
		   $elem = new G_Form_Element_Checkbox("vip");
		   $value = $this->getPost("vip", $catalog->vip);
		   $elem->setAttribs('value',1);
		   if ($value == 1) {
		   $elem->setAttribs('checked','checked');
		   }
		   $elem->setAttribs('label','VIP');
		   $this->addElement($elem);
		*/
	//	print_r($catalog);

		$page_id = 0;
		if ($this->page_id) {
			$page_id = $this->page_id;
		}



		$popa_start1 = explode(":", $catalog->popa_start);

		$elem = new G_Form_Element_Text("popa_start1");
		$value = $this->getPost("popa_start1", $popa_start1[0]);
		$elem->setAttribs('id','popa_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Po:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("popa_start2");
		$value = $this->getPost("popa_start2", $popa_start1[1]);
		$elem->setAttribs('id','popa_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$popa_end1 = explode(":", $catalog->popa_end);

		$elem = new G_Form_Element_Text("popa_end1");
		$value = $this->getPost("popa_end1", $popa_end1[0]);
		$elem->setAttribs('id','popa_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("popa_end2");
		$value = $this->getPost("popa_end2", $popa_end1[1]);
		$elem->setAttribs('id','popa_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);


		//////
		// Út
		$ut_start1 = explode(":", $catalog->ut_start);

		$elem = new G_Form_Element_Text("ut_start1");
		$value = $this->getPost("ut_start1", $ut_start1[0]);
		$elem->setAttribs('id','ut_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Út:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ut_start2");
		$value = $this->getPost("ut_start2", $ut_start1[1]);
		$elem->setAttribs('id','ut_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$ut_end1 = explode(":", $catalog->ut_end);

		$elem = new G_Form_Element_Text("ut_end1");
		$value = $this->getPost("ut_end1", $ut_end1[0]);
		$elem->setAttribs('id','ut_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ut_end2");
		$value = $this->getPost("ut_end2", $ut_end1[1]);
		$elem->setAttribs('id','ut_end2');
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		////
		//////
		// St
		$st_start1 = explode(":", $catalog->st_start);

		$elem = new G_Form_Element_Text("st_start1");
		$value = $this->getPost("st_start1", $st_start1[0]);
		$elem->setAttribs('id','st_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','St:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("st_start2");
		$value = $this->getPost("st_start2", $st_start1[1]);
		$elem->setAttribs('id','st_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$st_end1 = explode(":", $catalog->st_end);

		$elem = new G_Form_Element_Text("st_end1");
		$value = $this->getPost("st_end1", $st_end1[0]);
		$elem->setAttribs('id','st_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("st_end2");
		$value = $this->getPost("st_end2", $st_end1[1]);
		$elem->setAttribs('id','st_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		////
		// Čt
		$ct_start1 = explode(":", $catalog->ct_start);

		$elem = new G_Form_Element_Text("ct_start1");
		$value = $this->getPost("ct_start1", $ct_start1[0]);
		$elem->setAttribs('id','ct_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Čt:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ct_start2");
		$value = $this->getPost("ct_start2", $ct_start1[1]);
		$elem->setAttribs('id','ct_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$ct_end1 = explode(":", $catalog->ct_end);

		$elem = new G_Form_Element_Text("ct_end1");
		$value = $this->getPost("ct_end1", $ct_end1[0]);
		$elem->setAttribs('id','ct_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ct_end2");
		$value = $this->getPost("ct_end2", $ct_end1[1]);
		$elem->setAttribs('id','ct_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		////
		// pá
		$pa_start1 = explode(":", $catalog->pa_start);

		$elem = new G_Form_Element_Text("pa_start1");
		$value = $this->getPost("pa_start1", $pa_start1[0]);
		$elem->setAttribs('id','pa_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Pá:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("pa_start2");
		$value = $this->getPost("pa_start2", $pa_start1[1]);
		$elem->setAttribs('id','pa_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$pa_end1 = explode(":", $catalog->pa_end);

		$elem = new G_Form_Element_Text("pa_end1");
		$value = $this->getPost("pa_end1", $pa_end1[0]);
		$elem->setAttribs('id','pa_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("pa_end2");
		$value = $this->getPost("pa_end2", $pa_end1[1]);
		$elem->setAttribs('id','pa_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		////

		// so-ne
		$sone_start1 = explode(":", $catalog->sone_start);

		$elem = new G_Form_Element_Text("sone_start1");
		$value = $this->getPost("sone_start1", $sone_start1[0]);
		$elem->setAttribs('id','sone_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','So:');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("sone_start2");
		$value = $this->getPost("sone_start2", $sone_start1[1]);
		$elem->setAttribs('id','sone_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$sone_end1 = explode(":", $catalog->sone_end);

		$elem = new G_Form_Element_Text("sone_end1");
		$value = $this->getPost("sone_end1", $sone_end1[0]);
		$elem->setAttribs('id','sone_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("sone_end2");
		$value = $this->getPost("sone_end2", $sone_end1[1]);
		$elem->setAttribs('id','sone_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		////
		// sne
		$ne_start1 = explode(":", $catalog->ne_start);

		$elem = new G_Form_Element_Text("ne_start1");
		$value = $this->getPost("ne_start1", $ne_start1[0]);
		$elem->setAttribs('id','ne_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','Ne:');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ne_start2");
		$value = $this->getPost("ne_start2", $ne_start1[1]);
		$elem->setAttribs('id','ne_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$ne_end1 = explode(":", $catalog->ne_end);

		$elem = new G_Form_Element_Text("ne_end1");
		$value = $this->getPost("ne_end1", $ne_end1[0]);
		$elem->setAttribs('id','ne_end1');
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ne_end2");
		$value = $this->getPost("ne_end2", $ne_end1[1]);
		$elem->setAttribs('id','ne_end2');
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$name = "city_id";
		$elem= new G_Form_Element_Hidden($name);
		$value = $this->Request->getPost($name, $catalog->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','city_id');
		$this->addElement($elem);


	//	print $catalog->mesto_nazev;

		$mestoDefault = ($catalog->mesto_id > 0) ? $catalog->mesto_nazev : $catalog->city;


		$name = "city";
		$value = $this->getPost($name, $mestoDefault);
		$this->getElement($name)->setAttribs("value",$value);

		$name = "website";
		$value = $this->getPost($name, $catalog->website);
		$this->getElement($name)->setAttribs("value",$value);


		$name = "title_cs";
		$value = $this->getPost($name, $catalog->title);
		$this->getElement($name)->setAttribs("value",$value);
		$this->getElement($name)->setAttribs("label",'Název podniku:<span class="required">*</span>');

		$this->getElement('kontaktni_osoba')->setAttribs('required',true);
		$this->getElement('kontaktni_osoba')->setAttribs("label",'kontaktní osoba:<span class="required">*</span>');





		$this->getElement('femail')->setAttribs('required',false);
		$this->getElement('kontaktni_osoba')->setAttribs('required',false);
		$this->getElement('ftelefon')->setAttribs('required',false);
		$this->getElement('telefon')->setAttribs('required',false);
		$this->getElement('telefon')->setAttribs("label",'Telefon:');

		$this->getElement('address2')->setAttribs("label",'Město:<span class="required">*</span>');
		$this->getElement('address2')->setAttribs("class",'textbox waypoint');
		$this->getElement('address2')->setAttribs(array("dd_decorator" => "","dt_decorator" => "","dl_decorator" => ""));


		$this->getElement('category_id')->setAttribs('required',false);
		$this->getElement('category_id')->setAttribs("label",'Typ:<span class="required">*</span>');
		$name = "description_cs";
		$value = $this->getPost($name, $catalog->description);
		$this->getElement($name)->setAttribs("value",$value);
		$this->getElement($name)->setAttribs("label",'Popis podniku:<span class="required">*</span>');



		$elem= new G_Form_Element_Text("subdomena");
		$value = $this->Request->getPost("subdomena", $catalog->subdomena);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','WEB Subdoména:');
		$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("cena_1");
		$value = $this->Request->getPost("cena_1", $catalog->cena_1);
		$elem->setAttribs('id','cena_1');
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox num');
		$elem->setAttribs('label','Cena 1/2h:');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("cena_2");
		$value = $this->Request->getPost("cena_2", $catalog->cena_2);
		$elem->setAttribs('id','cena_2');
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox num');
		$elem->setAttribs('label','Cena 1h:');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("cena_3");
		$value = $this->Request->getPost("cena_3", $catalog->cena_3);
		$elem->setAttribs('id','cena_3');
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox num');
		$elem->setAttribs('label','Cena 1h:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("cena_4");
		$value = $this->Request->getPost("cena_4", $catalog->cena_4);
		$elem->setAttribs('id','cena_4');
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox num');
		$elem->setAttribs('label','Cena 3h:');
		$this->addElement($elem);



		// Fakturační email
		$this->getElement("ftelefon")->setAttribs("label",'Kontaktní telefon:<span class="required">*</span>');
		$this->getElement("ftelefon")->setAttribs("required",false);

		$this->getElement("femail")->setAttribs("label",'Kontaktní email:<span class="required">*</span>');
		$this->getElement("femail")->setAttribs("required",false);

		// Název firmy pro fakturaci
		$elem= new G_Form_Element_Text("fnazev_firmy");
		$value = $this->Request->getPost("fnazev_firmy", $catalog->fnazev_firmy);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název podniku:');
		$this->addElement($elem);

		// Název firmy pro korepondenci
		$elem= new G_Form_Element_Text("pnazev_firmy");
		$value = $this->Request->getPost("pnazev_firmy", $catalog->pnazev_firmy);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název podniku:');
		$this->addElement($elem);

		// Vstupné - jen firmy
		$elem= new G_Form_Element_Text("vstupne");
		$value = $this->Request->getPost("vstupne", $catalog->vstupne);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Vstupné:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$popa_start1 = explode(":", $catalog->popa_start);

		$elem = new G_Form_Element_Text("popa_start1");
		$value = $this->Request->getPost("popa_start1", $popa_start1[0]);
		$elem->setAttribs('id','popa_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Po:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("popa_start2");
		$value = $this->Request->getPost("popa_start2", $popa_start1[1]);
		$elem->setAttribs('id','popa_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$popa_end1 = explode(":", $catalog->popa_end);

		$elem = new G_Form_Element_Text("popa_end1");
		$value = $this->Request->getPost("popa_end1", $popa_end1[0]);
		$elem->setAttribs('id','popa_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("popa_end2");
		$value = $this->Request->getPost("popa_end2", $popa_end1[1]);
		$elem->setAttribs('id','popa_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);


		//////
		// Út
		$ut_start1 = explode(":", $catalog->ut_start);

		$elem = new G_Form_Element_Text("ut_start1");
		$value = $this->Request->getPost("ut_start1", $ut_start1[0]);
		$elem->setAttribs('id','ut_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Út:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ut_start2");
		$value = $this->Request->getPost("ut_start2", $ut_start1[1]);
		$elem->setAttribs('id','ut_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$ut_end1 = explode(":", $catalog->ut_end);

		$elem = new G_Form_Element_Text("ut_end1");
		$value = $this->Request->getPost("ut_end1", $ut_end1[0]);
		$elem->setAttribs('id','ut_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ut_end2");
		$value = $this->Request->getPost("ut_end2", $ut_end1[1]);
		$elem->setAttribs('id','ut_end2');
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		////
		//////
		// St
		$st_start1 = explode(":", $catalog->st_start);

		$elem = new G_Form_Element_Text("st_start1");
		$value = $this->Request->getPost("st_start1", $st_start1[0]);
		$elem->setAttribs('id','st_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','St:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("st_start2");
		$value = $this->Request->getPost("st_start2", $st_start1[1]);
		$elem->setAttribs('id','st_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$st_end1 = explode(":", $catalog->st_end);

		$elem = new G_Form_Element_Text("st_end1");
		$value = $this->Request->getPost("st_end1", $st_end1[0]);
		$elem->setAttribs('id','st_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("st_end2");
		$value = $this->Request->getPost("st_end2", $st_end1[1]);
		$elem->setAttribs('id','st_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		////
		// Čt
		$ct_start1 = explode(":", $catalog->ct_start);

		$elem = new G_Form_Element_Text("ct_start1");
		$value = $this->Request->getPost("ct_start1", $ct_start1[0]);
		$elem->setAttribs('id','ct_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Čt:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ct_start2");
		$value = $this->Request->getPost("ct_start2", $ct_start1[1]);
		$elem->setAttribs('id','ct_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$ct_end1 = explode(":", $catalog->ct_end);

		$elem = new G_Form_Element_Text("ct_end1");
		$value = $this->Request->getPost("ct_end1", $ct_end1[0]);
		$elem->setAttribs('id','ct_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ct_end2");
		$value = $this->Request->getPost("ct_end2", $ct_end1[1]);
		$elem->setAttribs('id','ct_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		////
		// pá
		$pa_start1 = explode(":", $catalog->pa_start);

		$elem = new G_Form_Element_Text("pa_start1");
		$value = $this->Request->getPost("pa_start1", $pa_start1[0]);
		$elem->setAttribs('id','pa_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','Pá:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("pa_start2");
		$value = $this->Request->getPost("pa_start2", $pa_start1[1]);
		$elem->setAttribs('id','pa_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$pa_end1 = explode(":", $catalog->pa_end);

		$elem = new G_Form_Element_Text("pa_end1");
		$value = $this->Request->getPost("pa_end1", $pa_end1[0]);
		$elem->setAttribs('id','pa_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("pa_end2");
		$value = $this->Request->getPost("pa_end2", $pa_end1[1]);
		$elem->setAttribs('id','pa_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		////

		// so-ne
		$sone_start1 = explode(":", $catalog->sone_start);

		$elem = new G_Form_Element_Text("sone_start1");
		$value = $this->Request->getPost("sone_start1", $sone_start1[0]);
		$elem->setAttribs('id','sone_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','So:');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("sone_start2");
		$value = $this->Request->getPost("sone_start2", $sone_start1[1]);
		$elem->setAttribs('id','sone_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$sone_end1 = explode(":", $catalog->sone_end);

		$elem = new G_Form_Element_Text("sone_end1");
		$value = $this->Request->getPost("sone_end1", $sone_end1[0]);
		$elem->setAttribs('id','sone_end1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('class','pole_time');
		$elem->setAttribs('label','');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("sone_end2");
		$value = $this->Request->getPost("sone_end2", $sone_end1[1]);
		$elem->setAttribs('id','sone_end2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		////
		// sne
		$ne_start1 = explode(":", $catalog->ne_start);

		$elem = new G_Form_Element_Text("ne_start1");
		$value = $this->Request->getPost("ne_start1", $ne_start1[0]);
		$elem->setAttribs('id','ne_start1');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','Ne:');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ne_start2");
		$value = $this->Request->getPost("ne_start2", $ne_start1[1]);
		$elem->setAttribs('id','ne_start2');
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$ne_end1 = explode(":", $catalog->ne_end);

		$elem = new G_Form_Element_Text("ne_end1");
		$value = $this->Request->getPost("ne_end1", $ne_end1[0]);
		$elem->setAttribs('id','ne_end1');
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ne_end2");
		$value = $this->Request->getPost("ne_end2", $ne_end1[1]);
		$elem->setAttribs('id','ne_end2');
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('style','width:16px;');
		$elem->setAttribs('label','');
		$elem->setAttribs('class','pole_time');
		$this->addElement($elem);

		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}
	}
}
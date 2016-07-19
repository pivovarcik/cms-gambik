<?php




class Application_Form_LicenceEdit extends G_Form
{

	public $formName = "Vložení licenčního čísla";

	public $submitButtonName = "ins_sms";
	public $submitButtonTitle = "Potvrdit";

	public $product;

	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct();
		$this->init();
	}

	public function loadPage($product_id)
	{

		// umožnuje načíst hodnoty z hlavního produktu
		if (!is_null($product_id)) {


			if ($page_id == null) {
				/*$this->page->dph_id = $this->product->dph_id;
				   $this->page->dostupnost_id = $this->product->dostupnost_id;
				   $this->page->price = $this->product->prodcena;
				   $this->page->price_sdani = $this->product->prodcena_sdph;

				   $this->page->name = $this->product->title;
				   $this->page->code = $this->product->cislo;*/
			}

		}

	}

	public function loadElements()
	{

		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		//	parent::loadElements();
		$translator = G_Translator::instance();

		$page = $this->page;

		$name = "licence_key";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',$this->getPost($name,""));
		$elem->setAttribs('label',"Zadejte nové licenční číslo");
	//	$elem->setAnonymous();
		$this->addElement($elem);

	}

	public function init()
	{

		$this->loadPage();
		$this->loadElements();


		$name = "upd_licence";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"upd_licence");
		$elem->setAnonymous();

		$this->addElement($elem);

		$name = "ins_sms";
		$elem = new G_Form_Element_Button($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		//$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value','Potvrdit');
		//$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);


	}
}
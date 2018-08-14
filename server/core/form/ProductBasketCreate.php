<?php



class F_ProductBasketCreate extends G_Form
{

	public $formName = '<i class="fa fa-shopping-basket" aria-hidden="true"></i> Přidání zboží do košíku';

	public $submitButtonName = "ins_sms";
	public $submitButtonTitle = "Potvrdit";

	public $product;
	public $product_id;
	public $varianty;
	public $varianty_id;

	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct();
		$this->init();
	}

	public function loadPage($product_id, $varianty_id)
	{

		// umožnuje načíst hodnoty z hlavního produktu
		if (!is_null($product_id)) {
			$productModel = new models_Products();
			$this->product = $productModel->getDetailById($product_id);


			if ($page_id == null) {
				/*$this->page->dph_id = $this->product->dph_id;
				$this->page->dostupnost_id = $this->product->dostupnost_id;
				$this->page->price = $this->product->prodcena;
				$this->page->price_sdani = $this->product->prodcena_sdph;

				$this->page->name = $this->product->title;
				$this->page->code = $this->product->cislo;*/
			}
			$this->product_id = (int)$product_id;
		}
    
    
    if (!is_null($varianty_id)) {
			$productModel = new models_ProductVarianty();
			$this->varianty = $productModel->getDetailById($varianty_id);
      
      $ProductController = new ProductController();
      $this->product->product_description = $ProductController->getProductVariantText($product_id,$varianty_id);


			if ($page_id == null) {
				/*$this->page->dph_id = $this->product->dph_id;
				$this->page->dostupnost_id = $this->product->dostupnost_id;
				$this->page->price = $this->product->prodcena;
				$this->page->price_sdani = $this->product->prodcena_sdph;

				$this->page->name = $this->product->title;
				$this->page->code = $this->product->cislo;*/
			}
			$this->varianty_id = (int)$varianty_id;
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

		$name = "product_id";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs('value',$this->product_id);
		$elem->setAnonymous();
		$this->addElement($elem);


		$name = "varianty_id";
		$elem = new G_Form_Element_Hidden($name);
	//	$elem->setAttribs('value',$this->varianty_id);

		$value = $this->Request->getPost($name,"");
		$elem->setAttribs('value',$value);
		$elem->setAnonymous();
		$this->addElement($elem);

		$name = "qty";
		$elem = new G_Form_Element_Hidden($name);
		$value = $this->Request->getPost($name,"");
		$elem->setAttribs('value',$value);
		$elem->setAnonymous();
		$this->addElement($elem);
	}

	public function init()
	{


		$product_id = (int) $this->Request->getPost("product_id",false);
		$varianty_id = (int) $this->Request->getPost("varianty_id",false);
		$this->loadPage($product_id,$varianty_id);
		$this->loadElements();


		$name = "add_product_basket";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"add_basket");
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
<?php
/**
 * Společný předek pro formuláře typu Faktura
 * */

/*

	vytvoří obálku pro řádek
*/
class RadekFactory{

	protected $TEntity;
	public function __construct($radek)
	{
		$this->TEntity = $radek;
	}

	public function create($data = array())
	{
		$radek = new $this->TEntity($data);

		return $radek;
	}
}

/**
 * Třída zajištuje obecné postavení Formulářového řádku ze všemi atributy
 * @$radek instance třídy typu RadekEntity
 * @$formName string - název formuláře pro zapouzdření do něj v rámci kontextu POST
 * */
class PolozkaFormFactory{

	//protected $indexRow;
	protected $formName;
	protected $Request;
	protected $TEntity;
	public $elements;
	public function __construct(AEntity $radek, $formName ="")
	{
		$this->TEntity = $radek;

		$this->indexRow = $index;
		$this->formName = (!empty($formName) ? $formName . "_" : "" );
		$this->Request = new G_Html();
	}

	public function create(G_Form $formInstance, $mode = "edit")
	{

		$row = new stdClass();
		$dataRadku = $this->TEntity->vratEntitu();

		foreach ($dataRadku as $key => $attr) {

			$meta = $this->TEntity->getMetadata($key);
			$row->$key = $attr;
			$name = $key . "[]";
			if ($meta["type"] == "varchar(255)" || strpos($meta["type"],"text")) {

				$elem = new G_Form_Element_Text($name);
				$value = $this->Request->getPost($name, $attr);
				$elem->setAttribs('value',$value);
				$elem->setAttribs('class','form_edit');
				$elem->setDecoration();

				if ($mode == "readonly") {
					$elem->setAttribs('readonly','readonly');
					$elem->setAttribs('disabled','disabled');
				}

				$formInstance->addElement($elem);
				$row->$key = $elem->render();
			}
			if ($meta["type"] == "datetime") {

				//$name = "platnost_od[" . $i . "]";
				$elem= new G_Form_Element_Text($name);
				$value = $this->Request->getPost($name, gDate($attr));
				$elem->setAttribs('value',$value);
				$elem->setAttribs('class','form_edit datepicker');
				$elem->setDecoration();
				if ($mode == "readonly") {
					$elem->setAttribs('readonly','readonly');
					$elem->setAttribs('disabled','disabled');
				}

				$formInstance->addElement($elem);
				$row->$key = $elem->render();
			}

			if ($meta["type"] == "decimal(12,2)" || strpos($meta["type"],"decimal")) {

				$elem = new G_Form_Element_Text($name);
				$value = $this->Request->getPost($name, $attr);
				$elem->setAttribs('value',$value);
				$elem->setAttribs('class','form_edit');
				$elem->setAttribs(array("is_numeric"=>true));
				$elem->setAttribs('style','text-align:right;');
				if ($mode == "readonly") {
					$elem->setAttribs('readonly','readonly');
					$elem->setAttribs('disabled','disabled');
				}
				$elem->setDecoration();
				$formInstance->addElement($elem);
				$row->$key = $elem->render();
			}

		}

		$name = "radek_id[]";
		$elem= new G_Form_Element_Hidden($name);
		$value = $this->TEntity->getId();
		$elem->setAttribs('value',$value);
	//	$elem->setAnonymous();
$formInstance->addElement($elem);
		$radek_id = $elem->render();
		//" . $this->indexRow . "
		$name = "isDeleted[]";
		$elem= new G_Form_Element_Hidden($name);
		//$value = $this->getPost($name,0);
		$value = 0;
		$elem->setAttribs('value',$value);
	//	$elem->setAnonymous();
		$formInstance->addElement($elem);
		//$this->addElement($elem);
		$radek_deleted = $elem->render();
		//	$radek_deleted = "";
		$deleted = '<a class="rowSetDeleted" href="#"><span>x</span></a>';
		$row->counter = $radek_id . $radek_deleted.$deleted;


		//	$dataRadku["counter"] = $radek_id . $radek_deleted;

		$this->elements = $formInstance->getElement();

		//	print_r($row);
		return $row;
	}

}

/**
 * Třída zajištuje obecné postavení Formulářového řádku ze všemi atributy
 * @$radek instance třídy typu RadekEntity
 * @$formName string - název formuláře pro zapouzdření do něj v rámci kontextu POST
 * */
class RadekFormFactory extends PolozkaFormFactory{


	public function __construct(RadekEntity $radek, $formName ="")
	{
		parent::__construct($radek, $formName);
	}
}



class RadekForm extends G_Form
{
	public $mode = "edit";
	public $pageModel;
	public $radky = array();
	public $radkyOriginal = array();
	public $radkyTabulky = array();
	public $doklad_id;
	protected $TEntity;
	protected $pocet_prazdnych_radku = 1;
	public $languageModel;
	public $languageList;

	protected $polozkaFormFactory;

	// kolekce ukládáných entit řádků
	protected $savedEntity = array();

	function __construct($TEntity)
	{
		parent::__construct();

		if ( !is_subclass_of($TEntity,"RadekEntity")) {
			throw new Exception('Prvek musi byt typu RadekEntity!');
		}

		$this->TEntity = $TEntity;
		$this->polozkaFormFactory = "RadekFormFactory";
		$model = "models_" . str_replace("Entity", "", $TEntity);
		$this->loadModel($model);
		//$this->loadPage();

	}
	// načte datový model
	public function loadModel($model)
	{

		$this->pageModel = new $model;
		//$this->languageModel = new models_Language();
		//$this->languageList = $this->languageModel->getActiveLanguage();

	}
	// načte datový model
	public function loadPage($doklad_id = null)
	{

		// řádky s originál daty
		$this->radkyOriginal = array();

		// aktuální datové řádky
		$this->radky = array();

		// řádky transformované pro tabulku
		$this->radkyTabulky = array();



		if ($doklad_id != null) {
			$this->doklad_id = (int) $doklad_id;

			//	print $doklad_id;
			$params = new ListArgs();
			$params->doklad_id = (int) $doklad_id;
			$params->isDeleted = 0;
			$params->limit = 10000;
			$params->orderBy = 't1.order ASC, t1.TimeStamp ASC';
			$this->radkyOriginal = $this->pageModel->getList($params);
			//print_r($this->radkyOriginal);
		}

		if ($this->Request->isPost())
		{
			$radkyUpravene = $this->getPost("radek_id[]");
			foreach ($radkyUpravene as $i => $val){

				$vstupniData = array();
				$vstupniData["id"] = $val;

				// pokus jedná o existující instanci, tak je třeba ji správně naplnit, aby bylo určené original data
				foreach ($this->radkyOriginal as $key => $originalData) {

					if ($originalData->id == $val) {
						$vstupniData = $originalData;
						break;
					}
				}
				$radek = $this->RadekFactory($vstupniData);

				$this->radky[$i] =  new stdClass();

				foreach ($radek->vratEntitu() as $key => $attr) {
					if ($this->getPost($key."[$i]")) {
						$this->radky[$i]->$key = $this->getPost($key."[$i]");
					}
				}
				// naplním entitu pro uložení
				$radek->naplnEntitu($this->radky[$i]);

				array_push($this->savedEntity, $radek);
				//print_r($radek);
				//$this->radky[$i]->radek_added = $_POST["radek_added"][$i];
				$this->radky[$i]->radek_added = $radkyPridane[$i];
				//$this->radky[$i]->cmd = "";

			}
		} else {
			$this->radky = $this->radkyOriginal;


			$pocetRadku = $this->pocet_prazdnych_radku;
			/*	if (count($this->radky) > $this->pocet_prazdnych_radku) {
			   $pocetRadku = count($this->radky);

			   }*/

			if (count($this->radky) > 0) {
				$pocetRadku = count($this->radky);

			}


			$i=0;
			for ($i=0;$i < $pocetRadku;$i++)
			{

				if (isset($this->radky[$i])) {
					$radek = $this->RadekFactory($this->radky[$i]);
					$this->radky[$i]->radek_added = 0;
				} else {
					$radek = $this->RadekFactory();
					$this->radky[$i]->radek_added = 1;
				}
				array_push($this->savedEntity, $radek);

				// abych dostal plochý data
				foreach ($radek->vratEntitu() as $key => $attr) {
					$this->radky[$i]->$key = $attr;
				}
				$this->radky[$i]->radek_added = 1;
			}

		}

	}
	// vrací kolekci entit v podobě pro uložení
	public function getEntity()
	{
		return $this->savedEntity;
	}
	// Vytvoří novou instanci řádku
	public function RadekFactory($data = array())
	{
		$radek = new $this->TEntity($data);

		return $radek;
	}
	// načte datový model
	public function loadElements()
	{
		$radek = $this->getEntity();


		foreach ($this->elements as $key => $element) {
			//	print_r($element);
			//	print_r($key);
	//		print "Před:" . $element->getName() . ":" . $element->getValue()." = " . count($this->elements) . "<br />";
		//	$this->addElement($element);
		}

		for ($i=0;$i < count($radek);$i++)
		{
			$RadekFormFactory = new $this->polozkaFormFactory($radek[$i],get_class($this));
			$this->radky[$i] = $RadekFormFactory->create($this,$this->mode);
		//	print count($this->elements) ;
		/*	foreach ($RadekFormFactory->elements as $key => $element) {
				//	print_r($element);
				//	print_r($key);
							print $element->getName() . ":" . $element->getValue()." = " . count($this->elements) . "<br />";
				$this->addElement($element);
			}*/
			//$this->addElements($RadekFormFactory->elements);
				//print_r($this->elements);
		}


	//	print_r($this->getValues());
	//	exit;
		if ($this->doklad_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->doklad_id);
			$this->addElement($elem);
		}
	}
/*
	// Z řádku sestaví formulářový řádek
	public function RadekFormFactory(IRadek $radek, $index)
	{
		$row = new stdClass();
		$dataRadku = $radek->vratEntitu();
		foreach ($dataRadku as $key => $attr) {

			$meta = $radek->getMetadata($key);

			$name = $key . "[" . $index . "]";
			if ($meta["type"] == "varchar(255)") {

				$elem = new G_Form_Element_Text($name);
				$value = $this->Request->getPost($name, $attr);
				$elem->setAttribs('value',$value);
				$elem->setAttribs('class','form_edit');
			//	$elem->setAttribs('style','width:98%;text-align:left');
				//$this->addElement($elem);
				$row->$key = $elem->render();
			}
		}

		return $row;

	}*/
	public function tableRender()
	{
		$data = $this->radky;

	}
}
<?php

class PolozkaForm extends G_Form
{

	public $pageModel;
	public $radkyTabulky = array();
	public $radkyOriginal = array();
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
		$this->TEntity = $TEntity;
		$this->polozkaFormFactory = "PolozkaFormFactory";
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

		$this->radkyOriginal = array();
		$this->radkyTabulky = array();




		if ($doklad_id != null) {
			$this->doklad_id = (int) $doklad_id;


			$params = new ListArgs();
			$params->doklad_id = (int) $doklad_id;
			$params->isDeleted = 0;
			$params->limit = 10000;
			$params->orderBy = 't1.order ASC, t1.TimeStamp ASC';
			$this->radkyOriginal = $this->pageModel->getList($params);
		/*
			//	print $doklad_id;
			$params = array();
			$params["doklad_id"] = (int) $doklad_id;
			$params['isDeleted'] = 0;
			$params['order'] = 't1.order ASC, t1.TimeStamp ASC';
			$this->radkyOriginal = $this->pageModel->getList($params);*/
			//print_r($this->radkyOriginal);
		}

		if ($this->Request->isPost())
		{
			$radkyUpravene = $this->getPost("radek_id[]");
			foreach ($radkyUpravene as $i => $val){

				$vstupniData = array();
				$vstupniData["id"] = $val;

				//print "tudy";
				// pokus jedná o existující instanci, tak je třeba ji správně naplnit, aby bylo určené original data
				foreach ($this->radkyOriginal as $key => $originalData) {

					if ($originalData->id == $val) {
						$vstupniData = $originalData;
						break;
					}
				}
				$radek = $this->RadekFactory($vstupniData);

				$this->radkyTabulky[$i] =  new stdClass();

				foreach ($radek->vratEntitu() as $key => $attr) {
					if ($this->getPost($key."[$i]")) {
						$this->radkyTabulky[$i]->$key = $this->getPost($key."[$i]");
					}
				}
				//print_r($this->radky[$i]);
				// naplním entitu pro uložení
				$radek->naplnEntitu($this->radkyTabulky[$i]);

				array_push($this->savedEntity, $radek);
				//print_r($radek);
				//$this->radky[$i]->radek_added = $_POST["radek_added"][$i];
				$this->radkyTabulky[$i]->radek_added = $radkyPridane[$i];
				//$this->radky[$i]->cmd = "";

			}
		} else {
			$this->radkyTabulky = $this->radkyOriginal;


			$pocetRadku = $this->pocet_prazdnych_radku;
			if (count($this->radkyTabulky) >= $this->pocet_prazdnych_radku) {
				$pocetRadku = count($this->radkyTabulky);
				$pocetRadku = $pocetRadku+$this->pocet_prazdnych_radku;
			}

			// prázdná žádanka
			$i=0;
			//$this->pocet_prazdnych_radku = 5;
			for ($i=0;$i < $pocetRadku;$i++)
			{

				if (isset($this->radkyTabulky[$i])) {
					$radek = $this->RadekFactory($this->radkyTabulky[$i]);
					$this->radkyTabulky[$i]->radek_added = 0;
				} else {
					$radek = $this->RadekFactory();
					$this->radkyTabulky[$i]->radek_added = 1;
				}
				array_push($this->savedEntity, $radek);

				// abych dostal plochý data
				foreach ($radek->vratEntitu() as $key => $attr) {
					$this->radkyTabulky[$i]->$key = $attr;
				}
				$this->radkyTabulky[$i]->radek_added = 1;
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

		//	print_r($radek);
		for ($i=0;$i < count($radek);$i++)
		{
			$RadekFormFactory = new $this->polozkaFormFactory($radek[$i],get_class($this));
			$this->radkyTabulky[$i] = $RadekFormFactory->create($this);
		}

		if ($this->doklad_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->doklad_id);
			$this->addElement($elem);
		}
	}
	public function tableRender()
	{
		$data = $this->radkyTabulky;

	}
}
<?php

interface IEntity {

	public function getPrimary();
	public function getTablename();
	public function getDefaultData();
	public function getAttrib();
	public function getMetadata();
}

/**
 * Abstraktní třída pro všechny entity
 *
 */
abstract class AEntity implements IEntity {

	protected $_name;
	protected $metadata;
	protected $lazyLoad;


	// abych dokázal jednozačně identifikovat instance stejné třídy
	protected $globalId;
	protected $_primary = "id";
	function __construct($entity = null, $lazyLoad = true)
	{

		$this->lazyLoad = $lazyLoad;
		// veškeré entity budou mít atribut Id jako primární klíč
		$this->metadata["id"] = array("type" => "int(11)", "scope" => "private");

		$this->metadata["isDeleted"] = array("type" => "tinyint(1)", "default" => "0");

		// časová značka při založení entity
		$this->metadata["TimeStamp"] = array("type" => "datetime", "default" => "NULL");

		// časová značka změny v entitě
		$this->metadata["ChangeTimeStamp"] = array("type" => "datetime", "default" => "NULL");

		$this->nastav($entity, true);
		$this->globalId = UUID::v4();

	}
	// vrací název primárního klíče
	//	abstract function getPrimary();
	// vrací název tabulky
	//abstract function getTablename();

	// vrací defaultní data
	//	abstract function getDefaultData();

	// vrací atributy tabulky
	//	abstract function getAttrib();

	/*
	Stažení entity ze serveru
	*/
	protected function getEntityById($id){


		$model = new G_Service($this->getTablename());

		$detail = $model->get_row("select * from " . $this->getTablename() . " where id=" . $id);
	//	print $model->getLastQuery();
		return $detail;
	}
	public function __get($property) {
		/*
		   if (property_exists($this, $property)) {
		   return $this->$property;
		   }
		*/
		$func = 'get'.$property;
		if (method_exists($this, $func))
		{
			return $this->$func();
		} else {
			//throw new Exception("Property: $property not exist");
			user_error("undefined property $property");
		}

	}

	public function __set($property, $value) {
		/*
		   if (property_exists($this, $property)) {
		   $this->$property = $value;
		   }
		*/
		$func = 'set'.$property;
		if (method_exists($this, $func))
		{
			$this->$func($value);
		} else {
			if (method_exists($this, 'get'.$property))
			{
				//throw new Exception("property $property is read-only");
				user_error("property $property is read-only");
			} else {
				//throw new Exception("Property: $property not exist");
				//user_error("undefined property $property");
			}
		}

	}
	final function getGlobalId()
	{
		return $this->globalId;
	}
	final function getPrimary()
	{
		return $this->_primary;
	}
	final function getTablename()
	{
		return $this->_name;
	}

	final function getDefaultData()
	{
		return $this->_defaultData;
	}
	/**
	 * Vrací kolekci atributů
	 * */
	final function getAttrib($attr = null)
	{
		if ($attr === null) {
			return $this->_attributtes;
		}
		if (isset($this->_attributtes[$attr])) {
			return $this->_attributtes[$attr];
		}

	}


	final function getMetadata($attr = null)
	{
		if ($attr === null) {
			return $this->metadata;
		}
		if (isset($this->metadata[$attr])) {
			return $this->metadata[$attr];
		}

	}


	// vrací atributy entity jako pole
	public function vratEntitu()
	{
		$dokladArray = array();
		foreach (get_object_vars($this) as $property => $value) {
			//	print_r($property);
			//print_r($value);

			//if ($property != "globalId" && $property != "metadata" && method_exists($this, 'get'.$property))
			if ($property != "globalId" && substr($property, strLen($property)-8, 8) != "Original" && $property != "metadata" && method_exists($this, 'get'.$property))
			{
				$dokladArray[$property] = $value;
			}
			//array_push($dokladArray, $property[$value]);
		}
		return $dokladArray;
	}

	// vrací pouze atributy k uložení
	// Vrací pouze rozdílové atributy
	public function getChangedData()
	{
		$dokladArray = array();
		foreach (get_object_vars($this) as $property => $value) {
			//	print_r($property);
			//print_r($value);
			$isVypoctova = false;
			$attrb = $this->getMetadata($property);
			if (isset($attrb["stereotyp"]) && $attrb["stereotyp"] == "vypoctova") {
			//	print $attrb["stereotyp"];
				$isVypoctova = true;
			}

			$original = $property . "Original";
			if (method_exists($this, 'get'.$property) && (method_exists($this, 'set'.$property) || $isVypoctova))
			{
				//print $this->$original;

				if ($isVypoctova) {

					$getProperty = "get" .ucfirst($property);
				//	print $property . "!=" . $this->$getProperty();
					if ($this->$original != $this->$getProperty()) {
						$dokladArray[$property] = $this->$getProperty();
					}
				} else {
					if ($this->$original != $value) {
						$dokladArray[$property] = $value;
					}
				}



			}
			//array_push($dokladArray, $property[$value]);
		}
		return $dokladArray;
	}

	// volá se pouze při inicializaci Entity
	private function nastav($entity = null, $inicializace = false)
	{
		if ($entity != null)
		{
			// Napln z objektu
			if (is_object($entity)) {
				$entity = get_object_vars($entity);
			}

			foreach ($entity as $property => $value) {
				if (property_exists($this, $property)) {

					$func = 'set'.$property;
					if (method_exists($this, $func))
					{
						$attrb = $this->getMetadata($property);
						if ((empty($value) || $value == 0)) {

							if (isset($attrb["reference"])) {
								// ošetření pro reference
								$value = NULL;
							}

							if ($property == "id") {
								// ošetření prázdné nebo nulové hodnoty pro id
								$value = NULL;
							}

						}

						$this->$func($value);

					} else {
						if ($inicializace) {
							$this->$property = $value;
						}
					}

					if ($inicializace) {
						$original = $property . "Original";
						$this->$original = $value;
					}


				} else {
					//user_error("undefined property $property");
				}
			}
		}
	}
	// naplní novou instanci existujícími daty stejného typu
	public function naplnEntitu($entity = null)
	{

		$this->nastav($entity, false);
	}
}
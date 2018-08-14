<?php

/*
   * Generátor entit
*/
class EntityGenerator {


	public function generujVse()
	{
		$this->generujCoreTemplate();
		$this->generujApplicationTemplate();

	}

	private function generuj($path = null, $outPath = null)
	{
		if ($path == null)
		{
			$path = dirname(__FILE__);
		}

		if ($handle = opendir ($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				if (substr($file,-12) == "Template.php" && strLen($file) > 12)
				{
					$templateName = substr($file,0,strLen($file)-4);
					require_once $path . "/" . $file;
					$this->generujEntity($templateName, $outPath);

				}
			}
		}
	}
	private function generujCoreTemplate()
	{
		$this->generuj();
	}

	public function generujApplicationTemplate()
	{
//		$this->generuj(PATH_ROOT . "application/template/", dirname(__FILE__). "/../../application/entity/");
		$this->generuj(PATH_ROOT . "application/template/", PATH_ROOT . "application/entity/");
	}
	public function generujEntity($Template,$outPath = null)
	{

		if (is_null($outPath)) {
			$outPath = dirname(__FILE__). "/../entity/";
		}


		$class = new ReflectionClass($Template);
		$abstract = $class->isAbstract();

		if ($abstract) {
			//print "Abstrakce překakuju";
			return false;
		}
		$TemplateClass = new $Template;
		//print_r($TemplateClass->_attributtes);
		//$templateName = str_replace("Template", "" , $Template);
		$templateName = substr($Template,0, strLen($Template) - strLen("Template"));
		$templateName = str_replace("Entity", "" , $templateName);

		$result = '<?php'."\n";

		if (!empty($TemplateClass->_name)) {
		//	$result .= 'define("' . $TemplateClass->_name . '","' . $TemplateClass->_name . '");'."\n";
		}

		$result .= '/*************'."\n";
		$result .= '* Třída ' . $templateName . 'Entity '."\n";
		$result .= '* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! '."\n";
		$result .= '* Date '.date("Y-m-d H:i:s").' '."\n";
		$result .= '*************/'."\n";
		if (!empty($TemplateClass->parent)) {
			$result .= 'require_once(' . $TemplateClass->path . '"' . $TemplateClass->parent . '.php");'."\n";
		}

		$isAbstract = (empty($TemplateClass->_name)) ? "abstract " : "";


		$result .= $isAbstract . 'class ' . $templateName . 'Entity extends ' . $TemplateClass->parent . ' {'."\n";

		$result .= '	#region constructor' . "\n";
		$result .= '	function __construct($entity = null, $lazyLoad = true)'."\n";
		$result .= '	{'."\n";
		if (!empty($TemplateClass->_name)) {
			$result .= '		$this->_name = "' . $TemplateClass->_name . '";'."\n";

			$result .= '		if (isInt($entity)) {'."\n";
			$result .= '			$entity = $this->getEntityById($entity);'."\n";
			$result .= '		}'."\n";
		}
		$result .= '		parent::__construct($entity, $lazyLoad);'."\n";

		if (!empty($TemplateClass->_name)) {

			// opětovně nastavuji, kvůli předkům
			$result .= '		$this->_name = "' . $TemplateClass->_name . '";'."\n";
		}
		// Stará podpora

		if (isset($TemplateClass->_attributtes)) {
			foreach ($TemplateClass->_attributtes as  $property => $definition) {


				if (isset($definition["type"])) {


				$result .= '		$this->metadata["'.$property.'"] = array("type" => "'.$definition["type"].'"';
				if (isset($definition["stereotyp"])) {
					$result .= ',"stereotyp" => "'.$definition["stereotyp"].'"';
					$result .= ',"default" => "NULL"';
				} else {
					if (isset($definition["default"])) {
						$result .= ',"default" => "'.$definition["default"].'"';
					}
				}

				if (isset($definition["scope"])) {
					$result .= ',"scope" => "'.$definition["scope"].'"';
				}

				if (isset($definition["reference"])) {
					$result .= ',"reference" => "'.$definition["reference"].'"';
				}


					if (isset($definition["index"])) {
						$result .= ',"index" => "'.$definition["index"].'"';
					}
				$result .= ');'."\n";
				} else {
					// jedná se o rozšíření definice na atribut předka
					if (isset($definition["reference"])) {
						$result .= '		$this->metadata["'.$property.'"]["reference"] = "'.$definition["reference"].'";'."\n";
					}
				}
			}
		}

		$result .= '	}'."\n";
		$result .= '	#endregion' . "\n\n";
		if (isset($TemplateClass->_attributtes)) {
			//print_r($TemplateClass->_attributtes);

			// vytvořím Property

			$result .= '	#region Property' . "\n";
			foreach ($TemplateClass->_attributtes as  $property => $definition) {

				if (isset($definition["type"])) {
					$result .= '	// ' . $definition["type"] . "\n";


					if (isset($definition["default"]) && strtolower($definition["default"]) !== "not null" &&
					!isset($definition["stereotyp"]))
					{
						$result .= '	protected $' . $property . ' = ' . $definition["default"] . ';'. "\n";
						$result .= '	protected $' . $property . 'Original = ' . $definition["default"] . ';'. "\n\n";
					} else {
						$result .= '	protected $' . $property . ';'. "\n\n";
						$result .= '	protected $' . $property . 'Original;'. "\n";
					}

					if (isset($definition["reference"]) && !empty($definition["reference"])) {

						$entityName = str_replace("_id", "", $property);

						$entityName .= $definition["reference"] . "Entity";
						$result .= '	protected $' . $entityName . ';'. "\n\n";
					}
				}

			}
			$result .= '	#endregion' . "\n\n";

			$result .= '	#region Method' . "\n";
			foreach ($TemplateClass->_attributtes as  $property => $definition) {

				// Property default public
				$isPublic = true;
				$isVypoctova = false;
				if (isset($definition["scope"]) && $definition["scope"] == "private") {
					$isPublic = false;
				}

				if (isset($definition["stereotyp"]) && $definition["stereotyp"] == "vypoctova") {
					$isPublic = false;
					$isVypoctova = true;
				}

			//s	print_r($definition);
				if ($isPublic) {
					$result .= '	// Setter ' . $property . "\n";
					$result .= '	protected function set' . ucfirst($property) . '($value)'. "\n";
					$result .= '	{'. "\n";


					if (isset($definition["type"]) && ("float" === substr(strtolower($definition["type"]),0,5) || "decimal" === substr(strtolower($definition["type"]),0,7) || "numeric" === substr(strtolower($definition["type"]),0,7))) {

						if (isset($definition["default"]) && strToUpper($definition["default"]) !="NULL" && strToUpper($definition["default"]) !="NOT NULL") {
							// nesmí být NULL
							$result .= '		if (is_null($value)) { return; }' . "\n";
						}
						$result .= '		$this->' . $property . ' = strToNumeric($value);' . "\n";
					}

					elseif (isset($definition["type"]) && "date" === substr(strtolower($definition["type"]),0,4)) {
						$result .= '		$this->' . $property . ' = strToDatetime($value);' . "\n";
					}

					elseif (isset($definition["type"]) && "int" === substr(strtolower($definition["type"]),0,3)) {

						if (isset($definition["reference"]) && !empty($definition["reference"])) {

							$entityName = str_replace("_id", "", $property);

							$entityName .= $definition["reference"] . "Entity";
							//$result .= '	protected $' . $entityName . ';'. "\n\n";
							$result .= '		if (isCeleKladneCislo($value) || is_null($value)) {' . "\n";
							$result .= '			$this->' . $property . ' = $value;' . "\n";
							$result .= '		}' . "\n";

							$result .= '		if (isCeleKladneCislo($value) && $this->lazyLoad) {' . "\n";
							$result .= '			$this->' . $entityName . ' = new ' . $definition["reference"] . 'Entity($value,false);' . "\n";
							$result .= '		} else {' . "\n";
							$result .= '			$this->' . $entityName . ' = null;' . "\n";
							$result .= '		}' . "\n";



						} else {
							$result .= '		if (isInt($value) || is_null($value)) { $this->' . $property . ' = $value; }' . "\n";
						}


					}
					else {
						$result .= '		$this->' . $property . ' = $value;' . "\n";
					}

					$result .= '	}'. "\n";
				}

				$result .= '	// Getter ' . $property . "\n";
				$result .= '	public function get' . ucfirst($property) . '()'. "\n";
				$result .= '	{'. "\n";

				if (!$isVypoctova) {
					$result .= '		return $this->' . $property . ';' . "\n";
				} else {
					$result .= '		return ' . $definition["default"] . ';' . "\n";
				}

				$result .= '	}'. "\n";



				$result .= '	// Getter ' . $property . "Original\n";
				$result .= '	public function get' . ucfirst($property) . 'Original()'. "\n";
				$result .= '	{'. "\n";

				if (!$isVypoctova) {
					$result .= '		return $this->' . $property . 'Original;' . "\n";
				} else {
					$result .= '		return ' . $definition["default"] . ';' . "\n";
				}

				$result .= '	}'. "\n";

			}
			$result .= '	#endregion' . "\n\n";



		}
		$result .= '}'. "\n";
		//print $result;
		$data =  $result;
		$tempDir = $outPath; //dirname(__FILE__). "/../entity/";
		$tempName = $templateName . "Entity.php";
	//	print "ukládám:" . $tempDir . $tempName . "<br />";
		//$data = $soapObj->photo->bytes;

		file_put_contents($tempDir . $tempName, $data);

		PRINT '* Trida ' . $templateName . 'Entity - vygenerovana'. "<br />";

	}
}



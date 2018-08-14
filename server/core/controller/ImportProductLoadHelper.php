<?php


class ImportProductLoadHelper{

	private $name = "";
	private $path = "";
	public function __construct($name, $path = null)
	{
		$this->name = $name;
		$this->path2 = PATH_ROOT . "/application/import/";
		if (is_null($path)) {

		//	$this->path = PATH_ROOT . "core/import/";
			$this->path = PATH_CORE . "import/";
		//	$this->path = PATH_ROOT . "import/".$this->name;
		} else {
			$this->path = $path;
		}

		//$this->loading();

	}

	public function loading()
	{
		if (!defined("IMP_DIRECTORY"))
		{
			define('IMP_DIRECTORY', PATH_ROOT . "import/".$this->name."/log/");
		//	define('IMP_DIRECTORY', $this->path.'log/');
		}

		require_once $this->path . "ProductFactory.php";
		require_once $this->path . "ProductVersionFactory.php";

		require_once $this->path . "ImportIteratorLog.php";
		require_once $this->path . "ImportManagerLog.php";

		require_once $this->path2 . "".$this->name."/CategoryDictionary.php";
		require_once $this->path . "DostupnostDictionary.php";
		require_once $this->path . "MernaJednotkaDictionary.php";
		require_once $this->path . "StateDictionary.php";


		require_once $this->path . "DphDictionary.php";
		//require_once $this->path . "ImportConfig.php";
		require_once $this->path2 . "".$this->name."/ImportConfig.php";


		require_once $this->path . "ProductAttributesDictionary.php";
		require_once $this->path . "ProductAttributesValueDictionary.php";

		require_once $this->path . "VyrobceDictionary.php";
		require_once $this->path2 . "".$this->name."/ProductDecoder.php";

		require_once $this->path . "ImportManager.php";
		require_once $this->path . "ProductImporter.php";
	}
}
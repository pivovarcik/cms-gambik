<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

/**
 * fIX utf8_unicode_ci
 *
 */
class GModel{
	/**
	 * Constructor
	 */

	private $install_date;
	private $version_date;
	private $version;
	private $upsize;
	private $url_home;
	private $url_home_rel;


	public $dropConstraintLog;
	public $createConstraintLog;
	public $createIndexLog;
	public $validTableLog;

	private $dbShcema = array();
	function __construct(){
		$this->install_date = date("Y-m-d H:i:s");
		//$this->version_date = date("2011-12-07");
		//$this->version = 4.50;
		$this->version_date = date("2016-07-04");
		$this->version = 4.993;
		$this->upsize = 12;
		$this->url_home = "http://" . $_SERVER["HTTP_HOST"] . substr($_SERVER["REQUEST_URI"],0,strlen($_SERVER["REQUEST_URI"])-11);
		$this->url_home_rel = substr($_SERVER["REQUEST_URI"],0,strlen($_SERVER["REQUEST_URI"])-11);
		$this->sql = Sql::instance();


		$this->loadDbSchema();
		$this->loadDbFK();
	}

	/*
	   public function validujModel()
	   {
	   $this->validTableVse();
	   $this->zrusReferenceVse();
	   $this->validData();
	   $this->zalozReferenceVse();
	   }
	*/
	public function instalujVse($path = null,$drop = false)
	{
		if ($path == null)
		{
			//$path = dirname(__FILE__);

			$path = dirname(__FILE__).'/../../entity/';

		}

		if ($handle = opendir ($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				//	print $file . "<br />";
				if (substr($file,-10) == "Entity.php" && strLen($file) > 10)
				{
					$templateName = substr($file,0,strLen($file)-4);
					require_once $path . "/" . $file;
					$this->zalozTable($templateName,$drop);

				}
			}
		}

	}


	public function zalozView()
	{
		$model = new models_SysCategory();
		$model->generateCategoryTree();

		//	$model = new models_Category();
		//	$model->generateCategoryTree();
	}
	public function zalozTable($entitaName,$drop = false)
	{

		$class = new ReflectionClass($entitaName);
		$abstract = $class->isAbstract();

		if ($abstract) {
			//print "Abstrakce překakuju";
			return false;
		}
		$entita = new $entitaName;

		//print_r($TemplateClass->getMetadata());
		if ($drop) {
			$this->drop($entita->getTablename());
		}


		$res = 'CREATE TABLE IF NOT EXISTS `'.$entita->getTablename().'`';

		$res .= '(';

		foreach ($entita->getMetadata() as  $property => $definition) {
			$res .= '`'.$property.'` '.$definition["type"].'';
			if ($property == $entita->getPrimary()) {
				$res .= ' NOT NULL auto_increment';
			} else {

				if (isset($definition["default"]) && $definition["stereotyp"] != "vypoctova") {
					if (trim(strtoupper($definition["default"])) == "NOT NULL") {
						$res .= ' NOT NULL';
					} else {
						$res .= ' DEFAULT ' . $definition["default"];
					}
				} else {
					$res .= ' DEFAULT NULL';
				}
			}
			//COLLATE utf8_unicode_ci
			$STRING_ARRAY = array("VAR","TEX","LON");
			if (in_array(SUBSTR(trim(strtoupper($definition["type"])),0,3), $STRING_ARRAY)) {
				$res .= ' COLLATE utf8_unicode_ci';
			}
			$res .= ',';
		}
		$res .= 'PRIMARY KEY  (`'.$entita->getPrimary().'`)';
		$res .= ')';
		$res .= 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';
		print '* Tabulka ' . $entita->getTablename() . ' - vygenerovana'. "<br />";
		return $this->sql->query($res);
		//PRINT $res . "<BR />";


	}

	public function validTableVse($path = null)
	{
		if ($path == null)
		{
			//$path = dirname(__FILE__);

			$path = dirname(__FILE__).'/../../entity/';

		}

		if ($handle = opendir ($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				//	print $file . "<br />";
				if (substr($file,-10) == "Entity.php" && strLen($file) > 10)
				{
					$templateName = substr($file,0,strLen($file)-4);
					require_once $path . "/" . $file;
					$this->validTable($templateName);

				}
			}
		}

		$this->create_category_view();

	}

	public function zalozReferenceVse($path = null,$drop = false)
	{
		if ($path == null)
		{
			$path = dirname(__FILE__).'/../../entity/';

		}


		if ($handle = opendir ($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				//	print $file . "<br />";
				if (substr($file,-10) == "Entity.php" && strLen($file) > 10)
				{
					$templateName = substr($file,0,strLen($file)-4);
					print $path . "/" . $file . "<br />";
					require_once $path . "/" . $file;
					$this->zalozReferenci($templateName,$path);

				}
			}
		}

	}

	public function zrusReferenceVse($path = null,$drop = false)
	{
		if ($path == null)
		{
			$path = dirname(__FILE__).'/../../entity/';
		}

		//print $path;
		if ($handle = opendir ($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				//	print $file . "<br />";
				if (substr($file,-10) == "Entity.php" && strLen($file) > 10)
				{
					$templateName = substr($file,0,strLen($file)-4);
					require_once $path . "/" . $file;
					$this->zrusReferenci($templateName);

				}
			}
		}

	}

	public function zrusIndexiVse($path = null,$drop = false)
	{
		if ($path == null)
		{
			$path = dirname(__FILE__).'/../../entity/';
		}

		//print $path;
		if ($handle = opendir ($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				//	print $file . "<br />";
				if (substr($file,-10) == "Entity.php" && strLen($file) > 10)
				{
					$templateName = substr($file,0,strLen($file)-4);
					require_once $path . "/" . $file;
					$this->zrusIndex($templateName);

				}
			}
		}

	}

	public function zalozReferenci($entitaName,$path)
	{
		// nejprve zruším všechny cizí klíče
		$class = new ReflectionClass($entitaName);
		$abstract = $class->isAbstract();

		$pathDefault = dirname(__FILE__).'/../../entity/';
		if ($abstract) {
			//print "Abstrakce překakuju";
			return false;
		}
		$entita = new $entitaName;

		$metadata = $entita->getMetadata();
		foreach ($metadata as  $property => $definition) {

			if (isset($definition["reference"])) {

				if (file_exists($path . $definition["reference"] . "Entity.php")) {
					require_once($path . $definition["reference"] . "Entity.php");
				} else {
					require_once($pathDefault . $definition["reference"] . "Entity.php");
				}


				$parentEntitaName = $definition["reference"] . "Entity";
				$parentEntita = new $parentEntitaName;

				$isNull = true;
				if (isset($definition["default"]) && $definition["default"] == "NOT NULL" ) {
					$isNull = false;
				}
				$this->createConstraint($entita->getTablename(),$property,$parentEntita->getTableName(),"id",$isNull);
			}
		}

		// založím je znovu
	}

	public function zalozIndexiVse($path = null)
	{
		if ($path == null)
		{
			$path = dirname(__FILE__).'/../../entity/';

		}


		if ($handle = opendir ($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				//	print $file . "<br />";
				if (substr($file,-10) == "Entity.php" && strLen($file) > 10)
				{
					$templateName = substr($file,0,strLen($file)-4);
					print $path . "/" . $file . "<br />";
					require_once $path . "/" . $file;
					$this->zalozIndex($templateName,$path);

				}
			}
		}

	}

	public function zalozIndex($entitaName,$path)
	{
		// nejprve zruším všechny cizí klíče
		$class = new ReflectionClass($entitaName);
		$abstract = $class->isAbstract();

		$pathDefault = dirname(__FILE__).'/../../entity/';
		if ($abstract) {
			//print "Abstrakce překakuju";
			return false;
		}
		$entita = new $entitaName;

		$metadata = $entita->getMetadata();
		foreach ($metadata as  $property => $definition) {

			if (isset($definition["index"])) {
				$this->createIndex($entita->getTablename(),$property);
			}
		}

		// založím je znovu
	}

	public function zrusIndex($entitaName)
	{
		// nejprve zruším všechny cizí klíče
		$class = new ReflectionClass($entitaName);
		$abstract = $class->isAbstract();

		if ($abstract) {
			//print "Abstrakce překakuju";
			return false;
		}
		$entita = new $entitaName;


		$metadata = $entita->getMetadata();
		foreach ($metadata as  $property => $definition) {

			if (isset($definition["index"])) {
				$this->dropIndex($entita->getTablename(),$property);
			}
		}
	}

	public function zrusReferenci($entitaName)
	{
		// nejprve zruším všechny cizí klíče
		$class = new ReflectionClass($entitaName);
		$abstract = $class->isAbstract();

		if ($abstract) {
			//print "Abstrakce překakuju";
			return false;
		}
		$entita = new $entitaName;

		/*
		   SELECT CONSTRAINT_name
		   FROM `information_schema`.`TABLE_CONSTRAINTS`
		   WHERE `TABLE_SCHEMA` = 'www3_karapneu_cz'
		   AND CONSTRAINT_TYPE = 'FOREIGN KEY'
		*/


		//	$constraintName = "fk_" . $entita->getTablename() . "_" . $property;
		//AND `CONSTRAINT_NAME`='" . $constraintName ."'
		/*		$query = "select CONSTRAINT_NAME from `information_schema`.`TABLE_CONSTRAINTS` WHERE `TABLE_SCHEMA` = '" . DB_NAME ."'
		   AND CONSTRAINT_TYPE = 'FOREIGN KEY'  AND `TABLE_NAME` = '" . $entita->getTablename() ."'";
		   $list = $this->sql->get_results($query);
		*/
		$list = $this->getTableFK($entita->getTablename());
		//	print $query . "<br />";
		for ($i=0;$i<count($list);$i++)
		{
			$this->dropConstraint($entita->getTablename(),$list[$i]->CONSTRAINT_NAME);
		}
	}

	private function dropConstraint($entitaName,$constraintName)
	{

		$query = "ALTER TABLE `" . $entitaName . "` DROP FOREIGN KEY `" . $constraintName . "`;";
		//	print "<br /> Ruším pravidlo:<br />" . $query . "<br />------------------------------<br />";
		$this->dropConstraintLog .= "" . $query . "\n";
		$this->sql->query($query);
	}


	private function dropIndex($entitaName,$constraintName)
	{

		$query = "ALTER TABLE `" . $zdrojTabulka . "` DROP INDEX (`" . $zdrojPolozka  . "`);";
		//	print "<br /> Ruším pravidlo:<br />" . $query . "<br />------------------------------<br />";
		$this->dropConstraintLog .= "" . $query . "\n";
		$this->sql->query($query);
	}


	//Opravdu si přejete provést „ALTER TABLE `mm_category_version` ADD INDEX(`version`);“?

	private function createIndex($zdrojTabulka,$zdrojPolozka)
	{
		$query = "ALTER TABLE `" . $zdrojTabulka . "` ADD INDEX (`" . $zdrojPolozka  . "`);";
		$this->sql->query($query);

		$this->createConstraintLog .= "-- Zakládám index pro " . $zdrojPolozka . " (" . $zdrojTabulka . "):" . "\n" . $query . "\n";
	}
	private function createConstraint($zdrojTabulka,$zdrojPolozka,$cilTabulka,$cilPolozka,$isNull)
	{



		$query = "select " . $zdrojPolozka . " from " . $zdrojTabulka . " where " . $zdrojPolozka . " not in (select id from " . $cilTabulka . ") and " . $zdrojPolozka . " is not NULL  group by " . $zdrojPolozka . "";
		$list = $this->sql->get_results($query);

		$neexistujiciKlice = array();
		$neexistujiciQuery = "";
		for ($i=0;$i<count($list);$i++)
		{
			print $query;
			$neexistujiciKlice[] = $list[$i]->$zdrojPolozka;
			$neexistujiciQuery .= "update " . $zdrojTabulka . " set " . $zdrojPolozka . "=NULL where " . $zdrojPolozka . "= " . $list[$i]->$zdrojPolozka . ";<br />";

			// hodnotu 0 mohu vklidu nahradit za NULL
			if (trim($list[$i]->$zdrojPolozka) == "0") {
				$query = "update " . $zdrojTabulka . " set " . $zdrojPolozka . "=NULL where " . $zdrojPolozka . "= " . $list[$i]->$zdrojPolozka . "";
				$this->sql->query($query);
			}
		}

		$deleteNull = "";
		if ($isNull) {
			$deleteNull = "ON DELETE SET NULL ";
		}
		if (count($list) == 0) {
			$query = "ALTER TABLE `" . $zdrojTabulka . "`
		ADD CONSTRAINT `fk_" . $zdrojTabulka . "_" . $zdrojPolozka . "`
		FOREIGN KEY (`" . $zdrojPolozka . "`) REFERENCES `" . $cilTabulka . "` (`" . $cilPolozka . "`) " . $deleteNull . "ON UPDATE CASCADE;";
			$this->sql->query($query);

			$this->createConstraintLog .= "-- Zakládám pravidlo pro " . $zdrojPolozka . " (" . $zdrojTabulka . "):" . "\n" . $query . "\n";
			//	print "<br /> Zakládám pravidlo pro " . $zdrojPolozka . " (" . $zdrojTabulka . "):<br />" . $query . "<br />------------------------------<br />";
		} else {
			print "<br /><span style=\"color:red;\"> Pravidlo " . $zdrojPolozka . " (" . $zdrojTabulka . ") nemohlo být založeno:<br />Obsahuje neexistující klíče!</span>" . implode(",",$neexistujiciKlice) . "<br /> " .$neexistujiciQuery . "<br />------------------------------<br />";
		}

		//$this->sql->query($query);
	}


	private function getTableSchema($tablename)
	{
		if (isset($this->dbShcema[$tablename])) {
			return $this->dbShcema[$tablename];
		}
		return array();
	}

	private function getTableFK($tablename)
	{
		if (isset($this->dbFK[$tablename])) {
			return $this->dbFK[$tablename];
		}
		return array();
	}

	public function loadDbFK()
	{
		//	$query = "select TABLE_NAME,COLUMN_NAME,DATA_TYPE,COLUMN_COMMENT,IS_NULLABLE,COLUMN_DEFAULT,CHARACTER_MAXIMUM_LENGTH from `information_schema`.`COLUMNS` WHERE `TABLE_SCHEMA` = '" . DB_NAME ."' order by TABLE_NAME asc";


		$query = "select CONSTRAINT_NAME, TABLE_NAME from `information_schema`.`TABLE_CONSTRAINTS` WHERE `TABLE_SCHEMA` = '" . DB_NAME ."' AND CONSTRAINT_TYPE = 'FOREIGN KEY'";
		$list =  $this->sql->get_results($query);

		$tablename = "";
		$poleTemp = array();
		for ($i=0; $i<count($list);$i++) {

			if ($tablename != $list[$i]->TABLE_NAME || ($i+1) == count($list)) {

				if (!empty($tablename)) {
					$this->dbFK[$tablename] = $poleTemp;
				}
				$poleTemp = array();
				//$this->dbShcema[$val->TABLE_NAME] = array();
			}

			array_push($poleTemp,$list[$i]);
			$tablename = $list[$i]->TABLE_NAME;


		}
		return $this->dbFK;
	}

	public function loadDbSchema()
	{
		$query = "select TABLE_NAME,COLUMN_NAME,DATA_TYPE,COLUMN_COMMENT,IS_NULLABLE,COLUMN_DEFAULT,CHARACTER_MAXIMUM_LENGTH from `information_schema`.`COLUMNS` WHERE `TABLE_SCHEMA` = '" . DB_NAME ."' order by TABLE_NAME asc";



		$list =  $this->sql->get_results($query);

		$tablename = "";
		$poleTemp = array();
		for ($i=0; $i<count($list);$i++) {

			if ($tablename != $list[$i]->TABLE_NAME || ($i+1) == count($list)) {

				if (!empty($tablename)) {
					$this->dbShcema[$tablename] = $poleTemp;
				}
				$poleTemp = array();
				//$this->dbShcema[$val->TABLE_NAME] = array();
			}

			array_push($poleTemp,$list[$i]);
			$tablename = $list[$i]->TABLE_NAME;


		}
		return $this->dbShcema;
	}

	public function validTable($entitaName)
	{

		$class = new ReflectionClass($entitaName);
		$abstract = $class->isAbstract();

		if ($abstract) {
			//print "Abstrakce překakuju";
			return false;
		}
		$entita = new $entitaName;
		$list = $this->getTableSchema($entita->getTablename());
		if (count($list) == 0) {
			print "--Pozor!. Není založena tabulka <strong>" . $entita->getTablename() . "</strong>!<br />";

			$this->zalozTable($entitaName);
			return;
		}

		$tableSchema = array();
		for($i=0; $i<count($list);$i++) {
			if (is_null($list[$i]->COLUMN_DEFAULT)) {
				$default = (trim($list[$i]->IS_NULLABLE) == "YES") ? "NULL" : "NOT NULL";
			} else {
				$default = trim($list[$i]->COLUMN_DEFAULT);
			}

			$tableSchema[$list[$i]->COLUMN_NAME] = array("default" => $default, "type" =>trim($list[$i]->DATA_TYPE), "length" => trim($list[$i]->CHARACTER_MAXIMUM_LENGTH));
		}

		$metadata = $entita->getMetadata();
		foreach ($metadata as  $property => $definition) {

			if (!isset($tableSchema[$property])) {

				//	print "--Pozor!. V tabulce <strong>" . $entita->getTablename() . "</strong> chybí atribut <strong>" . $property . "</strong> (" . $entitaName . ")!<br />";
				$res = "ALTER TABLE `" . $entita->getTablename() . "` ADD COLUMN `" . $property . "` " . $definition["type"]. "";

				if (isset($definition["default"]) && $definition["stereotyp"] != "vypoctova") {
					if (trim(strtoupper($definition["default"])) == "NOT NULL") {
						$res .= ' NOT NULL';
					} else {
						$res .= ' DEFAULT ' . $definition["default"];
					}
				} else {
					$res .= ' DEFAULT NULL';
				}
				$STRING_ARRAY = array("VAR","TEX","LON");
				if (in_array(SUBSTR(trim(strtoupper($definition["type"])),0,3), $STRING_ARRAY)) {
					$res .= ' COLLATE utf8_unicode_ci';
				}
				$res .= ';';


				$this->validTableLog .= "--Pozor!. V tabulce " . $entita->getTablename() . " chybí atribut " . $property . " (" . $entitaName . ")!" . "\n" . $res . "\n";
				$this->sql->query($res);
				//print $res . "<br />-----------------------------------------------<br />";

			}
		}

		foreach ($tableSchema as  $property => $definition) {

			if (!isset($metadata[$property])) {

				//	print "--Pozor!. V tabulce <strong>" . $entita->getTablename() . "</strong> je atribut <strong>" . $property . "</strong>, ale není obsažen v Entitách (" . $entitaName . ")!<br />";
				$res = "ALTER TABLE `" . $entita->getTablename() . "` DROP COLUMN `" . $property . "`;";
				//	print $res . "<br />-----------------------------------------------<br />";

				$this->validTableLog .= "--Pozor!. V tabulce " . $entita->getTablename() . " je atribut " . $property . ", ale není obsažen v Entitách (" . $entitaName . ")!" . "\n" . $res . "\n";

			} else {

				// porovnám ho s metadaty
				if (isset($metadata[$property]["default"]) && trim(strtoupper($metadata[$property]["default"])) != $definition["default"]) {
					print "--Pozor!. V tabulce <strong>" . $entita->getTablename() . "</strong> je atribut <strong>" . $property . "</strong> má rozdílnou hodnotu IS_NULLABLE " . $metadata[$property]["default"] . " <> " . $definition["default"] . "[db]!<br />";

					// ALTER TABLE `mm_category` CHANGE `user_id` `user_id` INT( 11 ) NULL
					$default = "DEFAULT " . $metadata[$property]["default"];
					if ($metadata[$property]["default"] == "NOT NULL") {
						$default = $metadata[$property]["default"];
					}
					$res = "ALTER TABLE `" . $entita->getTablename() . "` CHANGE `" . $property . "` `" . $property . "` " . $metadata[$property]["type"]. " " . $default;
					print $res . "<br />-----------------------------------------------<br />";
					$this->sql->query($res);
					//exit;
				}

				// Kontrola délky stringu
				if (trim(strtoupper($definition["type"])) == "VARCHAR" &&
				trim(strtoupper($metadata[$property]["type"])) != trim(strtoupper($definition["type"] . "(" . $definition["length"] . ")"))) {


					print "--Pozor!. V tabulce <strong>" . $entita->getTablename() . "</strong> je atribut <strong>" . $property . "</strong> má rozdílnou délku " . $metadata[$property]["type"]. " <> " . $definition["type"] . "(" . $definition["length"] . ") [db]!" . "!<br />";

					// ALTER TABLE `mm_category` CHANGE `user_id` `user_id` INT( 11 ) NULL
					$default = "DEFAULT " . $metadata[$property]["default"];
					if ($metadata[$property]["default"] == "NOT NULL") {
						$default = $metadata[$property]["default"];
					}
					$res = "ALTER TABLE `" . $entita->getTablename() . "` CHANGE `" . $property . "` `" . $property . "` " . $metadata[$property]["type"] . " DEFAULT null";
					print $res . "<br />-----------------------------------------------<br />";
					$this->sql->query($res);
					//exit;
				}
			}
		}
	}


	public function validData()
	{

		$this->getUpsize();

		$testdata = $this->getSettingsData();

		$query = "select * from `" . T_OPTIONS . "`";
		$list = $this->sql->get_results($query);



		$appData = array();
		for($i=0; $i<count($list);$i++) {
			$appData[$list[$i]->key] = "";
		}

		//	print_r($appData);

		foreach ($testdata as  $property => $definition) {

			if (!isset($appData[$property])) {

				print "--Pozor!. V tabulce <strong>" . T_OPTIONS . "</strong> chybí hodnota <strong>" . $property . "</strong>!<br />";

				$data = array();

				$data["key"] = $property;
				$data["value"] = $definition;

				$model = new models_Settings();
				$model->insert($data);
			}
		}


		$data = array();


		$data["value"] = $this->version;

		$model = new models_Settings();
		$model->updateRecords($model->getTableName(),$data, "`key`='VERSION_RS'");

	//	print $model->getLastQuery();
		print "Aktualizuji verzi CMS " . $this->version;



		$testdata = $this->getShopSettingsData();

		$query = "select * from `" . T_SHOP_SETTINGS . "`";
		$list = $this->sql->get_results($query);



		$appData = array();
		for($i=0; $i<count($list);$i++) {
			$appData[$list[$i]->key] = "";
		}

		//	print_r($appData);

		foreach ($testdata as  $property => $definition) {

			if (!isset($appData[$property])) {

				print "--Pozor!. V tabulce <strong>" . T_SHOP_SETTINGS . "</strong> chybí hodnota <strong>" . $property . "</strong>!<br />";

				$data = array();

				$data["key"] = $property;
				$data["value"] = $definition;

				$model = new models_Eshop();
				$model->insert($data);
			}
		}



		$testdata = $this->getFilterViewDefinitionData();





		$appData = array();


		//	print_r($appData);

		for ($i=0; $i<count($testdata);$i++) {

			$query = "select * from `" . T_FILTERVIEW . "` where modelname='" . $testdata[$i]["modelname"]. "' and isDefault=1 and user_id is null";
			$list = $this->sql->get_results($query);
			$model = new models_NextId();
			if (count($list) == 1) {
				// update
				$data = array();
				$data = $testdata[$i];
				//	$data["name"] = "Základní";
				$model->updateRecords(T_FILTERVIEW,$data, "modelname='" . $testdata[$i]["modelname"]."' and isDefault=1");
				print "-- Aktualizován pohled <strong>" . $testdata[$i]["modelname"] . "</strong><br />";
			} else {
				// insert
				$data = array();
				$data = $testdata[$i];
				//	$data["name"] = "Základní";
				$model->insertRecords(T_FILTERVIEW,$data);
				print "-- Přidán pohled <strong>" . $testdata[$i]["modelname"] . "</strong><br />";

			}


		}

		$data = array();
		$data["name"] = "Základní";
		$model->updateRecords(T_FILTERVIEW,$data, "isDefault=1 and name is null");

	}
	public function install(){
		/*
		   if (!$this->check_version()) {
		   return false;
		   }
		*/


		//	$this->dropForeignKey();

		$this->instalujVse(null,true);
		//	$this->create_menu();
		$this->create_category_view();


		//	$this->createForeignKey();
		$this->insert_data();

		//	$this->update_options();


		// založení pohledů
		$modelCategory = new models_Category();
		$modelCategory->generateCategoryTree();
	}
	public function upgrade(){

		if (!$this->check_version()) {
			return false;
		}

		$this->getUpsize();

		$this->update_options();


	}

	public function getFilterViewDefinitionData()
	{
		$filterViewDefinitionData = array();
		$data = array();
		$data["modelname"] = "Faktura";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="" class="icon" order="2" visibility="1"/>
<column name="description_secret" header="" class="icon" order="3" visibility="1"/>
<column name="code" header="Doklad" class="code" order="1" visibility="1"/>
<column name="shipping_first_name" header="Odběratel" class="text" order="3" visibility="1"/>
<column name="shipping_email" header="Email" class="email" order="5" visibility="1"/>
<column name="shipping_phone" header="Telefon" class="phone" order="6" visibility="0"/>
<column name="cost_total" header="Celkem" class="money" order="4" visibility="1"/>
<column name="amount_paid" header="Zaplaceno" class="money" order="10" visibility="1"/>
<column name="maturity_date" header="Splatnost" class="date" order="6" visibility="1"/>
<column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/>
<column name="shipping_dic" header="DIČ" class="text" order="21" visibility="0"/>
<column name="shipping_ico" header="IČ" class="text" order="13" visibility="1"/>
<column name="nazev_stav" header="Stav" class="text" order="24" visibility="0"/>
<column name="storno" header="Strono" class="checkbox" order="20" visibility="0"/>
<column name="shipping_address_1" header="Ulice" class="text" order="9" visibility="1"/>
<column name="shipping_city" header="Město" class="text" order="10" visibility="1"/>
</definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Orders";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="" class="icon" order="1" visibility="1"/>
<column name="description_secret" header="" class="icon" order="2" visibility="1"/><column name="code" header="Doklad" class="code" order="3" visibility="1"/>
<column name="shipping_first_name" header="Odběratel" class="text" order="4" visibility="1"/>
<column name="shipping_email" header="Email" class="email" order="5" visibility="1"/>
<column name="shipping_phone" header="Telefon" class="phone" order="6" visibility="0"/>
<column name="cost_total" header="Celkem" class="money" order="7" visibility="1"/>
<column name="TimeStamp" header="Vloženo" class="datetime" order="8" visibility="1"/>
<column name="shipping_address_1" header="Ulice" class="text" order="9" visibility="1"/>
<column name="shipping_city" header="Město" class="text" order="10" visibility="1"/>
<column name="shipping_zip_code2" header="PSČ2" class="text" order="11" visibility="0"/>
<column name="shipping_last_name2" header="Příjmení2" class="text" order="12" visibility="0"/>
<column name="shipping_ico" header="IČ" class="text" order="13" visibility="1"/>
<column name="shipping_state" header="Země" class="text" order="14" visibility="0"/>
<column name="shipping_zip_code" header="PSČ" class="text" order="15" visibility="0"/>
<column name="shipping_address_12" header="Ulice2" class="text" order="16" visibility="0"/>
<column name="shipping_last_name" header="Příjmení" class="text" order="17" visibility="0"/>
<column name="shipping_address_2" header="Ulice2" class="text" order="18" visibility="0"/>
<column name="shipping_address_22" header="Ulice22" class="text" order="19" visibility="0"/>
<column name="storno" header="Strono" class="checkbox" order="20" visibility="0"/>
<column name="shipping_dic" header="DIČ" class="text" order="21" visibility="0"/>
<column name="heureka" header="Heureka" class="checkbox" order="22" visibility="0"/>
<column name="shipping_first_name2" header="Odběratel2" class="text" order="23" visibility="0"/>
<column name="nazev_stav" header="Stav" class="text" order="24" visibility="0"/>
<column name="shipping_city2" header="Město2" class="text" order="25" visibility="0"/>
<column name="shipping_state2" header="Země2" class="text" order="26" visibility="0"/>
<column name="nazev_dopravy" header="Doprava" class="text" order="27" visibility="0"/>
<column name="nazev_platby" header="Platba" class="text" order="28" visibility="0"/>
</definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Products";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition>
<column name="cislo" header="Číslo" class="code" order="1" visibility="1"/>
<column name="title" header="Název" class="text" order="2" visibility="1"/>
<column name="nazev_category" header="Umístění" class="code" order="3" visibility="0"/>
<column name="nazev_skupina" header="Skupina" class="text" order="4" visibility="1"/>
<column name="nazev_vyrobce" header="Značka" class="text" order="5" visibility="1"/>
<column name="prodcena" header="Prodejní cena" class="money" order="6" visibility="1"/>
<column name="prodcena_sdph" header="Prodejní cena s DPH" class="money" order="6" visibility="1"/>
<column name="qty" header="Množství" class="money" order="7" visibility="1"/>
<column name="PageTimeStamp" header="Vloženo" class="datetime" order="8" visibility="1"/>
<column name="aktivni" header="Aktivní" class="checkbox" order="9" visibility="1"/>
<column name="code01" header="code01" class="code" order="10" visibility="1"/>
<column name="code02" header="code02" class="code" order="11" visibility="1"/>
<column name="code03" header="code03" class="code" order="12" visibility="0"/>
<column name="bazar" header="Bazar" class="checkbox" order="13" visibility="0"/>
<column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="14" visibility="0"/>
<column name="nazev_mj" header="MJ" class="" order="15" visibility="0"/>
<column name="nazev_dph" header="DPH" class="" order="16" visibility="0"/>
<column name="sleva" header="Sleva" class="money" order="17" visibility="0"/>
<column name="cislo4" header="cislo4" class="code" order="18" visibility="0"/>
<column name="ppc_zbozicz" header="PPC" class="check" order="19" visibility="0"/>
<column name="netto" header="Množství" class="money" order="20" visibility="0"/>
<column name="cislo3" header="cislo3" class="code" order="21" visibility="0"/>
<column name="cislo1" header="cislo1" class="code" order="22" visibility="0"/>
<column name="cislo5" header="cislo5" class="code" order="23" visibility="0"/>
<column name="polozka5" header="polozka5" class="code" order="24" visibility="0"/>
<column name="polozka1" header="polozka1" class="code" order="25" visibility="0"/>
<column name="polozka2" header="polozka2" class="code" order="26" visibility="0"/>
<column name="polozka3" header="polozka3" class="code" order="27" visibility="0"/>
<column name="polozka4" header="polozka4" class="code" order="28" visibility="0"/>
<column name="nazev_dostupnost" header="Dostupnost" class="" order="29" visibility="0"/>
<column name="cislo2" header="cislo2" class="code" order="30" visibility="0"/>
<column name="thumb" header="Náhled" class="thumb" order="1" visibility="1"/>
</definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "Users";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="nick" header="Uživatel" class="" order="1" visibility="1"/><column name="email" header="Email" class="email" order="2" visibility="1"/><column name="jmeno" header="Jméno" class="" order="3" visibility="1"/><column name="prijmeni" header="Příjmení" class="" order="4" visibility="1"/><column name="nazev_role" header="Role" class="" order="5" visibility="1"/><column name="aktivni" header="Aktivní" class="checkbox" order="6" visibility="1"/><column name="autorizace" header="Autor." class="checkbox" order="7" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="8" visibility="1"/><column name="naposledy" header="Poslední aktivita" class="datetime" order="9" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Roles";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="title" header="Název role" class="" order="1" visibility="1"/><column name="p1" header="P1" class="checkbox" order="2" visibility="1"/><column name="p2" header="P2" class="checkbox" order="3" visibility="1"/><column name="p3" header="P3" class="checkbox" order="4" visibility="1"/><column name="p4" header="P4" class="checkbox" order="5" visibility="1"/><column name="p5" header="P5" class="checkbox" order="6" visibility="1"/><column name="p6" header="P6" class="checkbox" order="7" visibility="1"/><column name="p7" header="P7" class="checkbox" order="8" visibility="1"/><column name="p8" header="P8" class="checkbox" order="9" visibility="1"/><column name="p9" header="P9" class="checkbox" order="10" visibility="1"/><column name="p10" header="P10" class="checkbox" order="11" visibility="1"/><column name="p11" header="P12" class="checkbox" order="12" visibility="1"/><column name="p12" header="P12" class="checkbox" order="13" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="14" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Publish";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="title" header="Název" class="" order="1" visibility="1"/><column name="description" header="Obsah" class="" order="2" visibility="1"/><column name="perex" header="Perex" class="" order="3" visibility="0"/><column name="link" header="Odkaz" class="url" order="4" visibility="0"/><column name="category_path" header="Umístění" class="" order="5" visibility="1"/><column name="nazev_category" header="Rubrika" class="" order="6" visibility="0"/><column name="autor" header="Autor" class="nick" order="7" visibility="1"/><column name="editor" header="Editor" class="nick" order="8" visibility="1"/><column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="10" visibility="1"/><column name="PageTimeStamp" header="Vloženo" class="datetime" order="9" visibility="1"/><column name="PublicDate" header="Publikováno" class="datetime" order="11" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "RadekObjednavky";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="order_code" header="Doklad" class="code" order="3" visibility="1"/><column name="product_code" header="Číslo položky" class="text" order="4" visibility="1"/><column name="product_name" header="Název položky" class="text" order="5" visibility="1"/><column name="qty" header="Množství" class="money" order="6" visibility="1"/><column name="tax_name" header="DPH" class="text" order="7" visibility="1"/><column name="price" header="Cena" class="money" order="7" visibility="1"/><column name="nazev_mj" header="MJ" class="text" order="7" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="8" visibility="1"/><column name="price_total" header="Celkem" class="money" order="9" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "ProductCategory";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="" class="icon" order="2" visibility="1"/><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="parent_name" header="Nadřízený" class="text" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "ProductVyrobce";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="" class="icon" order="2" visibility="1"/><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="parent_name" header="Nadřízený" class="text" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "ProductZaruka";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="" class="icon" order="2" visibility="1"/><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="parent_name" header="Nadřízený" class="text" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Attributes";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="" class="icon" order="2" visibility="1"/><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="parent_name" header="Nadřízený" class="text" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "NextId";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="nazev" header="Název" class="text" order="1" visibility="1"/><column name="rada" header="Řada" class="text" order="2" visibility="1"/><column name="polozka" header="Položka" class="text" order="3" visibility="1"/><column name="delka" header="Délka řady" class="text" order="3" visibility="1"/><column name="tabulka" header="Tabulka" class="text" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Doprava";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="description" header="" class="icon" order="2" visibility="1"/><column name="price_value" header="Cena popis" class="text" order="3" visibility="1"/><column name="price" header="Cena" class="money" order="4" visibility="1"/><column name="osobni_odber" header="Odběrné místo" class="checkbox" order="5" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Platba";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="description" header="" class="icon" order="2" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Catalog";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="title" header="Název" class="text" order="1" visibility="1"/><column name="status" header="Stav" class="checkbox" order="1" visibility="1"/><column name="description" header="Popis" class="icon" order="1" visibility="1"/><column name="dic" header="DIČ" class="" order="2" visibility="1"/><column name="nazev_category" header="Kategorie" class="" order="2" visibility="1"/><column name="address2" header="Město" class="" order="2" visibility="1"/><column name="email" header="Email" class="email" order="2" visibility="1"/><column name="ico" header="IČO" class="" order="2" visibility="1"/><column name="lng" header="Lng" class="" order="2" visibility="1"/><column name="zip_code" header="PSČ" class="" order="2" visibility="1"/><column name="telefon" header="Telefon" class="" order="2" visibility="1"/><column name="address1" header="Ulice" class="" order="2" visibility="1"/><column name="lat" header="Lat" class="" order="2" visibility="1"/><column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="7" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Translator";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="name" header="Překlad" class="text" order="3" visibility="1"/><column name="keyword" header="Klíčové slovo" class="" order="1" visibility="1"/><column name="code" header="Jazyk" class="" order="2" visibility="1"/><column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="4" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="5" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "Blacklist";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="ip" header="IP" class="" order="1" visibility="1"/><column name="active" header="Aktivní" class="checkbox" order="2" visibility="1"/><column name="pokusy" header="Pokusy" class="" order="3" visibility="1"/><column name="description" header="description" class="" order="4" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="14" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Message";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="autor_jmeno" header="Odesílatel" class="" order="1" visibility="1"/><column name="adresat_jmeno" header="Adresat" class="" order="2" visibility="1"/><column name="message" header="Zpráva" class="" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="4" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Mj";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="name" header="Název" class="" order="1" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="2" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Comments";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="nick" header="Uživatel" class="" order="1" visibility="1"/><column name="email" header="Email" class="email" order="2" visibility="1"/><column name="text" header="Komentář" class="desciption" order="3" visibility="1"/><column name="ip" header="IP" class="desciption" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="4" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "Mailing";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="email" header="Adresát" class="" order="1" visibility="1"/><column name="subject" header="předmět" class="" order="2" visibility="1"/><column name="description" header="Zpráva" class="" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="4" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "SmsGate";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="phone" header="Telefon" class="" order="1" visibility="1"/><column name="message" header="Zpráva" class="" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="4" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "ProductVarianty";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition>
<column name="code" header="Číslo" class="code" order="1" visibility="1"/>
<column name="name" header="Název" class="" order="2" visibility="1"/>
<column name="price" header="Cena" class="money" order="3" visibility="1"/>
<column name="qty" header="Množství" class="numeric" order="4" visibility="1"/>
<column name="params" header="Parametry" class="" order="5" visibility="1"/>
<column name="order" header="Pořadí" class="" order="5" visibility="1"/>
<column name="dostupnost_nazev" header="Dostunost" class="" order="5" visibility="1"/>
<column name="TimeStamp" header="Vloženo" class="datetime" order="8" visibility="1"/>
</definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "ProductStavy";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="cislo" header="Číslo" class="code" order="1" visibility="1"/><column name="title" header="Název" class="text" order="2" visibility="1"/><column name="qty" header="Aktuální stav" class="money" order="3" visibility="1"/><column name="qty_min" header="Min. stav" class="money" order="4" visibility="1"/><column name="qty_max" header="Max. stav" class="money" order="5" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="6" visibility="0"/></definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "ShopPlatby";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="label" header="Text" class="code" order="1" visibility="1"/><column name="status" header="Stav" class="code" order="1" visibility="1"/><column name="method" header="Metoda" class="code" order="1" visibility="1"/><column name="transId" header="ID transakce" class="code" order="1" visibility="1"/><column name="code" header="Var. symbol" class="code" order="1" visibility="1"/><column name="amout" header="Částka" class="money" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="4" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "ProductDostupnost";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="" class="icon" order="2" visibility="1"/><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="hodiny" header="Hodiny" class="text" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "FotoGallery";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition>
		<column name="thumb" header="Náhled" class="thumb" order="1" visibility="1"/>
		<column name="description" header="Popis" class="icon" order="2" visibility="1"/>
		<column name="file" header="Název" class="Soubor" order="1" visibility="1"/>
		<column name="size" header="Velikost" class="" order="4" visibility="1"/>
		<column name="nick" header="Vložil" class="" order="5" visibility="1"/>
		<column name="type" header="Typ" class="" order="3" visibility="1"/>
		<column name="TimeStamp" header="Vloženo" class="datetime" order="6" visibility="1"/>
		</definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "Files";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="description" header="Popis" class="icon" order="2" visibility="1"/><column name="file" header="Název" class="Soubor" order="1" visibility="1"/><column name="size" header="Velikost" class="" order="4" visibility="1"/><column name="nick" header="Vložil" class="" order="5" visibility="1"/><column name="type" header="Typ" class="" order="3" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="6" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "ProductCenik";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="name" header="Název" class="text" order="1" visibility="1"/><column name="description" header="" class="icon" order="7" visibility="1"/><column name="sleva" header="Sleva" class="text" order="2" visibility="1"/><column name="typ_slevy" header="Typ" class="text" order="3" visibility="1"/><column name="priorita" header="Priorita" class="text" order="4" visibility="1"/><column name="platnost_do" header="Platnost do" class="datetime" order="6" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="8" visibility="1"/><column name="platnost_od" header="Platnost od" class="datetime" order="5" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "Kurz";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="kod" header="Kód" class="" order="1" visibility="1"/><column name="name" header="Název" class="" order="2" visibility="1"/><column name="kurz" header="Kurz" class="money" order="3" visibility="1"/><column name="mnozstvi" header="Množství měny" class="numeric" order="4" visibility="1"/><column name="datum" header="Datum" class="datetime" order="5" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="6" visibility="1"/><column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);

		$data = array();
		$data["modelname"] = "ProductCena";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition>
<column name="product_cislo" header="Číslo" class="" order="1" visibility="1" edit="0"/>
<column name="product_name" header="Zboží" class="" order="2" visibility="1" edit="0"/>
<column name="cenik_name" header="Kód ceny" class="" order="3" visibility="1" edit="0"/>
<column name="prodcena" header="Základní cena" class="money" order="4" visibility="1" edit="0"/>
<column name="cenik_cena" header="Ceníková cena" class="money" order="5" visibility="1" edit="1"/>
<column name="sleva" header="Sleva" class="money" order="6" visibility="1" edit="1"/>
<column name="typ_slevy" header="Druh slevy" class="" order="7" visibility="1" edit="1"/>
<column name="platnost_od" header="Platná od" class="datetime" order="8" visibility="1" edit="1"/>
<column name="platnost_do" header="Platná do" class="datetime" order="9" visibility="1" edit="1"/>
<column name="TimeStamp" header="Vloženo" class="datetime" order="10" visibility="1" edit="0"/>
<column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="11" visibility="0" edit="0"/>
</definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "CatalogZakazniku";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="title" header="Název" class="text" order="1" visibility="1"/><column name="status" header="Stav" class="checkbox" order="1" visibility="1"/><column name="description" header="Popis" class="icon" order="1" visibility="1"/><column name="dic" header="DIČ" class="" order="2" visibility="0"/><column name="email" header="Email" class="email" order="2" visibility="1"/><column name="address2" header="Město" class="" order="2" visibility="1"/><column name="ico" header="IČ" class="" order="2" visibility="1"/><column name="nazev_category" header="Kategorie" class="" order="2" visibility="1"/><column name="address1" header="Ulice" class="" order="2" visibility="1"/><column name="zip_code" header="PSČ" class="" order="2" visibility="1"/><column name="lng" header="Lng" class="" order="2" visibility="0"/><column name="telefon" header="Telefon" class="" order="2" visibility="1"/><column name="lat" header="Lat" class="" order="2" visibility="0"/><column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="7" visibility="1"/><column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/></definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "CatalogFirem";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition><column name="title" header="Název" class="" order="1" visibility="1" edit="0"/><column name="status" header="Stav" class="checkbox" order="1" visibility="0" edit="0"/><column name="description" header="Popis" class="icon" order="1" visibility="0" edit="0"/><column name="ico" header="IČ" class="text" order="2" visibility="0" edit="0"/><column name="lng" header="Lng" class="" order="2" visibility="0" edit="0"/><column name="nazev_category" header="Kategorie" class="" order="2" visibility="1" edit="0"/><column name="dic" header="DIČ" class="text" order="2" visibility="0" edit="0"/><column name="lat" header="Lat" class="" order="2" visibility="0" edit="0"/><column name="email" header="Email" class="email" order="3" visibility="1" edit="0"/><column name="address2" header="Město" class="text" order="4" visibility="1" edit="0"/><column name="zip_code" header="PSČ" class="" order="5" visibility="1" edit="0"/><column name="address1" header="Ulice" class="" order="6" visibility="1" edit="0"/><column name="telefon" header="Telefon" class="" order="7" visibility="1" edit="0"/><column name="PageChangeTimeStamp" header="Upraveno" class="datetime" order="8" visibility="0" edit="0"/><column name="PageTimeStamp" header="Vloženo" class="datetime" order="9" visibility="1" edit="0"/></definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "ImportProductSetting";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition>
<column name="description" header="" class="icon" order="2" visibility="1"/>
<column name="name" header="Název" class="text" order="1" visibility="1"/>
<column name="url" header="Adresa XML" class="text" order="3" visibility="1"/>
<column name="TimeStamp" header="Vloženo" class="datetime" order="7" visibility="1"/>
</definition>';
		array_push($filterViewDefinitionData, $data);


		$data = array();
		$data["modelname"] = "Basket";
		$data["isDefault"] = 1;
		$data["definition"] = '<definition>
<column name="product_code" header="Číslo" class="code" order="1" visibility="1"/>
<column name="product_name" header="Název" class="text" order="2" visibility="1"/>
<column name="nazev_category" header="Umístění" class="code" order="3" visibility="0"/>
<column name="nazev_skupina" header="Skupina" class="text" order="4" visibility="1"/>
<column name="nazev_vyrobce" header="Značka" class="text" order="5" visibility="1"/>
<column name="prodcena" header="Prodejní cena" class="money" order="6" visibility="1"/>
<column name="prodcena_sdph" header="Prodejní cena s DPH" class="money" order="6" visibility="1"/>
<column name="qty" header="Množství" class="money" order="7" visibility="1"/>
<column name="TimeStamp" header="Vloženo" class="datetime" order="8" visibility="1"/>
<column name="basket_sleva" header="Sleva" class="money" order="9" visibility="1"/>
<column name="basket_id" header="Košík Id" class="code" order="9" visibility="1"/>
<column name="basket_typ_slevy" header="Typ slevy" class="code" order="10" visibility="1"/>
<column name="ChangeTimeStamp" header="Upraveno" class="datetime" order="14" visibility="0"/>
<column name="thumb" header="Náhled" class="thumb" order="1" visibility="1"/>
</definition>';
		array_push($filterViewDefinitionData, $data);


$data = array();
$data["modelname"] = "UserActivityMonitor";
$data["isDefault"] = 1;
$data["definition"] = '<definition>
		<column name="from_url" header="Odkud" class="" order="1" visibility="1"/>
		<column name="to_url" header="Kam" class="" order="3" visibility="1"/>
		<column name="ip_adresa" header="IP" class="" order="3" visibility="1"/>
		<column name="TimeStamp" header="Vloženo" class="datetime" order="4" visibility="1"/>
</definition>';
		array_push($filterViewDefinitionData, $data);



		return $filterViewDefinitionData;
	}

	private function getUpsize()
	{
		$sql = "SELECT * FROM `" . T_OPTIONS . "` where  `key` ='UPSIZE'";
		$nastaveni = $this->sql->get_row($sql);
		//print $sql;
		//print_r($nastaveni);
		//exit;
		$upsize = (int) $nastaveni->value;

		if ($this->upsize > $upsize) {




			if (12 > $upsize) {

				// Opravný script pro nastavení rozmezí cen u variant
				$sql = "update `mm_products` p left join mm_products_version v  on p.id=v.page_id and p.version=v.version
				set p.max_prodcena = v.prodcena,
				p.max_prodcena_sdph = v.prodcena_sdph,
				p.min_prodcena = v.prodcena,
				p.min_prodcena_sdph = v.prodcena_sdph
				";
				$this->sql->get_row($sql);

				$sql = "update `mm_products` left join (
				SELECT product_id,max(price) as max_price,max(price_sdani) as max_price_sdani,
				min(price) as min_price, min(price_sdani) as min_price_sdani FROM `mm_product_varianty` where price is not null  and isDeleted=0
				group by product_id) v on `mm_products`.id = v.product_id
				set max_prodcena = v.max_price,
				max_prodcena_sdph = v.max_price_sdani,
				min_prodcena = v.min_price,
				min_prodcena_sdph = v.min_price_sdani
				where v.product_id in (
				SELECT product_id FROM `mm_product_varianty` where price is not null  and isDeleted=0
				group by product_id)	";
				$this->sql->get_row($sql);


				$sql = "update `" . T_OPTIONS . "` set `value` = '" . $this->upsize . "' where  `key` ='UPSIZE'";
				$this->sql->get_row($sql);

			}



		}
	}


	public function check_version(){

		$query = "SELECT * FROM `" . T_OPTIONS . "` WHERE `key`='VERSION_RS' LIMIT 1";
		$row = $this->sql->get_row($query);
		$aktualni_verze = $row->value * 1;
		if ($this->version > $aktualni_verze) {
			return false;
		}
		return true;
	}
	public function insert_data(){

		$this->insert_languages();
		$this->insert_role();
		$this->insert_options();
		$this->insert_category();
		$this->insert_syscategory();
		$this->insert_users();

		$this->insert_mesta();
		$this->insert_kraje();
		//		$this->insert_menu();
		$this->insert_svatky();
		$this->insert_eshop_settings();
		$this->insert_dph();
		$this->insert_mj();
		$this->insert_zpusob_dopravy();
		$this->insert_zpusob_platby();
		$this->insert_nextid();
		$this->insert_pageTypes();
		$this->insert_orderStatus();

		$this->insert_typyFaktur();
		$this->insert_moduly();

		$this->insert_dostupnost();
	}

	private function insert_orderStatus()
	{

		$model = new models_NextId();

		$data = array();
		$data["name"] = "Přijatá";
		$data["order"] = 4;
		$model->insertRecords(T_ORDER_STATUS,$data);

		$data = array();
		$data["name"] = "Vyexpedovaná";
		$data["order"] = 2;
		$model->insertRecords(T_ORDER_STATUS,$data);

		$data = array();
		$data["name"] = "Vyřizuje se";
		$data["order"] = 3;
		$model->insertRecords(T_ORDER_STATUS,$data);

		$data = array();
		$data["name"] = "Vyřízená";
		$data["order"] = 1;
		$model->insertRecords(T_ORDER_STATUS,$data);
	}
	private function insert_pageTypes()
	{

		$model = new models_NextId();

		$data = array();
		$data["name"] = "Příspěvky";
		$model->insertRecords(T_PAGE_TYPE,$data);

		$data = array();
		$data["name"] = "Rubriky";
		$model->insertRecords(T_PAGE_TYPE,$data);

		$data = array();
		$data["name"] = "Produkty";
		$model->insertRecords(T_PAGE_TYPE,$data);

		$data = array();
		$data["name"] = "Katalog";
		$model->insertRecords(T_PAGE_TYPE,$data);
	}
	private function insert_nextid()
	{

		$model = new models_NextId();

		$data = array();
		$data["tabulka"] = "MM_PRODUCTS";
		$data["polozka"] = "cislo";
		$data["rada"] = "22";
		$data["delka"] = 8;
		$data["nazev"] = "Produkty";
		$model->insert($data);

		$data = array();
		$data["tabulka"] = "MM_SHOP_ORDERS";
		$data["polozka"] = "order_code";
		$data["rada"] = "22";
		$data["delka"] = 8;
		$data["nazev"] = "Objednávky";
		$model->insert($data);

		$data = array();
		$data["tabulka"] = "MM_FAKTURY";
		$data["polozka"] = "code";
		$data["rada"] = "22";
		$data["delka"] = 8;
		$data["nazev"] = "Faktury";
		$model->insert($data);
	}
	private function insert_options(){


		$model = new models_Settings();

		$demodata = $this->getSettingsData();

		foreach ($demodata as $key => $val) {

			$data = array();

			$data["key"] = $key;
			$data["value"] = $val;
			$model->insert($data);
		}





	}


	private function insert_typyFaktur()
	{
		$model = new models_TypyFaktur();

		$demodata = $this->getTypyFakturData();

		foreach ($demodata as $key => $data) {
			$model->insert($data);
		}
	}
	public function getTypyFakturData()
	{
		$demodata = array();
		$i=0;
		$demodata[$i]["id"] = 1;
		$demodata[$i]["name"] = "standardni_faktura";
		$i++;
		$demodata[$i]["id"] = 2;
		$demodata[$i]["name"] = "proforma_faktura";
		$i++;
		$demodata[$i]["id"] = 3;
		$demodata[$i]["name"] = "zalohova_faktura";
		$i++;
		$demodata[$i]["id"] = 4;
		$demodata[$i]["name"] = "dobropis";
		$i++;
		return $demodata;

	}

	/***
	 * Data nastavení CMS
	 * */
	public function getSettingsData()
	{
		$demodata = array();
		$demodata["google_analytics_key"] = "";
		$demodata["SERVER_ROBOTS"] = "index,follow";
		$demodata["meta_refresh"] = "3600";
		$demodata["SERVER_KEYWORDS"] = "Keywords - RS Gambík";
		$demodata["SERVER_NAME"] = $_SERVER["SERVER_NAME"];
		$demodata["SERVER_LANG"] = "cs-CZ";
		$demodata["SERVER_DESCRIPTION"] = "Popis - RS Gambík";
		$demodata["SERVER_TITLE"] = "Titulek - RS Gambík";
		$demodata["URL_DOMAIN"] = $_SERVER["HTTP_HOST"];
		$demodata["URL_HOME_REL"] = $this->url_home_rel;
		$demodata["URL_HOME"] = $this->url_home;
		$demodata["PAGE_HOME"] = "main.php";
		$demodata["SERVER_CSS"] = $this->url_home_rel . "js/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.min.css,
" . $this->url_home_rel . "js/bootstrap/bootstrap.min.css,
" . $this->url_home_rel . "js/fancybox/source/jquery.fancybox.css,
" . $this->url_home_rel . "public/style/default.css,
" . $this->url_home_rel . "style/font-awesome/css/font-awesome.min.css";
		$demodata["SERVER_JS"] = $this->url_home_rel . "js/jquery.js[]
" . $this->url_home_rel . "js/bootstrap/bootstrap.min.js[]
" . $this->url_home_rel . "js/jquery-ui-1.10.4/js/jquery-ui-1.10.4.min.js[]
" . $this->url_home_rel . "js/fancybox/source/jquery.fancybox.js[]
" . $this->url_home_rel . "js/slides.min.jquery.js[]
" . $this->url_home_rel . "public/js/main.js";
		$demodata["COMPANY_NAME"] = "";
		$demodata["COMPANY_ADRESS1"] = "";
		$demodata["COMPANY_ADRESS2"] = "";
		$demodata["CONTACT_PERSON"] = "";
		$demodata["CONTACT_EMAIL"] = "";
		$demodata["LICENCE_KEY"] = LICENCE_KEY;
		$demodata["SERVER_GOOGLEBOT"] = "index,follow";
		$demodata["SERVER_AUTHOR"] = "CMS Gambík";
		$demodata["VERSION_DATE"] = $this->version_date;
		$demodata["INSTALL_DATE"] = $this->install_date;
		$demodata["UPSIZE"] = $this->upsize;
		$demodata["PAGETITLE_PREFIX"] = "";
		$demodata["SERVER_POZN"] = "";
		$demodata["MENU_ROOT_ID"] = "1";
		$demodata["SERVER_FAVICON"] = "";
		$demodata["TINY_CSS"] = '* {
font-family: Arial,Helvetica,sans-serif;
font-size: 12px;}img.zleva {
	float: left;
	margin-right: 10px;
}
img.zprava {
	float: right;
	margin-left: 10px;
}
a.lightbox {}
.text-center { text-align:center; }
.text-right { text-align:right; }
.text-left{ text-align:left; }
.text-full { text-align:justify;}
';


		$value='@[id|class|title|dir<ltr?rtl|lang|xml::lang"
+ "],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
+ "name|href|target|title|class],strong/b,em/i,strike,u,"
+ "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
+ "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
+ "-blockquote,-table[border=1|cellspacing=0|cellpadding=0|width|frame|rules|"
+ "height|align|summary],-tr[rowspan|width|"
+ "height|align|valign],tbody,thead,tfoot,"
+ "#td[colspan|rowspan|width|height|align|valign"
+ "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
+ "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
+ "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
+ "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
+ "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
+ "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
+ "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
+ "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
+ "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
+ "q[cite],samp,select[disabled|multiple|name|size],small,"
+ "textarea[cols|rows|disabled|name|readonly],tt,var,big,iframe[src|width|height]';

		$demodata["TINY_VALID"] = $value;
		$demodata["TINY_WIDTH"] = "670";
		$demodata["TINY_HEIGHT"] = "800";
		$demodata["TINY_BUTTONS1"] = "undo,redo,|,pastetext,pasteword,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect";
		$demodata["TINY_BUTTONS2"] = "bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,cleanup,code,|,table,|,hr,removeformat,visualaid,|,forecolor,backcolor";
		$demodata["TINY_BUTTONS3"] = "";
		$demodata["TINY_MODE"] = "textareas";
		$demodata["TINY_PLUGINS"] = "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template";

		$demodata["VERSION_RS"] = $this->version;
		$demodata["VERSION_CATEGORY"] = "0";
		$demodata["VERSION_POST"] = "0";
		$demodata["VERSION_CATALOG"] = "0";
		$demodata["VERSION_PRODUCT"] = "0";

		$demodata["MSG_REFRESH"] = "0";
		$demodata["MAX_WIDTH"] = "640";

		$demodata["MAX_HEIGHT"] = "640";
		$demodata["PATH_WATERMARK"] = "";
		$demodata["WATERMARK_POS"] = "5";


		$demodata["DATA_EXTENSION_WHITELIST"] = "txt,pdf,xls,xlsx,doc,rtf,docx,swf,mp3,png,jpg,bmp,gif,zip,exe,xml";
		$demodata["IMAGE_EXTENSION_WHITELIST"] = "png,jpg,jpeg,bmp,gif";
		$demodata["FACEBOOK_SECRET"] = "";
		$demodata["FACEBOOK_API_ID"] = "";

		$demodata["SMSBRANA"] = "smsbarana.cz";
		$demodata["SMSBRANA_LOGIN"] = "";
		$demodata["SMSBRANA_PWD"] = "";
		$demodata["DEFAULT_LIMIT"] = "100";

		$demodata["IS_RESPONSIVE"] = "0";

		$demodata["KURZY_IMPORT_LIST"] = "EUR|USD";

		$demodata["KURZY_IMPORT_CRON"] = "99";




		$demodata["FILE_SIZE_LIMIT"] = "5";
		$demodata["FOTO_SIZE_LIMIT"] = "2";


		$demodata["POST_URL_ID_PREFIX"] = "0";

		$demodata["MODUL_ESHOP"] = "0";


		// PŘESUNUTO Z ESHOPU
		$demodata["EMAIL_USERNAME"] = "";
		$demodata["EMAIL_PWD"] = "";
		$demodata["EMAIL_SMTP_SERVER"] = "";


		$demodata["EMAIL_SMTP_SEND"] = "1";
		$demodata["EMAIL_SMTP_AUTH"] = "0";
		$demodata["EMAIL_SMTP_PORT"] = "";
		$demodata["EMAIL_SMTP_CERT"] = "";
		$demodata["EMAIL_ORDER_ALIAS"] = "";

		$demodata["BCC_EMAIL"] = "";
		$demodata["EMAIL_ORDER"] = "";

		$demodata["MENU_CATEGORY_LIST"] = ""; // kategorie pro slider


		$demodata["reCAPTCHA_SITE_KEY"] = "";
		$demodata["reCAPTCHA_SECRET_KEY"] = "";

		$demodata["FOOTER_JS"] = "0";

		$demodata["SLIDER_CATEGORY"] = "0"; // kategorie pro slider
		$demodata["SLIDER_CATEGORY_LIMIT"] = "0"; // kategorie pro slider

		$demodata["WEB_ID"] = "0";

		$demodata["FACEBOOK_PAGE"] = "";

		// upozornění na souhlas užíváním cookies
		$demodata["COOKIES_EU"] = "0";

		// id loga
		$demodata["LOGO_FILE_ID"] = "";

		return $demodata;
	}

	private function addCategory($title,$url,$category_id = null,$description=null)
	{
		$model = new models_Category();
		$data = array();
		$data["user_id"] = 2;
		$data["category_id"] = $category_id;
		$model->insert($data);

		$id = $model->insert_id;

		$model = new models_CategoryVersion();
		$data = array();
		$data["page_id"] = $id;
		$data["lang_id"] = 6;
		$data["user_id"] = 2;
		$data["title"] = $title;
		$data["description"] = $description;
		$data["url"] = $url;

			$data["category_id"] = $category_id;
		$model->insert($data);

		return $id;
	}

	private function addPost($title,$url,$category_id = null,$description=null)
	{
		$model = new models_Publish();
		$data = array();
		$data["user_id"] = 2;
		$data["category_id"] = $category_id;
		$data["PublicDate"] = date("Y-m-d H:i:s");
		$model->insert($data);

		$id = $model->insert_id;

		$model = new models_PublishVersion();
		$data = array();
		$data["page_id"] = $id;
		$data["lang_id"] = 6;
		$data["user_id"] = 2;
		$data["title"] = $title;
		$data["description"] = $description;
		$data["url"] = $url;

		$data["category_id"] = $category_id;
		$model->insert($data);

		return $id;
	}


	/**
	 * Založí základní kategorie do stromu webu
	 * **/
	private function insert_category(){

		$title = "Veřejná část";

		$description = '<h1>Vítejte!</h1>
<p>Nacházíte se na úvodní stránce Vašeho nového webu, který pro Vás připravujeme.</p>
<p>Vaše stránky budou moderní, validní a dobře čitelné pro vyhledávače.</p>';
		$url = "root";

		$id = $this->addCategory($title,$url,null,$description);

		// Secret
		$title = "Skryté";
		$url = "secret";

		$id = $this->addCategory($title,$url);


	}

	/**
	 * Založí kategorii pro menu admina
	 * **/
	private function addSysCategory($title,$url,$category_id = null, $icon = null, $poradi = 0)
	{

		// Ověřím, že stránka neexistuje podle url

		$model = new models_SysCategory();
		$modelVersion = new models_SysCategoryVersion();
		$detail = $model->getDetailByUrl($url,"cs");
		//print_r($detail);
		if (!$detail) {
			$data = array();
			$data["user_id"] = null;
			$data["category_id"] = $category_id;

			$data["icon_class"] = $icon;
			$data["level"] = $poradi;
			$model->insert($data);

			$id = $model->insert_id;


			$data = array();
			$data["page_id"] = $id;
			$data["lang_id"] = 6;
			$data["user_id"] = null;
			$data["title"] = $title;
			$data["url"] = $url;
			$data["category_id"] = $category_id;




			//	$data["category_id"] = $category_id;
			$modelVersion->insert($data);
			return $id;
		} else {

			// umístění neopravovat, pokud si ho uživatel změnil!
			/*$data = array();
			   $data["category_id"] = $category_id;
			   $model->updateRecords($model->getTableName(),$data,"id=" . $detail->id);
			   $modelVersion->updateRecords($modelVersion->getTableName(),$data,"page_id=" . $detail->id);*/
			print "Nabídka " . $title . " již existuje.<br />";
			return $detail->id;
		}



	}

	/***
	 * Data nastavení ESHOP
	 * */
	public function getShopSettingsData()
	{
		$demodata = array();
		$demodata["MENA"] = "Kč";
		$demodata["COMPANY_NAME"] = "Název eshopu";
		$demodata["ADDRESS1"] = "";
		$demodata["ADDRESS2"] = "";
		$demodata["CITY"] = "";
		$demodata["ZIP_CODE"] = "";
		$demodata["COUNTRY"] = "";
		$demodata["ICO"] = "";
		$demodata["DIC"] = "";
		$demodata["IBAN"] = "";
		$demodata["UCET"] = "";


		$demodata["NEXTID_ORDER"] = "";
		$demodata["NEXTID_PRODUCT"] = "";
		$demodata["OR"] = "";
		$demodata["PLATCE_DPH"] = "0";
		$demodata["FORMAT_QTY"] = "";

		$demodata["FORMAT_PRICE"] = "";
		$demodata["SLCT_QTY"] = "";
		$demodata["PRICE_TAX"] = "";
		$demodata["EMAIL_ORDER"] = "";
		/*
		   $demodata["EMAIL_USERNAME"] = "";
		   $demodata["EMAIL_PWD"] = "";
		   $demodata["EMAIL_SMTP_SERVER"] = "";


		   $demodata["EMAIL_SMTP_SEND"] = "1";
		   $demodata["EMAIL_SMTP_AUTH"] = "0";
		   $demodata["EMAIL_ORDER_ALIAS"] = "";
		*/

		$demodata["EMAIL_ORDER_SUBJECT"] = "Objednávka";
		$demodata["INFO_EMAIL"] = "";
		$demodata["BCC_EMAIL"] = "";
		$demodata["KONTAKT_EMAIL"] = "";
		//	$demodata["EMAIL_SMTP_SERVER"] = "";


		$demodata["KONTAKT_TELEFON"] = "";
		$demodata["LOGO_PDF"] = "";
		$demodata["EMAIL_ORDER_BODY_CS"] = "Dobrý den,
zasíláme potrvrzení o přijetí objednávky.";
		$demodata["DOPRAVNE_ZA_MJ"] = "";
		$demodata["DOPRAVNE_ZDARMA"] = "";
		$demodata["SLCT_TAX"] = "0";
		$demodata["PRODUCT_NEXTID_AUTO"] = "0";
		$demodata["CATEGORY_ROOT"] = "1";


		$demodata["CISLO01"] = "";
		$demodata["CISLO02"] = "";
		$demodata["CISLO03"] = "";
		$demodata["CISLO04"] = "";
		$demodata["CISLO05"] = "";

		$demodata["CISLO06"] = "";
		$demodata["CISLO07"] = "";
		$demodata["CISLO08"] = "";
		$demodata["CISLO09"] = "";
		$demodata["CISLO10"] = "";

		$demodata["CISLO01_CHECK"] = "0";
		$demodata["CISLO02_CHECK"] = "0";
		$demodata["CISLO03_CHECK"] = "0";
		$demodata["CISLO04_CHECK"] = "0";
		$demodata["CISLO05_CHECK"] = "0";

		$demodata["CISLO06_CHECK"] = "0";
		$demodata["CISLO07_CHECK"] = "0";
		$demodata["CISLO08_CHECK"] = "0";
		$demodata["CISLO09_CHECK"] = "0";
		$demodata["CISLO10_CHECK"] = "0";


		$demodata["POLOZKA01"] = "";
		$demodata["POLOZKA02"] = "";
		$demodata["POLOZKA03"] = "";
		$demodata["POLOZKA04"] = "";
		$demodata["POLOZKA05"] = "";

		$demodata["POLOZKA06"] = "";
		$demodata["POLOZKA07"] = "";
		$demodata["POLOZKA08"] = "";
		$demodata["POLOZKA09"] = "";
		$demodata["POLOZKA10"] = "";


		$demodata["POLOZKA01_CHECK"] = "0";
		$demodata["POLOZKA02_CHECK"] = "0";
		$demodata["POLOZKA03_CHECK"] = "0";
		$demodata["POLOZKA04_CHECK"] = "0";
		$demodata["POLOZKA05_CHECK"] = "0";

		$demodata["POLOZKA06_CHECK"] = "0";
		$demodata["POLOZKA07_CHECK"] = "0";
		$demodata["POLOZKA08_CHECK"] = "0";
		$demodata["POLOZKA09_CHECK"] = "0";
		$demodata["POLOZKA10_CHECK"] = "0";



		$demodata["RAZITKO_OBJ_PDF"] = "";
		$demodata["RAZITKO_FAK_PDF"] = "";
		$demodata["HEUREKA_CODE"] = "";
		$demodata["HEUREKA_ENABLED"] = "0";


		$demodata["SPLATNOST"] = "0";
		$demodata["CISLO_FAK_OBJ"] = "0";

		$demodata["AGMO_TEST"] = "0";
		$demodata["AGMO_URL"] = "";
		$demodata["AGMO_MERCHANT"] = "";
		$demodata["AGMO_SECRET"] = "";

		$demodata["PRODUCT_VARIANTY"] = "0";
		$demodata["SLEVA_DOKLAD_TISK"] = "0";


		$demodata["PAYU_POS_ID"] = "";
		$demodata["PAYU_KEY1"] = "";
		$demodata["PAYU_KEY2"] = "";

		$demodata["SKLAD_AKTIVNI"] = "0";
		$demodata["SKLAD_BLOKACE"] = "0";

		$demodata["PRODUCT_LIST_LIMIT"] = "25"; // POČET PRODUKTŮ NA STRÁNCE

		$demodata["ROW_PRODUCT_COUNT"] = "3"; // POČET PRODUKTŮ NA ŘÁDCE

		$demodata["PAGE_PODCATEGORY"] = "1"; // ZOBRAZENÍ PODKATEGORII NA STRÁNCE
		$demodata["PRODUCT_FILTER"] = "1"; // ZOBRAZENÍ FILTRU

		$demodata["PRODUCT_LIST_TYPE"] = "0"; // KATALOG / TABULKA

		$demodata["SLIDER_CATEGORY"] = "0"; // kategorie pro slider
		$demodata["SLIDER_CATEGORY_LIMIT"] = "0"; // kategorie pro slider

		$demodata["ESHOP_CATEGORY_LIST"] = ""; // kategorie pro slider

		$demodata["BASKET_SLEVY"] = "0"; // kategorie pro slider

		$demodata["PRODUCT_THUMB_WIDTH"] = "190";
		$demodata["PRODUCT_THUMB_HEIGHT"] = "200";

		$demodata["MSG_NENALEZENO"] = '<p>Nápověda:<br />
    Ujistěte se, že jste napsali správně to, co hledáte.<br />
    Zkuste vyhledat podobná slova.<br />
    Zkuste obecnější dotaz.</p>';

		$demodata["LEFT_PANEL_ON"] = "1";
		$demodata["LEFT_PANEL_SLIM"] = "1";
		$demodata["RIGHT_PANEL_SLIM"] = "1";
		$demodata["RIGHT_PANEL_ON"] = "0";


		$demodata["SHOP_LEFT_PANEL_ON"] = "1";
		$demodata["SHOP_LEFT_PANEL_SLIM"] = "1";
		$demodata["SHOP_RIGHT_PANEL_SLIM"] = "1";
		$demodata["SHOP_RIGHT_PANEL_ON"] = "0";

		$demodata["ESHOP_MENU_POS"] = "LEFT";
		$demodata["ESHOP_MENU_MAIN_POS"] = "LEFT";

		$demodata["ESHOP_TEMPLATE"] = "1";

		$demodata["ADD_BASKET_LIST"] = "0";
		$demodata["ADD_BASKET_DETAIL"] = "1";


		$demodata["SEARCH_BOX_POS"] = "LEFT";
		$demodata["PRODUCT_HISTORY_POS"] = "RIGHT";
		$demodata["PRODUCT_AKCE_POS"] = "RIGHT";
		$demodata["ESHOP_SLIDER_POS"] = "TOP";

		$demodata["ESHOP_SLIDER_WIDTH"] = "748";
		$demodata["ESHOP_SLIDER_HEIGHT"] = "425";
		$demodata["BASKET_CALLBACK_URL"] = "";


		$demodata["RELATIVE_PRODUCTS_LIMIT"] = "8";
		$demodata["TIP_PRODUCTS_LIMIT"] = "8";
		$demodata["TIP_PRODUCTS_ORDER"] = "rand()";
		$demodata["TIP_PRODUCTS_GROUP"] = "1";

		$demodata["ESHOP_SLIDER_PAGE"] = "MAIN";
		$demodata["LOGO_MENU"] = "WITHOUT_LOGO";



		return $demodata;
	}

	public function insert_eshop_settings(){

		$model = new models_Eshop();

		$demodata = $this->getShopSettingsData();

		foreach ($demodata as $key => $val) {

			$data = array();

			$data["key"] = $key;
			$data["value"] = $val;
			$model->insert($data);
		}

	}

	private function drop($table){

		$query = "DROP TABLE IF EXISTS `" . $table . "`";
		return $this->sql->query($query);

	}

	private function create_category_view()
	{
		$query = "CREATE TABLE IF NOT EXISTS `view_category` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`ChangeTimeStamp` datetime NOT NULL,
		`TimeStamp` datetime NOT NULL,
		`category_id` int(11) NOT NULL,
		`lang_id` int(11) NOT NULL,
		`parent_id` int(11) NOT NULL,
		`serial_cat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`serial_cat_title` text COLLATE utf8_unicode_ci NOT NULL,
		`serial_cat_url` text COLLATE utf8_unicode_ci NOT NULL,
		PRIMARY KEY (`id`),
		KEY `fk_view_category_lang_id` (`lang_id`),
		KEY `fk_view_category_category_id` (`category_id`),
		KEY `fk_view_category_parent_id` (`parent_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
		$this->sql->query($query);
	}


	public function alterTableModel($model)
	{
		$res = 'ALTER TABLE IF EXISTS `'.$model->getTablename().'`';
		//ALTER TABLE `mm_articles` CHANGE `user_id` `user_id` TINYINT( 11 ) NOT NULL
		$attr = $model->getAttrib();

		foreach($attr as $key => $val)
		{
			$res .= 'CHANGE `'.$key.'` `'.$key.'` '.$val["type"].'';
			if (isset($val["default"])) {
				if (trim(strtoupper($val["default"])) == "NOT NULL") {
					$res .= ' NOT NULL';
				} else {
					$res .= ' DEFAULT ' . $val["default"];
				}

			} else {
				$res .= ' DEFAULT NULL';
			}
		}
		$res .= '';
		return $res;
	}

	public function createTableModel($model)
	{

		$res = 'CREATE TABLE IF NOT EXISTS `'.$model->_name.'`';
		$attr = $model->_attributtes;
		$res .= '(';
		foreach($attr as $key => $val)
		{
			$res .= '`'.$key.'` '.$val["type"].'';

			if ($key == $model->getPrimary()) {
				$res .= ' NOT NULL auto_increment';
			} else {
				if (isset($val["default"])) {
					if (trim(strtoupper($val["default"])) == "NOT NULL") {
						$res .= ' NOT NULL';
					} else {
						$res .= ' DEFAULT ' . $val["default"];
					}

				} else {
					$res .= ' DEFAULT NULL';
				}
				//COLLATE utf8_unicode_ci
				$STRING_ARRAY = array("VAR","TEX","LON");
				//print SUBSTR(trim(strtoupper($val["type"])),0,3) . "<br />";
				if (in_array(SUBSTR(trim(strtoupper($val["type"])),0,3), $STRING_ARRAY)) {
					$res .= ' COLLATE utf8_unicode_ci';
				}

			}
			$res .= ',';
		}
		$res .= 'PRIMARY KEY  (`'.$model->_primary.'`)';
		$res .= ')';
		$res .= 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';
		PRINT $res . "<BR />";
		$this->sql->query($res);
		return $res;
	}

	/***
	 * Založí Menu do admina
	 * */
	public function insert_syscategory(){

		/**
		 SET FOREIGN_KEY_CHECKS=0;
		 TRUNCATE TABLE `view_syscategory`;
		 TRUNCATE TABLE `mm_syscategory_version`;
		 TRUNCATE TABLE `mm_syscategory`;
		 SET FOREIGN_KEY_CHECKS=1;
		 * */
		/*
		   $query = "SET FOREIGN_KEY_CHECKS=0";
		   $this->sql->query($query);

		   $query = "TRUNCATE TABLE `view_syscategory`";
		   $this->sql->query($query);

		   $query = "TRUNCATE TABLE `mm_syscategory_version`";
		   $this->sql->query($query);

		   $query = "TRUNCATE TABLE `mm_syscategory`";
		   $this->sql->query($query);

		   $query = "SET FOREIGN_KEY_CHECKS=1";
		   $this->sql->query($query);
		*/
		$rootId = $this->addSysCategory("Nástěnka","root",null,null,1);

		$obsahWebuId = $this->addSysCategory("Obsah webu","category",$rootId,"fa-sitemap",10);
		$this->addSysCategory("Příspěvky","posts",$obsahWebuId,"fa-pencil");

		$usersId = $this->addSysCategory("Uživatelé","users",$rootId,"fa-users",3);
		$this->addSysCategory("Role","roles",$usersId,"fa-unlock-alt");


		$eshopId = $this->addSysCategory("Eshop","eshop",$rootId,"fa-shopping-cart",9);
		$nastaveniId = $this->addSysCategory("Nastavení","options",$rootId,"fa-cog",4);

		$komunikaceId = $this->addSysCategory("Komunikace","komunikace",$rootId," fa-folder-o",6);
		$this->addSysCategory("Emaily","mailing",$komunikaceId,"fa-envelope");
		$this->addSysCategory("SMS zprávy","smsgatein",$komunikaceId,"fa-mobile");
		$this->addSysCategory("Komentáře","comments",$komunikaceId,"fa-comment-o");


		$catalogId = $this->addSysCategory("Katalog","catalog",$rootId," fa-folder-o",5);




		$this->addSysCategory("Fotogalerie","foto",$rootId,"fa-picture-o",8);
		$this->addSysCategory("Správce souborů","data",$rootId,"fa-upload",7);

		$this->addSysCategory("Objednávky","objednavky",$eshopId,"fa-file-text-o");
		$this->addSysCategory("Sortiment","sortiment",$eshopId,"fa-dropbox");
		$this->addSysCategory("Skladové zásoby","sortiment_stavy",$eshopId,"fa-dropbox");
		$this->addSysCategory("Nastavení obchodu","eshop_settings",$eshopId,"fa-wrench");
		$this->addSysCategory("Skupiny","eshop_cat",$eshopId,"fa-tags");
		$this->addSysCategory("Výrobce","eshop_vyrobce",$eshopId,"fa-flask");
		$this->addSysCategory("Záruka","product_zaruka",$eshopId,"");

		$this->addSysCategory("Faktury","faktury",$eshopId,"fa-money");
		$this->addSysCategory("Přijaté platby","platby",$eshopId,"fa-money");
		$this->addSysCategory("Parametry","attributes",$eshopId,"fa-th-large");

		$this->addSysCategory("Typy přeprav","shop_transfer",$eshopId,"fa-truck");
		$this->addSysCategory("Typy plateb","shop_payment",$eshopId,"fa-credit-card");

		$cenyId = $this->addSysCategory("Ceny a slevy","product_ceniky",$eshopId,"fa-money");

		$this->addSysCategory("Ceník produktů","product_ceny",$cenyId,"");
		$this->addSysCategory("Generátor cen","generator_cen",$cenyId,"");



		$this->addSysCategory("Dostupnosti","product_dostupnost",$eshopId,"fa-clock-o");
		$this->addSysCategory("Nákupní košík","basket",$eshopId,"fa-shopping-cart");
		$this->addSysCategory("Import produktů","import_product_settings",$eshopId,"");

		$this->addSysCategory("Vzhled","web_zobrazeni",$eshopId,"fa-pencil-square-o");


		$this->addSysCategory("Slovník","translator",$nastaveniId,"fa-book");
		$this->addSysCategory("Měrné jednotky","mj",$nastaveniId,"fa-inbox");
		$this->addSysCategory("Číselné řady","nextid",$nastaveniId,"fa-inbox");
		$this->addSysCategory("Editor menu","syscategory",$nastaveniId,"fa-sitemap");
		$this->addSysCategory("Kurzy","kurzy",$nastaveniId,"fa-puzzle-piece");

		$this->addSysCategory("Zdroje návštěv","zdroje",$nastaveniId,"fa-random");

		$this->addSysCategory("Newsletter","newsletter",$komunikaceId,"fa-twitch");

		$this->addSysCategory("Zákazníci","catalog_zakaznici",$catalogId,"fa-twitch");
	}


	/**
	 * Založení defaultních rubrik eshopu
	 * **/
	public function insert_category_eshop_demo()
	{

		$menuId = "";
		$title = "O nás";
		$url = strToUrl($title);
		$description = '<h1>O nás</h1>
		<p>Jsme nový eshop ......</p>';
		$id = $this->addCategory($title,$url,null,$description);
		$menuId .= "|" . $id;
		$title = "Obchodní podmínky";
		$url = strToUrl($title);

		$firma = "XXXXXXX";
		$sidlo = "YYYYYYYY";
		$description = '<h1>Obchodní podmínky</h1>
		<p> </p>
<h2>Článek 1. Obecná ustanovení</h2>
<p>I.</p>
<p>Tyto obchodní podmínky se použijí na smluvní vztahy, které jsou uzavírané prostřednictvím<br />e-shopu, jehož provozovatelem je ' . $firma . ', se sídlem ' . $sidlo . '.</p>
<p>II.</p>
<p>Kupující učiněním objednávky akceptuje Obchodní podmínky pro dodávky zboží vyhlášené prodávajícím v platném a účinném znění v okamžiku odeslání objednávky a stvrzuje, že se s nimi seznámil. Vztahy kupujícího a prodávajícího se řídí těmito obchodními podmínkami, které jsou pro obě strany závazné, pokud není ve smlouvě stanoveno výslovně něco jiného, a českým právním řádem. Právní vztahy výslovně neupravené Obchodními podmínkami ani smlouvou se řídí zákonem č. 89/2012 Sb., občanským zákoníkem v platném a účinném znění a ostatními souvisejícími předpisy.</p>
<p>III.</p>
<p>Kupujícím je spotřebitel nebo podnikatel. Podle občanského zákoníku se spotřebitelem rozumí každý člověk, který mimo rámec své podnikatelské činnosti nebo mimo rámec samostatného výkonu svého povolání uzavírá smlouvu s podnikatelem nebo s ním jinak jedná. Podnikatelem se rozumí ten, kdo samostatně vykonává na vlastní účet a odpovědnost výdělečnou činnost živnostenským nebo obdobným způsobem se záměrem činit tak soustavně za účelem dosažení zisku. Pro právní postavení kupujícího-podnikatele jsou vyloučena ustanovení o slabší straně.</p>
<p>IV.</p>
<p>Obchodní podmínky blíže vymezují a upřesňují práva a povinnosti prodávajícího (společnosti ' . $firma . ') a jeho zákazníků (kupujících) a ve svém aktuálním znění tvoří obsah kupní smlouvy (o dodávce zboží), resp. je její nedílnou součástí. Není-li mezi účastníky sjednána trvalá kupní smlouva v písemné formě, dodá prodávající zboží na základě elektronické objednávky a specifikace zákazníka (objednávky doručené prostřednictvím elektronické pošty) na formuláři, který je k dispozici při první registraci zákazníka v internetovém obchodě.</p>
<p> </p>
<h2>Článek 2. Sdělení před uzavřením smlouvy</h2>
<p>Prodávající ' . $firma . ' v souladu s § 1820 občanského zákoníku sděluje, že</p>
<p>a) náklady na prostředky komunikace na dálku se neliší od základní sazby, tzn., že internetové připojení a telefonní hovory hradí kupující podle podmínek svého operátora,<br />prodávající si za uskutečněné hovory ani internetové připojení neúčtuje žádné poplatky navíc,</p>
<p>b) prodávající požaduje zaplacení kupní ceny nebo její zálohy před převzetím předmětu koupě,</p>
<p>c) v případě, že se jedná o dlouhodobou rámcovou písemnou kupní smlouvu, elektronická objednávka uzavřenou smlouvu blíže specifikuje a konkretizuje a je její nedílnou součástí,</p>
<p>d) práva na odstoupení od smlouvy může využít spotřebitel, a to v zákonné čtrnáctidenní lhůtě za podmínek uvedených ve článku 5. těchto obchodních podmínek,</p>
<p>e) v případě odstoupení od smlouvy ponese spotřebitel náklady spojené s navrácením zboží, a jde-li o smlouvu uzavřenou prostřednictvím prostředku komunikace na dálku, náklady za navrácení zboží, jestliže toto zboží nemůže být vráceno pro svou povahu obvyklou poštovní cestou,</p>
<p>f) spotřebitel má povinnost uhradit poměrnou část ceny v případě odstoupení od smlouvy, jejímž předmětem je poskytování služeb a jejichž plnění již začalo,</p>
<p>g) spotřebitel nemůže odstoupit od smlouvy v situacích, které jsou uvedeny v těchto obchodních podmínkách ve článku 5.,</p>
<p>h) případné stížnosti spotřebitelů se budou řešit dle platných právních předpisů České republiky, případné spory, které vzniknou na základě smlouvy, budou řešeny výhradně podle práva České republiky, a to prostřednictvím příslušných soudů v České republice.</p>
<p> </p>
<h2>Článek 3. Smlouva, předmět smlouvy</h2>
<p>I.</p>
<p>Kupní smlouvou se prodávající (Firma ' . $firma . ') zavazuje, že kupujícímu odevzdá věc, která je předmětem koupě, a umožní mu nabýt vlastnické právo k ní, a kupující se zavazuje, že věc převezme a zaplatí prodávajícímu kupní cenu. Vzhledem k tomu, že si ' . $firma . ' vyhrazuje vlastnické právo podle § 2132 zákona č. 89/2012 Sb., občanského zákoníku, vlastníkem se kupující stane až úplným zaplacením kupní ceny. Nebezpečí škody na věci však na kupujícího přechází již jejím převzetím. Nebezpečí škody na věci přechází na kupujícího i v případě, kdy sice věc nepřevzal, ale bylo mu umožněno s věcí nakládat.</p>
<p>II.</p>
<p>Povinnost odevzdat předmět koupě kupujícímu je splněna v případě osobního odběru v okamžiku, kdy prodávající předá věc kupujícímu. Pokud prodávající věc odesílá, je tato povinnost splněna předáním prvnímu dopravci k přepravě pro kupujícího a umožněním kupujícímu uplatnit práva z přepravní smlouvy vůči dopravci.</p>
<p>III.</p>
<p>Předmětem smlouvy jsou pouze položky výslovně uvedené v kupní smlouvě - objednávce (dále jen zboží). Váhy, rozměry, kapacita, ceny, výkony a ostatní údaje obsažené na internetových stránkách ' . $firma . ', katalozích, prospektech a jiných tiskovinách jsou nezávaznými údaji, pokud nebyly ve smlouvě výslovně uvedeny jako závazné. Pokud vyplývá ze smlouvy nebo z povahy předmětu koupě, že množství je určeno jen přibližně, určí přesné množství prodávající.</p>
<p>IV.</p>
<p>Má-li kupující určit dodatečně vlastnosti předmětu koupě a neučiní-li to včas, určí je prodávající sám a oznámí kupujícímu, jaké vlastnosti určil. Přičemž přihlédne k potřebám kupujícího, které zná.</p>
<p>V.</p>
<p>Dodá-li prodávající větší množství věcí, než bylo ujednáno, je kupní smlouva uzavřena i na přebytečné množství, ledaže je kupující bez zbytečného odkladu odmítl.</p>
<p>VI.</p>
<p>Předmět koupě zabalí prodávající podle zvyklostí, není-li ujednáno jinak. V případě neexistence zvyklostí pak způsobem potřebným pro uchování věci a její ochranu. Stejným způsobem opatří prodávající věc pro přepravu.</p>
<p>VII.</p>
<p>Koupě na zkoušku podle ustanovení § 2150 občanského zákoníku je vyloučena.</p>
<p> </p>
<h2>Článek 4. Objednání zboží, uzavření smlouvy</h2>
<p>I.</p>
<p>Podmínkou platnosti elektronické objednávky je vyplnění veškerých formulářem předepsaných údajů a náležitostí. Objednávka je neplatná, pokud neobsahuje požadované údaje. Kupujícímu je zároveň umožněno zaregistrovat se na internetových stránkách prodávajícího. Registrovaný uživatel pak nemusí již jednou uvedené údaje v registraci znovu vkládat do formuláře, objednávku provádí prostřednictvím svého registrovaného účtu.</p>
<p>II.</p>
<p>Kupující je povinen před zasláním objednávky prodávajícímu zkontrolovat údaje, které do objednávky vložil. Údaje uvedené v objednávce prodávající považuje za správné.</p>
<p>III.</p>
<p>Objednávka je návrhem kupní smlouvy, kterou prodávající po jejím přijetí neformálně potvrdí. K uzavření kupní smlouvy se nevyžaduje formální potvrzení objednávky prodávajícím, smlouva pak vzniká samotným dodáním zboží. Prodávající si může v jednotlivém zejména cenově náročnějším případě vyhradit vznik smlouvy potvrzením objednávky. Prodávající je v závislosti na charakteru obchodu (množství zboží, výše ceny, náklady na přepravu, vzdálenosti apod.), vždy oprávněn žádat kupujícího o autorizaci objednávky vhodným způsobem, např. telefonicky či písemně. Odmítne-li prodávající objednávku požadovaným způsobem autorizovat, považuje se objednávka za neplatnou.</p>
<p>IV.</p>
<p>Prodávající má právo odmítnout objednávku kupujícího, který při předchozí objednávce řádně a včas nezaplatil závazně objednané zboží nebo jiným způsobem podstatně porušil své povinnosti vůči prodávajícímu.</p>
<p>V.</p>
<p>Zboží bude dodáno pouze na základě objednávky, která je uskutečněna podle platné nabídky prodávajícího zveřejněné na internetových stránkách, přičemž je vyloučeno, aby byla učiněna objednávka s dodatkem nebo odchýlením se od nabídky prodávajícího. Platná nabídka zboží je vytvořena s výhradou vyčerpání zásob nebo ztráty schopnosti prodávajícího plnit. Vystavené zboží není nabídkou k uzavření smlouvy, nýbrž pouze výzvou k podání nabídky.</p>
<p>VI.</p>
<p>Je-li mezi účastníky uzavřena dlouhodobá rámcová písemná kupní smlouva, elektronická objednávka uzavřenou smlouvu blíže specifikuje a konkretizuje a je její nedílnou součástí. Smluvní zákazníci s nimiž je uzavřena písemná kupní smlouva požívají výhod sjednaných při podepisování smlouvy. Společnost ' . $firma . ', poskytne smluvně dohodnutou slevu z ceníkových cen uvedených na stránkách www.XXXXX.cz.</p>
<p>VII.</p>
<p>Kupující souhlasí s použitím komunikačních prostředků na dálku při uzavírání smlouvy. Náklady související s uzavřením smlouvy, které mu vzniknou při použití komunikačních prostředků na dálku (například náklady spojené s připojením k internetu nebo platby za telefonní hovory) hradí kupující sám.</p>
<p> </p>
<h2>Článek 5. Odstoupení od kupní smlouvy (zásilkový obchod)</h2>
<p>I.</p>
<p>Kupující-spotřebitel (nikoli podnikatel) má podle občanského zákoníku právo odstoupit od smlouvy ve lhůtě čtrnácti dnů. Uvedená lhůta běží ode dne uzavření smlouvy a jde-li o</p>
<p>a) kupní smlouvu, ode dne převzetí zboží,</p>
<p>b) smlouvu, jejímž předmětem je několik druhů zboží nebo dodání několika částí, ode dne převzetí poslední dodávky zboží, nebo</p>
<p>c) smlouvu, jejímž předmětem je pravidelná opakovaná dodávka zboží, ode dne převzetí první dodávky zboží.</p>
<p>II.</p>
<p>Kupující písemně oznámí odstoupení od smlouvy a v tomto písemném odstoupení identifikuje zboží, uvede datum objednávky, číslo objednávky, variabilní symbol, datum převzetí zboží a číslo bankovního účtu pro vrácení kupní ceny.</p>
<p>III.</p>
<p>Pokud kupující-spotřebitel odstoupí od smlouvy, zašle nebo předá prodávajícímu bez zbytečného odkladu, nejpozději do čtrnácti dnů od odstoupení od smlouvy, zboží, které od něho obdržel. Jestliže to není možné, poskytne kupující prodávajícímu peněžitou náhradu ve výši toho, co nemůže být zasláno nebo předáno. Prodávající má právo na uplatnění náhrady toho, co nemůže být předáno, u kupujícího a započíst svůj nárok oproti nároku na vrácení kupní ceny. Zboží zasílá kupující v původním nepoškozeném obalu, nepoužité, nepoškozené a kompletní (tzn. včetně příslušenství, záručního listu, návodu, atd.) s originálním dokladem o koupi. Zasílá ho doporučeně a pojištěné, prodávající neručí za jeho případnou ztrátu během přepravy. (Doporučeně neznamená na dobírku).</p>
<p>IV.</p>
<p>Odstoupil-li kupující-spotřebitel od smlouvy, jejímž předmětem je poskytování služeb a prodávající s plněním začal na základě výslovné žádosti spotřebitele před uplynutím lhůty pro odstoupení od smlouvy, kupující-spotřebitel uhradí prodávajícímu poměrnou část sjednané ceny za plnění poskytnuté do okamžiku odstoupení od smlouvy. Je-li sjednaná cena nepřiměřeně vysoká, uhradí kupující-spotřebitel podnikateli poměrnou část ceny odpovídající tržní hodnotě poskytovaného plnění.</p>
<p>V.</p>
<p>Pokud kupující-spotřebitel odstoupí od smlouvy, vrátí mu prodávající bez zbytečného odkladu, nejpozději do čtrnácti dnů od odstoupení od smlouvy, všechny peněžní prostředky včetně nákladů na dodání, které od něho na základě smlouvy přijal, stejným způsobem. Prodávající se může dohodnout se spotřebitelem na vrácení těchto prostředků jiným způsobem. Jestliže kupující zvolil jiný než nejlevnější způsob dodání zboží, který prodávající nabízí, vrátí prodávající kupujícímu náklady na dodání zboží ve výši odpovídající nejlevnějšímu nabízenému způsobu dodání zboží. V případě nedodání kompletního zboží či jinak odporující výše uvedeným podmínkám se termín vrácení peněžních prostředků posouvá do doby dodání plnohodnotného zboží.</p>
<p>VI.</p>
<p>Prodávající není povinen vrátit přijaté peněžní prostředky spotřebiteli dříve, než mu spotřebitel zboží předá nebo prokáže, že zboží podnikateli odeslal. Kupující-spotřebitel odpovídá prodávajícímu za snížení hodnoty zboží, které vzniklo v důsledku nakládání s tímto zboží jinak, než je nutné s ním nakládat s ohledem na jeho povahu a vlastnosti.</p>
<p>VII.</p>
<p>Kupující-spotřebitel nese náklady na vrácení zboží v souvislosti s odstoupením od smlouvy, pokud zboží není možné vrátit obvyklou poštovní cestou vzhledem k jeho vlastnostem.</p>
<p>VIII.</p>
<p>Kupující-spotřebitel však nemůže odstoupit od smlouvy:</p>
<p>a) o poskytování služeb, jestliže byly splněny s jeho předchozím výslovným souhlasem před uplynutím lhůty pro odstoupení od smlouvy a prodávající před uzavřením smlouvy sdělil kupujícímu-spotřebiteli, že v takovém případě nemá právo na odstoupení od smlouvy,</p>
<p>b) o dodávce zboží nebo služby, jejichž cena závisí na výchylkách finančního trhu nezávisle na vůli prodávajícího a k němuž může dojít během lhůty pro odstoupení od smlouvy,</p>
<p>c) o dodávce zboží, které bylo upraveno podle přání spotřebitele nebo pro jeho osobu,</p>
<p>d) o dodávce zboží, které podléhá rychlé zkáze, jakož i zboží, které bylo po dodání nenávratně smíseno s jiným zbožím,</p>
<p>e) o opravě nebo údržbě provedené v místě určeném kupujícím-spotřebitelem na jeho žádost; to však neplatí v případě následného provedení jiných než vyžádaných oprav či dodání jiných než vyžádaných náhradních dílů,</p>
<p>f) o dodávce zboží v uzavřeném obalu, které spotřebitel z obalu vyňal a z hygienických důvodů jej není možné vrátit,</p>
<p>g) o dodávce novin, periodik nebo časopisů,</p>
<p>h) uzavírané na základě veřejné dražby podle zákona upravujícího veřejné dražby, nebo</p>
<p>IX. V případě nesplnění některé podmínek uvedených v tomto článku nebude prodávající akceptovat odstoupení od spotřebitelské smlouvy a zboží bude vráceno na náklady odesílajícího zpět.</p>
<p> </p>
<h2>Článek 6. Vadné plnění</h2>
<p>I.</p>
<p>Prodávající (' . $firma . ') odpovídá kupujícímu za to, že předmět koupě nemá vady a má vlastnosti obvyklé pro daný druh zboží. Zejména prodávající odpovídá kupujícímu, že v době, kdy kupující věc převzal,</p>
<p>a) má věc vlastnosti, které si strany ujednaly, a chybí-li ujednání, takové vlastnosti, které prodávající nebo výrobce popsal nebo které kupující očekával s ohledem na povahu zboží a na základě reklamy jimi prováděné,</p>
<p>b) se věc hodí k účelu, který pro její použití prodávající uvádí nebo ke kterému se věc tohoto druhu obvykle používá,</p>
<p>c) věc odpovídá jakostí nebo provedením smluvenému vzorku nebo předloze, byla-li jakost nebo provedení určeno podle smluveného vzorku nebo předlohy,</p>
<p>d) je věc v odpovídajícím množství, míře nebo hmotnosti a</p>
<p>e) věc vyhovuje požadavkům právních předpisů.</p>
<p>II.</p>
<p>Kupující prohlédne dodané zboží co nejdříve po přechodu nebezpečí škody na věci a přesvědčí se o jejich vlastnostech a množství a bez zbytečného odkladu informuje prodávajícího o zjištěných vadách. Reklamace ohledně druhu, množství nebo poškození zboží při dopravě, učiněné později než bez zbytečného odkladu, nebudou uznávány.</p>
<p>III.</p>
<p>Věc je vadná, pokud nesplňuje požadavky ujednaného množství, jakosti a provedení. Jestliže ovšem plyne z prohlášení prodávajícího nebo z dokladu o předání, že prodávající dodal menší množství věci, nevztahují se na chybějící věci ustanovení o vadách.</p>
<p>IV.</p>
<p>Kupující-spotřebitel je oprávněn uplatnit u prodávajícího právo z vady, která se vyskytne u spotřebního zboží, v době dvaceti čtyř měsíců od převzetí. Kupující-podnikatel je oprávněn toto právo uplatnit v době do dvanácti měsíců od převzetí. Pokud se vada projeví v průběhu prvních šesti měsíců od převzetí, má se za to, že věc byla vadná již při převzetí. Právo z vady uplatní kupující u prodávajícího písemně.</p>
<p>V.</p>
<p>Prodávající kupujícímu písemně potvrdí, kdy kupující právo z vadného plnění uplatnil, a dále potvrdí výběr jeho práva podle čl. 6, odst. VI nebo VIII.</p>
<p>VI.</p>
<p>Pokud je vadné plnění podstatným porušením smlouvy, kupující má právo na:</p>
<p>a) odstranění vady dodáním nové věci bez vady nebo dodáním chybějící věci,</p>
<p>b) odstranění vady opravou věci,</p>
<p>c) přiměřenou slevu z kupní ceny, nebo</p>
<p>d) odstoupit od smlouvy.</p>
<p>VII.</p>
<p>Kupující sdělí prodávajícímu při oznámení vady jaké právo uvedené v odstavci VI. tohoto článku zvolil, přičemž svoji volbu nemůže změnit bez souhlasu prodávajícího. Jestliže kupující žádal opravdu věci, která se ukáže jako neopravitelná, má znovu právo vybrat si z výše uvedených možností. Neodstraní-li prodávající vady v přiměřené lhůtě, či oznámí-li kupujícímu, že vady neodstraní, může kupující požadovat místo odstranění vady přiměřenou slevu z kupní ceny, nebo může od smlouvy odstoupit. V případě, že kupující nezvolí své právo včas, tedy při oznámení vady, náleží mu práva z vadného plnění jako v případě nepodstatného porušení smlouvy.</p>
<p>VIII.</p>
<p>Jestliže se jedná o vadné plnění nepodstatným porušením smlouvy, kupující má právo na:</p>
<p>a) odstranění vady</p>
<p>b) přiměřenou slevu z kupní ceny.</p>
<p>IX.</p>
<p>Dokud kupující neuplatní právo na slevu z kupní ceny nebo neodstoupí od smlouvy, může prodávající dodat to, co chybí, nebo odstranit právní vadu. Jiné vady může prodávající odstranit podle své volby opravou věci nebo dodáním nové věci, přičemž volba nesmí kupujícímu způsobit nepřiměřené náklady.</p>
<p>X.</p>
<p>Kupující nemá právo na uplatnění práva z vady v následujících případech:</p>
<p>a) u věci prodávané za nižší cenu na vadu, pro kterou byla nižší cena ujednána,</p>
<p>b) na opotřebení věci způsobené jejím obvyklým užíváním,</p>
<p>c) u použité věci na vadu odpovídající míře používání nebo opotřebení, kterou věc měla při převzetí kupujícím, nebo</p>
<p>d) vyplývá-li to z povahy věci.</p>
<p>XI.</p>
<p>Kupující dále nemá práva z vadného plnění, pokud se jedná o vadu, kterou musel s vynaložením obvyklé pozornosti poznat již při uzavření smlouvy nebo pokud se jedná o vadu, kterou sám způsobil. Tím se rozumí situace, kdy kupující postupuje v rozporu s návodem pro použití věci, užívá věc k jiným než obvyklým účelům nebo se věc stala vadnou v důsledku pádu, neopatrného zacházení, náhody či působením vyšší moci.</p>
<p> </p>
<h2>Článek 7. Cena a placení</h2>
<p>I.</p>
<p>Nabídkové ceny uvedené na internetových stránkách společnosti ' . $firma . ' jsou platné v okamžiku objednání. Ceny uvedené v tištěném ceníku jsou platné do vydání nového ceníku. Prodávající si vyhrazuje právo tiskových chyb a změny cen, v případě změny peněžních kurzů, výrazném nárůstu inflace nebo při výrazných změnách dodavatelských podmínek u výrobců a ostatních dodavatelů zboží.</p>
<p>II.</p>
<p>Ceny jsou na internetových stránkách uvedeny u jednotlivých výrobků bez DPH, po vložení výrobku do košíku se zobrazí výše DPH u výrobku a celková cena k úhradě.</p>
<p>III.</p>
<p>Uzavřením smlouvy se cena stává závaznou.</p>
<p>IV.</p>
<p>Kupní cena bude považována za zaplacenou teprve připsáním celé kupní ceny za samostatnou část dodávky na běžný účet prodávajícího nebo uhrazením v hotovosti v pokladně prodávajícího. V případě nedodržení jakékoliv platební lhůty je kupující povinen zaplatit prodávajícímu poplatky z prodlení z hodnoty včas nezaplacené částky ve výši 0,1 % za každý den prodlení. Prodávající si vyhrazuje vlastnické právo ke zboží až do úplného zaplacení kupní ceny.</p>
<p>V.</p>
<p>Faktura vystavená na základě kupní smlouvy mezi prodávajícím a kupujícím je současně daňovým dokladem. Převzetí zboží kupujícím je zásadně možné až po jeho úplném zaplacení, pokud není dohodnuto jinak. K ceně zboží je připočítána cena dopravy.</p>
<p>VI.</p>
<p>Jestliže je platba provedena bezhotovostně převodem, je provedena v okamžiku připsání částky na účet prodávajícího. Platba v hotovosti je provedena v okamžiku uskutečnění platby osobě, která je k tomu pověřena prodávajícím, držiteli poštovní licence nebo přepravci.</p>
<p>VII.</p>
<p>Zdanitelné plnění se považuje za uskutečněné při prodeji zboží podle kupní smlouvy dnem dodání, v ostatních případech dnem převzetí nebo zaplacením zboží, a to tím dnem, který nastane dříve.</p>
<p>VIII.<br />Po odeslání objednávky má Plátce možnost využít službu ePlatba, která Vás přesměruje na internetové bankovnictví Vaší banky. Plátce prostřednictvím internet bankingu odešle Platbu. Prodávající expeduje zboží ihned po přijetí potvrzení o úhradě. Převody peněz jsou uskutečňovány prostřednictvím účtu společnosti AGMO a.s.<br />Citlivé vstupní údaje, které zadáváte do systému internetového bankovnictví, jsou chráněny platebními branami bank a nedostávají se do prostředí třetích stran. Zpracovatelé plateb vidí pouze informace o transakci, které jim banka s odeslanou transakcí sdělí.</p>
<p>Uzavřením kupní smlouvy dává kupující prodávajícímu souhlas se zpracováním svých kontaktních údajů a to až do doby jeho písemného vyjádření nesouhlasu s tímto zpracováním. Kontaktní údaje, které kupující uvede při objednání, slouží výhradně pro naši potřebu a nebudou poskytnuty jiným subjektům s výjimkou zpracovatelů plateb.</p>
<p> </p>
<h2>Článek 8. Dodání a dodací lhůta</h2>
<p>I.</p>
<p>Kupující v objednávce určí místo dodání, na které se zboží dodá. Zboží však bude dodáváno pouze na území České republiky.</p>
<p>II.</p>
<p>Místem plnění je místo dodání, určené v objednávce zákazníka. Při osobním odběru zboží je kupující povinen ve výdejním skladu předložit doklad o úplném zaplacení zboží, nebo zboží zaplatit. U smluvních zákazníků nebo při pravidelných odběrech je možno dohodnout individuální platební podmínky.</p>
<p>III.</p>
<p>Dodací lhůta začíná běžet ode dne obdržení závazné objednávky za podmínky obdržení všech podkladů, které jsou nutné pro včasné vyřízení dodávky. V případě, že zboží je na skladě, prodávající je vyexpeduje nebo předá dopravci obvykle do 5 pracovních dnů.</p>
<p>IV.</p>
<p>Dodací lhůta bude přiměřeně k okolnostem prodloužena, jestliže zpoždění je způsobeno vyšší mocí nebo okolnostmi nezaviněnými prodávajícím.</p>
<p>V.</p>
<p>V případě, že objednané zboží nebude na skladě nebo je nebude možné dodat přepravci do 5 pracovních dnů, oznámí prodávající předpokládaný termín dodání nebo nabídne jiný srovnatelný výrobek. V tom případě si však vyžádá odsouhlasení kupujícího.</p>
<p>VI.</p>
<p>Dodací lhůta se považuje za splněnou včas, jestliže zboží bude připraveno v místě plnění k předání nejpozději poslední den sjednané nebo dodatečně sjednané dodací lhůty. Obvyklá dodací lhůta činí 30 dní. Není-li prodávající schopen do 30 kalendářních dní odeslat zboží odběrateli (předat k přepravě prvnímu přepravci), je možné sjednat s kupujícím delší dodací lhůtu. Pokud nebude dodatečná lhůta sjednána, kupující a prodávající si vrátí navzájem vše, co již bylo plněno.</p>
<p>VII.</p>
<p>Papírové ubrousky s potiskem, jejichž barvu, velikost a celkový vzhled si zvolí sám kupující, mají zvláštní dodací lhůtu v délce trvání 5-6 týdnů.</p>
<p>VIII.</p>
<p>Pokud má prodávající věc odeslat, odevzdá věc kupujícímu předáním prvnímu dopravci k přepravě pro kupujícího a umožní kupujícímu uplatnit práva z přepravní smlouvy vůči dopravci. Prodávající neodpovídá za opožděné doručení věci z důvodu pochybení nebo případných jiných obtíží držitele poštovní licence nebo přepravce. Zároveň neodpovídá za případné poškození věci během přepravy.</p>
<p>IX.</p>
<p>Při odeslání nastanou účinky odevzdání věci kupujícímu jejím předáním dopravci, označí-li prodávající věc zjevně a dostatečně jako zásilku pro kupujícího. Neoznačí-li prodávající věc, nastanou účinky odevzdání, oznámí-li prodávající kupujícímu bez zbytečného odkladu, že mu věc odeslal, a určí-li ji dostatečně v oznámení.</p>
<p>X.</p>
<p>Je-li kupující v prodlení s převzetím věci, vzniká prodávajícímu právo věc po předchozím upozornění kupujícího vhodným způsobem prodat poté, co kupujícímu poskytl dodatečnou přiměřenou lhůtu k převzetí.</p>
<h2>Článek 9. Dopravní podmínky, poštovné</h2>
<p>I.</p>
<p>Platbu může kupující provést:</p>
<p>a) Dobírkou (platba při předání zboží)             130 Kč (objednávky do 2 000 Kč)</p>
<p>b) Převodem z účtu                           95 Kč (zboží dodáme po připsání</p>
<p>částky na náš účet - objednávky do 2 000 Kč)</p>
<p>c) Poštovné a balné neúčtujeme u objednávek nad 2 000 Kč</p>
<p>d) Hotově bez poplatku při vlastním odběru na pobočce naší firmy ' . $firma . '</p>
<p>Ceny jsou uvedeny bez DPH.</p>
<p>II.</p>
<p>Dodací lhůta činí 5 pracovních dnů u zboží, které je skladem. Kupující je povinen zboží od přepravce řádně převzít, zkontrolovat neporušenost obalů, počet balíků a v případě jakýchkoliv závad neprodleně oznámit přepravci a trvat na přesném zápisu do protokolu o škodě. V případě, že tak neučiní, reklamace nebude uznána. Faktura a daňový doklad jsou pak přiloženy v označeném balíku.</p>
<p> </p>
<h2>Článek 10. Záruka, servis</h2>
<p>I.</p>
<p>Prodávající poskytuje záruku za jakost a úplnost dodávky s výjimkou spotřebního materiálu, přičemž spotřebním materiálem se rozumí zejména čistící prostředky, hotelová a spotřební kosmetika, objektová chemie, desinfekce, mýdla, krémy, papírové ručníky, papírové ubrousky, průmyslové utěrky a toaletní papíry. Prodávající se prostřednictvím záruky za jakost zavazuje, že zboží bude po určitou dobu způsobilé k použití pro obvyklý účel nebo že si zachová obvyklé vlastnosti. Tyto účinky má i uvedení záruční doby nebo doby použitelnosti věci na obalu nebo v reklamě. Záruka může být poskytnuta i na jednotlivou součást věci.</p>
<p>II.</p>
<p>Na opotřebení způsobené obvyklým užíváním věci se záruka nevztahuje.</p>
<p>III.</p>
<p>Záruční doba běží od odevzdání věci kupujícímu; byla-li věc podle smlouvy odeslána, běží od dojití věci do místa určení. Kupující nemá právo ze záruky, jestliže vadu způsobila po přechodu nebezpečí škody na věci na kupujícího vnější událost. To neplatí, způsobil-li vadu prodávající.</p>
<p>IV.</p>
<p>Určují-li smlouva a prohlášení o záruce různé záruční doby, platí doba z nich nejdelší. Ujednají-li však kupující a prodávající jinou záruční dobu, než jaká je vyznačena na obalu jako doba použitelnosti, má přednost ujednání stran.</p>
<p>V.</p>
<p>Zboží je kupujícímu-spotřebiteli dodáváno se zárukou minimálně 24 měsíců, kupujícímu-podnikateli pak se zárukou 12 měsíců. Zjistí-li kupující při převzetí zboží vady, musí tyto skutečnosti sdělit vždy písemně a doporučeně, bez zbytečného odkladu, nejpozději však do 3 dnů od převzetí zboží. Prodávající kupujícímu potvrdí v písemné formě kdy své právo uplatnil, provedení opravy a dobu jejího trvání.</p>
<p>VI.</p>
<p>Reklamační formulář je kupujícímu k dispozici na internetových stránkách prodávajícího.</p>
<p>VII.</p>
<p>Reklamační list musí obsahovat datum dodání zboží, název výrobku, reklamované množství, popis závady a návrh na vyřízení reklamace. Prodávající je povinen vyjádřit se k reklamaci do 15 dnů ode dne jejího obdržení.</p>
<p> </p>
<h2>Článek 11. Ochrana osobních údajů</h2>
<p>I.</p>
<p>Kupující odesláním objednávky uděluje prodávajícímu souhlas se zpracováním všech jím uvedených osobních a jiných údajů v objednávce. Zpracovatelem uvedených informací je prodávající.</p>
<p>II.</p>
<p>Prodávající prohlašuje, že jemu poskytnuté osobní a jiné údaje jsou důvěrné, budou použity pouze k uskutečnění plnění smlouvy s kupujícím, k obchodním a marketingovým účelům a nebudou poskytnuty třetím osobám. Prodávající předá osobní údaje třetí osobě pouze ohledně distribuce nebo platebního styku, který se týká objednaného zboží. Veškeré údaje o kupujících jsou shromažďovány, zpracovávány a uchovávány v souladu s platnými zákony České republiky, zejména se zákonem č. 101/2000 Sb., o ochraně osobních údajů, v platném a účinném znění.</p>
<p> </p>
<h2>Článek 12. Závěrečná ustanovení</h2>
<p>I.</p>
<p>Tyto obchodní podmínky platí ve znění uvedeném na internetové stránce prodávajícího v den odeslání elektronické objednávky tehdy, není-li mezi účastníky písemně dohodnuto něco jiného.</p>
<p>II.</p>
<p>Odesláním elektronické objednávky kupující bez výhrad akceptuje veškerá ustanovení obchodních podmínek ve znění platném v den odeslání objednávky, jakož i v den odeslání objednávky platnou výši ceny objednaného zboží (včetně příp. expedičních a dopravních nákladů) uvedenou v ceníku na internetové stránce, nebude-li v konkrétním případe prokazatelně dohodnuto jinak. Odeslanou objednávkou (návrhem kupní smlouvy) je kupující po dobu stanovenou k dodání zboží neodvolatelně vázán.</p>
<p>III.</p>
<p>Pokud se na straně prodávajícího objeví jím nezaviněné neodstranitelné překážky, které neumožňují splnění jeho závazků vůči kupujícímu, prodávající je oprávněn jednostranně písemně odstoupit od smlouvy. V takovém případě kupujícímu neprodleně vrátí uhrazenou částku.</p>
<p>IV.</p>
<p>Pokud by prodávající nesplnil své závazky z uzavřené smlouvy z nepředvídaných a neodvratitelných důvodů, kterým prodávající nemohl nijak zabránit, neodpovídá kupujícímu za způsobenou škodu ani za nesplnění svých závazků. Prodávající dále neodpovídá za škody, které vzniknou kupujícímu v souvislosti s uzavřenými smlouvami se třetími osobami.</p>
<p>V.</p>
<p>Smlouva strany zavazuje, je jí možné měnit nebo zrušit jen se souhlasem obou stran, a nebo z jiných zákonných důvodů.</p>
<p>VI.</p>
<p>Obsahuje-li smlouva uzavřená mezi prodávajícím a kupujícím ustanovení odlišná od těchto obchodních podmínek, přednost má smlouva.</p>
<p>VII.</p>
<p>Smlouva je uzavírána v českém jazyce. Pokud by vznikl spor ohledně výkladu případného překladu pro zahraničního kupujícího, platí výklad smlouvy učiněný v českém jazyce.</p>
<p>VIII.</p>
<p>Pro případné spory vzniklé na základě smluv uzavřených mezi prodávajícím a kupujícím je rozhodným právem právo platné v České republice. Příslušnými orgány pro řešení sporu jsou soudy České republiky.</p>
<p>IX.</p>
<p>Prodávající je oprávněn v přiměřeném rozsahu změnit znění těchto obchodních podmínek. Obchodní podmínky však musejí být před svou účinností vyvěšeny na internetových stránkách prodávajícího s tím, že prodávající určí jejich účinnost. Kupující, který má s prodávajícím uzavřenou smlouvu zavazující dlouhodobě k opětovným plněním stejného druhu s odkazem na obchodní podmínky, má právo změny odmítnout a závazek z tohoto důvodu vypovědět. Kupující je povinen takto učinit před účinností obchodních podmínek, a to písemně, jinak se má za to, že se změnou obchodních podmínek souhlasí.</p>
<p>X.</p>
<p>Tyto obchodní podmínky nabývají účinnosti dne ' . date("j.n.Y"). '.</p>';
		$id = $this->addCategory($title,$url,null,$description);
		$menuId .= "|" . $id;

		$title = "Kontakty";
		$url = strToUrl($title);
		$description = '<h1>Kontakty</h1>
		<p>Kontakty na nás, adresa, telefon, bankovní spojení ......</p>';
		$id = $this->addCategory($title,$url,null,$description);
		$menuId .= "|" . $id;

		$title = "jak nakupovat";
		$url = strToUrl($title);
		$description = '<h1>Jak nakupovat</h1>
		<p>Většina z Vás již jistě v e-shopu nakupovala, ale přesto ve zkratce :</p>

		<p>U zboží je uveden maximální počet, který je momentálně k dispozici. U každého zboží je přednastaven 1 ks, který se po stisknutí tlačítka "koupit" vloží do košiku. Pokud budete chtít větší mnoštví, může postupně přidávat po jednom kusu nebo před stisknutím tlačíka změnit číslici jedna v rámečku za požadované množství. Pokud zadáte větší množství než je skladem, počítač Vám víc nevydá ani nedoobjedná. Po každé položce se Vám objeví seznam zboží v nákupním košíku s cenami a také odpovídajícími možnostmi dopravy a platbami, které se aktualizují dle nákupního košíku. Vy máte v naprosté většině případů možnost nakombinovat způsob dopravy, který si zvolíte poté, co vložíte vše požadované do košíku. Košík během nakupování můžete také zcela vypráznit a začít znovu, případně jen vyškrnout některé položky. Pokud jste si vybrali zboží i dopravu a platbu, objeví se Vám formulář, který je potřeba vyplnit, abychom věděli komu a kam co zaslat. Poté Vám bude celý nákup i s údaji zrekapitulován, no a pokud bude vše souhlasit, jedním tlačítkem nákup dokončíte. Po správě provedené objednáce Vám obratem přijde potvrzovací mail, čímž také víte, že nám objednávka byla doručena.</p>

		<p>V našem obchodě  můžete nakupovat i bez registrace, ale registrovaný zákazník, kromě dalších menších výhod, jako například možnost získat slevy při opakovaných nákupech, nemusí při příštím nákupu vyplňovat všechny údaje znovu, jen zadá přihlašovací jméno a heslo a poté si může navíc prohlížet své dřívější nákupy atp. Registrovaný i neregistrovaný zákazník vyplňuje v podstatě jen stejné údaje nutné k vyřízení objednávky, ale registrovaný zákazník se dále zařadí do našeho seznamu zákazníků, kdežto neregistrovaný je i při opakovaných nákupech stále "nový" a kromě údajů na objednávce "neviditelný". Dále viz ochrana osobních údajů.</p>';

		$id = $this->addCategory($title,$url,null,$description);
		$menuId .= "|" . $id;


		$data = array();
		$data["value"] = $menuId;

		$model = new models_Settings();
		$model->updateRecords($model->getTableName(),$data,"`key`='MENU_CATEGORY_LIST'");


		$data = array();
		$data["value"] = 1;

		$model = new models_Settings();
		$model->updateRecords($model->getTableName(),$data,"`key`='MODUL_ESHOP'");

		$data = array();
		$data["value"] = 1;

		$model = new models_Settings();
		$model->updateRecords($model->getTableName(),$data,"`key`='IS_RESPONSIVE'");


		$menuId = "";

		$title = "Kategorie 1";
		$url = strToUrl($title);
		$description = '<p></p>';
		$idCat1 = $this->addCategory($title,$url,1,$description);
		$menuId .= "|" . $idCat1;

		$title = "Kategorie 2";
		$url = strToUrl($title);
		$description = '<p></p>';
		$idCat2 = $this->addCategory($title,$url,1,$description);


		$menuId .= "|" . $idCat2;

		$title = "Kategorie 3";
		$url = strToUrl($title);
		$description = '<p></p>';
		$idCat3 = $this->addCategory($title,$url,1,$description);
		$menuId .= "|" . $idCat3;


		$data = array();
		$data["value"] = $menuId;

		$model = new models_Eshop();
		$model->updateRecords($model->getTableName(),$data,"`key`='ESHOP_CATEGORY_LIST'");


		$data = array();
		$data["value"] = 1;

		$model = new models_Eshop();
		$model->updateRecords($model->getTableName(),$data,"`key`='SLIDER_CATEGORY'");


		$data = array();
		$data["value"] = 3;

		$model = new models_Eshop();
		$model->updateRecords($model->getTableName(),$data,"`key`='SLIDER_CATEGORY_LIMIT'");


		$title = "Akce 1";
		$url = strToUrl($title);
		$description = '<p>Sezónní výprodej, až 90%</p>';
		$id = $this->addPost($title,$url,1,$description);

		$title = "Akce 2";
		$url = strToUrl($title);
		$description = '<p>Likvidace zásob. Velké slevy</p>';$
		$id = $this->addPost($title,$url,1,$description);

		$title = "Akce 3";
		$url = strToUrl($title);
		$description = '<p>Vzykoušejte naší novinku</p>';
		$id = $this->addPost($title,$url,1,$description);





		$data["name"] = "Akční zboží";
		$ProductEntity = new ProductCategoryEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);
		if ($saveEntity->save()) {
			$skupina_id1 = $saveEntity->getSavedEntity("ProductCategoryEntity")->id;
		}


		$data["name"] = "Nejprodávanější zboží";
		$ProductEntity = new ProductCategoryEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);
		if ($saveEntity->save()) {
				$skupina_id2 = $saveEntity->getSavedEntity("ProductCategoryEntity")->id;
		}


		$data["name"] = "Značka XYZ";
		$ProductEntity = new ProductVyrobceEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);
		if ($saveEntity->save()) {
			$znacka_id1 = $saveEntity->getSavedEntity("ProductVyrobceEntity")->id;
		}


		$data["name"] = "ALKA";
		$ProductEntity = new ProductVyrobceEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);
		if ($saveEntity->save()) {
			$znacka_id2 = $saveEntity->getSavedEntity("ProductVyrobceEntity")->id;
		}


		$data["name"] = "24 měsíců";
		$ProductEntity = new ProductZarukaEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);
		if ($saveEntity->save()) {
			$zaruka_id = $saveEntity->getSavedEntity("ProductZarukaEntity")->id;
		}



		$data = array();
		$data["cislo"] = "XX01";
		$data["title"] = "Sortiment 1";
		$data["lang_id"] = 6;
		$data["category_id"] = $idCat1;
		$data["vyrobce_id"] = $znacka_id1;
		$data["aktivni"] = 1;

		$data["zaruka_id"] = $zaruka_id;
		$data["dostupnost_id"] = 1;


		$data["skupina_id"] = $skupina_id1;


		$mjId = 1;
		$data["hl_mj_id"] = $mjId;
		$data["mj_id"] = $mjId;

		$dphId = 1;
		$data["dph_id"] = $dphId;

		$data["prodcena"] = 1500;


		$ProductEntity = new ProductEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);


		$ProductVersionEntity = new ProductVersionEntity();
		$ProductVersionEntity->naplnEntitu($data);

		$saveEntity->addSaveEntity($ProductVersionEntity);
		if ($saveEntity->save()) {

		}

		$data["cislo"] = "XX05";
		$data["title"] = "Sortiment 5";
		$data["category_id"] = $idCat1;
		$data["prodcena"] = 180;
		$data["vyrobce_id"] = $znacka_id2;

		$ProductEntity = new ProductEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);


		$ProductVersionEntity = new ProductVersionEntity();
		$ProductVersionEntity->naplnEntitu($data);

		$saveEntity->addSaveEntity($ProductVersionEntity);
		if ($saveEntity->save()) {

		}


		$data["cislo"] = "XX02";
		$data["title"] = "Sortiment 2";
		$data["category_id"] = $idCat2;
		$data["prodcena"] = 990;
		$data["vyrobce_id"] = $znacka_id1;

		$ProductEntity = new ProductEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);


		$ProductVersionEntity = new ProductVersionEntity();
		$ProductVersionEntity->naplnEntitu($data);

		$saveEntity->addSaveEntity($ProductVersionEntity);
		if ($saveEntity->save()) {

		}


		$data["cislo"] = "XX04";
		$data["title"] = "Sortiment 4";
		$data["category_id"] = $idCat2;
		$data["prodcena"] = 324;
		$data["vyrobce_id"] = $znacka_id2;

		$ProductEntity = new ProductEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);


		$ProductVersionEntity = new ProductVersionEntity();
		$ProductVersionEntity->naplnEntitu($data);

		$saveEntity->addSaveEntity($ProductVersionEntity);
		if ($saveEntity->save()) {

		}



		$data["cislo"] = "XX03";
		$data["title"] = "Sortiment 3";
		$data["category_id"] = $idCat3;
		$data["prodcena"] = 4352;
		$data["vyrobce_id"] = $znacka_id1;

		$ProductEntity = new ProductEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);


		$ProductVersionEntity = new ProductVersionEntity();
		$ProductVersionEntity->naplnEntitu($data);

		$saveEntity->addSaveEntity($ProductVersionEntity);
		if ($saveEntity->save()) {

		}


		$data["cislo"] = "XX06";
		$data["title"] = "Sortiment 6";
		$data["category_id"] = $idCat3;
		$data["prodcena"] = 274;
		$data["skupina_id"] = null;
		$data["vyrobce_id"] = $znacka_id2;

		$ProductEntity = new ProductEntity();
		$ProductEntity->naplnEntitu($data);

		$saveEntity = new SaveEntity();
		$saveEntity->addSaveEntity($ProductEntity);


		$ProductVersionEntity = new ProductVersionEntity();
		$ProductVersionEntity->naplnEntitu($data);

		$saveEntity->addSaveEntity($ProductVersionEntity);
		if ($saveEntity->save()) {

		}



	}


	private function insert_dostupnost()
	{
	/*	INSERT INTO `mm_product_dostupnost` (`id`, `isDeleted`, `TimeStamp`, `ChangeTimeStamp`, `name`, `description`, `order`, `parent`, `hodiny`) VALUES
			(1, 0, NULL, NULL, 'Skladem', NULL, 5, NULL, 0),
			(2, 0, NULL, NULL, 'Do 3 dnů', NULL, 4, NULL, 72),
			(3, 0, NULL, NULL, 'Výprodej ověřit předem tel.dostupnost', NULL, 2, NULL, 504),
			(4, 0, NULL, NULL, '2-14 dní', NULL, 3, NULL, 192),
			(5, 0, NULL, NULL, 'Není skladem', NULL, 1, NULL, 1000);
*/

		$model = new models_ProductDostupnost();

		$insertData = array();


		$insertData["name"] = 'Skladem';
		$insertData["order"] = 5;
		$insertData["hodiny"] = 0;
		$model->insertRecords($model->getTablename(),$insertData);

		$insertData["name"] = 'Do 3 dnů';
		$insertData["order"] = 4;
		$insertData["hodiny"] = 72;
		$model->insertRecords($model->getTablename(),$insertData);

		$insertData["name"] = '14 dní';
		$insertData["order"] = 3;
		$insertData["hodiny"] = 192;
		$model->insertRecords($model->getTablename(),$insertData);

		$insertData["name"] = 'Není skladem';
		$insertData["order"] = 2;
		$insertData["hodiny"] = 1000;
		$model->insertRecords($model->getTablename(),$insertData);


	}

	private function insert_zpusob_dopravy()
	{
		$model = new models_Doprava();

		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Osobní rozvoz';
		$insertData["description"] = 'Zboží Vám bude dovezeno na uvedenou doručovací adresu, kterou budete vyplňovat v posledním kroku této objednávky. Platí pouze pro Karlovy Vary. Cena za dopravu 60,- Kč';
		$insertData["price"] = 60;
		$insertData["price_value"] = '60 Kč';
		$model->insertRecords(T_SHOP_ZPUSOB_DOPRAVY_VERSION,$insertData);


		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Osobní vyzvednutí';
		$insertData["description"] = 'Zboží budete mít připravené k vyzvednutí přímo u nás na kavárně. Poštovné se v tomto případě nehradí!';
		$insertData["price"] = 0.00;
		$insertData["price_value"] = 'zdarma';
		$model->insertRecords(T_SHOP_ZPUSOB_DOPRAVY_VERSION,$insertData);


		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Balík do ruky';
		$insertData["description"] = 'Přeprava poštou formou balíku do ruky 285,- Kč';
		$insertData["price"] = 285;
		$insertData["price_value"] = '285 Kč';
		$model->insertRecords(T_SHOP_ZPUSOB_DOPRAVY_VERSION,$insertData);


		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Balík na poštu';
		$insertData["description"] = 'Přeprava poštou formou vyzvednutí balíku na poště 270,- Kč';
		$insertData["price"] = 270;
		$insertData["price_value"] = '270 Kč';
		$model->insertRecords(T_SHOP_ZPUSOB_DOPRAVY_VERSION,$insertData);


		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Cenný balík';
		$insertData["description"] = 'Přeprava poštou formou cenného balíku s vyšší hodnotou zásilky 250,- Kč';
		$insertData["price"] = 250;
		$insertData["price_value"] = '250 Kč';
		$model->insertRecords(T_SHOP_ZPUSOB_DOPRAVY_VERSION,$insertData);
		return true;
	}

	private function insert_zpusob_platby()
	{

		$model = new models_Platba();

		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Dobírka';
		$insertData["description"] = 'Zboží zaplatíte při převzetí zboží od řidiče České pošty. Na dobu předpokládaného doručení prosím mějte doma připravenou dostatečnou hotovost. Jedná se o nejběžnější formu úhrady, nekomplikující proces dodání.';
		$model->insertRecords(T_SHOP_ZPUSOB_PLATBY_VERSION,$insertData);

		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Hotově';
		$insertData["description"] = 'Objednané zboží uhradíte hotově při osobním vyzvednutí u nás na skladě.';
		$model->insertRecords(T_SHOP_ZPUSOB_PLATBY_VERSION,$insertData);

		$insertData = array();
		$model->insertRecords($model->getTablename(),$insertData);
		$insertData["page_id"] = $model->insert_id;
		$insertData["lang_id"] = 6;
		$insertData["name"] = 'Převodem z účtu';
		$insertData["description"] = 'Po dokončení objednávky Vám zašleme informace o čísle účtu, na který zaplatíte za objednané zboží. Zboží bude expedováno až po připsání peněz na náš účet.';
		$model->insertRecords(T_SHOP_ZPUSOB_PLATBY_VERSION,$insertData);
		return true;
	}

	private function insert_dph()
	{

		$model = new Models_Dph();
		$data = array();
		$data["name"] = "21%";
		$data["value"] = 21;
		$data["platnost_od"] = "2013-01-01 00:00:00";
		$model->insert($data);


		$data["name"] = "15%";
		$data["value"] = 15;
		$data["platnost_od"] = "2013-01-01 00:00:00";
		$model->insert($data);

		$data["name"] = "Ne";
		$data["value"] = 0;
		$data["platnost_od"] = "null";
		$model->insert($data);


		$data["name"] = "Osv";
		$data["value"] = 0;
		$data["platnost_od"] = "null";
		$model->insert($data);
	}

	private function insert_mj()
	{
		$model = new Models_Mj();
		$data = array();
		$data["name"] = "Ks";
		$model->insert($data);

		$data = array();
		$data["name"] = "Kg";
		$model->insert($data);

		$data = array();
		$data["name"] = "Bal.";
		$model->insert($data);

		$data = array();
		$data["name"] = "t";
		$model->insert($data);

		$data = array();
		$data["name"] = "l";
		$model->insert($data);

		$data = array();
		$data["name"] = "m";
		$model->insert($data);

	}

	private function insert_role(){

		$model = new Models_Roles();
		$data = array();
		$data["title"] = "Redaktor";
		$data["p1"] = 0;
		$data["p2"] = 0;
		$data["p3"] = 0;
		$data["p4"] = 0;
		$data["p5"] = 0;
		$data["p6"] = 0;
		$data["p7"] = 0;
		$data["p8"] = 0;
		$data["p9"] = 0;
		$data["p10"] = 0;

		$model->insert($data);

		$data["title"] = "Správce";
		$data["p10"] = 1;
		$model->insert($data);

		$data["title"] = "Šéfredaktor";
		$data["p10"] = 1;
		$model->insert($data);

		$data["title"] = "Registrovaný uživatel";
		$data["p10"] = 0;
		$model->insert($data);

	}

	private function insert_languages(){

		$model = new models_Language();
		$data = array();
		$data["code"] = "en";
		$data["name"] = "English";
		$data["order"] = 2;
		$data["content_language"] = "en-US";
		$model->insert($data);

		$data["code"] = "de";
		$data["name"] = "Deutsch";
		$data["order"] = 3;
		$data["content_language"] = "de";
		$model->insert($data);

		$data["code"] = "ic";
		$data["name"] = "Iceland";
		$data["order"] = 8;
		$data["content_language"] = "ic";
		$model->insert($data);

		$data["code"] = "fr";
		$data["name"] = "France";
		$data["content_language"] = "fr";
		$data["order"] = 7;
		$model->insert($data);

		$data["code"] = "sk";
		$data["name"] = "Slovensky";
		$data["order"] = 5;
		$data["content_language"] = "sk-SK";
		$model->insert($data);

		$data["code"] = "cs";
		$data["name"] = "Česky";
		$data["active"] = 1;
		$data["order"] = 1;
		$data["content_language"] = "cs-CZ";
		$model->insert($data);

		$data["code"] = "pl";
		$data["name"] = "Polski";
		$data["order"] = 6;
		$data["active"] = 0;
		$data["content_language"] = "pl";
		$model->insert($data);

		$data["code"] = "ru";
		$data["name"] = "Pусский";
		$data["active"] = 0;
		$data["order"] = 4;
		$data["content_language"] = "ru-RU";
		$model->insert($data);

		$data["code"] = "it";
		$data["name"] = "Italien";
		$data["active"] = 0;
		$data["order"] = 9;
		$data["content_language"] = "it";
		$model->insert($data);

	}

	private function insert_users(){

		$model = new models_Users();
		$data = array();
		$data["nick"] = "admin";
		$data["password"] = "78a301055dc251d6de30ee8f013bc18f";
		$data["sex"] = 1;
		$data["isDeleted"] = 0;
		$data["email"] = "info@svetfirem.cz";
		$data["prijmeni"] = "Administrátor";
		$data["ip_adresa"] = $_SERVER["REMOTE_ADDR"];
		$data["stillin"] = 0;
		$data["last_page"] = 0;
		$data["aktivni"] = 1;
		$data["doba"] = 0;
		$data["autorizace"] = 1;
		$data["role"] = 2;
		$data["prihlasen"] = 0;
		$data["p9"] = 1;
		$data["p10"] = 1;
		$model->insert($data);

		$data = array();
		$data["nick"] = "sysadmin";
		$data["password"] = "5ce3fc847651059aa3b5b90ba6b5bd1f";
		$data["sex"] = 1;
		$data["isDeleted"] = 0;
		$data["email"] = "rudolf.pivovarcik@centrum.cz";
		$data["prijmeni"] = "Systémový Administrátor";
		$data["ip_adresa"] = $_SERVER["REMOTE_ADDR"];
		$data["stillin"] = 0;
		$data["last_page"] = 0;
		$data["aktivni"] = 1;
		$data["doba"] = 0;
		$data["autorizace"] = 1;
		$data["role"] = 2;
		$data["prihlasen"] = 0;
		$data["p9"] = 1;
		$data["p10"] = 1;
		$model->insert($data);
	}


	private function insert_kraje(){
		$query = "INSERT INTO `" . T_KRAJE . "` (`id`, `name`, `order`) VALUES
			(1, 'Středočeský kraj', 0),
			(2, 'Jihočeský kraj', 0),
			(3, 'Karlovarský kraj', 0),
			(4, 'Ústecký kraj', 0),
			(5, 'Liberecký kraj', 0),
			(6, 'Královehradecký kraj', 0),
			(7, 'Pardubický kraj', 0),
			(8, 'Jihomoravský kraj', 0),
			(9, 'Olomoucký kraj', 0),
			(10, 'Moravskoslezský kraj', 0),
			(11, 'Praha', 0),
			(12, 'Plzeňský kraj', 0),
			(13, 'Zlínkský kraj', 0),
			(14, 'Vysočina', 0);";
		return $this->sql->query($query);
	}

	private function insert_moduly(){
		$query = "INSERT INTO `" . T_MODULY . "` (`id`, `name`, `order`, `status`) VALUES
			(1, 'Redakční systém', 0, 1),
			(2, 'Elektronický obchod', 0, 1),
			(3, 'Katalog firem', 0, 1),
			(4, 'Katalog her', 0, 1),
			(5, 'Katalog videí', 0, 1),
			(6, 'Katalog mp3', 0, 1),
			(7, 'Rezervace', 0, 1),
			(8, 'Inzerce', 0, 1),
			(9, 'Katalog staveb', 0, 1),
			(10, 'Reality', 0, 1),
			(11, 'Mailing', 0, 1),
			(12, 'SMS brána', 0, 1),
			(13, 'Správa reklam', 0, 1)
			;";
		return $this->sql->query($query);
	}

	private function insert_mesta(){

		$query = "INSERT INTO `" . T_MESTA . "` (`id`, `mesto`, `okres`, `stat`) VALUES
		(1, 'Středočeský kraj', 1, ''),
		(2, 'Benešov', 1, ''),
		(4, 'Beroun', 1, ''),
		(5, 'Kladno', 1, ''),
		(6, 'Kolín', 1, ''),
		(7, 'Kutná Hora', 1, ''),
		(8, 'Mělník', 1, ''),
		(9, 'Mladá Boleslav', 1, ''),
		(10, 'Nymburk', 1, ''),
		(11, 'Praha-východ', 1, ''),
		(12, 'Praha-západ', 1, ''),
		(13, 'Příbram', 1, ''),
		(14, 'Rakovník', 1, ''),
		(15, 'Jihočeský kraj', 2, ''),
		(16, 'České Budějovice', 2, ''),
		(17, 'Český Krumlov', 2, ''),
		(18, 'Jindřichův Hradec', 2, ''),
		(19, 'Písek', 2, ''),
		(20, 'Prachatice', 2, ''),
		(21, 'Strakonice', 2, ''),
		(22, 'Tábor', 2, ''),
		(23, 'Plzeňský kraj', 3, ''),
		(24, 'Domažlice', 3, ''),
		(25, 'Klatovy', 3, ''),
		(26, 'Plzeň-město', 3, ''),
		(27, 'Plzeň-jih', 3, ''),
		(28, 'Plzeň-sever', 3, ''),
		(29, 'Rokycany', 3, ''),
		(30, 'Tachov', 3, ''),
		(31, 'Karlovarský kraj', 4, ''),
		(32, 'Cheb', 4, ''),
		(33, 'Chodov', 4, ''),
		(34, 'Karlovy Vary', 4, ''),
		(35, 'Ostrov', 4, ''),
		(36, 'Sokolov', 4, ''),
		(37, 'Ústecký kraj', 5, ''),
		(38, 'Děčín', 5, ''),
		(39, 'Chomutov', 5, ''),
		(40, 'Litoměřice', 5, ''),
		(41, 'Louny', 5, ''),
		(42, 'Most', 5, ''),
		(43, 'Teplice', 5, ''),
		(44, 'Ústí nad Labem', 5, ''),
		(45, 'Liberecký kraj', 6, ''),
		(46, 'Česká Lípa', 6, ''),
		(47, 'Jablonec nad Nisou', 6, ''),
		(48, 'Liberec', 6, ''),
		(49, 'Semily', 6, ''),
		(50, 'Královehradecký kraj', 7, ''),
		(51, 'Hradec Králové', 7, ''),
		(52, 'Jičín', 7, ''),
		(53, 'Náchod', 7, ''),
		(54, 'Rychnov nad Kněžnou', 7, ''),
		(55, 'Trutnov', 7, ''),
		(56, 'Pardubický kraj', 8, ''),
		(57, 'Chrudim', 8, ''),
		(58, 'Pardubice', 8, ''),
		(59, 'Svitavy', 8, ''),
		(60, 'Ústí nad Orlicí', 8, ''),
		(61, 'Vysočina', 9, ''),
		(62, 'Havlíčkův Brod', 9, ''),
		(63, 'Jihlava', 9, ''),
		(64, 'Pelhřimov', 9, ''),
		(65, 'Třebíč', 9, ''),
		(66, 'Žďár nad Sázavou', 9, ''),
		(67, 'Jihomoravský kraju', 10, ''),
		(68, 'Blansko', 10, ''),
		(69, 'Brno-město', 10, ''),
		(70, 'Brno-venkov', 10, ''),
		(71, 'Břeclav', 10, ''),
		(72, 'Hodonín', 10, ''),
		(73, 'Vyškov', 10, ''),
		(74, 'Znojmo', 10, ''),
		(75, 'Olomoucký kraj', 11, ''),
		(76, 'Jeseník', 11, ''),
		(77, 'Olomouc', 11, ''),
		(78, 'Prostějov', 11, ''),
		(79, 'Přerov', 11, ''),
		(80, 'Šumperk', 11, ''),
		(81, 'Zlínský kraj', 12, ''),
		(82, 'Kroměříž', 12, ''),
		(83, 'Uherské Hradiště', 12, ''),
		(84, 'Vsetín', 12, ''),
		(85, 'Zlín', 12, ''),
		(86, 'Ostravský kraj', 13, ''),
		(87, 'Bruntál', 13, ''),
		(88, 'Frýdek-Místek', 13, ''),
		(89, 'Karviná', 13, ''),
		(90, 'Nový Jičín', 13, ''),
		(91, 'Opava', 13, ''),
		(92, 'Ostrava-město', 13, ''),
		(93, 'Orlová', 13, ''),
		(94, 'Praha', 14, ''),
		(95, 'Praha 1', 14, ''),
		(96, 'Praha 2', 14, ''),
		(97, 'Praha 3', 14, ''),
		(98, 'Praha 4', 14, ''),
		(99, 'Praha 5', 14, ''),
		(100, 'Praha 6', 14, ''),
		(101, 'Praha 7', 14, ''),
		(102, 'Praha 8', 14, ''),
		(103, 'Praha 9', 14, ''),
		(104, 'Praha 10', 14, ''),
		(105, 'Slovensko', 15, ''),
		(106, 'Bratislavský', 15, ''),
		(107, 'Trnavský', 15, ''),
		(108, 'Trenciansky', 15, ''),
		(109, 'Nitriansky', 15, ''),
		(110, 'Žilinský', 15, ''),
		(111, 'Banskobystrický', 15, ''),
		(112, 'Prešovský', 15, ''),
		(113, 'Košický', 15, ''),
		(114, 'Zahraničí', 16, ''),
		(115, 'Evropa', 16, ''),
		(116, 'Amerika', 16, ''),
		(117, 'Asie', 16, ''),
		(118, 'Zbytek Světa', 16, '');";
		return $this->sql->query($query);
	}

	private function insert_svatky()
	{
		$query = "INSERT INTO `" . T_SVATKY . "` (`id`, `dd`, `mm`, `svatek`, `volno`) VALUES
				(1, 1, 1, 'Nový rok', 1),
				(2, 2, 1, 'Karina', 0),
				(3, 3, 1, 'Radmila', 0),
				(4, 4, 1, 'Diana', 0),
				(5, 5, 1, 'Dalimil', 0),
				(6, 6, 1, 'Tři králové', 0),
				(7, 7, 1, 'Vilma', 0),
				(8, 8, 1, 'Čestmír', 0),
				(9, 9, 1, 'Vladan', 0),
				(10, 10, 1, 'Břetislav', 0),
				(11, 11, 1, 'Bohdana', 0),
				(12, 12, 1, 'Pravoslav', 0),
				(13, 13, 1, 'Edita', 0),
				(14, 14, 1, 'Radovan', 0),
				(15, 15, 1, 'Alice', 0),
				(16, 16, 1, 'Ctirad', 0),
				(17, 17, 1, 'Drahoslav', 0),
				(18, 18, 1, 'Vladislav', 0),
				(19, 19, 1, 'Doubravka', 0),
				(20, 20, 1, 'Ilona', 0),
				(21, 21, 1, 'Běla', 0),
				(22, 22, 1, 'Slavomír', 0),
				(23, 23, 1, 'Zdeněk', 0),
				(24, 24, 1, 'Milena', 0),
				(25, 25, 1, 'Miloš', 0),
				(26, 26, 1, 'Zora', 0),
				(27, 27, 1, 'Ingrid', 0),
				(28, 28, 1, 'Otýlie', 0),
				(29, 29, 1, 'Zdislava', 0),
				(30, 30, 1, 'Robin', 0),
				(31, 31, 1, 'Marika', 0),
				(32, 1, 2, 'Hynek', 0),
				(33, 2, 2, 'Nela/Hromnice', 0),
				(34, 3, 2, 'Blažej', 0),
				(35, 4, 2, 'Jarmila', 0),
				(36, 5, 2, 'Dobromila', 0),
				(37, 6, 2, 'Vanda', 0),
				(38, 7, 2, 'Veronika', 0),
				(39, 8, 2, 'Milada', 0),
				(40, 9, 2, 'Apolena', 0),
				(41, 10, 2, 'Mojmír', 0),
				(42, 11, 2, 'Božena', 0),
				(43, 12, 2, 'Slavěna', 0),
				(44, 13, 2, 'Věnceslav', 0),
				(45, 14, 2, 'Valentýn', 0),
				(46, 15, 2, 'Jiřina', 0),
				(47, 16, 2, 'Ljuba', 0),
				(48, 17, 2, 'Miloslava', 0),
				(49, 18, 2, 'Gizela', 0),
				(50, 19, 2, 'Patrik', 0),
				(51, 20, 2, 'Oldřich', 0),
				(52, 21, 2, 'Lenka', 0),
				(53, 22, 2, 'Petr', 0),
				(54, 23, 2, 'Svatopluk', 0),
				(55, 24, 2, 'Matěj', 0),
				(56, 25, 2, 'Liliana', 0),
				(57, 26, 2, 'Dorota', 0),
				(58, 27, 2, 'Alexandr', 0),
				(59, 28, 2, 'Lumír', 0),
				(60, 29, 2, 'Horymír', 0),
				(61, 1, 3, 'Bedřich', 0),
				(62, 2, 3, 'Anežka', 0),
				(63, 3, 3, 'Kamil', 0),
				(64, 4, 3, 'Stela', 0),
				(65, 5, 3, 'Kazimír', 0),
				(66, 6, 3, 'Miroslav', 0),
				(67, 7, 3, 'Tomáš', 0),
				(68, 8, 3, 'Gabriela', 0),
				(69, 9, 3, 'Františka', 0),
				(70, 10, 3, 'Viktorie', 0),
				(71, 11, 3, 'Anděla', 0),
				(72, 12, 3, 'Řehoř', 0),
				(73, 13, 3, 'Růžena', 0),
				(74, 14, 3, 'Rót/Matylda', 0),
				(75, 15, 3, 'Ida', 0),
				(76, 16, 3, 'Elena/Herbert', 0),
				(77, 17, 3, 'Vlastimil', 0),
				(78, 18, 3, 'Eduard', 0),
				(79, 19, 3, 'Josef', 0),
				(80, 20, 3, 'Světlana', 0),
				(81, 21, 3, 'Radek', 0),
				(82, 22, 3, 'Leona', 0),
				(83, 23, 3, 'Ivona', 0),
				(84, 24, 3, 'Gabriel', 0),
				(85, 25, 3, 'Marián', 0),
				(86, 26, 3, 'Emanuel', 0),
				(87, 27, 3, 'Dita', 0),
				(88, 28, 3, 'Soňa', 0),
				(89, 29, 3, 'Taťána', 0),
				(90, 30, 3, 'Arnošt', 0),
				(91, 31, 3, 'Kvido', 0),
				(92, 1, 4, 'Hugo', 0),
				(93, 2, 4, 'Erika', 0),
				(94, 3, 4, 'Richard', 0),
				(95, 4, 4, 'Ivana', 0),
				(96, 5, 4, 'Velikonoční pondělí, Miroslava', 1),
				(97, 6, 4, 'Vendula', 0),
				(98, 7, 4, 'Heřman/Hermína', 0),
				(99, 8, 4, 'Ema', 0),
				(100, 9, 4, 'Dušan', 0),
				(101, 10, 4, 'Darja', 0),
				(102, 11, 4, 'Izabela', 0),
				(103, 12, 4, 'Julius', 0),
				(104, 13, 4, 'Aleš', 0),
				(105, 14, 4, 'Vincenc', 0),
				(106, 15, 4, 'Anastázie', 0),
				(107, 16, 4, 'Irena', 0),
				(108, 17, 4, 'Rudolf', 0),
				(109, 18, 4, 'Valérie', 0),
				(110, 19, 4, 'Rostislav', 0),
				(111, 20, 4, 'Marcela', 0),
				(112, 21, 4, 'Alexandra', 0),
				(113, 22, 4, 'Evženie', 0),
				(114, 23, 4, 'Vojtěch', 0),
				(115, 24, 4, 'Jiří', 0),
				(116, 25, 4, 'Marek', 0),
				(117, 26, 4, 'Oto', 0),
				(118, 27, 4, 'Jaroslav', 0),
				(119, 28, 4, 'Vlastislav', 0),
				(120, 29, 4, 'Robert', 0),
				(121, 30, 4, 'Blahoslav', 0),
				(122, 1, 5, 'Svátek práce', 1),
				(123, 2, 5, 'Zikmund', 0),
				(124, 3, 5, 'Alexej', 0),
				(125, 4, 5, 'Květoslav', 0),
				(126, 5, 5, 'Klaudie, Květnové povstání českého lidu(1945)', 0),
				(127, 6, 5, 'Radoslav', 0),
				(128, 7, 5, 'Stanisla', 0),
				(129, 8, 5, 'Den osvobození od fašismu(1945)', 1),
				(130, 9, 5, 'Ctibor', 0),
				(131, 10, 5, 'Blažena', 0),
				(132, 11, 5, 'Svatava', 0),
				(133, 12, 5, 'Pankrác', 0),
				(134, 13, 5, 'Servác', 0),
				(135, 14, 5, 'Bonifác', 0),
				(136, 15, 5, 'Žofie', 0),
				(137, 16, 5, 'Přemysl', 0),
				(138, 17, 5, 'Aneta', 0),
				(139, 18, 5, 'Nataša', 0),
				(140, 19, 5, 'Ivo', 0),
				(141, 20, 5, 'Zbyšek', 0),
				(142, 21, 5, 'Monika', 0),
				(143, 22, 5, 'Emil', 0),
				(144, 23, 5, 'Vladimír', 0),
				(145, 24, 5, 'Jana', 0),
				(146, 25, 5, 'Viola', 0),
				(147, 26, 5, 'Filip', 0),
				(148, 27, 5, 'Valdemar', 0),
				(149, 28, 5, 'Vilém', 0),
				(150, 29, 5, 'Maxmilián', 0),
				(151, 30, 5, 'Ferdinand', 0),
				(152, 31, 5, 'Kamila', 0),
				(153, 1, 6, 'Laura', 0),
				(154, 2, 6, 'Jarmil', 0),
				(155, 3, 6, 'Tamara', 0),
				(156, 4, 6, 'Dalibor', 0),
				(157, 5, 6, 'Dobroslav', 0),
				(158, 6, 6, 'Norbert', 0),
				(159, 7, 6, 'Iveta/Slavoj', 0),
				(160, 8, 6, 'Medard', 0),
				(161, 9, 6, 'Stanislav', 0),
				(162, 10, 6, 'Gita', 0),
				(163, 11, 6, 'Bruno', 0),
				(164, 12, 6, 'Antonie', 0),
				(165, 13, 6, 'Antonín', 0),
				(166, 14, 6, 'Roland', 0),
				(167, 15, 6, 'Vít', 0),
				(168, 16, 6, 'Zbyněk', 0),
				(169, 17, 6, 'Adolf', 0),
				(170, 18, 6, 'Milan', 0),
				(171, 19, 6, 'Leoš', 0),
				(172, 20, 6, 'Květa', 0),
				(173, 21, 6, 'Alois', 0),
				(174, 22, 6, 'Pavla', 0),
				(175, 23, 6, 'Zdeňka', 0),
				(176, 24, 6, 'Jan', 0),
				(177, 25, 6, 'Ivan', 0),
				(178, 26, 6, 'Adriana', 0),
				(179, 27, 6, 'Ladislav', 0),
				(180, 28, 6, 'Lubomír', 0),
				(181, 29, 6, 'Petr a Pavel', 0),
				(182, 30, 6, 'Šárka', 0),
				(183, 1, 7, 'Jaroslava', 0),
				(184, 2, 7, 'Patricie', 0),
				(185, 3, 7, 'Radomír', 0),
				(186, 4, 7, 'Prokop', 0),
				(187, 5, 7, 'Den slovanských věrozvěstů Cyrila a Metoděje', 1),
				(188, 6, 7, 'Den Upálení mistra Jana Husa(1415)', 1),
				(189, 7, 7, 'Bohuslava', 0),
				(190, 8, 7, 'Nora', 0),
				(191, 9, 7, 'Drahoslava', 0),
				(192, 10, 7, 'Libuše/Amálie', 0),
				(193, 11, 7, 'Olga', 0),
				(194, 12, 7, 'Bořek', 0),
				(195, 13, 7, 'Markéta', 0),
				(196, 14, 7, 'Karolína', 0),
				(197, 15, 7, 'Jindřich', 0),
				(198, 16, 7, 'Luboš', 0),
				(199, 17, 7, 'Martina', 0),
				(200, 18, 7, 'Drahomíra', 0),
				(201, 19, 7, 'Čeněk', 0),
				(202, 20, 7, 'Ilja', 0),
				(203, 21, 7, 'Vítězslav', 0),
				(204, 22, 7, 'Magdeléna', 0),
				(205, 23, 7, 'Libor', 0),
				(206, 24, 7, 'Kristýna', 0),
				(207, 25, 7, 'Jakub', 0),
				(208, 26, 7, 'Anna', 0),
				(209, 27, 7, 'Věroslav', 0),
				(210, 28, 7, 'Viktor', 0),
				(211, 29, 7, 'Marta', 0),
				(212, 30, 7, 'Bořivoj', 0),
				(213, 31, 7, 'Ignác', 0),
				(214, 1, 8, 'Oskar', 0),
				(215, 2, 8, 'Gustav', 0),
				(216, 3, 8, 'Miluše', 0),
				(217, 4, 8, 'Dominik', 0),
				(218, 5, 8, 'Kristián', 0),
				(219, 6, 8, 'Oldřiška', 0),
				(220, 7, 8, 'Lada', 0),
				(221, 8, 8, 'Soběslav', 0),
				(222, 9, 8, 'Roman', 0),
				(223, 10, 8, 'Vavřinec', 0),
				(224, 11, 8, 'Zuzana', 0),
				(225, 12, 8, 'Klára', 0),
				(226, 13, 8, 'Alena', 0),
				(227, 14, 8, 'Alan', 0),
				(228, 15, 8, 'Hana', 0),
				(229, 16, 8, 'Jáchym', 0),
				(230, 17, 8, 'Petra', 0),
				(231, 18, 8, 'Helena', 0),
				(232, 19, 8, 'Ludvík', 0),
				(233, 20, 8, 'Bernard', 0),
				(234, 21, 8, 'Johana', 0),
				(235, 22, 8, 'Bohuslav', 0),
				(236, 23, 8, 'Sandra', 0),
				(237, 24, 8, 'Bartoloměj', 0),
				(238, 25, 8, 'Radim', 0),
				(239, 26, 8, 'Luděk', 0),
				(240, 27, 8, 'Otakar', 0),
				(241, 28, 8, 'Augustýn', 0),
				(242, 29, 8, 'Evelýna', 0),
				(243, 30, 8, 'Vladěna', 0),
				(244, 31, 8, 'Pavlína', 0),
				(245, 1, 9, 'Linda/Samuel', 0),
				(246, 2, 9, 'Adéla', 0),
				(247, 3, 9, 'Bronislav', 0),
				(248, 4, 9, 'Jindřiška', 0),
				(249, 5, 9, 'Boris', 0),
				(250, 6, 9, 'Boleslav', 0),
				(251, 7, 9, 'Regína', 0),
				(252, 8, 9, 'Mariana', 0),
				(253, 9, 9, 'Daniela', 0),
				(254, 10, 9, 'Irma', 0),
				(255, 11, 9, 'Denisa', 0),
				(256, 12, 9, 'Marie', 0),
				(257, 13, 9, 'Lubor', 0),
				(258, 14, 9, 'Radka', 0),
				(259, 15, 9, 'Jolana', 0),
				(260, 16, 9, 'Ludmila', 0),
				(261, 17, 9, 'Naděžda', 0),
				(262, 18, 9, 'Kryštof', 0),
				(263, 19, 9, 'Zita', 0),
				(264, 20, 9, 'Oleg', 0),
				(265, 21, 9, 'Matouš', 0),
				(266, 22, 9, 'Darina', 0),
				(267, 23, 9, 'Berta', 0),
				(268, 24, 9, 'Jaromír', 0),
				(269, 25, 9, 'Zlata', 0),
				(270, 26, 9, 'Andrea', 0),
				(271, 27, 9, 'Jonáš', 0),
				(272, 28, 9, 'Václav, Den české státnosti', 1),
				(273, 29, 9, 'Michal', 0),
				(274, 30, 9, 'Jeroným', 0),
				(275, 1, 10, 'Igor', 0),
				(276, 2, 10, 'Olívie', 0),
				(277, 3, 10, 'Bohumil', 0),
				(278, 4, 10, 'František', 0),
				(279, 5, 10, 'Eliška', 0),
				(280, 6, 10, 'Hanuš', 0),
				(281, 7, 10, 'Justýna', 0),
				(282, 8, 10, 'Věra', 0),
				(283, 9, 10, 'Štefan/Sára', 0),
				(284, 10, 10, 'Marina', 0),
				(285, 11, 10, 'Andrej', 0),
				(286, 12, 10, 'Marcel', 0),
				(287, 13, 10, 'Renáta', 0),
				(288, 14, 10, 'Agáta', 0),
				(289, 15, 10, 'Tereza', 0),
				(290, 16, 10, 'Havel', 0),
				(291, 17, 10, 'Hedvika', 0),
				(292, 18, 10, 'Lukáš', 0),
				(293, 19, 10, 'Michaela', 0),
				(294, 20, 10, 'Vendelín', 0),
				(295, 21, 10, 'Brigita', 0),
				(296, 22, 10, 'Sabina', 0),
				(297, 23, 10, 'Teodor', 0),
				(298, 24, 10, 'Nina', 0),
				(299, 25, 10, 'Beáta', 0),
				(300, 26, 10, 'Erik', 0),
				(301, 27, 10, 'Šarlota/Zoe', 0),
				(302, 28, 10, 'Den vzniku samostatného československého státu', 1),
				(303, 29, 10, 'Silvie', 0),
				(304, 30, 10, 'Tadeáš', 0),
				(305, 31, 10, 'Štěpánka', 0),
				(306, 1, 11, 'Felix', 0),
				(307, 2, 11, 'Památka zesnulých', 0),
				(308, 3, 11, 'Hubert', 0),
				(309, 4, 11, 'Karel', 0),
				(310, 5, 11, 'Miriam', 0),
				(311, 6, 11, 'Liběna', 0),
				(312, 7, 11, 'Saskie', 0),
				(313, 8, 11, 'Bohumír', 0),
				(314, 9, 11, 'Bohdan', 0),
				(315, 10, 11, 'Evžen', 0),
				(316, 11, 11, 'Martin', 0),
				(317, 12, 11, 'Benedikt', 0),
				(318, 13, 11, 'Tibor', 0),
				(319, 14, 11, 'Sýva', 0),
				(320, 15, 11, 'Leopold', 0),
				(321, 16, 11, 'Otmar', 0),
				(322, 17, 11, 'Mahulena, Den boje studentů za svobodu a demokraci', 1),
				(323, 18, 11, 'Romana', 0),
				(324, 19, 11, 'Alžběta', 0),
				(325, 20, 11, 'Nikola', 0),
				(326, 21, 11, 'Albert', 0),
				(327, 22, 11, 'Cecílie', 0),
				(328, 23, 11, 'Klement', 0),
				(329, 24, 11, 'Emýlie', 0),
				(330, 25, 11, 'Kateřina', 0),
				(331, 26, 11, 'Artur', 0),
				(332, 27, 11, 'Xenie', 0),
				(333, 28, 11, 'René', 0),
				(334, 29, 11, 'Zina', 0),
				(335, 30, 11, 'Ondřej', 0),
				(336, 1, 12, 'Iva', 0),
				(337, 2, 12, 'Blanka', 0),
				(338, 3, 12, 'Svatoslav', 0),
				(339, 4, 12, 'Barbora', 0),
				(340, 5, 12, 'Jitka', 0),
				(341, 6, 12, 'Mikuláš', 0),
				(342, 7, 12, 'Ambrož/Benjam', 0),
				(343, 8, 12, 'Květoslava', 0),
				(344, 9, 12, 'Vratislav', 0),
				(345, 10, 12, 'Julie', 0),
				(346, 11, 12, 'Dana', 0),
				(347, 12, 12, 'Simona', 0),
				(348, 13, 12, 'Lucie', 0),
				(349, 14, 12, 'Lídie', 0),
				(350, 15, 12, 'Radana', 0),
				(351, 16, 12, 'Albína', 0),
				(352, 17, 12, 'Daniel', 0),
				(353, 18, 12, 'Miloslav', 0),
				(354, 19, 12, 'Ester', 0),
				(355, 20, 12, 'Dagmar', 0),
				(356, 21, 12, 'Natálie', 0),
				(357, 22, 12, 'Šimon', 0),
				(358, 23, 12, 'Vlasta', 0),
				(359, 24, 12, 'Adam a Eva, Štědrý den', 1),
				(360, 25, 12, 'Boží hod vánoční, 1.svátek vánoční', 1),
				(361, 26, 12, 'Štěpán, 2.svátek vánoční', 1),
				(362, 27, 12, 'Žaneta', 0),
				(363, 28, 12, 'Bohumila', 0),
				(364, 29, 12, 'Judita', 0),
				(365, 30, 12, 'David', 0),
				(366, 31, 12, 'Silvestr', 0);";
		return $this->sql->query($query);
	}
}


/**
 O nás,
 Kontakty
 Obchodní podmínky
 Jak nakupovat
 * */

/**


 INSERT INTO `mm_slovnik` (`id`, `isDeleted`, `TimeStamp`, `ChangeTimeStamp`, `keyword`) VALUES
 (1, 0, '2014-03-02 15:41:27', '2014-12-27 23:49:49', 'znacka_zbozi'),
 (2, 0, '2014-03-02 15:41:49', '2014-03-02 15:41:49', 'kod_zbozi'),
 (3, 0, '2014-03-02 15:42:02', '2014-03-02 15:42:02', 'dostupnost'),
 (4, 0, '2014-03-02 15:42:19', '2014-03-02 15:42:19', 'zaruka'),
 (5, 0, '2014-03-02 15:42:40', '2014-03-02 15:42:40', 'koupit'),
 (6, 0, '2014-03-02 15:42:56', '2014-03-02 15:42:56', 'celkem_bez_dph'),
 (7, 0, '2014-03-02 15:43:39', '2014-03-02 15:43:39', 'add_favorite'),
 (8, 0, '2014-03-02 15:44:13', '2014-03-02 15:44:13', 'popis_pneu'),
 (9, 0, '2014-03-02 15:44:27', '2014-03-02 15:44:27', 'parametry_pneu'),
 (10, 0, '2014-03-02 15:45:17', '2014-03-02 15:45:17', 'detail'),
 (11, 0, '2014-03-02 21:24:32', '2014-03-02 21:24:32', 'product'),
 (12, 0, '2014-03-02 21:24:46', '2014-12-27 00:28:53', 'nakupni_kosik'),
 (13, 0, '2014-03-02 21:25:04', '2014-03-02 21:25:04', 'cena_za_jednotku'),
 (14, 0, '2014-03-02 21:25:20', '2014-03-02 21:25:20', 'mnozstvi'),
 (15, 0, '2014-03-02 21:26:04', '2014-03-02 21:26:04', 'celkem_vc_dph'),
 (16, 0, '2014-03-02 21:26:37', '2014-03-02 21:26:37', 'upravit'),
 (17, 0, '2014-03-02 21:26:51', '2014-03-02 21:26:51', 'castka_za_dopravu'),
 (18, 0, '2014-03-02 21:27:10', '2014-03-02 21:27:10', 'celkova_cena_bez_dph'),
 (19, 0, '2014-03-02 21:27:25', '2014-03-02 21:27:25', 'castka_dph'),
 (20, 0, '2014-03-02 21:27:43', '2014-03-02 21:27:43', 'celkova_cena_objednavky'),
 (21, 0, '2014-03-02 21:28:11', '2014-03-02 21:28:11', 'vyprazdnit_kosik'),
 (22, 0, '2014-03-02 21:28:48', '2014-03-02 21:28:48', 'vytvorit_objednavku'),
 (23, 0, '2014-03-02 21:29:24', '2014-03-02 21:29:24', 'polozek_v_kosiku'),
 (24, 0, '2014-03-02 21:29:43', '2014-03-02 21:29:43', 'logout'),
 (25, 0, '2014-03-02 21:30:03', '2014-03-02 21:30:03', 'account'),
 (26, 0, '2014-03-02 21:30:26', '2014-03-02 21:30:26', 'cena'),
 (27, 0, '2014-03-02 21:31:10', '2014-03-02 21:31:10', 'zvolte_zpusob_dopravy'),
 (28, 0, '2014-03-02 21:31:57', '2014-03-02 21:31:57', 'volba_zpusobu_platby'),
 (29, 0, '2014-03-02 21:32:32', '2014-03-02 21:32:32', 'zvolte_zpusob_platby'),
 (30, 0, '2014-03-02 21:33:10', '2014-03-02 21:33:10', 'fakturacni_udaje'),
 (31, 0, '2014-03-02 21:33:46', '2014-03-02 21:33:46', 'fakturacni_adresa'),
 (32, 0, '2014-03-02 21:33:58', '2014-03-02 21:33:58', 'dodaci_adresa'),
 (33, 0, '2014-03-02 21:34:22', '2014-03-02 21:34:22', 'odeslat_objednavku'),
 (34, 0, '2014-03-02 21:35:01', '2014-03-02 21:35:01', 'rozdilna_dodaci_adresa'),
 (35, 0, '2014-03-02 21:35:49', '2014-03-02 21:35:49', 'kosik_je_prazdny'),
 (36, 0, '2014-03-02 21:36:18', '2014-03-02 21:36:18', 'jmeno_firma'),
 (37, 0, '2014-03-02 21:37:06', '2014-03-02 21:37:06', 'trideni_vzestupne'),
 (38, 0, '2014-03-02 21:37:35', '2014-03-02 21:37:35', 'trideni_sestupne'),
 (39, 0, '2014-03-03 14:51:11', '2014-03-03 14:51:11', 'register'),
 (40, 0, '2014-03-03 14:51:20', '2014-03-03 14:51:20', 'login'),
 (41, 0, '2014-03-11 16:57:05', '2014-03-11 16:57:05', 'prijata_objednavka_cislo'),
 (42, 0, '2014-03-11 16:57:21', '2014-03-11 16:57:21', 'odberatel'),
 (43, 0, '2014-03-11 16:57:30', '2014-03-11 16:57:30', 'dodavatel'),
 (44, 0, '2014-03-11 16:57:48', '2014-03-11 16:57:48', 'ico'),
 (45, 0, '2014-03-11 16:57:59', '2014-03-11 16:57:59', 'dic'),
 (46, 0, '2014-03-11 16:58:11', '2014-03-11 16:58:11', 'variabilni_symbol'),
 (47, 0, '2014-03-11 16:58:22', '2014-03-11 16:58:22', 'datum_vystaveni'),
 (48, 0, '2014-03-11 16:58:51', '2014-03-11 16:58:51', 'zpusob_dopravy'),
 (49, 0, '2014-03-11 16:59:05', '2014-03-11 16:59:05', 'zpusob_platby'),
 (50, 0, '2014-03-11 16:59:16', '2014-03-11 16:59:16', 'cislo_uctu_iban'),
 (51, 0, '2014-03-11 16:59:36', '2014-03-11 16:59:36', 'dodavatel_platce'),
 (52, 0, '2014-03-11 17:00:38', '2014-03-11 17:00:38', 'uvodni_text_objednavky'),
 (53, 0, '2014-03-11 17:00:53', '2014-03-11 17:00:53', 'sazba_dph'),
 (54, 0, '2014-03-11 17:01:07', '2014-03-11 17:01:07', 'celkem'),
 (55, 0, '2014-03-11 17:01:19', '2014-03-11 17:01:19', 'mezisoucet'),
 (56, 0, '2014-03-11 17:01:33', '2014-03-11 17:01:33', 'vyse_dane'),
 (57, 0, '2014-03-11 17:02:03', '2014-03-11 17:02:03', 'celkova_cena_objednavky_sdani'),
 (58, 0, '2014-03-11 17:02:38', '2015-01-17 20:38:57', 'poznamka_objednavky'),
 (59, 0, '2014-03-11 17:03:04', '2014-03-11 17:03:04', 'poznamka_zakaznika'),
 (60, 0, '2014-03-11 17:03:43', '2014-03-11 17:03:43', 'kontaktni_udaje_zakaznika'),
 (61, 0, '2014-03-12 21:37:27', '2014-03-12 21:37:27', 'home'),
 (62, 0, '2014-03-14 21:23:07', '2014-03-14 21:23:07', 'your_basket_is_empty'),
 (63, 0, '2014-03-14 21:34:21', '2015-01-17 20:38:38', 'objednavka_dokoncena_info'),
 (64, 0, '2014-08-28 19:22:16', '2014-08-28 19:22:16', 'znacka_value'),
 (65, 0, '2014-08-28 19:31:26', '2014-08-28 19:31:26', 'parametry'),
 (66, 0, '2014-08-28 19:31:35', '2014-08-28 19:31:35', 'popis'),
 (67, 0, '2014-08-28 19:51:24', '2014-08-28 19:51:24', 'odebrat_zbozi_z_kosiku'),
 (68, 0, '2014-12-27 00:29:44', '2014-12-27 00:29:44', 'pokracovat_v_nakupu');

 --
 -- Vypisuji data pro tabulku `mm_slovnik_version`
 --

 INSERT INTO `mm_slovnik_version` (`id`, `isDeleted`, `TimeStamp`, `ChangeTimeStamp`, `name`, `lang_id`, `keyword_id`) VALUES
 (1, 0, '2014-03-02 15:41:27', '2014-12-27 23:49:49', 'Výrobce/Značka', 6, 1),
 (2, 0, '2014-03-02 15:41:49', '2014-03-02 15:41:49', 'Katalogové číslo', 6, 2),
 (3, 0, '2014-03-02 15:42:02', '2014-03-02 15:42:02', 'Dostupnost', 6, 3),
 (4, 0, '2014-03-02 15:42:19', '2014-03-02 15:42:19', 'Záruka', 6, 4),
 (5, 0, '2014-03-02 15:42:40', '2014-03-02 15:42:40', 'Koupit', 6, 5),
 (6, 0, '2014-03-02 15:42:56', '2014-03-02 15:42:56', 'Celkem bez DPH', 6, 6),
 (7, 0, '2014-03-02 15:43:39', '2014-03-02 15:43:39', 'Přidat do sledovaných', 6, 7),
 (8, 0, '2014-03-02 15:44:13', '2014-03-02 15:44:13', 'Popis pneu', 6, 8),
 (9, 0, '2014-03-02 15:44:27', '2014-03-02 15:44:27', 'Parametry pneu', 6, 9),
 (10, 0, '2014-03-02 15:45:17', '2014-03-02 15:45:17', 'Detail', 6, 10),
 (11, 0, '2014-03-02 21:24:32', '2014-03-02 21:24:32', 'Název zboží', 6, 11),
 (12, 0, '2014-03-02 21:24:46', '2014-12-27 00:28:53', 'Nákupní košík', 6, 12),
 (13, 0, '2014-03-02 21:25:04', '2014-03-02 21:25:04', 'Cena / MJ', 6, 13),
 (14, 0, '2014-03-02 21:25:20', '2014-03-02 21:25:20', 'Množství', 6, 14),
 (15, 0, '2014-03-02 21:26:04', '2014-03-02 21:26:04', 'Celkem vč. DPH', 6, 15),
 (16, 0, '2014-03-02 21:26:37', '2014-03-02 21:26:37', 'změnit', 6, 16),
 (17, 0, '2014-03-02 21:26:51', '2014-03-02 21:26:51', 'Dopravné', 6, 17),
 (18, 0, '2014-03-02 21:27:10', '2014-03-02 21:27:10', 'Celkem bez DPH', 6, 18),
 (19, 0, '2014-03-02 21:27:25', '2014-03-02 21:27:25', 'DPH', 6, 19),
 (20, 0, '2014-03-02 21:27:43', '2014-03-02 21:27:43', 'K úhradě', 6, 20),
 (21, 0, '2014-03-02 21:28:11', '2014-03-02 21:28:11', 'Vyprázdnit košík', 6, 21),
 (22, 0, '2014-03-02 21:28:48', '2014-03-02 21:28:48', 'Pokračovat k pokladně', 6, 22),
 (23, 0, '2014-03-02 21:29:24', '2014-03-02 21:29:24', 'Položky v košíku', 6, 23),
 (24, 0, '2014-03-02 21:29:43', '2014-03-02 21:29:43', 'Odhlásit se', 6, 24),
 (25, 0, '2014-03-02 21:30:03', '2014-03-02 21:30:03', 'profil', 6, 25),
 (26, 0, '2014-03-02 21:30:26', '2014-03-02 21:30:26', 'Celkem', 6, 26),
 (27, 0, '2014-03-02 21:31:10', '2014-03-02 21:31:10', 'Zvolte způsob dopravy', 6, 27),
 (28, 0, '2014-03-02 21:31:57', '2014-03-02 21:31:57', 'Pokračovat k výběru platby', 6, 28),
 (29, 0, '2014-03-02 21:32:32', '2014-03-02 21:32:32', 'Zvolte způsob platby', 6, 29),
 (30, 0, '2014-03-02 21:33:10', '2014-03-02 21:33:10', 'Fakturační údaje', 6, 30),
 (31, 0, '2014-03-02 21:33:46', '2014-03-02 21:33:46', 'Fakturační adresa', 6, 31),
 (32, 0, '2014-03-02 21:33:58', '2014-03-02 21:33:58', 'Dodací adresa', 6, 32),
 (33, 0, '2014-03-02 21:34:22', '2014-03-02 21:34:22', 'Dokončit objednávku', 6, 33),
 (34, 0, '2014-03-02 21:35:01', '2014-03-02 21:35:01', 'Dodací adresu vyplňte v případě, že se obě liší!', 6, 34),
 (35, 0, '2014-03-02 21:35:49', '2014-03-02 21:35:49', 'Váš košík je prázdný', 6, 35),
 (36, 0, '2014-03-02 21:36:18', '2014-03-02 21:36:18', 'Jméno a Příjmení / Firma', 6, 36),
 (37, 0, '2014-03-02 21:37:06', '2014-03-02 21:37:06', 'a-Z', 6, 37),
 (38, 0, '2014-03-02 21:37:35', '2014-03-02 21:37:35', 'z-A', 6, 38),
 (39, 0, '2014-03-03 14:51:11', '2014-03-03 14:51:11', 'Registrovat', 6, 39),
 (40, 0, '2014-03-03 14:51:20', '2014-03-03 14:51:20', 'Přihlásit', 6, 40),
 (41, 0, '2014-03-11 16:57:05', '2014-03-11 16:57:05', 'Přijatá objednávka č.', 6, 41),
 (42, 0, '2014-03-11 16:57:21', '2014-03-11 16:57:21', 'Odběratel', 6, 42),
 (43, 0, '2014-03-11 16:57:30', '2014-03-11 16:57:30', 'Dodavatel', 6, 43),
 (44, 0, '2014-03-11 16:57:48', '2014-03-11 16:57:48', 'IČ', 6, 44),
 (45, 0, '2014-03-11 16:57:59', '2014-03-11 16:57:59', 'DIČ', 6, 45),
 (46, 0, '2014-03-11 16:58:11', '2014-03-11 16:58:11', 'Variabilní symbol', 6, 46),
 (47, 0, '2014-03-11 16:58:22', '2014-03-11 16:58:22', 'Datum vystavení', 6, 47),
 (48, 0, '2014-03-11 16:58:51', '2014-03-11 16:58:51', 'Způsob dopravy zboží', 6, 48),
 (49, 0, '2014-03-11 16:59:05', '2014-03-11 16:59:05', 'Způsob úhrady', 6, 49),
 (50, 0, '2014-03-11 16:59:16', '2014-03-11 16:59:16', 'Bankovní spojení', 6, 50),
 (51, 0, '2014-03-11 16:59:36', '2014-03-11 16:59:36', 'Dodavatel není plátce DPH', 6, 51),
 (52, 0, '2014-03-11 17:00:38', '2014-03-11 17:00:38', 'Fakturujeme Vám za níže objednané zboží. Ceny jsou smluvní dle našeho ceníku a jsou uvedeny v CZK.', 6, 52),
 (53, 0, '2014-03-11 17:00:53', '2014-03-11 17:00:53', 'Sazba DPH', 6, 53),
 (54, 0, '2014-03-11 17:01:07', '2014-03-11 17:01:07', 'Celkem', 6, 54),
 (55, 0, '2014-03-11 17:01:19', '2014-03-11 17:01:19', 'Mezisoučet', 6, 55),
 (56, 0, '2014-03-11 17:01:33', '2014-03-11 17:01:33', 'Výše daně', 6, 56),
 (57, 0, '2014-03-11 17:02:03', '2014-03-11 17:02:03', 'K zaplacení', 6, 57),
 (58, 0, '2014-03-11 17:02:38', '2015-01-17 20:38:57', 'Upozornění: Nejedná se o daňový doklad. Daňový doklad Vám vystavíme při expedici/dodání zboží. Zákazník při objednání zboží souhlasil s obchodními podmínkami\r\nna stránkách www.voda-in.cz', 6, 58),
 (59, 0, '2014-03-11 17:03:04', '2014-03-11 17:03:04', 'Poznámka od zákazníka', 6, 59),
 (60, 0, '2014-03-11 17:03:43', '2014-03-11 17:03:43', 'Kontaktní údaje odběratele / Vyřizuje', 6, 60),
 (61, 0, '2014-03-12 21:37:27', '2014-03-12 21:37:27', 'Úvodní stránka', 6, 61),
 (62, 0, '2014-03-14 21:23:07', '2014-03-14 21:23:07', 'Váš košík jezatím prázdný', 6, 62),
 (63, 0, '2014-03-14 21:34:21', '2015-01-17 20:38:38', 'Vaše objednávka byla úspěšně dokončena.<br />\r\nVelice děkujeme za Váš nákup na www.voda-in.cz', 6, 63),
 (64, 0, '2014-08-28 19:22:16', '2014-08-28 19:22:16', 'Výrobce', 6, 64),
 (65, 0, '2014-08-28 19:31:26', '2014-08-28 19:31:26', 'Parametry', 6, 65),
 (66, 0, '2014-08-28 19:31:35', '2014-08-28 19:31:35', 'Popis', 6, 66),
 (67, 0, '2014-08-28 19:51:24', '2014-08-28 19:51:24', 'Odebrat zboží z košíku?', 6, 67),
 (68, 0, '2014-12-27 00:29:44', '2014-12-27 00:29:44', 'Zpět do obchodu', 6, 68);

 * */
?>
<?php

require_once("ADictionary.php");
class DphDictionary extends ADictionary{


	public static $dictionary = array();

	public static $entityName = "Dph";

	public function createDictionary(){

		$modelName = "models_" . self::getEntityName();

		$model = new $modelName;

		$args = new ListArgs();
		$args->limit = 1000;

		//	return $model->getList($args);
		self::$dictionary = $model->getList($args);

	//	print $model->getLastQuery();

	}

	public static function getDictionaryEntry($name, $added = true)
	{
		if (empty($name)) {
			return NULL;
		}


		if (count(self::$dictionary)==0) {
			self::createDictionary();
		}


		// snažím se dohledat ID z DB
		for ($i=0;$i<count(self::$dictionary);$i++)
		{
			//print $serial_cat_title . "===" . $category_path . "<br />";
			if (self::$dictionary[$i]->name === $name) {

//				print "Našel:" . self::$dictionary[$i]->name . "===" . $name . "<br />";

				//	print_r(self::$dictionary[$i]);
				return self::$dictionary[$i]->id;
			}
		}


		if ($added) {


			$data = array();
			$data["name"] = $name;

			return self::pridej($data);
		}
		return false;


	}

	protected function pridej($data = array())
	{
		//	$data["name"] = $name;

		$entityName = self::getEntityName(). "Entity";

		$saveEntity = new SaveEntity();
		$entitaOut = new $entityName;

		$entitaOut->naplnEntitu($data);
		$saveEntity->addSaveEntity($entitaOut);

		if ($saveEntity->save()) {
			// nově načtu slovník
			self::$dictionary= self::createDictionary();
			return $saveEntity->getSavedEntity($entityName)->getId();
		}
		return false;
	}

	protected function getEntityName()
	{
		return self::$entityName;
	}

	public static function getDictionaryValue($name, $added = false)
	{
		//	self::$entityName = "Dph";
		if (empty($name)) {
			return NULL;
		}


		if (count(self::$dictionary)==0) {
			self::createDictionary();
		}

	//	print_r((self::$dictionary));


		// snažím se dohledat ID z DB
		for ($i=0;$i<count(self::$dictionary);$i++)
		{
			$name = $name*1;
			$value = self::$dictionary[$i]->value * 1;
	//		print $value . "===" . $name . "<br />";
			if (self::$dictionary[$i]->value == $name) {

//				print "Našel:" . $value . "===" . $name . "<br />";

				//	print_r(self::$dictionary[$i]);
				return self::$dictionary[$i]->id;
			}
		}


		if ($added) {


			$data = array();
			$data["name"] = $name;
			$data["value"] = $name;
			return self::pridej($data = array());
		}
		return NULL;


	}

}




?>
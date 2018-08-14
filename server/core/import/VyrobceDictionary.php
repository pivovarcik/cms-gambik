<?php

class VyrobceDictionary{


	public static $dictionary = array();

	public function createDictionary(){
		$productModel = new models_ProductVyrobce();
		$args = new ListArgs();
		$args->limit = 1000;
		$args->page = 1;
		self::$dictionary = $productModel->getList($args);



		//print $productModel->getLastQuery();
		//print_R(self::$dictionary);

	}

	public static function getDictionaryEntry($name, $added = true)
	{

		if (empty($name)) {
			return null;
		}
		if (count(self::$dictionary)==0) {
			self::createDictionary();
		}



		for ($i=0;$i<count(self::$dictionary);$i++)
		{

			$title = self::$dictionary[$i]->name;

			if (strtoupper($title) === strtoupper($name)) {

//				print 'Výrobce nalezen!<br />';
				return self::$dictionary[$i]->id;
			}
		}

		if ($added) {
			$saveEntity = new SaveEntity();
			$entitaOut = new ProductVyrobceEntity();

			$data = array();
			$data["name"] = $name;
			$entitaOut->naplnEntitu($data);
			$saveEntity->addSaveEntity($entitaOut);

			if ($saveEntity->save()) {
				$id = $saveEntity->getSavedEntity("ProductVyrobceEntity")->getId();
				$obj = new stdClass();
				$obj->id = $id;
				$obj->name = $name;
				array_push(self::$dictionary, $obj);
				return $id;
			}
			return null;
		}
		/*
		$productModel = new models_ProductVyrobce();
		if ($detail = $productModel->getDetailByName($name)) {
			return $detail->id;
		} else {

			$saveEntity = new SaveEntity();
			$entitaOut = new ProductVyrobceEntity();

			$data = array();
			$data["name"] = $name;
			$entitaOut->naplnEntitu($data);
			$saveEntity->addSaveEntity($entitaOut);

			if ($saveEntity->save()) {
				return $saveEntity->getSavedEntity("ProductVyrobceEntity")->getId();
			}
			return false;

		}*/
	}
}



?>
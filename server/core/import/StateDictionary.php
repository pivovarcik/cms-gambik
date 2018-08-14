<?php

class StateDictionary{

	public static function getDictionaryEntry($name)
	{
		$productModel = new models_ProductCategory();
		if ($detail = $productModel->getDetailByName($name)) {
			return $detail->id;
		} else {

			$saveEntity = new SaveEntity();
			$entitaOut = new ProductCategoryEntity();

			$data = array();
			$data["name"] = $name;
			$entitaOut->naplnEntitu($data);
			$saveEntity->addSaveEntity($entitaOut);

			if ($saveEntity->save()) {
				return $saveEntity->getSavedEntity("ProductCategoryEntity")->getId();
			}
			return false;

		}
	}
}


?>
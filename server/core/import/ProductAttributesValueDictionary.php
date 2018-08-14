<?php

class ProductAttributesValueDictionary{

	public static function getDictionaryEntry($name,$value)
	{
		$attrib_id = ProductAttributesDictionary::getDictionaryEntry($name);


		$productModel = new models_Attributes();
		if ($detail = $productModel->get_attributeValueIdByAttributeNameAndValue($attrib_id, $value)) {
			return $detail->id;
		} else {

			$saveEntity = new SaveEntity();
			$entitaOut = new ProductAttributeValuesEntity();

			$data = array();
			$data["name"] = $value;
			$data["attribute_id"] = $attrib_id;
			$entitaOut->naplnEntitu($data);
			$saveEntity->addSaveEntity($entitaOut);

			if ($saveEntity->save()) {
				return $saveEntity->getSavedEntity("ProductAttributeValuesEntity")->getId();
			}
			return false;


		}
	}
}



?>
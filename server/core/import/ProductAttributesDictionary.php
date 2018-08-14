<?php

class ProductAttributesDictionary{

	public static function getDictionaryEntry($name)
	{
		$productModel = new models_Attributes();
		if ($detail = $productModel->getDetailByName($name, LANG_TRANSLATOR)) {
			return $detail->id;
		} else {


        $Entity = new ProductAttributesEntity(null);
        
        $saveEntity = new SaveEntity();
				$saveEntity->addSaveEntity($Entity);


        

				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();




				// Verzování dle jazyků
				foreach ($languageList as $key => $val){

          $versionEntity = new ProductAttributesVersionEntity();
		
          $versionEntity->lang_id = $val->id;
      
	
					$versionEntity->name = $name;
          $saveEntity->addSaveEntity($versionEntity);

				}

			if ($saveEntity->save()) {
				return $saveEntity->getSavedEntity("ProductAttributesEntity")->getId();
			}
			return false;
        
        
        
        
		}
	}
}



?>
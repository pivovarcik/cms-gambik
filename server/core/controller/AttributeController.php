<?php




/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class AttributeController extends G_Controller_Action
{
	
  	public function deleteAjaxAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteAttributes" == $this->getRequest->getPost('action', false))
		{



			$doklad_id = (int) $this->getRequest->getQuery('id', 0);

			if ($doklad_id) {
				$model = new models_ProductAttributes();
				$obj = $model->getDetailById($doklad_id);

				if ($obj) {
					$data = array();
					$data["isDeleted"] = 1;
					if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
					{
						array_push($seznamCiselObjednavek,$obj->id );
						return true;
					}
				}

			}

		}
	}

	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "AttribEdit" == $this->getRequest->getPost('action', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('AttribEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$page_id = (int) $this->getRequest->getQuery('id', 0);

				if ($page_id == 0) {
					$form->setResultError("Není zadáno ID.");
					return false;
				}
        $postdata = $form->getValues();
        $Entity = new ProductAttributesEntity($page_id);
        
        $saveEntity = new SaveEntity();
        $Entity->pohoda_id =  $postdata["pohoda_id"];
        $Entity->multi_select =  $postdata["multi_select"];
				$saveEntity->addSaveEntity($Entity);


        

				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();






				$data = array();
				//$data["keyword"] = $postdata["keyword"];

        $model = new models_ProductAttributes;

				// Verzování dle jazyků
				foreach ($languageList as $key => $val){

					$args = new ListArgs();

					$args->page_id = (int) $page_id;
					$args->lang = $val->code;
					$row = $model->getList($args);

				//	print_r($row);
        //exit;
					if (count($row) > 0) {
            $versionEntity = new ProductAttributesVersionEntity($row[0]->version_id);
					} else {
            $versionEntity = new ProductAttributesVersionEntity();
					}
          $versionEntity->lang_id = $val->id;
          $name = 'name_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionEntity->name = $postdata[$name];
					}
          
          $name = 'description_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionEntity->description = $postdata[$name];
					}

          $saveEntity->addSaveEntity($versionEntity);

				}

        if ($saveEntity->save()) {
        
        
        
        
        $formValue = $this->formLoad('AttribValueEdit');
				$formValueData = $formValue->getValues();
				$attrValArray = $formValue->getPost('attrVal', array());
				$attrCodeArray = $formValue->getPost('attrCode', array());
				$attrValIdArray = $formValue->getPost('attrValId', array());
			//	print_r($attrValArray);
				//exit;
				for($i=0;$i<count($attrValArray);$i++)
				{

					$attrVal = $attrValArray[$i];
					$attrCode = $attrCodeArray[$i];
					//print $attrVal;


					$changes = array();
					$changes["name"] = $attrVal;
					$changes["attribute_code"] = $attrCode;
					//	'attrValId[0]';
					//print $this->getRequest->getPost('attrValId[0]', 0);
					if (isset($attrValIdArray[$i])) {
						$idValue = $attrValIdArray[$i];


						if (empty($attrVal)) {
							if($model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES, "id={$idValue}"))
							{

							}
						} else {
							if($model->updateRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES, $changes, "id={$idValue}"))
							{

							}
						}


					} else {
						$inserted = array();
						$inserted["attribute_id"] = $page_id;
            $inserted["attribute_code"] = $attrCode;
						$inserted["name"] = $attrVal;
						if($model->insertRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES, $inserted))
						{

						}
					}



				}
        
        
          $form->setResultSuccess("Zaznam byl aktualizován.");
					return true;
        }
        


			}
		}
	}

	public function createAjaxAction()
	{

		//	PRINT_R($_POST);
		// Je odeslán formulář
		if($this->getRequest->isPost() && "AttribCreate" == $this->getRequest->getPost('action', false))
		{
//print "tudy";

			// načtu Objekt formu
			$form = $this->formLoad('AttribCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{





        $postdata = $form->getValues();
        $Entity = new ProductAttributesEntity(null);
        
        $saveEntity = new SaveEntity();
        $Entity->pohoda_id =  $postdata["pohoda_id"];
				$saveEntity->addSaveEntity($Entity);


        

				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();






				$data = array();
				//$data["keyword"] = $postdata["keyword"];

        $model = new models_ProductAttributes;

				// Verzování dle jazyků
				foreach ($languageList as $key => $val){

					$args = new ListArgs();

					$args->page_id = (int) $page_id;
					$args->lang = $val->code;
					$row = $model->getList($args);

				//	print_r($row);
        //exit;
					if (count($row) > 0) {
            $versionEntity = new ProductAttributesVersionEntity($row[0]->version_id);
					} else {
            $versionEntity = new ProductAttributesVersionEntity();
					}
          $versionEntity->lang_id = $val->id;
          $name = 'name_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionEntity->name = $postdata[$name];
					}
          
          $name = 'description_'.$val->code;
					if (array_key_exists($name, $postdata)) {
						$versionEntity->description = $postdata[$name];
					}

          $saveEntity->addSaveEntity($versionEntity);

				}

        if ($saveEntity->save()) {
        					return true;
				} else {
					$result = array();
					$result["status"] = "wrong";
					$json = json_encode($result);
					print_r($json);
					exit;
				}
        
        
        
       /* 


				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();

				$versionEntity = new ProductAttributesVersionEntity();

				$version = 0;
				$postdata = $form->getValues();

				// TODO ošetřit duplicitu !
				$data = array();
				//$data["keyword"] = $postdata["keyword"];

				$model = new models_ProductAttributes();

				$all_query_ok=true;
				$model->start_transakce();

				$model->insertRecords($model->getTablename(),$data);
				$model->commit ? null : $all_query_ok = false;

				if ($model->commit == false) {
					//	print "chyba";
				}
				$page_id = $model->insert_id;



				foreach ($languageList as $key => $val){
					$versionData = array();
					//$versionData["caszapsani"] = $caszapsani;
					$versionData["lang_id"] = $val->id;
					$versionData["mj_id"] = $page_id;
					//$versionData["user_id"] = USER_ID;
					//$versionData["version"] = $version;


					if (isset($postdata["name_$val->code"])) {
						$versionData["name"] = $postdata["name_$val->code"];
					}

					$model->insertRecords($versionEntity->getTablename(),$versionData);
					$model->commit ? null : $all_query_ok = false;
					if ($model->commit == false) {
						//	print "chyba";
					}

				}


				if ($model->konec_transakce($all_query_ok)) {
					$form->setResultSuccess('Záznam byl přidán.');
					return true;
				} else {
					$result = array();
					$result["status"] = "wrong";
					$json = json_encode($result);
					print_r($json);
					exit;
				}*/

			}
		}
	}

  
  public function attributeList()
	{
		$model = new models_Attributes();

		$limit 	= $this->getRequest->getQuery('limit', 100);
		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');
		$skupina = $this->getRequest->getQuery('grp', '');
		$category = $this->getRequest->getQuery('cat', '');

		$querys = array();
		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'t1.name');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'t1.description');
		$orderFromQuery = $this->orderFromQuery($querys, 't1.description ASC');

		$l = $model->getList(array(
						'limit' => $limit,
						'fulltext' => $search_string,
						'page' => $page,
						'order' => $orderFromQuery,
						'debug' => 0,
						));

		//$this->categoryTable();
		return $l;
	}
	public function saveAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_attrib', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('AttribEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formData = $form->getValues();
				//print_r($form->getValues());
				//print_r($form->getValues());

				$model = new models_Attributes();
				$changes = array();
				$changes["name"] = $formData["name"];
				$changes["description"] = $formData["description"];
				$id = $form->getPost('id', 0);

				if($model->updateRecords($model->getTableName(), $changes, "id={$id}"))
				{


				}

				$formValue = $this->formLoad('AttribValueEdit');
				$formValueData = $formValue->getValues();
				$attrValArray = $formValue->getPost('attrVal', array());
				$attrValIdArray = $formValue->getPost('attrValId', array());
			//	print_r($attrValArray);
				//exit;
				for($i=0;$i<count($attrValArray);$i++)
				{

					$attrVal = $attrValArray[$i];
					//print $attrVal;


					$changes = array();
					$changes["name"] = $attrVal;
					//	'attrValId[0]';
					//print $this->getRequest->getPost('attrValId[0]', 0);
					if (isset($attrValIdArray[$i])) {
						$idValue = $attrValIdArray[$i];


						if (empty($attrVal)) {
							if($model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES, "id={$idValue}"))
							{

							}
						} else {
							if($model->updateRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES, $changes, "id={$idValue}"))
							{

							}
						}


					} else {
						$inserted = array();
						$inserted["attribute_id"] = $id;
						$inserted["name"] = $attrVal;
						if($model->insertRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES, $inserted))
						{

						}
					}



				}
				$form->setResultSuccess("Vlastnost byla aktualizována.");
				$this->getRequest->goBackRef();
			}
		}

	}


	public function deleteAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteAttributes" == $this->getRequest->getPost('action', false))
		{

			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {


						if ($this->deleteItem($doklad_id)) {
							array_push($seznamCiselObjednavek,$doklad_id);
						}

						/*
						$model = new models_Products();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->cislo );
							}
						}*/
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Parametr " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}
			}

		}
	}


	private function deleteItem($product_id){
		$model = new models_Attributes();
		$row = $model->getRow($product_id);

		//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
		if ($row) {

			// Musím smazat i Value + asiciace

			//$_fotoPlaces->setData($data);
			$attrValues = $model->get_attributeValues($product_id);
			if (count($attrValues)>0) {

				for ($i=0;$i<count($attrValues);$i++)
				{
					if($model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC,"attribute_id=" . $attrValues[$i]->ID))
					{

					}
				}
				if($model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES,"attribute_id=" . $product_id))
				{

				}

			}

			if($model->delete($product_id))
			{
				return true;
			}
		}

		return false;
	}
	public function deleteActionOld()
	{





		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('del_product', false))
		{
			//print "mažu";
			//print
			/*
			   foreach($this->getRequest->getPost('del_product', false) as $key => $value)
			   {
			   list($key,$value);
			   }*/
			$tenzin = $this->getRequest->getPost('del_product', false);
			list($key,$value) = each($tenzin);
			//	print $key;
			$product_id = $_POST['product_id'][$key];
			//	print_r($this->getRequest->getPost('product_id[$key]', false));
			//	$product_id = $this->getRequest->getPost('product_id['.$key.']', false);
			if ($product_id) {

				$model = new models_Attributes();
				$row = $model->getRow($product_id);

				//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
				if ($row) {

					// Musím smazat i Value + asiciace

					//$_fotoPlaces->setData($data);
					$attrValues = $model->get_attributeValues($product_id);
					if (count($attrValues)>0) {

						for ($i=0;$i<count($attrValues);$i++)
						{
							if($model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC,"attribute_id=" . $attrValues[$i]->ID))
							{

							}
						}
						if($model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES,"attribute_id=" . $product_id))
						{

						}

					}

					if($model->delete($product_id))
					{
						//$_SESSION["statusmessage"]="Foto bylo úspěšně přidáno k produktu.";
						//$_SESSION["classmessage"]="success";
						$this->getRequest->clearPost();
					}
				}
			}

		}

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('attrValDel', false))
		{
			//	print "mažu";
			//print
			/*
			   foreach($this->getRequest->getPost('del_product', false) as $key => $value)
			   {
			   list($key,$value);
			   }*/
			$tenzin = $this->getRequest->getPost('attrValDel', false);
			list($key,$value) = each($tenzin);
			//	print $key;
			$attr_id = $_POST['attrValId'][$key];
			//	print_r($this->getRequest->getPost('product_id[$key]', false));
			//	$product_id = $this->getRequest->getPost('product_id['.$key.']', false);
			if ($attr_id) {

				$model = new models_Attributes();
				$row = $model->getRow("select * from " . T_SHOP_PRODUCT_ATTRIBUTE_VALUES. " where ID =" . $attr_id);

				//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
				if ($row) {
					//$_fotoPlaces->setData($data);

					if($model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUES,"id=".$attr_id))
					{
						//$_SESSION["statusmessage"]="Foto bylo úspěšně přidáno k produktu.";
						//$_SESSION["classmessage"]="success";
						$this->getRequest->clearPost();
					}
				}
			}

		}
	}

	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_attr', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('AttribCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$model = new models_Attributes();
				$formdata = $form->getValues();

				$attr_name = $formdata["name"];
				$attr_desc = $formdata["description"];
				if ($model->existAttribName($attr_name)) {
					$form->setResultError("Vlastnost s tímto názvem již existuje!");
					return false;
				}

				if ($model->insertAttr($attr_name, $attr_desc)) {
					$form->setResultSuccess("Vlastnost byla přidána.");
					$this->getRequest->goBackRef();
				}
			}
		}
	}

}
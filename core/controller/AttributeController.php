<?php

class AttributeTabs extends G_Tabs {

	public $form;
	public function __construct($pageForm)
	{
		$this->form = $pageForm;
		//parent::__construct($pageForm);
	}


	protected function MainTab()
	{

		$form = $this->form;

		$contentMain = '';
		$contentMain .= $form->getElement("name")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("description")->render() . '<p class="desc"></p><br />';

		if ($form->getElement("id")) {
			$contentMain .=$form->getElement("id")->render();
		}


		return $contentMain;
	}

	protected function ParametryTab()
	{
		$form = $this->form;
		$contentParametry = '';

		$formValue = new Application_Form_AttribValueEdit();
	$contentParametry .= '<fieldset>
		<legend><a href="javascript:show_element(\'product_spec\')">Hodnoty</a></legend>
		<div id="divTxt">';

		$pocet = $formValue->getValue("count");

		for($i=0; $i<$pocet;$i++)
		{
			$contentParametry .= $formValue->getElement("attrVal[$i]")->render();
			$contentParametry .= $formValue->getElement("attrValId[$i]")->render();
		}


	$contentParametry .= '</div>
	<p class="desc"></p>
	<br />
	<input type="hidden" name="counter" id="counter" value="' . $pocet . '" />
	<input type="button" name="add" value="Přidej" class="tlac" onclick="pridej_radek();">
	</fieldset>';


		return $contentParametry;

	}



	public function makeTabs($tabs = array()) {

		//	parent::makeTabs

		$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );

		$form = $this->form;
		if ($form->getElement("id")) {
			$tabs[] = array("name" => "Param", "title" => "Parametry","content" => $this->ParametryTab() );		}
		return parent::makeTabs($tabs);
	}

}

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class AttributeController extends G_Controller_Action
{
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
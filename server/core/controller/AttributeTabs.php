<?php
class AttributeTabs extends G_Tabs {

	public $form;
	public function __construct($pageForm)
	{
		$this->form = $pageForm;
    		$languageModel = new models_Language();
		$this->languageList = $languageModel->getActiveLanguage();
		//parent::__construct($pageForm);
	}


	protected function MainTab()
	{

		$form = $this->form;

		$contentMain = '';
    
   $languageList = $this->languageList; 
    
    		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-12">';
				$first = true;
		foreach ($languageList as $key => $val)
		{

			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentMain .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("name_$val->code")->render() . '</div>';
		}

		$contentMain .= '</div>';
		$contentMain .= '</div>';
    
    
    
        		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-12">';
				$first = true;
		foreach ($languageList as $key => $val)
		{

			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentMain .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("description_$val->code")->render() . '</div>';
		}

		$contentMain .= '</div>';
		$contentMain .= '</div>';
    

    
		$contentMain .= $form->getElement("pohoda_id")->render();
		$contentMain .= $form->getElement("multi_select")->render();
		$contentMain .= $form->getElement("secret")->render();
	//	$contentMain .= $form->getElement("description")->render() . '<p class="desc"></p><br />';

		if ($form->getElement("id")) {
			$contentMain .=$form->getElement("id")->render();
		}


		return $contentMain;
	}

	protected function ParametryTab()
	{
		$form = $this->form;
		$contentParametry = '';

		$formValue = new F_AttribValueEdit();
	$contentParametry .= '<fieldset>
		<legend><a href="javascript:show_element(\'product_spec\')">Hodnoty</a></legend>
		<div id="divTxt">';

		$pocet = $formValue->getValue("count");

		for($i=0; $i<$pocet;$i++)
		{
      $contentParametry .= '<div class="row">';
      $contentParametry .= '<div class="col-sm-9">';
			$contentParametry .= $formValue->getElement("attrVal[$i]")->render();
			$contentParametry .= $formValue->getElement("attrValId[$i]")->render();
      $contentParametry .= '</div>';
       $contentParametry .= '<div class="col-sm-3">';
			$contentParametry .= $formValue->getElement("attrCode[$i]")->render();
      	$contentParametry .= '</div>';
      	$contentParametry .= '</div>';
		}


	$contentParametry .= '</div>
	<p class="desc"></p>
	<br />
	<input type="hidden" name="counter" id="counter" value="' . $pocet . '" />
	<input type="button" name="add" value="Přidej" class="tlac" onclick="pridej_radek2();">
  
  
  <script>
  
  function pridej_radek2() {

var id = $("#counter").val() * 1;
$("#divTxt").append(\'<div class="row"><div class="col-sm-9"><input class="form-control" type="text" name="F_AttribValueEdit_attrVal[\' + id + \']"></div><div class="col-sm-3"><input class="form-control" type="text" name="F_AttribValueEdit_attrCode[\' + id + \']"></div></div>\');
id = $("#counter").val(id+1);

}

  </script>
  
  
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
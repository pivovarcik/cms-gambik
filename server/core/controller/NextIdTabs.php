<?php


class NextIdTabs extends G_Tabs {

	protected $form;
	protected $entityName;
	public function __construct($pageForm)
	{

		$this->form = $pageForm;
		$this->entityName = "NextId";
	}

	protected function MainTabs()
	{
		$form = $this->form;
		$contentMain ='';


		$contentMain .='<div class="form-group">';
		$contentMain .= $form->getElement("rada")->render();
		$contentMain .='<p class="help-block"></p>';
		$contentMain .='</div>';

                                                      	$contentMain .= $form->getElement("name")->render();
                                                        
		$contentMain .=$form->getElement("nazev")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("delka")->render();
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .=$form->getElement("tabulka")->render();
		$contentMain .='<p class="desc"></p><br />';
    
        		if ($form->getElement("action") !== false) {
			$contentMain .= $form->getElement("action")->render();
		}

		if ($form->getElement("id")) {

			$contentRoles .=$form->getElement("id")->render();
		}



		return $contentMain;

	}


	public function makeTabs($tabs = array()) {


		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));

		return parent::makeTabs($tabs);
	}

}
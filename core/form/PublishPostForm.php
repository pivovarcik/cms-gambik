<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("PageForm.php");
class PublishPostForm extends PageForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_Publish");
	//	$this->init();
	}
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;

		//	print_r($page);

		if (empty($page->publicDate)) {
			$datum_publikace = date("j.n.Y H:i:s");
		} else {
			$datum_publikace = date("j.n.Y H:i:s", strtotime($page->publicDate));
		}


		$name = "public_date";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum_publikace);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','datetimepicker');
		$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Publikovat od:');
		$this->addElement($elem);


		if (empty($page->publicDate_end)) {
			$datum_publikace = "";
		} else {
			$datum_publikace = date("j.n.Y H:i:s", strtotime($page->publicDate_end));
		}


		$name = "public_date_end";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum_publikace);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','datetimepicker');
		$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Do:');
		$this->addElement($elem);


		$name = "logo_url";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Url adresa loga:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

	}
}
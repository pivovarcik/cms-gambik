<?php
/**
 * Společný předek pro formuláře typu Page
 * */
class Application_Form_SmsCreate extends G_Form
{

	public $formName = "Nová sms zpráva";

	public $submitButtonName = "ins_sms";
	public $submitButtonTitle = "Odeslat";


	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");
		//$id = (int) $this->Request->getQuery("id",false);


		$userModel = new models_Users();
		$userList = $userModel->getList();

		$elem = new G_Form_Element_Select("phone");
		$elem->setAttribs(array("id"=>"phone","required"=>true));
		$value = $this->getPost("phone", $this->getPost("phone", ""));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','form-control');
		$pole = array();
		$pole[0] = " -- mobilní číslo -- ";
		$attrib = array();
		foreach ($userList as $key => $value)
		{

	//		print_r($value);
			//$value->id != USER_ID &&
			if (!empty($value->mobil)) {
			//	print_r($value);
				$pole[$value->mobil] = $value->mobil . " (" . $value->nick.")";
			}


			//if () {
			//$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
			//}
		}
		/*if (count($pole) == 2) {
			$elem->setAttribs('value',$userList[(count($userList)-1)]->id);
		}*/
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		// Perex
		$name = "message";
		$elem = new G_Form_Element_Textarea($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','form-control');
		$elem->setDecoration();
		$this->addElement($elem);


		$name = "action";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"send_sms");

		$this->addElement($elem);

		$name = "ins_sms";
		$elem = new G_Form_Element_Button($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		//$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value','Přidej');
		//$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);


	}
}
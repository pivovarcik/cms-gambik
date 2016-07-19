<?php
/**
 * Společný předek pro formuláře typu Page
 * */
class Application_Form_CommentsPublicCreate extends G_Form
{


	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{

		$translator = G_Translator::instance();
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		// Perex
		$name = "message";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','editbox');
		$elem->setAttribs('label',$translator->prelozitFrazy("komentar") . ':');
		$this->addElement($elem);

		$name = "nick";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label',$translator->prelozitFrazy("prezdivka") . ':');
		$this->addElement($elem);

		$name = "email";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"is_email" => true));
		$elem->setAttribs('class','textbox');
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("email") . ':');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("captcha");
		$value = "";
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("opiste_kod") . ':*');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs("required",true);
		$this->addElement($elem);


		$name = "but1";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs('id',$name);
		$value = $this->getPost($name, 0);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);


		$name = "but2";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs('id',$name);
		$value = $this->getPost($name, 1);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name = "send_message";
		$elem = new G_Form_Element_Submit($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		//$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$translator->prelozitFrazy("odeslat"));
		//$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);


	}
}
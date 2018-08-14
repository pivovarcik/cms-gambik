<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_AdminUserProfilEdit extends G_Form
{

  public $page = null;
	function __construct()
	{
		parent::__construct();
		$this->setStyle(BootstrapForm::getStyle());
		$this->init();
	}
	public function init()
	{
		$this->setAction($_SERVER["PHP_SELF"]);
	//	$this->setClass("standard_form");
		/*
		   $this->setStyle(array(
		   "label_wrap_start" => "<span>",
		   "label_wrap_end" => "</span>",
		   "text_wrap_start" => "<div class=\"textbox\">",
		   "text_wrap_end" => "</div>",
		   ));
		*/
		$model = new models_Users();
		$token = $this->Request->getSession("uidlogin2", "sdsfsf");
	//	$userDetail = $model->getUserByToken($token);
    $this->page = $model->getUserByToken($token);
    $userDetail = $this->page;

        		$name = "file";
		$elem = new G_Form_Element_File($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Nahrát foto');

		$this->addElement($elem);
    
    
		$name = "jmeno";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs("disabled","disabled");
		$elem->setAttribs("required",true);
		$elem->setAttribs('label','Vaše jméno:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs("autocomplete","off");
		$this->addElement($elem);

		$name = "mobil";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Mobil:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs("autocomplete","off");
		$this->addElement($elem);

		$name = "email";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Email:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs("required",true);
		$elem->setAttribs("autocomplete","off");
		$elem->setAttribs("is_email",true);
		$this->addElement($elem);

		$name = "newsletter";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label','Zasílání novinek:');
		$this->addElement($elem);


		$name = "prijmeni";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs("required",true);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Příjmení:');
		$this->addElement($elem);

		$name = "titul";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs("required",false);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Titul:');
		$this->addElement($elem);



		$elem = new G_Form_Element_Button("user_profil_edit");
		$elem->setAttribs('value','Uložit změny');
		$elem->setAttribs('class','btn btn-primary');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
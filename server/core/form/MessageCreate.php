<?php
/**
 * Společný předek pro formuláře typu Page
 * */
require_once("MessageForm.php");
class F_MessageCreate extends MessageForm
{

	public $formName = "Chat - Nová zpráva";

	public $submitButtonName = "ins_message";
	public $submitButtonTitle = "Odeslat";


	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{


		parent::init();
		$name = "ins_message";
		$elem = new G_Form_Element_Button($name);
		$elem->setAttribs('value','Odeslat');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$this->addElement($elem);


		$name = "action";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"ins_message");

		$this->addElement($elem);
		/*


		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");
		//$id = (int) $this->Request->getQuery("id",false);


		$page = new MessageEntity();
		$user = new models_User();

	//	$args = new ListArgs();

		$userList = $user->getList();

		$elem = new G_Form_Element_Select("adresat_id");
		$elem->setAttribs(array("id"=>"adresat_id","required"=>true));
		$value = $this->getPost("adresat_id", $this->Request->getQuery("adresat_id", ""));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','To:');
		$pole = array();
		$pole[0] = " -- adresát -- ";
		$attrib = array();
		foreach ($userList as $key => $value)
		{
			if ($value->id != USER_ID) {
				$pole[$value->id] = $value->nick;
			}


			//if () {
			//$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
			//}
		}
		if (count($pole) == 2) {
			$elem->setAttribs('value',$userList[(count($userList)-1)]->id);
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		// Perex
		$name = "message";
		$elem = new G_Form_Element_Textarea($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);

		$name = "ins_message";
		$elem = new G_Form_Element_Button($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		//$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value','Přidej');
		//$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);*/


	}
}
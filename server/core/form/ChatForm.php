<?php
/**
 * Společný předek pro formuláře typu Page
 * */
class F_ChatForm extends G_Form
{


	protected $page;
	protected $page_id;
	protected $pageModel;
	protected $adresat_id;
	protected $messageList = array();

	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct();
		$this->loadModel("models_Message");
		$this->init();
	}

	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}

	public function loadPage($user_id = null)
	{
		$this->adresat_id = $user_id;
    if ($user_id == null) {
			$this->page = new MessageEntity();
		} else {
      $args = new ListArgs();
      $args->chat_adresat_id = $user_id;
      $args->chat_autor_id = USER_ID;
      $args->orderBy = "m.TimeStamp DESC";
      
      $this->messageList = $this->pageModel->getList($args);
		//	$this->page = $this->pageModel->getDetailById($page_id);
			$this->page_id = $page_id;
		}
/*
		$user = new models_User();

		$userArgs = new ListArgs();
		$userArgs->orderBy = "t1.email ASC";
		$userArgs->limit = 10000;
		$this->userList = $user->getList($userArgs);
		*/

	}

	public function init()
	{
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");
		//$id = (int) $this->Request->getQuery("id",false);

/*
		$user = new UserController();
		$userList = $user->usersList(array(
						"parent"=>0,
						"debug"=>0,
						));

		$elem = new G_Form_Element_Select("adresat_id");
		$elem->setAttribs(array("id"=>"adresat_id","required"=>true));
		$value = $this->getPost("adresat_id", "");
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
*/

    $name = "adresat_id";
		$elem = new G_Form_Element_Hidden($name);
    $elem->setAttribs('value',$this->adresat_id);
    $this->addElement($elem);
    
    
		// Perex
		$name = "message";
		$elem = new G_Form_Element_Textarea($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:100%;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
	//	$elem->setAttribs('label','Zpráva:');
		$elem->setAttribs('class','editbox');
		$elem->setAttribs('placeholder','Sem napište krátkou zprávu');
		$this->addElement($elem);

		$name = "send_message";
		$elem = new G_Form_Element_Button($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		//$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value','Odeslat');

		//$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);

    $name = "action";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"ins_message");

		$this->addElement($elem);

	}
}
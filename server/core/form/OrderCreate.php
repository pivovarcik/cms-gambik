<?php
/**
 * Třída pro TVORBU OBJEDNÁVKY
 * */

// TODO vyhodit nahrazeno ObejdnavkaCreate
require_once("ObjednavkaForm.php");
class F_OrderCreate extends ObjednavkaForm
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$this->loadPage();
		$this->loadElements();

		$translator = $this->translator;
		$name = "save_order";
		$elem = new G_Form_Element_Submit($name);
		$elem->setAttribs('value',$translator->prelozitFrazy("send_order"));
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
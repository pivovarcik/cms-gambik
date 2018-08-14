<?php


class ProductAttributesBootstrapModalForm extends BootrapModalForm {
	public $form = null;
	public function __construct($formName)
	{

		$this->form = new $formName();


		parent::__construct("myModal",$this->form , "medium");
	}



	public function setBody($body = '')
	{
		$form = $this->form;

		$GTabs = new AttributeTabs($form);
		$body = $GTabs->makeTabs();


		$body .= $form->getElement("action")->render();
	/*	$body .= '<script>

	getMainFoto(' . $form->page->foto_id . ');
	loadCategoryPicker();
</script>';*/

		parent::setBody($body);

	}
}

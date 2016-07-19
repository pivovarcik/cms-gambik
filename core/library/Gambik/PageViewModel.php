<?php
require_once("BaseViewModel.php");
abstract class PageViewModel extends BaseViewModel{

	protected $form;
	public function __construct()
	{

		parent::__construct();
	}

	protected function load()
	{
		parent::load();

	}

	protected function header(){

		$res = '';
		$res .= '<div class="modal-header">';
		$res .= '<button title="Zavřít" aria-hidden="true" data-dismiss="modal" class="close-button" type="button"></button>';
		$res .= '<h3>' . $this->pagetitle . '</h3>';
		$res .= '</div>';

		return $res;
	}

	protected function footer(){
		$res = '';
		$res .= '<div class="modal-footer">';
		$res .= '<button title="Close" class="close-button button btn"><span>Zavřít</span></button>';


		$elements = $this->form->getElementByType("Button");
		foreach ($elements as $element) {
			$res .= $element->render();
		}

		$elements = $this->form->getElementByType("Submit");
		foreach ($elements as $element) {
			$res .= $element->render();
		}
		$res .= '</div>';

		return $res;
	}

	protected function body(){
		$res = '';
		$res .= '<div class="modal-body">';
		$res .= $this->body;
		$res .= '</div>';

		return $res;
	}
	public function viewRender()
	{
		$res = '';
		$res .= '<div class="page-view page-view-modal">';
		$res .= '<form name="' . get_class($this->form) . '" id="' . get_class($this->form) . '" class="page-form" method="post" action="/zadani?do=' . get_class($this->form) . '-submit">';
		$res .= parent::viewRender();
		$res .= '</form>';
		$res .= '</div>';
		return $res;
	}
}

?>
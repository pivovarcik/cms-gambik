<?php
require_once("ModalForm.php");
//require_once("ModalForm.php");
class BootrapModalForm extends ModalForm {

	protected $formTitle;
	protected $modalDialogSize = "small";

	protected $submitButtonTitle;

	protected $submitButtonName;

	protected $formBody;
	protected $langbox = "";

	protected $formResult;
	public $formSubmitted = true;
	public $closeDisabled = false;
	protected $formDetailLink;

	protected $elements = array();

/*	public function __construct($formId, $title, $submitButtonName, $submitButtonTitle)
	{
		parent::__construct($formId);
		$this->formTitle = $title;
		$this->submitButtonName = $submitButtonName;
		$this->submitButtonTitle = $submitButtonTitle;

	}
	*/

	public function __construct($formId, $form, $modalDialogSize = "small")
	{
		parent::__construct($formId);

		$this->modalDialogSize = $modalDialogSize;
		// nastavuji explicitně Bootsrtap vzhled
		$form->setStyle(BootstrapForm::getStyle());
		$this->formTitle = $form->formName;
		$this->submitButtonName = $form->submitButtonName;
		$this->submitButtonTitle = $form->submitButtonTitle;
		$this->formResult = $form->Result();

		if (isset($form->formBody) && !empty($form->formBody)) {
			$this->formBody = $form->formBody;
		}
		if (isset($form->detailLink) && !empty($form->detailLink)) {
			$this->formDetailLink = $form->detailLink;
		}

		if (isset($form->languageList) && is_array($form->languageList) && count($form->languageList) >1) {


			$res = '<div class="lang-box">';
				// Verzování dle jazyků
				$first = true;
				foreach ($form->languageList as $key => $val)
				{
					$selected = ' class="langLink"';
					if ($first) { $selected = ' class="lang_selected langLink"'; }

					$res .='<a' . $selected . ' id="lnkLang' . strtoupper($val->code) . '" href="javascript:show_lang(\'' . $val->code . '\');">' . strtoupper($val->code) . '</a>';
					$first = false;
				}
	$res .= '</div>';
			$this->langbox = $res;


		}


	}

	public function setModalDialogSize($modalDialogSize)
	{
		$this->modalDialogSize = $modalDialogSize;
	}


	protected function getModalDialogSize()
	{
		return " modal-dialog-".$this->modalDialogSize;
	}
	public function addElement(G_Form_Element $formElement){


		array_push($this->elements,$formElement);
	}

	public function setBody($body = "")
	{
		$this->formBody = $body;
	}

	public function render()
	{
  
    $closeDisabled ='';
    if ($this->closeDisabled)
    {
      $closeDisabled =' disabled="disabled"';
    
    }
		$res = '';

		$res .= '<div id="' . $this->formId . '" class="modal fade" data-backdrop="static" >';
		$res .= '<div class="modal-dialog' . $this->getModalDialogSize() . '">';
		$res .= '<div class="modal-content">';
		$res .= '<form id="' . $this->formId . '-form" data-async data-target="#rating-modal" action="'.$_SERVER["REQUEST_URI"].'"  method="POST">';
		$res .= '<div class="modal-header">';


		$res .= '<button' . $closeDisabled . ' type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		$res .= '<h4 class="modal-title">' . $this->formTitle;
		$res .=  $this->langbox . '</h4>';
		$res .= '</div>';
		$res .= '<div class="modal-body">';

		$res .= $this->formResult;



		foreach ($this->elements as $element) {
				$res .= $element->render();
		}

		$res .= $this->formBody;

		$res .= '</div>';
		$res .= '<div class="modal-footer">';

		if (!empty($this->formDetailLink)) {
			$res .= '<div class="pull-left"><a href="' . $this->formDetailLink . '" class="btn">Detail</a></div>';
		}

		$res .= '<button' . $closeDisabled . ' type="button" class="btn btn-default" data-dismiss="modal">Zrušit</button>';
    
   	if (($this->formSubmitted)) { 
		  $res .= '<button id="' . $this->formId . '-submit" type="submit" name="' . $this->submitButtonName . '" class="btn btn-primary">' . $this->submitButtonTitle . '</button>';
		}
    
    $res .= '</div>';
		$res .= '</form>';
		$res .= '</div>';
		$res .= '</div>';
		$res .= '</div>';
		$res .= $this->getScript();
		return $res;

	}

	public function getScript()
	{
		$res = '<script type="text/javascript">';
		/*
		//$res .= '$(document).ready(function(){';
		$res .= '$("#' . $this->formId . '-form").on( "submit",function(e){';
		$res .= 'e.preventDefault();';


		$res .= 'if (!blockForm' . $this->formId . '){';

		$res .= 'var url = $("#' . $this->formId . '-form").attr("action");';
		$res .= 'console.log(url);';
		$res .= 'var callbackFunction = $("#myModa-form").attr("callback");';
	//	$res .= 	'saveData(lastAction' . $this->formId . ',lastControl' . $this->formId . ')';
		$res .= 	'saveData(url, callbackFunction)';
		$res .= '}';
		$res .= '})';
	//	$res .= '});';
*/
		$res .= '</script>';
		return $res;
	}
}

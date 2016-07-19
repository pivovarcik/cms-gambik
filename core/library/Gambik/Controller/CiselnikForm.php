<?php


class FormCreator {

	protected $elements = array();
	protected $elements_name = array();

	public function __construct()
	{

	}

	protected function addElement(G_Form_Element $formElement)
	{


		array_push($this->elements,$formElement);
		array_push($this->elements,$formElement->getName());
	}

	public function render()
	{
		$result = '';
		foreach ($this->elements as $key => $element) {
			$result .= $element->render();
		}

		return $result;
	}


}

?>
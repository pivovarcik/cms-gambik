<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//	include "./Form/G_Form_Element.php";
//include PATH_ROOT.'library/Gambik/Form/G_Form_Element.php';
class GForm{
	protected $elementsFormRegister = array();
}
require_once("Form/G_Form_Element.php");
class G_Form
{
	private $form;
	private $form_action;
	private $form_elements;
	private $method_list;
	private $_formLabel;
	private $_formClass;
	private $_encType;
	public $elements = array();
	private $_validErorr;

	// je-li použit kontext
	private $kontext;

	private $style = array();
	//public $Request;
	public $eol;


	function __construct($kontext = false)
	{

		//$this->getRequest = new getRequest();
		$this->Request = new G_Html();

		$this->kontext = $kontext;
		// povolené methody
		$this->method_list = array("POST","GET");
		$this->eol = '
';
	}


	public function setKontext($kontext)
	{
		$this->kontext = $kontext;
	}
	/**
	 * Získaní post dat z kontextu formuláře
	 * */
	public function getPost($key = null, $default = null)
	{

		if (null != $key) {
			$key = get_class($this) . "_" . $key;
		}
	//	print $key;
		return $this->Request->getPost($key, $default);

	}
	/**
	 * Nastavení post dat v kontextu formuláře
	 * */
	public function setPost($key, $value)
	{
		if (null != $key) {
			$key = get_class($this) . "_" . $key;
		}

		$this->Request->setPost($key, $value);

	}

	public function getStyle($style = null)
	{
		if ($style == null) {
			return $this->style;
		}
		if (isset($this->style[$style])) {
			return $this->style[$style];
		}
		return "";
	}

	public function setStyle($arr = array())
	{
		$this->style = $arr;
	}
	public function getValues($suppressArrayNotation = false)
	{
		$values = array();
		//if (!$this->kontext) {

		//print_r($this->getElement());
			foreach ($this->getElement() as $key => $element) {
				if (is_object($element)) {
					if (!$element->getIgnore()) {
					//	print "tudy" . $element->getName();
						if (strpos($element->getName(), "[")) {

							$pole = explode("[",$element->getName());

							$key1 = $pole[0];

							if (count($pole) > 2 && $pole[2]) {
								// výce dimenzní pole!

							}

							//has_attribute_id[0][]

						//	print_r($pole);
							$index = str_replace("]","",$pole[1]);



							if (!empty($index)) {

								if (count($pole) > 2) {
									// výce dimenzní pole!
								//	 = $element->getValue();

								//	$values[$key1][$index] = $this->getPost($key1);
										/*
									print "vytvářím pole " . $key1 . " > " .  $element->getName() . " index: " . $index . " value: " . implode(":",$element->getValue()). "<br />";

								//	$this->Request->getPost($key1, $default);
									print_r($this->getPost($key1, $default));
									if (is_array($element->getValue())) {
										//array_push($values[$key1][$index], $element->getValue());
										$novyIndex = count($values[$key1])+1;
										foreach ($element->getValue() as $key2 =>$Val2 ) {
											array_push($values[$key1][$novyIndex], $Val2);
										}

									} else {
										array_push($values[$key1][$index], $element->getValue());
									}
									*/

								} else {
									$values[$key1][$index] = $element->getValue();
								}
								//print "indexované:" . $key1 . "<br />";

							} else {

								// Pokud Value prvku již obsahuje hodnoty pro celou kolekci, tak jí přepíšu
								if (is_array($element->getValue())) {
								//	$values[$key1] = $element->getValue();
									$values[$key1] = $this->getPost($key1);
								} else {
								//	print "neindexované:" . $key1 . " : " . $element->getValue() . "<br />";
									//	$values[$key1][] = $element->getValue();
									if (is_array($values[$key1])) {
										//$values[$key1][] = $element->getValue();
										$values[$key1] = $this->getPost($key1);
										//array_push($values[$key1], $element->getValue());
									} else {

										//print "vytvářím pole " . $element->getName() . "<br />";
										$values[$key1] = array();
										array_push($values[$key1], $element->getValue());
									}
								}



							}


						//	print_r($values[$key1]);
						} else {
							$values[$element->getName()] = $element->getValue();
						}

					}
				}

			}

		return $values;
	}
	public function getValue($name)
	{
		if ($element = $this->getElement($name)) {

			//print_r($element);
			//print "Elem:"; //.  $element->getClassName();
			if ($element->getClassName() == "G_Form_Element_Checkbox") {
				//print "Ano";
			}
			return $element->getValue();
		}

		return null;
	}
	public function render()
	{
		$this->view = new G_View();
		/*
		   //$View->render();
		   print '<pre>';
		   print_r($obj);
		   print '</pre>';
		*/

		$result = '<form' . $this->getLabel()
		                   . $this->getClass()
		                   . $this->getEnctype()
		                   . $this->getMethod()
		                   . $this->getAction() . '>' . $this->eol;

		$result .= '<dl>' . $this->eol;
		$elements = $this->getElement();
		for($i=0;$i<count($elements);$i++)
		{
			$result .= $this->view->render($elements[$i]) . $this->eol;
		}
		$result .= '</dl>' . $this->eol;
		$result .= '</form>' . $this->eol;
		print $result;
	}
	public function setEnctype($enctype='')
	{
		$this->_encType = $enctype;
		return true;
	}
	private function getEnctype()
	{
		$result = (empty($this->_encType))  ? ' enctype="' . $this->_encType . 'application/x-www-form-urlencoded"' :  ' enctype="' . $this->_encType . '"';
		return $result;
	}
	public function setLabel($label='')
	{
		$this->_formLabel = $label;
		return true;
	}
	private function getLabel()
	{
		$result = (empty($this->_formLabel))  ? "" :  ' name="' . $this->_formLabel . '"';
		return $result;
	}
	public function setClass($class='')
	{
		$this->_formClass = $class;
		return true;
	}
	private function getClass()
	{
		$result = (empty($this->_formClass))  ? "" :  ' class="' . $this->_formClass . '"';
		return $result;
	}
	public function setMethod($method='POST')
	{

		$method = strToUpper($method);
		if(in_array($method, $this->method_list))
		{
			$this->form_method = $method;
			return true;
		} else {
			return false;
		}
	}
	private function getMethod()
	{
		$result = (empty($this->form_method)) ? "POST" : "GET";
		$result = ' method="' . $result . '"';
		return $result;
	}
	public function setAction($action='')
	{
		$this->form_action = $action;
	}
	private function getAction()
	{
		$result = (empty($this->form_action)) ? "" :  ' action="' . $this->form_action . '"';
		return $result;
	}

	public function addElement2($elem)
	{
		//print_r($this->getStyle());
		$elem->setStyle($this->getStyle());
		/*
		if ($this->getElement($elem->name)) {
		//	$this->dropElement($elem->name);
			//$this->dropElement($elem->name);
			//print $elem->name . " již existuje!";
		}
		*/
		$this->dropElement($elem->name);
		array_push($this->elements, $elem);
	}
	public function addElements($array=array())
	{
	//	$this->elements = array();
		foreach ($array as $key => $element) {
		//	print_r($element);
		//	print_r($key);
//			print $element->getName() . ":" . $element->getValue()."<br />";
			$this->addElement($element);
		}
		//$this->elements = $array;
	}

	public function addElement($elem)
	{

		//print get_class($this);

		//get_class($this);
		if (strtolower(get_class($elem)) != strtolower("G_Form_Element_Button") && strtolower(get_class($elem)) != strtolower("G_Form_Element_Submit")&& strtolower(get_class($elem)) != strtolower("G_Form_Element_Hidden")) {

			$elem->setStyle($this->getStyle());
		}

		$elem->setFormName(get_class($this));

		// možnost anonymního použití prvků na formuláři / původní chování
		if ($this->kontext) {
			$elem->setAnonymous();
		}

		for($i=0; $i<=count($this->elements);$i++)
		{
/*
			if (strpos($elem->name,"[]") ) {
				return array_push($this->elements, $elem);
			}*/
		//		print "hledám>" . $this->elements[$i]->name . "==" .$elem->name ." <br />";
			//strpos($key,"[]");
			//strpos($cat->serial_cat_id . "|", "|4|" ))

			if (isset($this->elements[$i]->name) && $this->elements[$i]->name==$elem->name )
			{
			//	print "shoda:" . $this->elements[$i]->name . "<br />";
				//print_r($this->elements[$i]);

				if (strpos($elem->name,"[]")) {

					// neprepesiju hodnotu, ale přidej
					return	array_push($this->elements, $elem);

					//return $this->elements[$i] = $elem;
				}
				return $this->elements[$i] = $elem;

			}
		}
		array_push($this->elements, $elem);

	}

	public function getElementByType($type = null)
	{

		$elements = array();

		for($i=0; $i<count($this->elements);$i++)
		{

			if (strtolower(get_class($this->elements[$i])) == strtolower("G_Form_Element_" . $type)) {
				array_push($elements,$this->elements[$i]);
				//print_r(get_class($this->elements[$i]));
			}


			//	print "tudy";
		}




		return $elements;

	}

	public function getElement($key = null)
	{

	//	print $key . "<br />";
		//print_r($this->elements);
		$result = false;
		if (!is_array($this->elements)) {
			return false;
		}
		if (null === $key) {
			return (is_array($this->elements)) ? $this->elements : array();
		}
		for($i=0; $i<count($this->elements);$i++)
		{


		//	print "tudy";
			if (strpos($key,"[]")) {
				//print $this->elements[$i]->name . "!<br />";
				$keyLen = strLen(str_replace("[]","",$key));

				if (strPos($this->elements[$i]->name, "]")) {
				//	print "(".strPos($this->elements[$i]->name, "]") . ")";
				}
				if (isset($this->elements[$i]->name) && substr($this->elements[$i]->name,0,$keyLen+1). ""===substr($key,0,strlen($key)-1))
				{
				//	print substr($this->elements[$i]->name,0,$keyLen). "[]"."==".$key."<br />";
					//return $this->elements[$i];
					$result[] =$this->elements[$i];
				}
			} else{
				if (isset($this->elements[$i]->name) && $this->elements[$i]->name==$key)
				{
					//print_r($this->elements[$i]);

					$elem = $this->elements[$i];




					if (get_class($elem) !="G_Form_Element_Submit" && get_parent_class($elem) !="G_Form_Element_Submit" && get_class($elem) !="G_Form_Element_Button" && get_parent_class($elem) !="G_Form_Element_Button" ) {
						$elem->setStyle($this->getStyle());
					}

					return  $elem;
					return $this->elements[$i];

				}
			}



		}
		return $result;

	}
/*
	public function getElement($key = null)
	{
		if (!is_array($this->elements)) {
			return false;
		}
		if (null === $key) {
			return (is_array($this->elements)) ? $this->elements : array();
		}
		for($i=0; $i<count($this->elements);$i++)
		{

			//	print $this->elements[$i]->name . "<br />";
			if (isset($this->elements[$i]->name) && $this->elements[$i]->name==$key)
			{
				//print_r($this->elements[$i]);
				return $this->elements[$i];

			}
		}
		return false;

	}
   */
	public function dropElement($key = null)
	{
		if (!is_array($this->elements)) {
			return false;
		}
		if (null === $key) {
			return;
		}
		for($i=0; $i<count($this->elements);$i++)
		{
			if (isset($this->elements[$i]->name) && $this->elements[$i]->name==$key)
			{
				//print_r($this->elements[$i]);
				 unset($this->elements[$i]);
				return;
				//return $this->elements[$i];

			}
		}
		return false;

	}

	public function getAttrib($Obj)
	{
	}


	/*
	   * Hodnota odeslaná přes POST
	   * vrací hodnotu z postu, jinak false
	*/
	public function getValuePosted($name)
	{
		if (array_key_exists($name, $_POST))
		{
			$value = trim($_POST[$name]);
			return $value;
		}
		return false;
	}

	public function isValid($postdata)
	{


		/*
		   print "<pre>";
		   print_r($postdata);
		   print "</pre>";
		*/
		$status = true;
		$elements = $this->getElement();
		for($i=0;$i<count($elements);$i++)
		{

			$element = $elements[$i];

			if (!$element) {
				break;
			}

			// hodně zastaralé
			$value = trim($_POST[$element->getName()]);


			$value = $this->getPost($element->getName(),$element->getValue());

			if ($element->getClassName() == "G_Form_Element_Checkbox") {
				//print $element->getName() . ":" . $element->getValue() . ":" . $_POST[$element->getName()];
			}
			$element->setValue($value);
			$element->Attributes["value"] = $value;
			/*
			   print "<pre>";
			   print_r($Obj);
			   print "</pre>";

			*/
			// $value = $Obj->Attributes["value"];



			if ($element->isMoney() && !empty($value))
			{

				$value = strToNumeric($value);

				if (isNumeric($value)) {
					$element->Attributes["value"] = $value;
				}else {
					$this->addError($element->getName(), "Pole: ". $element->label . " není zadána částka!");
					$status = ($status) ? false : $status;
				}
			}
			if ($element->isNumeric())
			{
				$value = strToNumeric($value);

				// numerická hodnota může být prázdná
				if ($element->isEmpty() || isNumeric($value)) {
					$element->Attributes["value"] = $value;
				}else {
					$this->addError($element->getName(), "Pole: ". $element->label . " není zadané číslo!");
					//require_once 'G_Exception.php';
					//throw new G_Exception($Obj->Attributes["name"] . ': je povinná položka!');

					$status = ($status) ? false : $status;
				}

			}

			// Povinné pole
			if ($element->isRequired() && $element->isEmpty())
			{
				$this->addError($element->getName(), "Pole: ". $element->getName() . " je povinná položka!");

				$status = ($status) ? false : $status;
			}

			if ($element->isEmail() && !$element->isEmpty())
			{
				$value = strtolower($value);
				$element->setValue($value);
				$element->Attributes["value"] = $value;

				if ( isEmail($value) == false) {
					$this->addError($element->getName(), "Pole: ". $element->label . " chybně vyplněn email!");
					$status = ($status) ? false : $status;
				}
			}



			if (isset($element->Attributes["valid"]) && $element->Attributes["valid"] == "num" && !is_numeric($value))
			{
				// value is empty!
				print $element->getName() . ": musí obsahovat číselnou hodnotu!<br />";

				$status = ($status) ? false : $status;
			}
		}

		if (!$status) {
			$this->zpracujChyby();
			$translator = G_Translator::instance();
			//"Nebyla vyplněna všechna povinná pole!"
			$this->setResultError($translator->prelozitFrazy("nebyla_vyplnena_povinna_pole"));

		}
		return $status;
	}
	public function addError($key, $value)
	{
		$this->_validErorr[get_class($this) . "_" . $key] = $value;
		$this->zpracujChyby();
		$this->setResultError($value);
	}
	public function getError()
	{
		return $this->_validErorr;
	}

	public function zpracujChyby()
	{
		$_SESSION["err_elem"][get_class($this)] = array();

		$chybyA = array();
		foreach($this->getError() as $key => $value)
		{
		//	$_SESSION["err_elem"][get_class($this)][$key] = $value;
			//array_push($_SESSION["err_elem"][get_class($this)], $key);
			$chybyA[$key] = $value;
	//		array_push($chybyA, $key);
	//		print $key . "<br />";

		}

		$_SESSION["err_elem"][get_class($this)] = $chybyA;
	//	$_SESSION["errors"][get_class($this)] = "Nebyla vyplněna všechna povinná pole!";

		/*
		print "==========";


		print_r($chybyA);
		print "==========";
		print_r($_SESSION["err_elem"]);
		*/
	}
	public function setResultError($message)
	{
		$_SESSION["errors"][get_class($this)] = $message;
	}

	public function setResultSuccess($alert)
	{
		return $_SESSION["success"][get_class($this)] = $alert;
	}
	public function Result()
	{
		/*
		if(empty($_SESSION["statusmessage"]))
		{
			return;
		}
		*/
		$alert	= "";

		$print = false;
		if (isset($_SESSION["success"][get_class($this)])) {
			$class = ' class="success"';
			$class = "success";
			$print = true;
			$alert = $_SESSION["success"][get_class($this)];
		}
		if (isset($_SESSION["errors"][get_class($this)])) {
			$class = ' class="errors"';
			$class = "danger";
			$alert = $_SESSION["errors"][get_class($this)];
			$print = true;
		}

		if ($print == false) {
			return;
		}
		/*
		if(isset($_SESSION["classmessage"]))
		{
			$class = ' class="' . $_SESSION["classmessage"] . '"';
		}
*/

		$print = AlertHelper::alert($alert,$class);
	//	$print = '<p' . $class . '>' . $alert . '</p>';

		unset($_SESSION["errors"][get_class($this)]);
		unset($_SESSION["success"][get_class($this)]);

	//	$_SESSION["statusmessage"]="";
	//	$_SESSION["classmessage"]="";
		return $print;
	}
	public function getValidError()
	{

		$_SESSION["err_elem"][get_class($this)] = array();

		$chybyA = array();
		foreach($this->getError() as $key => $value)
		{
			//$_SESSION["err_elem"][$key] = $value;
			$chybyA[$key] = $value;
		}

		$_SESSION["err_elem"][get_class($this)] = $chybyA;

		//print_r($form->getError());
	//	$_SESSION["statusmessage"]= "Nebyla vyplněna všechna povinná pole!";
	//	$_SESSION["classmessage"]="errors";

		return $_SESSION["err_elem"];
	}
}
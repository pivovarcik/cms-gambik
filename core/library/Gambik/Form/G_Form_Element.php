<?php
require_once("IFormElement.php");

class BootstrapForm {

	static function getStyle()
	{
		return $bootstrapElementStyle = array(
					"element_wrap_start" => '<div class="form-group">',
					"element_wrap_end"=>'</div>',
					"label_class"=>'control-label',
					"element_class"=>'form-control',
					"dt_decorator"=>"",
					"dd_decorator"=>"",
					"dl_decorator"=>"",
					);
	}
}

class G_Form_Element implements IFormElement
{
	public $Attributes = array();
	public $label = "";
	public $value = "";
	public $name = "";
	public $kontext = ""; // formulářový kontext
	private $required = false;
	private $checked = false;
	private $_ignore;
	private $formName;
	public $style = array();
	private $firstLabel = true;
	protected $anonymous;
	/**
	 * $tags = název prvku
	 * $anonymous = starý způsob, anonymní předávání dat bez formuláře
	 * */
	function __construct($tags, $anonymous = false, $value = null)
	{

		if (!is_null($value)) {
			$this->setValue($value);
		}

		$this->anonymous = $anonymous;
		$this->label = "";

		$this->setName($tags);

		//$this->name = $tags;

		$this->Request = new G_Html();


		$this->attrib_list = array(
		                      "name",
		                      "class",
		                      "id",
		                      "style",
		                      "date_format",
		                      "required",
		                      "value",
		                      "value_default",
		                          );
		$this->_ignore = false;
		//	$this->setAttribs(array("name" => $tags));
		$this->setAttribs(array("required" => false));
		$this->setAttribs(array("value" => $this->Request->getPost($tags)));
		$this->attrib_list = array(
								"class",
								"id",
								"style",
								"size",
								"value",
								"tabindex",
								"onchange",
								"onclick",
								"onkeyup",
								"date_format",
								"required",
								"label",
								"name",
								"is_money",
								"is_numeric",
								"is_int",
								"is_email",
								"value_default",
								"valid",
								"rows",
								"cols",
								"checked",
								"readonly",
								"enabled",
								"disabled",
								"autocomplete",
								"maxlength",
								"onblur",
								"dl_decorator",
								"dt_decorator",
								"dd_decorator",
								"placeholder",
								"title",
								"data-theme",
										"data-role",
										"context",
										"data-origin-value","autofocus"
								                          );

		/*
		   $this->style = array(
		   "element_wrap_start" => '<div class="form-group">',
		   "element_wrap_end"=>'</div>',
		   "label_class"=>'control-label',
		   "element_class"=>'form-control'
		   );*/

	}


	public function placeholder($value = false)
	{
		if (!$value) {
			return $this->Attributes["placeholder"];
		}
		$this->Attributes["placeholder"] = $value;
	}

	public function autofocus($value = true)
	{
		if (!$value) {
			unset($this->Attributes["autofocus"]);
			return;
		}
		$this->Attributes["autofocus"] = "autofocus";
	}

	public function firstLabel() {
		return $this->firstLabel;
	}
	public function setDecoration()
	{
		$this->Attributes["dd_decorator"] = "";
		$this->Attributes["dt_decorator"] = "";
		$this->Attributes["dl_decorator"] = "";
		/*	unset($this->setAttribs["dd_decorator"]);
		   unset($this->setAttribs["dt_decorator"]);
		   unset($this->setAttribs["dl_decorator"]);*/

		/*
		   $this->setAttribs(array("dd_decorator" => "dd",
		   "dt_decorator" => "dt",
		   "dl_decorator" => "dl",
		   "placeholder" => "",
		   ));*/
	}
	public function getName()
	{
		return $this->name;
	}
	public function getFormName()
	{
		return $this->formName;
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

		if (isset($arr["dd_decorator"])) {
			$this->Attributes["dd_decorator"] = $arr["dd_decorator"];
		}

		if (isset($arr["dt_decorator"])) {
			$this->Attributes["dt_decorator"] = $arr["dt_decorator"];
		}

		if (isset($arr["dl_decorator"])) {
			$this->Attributes["dl_decorator"] = $arr["dl_decorator"];
		}
		//print_r($arr);
		$this->style = $arr;
	}
	public function setFormName($name)
	{
		//print_r($arr);
		$this->formName = $name;
	}

	// nastaví prvek na anonymní předávání hodnoty
	public function setAnonymous()
	{
		//print_r($arr);
		$this->anonymous = true;
	}

	public function setFirstLabel($first = true)
	{
		//print_r($arr);
		$this->firstLabel = $first;
	}
	public function render()
	{
		$this->view = new G_View($this->anonymous);
		return $this->view->render($this);
	}

	public function getLabel()
	{
		return $this->label;
	}

	public function setLabel($input)
	{
		$this->label = $input;
	}
	public function setRequired($input)
	{
		$this->required = $input;
	}
	public function setValue($input)
	{
		$this->value = $input;
	}
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getClassName()
	{
		return get_class($this);
	}

	public function isEmpty()
	{
		$value = trim($this->getValue());
		//print $this->getClassName();
		if ($this->getClassName() == "G_Form_Element_Checkbox" && $value == "0")
		{
			//nezaškrtnuto
			return true;
		}
		if ($this->getClassName() == "G_Form_Element_Select" && ($value == "0" || $value == ""))
		{
			//nevybráno
			return true;
		}
		if (empty( $value )) {
			return true;
		}
		return false;
	}

	public function isRequired()
	{
		return $this->required;
	}

	// Je zaškrtnuto
	public function isChecked()
	{
		return $this->checked;
	}
	// Zaškrtnout
	public function checked()
	{
		$this->checked = true;
		$this->Attributes["checked"] = "checked";
	}
	// Odškrtnout
	public function unChecked()
	{
		$this->checked = false;
		$this->Attributes["checked"] = "";
	}
	public function setChecked($input)
	{
		$this->checked = $input;

		if ($this->checked) {
			$this->Attributes["checked"] = "checked";
		} else {
			$this->Attributes["checked"] = "";
		}
	}


	public function isNumeric()
	{
		if (isset($this->Attributes["is_numeric"]) && $this->Attributes["is_numeric"] == true) {
			return true;
		}
		return false;
	}

	public function setNumeric()
	{
		$this->Attributes["is_numeric"] = true;
	}

	public function isEmail()
	{
		if (isset($this->Attributes["is_email"]) && $this->Attributes["is_email"] == true) {
			return true;
		}
		return false;
	}

	public function setEmail()
	{
		$this->Attributes["is_email"] = true;
	}

	public function setMoney()
	{
		$this->Attributes["is_money"] = true;
	}

	public function isMoney()
	{
		if (isset($this->Attributes["is_money"]) && $this->Attributes["is_money"] == true) {
			return true;
		}
		return false;
	}
	public function getIgnore()
	{
		return $this->_ignore;
	}

	public function setIgnore($value)
	{
		$this->_ignore = $value;
	}
	public function getValueOld()
	{
		//print "tudy".$this->getName();
		// Pro checkbox platí jiný režim
		if ($this->getClassName() == "G_Form_Element_Checkbox" && $this->Request->isPost()) {

			$key =  $this->getName();
			if (!$this->anonymous) {
				$formName = $this->getFormName();
				if (!empty($formName)) {
					$key = $formName . "_" . $this->getName();
				} else {
					$key = $this->getName();
				}

			}
			if ($this->Request->getPost($key, false) === false) {
				return 0;
			}
		}
		// Je-li checkbox - rozhoduje jeli zaškrtnuto
		if ($this->getClassName() == "G_Form_Element_Checkbox") {

			//print "check:".$this->value;
			if (!empty($this->value)) {
				return 1;
			} else {
				return 0;
			}
			/*
			   if ($this->isChecked()) {
			   return 1;
			   } else {
			   return 0;
			   }
			*/
		}
		return $this->value;
	}


	public function getValue()
	{
		//print "tudy".$this->getName();
		// Pro checkbox platí jiný režim
		if ($this->Request->isPost()) {

			if ($this->getClassName() == "G_Form_Element_Checkbox") {

				$key =  $this->getName();
				if (!$this->anonymous) {
					$formName = $this->getFormName();
					if (!empty($formName)) {
						$key = $formName . "_" . $this->getName();
					} else {
						$key = $this->getName();
					}

				}
				if ($this->Request->getPost($key, false) === false) {
					return 0;
				}
			} else {
				$key =  $this->getName();
				if (!$this->anonymous) {
					$formName = $this->getFormName();
					if (!empty($formName)) {
						$key = $formName . "_" . $this->getName();
					} else {
						$key = $this->getName();
					}
				} else {
					$key = $this->getName();
				}

				if ($value = $this->Request->getPost($key, false)) {
					return $value;
				}
			}



		}
		// Je-li checkbox - rozhoduje jeli zaškrtnuto
		if ($this->getClassName() == "G_Form_Element_Checkbox") {

			//print "check:".$this->value;
			if (!empty($this->value)) {
				return $this->value; // 1;
			} else {
				return 0;
			}
			/*
			   if ($this->isChecked()) {
			   return 1;
			   } else {
			   return 0;
			   }
			*/
		}
		return $this->value;
	}
	// Nastavení jednoho atributu
	public function setAttrib($attribute, $value="")
	{
		// ověřím, že atribut je v seznamu
		$attribute = strToLower(trim($attribute));
		//print $attribute . "<br />";
		if(in_array($attribute, $this->attrib_list))
		{
			$this->Attributes[$attribute] = $value;

			if ($attribute == "class") {
				// znovu načtu všechny třídy
				$classA = explode(" ", trim($this->Attributes[$attribute]));
				$classA2 = array();
				foreach ($classA as $key => $className) {
					$classA2[$className] = $className;
				}
				$this->Attributes[$attribute] = implode(" ", $classA2);
			}

			switch($attribute)
			{
				case "value":
					$this->setValue($value);
					break;
				case "label":
					$this->setLabel($value);
					break;
				case "required":
					$this->setRequired($value);
					break;
				case "checked":
					$this->setChecked($value);
					break;
			}
		}
		if ($this->getName() == "title_cs") {
			//	print "----pole:" . $this->getName() . ">" . ($attribute) . "=" . ($value) . "<br />";
			//	print  $attribute . ">" . gettype($value) . "<br />";

		}
	}
	public function setAttribs($attributes, $value="")
	{



		//print_r($attributes);
		if (is_array($attributes) && count($attributes) >0)
		{
			//print "pole:" . $this->getName() . ">" . $input["required"] . "<br />";
			foreach ($attributes as $key =>$val)
			{
				//print $key."=>".$val."<br />";
				$this->setAttrib($key, $val);
			}
		} else
		{
			$this->setAttrib($attributes, $value);
		}
	}
	// Returns all attributes
	public function getAttrib($attr = null)
	{
		// každý elemt potřebuje ID
		//!in_array("id", $this->Attributes)

		if (!is_null($attr)) {
			return $this->Attributes[$attr];
		}
		if (!isset($this->Attributes["id"]) || empty($this->Attributes["id"])) {
			$this->Attributes["id"] = $this->getName() . "_" . rand();
		}
		//	print_r($this->Attributes);
		return $this->Attributes;
	}



}



require_once("G_Form_Element_Text.php");
require_once("G_Form_Element_Hidden.php");
require_once("G_Form_Element_Submit.php");
require_once("G_Form_Element_Select.php");
require_once("G_Form_Element_Textarea.php");
require_once("G_Form_Element_Password.php");
require_once("G_Form_Element_Checkbox.php");
require_once("G_Form_Element_Datetime.php");
require_once("G_Form_Element_File.php");
require_once("G_Form_Element_Radio.php");
require_once("G_Form_Element_Button.php");

require_once("G_Form_Element_Email.php");
require_once("G_Form_Element_Number.php");
require_once("G_Form_Element_Color.php");
require_once("G_Form_Element_Picker.php");
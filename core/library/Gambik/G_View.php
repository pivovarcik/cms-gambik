<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_View
{

	private $_tagStart;
	private $_tagCenter;
	private $_tagEnd;
	public $eol;
	public $element;
	public $class_name;

	private $render_attrib = array();
	protected $anonymous;

	function __construct($anonymous = false)
	{
		$this->anonymous = $anonymous;
		$this->eol = '
';

	}



	private function _getMultiOptionsSelect($Obj)
	{
		$result = '';
		if (!isset($Obj->multiOptions))
		{
			return '';
		}
		$input = $Obj->multiOptions;
		$attribs = $Obj->multiAttribs;

		if (is_array($input))
		{
			foreach ($input as $key =>$value)
			{

				$attrib_string = '';
				if (isset($attribs[$key]) && is_array($attribs[$key])) {
					//PRINT_R($attribs[$key]);
					foreach ($attribs[$key] as $keya => $valuea)
					{
						$attrib_string .= ' ' . $keya . '="'.$valuea.'"';
					}
				}
				if (is_array($value))
				{

					$result .= '<option'.$attrib_string.' value="' . $value[0] . '">' . $value[1]  . '</option>' . $this->eol;

				} else {
					if ($key == "value" && $this->class_name =="G_Form_Element_Textarea" )
					{
					} else
					{
						$selected = '';
						if (isset($Obj->Attributes["value"]) && $Obj->Attributes["value"] == $key) {
							$selected = ' selected="selected"';
						}
						$result .= '<option'.$attrib_string.'' . $selected . ' value="' . $key . '">' . $value . '</option>' . $this->eol;
					}

				}


			}
		}
		return $result;

	}
	private function _getMultiOptionsRadio($Obj)
	{
		$result = '';
		if (!isset($Obj->multiOptions))
		{
			return '';
		}
		$input = $Obj->multiOptions;
		$attribs = $Obj->Attributes; //$Obj->multiAttribs;


		//		"class",
		$povoleneAtributy = array(
		"id",
		"style",

		"size",
		"disabled",
		"readonly",
		"enabled",
		"onclick",
		"onchange",
		"tabindex",
		"autocomplete",
		"onblur",
	);



		$name = $Obj->getName();
		if ($this->anonymous === false) {
			$formName = $Obj->getFormName();
			if (!empty($formName)) {
				//$key = $formName . "_" . $this->getName();
				$name =  $Obj->getFormName() . "_" . $Obj->getName();
			} else {
				//$key = $this->getName();
				$name =  $Obj->getName();
			}

		}


		//	print_r($attribs);
		if (is_array($input))
		{
			foreach ($input as $key =>$value)
			{


				//	print $key;
				$attrib_string = '';
				/*
				   if (isset($attribs[$key]) && is_array($attribs[$key])) {
				   //PRINT_R($attribs[$key]);
				   foreach ($attribs[$key] as $keya => $valuea)
				   {
				   $attrib_string .= ' ' . $keya . '="'.$valuea.'"';
				   }
				   }
				*/
				foreach ($attribs as $keya => $valuea)
				{
					//print $keya;
					//	if ($povoleneAtributy[$keya]) {
					if (in_array($keya,$povoleneAtributy)) {
						$attrib_string .= ' ' . $keya . '="'.$valuea.'"';
					}

				}

				//	print $attrib_string;
				/*
				   $class = '';
				   if (isset($attribs["class"]) && !empty($attribs["class"])) {
				   $class = ' class="' . $attribs["class"] . '"';
				   }
				*/
				if (is_array($value))
				{



					$result .= '<input'.$attrib_string.' type="radio" name="' . $name . ' value="' . $value[0] . '"/>' . $this->eol;

				} else {

					$selected = '';
					if (isset($Obj->Attributes["value"]) && $Obj->Attributes["value"] == $key) {
						$selected = ' checked="checked"';
					}

					$result .= '<div class="radio">';
					$result .= '<label for="' . $name . '' . $key . '">';
					//$result .= '<input id="' . $Obj->getName() . '' . $key . '" name="' . $Obj->getName() . '"'.$attrib_string.' type="radio"' . $selected . ' value="' . $key . '"/><label for="' . $Obj->getName() . '' . $key . '">' . $value . '</label>' . $this->eol;
					$result .= '<input id="' . $name . '' . $key . '" name="' . $name . '"'.$attrib_string.' type="radio"' . $selected . ' value="' . $key . '"/>' . $value . '' . $this->eol;
					$result .= '</label>';
					$result .= '</div>';

				}


			}
		}
		return $result;

	}
	private function _getMultiOptions($Obj)
	{

		if ($this->class_name =="G_Form_Element_Textarea" || $this->class_name =="G_Form_Element_Select") {
			return $this->_getMultiOptionsSelect($Obj);
		}
		if ($this->class_name =="G_Form_Element_Radio") {
			return $this->_getMultiOptionsRadio($Obj);
		}
		return '';
	}

	// generuje atributy
	private function _getAttrib($Obj)
	{

		$name = $Obj->getName();
		if ($this->anonymous === false) {
			$formName = $Obj->getFormName();
			if (!empty($formName)) {
				//$key = $formName . "_" . $this->getName();
				$name =  $Obj->getFormName() . "_" . $Obj->getName();
			} else {
				//$key = $this->getName();
				$name =  $Obj->getName();
			}

		}

		// Kvůli velké pracnosti na předělání odchytávaných událostí v Action, se Prvky typu Button a Submit budou definovat bez kontextu formuláře
		if ($this->class_name =="G_Form_Element_Submit" || $this->class_name =="G_Form_Element_Button") {
			$name = $Obj->getName();
		}


		$atributy = $Obj->getAttrib();
		$result = '';

		if (isset($_SESSION["err_elem"][$Obj->getFormName()][$name])) {

		//	print $name;
			if (isset($atributy["class"])) {

				$Obj->setAttrib("class",$atributy["class"] . " err");
			} else {
				$Obj->setAttrib("class","err");
			}
			unset($_SESSION["err_elem"][$Obj->getFormName()][$name]);
		}

		if ($this->class_name !="G_Form_Element_Checkbox") {
			$Obj->setAttrib("class",$Obj->getAttrib("class")." " .$Obj->getStyle("element_class"));
		}

		// musím nově načíst aktualizované atributy
		$input = $Obj->getAttrib();
		if (is_array($input))
		{
			foreach ($input as $key =>$value)
			{



				if ($key == "value" && ($this->class_name =="G_Form_Element_Textarea" || $this->class_name =="G_Form_Element_Select") )
				{
				} elseif($key == "value" && $this->class_name =="G_Form_Element_Checkbox2" ){
					//print_r($input);
				} else
				{

					if (isset($input["is_money"]) && $key == "value" && $input["is_money"] == true )
					{

						$value = numberFormat($value);
						//number_format(2500000.44, 2, ',', ' ');

					}
					if (isset($input["is_numeric"]) && $key == "value" && $input["is_numeric"] == true )
					{

						$value = numberFormat($value);
						//number_format(2500000.44, 2, ',', ' ');

					}

					if (isset($input["is_int"]) && $key == "value" && $input["is_int"] == true )
					{

						$value = numberFormat($value,0);
						//number_format(2500000.44, 2, ',', ' ');

					}
					$value = textFix($value);

					//	print_r($this->render_attrib);
					// generuj jen atributy s hodnotami
					if (in_array($key, $this->render_attrib) && !empty($value)) {
						$result .= ' ' . $key . '="' . $value . '"';
					}

				}

			}
		}



		$result .= ' name="' . $name . '"';
		return $result;
	}
	public function render($Obj)
	{
		$result ='';
		if (!is_object($Obj))
		{
			return false;
		}

		$povolene_typy = array("G_Form_Element_Text","G_Form_Element_Number", "G_Form_Element_Color", "G_Form_Element_Image", "G_Form_Element_File", "G_Form_Element_Datetime",
		"G_Form_Element_Password","G_Form_Element_Radio","G_Form_Element_Checkbox","G_Form_Element_Hidden","G_Form_Element_Submit",
		"G_Form_Element_Button","G_Form_Element_Select","G_Form_Element_Textarea", "G_Form_Element_Picker");


		if (in_array(get_class($Obj), $povolene_typy)) {
			$this->class_name = get_class($Obj);
		} else {
			if (in_array(get_parent_class($Obj), $povolene_typy)) {
				$this->class_name = get_parent_class($Obj);
			}
		}

		//$input_value=' value="' . $Obj->value . '"';
		$this->render_attrib = array(
		"name",
		"id",
		"style",
		"class",
		"size",
		"disabled",
		"readonly",
		"enabled",
		"onclick",
		"onchange",
		"tabindex",
		"autocomplete",
		"onblur",
		"data-theme",
		"data-role",
		"data-origin-value","autofocus"
		);
		switch($this->class_name)
		{

			case "G_Form_Element_Text":
				$this->_tagStart = '<input type="text"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,"placeholder");
				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"autocomplete");
				array_push($this->render_attrib,"maxlength");
				break;

			case "G_Form_Element_Picker":
				$this->_tagStart = '<input type="hidden"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,"placeholder");
				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"autocomplete");
				array_push($this->render_attrib,"maxlength");
				array_push($this->render_attrib,"data-model");
				array_push($this->render_attrib,"data-col");
				array_push($this->render_attrib,"data-id");
				array_push($this->render_attrib,"data-picker");
				$Obj->setAttribs("class","item_id");
				break;


			case "G_Form_Element_Color":
				$this->_tagStart = '<input type="color"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,"placeholder");
				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"autocomplete");
				array_push($this->render_attrib,"maxlength");
				break;

			case "G_Form_Element_Number":
				$this->_tagStart = '<input type="number"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,"placeholder");
				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"autocomplete");
				array_push($this->render_attrib,"maxlength");
				break;
			case "G_Form_Element_Image":
				$this->_tagStart = '<input type="image"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';

				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"alt");
				array_push($this->render_attrib,"src");
				break;
			case "G_Form_Element_File":
				$this->_tagStart = '<input type="file"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,"value");
				break;
			case "G_Form_Element_Datetime":
				$this->_tagStart = '<input type="text"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				$this->_tagEnd .= '<script type="text/javascript">datedit("' . $Obj->Attributes["id"] . '", "' . $Obj->Attributes["date_format"] . '");</script>';
				array_push($this->render_attrib,"value");
				break;
			case "G_Form_Element_Password":
				$this->_tagStart = '<input type="password"';
				$this->_tagCenter = '';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"placeholder");
				break;

			case "G_Form_Element_Checkbox":
				$this->_tagStart = '<input type="checkbox"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';

				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"checked");
				break;
			case "G_Form_Element_Hidden":
				$this->_tagStart = '<input type="hidden"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,
				array(
					"value",
					));
				array_push($this->render_attrib,"value");
				break;
			case "G_Form_Element_Submit":
				$this->_tagStart = '<input type="submit"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';
				array_push($this->render_attrib,"value");
				break;

			case "G_Form_Element_Button":
				$this->_tagStart = '<button type="submit"';
				$this->_tagCenter ='><span>' . $Obj->value;
				$this->_tagEnd = '</span></button>';
				array_push($this->render_attrib,"value");
				break;
			case "G_Form_Element_Select":
				$this->_tagStart = '<select';
				$this->_tagCenter ='>' . $this->eol;
				$this->_tagEnd = '</select>';
				break;
			case "G_Form_Element_Radio":
				$this->_tagStart = '';
				$this->_tagCenter ='';
				$this->_tagEnd = '';

				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"checked");
				break;
			case "G_Form_Element_Textarea":
				$this->_tagStart = '<textarea';
				$this->_tagCenter = '>' . $Obj->value;
				$this->_tagEnd = '</textarea>';

				array_push($this->render_attrib,"rows");
				array_push($this->render_attrib,"cols");
				array_push($this->render_attrib,"placeholder");
				break;
			default:
				$this->_tagStart = '<input type="text"';
				$this->_tagCenter ='';
				$this->_tagEnd = ' />';

				array_push($this->render_attrib,"value");
				array_push($this->render_attrib,"autocomplete");
				array_push($this->render_attrib,"maxlength");
				break;
		}

		$label = $Obj->getLabel();
		$result_label = "";
		// && $this->class_name != "G_Form_Element_Checkbox"
		$this->_getAttrib($Obj);
		if (!empty($label))
		{

			/*			$result .= $Obj->getStyle("label_wrap_start");
			   $result .= '<label for="' . $Obj->getName() . '">' . $label . '</label>';
			   $result .= $Obj->getStyle("label_wrap_end") . $this->eol;
			*/
			$result_label = $Obj->getStyle("label_wrap_start");
			$label_class = $Obj->getStyle("label_class");
			$label_class = !empty($label_class) ? ' class="'.$Obj->getStyle("label_class").'"' : '';

			$result_label .= '<label for="' . $Obj->Attributes["id"] . '"'.$label_class.'>' . $label . '</label>';
			$result_label .= $Obj->getStyle("label_wrap_end") . $this->eol;
		}
		//$Obj->getStyle("label_wrap_start");
	//	print_r($Obj);

		if ($this->class_name == "G_Form_Element_Text") {
			$result .= $Obj->getStyle("text_wrap_start");
		}
		if ($this->class_name == "G_Form_Element_Password") {
			$result .= $Obj->getStyle("password_wrap_start");
		}


		$result .= $this->_tagStart;

		if ($this->class_name !="G_Form_Element_Radio") {
			$result .= $this->_getAttrib($Obj);
		}
		$result .= $this->_tagCenter
		          . $this->_getMultiOptions($Obj)
		          . $this->_tagEnd;



		if ( !empty($label) && $this->class_name == "G_Form_Element_Checkbox")
		{
			if ($Obj->viewType == 2) {
				$result_checkbox = '<div class="checkbox">' . $result . '<label for="' . $Obj->Attributes["id"] . '">'  . $label . '</label></div>';
			} else {
				$result_checkbox = '<div class="checkbox">' . '<label for="' . $Obj->Attributes["id"] . '">' . $result . $label . '</label></div>';
			}

			return $result_checkbox;
		}


		if ($this->class_name == "G_Form_Element_Picker") {

		//	print_r($Obj);
			$result .= '<input type="text" name="' . $Obj->getFormName() . "_" . $Obj->Attributes["data-col"]. '" value="' . $Obj->Attributes["value-alias"]. '" class="combobox form-control" />';
		}
	/*	if ( !empty($label) && $this->class_name == "G_Form_Element_Checkbox2")
		{
			$result_checkbox = '<div class="checkbox">' . $result . '<label for="' . $Obj->Attributes["id"] . '">'  . $label . '</label></div>';
			return $result_checkbox;
		}*/


		if ($this->class_name == "G_Form_Element_Text") {
			$result .= $Obj->getStyle("text_wrap_end");
		}

		if ($this->class_name == "G_Form_Element_Password") {
			$result .= $Obj->getStyle("password_wrap_end");
		}
		$result .= $Obj->getStyle("element_wrap_end");

		$result_value = $result;
		//$result .= '</dd>' . $this->eol;
		//	$result .= '<p class="desc"></p><br />' . $this->eol;
		//. $this->eol;
		/*
		   . $this->_getLabel()
		   . $this->_getClass()
		   . $this->_getId()
		   . $this->_getAttrib()
		*/
		// print $result;
		$class_dl = '';

		//	print_r($_SESSION["err_elem"]);

		if (isset($_SESSION["err_elem"][$Obj->getFormName()][$Obj->getName()])) {
			//print "Chyba";
			if (isset($Obj->Attributes["class_dl"])) {
				$Obj->Attributes["class_dl"] = $Obj->Attributes["class_dl"] . " err";
			} else {
				$Obj->Attributes["class_dl"] = "err";
			}
			$class_dl = ' class="err"';
			unset($_SESSION["err_elem"][$Obj->getFormName()][$Obj->getName()]);
			//print $_SESSION["err_elem"][$name];
		}
		$res = '';




		// label
		if (isset($Obj->Attributes["dt_decorator"]) && !empty($Obj->Attributes["dt_decorator"]) && !empty($label))
		{
			$result_label = "<" . $Obj->Attributes["dt_decorator"] . ">" . $result_label . "</" . $Obj->Attributes["dt_decorator"] . ">";
			//print_r($Obj->Attributes);
		}

		// value
		if (isset($Obj->Attributes["dd_decorator"]) && !empty($Obj->Attributes["dd_decorator"]))
		{

			$end_dd = explode(" ",  $Obj->Attributes["dd_decorator"]);


			$result_value = "<" . $Obj->Attributes["dd_decorator"] . ">" . $result_value . "</" .$end_dd[0] . ">";
		}

		if ($Obj->firstLabel()) {
			$result = $Obj->getStyle("element_wrap_start").$result_label . $result_value;
		} else {
			$result =  $Obj->getStyle("element_wrap_start").$result_value . $result_label;
		}

		// obal
		if (isset($Obj->Attributes["dl_decorator"]) && !empty($Obj->Attributes["dl_decorator"]))
		{
			return "<" . $Obj->Attributes["dl_decorator"] . ">" . $result . "</" . $Obj->Attributes["dl_decorator"] . ">";
		}

		return $result;

		//return "<dl><dd" . $class_dl . ">" . $result . "</dd></dl>";

	}

}

class BootstrapFormElement {

	private $autofocus = false;

	private $value = "";

	public function autoFocus($value = true)
	{
		$this->autofocus = $value;
	}

}
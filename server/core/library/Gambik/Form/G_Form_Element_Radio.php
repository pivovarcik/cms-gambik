<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Form_Element_Radio extends G_Form_Element
{
	public $multiOptions;
	public $multiAttribs;
	function __construct($name)
	{
		parent::__construct($name);
		$this->multiOptions = array();
		$this->setAttribs(array("dd_decorator" => 'dd class="radio-group"',
						"dt_decorator" => "dt",
						"dl_decorator" => "dl",));
	}

	public function setMultiOptions($arr,$attr = array())
	{
		//$pole = explode("[]", $hodnota);

		foreach ($arr as $key => $value)
		{
			//$pole[$key] = $value;
			$this->multiOptions[$key] = $value;
		}
		foreach ($attr as $key => $value)
		{
			//$pole[$key] = $value;
			$this->multiAttribs[$key] = $value;
		}

		//print_R($this->multiAttribs);
		/*
		   for($i=0;$i<count($arr);$i++)
		   {
		   if (!empty($arr[$i]))
		   { array_push($this->multiOptions, $arr[$i]); }
		   }
		*/
	}
}
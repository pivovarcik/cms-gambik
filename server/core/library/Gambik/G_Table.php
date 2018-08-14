<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class G_Table {

	protected  $_data;
	protected  $_column;
	protected  $_tdAttribs;
	protected  $_trAttribs;

	protected $_head;
	protected $_body;
	protected $_foot;
	protected $_print_foot = true;

	public function __construct($data, $column, $th_attribs = array(), $td_attribs = array(), $tr_attribs = array())
	{
		$this->_data = $data;
		$this->_column = $column;
		$this->_thAttribs = $th_attribs;
		$this->_tdAttribs = $td_attribs;
		$this->_trAttribs = $tr_attribs;
		//	print_r($this->_data);
	}

	public function makeTable ($attribs = array()) {

		if (isset($attribs["print_foot"]) && $attribs["print_foot"] == 0) {
			$this->_print_foot = false;
		}

		//print "tady0";
		$this->_setHead();
		//print "tady1";
		$this->_setBody();
		//	print "tady2";
		if ($this->_print_foot) {
			$this->_setFoot();
		}
		//	print "tady3";
		$ret = $this->_table(
			$this->_head . $this->_body . $this->_foot,
			$attribs
		);

		return $ret;
	}

	public function makeHead () {

		$this->_setHead();
		return $this->_head;
	}

	protected function _setHead()
	{
		//print "tady";
		$ret = '<thead>';
		$ret .= '<tr>';
		foreach ($this->_column as $column => $name) {
			//if (isset($this->_thAttribs[$column])) {
			$thAttribs = isset($this->_thAttribs[$column]) ? $this->_thAttribs[$column] : "";
				$ret .= $this->_th($name, $thAttribs);
			//}
		}
		$ret .= '</tr>';
		$ret .= '</thead>';

		$this->_head = $ret;
	}
	protected function _setFoot()
	{
		$ret = '<tfoot>';
		$ret .= '<tr>';
		foreach ($this->_column as $column => $name) {
			//if (isset($this->_thAttribs[$column])) {
			$thAttribs = isset($this->_thAttribs[$column]) ? $this->_thAttribs[$column] : "";
				$ret .= $this->_th($name, $thAttribs);
			//}
		}
		$ret .= '</tr>';
		$ret .= '</tfoot>';

		$this->_foot = $ret;
	}
	public function _setBody() {

		//$ret = '';
		$ret = '<tbody>';
		//	print_r($this->_data);
		if (count($this->_data) > 0)
		{
			$sudy = false;
			$rowIndex=0;
			foreach ($this->_data as $row) {

				//	print_r($row);
				$text = '';
				//print count($this->_column) . "<br />";

				$pocetSloupcu = count($this->_column);
				$pocetSloupcuNaRadku = $pocetSloupcu;
				$poseldniCisloSlopuce = 0;
				$i=0;
				foreach ($this->_column as $column => $name) {

					//if (!isset($row->$column) ) {
					if (isset($row->$column) || property_exists($row, $column)) {
					//	if (!($row->$column) ) {
						//print $row . "->" . $column . "<br />";

						$poseldniCisloSlopuce = $i;
					} else {
						$pocetSloupcuNaRadku--;
					}
					$i++;
				}

				if ($pocetSloupcu > $pocetSloupcuNaRadku) {

				}
				$i=0;
				foreach ($this->_column as $column => $name) {
					//	print $column . "<br />";
					//	$ret .= $this->_td($row->$column);
					//if (isset($row->$column)) {
					if (isset($row->$column) || property_exists($row, $column)) {
						$tdAttribs = array();
						if (isset($this->_tdAttribs[$column])) {
							$tdAttribs = $this->_tdAttribs[$column];
						}
						if ($pocetSloupcu > $pocetSloupcuNaRadku && $poseldniCisloSlopuce == $i ) {
							$tdAttribs["colspan"] = ($pocetSloupcu - $pocetSloupcuNaRadku+1);
						}
						$text .= $this->_td($row->$column, $tdAttribs);
					}
					$i++;
				}
				$attribs = array();
				if (isset($this->_trAttribs[$rowIndex])) {
					$attribs = $this->_trAttribs[$rowIndex];
				}
				if ($sudy) {
					$class = "sudy";
					if (isset($attribs["class"])) {
						$class = $attribs["class"] . " " . $class;
					}
					$attribs["class"] = $class;
					$sudy = false;
				} else {
					$sudy = true;
				}

				//$attribs = array("onmouseout"=>"this.className='first';", "onmouseover"=>"this.className='row_style_radek';");
				//$this->_thAttribs[$column];
				$ret .= $this->_tr($text, $attribs);
				$rowIndex++;
			}

		} else {
			$translator = G_Translator::instance();
			$text = '';
			$text .= $this->_td($translator->prelozitFrazy("zadna_data"), array("colspan" => count($this->_column),"style" => "text-align:center"));
			$attribs = array();
			$ret .= $this->_tr($text, $attribs);
		}
		$ret .= '</tbody>';
		//print $ret;
		$this->_body = $ret;
	}



	protected function _table($text, $attribs = array()) {

		return $this->_box($text, 'table', $attribs);
	}

	protected function _tr($text, $attribs = array()) {

		return $this->_box($text, 'tr', $attribs);
	}

	protected function _td($text, $attribs = array()) {

		//$view = new Zend_View();
		return $this->_box($text, 'td', $attribs);
	}
	protected function _th($text, $attribs = array()) {

		return $this->_box($text, 'th', $attribs);
	}

	protected function _box($text,$tag, $attribs = array()) {

		if (!empty($attribs)) {
			foreach ($attribs as $key => $value) {
				$atribArray[] = $key.'="'.$value.'"';
			}
			$tagAttribs = ' '.join(' ', $atribArray);
		} else {
			$tagAttribs = '';
		}


		$ret = '<'.$tag.$tagAttribs.'>'.$text.'</'.$tag.'>';

		return $ret;
	}



}
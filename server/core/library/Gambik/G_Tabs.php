<?php

/**
 * Třída na generování Záložek
 *
 * @version $Id$
 * @copyright 2011
 */

$tab = array("name" => "Main", "title" => "Hlavní" );




class G_Tabs {

	protected $tabs = array();
	protected $position = "TOP";
	public function __construct($position = "TOP")
	{
		$this->position = $position;
	}

	public function addTab($tab,$start = false)
	{
		if ($start) {
			array_unshift($this->tabs, $tab);
		} else {
			array_push($this->tabs, $tab);
		}



	}
	public function makeTabs ($tabs = array()) {


		foreach ($tabs as $tab) {
			$this->addTab($tab);
		}
		// class="tabs-min"
		// ui-tabs
		$class_position = '';
		if ($this->position == "left") {
			$class_position = ' class="tabbable tabs-left"';
		}
		$html = '<div'.$class_position.'>';
		$html .= '<ul id="myTab" class="nav nav-tabs">';
		// class="ui-tabs-nav"
		for($i=0;$i<count($this->tabs);$i++)
		{
			$selected = '';
			if ($i == 0) {
				//$selected = ' class="ui-tabs-selected"';

				$selected = ' class="active"';
			}
			$html .= '<li' . $selected .'><a href="#Tab' . $this->tabs[$i]["name"] .'"  data-toggle="tab">' . $this->tabs[$i]["title"] .'</a></li>';
		}
		$html .= '</ul>';
	//	$html .= '<div class="clearfix"> </div>';


		$html .= '<div id="myTabContent" class="tab-content">';

		for($i=0;$i<count($this->tabs);$i++)
		{
			$selected = '';
			if ($i == 0) {

				$selected = ' active';
			}
			// class="ui-tabs-panel' . $selected .'"
			$html .= '<div role="tabpanel" class="tab-pane'.$selected.'" id="Tab' . $this->tabs[$i]["name"] .'">';
		//	$html .= '<div class="container_content_labels">';
		//	$html .= '<div class="container_parameters">';

			$html .= $this->tabs[$i]["content"];

		//	$html .= '</div>';
		//	$html .= '</div>';
			$html .= '</div>';


		}
		$html .= '</div>';
		$html .= '</div>';
	/*
$html .= '<script>';
$html .= '$(function () {';
$html .= '	$("#myTab a:last").tab("show");';
$html .= '})';

$html .= '		$("#myTab a").click(function (e) {
			e.preventDefault();
			$(this).tab("show");
		})';
$html .= '</script>';*/

		return $html;
	}

}
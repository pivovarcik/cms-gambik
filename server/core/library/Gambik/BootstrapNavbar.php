<?php

class BootstrapNavbar {

	private $tabkey = "	";
	private $neLinekey = "\n";
	private $treeData = array();
	private $startNodeId = null;
	private $currentPath = null;
	private $naselStart = false;
	private $level = 9999;
	private $selected_parent = array();
	private $home = false;
	private $home_text = '';

	public $ulRootClass = "nav navbar-nav";
	public $ulClass = "dropdown-menu";
	public $liSelectedClass = "active";


	public function __construct($treeData = array(), $startId, $attribs = null){


		if (!is_null($attribs)) {
			if (isset($attribs->selected_parent) && is_array($attribs->selected_parent)) {
				$this->selected_parent =  $attribs->selected_parent;
			}
			if (!is_array($attribs->path)) {
			//	explode()
			}
			$this->currentPath =  $attribs->path;

			if (isset($attribs->level)) {
				$this->level = $attribs->level;
			}
		}


		$elem = null;
		foreach ($attribs->path as $key => $val) {

			if (is_null($elem)) {
				$elem = $treeData->childern[$val];
			} else {
				$elem = $elem->childern[$val];
			}



			$elem->data->class = "active";
			$elem->data->isSelected = true;



		//	print $val;

			if ($val == 6) {
			//	print_r($elem);
			}



		}
		$this->startNodeId = (int) $startId;

		if (isset($treeData->childern[$startId])) {
			$this->treeData = $treeData->childern[$startId];
		}

		$this->treeData->category_id= null;
	}

	public function addHomeButton($text = null)
	{
		$this->home = true;

		if (!is_null($text)) {
			$this->home_text = $text;
		}
	}

	private function printNode($node)
	{
		$this->naselStart = true;
		if (!$this->naselStart && $node->id == $this->startNodeId) {
			$this->naselStart = true;
			//print "našel";
		}

		$isChildern = false;
		if (isset($node->childern) && is_array($node->childern) && count($node->childern) > 0 ) {
			$isChildern = true;
			//	$node->data->ul_class = "dropdown-menu multi-level";
		}

		if ($isChildern) {
			if (is_null($node->data->category_id)) {
				//	$res = '<ul class="' . $this->ulRootClass . '">' . "\n";
			} else {
				//	$res = '<ul class="' . $this->ulClass . '">' . "\n";
			}
		}



		$res = '';
		if ($this->naselStart) {
		//	$res .= $this->tabkey . '<li>';

			$liClass = array();

  	if (isset($node->data->isSelected) && $node->data->isSelected) {
				array_push($liClass, $this->liSelectedClass);
				array_push($liClass, "stay-open");
			}

			/*
			if (isset($node->data->class) && !empty($node->data->class)) {
				array_push($liClass, $node->data->class);
				array_push($liClass, "stay-open");
			}
			*/
			if ($isChildern && $this->level >= $node->data->level) {
				array_push($liClass, "dropdown");
			}

			if (count($liClass)>0) {
				$liClass = ' class="' . implode(" ", $liClass) . '"';
			} else {
				$liClass = "";
			}


			$res .= $this->tabkey . '<li'.$liClass.'>';



			if ($isChildern && $this->level >= $node->data->level) {

				if (strpos("#", $node->data->link)) {
					$res .= '<a class="dropdown-toggle" data-toggle="dropdown" href="#">';
				} else {
					$res .= '<a class="dropdown-separate" href="' . $node->data->link . '">';
				//	$res .= '<a class="dropdown-toggle" data-toggle="dropdown" href="' . $node->data->link . '">';
				}

			} else {
				$res .= '<a href="' . $node->data->link . '">';
			}

			$res .= '<span>' . $node->data->title . '</span>';

			if ($isChildern && $this->level >= $node->data->level) {

				if (strpos("#", $node->data->link)) {

					$res .= '<b class="caret"></b></a>'. "\n";
				} else {
					$res .= '</a><span role="button" class="btn dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></span>'. "\n";
				}
			} else {
				$res .= '</a>';
			}

		}
		if ($isChildern && $this->level >= $node->data->level) {

			if ($this->naselStart) {
				$res .= '<ul class="' . $this->ulClass . '">' . "\n";
			}
			//	foreach ($node->childern as $child) {
			foreach ($node->orderList as $key => $id) {

				$child = $node->childern[$id];
		//		print $this->level . " >= " . $node->data->level."<br />";
			//	if ($this->level >= $node->data->level) {
					$res .= $this->printNode($child);
			//	}

			}
			if ($this->naselStart) {
				$res .= '</ul>'. "\n";
			}

		}
		if ($this->naselStart) {
			$res .= $this->tabkey .'</li>'. "\n";
		}
		//	if ($isChildern) {
		//	$res .= '</ul>'. "\n";
		//	}
		return $res;
	}
	public function printMenu()
	{
		//	$naselStart = false;
		//	$res = '<ul class="nav navbar-nav">';
		$res = "\n";
		$res .= '<ul class="' . $this->ulRootClass . '">'. "\n";

		if ($this->home) {
			$liClass = '';
			$res .= $this->tabkey . '<li'.$liClass.'>';

			$res .= '<a href="' . URL_HOME . '">';
			$res .= '<span>' . $this->home_text . '</span>';
			$res .= '</a>';

			$res .= $this->tabkey .'</li>'. "\n";
		}

	///		print_r($this->treeData->childern);
		foreach ($this->treeData->childern as $row) {

			$row->data->category_id = null;

			if (count($this->selected_parent) > 0) {

				if (in_array($row->data->id,$this->selected_parent)) {
					$res .= $this->printNode($row);
				}


			} else {
				$res .= $this->printNode($row);
			}



		}


		$res .= '</ul>'. "\n";

		return $res;
	}
}
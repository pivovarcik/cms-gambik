<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$category_root_id = 0;

$categoryTreeList = array();
$ignore_category = array();

$type = "category";
if (isset($_GET["type"])) {
	$type = $_GET["type"];
}
$tree = new G_Tree($type);

//$tree = new G_Tree();
$categoryTreeList = $tree->categoryTree(array(
				"parent"=>$category_root_id,
				"debug"=>0,
				));

$elem = new G_Form_Element_Select("category_id");
$elem->setAttribs(array("id"=>"category_id","required"=>false));
//$value = $this->Request->getPost("category_id", $page->category_id);
//$elem->setAttribs('value',$value);
//$elem->setAttribs('label','Rubrika:');
$elem->setAttribs('class','selectbox');
$pole = array();
$pole[0] = " -- nezařazené -- ";
$attrib = array();
print '<option value="0" class="vnoreni0">' .  $pole[0] . '</option>';
foreach ($categoryTreeList as $key => $value)
{

	if (!in_array($value->id, $ignore_category)) {
		$selected = "";
		if (isset($_POST["selected"]) && $_POST["selected"] == $value->id) {
			$selected = ' selected="selected"';
		}
		print '<option value="' . $value->id . '" class="vnoreni' . $value->vnoreni . '"' . $selected . '>' .  $value->title . '</option>';
		//$pole[$value->id] = $value->title;
		//$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
	}
}
$elem->setMultiOptions($pole,$attrib);
//print $elem->render();

//print_R($categoryTreeList);
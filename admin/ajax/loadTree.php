<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
/*
$type = "syscategory";
if (isset($_GET["type"])) {
	$type = $_GET["type"];

$tree = new G_Tree($type);
$dataProTree = $tree->categoryTree(array(
		"parent"=>0,
		"debug"=>0,));

} else {

}
*/
$entityType = isset($_GET["type"]) ? $_GET["type"] : "syscategory";

if ($entityType == "category" || $entityType == "syscategory") {
	$tree = new G_Tree($entityType);
	$dataProTree = $tree->categoryTree(array(
		"parent"=>0,
		"debug"=>0,));
	$editLink = $tree->linkEdit;
} else {
	$tree = new G_CiselnikTree($entityType);
	$dataProTree = $tree->categoryTree(array(
		"parent"=>0,
		"debug"=>0,
		));

	$editLink = isset($_GET["edit_link"]) ? $_GET["edit_link"] : "" . $entityType . "Edit";

}






print tree_menu($dataProTree,0,0,' id="treecat"',$entityType,$editLink);
?>
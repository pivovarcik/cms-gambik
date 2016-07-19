<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$type = "syscategory";
if (isset($_GET["type"])) {
	$type = $_GET["type"];
}
$tree = new G_Tree($type);
$dataProTree = $tree->categoryTree(array(
		"parent"=>0,
		"debug"=>0,));

print tree_menu($dataProTree,0,0,' id="treecat"',$type,'admin/syscategory/syscat');
?>
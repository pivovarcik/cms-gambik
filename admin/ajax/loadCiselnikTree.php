<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$entityType = isset($_GET["ciselnik"]) ? $_GET["ciselnik"] : "ProductCategory";
$editLink = isset($_GET["edit_link"]) ? $_GET["edit_link"] : "" . $entityType . "Edit";
$tree = new G_CiselnikTree($entityType);
$rubrikyList1 = $tree->categoryTree(array(

		"parent"=>0,
		"debug"=>0,
		));

?>
<?php
print tree_menu($rubrikyList1,0,0,' id="treecat"', $entityType, $editLink);
?>
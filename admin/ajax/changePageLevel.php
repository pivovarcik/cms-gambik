<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";


switch ($_POST["type"]) {
	case "post":
		$model = new models_Publish();
		break;
	case  "category":
		$model = new models_Category();
		break;
	case  "syscategory":
		$model = new models_SysCategory();
		break;
	default:
		$modelName = "models_" . $_POST["type"];
		$model = new $modelName;
} // switch

if (strtolower(trim($_POST["position"])) == "up") {
	$model->levelUp($_POST["id"]);
} else {
	$model->levelDown($_POST["id"]);
}
/*
$tree = new G_Tree();
$rubrikyList1 = $tree->categoryTree(array(

		"parent"=>0,
		"debug"=>0,
		));
*/
?>
<?php
//print tree_menu($rubrikyList1,0,0,' id="treecat"');
?>
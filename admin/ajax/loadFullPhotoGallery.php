<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

//print T_CLANKY;

$fotoController = new FotoController();
//$filesController->createAction();
//$filesController->deleteAction();
$params = array();
$params["limit"] = 100;
$table = $fotoController->fotoListTable($params);
//print_r($table);
$page = (int) isset($_GET["pg"]) ? $_GET["pg"] : 0;

$pager = new G_Paginator($page, $fotoController->total, $params["limit"]);
$output = $pager->render();


?>
<?php print($output); ?>
<?php
$table_attrib = array(
"class" => "widefat fixed",
"id" => "data_grid",
"cellspacing" => "0",
);
print $table->makeTable($table_attrib);?>
<?php print($output); ?>
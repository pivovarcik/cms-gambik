<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
//print T_CLANKY;

$fotoController = new FilesController();
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
<form action="" class="standard_form" method="post">
<?php print($output); ?>
<?php

print $table;?>
</form>
<?php print($output); ?>
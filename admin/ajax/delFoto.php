<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
$result = array();
$result["status"] = "wrong";
$fotoController = new FotoController();
$fotoGallery = $fotoController->deleteAction();


if ($fotoGallery) {
	$result["status"] = "ok";
}
$result = json_encode($result);
print_r($result);
exit;
?>

<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$fotoController = new FilesController();
$params = array();

$params["gallery_id"] = (int) $_POST["id"];
$params['gallery_type'] = $_POST["type"];
$fotoGallery = $fotoController->filesUmisteniListEdit($params);

print $fotoGallery;
return;
?>
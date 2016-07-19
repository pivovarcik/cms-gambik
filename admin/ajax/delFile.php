<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//include dirname(__FILE__) . "/../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$fotoController = new FilesController();
$fotoGallery = $fotoController->deleteAction();
?>

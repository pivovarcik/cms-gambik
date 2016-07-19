<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
if (isset($_POST["foto_id"])) {


//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
$foto_id = (int) $_POST["foto_id"];
$fotoController = new FotoController();
$fotoDetail = $fotoController->getFoto($foto_id);
$imageController = new ImageController();

if (!empty($fotoDetail->file)) {
	$PreviewUrl = $imageController->get_thumb($fotoDetail->file, 262,262);


	$res = '<img src="'. $PreviewUrl.'"/>';
	print $res;
}
	}
?>
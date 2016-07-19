<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$fotoController = new FotoController();
$params = new FotoPlacesListArgs();

$params->gallery_id = (int) $_POST["id"];
$params->gallery_type = $_POST["type"];
$fotoGallery = $fotoController->fotoUmisteniListEdit($params);
$data = array();
$data["html"] = $fotoGallery;
$data["count"] = $fotoController->total;

print_r(json_encode($data));
//print $fotoGallery;

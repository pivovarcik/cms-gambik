<?php
/**
* Kontrola nových zpráv
* */

session_start();
header('Content-type: text/html; charset=utf-8');
//equire_once dirname(__FILE__) . "/../../inc/init_spolecne.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$controller = new FotoController();
$controller->sortItemsAction();

?>
<?php
/**
 * Kontrola nových zpráv
 * */

session_start();
header('Content-type: text/html; charset=utf-8');
//require_once dirname(__FILE__) . "/../../inc/init_spolecne.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";


$last_version = file_get_contents("http://www.pivovarcik.cz/install/check_version.php");
$aktualni_version = $settings->get("VERSION_RS");
$data = array();
if ($last_version > $aktualni_version) {
	$data["status"] = "Nová verze je k dispozici";
	$data["upgrade"] = $last_version;
} else {
	$data["status"] = "Máte aktuální verzi";
	$data["upgrade"] = "";
}

$json = json_encode($data);
print_r($json);

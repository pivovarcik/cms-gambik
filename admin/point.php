<?php
/**
* Univerzální Upload fotek
* */

session_start();
header('Content-type: text/html; charset=utf-8');
require_once dirname(__FILE__) . "/../inc/init_spolecne.php";
//$userController->islogIn();


$data = array();
$data["cms_version"] = VERSION_RS;
$data["cms_expired"] =(date("j.n.Y",strtotime($g->setting["INSTALL_DATE"])+(365 * 24 * 3600)));
$json = json_encode($data);
print_r($json);
?>
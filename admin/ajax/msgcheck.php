<?php
/**
* Kontrola nových zpráv
* */

session_start();
header('Content-type: text/html; charset=utf-8');
//require_once dirname(__FILE__) . "/../../inc/init_spolecne.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
//include dirname(__FILE__) . "/../../inc/init_admin.php";
/*if (!$GAuth->islogIn()){
	return false;
}*/
$messageController = new models_Message();

$params = new ListArgs();
$params->adresat = USER_ID;
$params->new = true;
$params->order = "m.TimeStamp DESC";
$messagesList = $messageController->getList($params);

$result = array();

$result["msgs"] = array();
$countNewMessage = 0;
for($i=0;$i<count($messagesList);$i++)
{
	$result["msgs"][$i]->message = $messagesList[$i]->message;
	$result["msgs"][$i]->nick = $messagesList[$i]->autor_nick;
	$result["msgs"][$i]->id = $messagesList[$i]->autor_id;
	$countNewMessage += $messagesList[$i]->isNewMessage;
}
$result["count"] = $countNewMessage; //$messageController->total;
//$result["status"] = $status[$status_id];
/*
   $result["timeout"] = $timeout;
   $result["count"] = $l->pocet_znamek;
   $result["average"] = round($l->znamka/$pocet_znamek,2);
   $result["position"] = $position;
   $result["result"] = $text_hlasovalo  . ' &Oslash; ' . round($l->znamka/$pocet_znamek,2);
*/
//print_r($_POST);
$json = json_encode($result);
print_r($json);

?>
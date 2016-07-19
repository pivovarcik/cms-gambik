<?php

/**
 * Statistika objednávek na nástěnku
 *
 * @version $Id$
 * @copyright 2013
 */

include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$model = new models_Orders();

$params = new ListArgs();

$date = date("Y-m-d H:i:s");
$params->TimeStampTo = $date;
$params->TimeStampFrom = date("Y-m-d",strtotime ( '-1 month' , strtotime($date) ) );
$stats = $model->getStatsPerDay($params);

//print_r($stats);
$res2 = array();
$res2["label"] = date("j.n.Y",strtotime($params->TimeStampFrom)). " - " . date("j.n.Y",strtotime($params->TimeStampTo));
$res2["data"] = array();
$res = array();
foreach ($stats as $key => $value) {
	array_push($res, array(strtotime($value->date ) . "000",$value->cost_total) );
}
$res2["data"] = $res;
$json = json_encode($res2);
print_r($json);
exit;
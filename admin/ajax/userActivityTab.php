<?php

/**
 * Statistika objednávek na nástěnku
 *
 * @version $Id$
 * @copyright 2013
 */
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$model = new models_UserActivityMonitor();

$params = array();
$params["activity_monitor"] = true;
$stats = $model->getList($params);
//PRINT_r($stats);
//print_r($model->getStats($params));
//$json = json_encode($list2);
//print_r($json);
/*
$date = $params["TimeStampFrom"];
$params["TimeStampTo"] = $date;
$params["TimeStampFrom"] = date("Y-m-d",strtotime ( '-1 month' , strtotime($date) ) );

print_r($model->getStats($params));
   */

for ($i=0; $i<count($stats);$i++)
{
	$stats[$i]->TimeStamp = gDate($stats[$i]->TimeStamp);
}
$th_attrib = array();
$column["nick"] = "Uživatel";
$column["ip_adresa"] = "IP";
$column["to_url"] = "Url";
$column["TimeStamp"] = "Kdy";
//$column["nazev_vyrobce"] = $sorting->render("Značka", "vyr");

$table = new G_Table($stats, $column, $th_attrib, $td_attrib);


$table_attrib = array(
						"class" => " widefat",
						"cellspacing" => "0",
						"print_foot" => 0,
						);


?>
<h5>Poslední aktivita na webu<a href="#" class="right refresh"><i class="fa fa-refresh"></i></a></h5>
<?php
print $table->makeTable($table_attrib);
?>
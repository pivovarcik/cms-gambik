<?php

session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
include dirname(__FILE__) . "/../../inc/init_admin.php";
$result ="";
$data = array();
if (isset($_POST["id"]) && !empty($_POST["id"]))
{
	$id = (int) $_POST["id"];
	$model = new models_Products();
	$detail = $model->getDetailById($id);

	if ($detail) {
		$updateData = array();
		$status = 1;
		if ($detail->aktivni == 1) {
			$status = 0;
		}
		$updateData["aktivni"] = $status;
		$model->updateRecords($model->getTableName(),$updateData,"id=" . $id);

		$data["status"] = $status;
		$data["aktivni"] = $detail->aktivni;
	}
}
$json = json_encode($data);
print_r($json);
exit;
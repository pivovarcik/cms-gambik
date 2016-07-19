<?php
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));
define('PATH_TEMP', PATH_ROOT2 . '/../template/');

	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
	$data = new stdClass();
	$rows = array();

	$data->list = $rows;
	$data->count = 0;

	$favoriteProductController = new FavoriteProductController();



	$favoriteProductController->addProductAction();

	$favoriteProductController->removeProductAction();


	$params = array();
	$params["limit"] = 10;
	$params["pg"] = 1;
	$params["order"] = "TimeStampMax DESC";

	$thumb_width=87;
	$thumb_height=100;

	$showFirst = 3;

	$productHistorylist = $favoriteProductController->favoriteList($params);
	if (count($productHistorylist) > 0) {

		for($i=0;$i<count($productHistorylist);$i++) {
			$row = array();

			$PreviewUrl = "";
			if (!empty($productHistorylist[$i]->file)) {
				$PreviewUrl = $imageController->get_thumb($productHistorylist[$i]->file,$thumb_width,$thumb_height,null,false,false);
			}
			$row["img"] = $PreviewUrl;
			$row["title"] = $productHistorylist[$i]->title;
			$row["link"] = $productHistorylist[$i]->link;
			array_push($rows,$row);

		}
		$data->list = $rows;
		$data->count = count($productHistorylist);

	}

$json = json_encode($data);
print_r($json);
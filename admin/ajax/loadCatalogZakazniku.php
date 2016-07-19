<?php

include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";


$model = new models_CatalogZakazniku();

$args = new ListArgs();

$args->fulltext = $_POST["q"];
$list = $model->getList($args);

//print_r($list);


$result = array();
foreach ($list as $key => $item) {

	$radek = new stdClass();
	$radek->id = $item->page_id;
	$radek->title = strip_tags($item->title);
	$radek->address1 = $item->address1;
	$radek->zip_code = $item->zip_code;
	$radek->ico = $item->ico;
	$radek->dic = $item->dic;
	$radek->email = $item->email;
	$radek->city = $item->city;
	$radek->telefon = $item->telefon;

	$radek->firstname = $item->firstname;
	$radek->lastname = $item->lastname;
	array_push($result, $radek);
}

echo json_encode(array_slice(array_values($result), 0, 20));
?>
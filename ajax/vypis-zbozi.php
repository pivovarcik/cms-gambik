<?php

session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));
//define('PATH_TEMP', PATH_ROOT2 . '/../template/');

$data =array();
$data["status"] = "wrong";
if (isset($_POST["lang"])) {

	define("LANG_TRANSLATOR",(string) $_POST["lang"]);
	//$params->lang = (string) $_POST["lang"];
}


require_once PATH_ROOT2.'/../inc/init_spolecne.php';



$productController = new ProductController();


$params = new ListArgs();
//$params["umisteni"] = $umisteni;
//$params->child = PAGE_ID;

if (isset($_POST["cat_id"])) {
	define("PAGE_ID", $_POST["cat_id"]);
	$params->child = (int) $_POST["cat_id"];
}

$params->limit = (int) $eshopSettings->get("PRODUCT_LIST_LIMIT");

if (isset($_POST["limit"])) {

	$params->limit = (int) $_POST["limit"]; //33;
}


$params->aktivni = 1;
//$_attribs = new models_Attributes();

if (isset($_POST["lang"])) {
	$params->lang = (string) $_POST["lang"];
}

if (isset($_POST["q"]) && !empty($_POST["q"])) {
	$params->search = (string) $_POST["q"];
}
if (isset($_POST["page"])) {
	$params->page = (int) $_POST["page"];
}
if (isset($_POST["cenaOd"])) {
	$params->lowestPrice = (int) $_POST["cenaOd"];
}


if (isset($_POST["cenaDo"])) {
	$params->highestPrice = (int) $_POST["cenaDo"];
}
$tableView = false;

if (isset($_POST["view"]) && isInt($_POST["view"]) && $_POST["view"] == 1) {
	$tableView = true;
}

if (isset($_POST["vyr"]) && is_array($_POST["vyr"])) {


	$params->vyrobce = array_flip($_POST["vyr"]);
}
if (isset($_POST["znacka"])) {
	$params->vyrobce = (int) $_POST["znacka"];
}
if (isset($_POST["skupina"])) {
	$params->skupina = (int) $_POST["skupina"];
}


if (isset($_POST["attributes"]) && is_array($_POST["attributes"]) && count($_POST["attributes"]) > 0) {
//	$params->attributes = array_flip($_POST["attributes"]);
		$params->attributes = ($_POST["attributes"]);
}
//print_r($_POST["attributes"]);
//print_r($params);
if (isset($_POST["skupina"]) && is_array($_POST["skupina"]) && count($_POST["skupina"]) > 0) {
	$params->skupina = array_flip($_POST["skupina"]);
}


if (isset($_POST["order"])) {
	$params->orderBy = $_POST["order"];
}
if (isset($_POST["sort"])) {
	$params->orderBy .= " ".$_POST["sort"];
}
if (isset($_POST["img_width"])) {
	$thumb_width = (int) $_POST["img_width"];
}

if (isset($_POST["img_height"])) {
	$thumb_height = (int) $_POST["img_height"];
}


//$paramsFilter = new ProductParamsFilter();
//print $paramsFilter->minCena;

//print_r($params);

$zboziList = array();

$l = $productController->productList($params);

/*
for($i=0;$i<count($l);$i++)
{
	if (!empty($l[$i]->file)) {
		//$zboziList[$i]->PreviewUrl = '<img  alt="'.$l[$i]->title.'" src="' . $imageController->get_thumb($l[$i]->file,$thumb_width,$thumb_height,null,false,false) . '" class="thumb" />';

		$zboziList[$i]->img_url = $imageController->get_thumb($l[$i]->file,$thumb_width,$thumb_height,null,false,false);
	} else {
		//$zboziList[$i]->PreviewUrl = '<div style="width:93px;height:78px;"> Bez náhledu</div>';
		$zboziList[$i]->img_url = "";
	}

	$pocetDesetin = ($l[$i]->cena_bezdph - round($l[$i]->cena_bezdph) == 0) ? 0 : 2;
	$zboziList[$i]->title = strip_tags($l[$i]->title);
	$zboziList[$i]->link = $l[$i]->link;
	$zboziList[$i]->nazev_dostupnost = (string)$l[$i]->nazev_dostupnost;
	$zboziList[$i]->description = strip_tags(truncateUtf8(trim($l[$i]->description),110,false,true));
	$zboziList[$i]->qty = round($l[$i]->qty,0);
	if ($eshopSettings->get("PRICE_TAX") == "0") {
		$zboziList[$i]->cena = numberFormat($l[$i]->cena_bezdph, $pocetDesetin) . '&nbsp;Kč';
		$zboziList[$i]->cena_desc = 'bez DPH';
 	} else {
		$zboziList[$i]->cena = numberFormat($l[$i]->cena_sdph, 0) . '&nbsp;Kč';
 		$zboziList[$i]->cena_desc = 's DPH';
	}
	if ($eshopSettings->get("PLATCE_DPH") == "1") {
		$zboziList[$i]->cena_sdph = numberFormat($l[$i]->cena_sdph, $pocetDesetin). '&nbsp;Kč';
	}

	$zboziList[$i]->cislo = $l[$i]->cislo;
	$zboziList[$i]->product_id = $l[$i]->page_id;
	$zboziList[$i]->nazev_mj = $l[$i]->nazev_mj;

	$zboziList[$i]->sleva = $l[$i]->sleva;
	$zboziList[$i]->sleva_label = $l[$i]->sleva_label;
}
*/
$result = array();
//$result["productList"] 	= $zboziList;



$vypisRadkuHtml = new VlastniProductListHtmlVypis($l, $params->page, $productController->total, $params->limit, $tableView);


if (isset($_POST["printPages"])) {
	$vypisRadkuHtml->printPages = (int) $_POST["printPages"];
}

$result["productListHtml"] 	= $vypisRadkuHtml->getRadkyHtml(true);
$result["strankovaniHtml"] 	= $vypisRadkuHtml->getStrankovaniHtml();

$result["count"] = $productController->total;
//$result["min"] = $paramsFilter->minCena;
//$result["max"] = $paramsFilter->maxCena;
$result["pageLimit"] = $params->limit;

$result["orderby"] = $params->orderBy;
$json = json_encode($result);
print_r($json);
//print_r($result);
?>
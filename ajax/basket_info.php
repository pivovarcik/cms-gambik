<?php

session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));
define('PATH_TEMP', PATH_ROOT2 . '/../template/');
require_once PATH_ROOT2.'/../inc/init_spolecne.php';

//	PRINT LANG_TRANSLATOR;
//print_r($_GET);
if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
} else {
	define('LOGIN_STATUS', 'ON');
}
$basketController = new BasketController();
$thumb_width=87;
$thumb_height=100;

$params = new ListArgs();
$params->thumb_width = $thumb_width;
$params->thumb_height = $thumb_height;
$basketList = $basketController->basketListEdit($params);


if (!$basketController->isEmpty) {
	$kosik_label =  '<span class="kosik-label">' . numberFormat($basketController->getCelkovaCena(), 0). '&nbsp;' . MENA . '</span>';
}  else {
	$kosik_label = '<span class="kosik-label kosik-label-empty">' . $translator->prelozitFrazy("kosik_je_prazdny") . '</span>';
}
//fa fa-shopping-basket
//fa-shopping-cart
$basket_info_text = '<a id="basket-trigger" href="' . URL_HOME . 'basket"><i class="fa fa-shopping-basket"></i><span class="kosik_count">' . $basketController->total . '</span>' . $kosik_label . '</a>';
$data = array();


//print $basket_info_text;
if (!$basketController->isEmpty) {
	$basket_info_text .= '<div class="basket_preview" style="display:none;">';
		$basket_info_text .= '<div class="basket_zobacek"></div>';
		$basket_info_text .= '<div class="basket_preview_wrap">';




		$basket_info_text .= '<table cellpadding="0" cellspacing="0">';


for ($i=0;$i<count($basketList);$i++){
$basket_info_text .= '<tr>';
$basket_info_text .= '<td class="thumb"><a class="b1" href="' . $basketList[$i]->link . '">';
$basket_info_text .= $basketList[$i]->preview . '</a>';
$basket_info_text .= '</td>';
$basket_info_text .= '<td><a class="product_name" href="' . $basketList[$i]->link . '">';
$basket_info_text .= '		<span class="nazev">' . $basketList[$i]->title . '</span></a><br />';
$basket_info_text .= $basketList[$i]->product_description;
$basket_info_text .= '		<span class="kod">' . $basketList[$i]->cislo . '</span>';

$basket_info_text .= $basketList[$i]->mnozstvi . ' x ';
if ($eshopSettings->get("PRICE_TAX") == "0") {

$basket_info_text .=  numberFormat($basketList[$i]->cena_bezdph, 2). '&nbsp;' . MENA . ''; } else { $basket_info_text .= numberFormat($basketList[$i]->cena_sdph, 0). '&nbsp;' . MENA . ''; }

$basket_info_text .= '</td>';

$basket_info_text .= '</tr>';
}
$basket_info_text .= '</table>';


$basket_info_text .= '			<div class="basket-preview-footer">';
$basket_info_text .= '				<p id="mezisoucet">' . $translator->prelozitFrazy("mezisoucet") . ': <span class="price">' . numberFormat($basketController->getCelkovaCena(), 0). '&nbsp;' . MENA . '</span></p>';
$basket_info_text .= '				<p class="btn-group">';
$basket_info_text .= '				<a class="btn btn-sm btn-success cart_bottom_pokracovat" href="' . URL_HOME . 'basket">' . $translator->prelozitFrazy("pokracovat_k_pokladne"). ' <i class="fa fa-chevron-right"></i></a>';
$basket_info_text .= '				</p>';
$basket_info_text .= '			</div>';





$basket_info_text .= '		</div>';
$basket_info_text .= '	</div>';
/*
	$basket_info_text = '<a class="kosik" href="'.URL_HOME.'basket" title="' . $translator->prelozitFrazy("prejit_do_kosiku") . '">';
	$basket_info_text .= $translator->prelozitFrazy("polozek_v_kosiku") . ': <strong>' . $basketController->total . '</strong>, ' . $translator->prelozitFrazy("cena") . ': <strong>' . numberFormat($basketController->getCelkovaCena(),0). '</strong>&nbsp;' . MENA . '';
	$basket_info_text .= '</a>';*/
}

$data["html"] = $basket_info_text;
$data["count"] = $basketController->total;
$data["price"] = numberFormat($basketController->getCelkovaCena(), 0);


$json = json_encode($data);
print_r($json);

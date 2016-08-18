<?php
/**
 * Voláno z init.php na konci
 * */

/*
if (isset($_POST["notice"])) {
	$_SESSION['notice'] = $_POST["notice"];
	$not = new G_Html();
	$not->goBackRef();
}
// Drží náhodné řazení v seanci uživatele
$rand = "";
if (isset($_SESSION["rand"])) {
	$rand = $_SESSION['rand'];
}
if (empty($rand)) {
	srand((float)microtime()*1000000);
	//	$rand = "0.".rand();
	$rand = rand();
	$_SESSION['rand'] = $rand;
}
*/
define('PATH_IMG', dirname(__FILE__).'/../public/foto/');
define('URL_IMG', URL_HOME2. 'public/foto/');

define('PATH_DATA', dirname(__FILE__).'/../public/data/');
define('URL_DATA', URL_HOME2 . 'public/data/');



//include PATH_ROOT.'core/library/GoogleMaps/googlemap.php';

//$basketController = new BasketController();
//$basketlist = $basketController->basketList();
//include PATH_ROOT.'secret/Humboldt.class.php';
//$Hmbldt = new Humboldt();
//$adsController = new AdsController();
$imageController = new ImageController();



$translator = G_Translator::instance();
?>
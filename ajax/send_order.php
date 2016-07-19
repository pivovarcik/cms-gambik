<?php
/**
 * Add song my favorite
 * */
session_start();
/*
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
*/
define('PATH_ROOT2', dirname(__FILE__));


require_once PATH_ROOT2.'/../inc/init_spolecne_lite.php';
if (isset($_GET["id"]) && is_numeric($_GET["id"]))
{
	/**/
		/*
		   error_reporting(E_ERROR);
		   error_reporting(E_ALL);
		   ini_set("display_errors", 1);
		*/
	require_once PATH_ROOT . "core/controller/OrderController.php";
	require_once PATH_ROOT . "core/controller/EshopController.php";
	require_once PATH_ROOT . "core/controller/TranslatorController.php";
	require_once PATH_ROOT . "core/library/Gambik/G_Translator.php";

	$orderController = new OrderController();

	$orders = $orderController->getOrder($_GET["id"]);

	$urlOrderPdf = $orderController->createPDF($_GET["id"]);

	$odeslano = $orderController->sendEmailZakaznik($orders->shipping_email);

	$odeslano2 = $orderController->sendInfoEmail();

	//print "Odesláno na: " . $orders->shipping_email;
	header("Location:  /" . $languageModel->lang_url . "dokonceno?hash=" . urlencode(gcode($urlOrderPdf)), true, 303);
//	print gdecode(gcode($urlOrderPdf));
	exit;
	// We'll be outputting a PDF
	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="'.basename($urlOrderPdf).'"');
	header("Content-Transfer-Encoding: binary");
	ob_clean();
	flush();
	// The PDF source is in original.pdf
	readfile($urlOrderPdf);

//	print $urlOrderPdf;
//	fopen($urlOrderPdf);
	exit('<meta http-equiv="refresh" content="0; url=' . urldecode("/" . $languageModel->lang_url . "dokonceno") . '"/>');
	//print	$orderController->createPDF($_GET["id"],"I");

} else {
	exit();
}?>
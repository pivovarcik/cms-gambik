<?php
/**
 * Add song my favorite
 * */
session_start();
define('PATH_ROOT2', dirname(__FILE__));
	require_once PATH_ROOT2.'/../inc/init_spolecne.php';

if  (isset($_GET["h"]) && !empty($_GET["h"]) && file_exists(gdecode(urldecode($_GET["h"]))))
{

	$urlOrderPdf = gdecode(urldecode($_GET["h"]));
	header('Content-type:application/pdf');
	header('Content-Disposition: attachment; filename="'.basename($urlOrderPdf).'"');
	header("Content-Transfer-Encoding: binary");
	ob_clean();
	flush();
	// The PDF source is in original.pdf
	readfile($urlOrderPdf);

} else {
	exit();
}?>
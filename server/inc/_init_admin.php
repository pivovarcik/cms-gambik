<?php
define('ADMIN', 'YES');
session_start();
header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache');
header('Pragma: nocache');
header('Access-Control-Allow-Origin: *');
define("LANG_TRANSLATOR","cs");
define('PATH_PRG', dirname(__FILE__).'/../admin/prg/');
//define('URL_HOME', "/admin/");   // pro Url
//define('URL_HOME_REL', "/admin/");   // pro Url
define('PATH_TEMP', dirname(__FILE__).'/../admin/template/');
include dirname(__FILE__) . "/init_spolecne.php";

define('URL_HOME_SITE', $settings->get("URL_HOME_REL"));   // pro Url
//define('PATH_TEMP', PATH_ROOT . 'admin/template/');
//error_reporting(E_ALL);

//print_r($_SERVER);
if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
//print "Location: " . URL_HOME . "login.php";
	error_reporting(E_ALL);
	header("Location: " . URL_HOME_SITE . "login.php?redirect=".$_SERVER["REQUEST_URI"]);
	exit();
} else {
  define('LOGIN_STATUS', 'ON');
}

// registrovaný uživatel - blokace do hlavní administrace
if ($GAuth->getRoleParam10() == 0)
{
	print "Do této nabídky nemáte oprávnění přístupu.";
	exit;

}


$GHtml = new G_Html();
$TreeMenu = new TreeMenu("syscategory");
$TreeMenu->setUserUrlQuery();

if (isMobile()){
	$GHtml->setServerCss(URL_HOME . "admin_mobil.css");
} else {
	$GHtml->setServerCss(URL_HOME_SITE . "style/font-awesome/css/font-awesome.min.css");
}

$GHtml->setCokolivToHeader("<meta name=\"viewport\" content=\"width=device-width\">");
$GHtml->setCokolivToHeader('<script>var UrlBase = "' . URL_HOME_SITE . '"</script>');

$GHtml->setServerCss(URL_HOME_SITE . "js/jquery-ui-timepicker-addon.css");
$GHtml->setServerCss(URL_HOME_SITE . "js/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.min.css");

$GHtml->setServerCss(URL_HOME_SITE . "js/bootstrap/bootstrap.min.css");
$GHtml->setServerCss(URL_HOME_REL . "style/admin.css");
$GHtml->setServerCss(URL_HOME_SITE . "js/sb-admin/sb-admin-2.css");
$GHtml->setServerCss(URL_HOME_SITE . "js/select2/select2.min.css");
$GHtml->setServerCss(URL_HOME_SITE . "js/select2/select2-bootstrap.css");

//v1.11.1
$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/jquery-ui-1.10.4/js/jquery-ui-1.10.4.min.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/bootstrap/bootstrap.min.js");

$GHtml->setServerJs(URL_HOME_SITE . "js/sb-admin/sb-admin-2.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/sb-admin/plugins/metisMenu/metisMenu.min.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/select2/select2.full.min.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/select2/cs.js");

$GHtml->setServerJs(URL_HOME_SITE . "js/jquery-ui-timepicker-addon.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.ui.timepicker-cs.js");

// lokalizace CS UI datapicker
$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.ui.datepicker-cs.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.slimscroll.min.js");


$GHtml->setServerJs(URL_HOME_SITE . "admin/js/sidebar.js");

$GHtml->setServerJs(URL_HOME_SITE . "js/tinymce/tinymce.min.js");


//$GHtml->setServerJs("/js/colorbox/jquery.colorbox-min.js");
$GHtml->setServerJs(URL_HOME_REL . "js/admin.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/DataPicker.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/DataGridProvider.js");

$GHtml->setServerJs(URL_HOME_SITE . "js/fancybox/source/jquery.fancybox.js");
$GHtml->setServerCss(URL_HOME_SITE . "js/fancybox/source/jquery.fancybox.css");

$GHtml->setServerJs(URL_HOME_SITE . "js/SWFUpload/swfupload/swfupload.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/SWFUpload/js/swfupload.queue.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/SWFUpload/js/fileprogress.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/SWFUpload/js/handlers.js");

// vrací page_id
$TreeMenu->getPageIdFromQuery();

$TreeMenu->page_id = $TreeMenu->page_id == 0 ? MENU_ROOT_ID : $TreeMenu->page_id;
define("PAGE_ID",$TreeMenu->page_id);

if (isset($_GET['item']))
{
	require_once PATH_PRG . 'clanek.php';
	return;
} elseif (isset($_GET['cat']) && !is_array($_GET['cat']))
{
	if (file_exists(PATH_PRG . $_GET['cat'] . '.php')){

		require_once  PATH_PRG . $_GET['cat'] . '.php';
	} else
	{

		require_once PATH_PRG . 'clanky.php';
	}
	return;
}


if (isset($_GET['url']) && !empty($_GET['url']))
{
	$pole_url = explode('/', $_GET['url']);
	$prvni = $pole_url[0];
	$posledni = $pole_url[count($pole_url)-1];
	if(empty($posledni))
	{
		$posledni = $prvni;
	}
	//print $posledni;
	if (file_exists(PATH_PRG . $posledni.'.php')){
		require_once PATH_PRG . $posledni. '.php';
	}
	elseif (file_exists(PATH_ROOT . "application/admin/" . $posledni.'.php'))
	{
		require_once PATH_ROOT . "application/admin/" . $posledni. '.php';
	}

	else {
		if (PAGE_ID == 1 && !empty($_GET["url"]) && $_GET["url"] != "root")
		{
			//print "Stránka neexistuje";
			require_once PATH_PRG . '404.php';
			exit;
		}
		require_once PATH_PRG . 'clanky.php';
	}
	return;
} else
{

		require_once PATH_PRG . 'main.php';


}


?>
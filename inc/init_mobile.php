<?php
//ini_set("session.cookie_domain",".sexvemeste.cz");
session_start();
//setcookie(session_name(), $_COOKIE[session_name()], 0, "/");
header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache');
header('Pragma: nocache');

//print "Test: " . print_r($_SESSION);
//print "Test: " . print_r($_COOKIE);
include dirname(__FILE__) . "/init_spolecne_mobile.php";

define('MENU_ROOT_ID', $g->setting["MENU_ROOT_ID"]);
$TreeMenu = new TreeMenu();

$TreeMenu->getPageIdFromQuery();
$TreeMenu->page_id = $TreeMenu->page_id == 0 ? MENU_ROOT_ID : $TreeMenu->page_id;
define("PAGE_ID",$TreeMenu->page_id);

//print PAGE_ID;

define('PATH_TEMP', PATH_ROOT . 'template/');




$g->set_server_css($g->setting["SERVER_CSS"]);

$g->set_server_js($g->setting["SERVER_JS"]);
if (!$g->validIp())
{
	print "Správce Vám zakázal přístup na tyto stránky.";
	exit();
}

if (!$userController->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
} else {
  define('LOGIN_STATUS', 'ON');
}


$g->server_css_A = array("http://www3.karapneu.cz/public/style/mobile.css",
);
$g->server_js_A = array("https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js",
"http://www.sexvemeste.cz/public/js/svm_mobile.js",);
/*

$g->server_js_A = array("https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js",
"http://www.sexvemeste.cz/public/js/svm2.js",
"http://www.sexvemeste.cz/js/StickyScroller/StickyScroller.min.js",
"http://www.sexvemeste.cz/js/StickyScroller/GetSet.js",
"http://www.sexvemeste.cz/public/js/slides/slides.min.jquery.js",
"http://www.sexvemeste.cz/js/colorbox-1.3.18/colorbox/jquery.colorbox.js",
"http://www.sexvemeste.cz/public/js/colorbox.js",
);
}
*/
/*
//print $treemenu_uzitecne;
$page = "catalog";
require_once $g->get_page($page);
					 //return;
	return;       */
if (isset($_GET['item']))
{

	//print "tudy" . $_GET['item'];
	require_once PATH_PRG . 'clanek.php';
	return;
} elseif (isset($_GET['cat']))
{
  if (file_exists(PATH_PRG . $_GET['cat'] . '.php')){

		require_once  PATH_PRG . $_GET['cat'] . '.php';
  } else
  {

  	if ($_SERVER["REMOTE_ADDR"] == "90.177.76.16" || $_SERVER["REMOTE_ADDR"] == "90.176.2.39" || $_SERVER["REMOTE_ADDR"] == "109.80.162.56" || $_SERVER["REMOTE_ADDR"] == "85.71.106.193") {

  		require_once PATH_PRG . 'clanky2.php';
  	} else {
  		require_once PATH_PRG . 'clanky.php';
  	}


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
	if ($prvni=="catalog")
	{
		//print "Hledání v katalogu.";
		require_once PATH_PRG . $prvni. '.php';
		return;
	}

	if ($prvni=="podnik")
	{
		//print "Hledání v katalogu.";
		require_once PATH_PRG. 'podnik_mobile.php';
		return;
	}

	if ($prvni=="search")
	{
		//print "Hledání v katalogu.";
		require_once PATH_PRG. 'search_mobile.php';
		return;
	}

	if ($prvni=="divka")
	{
		//print "Hledání v katalogu.";
		require_once PATH_PRG. 'divka_mobile.php';
		return;
	}

	if (strtolower($prvni)=="kristalove-lustry-katalog" && isset($_GET['id']))
	{
		//print "Hledání v katalogu.";
		require_once PATH_PRG . 'product.php';
		return;
	}
	if (strtolower($prvni)=="eshop" && isset($_GET['id']))
	{
		//print "Hledání v katalogu.";
		require_once PATH_PRG . 'product.php';
		return;
	}
	if ($prvni=="product")
	{
    //print "Hledání v produktech.";
    require_once PATH_PRG . $prvni. '.php';
    return;
	}

	//print $posledni;
	if (file_exists(PATH_PRG . $posledni.'.php')){
    require_once PATH_PRG . $posledni. '.php';
  }
  else {
  	/*
  	if ($_SERVER["REMOTE_ADDR"] == "90.177.76.16" || $_SERVER["REMOTE_ADDR"] == "90.176.2.39" || $_SERVER["REMOTE_ADDR"] == "109.80.162.56" || $_SERVER["REMOTE_ADDR"] == "85.71.106.193") {
		require_once PATH_PRG . 'clanky2.php';

  	} else {
  		require_once PATH_PRG . 'clanky.php';
  	}
  	*/
  	require_once PATH_PRG . 'clanky_mobile.php';

	}
	return;
} else
{
	/*
	if (isset($u->uid_user))
	{
    $page = $_GET['pg'];
	} else
	{
    $page = "";
	}
	*/
/*
	if ($_SERVER["REMOTE_ADDR"] == "90.177.76.16" || $_SERVER["REMOTE_ADDR"] == "90.176.2.39" || $_SERVER["REMOTE_ADDR"] == "109.80.162.56" || $_SERVER["REMOTE_ADDR"] == "85.71.106.193") {

		require_once PATH_PRG . 'main2.php';
	} else {
		require_once $g->get_page($page);
	}
	*/

	require_once PATH_PRG . 'main_mobile.php';

}

?>

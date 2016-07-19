<?php

//print "test3";

//ini_set("session.cookie_domain",".sexvemeste.cz");
session_start();
//setcookie(session_name(), $_COOKIE[session_name()], 0, "/");
/**/
header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache');
header('Pragma: nocache');


//print "Test: " . print_r($_SESSION);
//print "Test: " . print_r($_COOKIE);
define('PATH_PRG', dirname(__FILE__).'/../admin2/prg/');
define('URL_HOME', "/admin2/");   // pro Url
define('URL_HOME_REL', "/admin2/");   // pro Url
include dirname(__FILE__) . "/init_spolecne.php";



if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
	//print "Location: " . URL_HOME . "login.php";
	header("Location: /login.php");
	exit();
} else {
	define('LOGIN_STATUS', 'ON');
}
if (!$g->validIp())
{
	print "Správce Vám zakázal přístup na tyto stránky.";
	exit();
}
$TreeMenu = new TreeMenu("syscategory");
// vrací page_id

$cat_id = isset($cat->id) ? $cat->id : "";
$TreeMenu->getMenu(array(
	"start_uroven"=>MENU_ROOT_ID,
	"rozbalit_vse"=>true,
	"select_uroven"=>$cat_id,
	"class_ul_selected"=>"",
	"class_ul_noselected"=>"",
	"max_vnoreni"=>100
));
/**/

$TreeMenu->page_id = $TreeMenu->page_id == 0 ? MENU_ROOT_ID : $TreeMenu->page_id;
define("PAGE_ID",$TreeMenu->page_id);

//print PAGE_ID;

define('PATH_TEMP', dirname(__FILE__).'/../admin2/template/');


//	print "a:".$_GET['url'];
//print "test2";

$g->set_server_css(URL_HOME . "style/default.css");


$g->set_server_js("http://code.jquery.com/jquery-latest.min.js");
$g->set_server_js(URL_HOME . "js/main.js");

$GHtml = new G_Html();
$GHtml->setServerJs("http://code.jquery.com/jquery-latest.min.js");
$GHtml->setServerJs(URL_HOME . "js/main.js");
$GHtml->setServerCss(URL_HOME . "style/default.css");

//$g->set_server_js($g->setting["SERVER_JS"]);


if (USER_ROLE_ID <> 2)
{
	print "Do této nabídky nemáte oprávnění přístupu.";
	exit;
}

//print_r($_GET);

//print "test3";
//exit;
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
	/*if ($prvni=="projekty")
	   {
	   //print "Hledání v katalogu.";
	   require_once PATH_PRG . $prvni. '.php';
	   return;
	   }*/



	//print $posledni;
	if (file_exists(PATH_PRG . $posledni.'.php')){
		require_once PATH_PRG . $posledni. '.php';
	} else {
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

	require_once PATH_PRG . 'main.php';

}

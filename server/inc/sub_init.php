<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$cesta = substr($_SERVER["HTTP_HOST"], 0, strrpos($_SERVER["PHP_SELF"], "/"));
//print "Přesměrování:" . $cesta;
$host = explode(".",$_SERVER["HTTP_HOST"]);
//print_r($_SERVER);
//exit;
if (isset($_GET["ses"])) {

	//session_id($_GET["ses"]);
	$key = "sub";
	setcookie($key, $_GET["ses"]);
}

if (isset($_COOKIE["sub"])) {
	session_id($_COOKIE["sub"]);
} else {
	print '<meta content="0; URL= http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '" http-equiv="Refresh">';
?>
<img height="1" width="1" src="http://www.sexvemeste.cz/session.php?sub=<?php print $host[0]; ?>">
<?php
	exit;
	//header("Location: http://".$_SERVER["HTTP_HOST"] . "" . $_SERVER["REQUEST_URI"]);
}
session_start();
header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache');
header('Pragma: nocache');

if (isset($_GET["ses"])) {

	//session_id($_GET["ses"]);
	$key = "sub";
	setcookie($key, $_GET["ses"]);
}
//print "Test: " . print_r($_SESSION);
//print "Test: " . print_r($_COOKIE);
include dirname(__FILE__) . "/init_spolecne.php";
define('PATH_TEMP', PATH_ROOT . 'template/');



define('MENU_ROOT_ID', $g->setting["MENU_ROOT_ID"]);
$g->set_server_css($g->setting["SERVER_CSS"]);

$g->set_server_js($g->setting["SERVER_JS"]);
if (!$g->validIp())
{
	print "Správce Vám zakázal přístup na tyto stránky.";
	exit();
}
/*
if (!$u->validLogIn())
{
	define('LOGIN_STATUS', 'OFF');

	@header("Location: " . URL_HOME . "login.php");
	exit();
} else {
  define('LOGIN_STATUS', 'ON');
}
				 */
if (!$userController->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
} else {
  define('LOGIN_STATUS', 'ON');
}
/*
if (isset($u->uid_user))
{
	$g->referer(array('uid_user'=>$u->uid_user));
} else
{
	$g->referer();
}
*/

/*

include PATH_ROOT.'library/Gambik/G_Registry.php';
$registry = GambikFrameworkRegistry::singleton();
$registry->getURLData();


// uložení základních objektů do registru
$registry->storeObject('Sql', 'db');

// vytvoř spojení s databází
$registry->getObject('db')->spojit();

//$registry->getObject('db')->query('SELECT controller FROM controllers WHERE active=1');

//$urlBits = $registry->getURLBits();
//print_r($urlBits);
$currentController = 'Foto';
require_once(PATH_ROOT . 'application/controller/' . $currentController . 'Controller.php');

$controllerInc = $currentController.'Controller';
$controller = new $controllerInc( $registry, true );


*/

/*
//if ($g->IsMobile()){
	include PATH_ROOT.'inc/Busy.class.php';
	$bus = new Busy();
	//require_once PATH_PRG . 'mobil.php';
	//exit();
//}   */

// Voláno na konci inicializace
// Např. Pro instancování vlastních knihoven
//$bus = new Busy();


define('MENU_ROOT_ID', $g->setting["MENU_ROOT_ID"]);
$TreeMenu = new TreeMenu();
// vrací page_id
$TreeMenu->getMenu(array(
	"start_uroven"=>MENU_ROOT_ID,
	"rozbalit_vse"=>true,
	"select_uroven"=>$cat->id,
	"class_ul_selected"=>"",
	"class_ul_noselected"=>"",
	"max_vnoreni"=>100
));


$TreeMenu->page_id = $TreeMenu->page_id == 0 ? MENU_ROOT_ID : $TreeMenu->page_id;
define("PAGE_ID",$TreeMenu->page_id);



//print_r($_SERVER);
//print_r($_GET);
$subdomain = str_replace(".sexvemeste.cz", "",$_SERVER["HTTP_HOST"] );
//print $subdomain;

if (isset($_GET["f"])) {
	require_once  PATH_PRG . 'firma_foto.php';
} elseif (isset($_GET["s"])) {
	require_once  PATH_PRG . 'firma_sluzby.php';
} elseif (isset($_GET["d"])) {
	require_once  PATH_PRG . 'firma_divky.php';
} elseif (isset($_GET["k"])) {
	require_once  PATH_PRG . 'firma_kontakt.php';
} else {
	require_once  PATH_PRG . 'firma.php';
}

?>

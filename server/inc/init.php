<?php
if (isset($_GET['imgresize']))
{

  //print $_GET['imgresize'];
    $imageController = new ImageController();
    $imageController->printImg($_GET['imgresize']);
	exit();    

}

   
if (isset($_GET['robotstxt']))
{

print "User-agent: * " . PHP_EOL ; 
  
print "Robot-version:2.0
Disallow:
Request-rate: 30/1m 1500-0559
Sitemap: " . URL_HOME . "sitemap.xml";

	exit();    
} /* */

if (VERSION_RS != $settings->get("VERSION_RS"))
{
	print "<h1>Probíhá Inicializace systému.</h1>";
	print "Chyba! Byl zjištěn konflikt verzí! Nelze pokračovat.<br />";
	print VERSION_RS . " <> " . $settings->get("VERSION_RS") ."<br />";
	print "Obraťte se na správce systému.<br />";

	exit();
}

if ($_SERVER["REQUEST_URI"]=="/" && count($activeLanguageList) > 1) {
	@header("Location: ".URL_HOME, true, 303);
}
$isMobile = isMobile();

if ($isMobile) {

}
// vypnuto nyní
$isMobileDisabled = isset($_GET["m"]) && $_GET["m"] == 0 ? true : false;

// vypnuto historicky
$isMobileDisabled = isset($_COOKIE["nomobile"]) ? true : $isMobileDisabled;

// Mobilní zařízení + vypnuta mobilní verze
$GHtml = new G_Html();
if ($isMobile && !$isMobileDisabled)
{
	// zapamatuju si vypnutí mobilní verze
	$GHtml->setCookie("nomobile", 1);
}

$TreeMenu = new TreeMenu();
// vrací page_id
//$stopky = new GStopky();
//$stopky->start();
$cat_id = isset($cat->id) ? $cat->id : "";


$TreeMenu->getPageIdFromQuery();
/**/
//print $stopky->konec();
/**/

$TreeMenu->page_id = $TreeMenu->page_id == 0 ? MENU_ROOT_ID : $TreeMenu->page_id;
define("PAGE_ID",$TreeMenu->page_id);

//	print PAGE_ID;

//define('PATH_TEMP', PATH_ROOT . 'template/');



if ($settings->get("FOOTER_JS") == "1") {
	$GHtml->setJsIncludeToFooter();
}
$GHtml->setServerJs($settings->get("SERVER_JS"));
$GHtml->setServerJsFooter($settings->get("SERVER_JS_FOOT"));


if ("1" == $settings->get("MODUL_ESHOP"))
{
	$GHtml->setServerCss(URL_HOME_SITE . "js/bootstrap/bootstrap.min.css");

	$GHtml->setServerCss(URL_HOME_SITE . "style/shopbase.php?id=" . $eshopSettings->get("ESHOP_TEMPLATE"));

}
$GHtml->setServerCss($settings->get("SERVER_CSS"));






/*
if (!$g->validIp())
{
	print "Správce Vám zakázal přístup na tyto stránky.";
	exit();
}*/

if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
} else {
  define('LOGIN_STATUS', 'ON');
}

if ("1" == $settings->get("MODUL_ESHOP"))
{
// Inisicalizuji košík až po loginu, jinak se načetl špatně košíK !!
	$basketController = new BasketController();
	//$basketController->desetinna_mista = 0;
//	$basketlist = $basketController->basketList();
//	$GHtml->setServerCss("/js/bootstrap/bootstrap.min.css");

//	$GHtml->setServerCss("/style/shopbase.php?id=" . $eshopSettings->get("ESHOP_TEMPLATE"));
	$GHtml->setServerJsFooter(URL_HOME_SITE . "js/bootstrap/bootstrap.min.js");
	$GHtml->setServerJsFooter(URL_HOME_SITE . "js/eshop.js");
}

//print_r($_GET);
$GHtml->audit();



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


  if (strtolower($prvni)=="gdpr" && isset($_GET['m']) && isset($_GET['hash']))
	{
		
    print "Byli jste prihlaseni k odberu novinek";
    //print "Hledání v katalogu.";
		//require_once PATH_PRG . 'product.php';
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
		exit;
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

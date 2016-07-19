<?php


ini_set("display_errors", 1);
error_reporting(E_ERROR);
//error_reporting(E_ALL);

if( ! ini_get('date.timezone') )
{
	//	date_default_timezone_set('GMT');
	date_default_timezone_set('Europe/Prague');
}

$start_app = explode(" ", microtime());
$start_app = $start_app[1] + $start_app[0];
$rd = "10000"; // zaokrouhlování
define('START_APPLICATION',$start_app);

define('VERSION_RS','4.994');
define('SERVER_CHARSET','utf-8');


define('PATH_ROOT', dirname(__FILE__).'/../');

if (!defined("PATH_PRG"))
{
	define('PATH_PRG', PATH_ROOT . 'prg/');
}


/*
   define('PHP_EOL','
   ');
*/
define('PHP_TAB','  ');
define('PATH_TEMPLE', PATH_ROOT . 'template/');

//include PATH_ROOT.'inc/Zakl.class.php';
//include PATH_ROOT.'inc/Gambik.class.php';
include PATH_ROOT.'inc/XML.class.php';
include PATH_ROOT.'inc/class.pop3.php';
include PATH_ROOT.'inc/class.smtp.php';
include PATH_ROOT.'inc/class.phpmailer.php';

// Spojení si nyní mapuju, aby se dalo lépe aktualizovat
include PATH_ROOT.'secret/before_init.php';
define('SERVER_COPYRIGHT','Gambik ('.VERSION_RS.') - www.pivovarcik.cz');
include PATH_ROOT.'inc/Sql.class.php';
/*====================================================
   ZAVADENI INSTANCI KNIHOVEN
   ====================================================*/


function autoLoader($path = null)
{
	if ($path == null)
	{
		$path = dirname(__FILE__);
	}

	if ($handle = opendir ($path))
	{
		while (false !== ($file = readdir($handle)))
		{

			if (substr($file,-4) == ".php")
			{
				//print "AutoLoader2: " . $file . "<br />";
				//        include $path . $file;
				require_once $path . $file;
			}
		}
	}
}

class GStopky{

	private $start_time;
	private $end_time;
	public function start()
	{
		$start_app2 = explode(" ", microtime());
		$this->start_time = $start_app2[1] + $start_app2[0];
	}

	public function konec()
	{
		$end_app2 = explode(" ", microtime());

		$this->end_time = ($end_app2[1] + $end_app2[0]);
		$rd = "10000"; // zaokrouhlovĂˇnĂ­
		return ((round(($this->end_time - $this->start_time) * $rd)) / $rd) . "sec";
	}
}
autoLoader(PATH_ROOT . "core/template/");
$stopky = new GStopky();


// Library
autoLoader(PATH_ROOT . "core/library/Gambik/Function/");
autoLoader(PATH_ROOT . "core/library/Gambik/Controller/");
autoLoader(PATH_ROOT . "core/library/Gambik/");



// Jádro
$stopky->start();

autoLoader(PATH_ROOT . "core/entity/");
autoLoader(PATH_ROOT . "core/form/");
autoLoader(PATH_ROOT . "core/controller/");
autoLoader(PATH_ROOT . "core/models/");

//$settings = new SettingsController();

$settings = G_Setting::instance();
if ("1" == $settings->get("MODUL_ESHOP"))
{
	$eshopSettings = G_EshopSetting::instance();
	define("MENA",$eshopSettings->get("MENA"));
}
/*
   Přesunuto do INIT
   if (VERSION_RS != $settings->get("VERSION_RS"))
{
	print "<h1>Probíhá Inicializace systému.</h1>";
	print "Chyba! Byl zjištěn konflikt verzí! Nelze pokračovat.<br />";
	print VERSION_RS . " <> " . $settings->get("VERSION_RS") ."<br />";
	print "Obraťte se na správce systému.<br />";

	exit();
}*/

//$g = new Gambik();

//print $stopky->konec();
// Aplikace
/**/
autoLoader(PATH_ROOT . "application/template/");
autoLoader(PATH_ROOT . "application/entity/");
autoLoader(PATH_ROOT . "application/controller/");
autoLoader(PATH_ROOT . "application/form/");
autoLoader(PATH_ROOT . "application/models/");

$userController = new UserController();
$GAuth = G_Authentification::instance();

// načtu aktivní jazyky
$languageModel = new models_Language();
$languageModel->initLanguage();

$activeLanguageList = $languageModel->activeLanguageCodeList;
$languageList = $languageModel->languageList;

//print_r($activeLanguageList);
// musí být až za inicializací jazyků. jinak nelze použít košík, nevidel URL_HOME


define('DEFAULT_LIMIT',$settings->get("DEFAULT_LIMIT"));

$translator = G_Translator::instance();
//$g->GoBackHandler();

// podpora pro admin prostředí
if (defined("ADMIN"))
{
	define('URL_HOME', $settings->get("URL_HOME") . "admin/");   // pro Url
	define('URL_HOME_REL', $settings->get("URL_HOME_REL") . "admin/");   // pro Url
} else {
	if (count($activeLanguageList) > 1) {

		if (!defined("URL_HOME"))
		{
			define('URL_HOME', $settings->get("URL_HOME") . $languageModel->lang_url);   // pro Url
		}
		if (!defined("URL_HOME_REL"))
		{
			define('URL_HOME_REL', $settings->get("URL_HOME_REL"). $languageModel->lang_url);
		}

	} else {
		if (!defined("URL_HOME"))
		{
			define('URL_HOME', $settings->get("URL_HOME"));   // pro Url
		}
		if (!defined("URL_HOME_REL"))
		{
			define('URL_HOME_REL', $settings->get("URL_HOME_REL"));
		}
	}

	define('URL_HOME2', $settings->get("URL_HOME_REL"));   // pro Url
}

include PATH_ROOT.'secret/after_init.php';


define('MENU_ROOT_ID', $settings->get("MENU_ROOT_ID"));


define('SERVER_KEYWORDS', $settings->get("SERVER_KEYWORDS"));
define('SERVER_NAME', $settings->get("SERVER_NAME"));             // pro Zobrazení
define('SERVER_DESCRIPTION', $settings->get("SERVER_DESCRIPTION"));
define('SERVER_TITLE', $settings->get("SERVER_TITLE"));
define('URL_DOMAIN', $settings->get("URL_DOMAIN"));   // pro Url
//define('SERVER_LANG', $g->get("SERVER_LANG"));
define('VERSION_DATE', $settings->get("VERSION_DATE"));
define('INSTALL_DATE', $settings->get("INSTALL_DATE"));
define('SERVER_ROBOTS', $settings->get("SERVER_ROBOTS"));
define('SERVER_GOOGLEBOT', $settings->get("SERVER_GOOGLEBOT"));
define('SERVER_AUTHOR', $settings->get("SERVER_AUTHOR"));
define('PAGETITLE_PREFIX', $settings->get("PAGETITLE_PREFIX"));


define('VERSION_CATEGORY', $settings->get("VERSION_CATEGORY"));
define('VERSION_POST', $settings->get("VERSION_POST"));
define('VERSION_CATALOG', $settings->get("VERSION_CATALOG"));
define('VERSION_PRODUCT', $settings->get("VERSION_PRODUCT"));




define('MAX_WIDTH',$settings->get("MAX_WIDTH"));
define('MAX_HEIGHT',$settings->get("MAX_HEIGHT"));
define('PATH_WATERMARK',constToText($settings->get("PATH_WATERMARK")));//PATH_ROOT . "watermark.gif"
define('WATERMARK_POS',($settings->get("WATERMARK_POS")));



//print PATH_ROOT . "watermark.gif";
define('IMAGE_EXTENSION_WHITELIST',$settings->get("IMAGE_EXTENSION_WHITELIST"));
define('DATA_EXTENSION_WHITELIST',$settings->get("DATA_EXTENSION_WHITELIST"));

define('FACEBOOK_API_ID', $settings->get("FACEBOOK_API_ID"));
define('FACEBOOK_SECRET', $settings->get("FACEBOOK_SECRET"));

if ($settings->get("IS_RESPONSIVE") == "1") {
	define('IS_RESPONSIVE', $settings->get("IS_RESPONSIVE"));
}

if (!defined("URL_IMG"))
{
	define('URL_IMG', URL_HOME2 . 'foto/');
}
if (!defined("PATH_IMG"))
{
	define('PATH_IMG', dirname(__FILE__).'/../foto/');
}

if (!defined("IMP_DIRECTORY"))
{
	define('IMP_DIRECTORY', dirname(__FILE__).'/../log/');
}


if (!defined("URL_DATA"))
{
	define('URL_DATA', URL_HOME2 . 'public/data/');
}

if (!defined("PATH_DATA"))
{
	define('PATH_DATA', PATH_ROOT . 'public/data/');
}

// TODO staré vyhodit
define('PATH_THUMBS', PATH_IMG . 'thumbs/');
define('URL_THUMBS', URL_IMG . 'thumbs/');
define('URL_IMAGE', URL_HOME . 'img/smiles/');
define('TRANSACTION_PAGE', URL_HOME . 'admin/transaction.php');

	define('SERVER_FAVICON', $settings->get("SERVER_FAVICON"));



?>

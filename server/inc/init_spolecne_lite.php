<?php
error_reporting(E_ERROR);
//error_reporting(E_ALL);
ini_set("display_errors", 1);
$start_app = explode(" ", microtime());
$start_app = $start_app[1] + $start_app[0];
$rd = "10000"; // zaokrouhlování
define('START_APPLICATION',$start_app);

define('VERSION_RS','4.79');
define('SERVER_CHARSET','utf-8');
define('SERVER_COPYRIGHT','Gambik ('.VERSION_RS.') - www.pivovarcik.cz');

define('PATH_ROOT', dirname(__FILE__).'/../');
define('PATH_PRG', PATH_ROOT . 'prg/');
/*
   define('PHP_EOL','
   ');
*/
define('PHP_TAB','  ');
define('PATH_TEMPLE', PATH_ROOT . 'template/');

include PATH_ROOT.'inc/Zakl.class.php';
//include PATH_ROOT.'inc/Gambik.class.php';
//include PATH_ROOT.'inc/Users.class.php';
//include PATH_ROOT.'inc/Eshop.class.php';
//include PATH_ROOT.'inc/Product.class.php';
include PATH_ROOT.'inc/XML.class.php';
include PATH_ROOT.'inc/class.pop3.php';
include PATH_ROOT.'inc/class.smtp.php';
include PATH_ROOT.'inc/class.phpmailer.php';
//include PATH_ROOT.'core/library/Captcha/captcha.php';

// Spojení si nyní mapuju, aby se dalo lépe aktualizovat
include PATH_ROOT.'secret/before_init.php';
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

// Library
autoLoader(PATH_ROOT . "core/library/Gambik/Function/");
autoLoader(PATH_ROOT . "core/library/Gambik/Controller/");
autoLoader(PATH_ROOT . "core/library/Gambik/");

// Jádro
autoLoader(PATH_ROOT . "core/template/");
autoLoader(PATH_ROOT . "core/entity/");
autoLoader(PATH_ROOT . "core/form/");
autoLoader(PATH_ROOT . "core/controller/");
autoLoader(PATH_ROOT . "core/models/");


// Aplikace
autoLoader(PATH_ROOT . "application/entity/");
autoLoader(PATH_ROOT . "application/controller/");
autoLoader(PATH_ROOT . "application/form/");
autoLoader(PATH_ROOT . "application/models/");

$userController = new UserController();
$GAuth = G_Authentification::instance();


if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
	//print "Location: " . URL_HOME . "login.php";
	//header("Location: " . URL_HOME . "login.php");
	//exit();
} else {
	define('LOGIN_STATUS', 'ON');
}


// načtu aktivní jazyky
$languageModel = new models_Language();
$languageModel->initLanguage();

$activeLanguageList = $languageModel->activeLanguageCodeList;
$languageList = $languageModel->languageList;


// musí být až za inicializací jazyků. jinak nelze použít košík
//include PATH_ROOT.'secret/after_init.php';
/*
   $languageList = $languageModel->getActiveLanguage();
   $activeLanguageList = array();
   foreach ($languageList as $key => $val)
   {
   $activeLanguageList[] = $val->code;
   }
*/
//$g->GoBackHandler();

/*
   $lang_url =  "";
   if (isset($_GET["lang"]) && in_array($_GET["lang"], $activeLanguageList)) {
   //LANG_TRANSLATOR = $_GET["lang"];
   if (!defined("LANG_TRANSLATOR"))
   {
   define('LANG_TRANSLATOR', $_GET["lang"]);
   $lang_url = LANG_TRANSLATOR . "/";
   }
   } else {
   if (!defined("LANG_TRANSLATOR"))
   {
   define('LANG_TRANSLATOR', $activeLanguageList[0]);
   //$lang_url = LANG_TRANSLATOR . "/";
   }
   }
*/
//print LANG_TRANSLATOR;

//print "Moje ID" . PAGE_ID . "<br />";
//$g->setTranslator();
define('URL_HOME', $g->setting["URL_HOME"] . $languageModel->lang_url);   // pro Url
define('URL_HOME2', $g->setting["URL_HOME"]);   // pro Url



define('MENU_ROOT_ID', $g->setting["MENU_ROOT_ID"]);

define('SERVER_KEYWORDS', $g->setting["SERVER_KEYWORDS"]);
define('SERVER_NAME', $g->setting["SERVER_NAME"]);             // pro Zobrazení
define('SERVER_DESCRIPTION', $g->setting["SERVER_DESCRIPTION"]);
define('SERVER_TITLE', $g->setting["SERVER_TITLE"]);
define('URL_DOMAIN', $g->setting["URL_DOMAIN"]);   // pro Url
//define('SERVER_LANG', $g->setting["SERVER_LANG"]);
define('VERSION_DATE', $g->setting["VERSION_DATE"]);
define('INSTALL_DATE', $g->setting["INSTALL_DATE"]);
define('SERVER_ROBOTS', $g->setting["SERVER_ROBOTS"]);
define('SERVER_GOOGLEBOT', $g->setting["SERVER_GOOGLEBOT"]);
define('SERVER_AUTHOR', $g->setting["SERVER_AUTHOR"]);
define('PAGETITLE_PREFIX', $g->setting["PAGETITLE_PREFIX"]);


define('VERSION_CATEGORY', $g->setting["VERSION_CATEGORY"]);
define('VERSION_POST', $g->setting["VERSION_POST"]);
define('VERSION_CATALOG', $g->setting["VERSION_CATALOG"]);
define('VERSION_PRODUCT', $g->setting["VERSION_PRODUCT"]);

define('URL_HOME_REL', $g->setting["URL_HOME_REL"]);


define('MAX_WIDTH',$g->setting["MAX_WIDTH"]);
define('MAX_HEIGHT',$g->setting["MAX_HEIGHT"]);
define('PATH_WATERMARK',$g->setting["PATH_WATERMARK"]);//PATH_ROOT . "watermark.gif"

define('IMAGE_EXTENSION_WHITELIST',$g->setting["IMAGE_EXTENSION_WHITELIST"]);
define('DATA_EXTENSION_WHITELIST',$g->setting["DATA_EXTENSION_WHITELIST"]);

if (!defined("URL_IMG"))
{
	define('URL_IMG', URL_HOME2 . 'foto/');
}
if (!defined("PATH_IMG"))
{
	define('PATH_IMG', dirname(__FILE__).'/../foto/');
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
if(!empty($g->setting["SERVER_FAVICON"]))
{
	define('SERVER_FAVICON', $g->setting["SERVER_FAVICON"]);
}


?>

<?php
error_reporting(E_ERROR);
//error_reporting(E_ALL);
ini_set("display_errors", 1);
$start_app = explode(" ", microtime());
$start_app = $start_app[1] + $start_app[0];
$rd = "10000"; // zaokrouhlování


define('VERSION_RS','4.78');
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
include PATH_ROOT.'inc/Gambik.class.php';
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

$stopky = new GStopky();
/*
autoLoader(PATH_ROOT . "core/library/Gambik/Function/");

autoLoader(PATH_ROOT . "core/library/Gambik/Controller/");

autoLoader(PATH_ROOT . "core/library/Gambik/");

// Jádro
autoLoader(PATH_ROOT . "core/entity/");
autoLoader(PATH_ROOT . "core/form/");
autoLoader(PATH_ROOT . "core/controller/");
autoLoader(PATH_ROOT . "core/models/");


// Aplikace
autoLoader(PATH_ROOT . "application/controller/");
autoLoader(PATH_ROOT . "application/form/");
autoLoader(PATH_ROOT . "application/models/");

*/

autoLoader(PATH_ROOT . "core/library/Gambik/Function/");
autoLoader(PATH_ROOT . "core/library/Gambik/Controller/");
autoLoader(PATH_ROOT . "core/library/Gambik/");

// Jádro
//$stopky->start();
autoLoader(PATH_ROOT . "core/template/");
autoLoader(PATH_ROOT . "core/entity/");
autoLoader(PATH_ROOT . "core/form/");
autoLoader(PATH_ROOT . "core/controller/");
autoLoader(PATH_ROOT . "core/models/");

//print $stopky->konec();
// Aplikace
/**/

autoLoader(PATH_ROOT . "application/entity/");
autoLoader(PATH_ROOT . "application/controller/");
autoLoader(PATH_ROOT . "application/form/");
autoLoader(PATH_ROOT . "application/models/");


$userController = new UserController();

//$xml = new c_xml_generator();




												/*
$g->set_server_js(URL_HOME . "js/core.js");
$g->set_server_js(URL_HOME . "js/ajax.js");
$g->set_server_js(URL_HOME . "js/jquery-1.3.2.js");
*/

include PATH_ROOT.'secret/after_init.php';



$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();
$activeLanguageList = array();
foreach ($languageList as $key => $val)
{
	$activeLanguageList[] = $val->code;
}

//$slovnik = $g->slovnik_list(array('lang'=>$lang, 'result'=>'array'));

$g->GoBackHandler();
$lang_url =  "";

//print_r($_GET);
/*
define("TRANSLATOR_EN", $g->setting["TRANSLATOR_EN"]);
define("TRANSLATOR_DE", $g->setting["TRANSLATOR_DE"]);
define("TRANSLATOR_RU", $g->setting["TRANSLATOR_RU"]);

if (!defined("ADMIN") && ($g->setting["TRANSLATOR_EN"]==1 || $g->setting["TRANSLATOR_DE"]==1 || $g->setting["TRANSLATOR_RU"]==1))
{
  $lang_url = LANG_TRANSLATOR;
  if (!empty($lang_url))
  {
    $lang_url =  $lang_url . "/";
  }
}
*/
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
//print LANG_TRANSLATOR;

//print "Moje ID" . PAGE_ID . "<br />";
//$g->setTranslator();

define('URL_HOME', str_replace("www.","m.",$g->setting["URL_HOME"]) . $lang_url);   // pro Url
define('URL_HOME2', str_replace("www.","m.",$g->setting["URL_HOME"]));   // pro Url

define('SERVER_KEYWORDS', $g->setting["SERVER_KEYWORDS"]);
define('SERVER_NAME', $g->setting["SERVER_NAME"]);             // pro Zobrazení
define('SERVER_DESCRIPTION', $g->setting["SERVER_DESCRIPTION"]);
define('SERVER_TITLE', $g->setting["SERVER_TITLE"]);
define('URL_DOMAIN', $g->setting["URL_DOMAIN"]);   // pro Url
define('SERVER_LANG', $g->setting["SERVER_LANG"]);
define('VERSION_DATE', $g->setting["VERSION_DATE"]);
define('INSTALL_DATE', $g->setting["INSTALL_DATE"]);
define('SERVER_ROBOTS', $g->setting["SERVER_ROBOTS"]);
define('SERVER_GOOGLEBOT', $g->setting["SERVER_GOOGLEBOT"]);
define('SERVER_AUTHOR', isset($g->setting["SERVER_AUTHOR"]) ? $g->setting["SERVER_AUTHOR"] : "");
define('PAGETITLE_PREFIX', $g->setting["PAGETITLE_PREFIX"]);


define('VERSION_CATEGORY', $g->setting["VERSION_CATEGORY"]);
define('VERSION_POST', $g->setting["VERSION_POST"]);
define('URL_HOME_REL', $g->setting["URL_HOME_REL"]);
//define('URL_IMG', URL_HOME . 'foto/');
$avatars = explode("x",$g->setting["avatar"]);

if (count($avatars)==2)
{
  $sirka = $avatars[0];
  $vyska = $avatars[1];
} else {
  $sirka = $avatars[0];
  $vyska = "AUTO";
}



define("VYCHOZI_VYSKA",$vyska);
define("VYCHOZI_SIRKA",$sirka);

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

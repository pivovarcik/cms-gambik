<?php
if( ! ini_get('date.timezone') )
{
	//	date_default_timezone_set('GMT');
	date_default_timezone_set('Europe/Prague');
}

$start_app = explode(" ", microtime());
$start_app = $start_app[1] + $start_app[0];
$rd = "10000"; // zaokrouhlování
define('START_APPLICATION',$start_app);


define('SERVER_CHARSET','utf-8');

define('PATH_ROOT2', dirname(__FILE__)."/");
define('PATH_CMS', dirname(__FILE__)."/");

/**
 *
 * Cesta k jádru
 **/
 
 
define('PATH_CORE', PATH_ROOT2 . "core/");


define('VERSION_RS','5.007');
define('PHP_TAB','  ');

define('PATH_ADMIN_PRG', PATH_CMS . "admin/prg/");

if (defined("ADMIN"))
{
   define('PATH_TEMP', PATH_CMS . 'admin/template/');
}  else {
  define('PATH_TEMP', PATH_HOME.'template/');
}



define('PATH_TEMPLE', PATH_HOME.'template/');

define('PATH_PRG', PATH_HOME .'prg/');

include PATH_CMS.'inc/XML.class.php';
include PATH_CMS.'inc/class.pop3.php';
include PATH_CMS.'inc/class.smtp.php';
include PATH_CMS.'inc/class.phpmailer.php';


function nactiTridu($trida)
{
    $paths = array();
 //   $paths[] = PATH_CORE . "library/Gambik/Function/";
    $paths[] = PATH_CORE . "library/Gambik/Controller/";
    $paths[] = PATH_CORE . "library/Gambik/";
    
    $paths[] = PATH_CORE . "library/Gambik/Form/";
    
    $paths[] = PATH_CORE . "template/";
    $paths[] = PATH_CORE . "entity/";
 //   $paths[] = PATH_CORE . "form/";
    $paths[] = PATH_CORE . "controller/";
    $paths[] = PATH_CORE . "models/";
    $paths[] = PATH_HOME . "application/template/";
    $paths[] = PATH_HOME . "application/entity/";
    $paths[] = PATH_HOME . "application/controller/";
    //$paths[] = PATH_HOME . "application/form/";
    $paths[] = PATH_HOME . "application/models/";
    
    if (substr($trida,0,strlen("models_")) == "models_")
    {
        $trida = substr($trida, strlen("models_"), strlen($trida));
    }

    foreach ($paths as $path){
    
     // print $path . " = " . $trida . "<br />";
     // print $path . $trida. ".php<br />";

      if (file_exists($path . $trida. ".php"))
      {
          require($path . $trida. ".php");
          return;
      }
    }
    if (substr($trida,0,strlen("F_")) == "F_")
    {
        $trida = substr($trida, strlen("F_"), strlen($trida));
    }    
    $paths = array();
    $paths[] = PATH_CORE . "form/";
    $paths[] = PATH_HOME . "application/form/";
    foreach ($paths as $path){
    
     // print $path . " = " . $trida . "<br />";
     // print $path . $trida. ".php<br />";

      if (file_exists($path . $trida. ".php"))
      {
          require($path . $trida. ".php");
          return;
      }
    } 
    
       
    /*
    if (file_exists(PATH_CORE . "library/Gambik/Function/$trida.php"))
    {
        require(PATH_CORE . "library/Gambik/Function/$trida.php");
        return;
    }    */
        // require("tridy/$trida.php");
}
spl_autoload_register("nactiTridu");


function autoLoader($path = null)
{
	if ($path == null)
	{
		$path = dirname(__FILE__);
	}

	
  if (file_exists($path) && $handle = opendir ($path))
	{
		while (false !== ($file = readdir($handle)))
		{

			if (substr($file,-4) == ".php")
			{
      if ( $_SERVER["REMOTE_ADDR"] == "90.177.76.16")
{
			//	print "AutoLoader2: " . $path . $file . "<br />";
				//print $path . $file . "<br />";
        
        }
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



// Spojení si nyní mapuju, aby se dalo lépe aktualizovat
//include PATH_ROOT2.'secret/before_init.php';
include PATH_HOME.'/secret/before_init.php';
define('SERVER_COPYRIGHT','Gambik ('.VERSION_RS.') - www.pivovarcik.cz');
include PATH_ROOT2.'inc/Sql.class.php';
/*====================================================
   ZAVADENI INSTANCI KNIHOVEN
   ====================================================*/
$stopky = new GStopky();

if ( $_SERVER["REMOTE_ADDR"] == "90.177.76.16")
{
   
   $stopky->start();
  // print autoLoader2();
    //print $stopky->konec() . "<br />";
}


$stopky->start();

autoLoader(PATH_CORE . "template/");


  //  PRINT PATH_ROOT2_GLOBAL . "core/library/Gambik/Function/";
    //EXIT;

// Library

autoLoader(PATH_CORE . "library/Gambik/Function/");
 /*
autoLoader(PATH_CORE . "library/Gambik/Controller/");

autoLoader(PATH_CORE . "library/Gambik/");
*/

// Jádro

/*
autoLoader(PATH_CORE . "entity/");
autoLoader(PATH_CORE . "form/");
autoLoader(PATH_CORE . "controller/");
autoLoader(PATH_CORE . "models/");
                 */
if ( $_SERVER["REMOTE_ADDR"] == "90.177.76.16")
{
  // print $stopky->konec() . "<br />";
}
     
//print PATH_CORE;
//$settings = new SettingsController();

$settings = G_Setting::instance();
if ("1" == $settings->get("MODUL_ESHOP"))
{
	$eshopSettings = G_EshopSetting::instance();
	define("MENA",$eshopSettings->get("MENA"));
}

 autoLoader(PATH_HOME . "application/template/");
     
    /*  
autoLoader(PATH_HOME . "application/template/");
autoLoader(PATH_HOME . "application/entity/");
       //    print "test3";
autoLoader(PATH_HOME . "application/controller/");
 //print "test2";
autoLoader(PATH_HOME . "application/form/");
autoLoader(PATH_HOME . "application/models/");
                   */
                   
autoLoader(PATH_HOME . "application/function/");
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
		define('URL_HOME2', $settings->get("URL_HOME_REL"));   // pro Url
} else {
  	define('URL_HOME2', $settings->get("URL_HOME"));   // pro Url
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

//	define('URL_HOME2', $settings->get("URL_HOME_REL"));   // pro Url
	define('URL_HOME_SITE', $settings->get("URL_HOME_REL"));   // pro Url
}

//include PATH_ROOT2.'secret/after_init.php';
include PATH_HOME .'secret/after_init.php';
   
	define('URL_HOME_ABS', $settings->get("URL_HOME"));   // pro Url

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
define('PATH_WATERMARK',constToText($settings->get("PATH_WATERMARK")));//PATH_ROOT2 . "watermark.gif"
define('WATERMARK_POS',($settings->get("WATERMARK_POS")));



//print PATH_ROOT2 . "watermark.gif";
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
//	define('IMP_DIRECTORY', dirname(__FILE__).'/../log/');
}


if (!defined("URL_DATA"))
{
	define('URL_DATA', URL_HOME2 . 'public/data/');
}

if (!defined("PATH_DATA"))
{
	define('PATH_DATA', PATH_ROOT2 . 'public/data/');
}

// TODO staré vyhodit
define('PATH_THUMBS', PATH_IMG . 'thumbs/');
define('URL_THUMBS', URL_IMG . 'thumbs/');
define('URL_IMAGE', URL_HOME . 'img/smiles/');
define('TRANSACTION_PAGE', URL_HOME . 'admin/transaction.php');

	define('SERVER_FAVICON', $settings->get("SERVER_FAVICON"));
	define('SERVER_FAVICON32', $settings->get("SERVER_FAVICON32"));
	define('SERVER_FAVICON96', $settings->get("SERVER_FAVICON96"));


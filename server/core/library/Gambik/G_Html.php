<?php
class UUID {
	public static function v3($namespace, $name) {
		if(!self::is_valid($namespace)) return false;

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2) {
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}

		// Calculate hash value
		$hash = md5($nstr . $name);

		return sprintf('%08s-%04s-%04x-%04x-%12s',

		  // 32 bits for "time_low"
		  substr($hash, 0, 8),

		  // 16 bits for "time_mid"
		  substr($hash, 8, 4),

		  // 16 bits for "time_hi_and_version",
		  // four most significant bits holds version number 3
		  (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

		  // 16 bits, 8 bits for "clk_seq_hi_res",
		  // 8 bits for "clk_seq_low",
		  // two most significant bits holds zero and one for variant DCE1.1
		  (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

		  // 48 bits for "node"
		  substr($hash, 20, 12)
		);
	}

	public static function v4() {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

		  // 32 bits for "time_low"
		  mt_rand(0, 0xffff), mt_rand(0, 0xffff),

		  // 16 bits for "time_mid"
		  mt_rand(0, 0xffff),

		  // 16 bits for "time_hi_and_version",
		  // four most significant bits holds version number 4
		  mt_rand(0, 0x0fff) | 0x4000,

		  // 16 bits, 8 bits for "clk_seq_hi_res",
		  // 8 bits for "clk_seq_low",
		  // two most significant bits holds zero and one for variant DCE1.1
		  mt_rand(0, 0x3fff) | 0x8000,

		  // 48 bits for "node"
		  mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

	public static function v5($namespace, $name) {
		if(!self::is_valid($namespace)) return false;

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2) {
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}

		// Calculate hash value
		$hash = sha1($nstr . $name);

		return sprintf('%08s-%04s-%04x-%04x-%12s',

		  // 32 bits for "time_low"
		  substr($hash, 0, 8),

		  // 16 bits for "time_mid"
		  substr($hash, 8, 4),

		  // 16 bits for "time_hi_and_version",
		  // four most significant bits holds version number 5
		  (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

		  // 16 bits, 8 bits for "clk_seq_hi_res",
		  // 8 bits for "clk_seq_low",
		  // two most significant bits holds zero and one for variant DCE1.1
		  (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

		  // 48 bits for "node"
		  substr($hash, 20, 12)
		);
	}

	public static function is_valid($uuid) {
		return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
		                  '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
	}
}


/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Html
{

	private $pageDescription = "";
	private $pagetitle = "";
	private $page_type = "";
	public $htmlClass = "";

	private $link = "";
	private $pageKeywords = "";
	private $cokolivToHeader = "";
	private $cokolivToFooter = "";
	private $robots_status = "";
	private $disableQuery = false;

	private $imagePreviewUrl = "";
	private $serverJsList = array();
	private $serverJsFooterList = array();
	private $serverCssList = array();

	private $javascriptInclude = false;
	public function getServer($key = null, $default = null)
	{
		if (null === $key) {
			return $_SERVER;
		}

		return (isset($_SERVER[$key])) ? $_SERVER[$key] : $default;
	}
  
  
  public function __construct()
  {
    if (defined("SERVER_ROBOTS"))
    {
      $this->robots_status = SERVER_ROBOTS;
    }
    
  }

	/**
	 * nazev
	 * pole[]
	 * pole[2]
	 * **/
	public function getPost($key = null, $default = null)
	{
		if (null === $key) {
			return $_POST;
		}
		//if (strpos("[", $key)) {
		if (strpos($key, "[")) {

			$pole = explode("[",$key);



			$key1 = $pole[0];




			// Snažím se dohledat konkrétní index
			$index = str_replace("]","",$pole[1]);


		//	print "key:" . ($key1) . " index: " . $index . "<br />";

		//	print_r( $_POST[$key1]);
		//	print $index;

		//	print_r($_POST);
			//print_r($_POST[$key1][0]);

			if (strLen($index) > 0) {
				return (isset($_POST[$key1][$index])) ? $_POST[$key1][$index] : $default;
				//return (isset($_POST[$key1][$index])) ? $_POST[$key1][$index] : $default;
			}
			if ($key1 == "ProductVariantyForm_has_attribute_id") {
			//	print_r((isset($_POST[$key1])) ? $_POST[$key1] : $default) ;
			}

			//return (isset($_POST[$key1])) ? $_POST[$key1] : $default;
			return (array_key_exists($key1, $_POST)) ? $_POST[$key1] : $default;
		}

		return (array_key_exists($key, $_POST)) ? $_POST[$key] : $default;
	//	return (isset($_POST[$key])) ? $_POST[$key] : $default;
	}

	public function getQuery($key = null, $default = null)
	{
		if ($this->disableQuery) {
			return false;
		}
		if (null === $key) {
			return $_GET;
		}

		return (isset($_GET[$key])) ? $_GET[$key] : $default;
	}
	public function setPost($key, $value)
	{
		if (null === $key) {
			return $_POST;
		}

		if (isset($_POST[$key]))
		{
			$_POST[$key] = $value;
		}

	}
	public function getCookie($key = null, $default = null)
	{
		if (null === $key) {
			return $_COOKIE;
		}

		return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : $default;
	}
	/*
	   * Vrací metodu
	*/
	public function getMethod()
	{
		return $this->getServer('REQUEST_METHOD');
	}

	// Dotaz je-li request přijat přes POST
	public function isPost()
	{
		if ($this->getMethod() == "POST")
		{
			return true;
		}
		return false;
	}

	// Dotaz je-li request přijat přes GET
	public function isGet()
	{
		if ($this->getMethod() == "GET")
		{
			return true;
		}
		return false;
	}

	public function setJsIncludeToFooter($javascriptInclude = true)
	{
		$this->javascriptInclude = $javascriptInclude;
	}
	public function clearPost()
	{
		$_POST = array();
		return $this;
	}
	public function goBackRef($url = '')
	{
		$cesta = substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], "/"));
		//print "Přesměrování:" . $_SERVER["HTTP_REFERER"];

		if (empty($url)) {
			$url = $_SERVER["HTTP_REFERER"];
		}
		@header("Location: ".$url, true, 303);
		print '<meta content="0; URL=' . $url . '" http-equiv="Refresh">';

		exit;
	}

	public function enableQuery()
	{
		$this->disableQuery = false;
	}
	public function disableQuery()
	{
		$this->disableQuery = true;
	}
	public function clearQuery()
	{
		$_GET = array();
		return $this;
	}

	public function clearCookies()
	{
		$_COOKIE = array();
		return $this;
	}
	public function setSession($key, $value)
	{
		if (null === $key) {
			return $_SESSION;
		}

		$_SESSION[$key] = $value;

	}
	public function getSession($key = null, $default = null)
	{
		if (null === $key) {
			return $_SESSION;
		}
		return (isset($_SESSION[$key])) ? $_SESSION[$key] : $default;
	}

	public function setCookie($key, $value, $expire = false)
	{
		if (null === $key) {
			return $_COOKIE;
		}
		if ($expire === false) {
			$expired = time()+999999999;
		} else {
			$expired = (int) $expire;
		}
		/*
		   if (isset($_COOKIE[$key]))
		   {
		   setcookie($key, $value, $expired);
		   }*/

		//$domain = defined("SERVER_NAME") ? SERVER_NAME : "";
		$domain = defined("URL_DOMAIN") ? URL_DOMAIN : "";
	//	$domain = str_replace("www","" ,$domain);
		$path = "/";
		//print $key . ":" . $value;
		@setcookie($key, $value, $expired , $path, $domain,false);
  //  setcookie('mycookie','mydata1',time() + 2*7*24*60*60,'/','www.domain.com', false);
	}

	public function clearJs()
	{
		$this->serverJsList = array();
	}

	public function clearCss()
	{
		$this->serverCssList = array();
	}

	public function setServerJs($hodnota)
	{
		$pole = explode("[]", $hodnota);
		for($i=0;$i<count($pole);$i++)
		{
			$js = trim($pole[$i]);
			if (!empty($js))
			{ array_push($this->serverJsList, $js); }
		}

	}

	public function getServerJs()
	{
		return $this->serverJsList;
	}
  
  
  
  public function setServerJsFooter($hodnota)
	{
		$pole = explode("[]", $hodnota);
		for($i=0;$i<count($pole);$i++)
		{
			$js = trim($pole[$i]);
			if (!empty($js))
			{ array_push($this->serverJsFooterList, $js); }
		}

	}

	public function getServerJsFooter()
	{
		return $this->serverJsFooterList;
	}
  
  

	public function setServerCss($hodnota)
	{
		$pole = explode(",", $hodnota);
		for($i=0;$i<count($pole);$i++)
		{

			$css = trim($pole[$i]);
			if (!empty($css))
			{ array_push($this->serverCssList, $css); }

		}

	}

	public function getServerCss()
	{
		return $this->serverCssList;
	}

	public function getHtmlJs()
	{
		$res ="";
		$list = $this->getServerJs();
		for($i=0;$i<count($list);$i++)
		{
			$p = explode("|",$list[$i]);

			if (count($p)>1) { $obsah = " " . $p[1]; } else {$obsah="";}
      $link = $p[0];
       if (strpos($link, "?")) {
        $link .= "&v=" . VERSION_RS;
       } else {
         $link .= "?v=" . VERSION_RS;
       }
			$res .= PHP_TAB . PHP_TAB . '<script' . $obsah . ' type="text/javascript" src="' . $link . '"></script>' . PHP_EOL;

		}
		return $res;
	}
	public function getHtmlJsFooter()
	{
		$res ="";
		$list = $this->getServerJsFooter();
		for($i=0;$i<count($list);$i++)
		{
			$p = explode("|",$list[$i]);

			if (count($p)>1) { $obsah = " " . $p[1]; } else {$obsah="";}
      $link = $p[0];
       if (strpos($link, "?")) {
        $link .= "&v=" . VERSION_RS;
       } else {
         $link .= "?v=" . VERSION_RS;
       }
			$res .= PHP_TAB . PHP_TAB . '<script' . $obsah . ' type="text/javascript" src="' . $link . '"></script>' . PHP_EOL;

		}
		return $res;
	}
	public function getHtmlCss()
	{
		$res ="";
		$list = $this->getServerCss();
		for($i=0;$i<count($list);$i++)
		{
			$link = $list[$i];
       if (strpos($link, "?")) {
        $link .= "&v=" . VERSION_RS;
       } else {
         $link .= "?v=" . VERSION_RS;
       }
   
      $res .= PHP_TAB . PHP_TAB . '<link rel="stylesheet" href="' . $link .  '" type="text/css" />' . PHP_EOL;
		}
		return $res;
	}

	public function setPreviewImage($imagePreviewUrl)
	{
		$this->imagePreviewUrl = $imagePreviewUrl;
	}


	public function printHtmlFooter()
	{
		$settings = G_Setting::instance();
		$html_text = "";
		if ($this->javascriptInclude) {
			//	$settings = G_Setting::instance();


		//	$html_text .= $this->getHtmlJs();

			$html_text .= PHP_TAB . PHP_TAB .'<!--[if lte IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->'. PHP_EOL;


		}
    
    		$html_text .= $this->getHtmlJsFooter();
    		$html_text .= $this->getcokolivToFooter();
        
		if ($settings->get("FOOTER_CODE") !="") {
			$html_text .= $settings->get("FOOTER_CODE"). PHP_EOL;
		}


		$appId = "";

		switch (LANG_TRANSLATOR) {
			case "cs":
				$lang = "cs_CZ";
				break;
			case "ru":
				$lang = "ru_RU";
				break;
			case "de":
				$lang = "de_DE";
				break;
			case "en":
				$lang = "en_US";
				break;
			case "sk":
				$lang = "sk_SK";
				break;
			case "pl":
				$lang = "pl_PL";
				break;

			default:
				$lang = "en_US";
		} // switch


		if ($settings->get("FACEBOOK_API_ID") !="") {
			$appId = "&appId=".$settings->get("FACEBOOK_API_ID");
		}


		$html_text .= PHP_TAB . PHP_TAB .'<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/' . $lang . '/sdk.js#xfbml=1&version=v2.3'.$appId.'";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, "script", "facebook-jssdk"));</script>'. PHP_EOL;

     
        if ($settings->get("GOOGLE_TAGMANAGER_KEY") !="" && $settings->get("GOOGLE_TAGMANAGER_POS") =="2") {
			$html_text .= $this->getGoogleTagManagerJs($settings->get("GOOGLE_TAGMANAGER_KEY"));
		}   
   
		if ($settings->get("google_analytics_key") !="" && $settings->get("GOOGLE_ANALYTICS_POS") =="2") {

			$html_text .= $this->getGoogleAnalyticsJs($settings->get("google_analytics_key"));
		}


		if ($settings->get("COOKIES_EU") =="1" && !isset($_COOKIE['eu-cookies']))
		{
			/*	$html_text .= '.eu-cookies {
			   position: fixed;
			   left: 0;
			   top: 0;
			   width: 100%;
			   color: white;
			   background-color: black;
			   z-index: 1000;
			   }

			   .eu-cookies button {
			   background: green;
			   color: white;
			   }';*/
			$translator = G_Translator::instance();

			$html_text .= '<div class="eu-cookies"><div class="container-fluid">'.$translator->prelozVyraz("cookies_eu_description").' <button class="btn">'.$translator->prelozVyraz("cookies_eu_accept").'</button>
				<a target="_blank" href="https://www.google.com/policies/technologies/cookies/">'.$translator->prelozVyraz("cookies_eu_info").'</a>
				</div></div>'. PHP_EOL;

			$html_text .= '<script>
				$(".eu-cookies button").click(function() {
					var date = new Date();
					date.setFullYear(date.getFullYear() + 10);
					document.cookie = "eu-cookies=1; path=/; expires=" + date.toGMTString();
					$(".eu-cookies").hide();
				});
				</script>'. PHP_EOL;

		}



		print $html_text;
		return $html_text;

	}
  
  
  public function setRobotsNoIndex()
  {
    $this->robots_status = "nofollow,noindex";
  }
  public function setRobots($status)
  {
     $this->robots_status = $status;
  }
  private function getRobots()
  {
    return  $this->robots_status;
  }
	public function printHtmlHeader()
	{

		$settings = G_Setting::instance();
    $eshopSettings = G_EshopSetting::instance();

		// HTML5
		$html_text ='<!DOCTYPE html>' . PHP_EOL;
		$html_text .='<html';
		if (defined("SERVER_LANG") && SERVER_LANG !="") {
			$html_text .=' lang="' . SERVER_LANG . '"';
		}

    if (!empty($this->htmlClass))
    {
      $html_text .=' class="' . $this->htmlClass . '"';
    }
    //  $html_text .=' class="' . $this->htmlClass . '"';
		if (defined("FACEBOOK_API_ID") && (FACEBOOK_API_ID) !="")
		{
			$html_text .=' xmlns:fb="http://www.facebook.com/2008/fbml"';
		}
		$html_text .='>' . PHP_EOL;

		$html_text .= PHP_TAB . '<head>' . PHP_EOL;

		// zakáže IE přepnout do kompatibilního režimu
		$html_text .= PHP_TAB . PHP_TAB . '<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->' . PHP_EOL;

		$html_text .= PHP_TAB . PHP_TAB . '<meta http-equiv="content-type" content="text/html; charset=' . SERVER_CHARSET . '" />' . PHP_EOL;


		// pro responzivní design

		if ($settings->get("IS_RESPONSIVE") == "1") {
			//$html_text .= PHP_TAB . PHP_TAB . '<meta name="viewport" content="width=device-width">'. PHP_EOL;
			$html_text .= PHP_TAB . PHP_TAB . '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">'. PHP_EOL;
		}

		$pagetitle = textfix($this->getPageTitle());
		$html_text .= PHP_TAB . PHP_TAB . '<title>' . $pagetitle . '</title>' . PHP_EOL;

		//<meta name="viewport" content="width=device-width">

		$html_text .= PHP_TAB . PHP_TAB . '<meta name="generator" content="' . SERVER_COPYRIGHT . '" />' . PHP_EOL;
		$html_text .= PHP_TAB . PHP_TAB . '<meta name="author" content="' . SERVER_NAME . '" />' . PHP_EOL;
	//	$html_text .= PHP_TAB . PHP_TAB . '<base href="' . URL_HOME . '">' . PHP_EOL;

		$pagedescription = textfix($this->getPageDescription());
		$html_text .= PHP_TAB . PHP_TAB . '<meta name="description" content="' . $pagedescription	 . '" />' . PHP_EOL;

		$keywords = textfix($this->getPageKeywords());
		$html_text .= PHP_TAB . PHP_TAB . '<meta name="keywords" content="' . $keywords . '" />' . PHP_EOL;

		$html_text .= PHP_TAB . PHP_TAB . '<meta name="robots" content="' . $this->getRobots() . '" />' . PHP_EOL;
		$html_text .= PHP_TAB . PHP_TAB . '<meta name="googlebot" content="' . $this->getRobots() . '" />' . PHP_EOL;
	//	$html_text .= PHP_TAB . PHP_TAB . '<meta name="googlebot" content="' . SERVER_GOOGLEBOT . '" />' . PHP_EOL;
		if (defined("SERVER_REFRESH") && SERVER_REFRESH > 0)
		{
		//	$html_text .= PHP_TAB . PHP_TAB . '<meta http-equiv="Refresh" content="' . SERVER_REFRESH . '; URL=' . $_SERVER["REQUEST_URI"] .'" />' . PHP_EOL;
		}

		if ($settings->get("GOOGLE_SITE_VERIFICATION") !="")
		{
			$html_text .= PHP_TAB . PHP_TAB . '<meta name="google-site-verification" content="' . $settings->get("GOOGLE_SITE_VERIFICATION") . '" />' . PHP_EOL;
		}

		if ($settings->get("FACEBOOK_API_ID") !="")
		{
			$html_text .= PHP_TAB . PHP_TAB . '<meta property="fb:app_id" content="' . $settings->get("FACEBOOK_API_ID") . '" />' . PHP_EOL;
		}



		if (!empty($this->page_type)) {
			$html_text .= PHP_TAB . PHP_TAB . '<meta property="og:type" content="' . $this->page_type . '"/>' . PHP_EOL;
		}

		$fbtitle = textfix($this->getPageTitle());
		if (!empty($fbtitle)) {
			$html_text .= PHP_TAB . PHP_TAB . '<meta property="og:title" content="' . $fbtitle . '" />' . PHP_EOL;
		}

		$fbdescription = textfix($this->getFbDescription());
		if (!empty($fbdescription)) {
			$html_text .= PHP_TAB . PHP_TAB . '<meta property="og:description" content="' . $fbdescription . '" />' . PHP_EOL;
		}
/*		$fbimage = textfix($this->getFbImage());
		if (!empty($fbdescription)) {
			$html_text .= PHP_TAB . PHP_TAB . '<meta property="og:image" content="' . $fbimage . '" />' . PHP_EOL;
		}
*/

		if (!empty($this->imagePreviewUrl)) {
			$html_text .= PHP_TAB . PHP_TAB . '<meta property="og:image" content="' . $this->imagePreviewUrl . '"/>' . PHP_EOL;
			$html_text .= PHP_TAB . PHP_TAB . '<link rel="previewimage" href="' . $this->imagePreviewUrl . '" />' . PHP_EOL;
		}
		if (!empty($this->link)) {
			$html_text .= PHP_TAB . PHP_TAB . '<meta property="og:url" content="' . $this->link . '"/>' . PHP_EOL;
			$html_text .= PHP_TAB . PHP_TAB . '<link rel="canonical" href="' . $this->link . '"/>' . PHP_EOL;
		}




		if (defined("SERVER_FAVICON") && SERVER_FAVICON !="")
		{
			//$html_text .= PHP_TAB . PHP_TAB . '<link rel="shortcut icon" href="' . SERVER_FAVICON . '" type="image/x-icon">' . PHP_EOL;
			$html_text .= PHP_TAB . PHP_TAB . '<link rel="icon" href="' . SERVER_FAVICON . '" type="image/x-icon"  sizes="16x16" />' . PHP_EOL;
		}
    if (defined("SERVER_FAVICON32") && SERVER_FAVICON32 !="")
		{
			//$html_text .= PHP_TAB . PHP_TAB . '<link rel="shortcut icon" href="' . SERVER_FAVICON . '" type="image/x-icon">' . PHP_EOL;
			$html_text .= PHP_TAB . PHP_TAB . '<link rel="icon" href="' . SERVER_FAVICON32 . '" type="image/x-icon"  sizes="32x32" />' . PHP_EOL;
		}
    
    if (defined("SERVER_FAVICON96") && SERVER_FAVICON96 !="")
		{
			//$html_text .= PHP_TAB . PHP_TAB . '<link rel="shortcut icon" href="' . SERVER_FAVICON . '" type="image/x-icon">' . PHP_EOL;
			$html_text .= PHP_TAB . PHP_TAB . '<link rel="icon" href="' . SERVER_FAVICON96 . '" type="image/x-icon"  sizes="96x96" />' . PHP_EOL;
		}
    

	//	print $html_text;
	//	return $html_text;
		$html_text .= $this->getHtmlCss();

    if ($settings->get("GOOGLE_TAGMANAGER_KEY") !="" && $settings->get("GOOGLE_TAGMANAGER_POS") =="1") {
			$html_text .= $this->getGoogleTagManagerJs($settings->get("GOOGLE_TAGMANAGER_KEY"));
		}  
    
    if ($settings->get("google_analytics_key") !="" && $settings->get("GOOGLE_ANALYTICS_POS") =="1") {
			$html_text .= $this->getGoogleAnalyticsJs($settings->get("google_analytics_key"));
		}



			$html_text .= '<script>
      ';
    if ($settings->get("MODUL_ESHOP") == "1")
    {
      $kurz = 1;
    	//PRINT LANG_KURZ;
    	if (defined("LANG_KURZ")) {
    		$kurz = (LANG_KURZ) * 1;
    	}
         //	print $kurz;
    //	$number = strToNumeric($number);
    //	$number = $number / $kurz;
    
    	$mena = "";
    	if (defined("LANG_CURRENCY")) {
    		$mena = LANG_CURRENCY;
    	}
    
    	if (empty($mena)) {
    		$mena = "Kč";
    	}
      
      $basketRedirect = "false";
      if ($eshopSettings->get("BASKET_REDIRECT") == "1")
      {
          $basketRedirect = "true";
      
      }
      
            $basketAfterInfo = "false";
      if ($eshopSettings->get("BASKET_REDIRECT") == "2")
      {
          $basketAfterInfo = "true";
      
      }
      
      $html_text .= '  		var KURZ = ' . $kurz . ';
		var CURRENCY = "' . $mena . '";
		var BASKET_REDIRECT  = ' . $basketRedirect . ';
		var BASKET_ADD_INFO  = ' . $basketAfterInfo . ';
    ';
    
    }




		$html_text .= 'var urlBase = "' . URL_HOME_REL . '";
		var lang = "' . LANG_TRANSLATOR . '";

		</script>'. PHP_EOL;


		$html_text .= $this->getHtmlJs();

		$html_text .= PHP_TAB . PHP_TAB .'<!--[if lte IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->'. PHP_EOL;

	//	}
		$html_text .= $this->getCokolivToHeader();


		//$html_text .= PHP_TAB . PHP_TAB . '<title>' . htmlentities($this->get_pagetitle()) . '</title>' . PHP_EOL;

		//	$html_text .= PHP_TAB . PHP_TAB . '<title>' . $this->get_pagetitle() . '</title>' . PHP_EOL;
		$html_text .= PHP_TAB . '</head>' . PHP_EOL;
		$html_text .= PHP_TAB . '<body class="lang-'.LANG_TRANSLATOR.'">' . PHP_EOL;

		//	return;
		print $html_text;
		return $html_text;
	//	flush();
	}

  	public function getGoogleTagManagerJs($code)
	{
		$html_text ="
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','" . $code . "');</script> 
	";
		return $html_text;
	}
  
	public function getGoogleAnalyticsJs($code)
	{
		$html_text ="
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '" . $code . "', 'auto');
		ga('send', 'pageview');

		</script>
		";
		return $html_text;
	}
	public function getFbDescription()
	{
		$settings = G_Setting::instance();
		return truncateUtf8(((!empty($this->pageDescription)) ? $this->pageDescription : $settings->get("SERVER_DESCRIPTION")),250,true,true);
	}

	public function getLink()
	{
		return $this->link;
	}
	public function setLink($value)
	{
		$this->link = strip_tags($value);
	}

	public function getPageType()
	{
		return $this->page_type;
	}
	public function setPageType($value)
	{
		$this->page_type = strip_tags($value);
	}



	public function setPageDescription($value)
	{
		$this->pageDescription = strip_tags($value);
	}

	public function getPageDescription()
	{
		$settings = G_Setting::instance();
		return truncateUtf8(((!empty($this->pageDescription)) ? $this->pageDescription : $settings->get("SERVER_DESCRIPTION")),250,true,true);
	}

	public function setPageKeywords($value)
	{
		$this->pageKeywords = strip_tags($value);
	}

	public function getPageKeywords()
	{
		$settings = G_Setting::instance();
		return truncateUtf8(((!empty($this->pageKeywords)) ? $this->pageKeywords : $settings->get("SERVER_KEYWORDS")),250,true,true);
	}

	public function getPageTitle()
	{
		$settings = G_Setting::instance();
		return ((!empty($this->pagetitle)) ? $this->pagetitle : $settings->get("SERVER_TITLE"));
	}

	public function setPageTitle($value)
	{
		if (defined("PAGETITLE_PREFIX"))
		{
			$value = $value . PAGETITLE_PREFIX;
		}
		$this->pagetitle = strip_tags($value);
	}


	public function getCokolivToHeader()
	{
		return $this->cokolivToHeader;
	}
	public function setCokolivToHeader($value)
	{
		$this->cokolivToHeader .= $value;
	}
  
  
	public function getCokolivToFooter()
	{
		return $this->cokolivToFooter;
	}
	public function setCokolivToFooter($value)
	{
		$this->cokolivToFooter .= $value;
	}
  
  
	public function audit()
	{

		$from_url = (isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : null;

		if (!is_null($from_url) && substr($from_url,0,strLen(URL_HOME)) != URL_HOME) {
			$model = new models_UserActivityMonitor();

			$data = array();
			$data["from_url"] = (isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : null;
			$data["to_url"] = $_SERVER["REQUEST_URI"];
			$data["ip_adresa"] = $_SERVER["REMOTE_ADDR"];
			$data["user_id"] = (defined("USER_ID")) ? USER_ID : null;
			return $model->insert($data);
		}
	}
}
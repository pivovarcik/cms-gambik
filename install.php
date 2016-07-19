<?php
//DEBUG

$url_home = "http://" . $_SERVER["HTTP_HOST"] . substr($_SERVER["REQUEST_URI"],0,strlen($_SERVER["REQUEST_URI"])-11);
//print $url_home;
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");

error_reporting(E_ALL);
ini_set("display_errors", 1);

define("LICENCE_KEY",rand());
define('PATH_ROOT', dirname(__FILE__) . "/");

include PATH_ROOT.'secret/before_init.php';
include PATH_ROOT.'inc/Sql.class.php';
//include PATH_ROOT.'inc/Zakl.class.php';
//include PATH_ROOT.'inc/Gambik.class.php';
//include PATH_ROOT.'/inc/Eshop.class.php';

//include PATH_ROOT.'core/library/Gambik/G_Model.php';


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

autoLoader(PATH_ROOT . "core/library/Gambik/Function/");

autoLoader(PATH_ROOT . "core/library/Gambik/Controller/");

autoLoader(PATH_ROOT . "core/library/Gambik/");

// Jádro
autoLoader(PATH_ROOT . "core/template/");
autoLoader(PATH_ROOT . "core/entity/");
//autoLoader(PATH_ROOT . "core/form/");
//autoLoader(PATH_ROOT . "core/controller/");
autoLoader(PATH_ROOT . "core/models/");

$model = new GModel();

$upsize = 0;
$upgrade = false;


if (isset($_POST["install"]) && $_POST["password"] =="ND4Dk4-DSFOKs4-a8rf7y4"){


	if ($upgrade)
	{
		$model->upgrade();

	} else {
		$model->install();
	}

	print "Instalace Dokončena!";
} else {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="cs-CZ" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	  	<meta name="robots" content="noindex,nofollow" />
	  	<link type="text/css" href="admin/admin.css" rel="stylesheet">
		<title>Instalace</title>
	</head>
	<body class="login">
		<form action="" method="post">
			<h1>Redakční Systém Gambik(R)</h1>
			<h2>Instalace nové verze <?php print VERSION_RS; ?></h2>
			<?php if (!$upgrade)
			{ ?>
			<p style="color:red;font-weight:bold;">POZOR! Dojde k odmazánání a znovu založení dat.</p>
			<?php } ?>
			<?php // print $changeLog; ?>

			<p>Pro Instalaci zadejte heslo: <input type="text" name="password" value=""/></p>
			<p><input type="submit" name="install" value="Instalovat"/></p>
		</form>
	</body>
</html>
	<?php } ?>
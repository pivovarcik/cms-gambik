<?php
/**
 * Add song my favorite
 * */
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));
define('PATH_TEMP', PATH_ROOT2 . '/../template/');

if (isset($_POST["id"])) {
	require_once PATH_ROOT2.'/../inc/init_spolecne.php';

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
	include PATH_ROOT.'library/Gambik/G_Image.php';
/*   */
	include PATH_ROOT.'library/Gambik/G_Html.php';
	include PATH_ROOT.'library/Gambik/G_Form.php';
	include PATH_ROOT.'library/Gambik/G_View.php';
	include PATH_ROOT.'library/Gambik/G_Service.php';
	include PATH_ROOT.'library/Gambik/G_Table.php';
	include PATH_ROOT.'library/Gambik/G_Paginator.php';
	include PATH_ROOT.'library/Gambik/G_Tree.php';
	include PATH_ROOT.'library/Gambik/Controller/G_Controller_Action.php';


	autoLoader(PATH_ROOT . "application/form/");
	autoLoader(PATH_ROOT . "application/controller/");
	autoLoader(PATH_ROOT . "application/models/");

	$_attribs = new models_Attributes();
	$profilDleSirky = $_attribs->get_attribute_value_from_parent($_POST["parent"],$_POST["id"]);
	$data =array();
	$data[0] = "-- vyberte --";
	foreach ($profilDleSirky as $key => $value)
	{

		$data[$value->ID] = $value->name;
	//	$slct .= '<option value="'.$key.'">'.$value["name"].'</option>';
	}
	//$slct .='</select>';$json = json_encode($result);
	$json = json_encode($data);
	print_r($json);
}
//print "hotovo";
?>

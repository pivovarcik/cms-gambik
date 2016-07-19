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
	$tree = new G_Tree();
	$rubrikyList = $tree->categoryTree(array(
			"parent"=>$_POST["id"],
			"vnoreni"=>1,
			"debug"=>0,
			));
	/*
	   print "<pre>";
	   print_r($rubrikyList);
	   print "</pre>";
	*/
		$slct = '<label>Typ auta:</label><select name="typecar" id="typeCarSlct">';
		$slct .= '<option value="0">-- vyberte --</option>';
	foreach ($rubrikyList as $key => $value)
	{
		$slct .= '<option value="'.$key.'">'.$value["name"].'</option>';
	}
		$slct .='</select>';

	print $slct;
}
//print "hotovo";
?>

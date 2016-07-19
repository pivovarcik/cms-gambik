<?php

session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
include dirname(__FILE__) . "/../../inc/init_spolecne.php";
$result ="";
/*
	$l = $g->facisodb_list(array('limit'=>20,
	 												'debug'=>'1',
	 												'naseptavac'=>1,
													 'odberatel'=>'n'));
													 print_R($l);         */
//$orderBySql = "t1.interpret,t1.song";

$data = array();
if (isset($_GET["term"]) && !empty($_GET["term"]))
{
	$input_search = $_GET["term"];


	$productController = new ProductController();
	$params = array();
	$params["search"] = $input_search;
	$params["page"] = 1;
	$params["limit"] = 20;
	$l = $productController->productList($params);

	if (count($l)>0)
	{
		//print_r($l);
		$sudy = false;
	//	print '<ul>';
		for ($i=0; $i < count($l);$i++){

			if ($sudy)
			{
				$classProSudy = ' class="sudy"';
				$sudy = false;
			} else
			{
				$classProSudy = '';
				$sudy = true;
			}

		//	print '<li' . $classProSudy . '>' . $l[$i]->odberatel . '</li>';
			$data[$i]["value"] = $l[$i]->title ;
			$data[$i]["id"] = $l[$i]->id;
		}
		//print '</ul>';

	}
}
$json = json_encode($data);
print_r($json);
exit;

if (isset($_POST["value"]) && !empty($_POST["value"]))
{
  $input_search = $_POST["value"];
	$l = $g->facisodb_list(array('limit'=>20,
	 												'debug'=>'0',
	 												'naseptavac'=>1,
													 'odberatel'=>$input_search));
	if (count($l)>0)
	{
    $sudy = false;
		print '<ul>';
		for ($i=0; $i < count($l);$i++){

      if ($sudy)
			{
		    $classProSudy = ' class="sudy"';
		    $sudy = false;
			} else
			{
		    $classProSudy = '';
		    $sudy = true;
			}

		  print '<li' . $classProSudy . '>' . $l[$i]->odberatel . '</li>';
		}
		print '</ul>';
	}


}   /*
print '<ul>';
print '<li>Pokus</li>';
print '</ul>';
 */

?>
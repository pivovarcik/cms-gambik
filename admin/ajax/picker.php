<?php
session_start();
define('URL_HOME', "/admin/");   // pro Url
define('URL_HOME_REL', "/admin/");   // pro Url
include dirname(__FILE__) . "/../../inc/init_spolecne.php";


if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
	//print "Location: " . URL_HOME . "login.php";
	//	header("Location: /login.php?redirect=".$_SERVER["REQUEST_URI"]);
	exit();
} else {
	define('LOGIN_STATUS', 'ON');
}
$data = array();
if (isset($_GET["picker"])) {
	$Picker = new $_GET["picker"];


	$data = $Picker->getData();
}
/*


if (isset($_GET["model"])) {
	$modelName = "models_" . $_GET["model"];

	$columnName = $_GET["column"];

	$columnNameId = $columnName;
	if (isset($_GET["columnId"])) {
		$columnNameId = $_GET["columnId"];
	}

	$columnNameLike = "like_" . $columnName;
	$model = new $modelName;
	$args = new ListArgs();

	$args->page = 1;
	$args->limit = 10;
	$args->$columnNameLike = $_GET["term"];
	$args->orderBy = $columnName;
	$list = $model->getList($args);
//	print $model->getLastQuery();

	$data = array();
	foreach ($list as $key => $row) {

		//PRINT_R($row);
		$obj = new stdClass();
		//	$obj->id = $row->id;
		//	$obj->value = $row->value;

		$obj->id = $row->$columnNameId;
		$obj->value = $row->$columnName;
		array_push($data, $obj);
	}

}
*/
$result = new stdClass();
$result->hasresults = Count($data) > 0 ? true : false;
$result->rows = $data;

$json = json_encode($result);
print_r($json);
//{"hasresults":true,"resultscount":1,"zip":false,"zipcodes":{"rows":[{"adresa1":"Pra~ská 14","adresa2":"PYíbram II.","id":78,"odberatel":"J.K.R. spol. s r.o.","psc":"261 01","stat":null,"value":1}]}}
?>

<?php
/**
 * Add song my favorite
 * */
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
//define('PATH_ROOT2', dirname(__FILE__));
//define('PATH_TEMP', PATH_ROOT2 . '/../template/');


//require_once PATH_ROOT2.'/../inc/init_spolecne.php';
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
function createRowCalender(){

	$row = new stdClass();
	$dnyTydne = array("Po", "Út", "St", "Čt", "Pá", "So", "Ne");
	foreach ($dnyTydne as $key => $value) {

		$value =strtolower(utfx($value));
		$row->$value = 0;
	}

	return $row;
}
// vytvoří jednu bunku TD
function createTdCalender($date){

	$dnes = false;
	$classToday='';
	if (date("Ymd",strtotime($date)) == date("Ymd") ) {
		$dnes = true;
		$classToday=' today';
	}

	$day = date("j",strTotime($date));
	$res = '<div class="day' . $classToday . '" id="dayBox'.$date.'">';

	$res .= '<span class="date">' . $day . '</span>';
	$res .= '<ul class=""></ul>';
	$res .= '</div>';

	return $res;
}

//print_r(createRowCalender());


function calenderBuilder($mesic,$rok){

	$dnyTydne = array("Po", "Út", "St", "Čt", "Pá", "So", "Ne");
	$nazvyDnuTedny = array("0" => "po", "1" => "ut", "2" => "st", "3" => "ct", "4" => "pa", "5" => "so", "6" => "ne");


	$prvniDenVMesici = "1.".$mesic. "." . $rok;
	$days_in_month = days_in_month($mesic,$rok);



	if ($mesic-1 == 0) {
		$predchoziMesic = 12;
		$predchoziRok = $rok-1;

		$nasledujiciMesic = $mesic+1;
		$nasledujiciRok = $rok;
		$pocetDnuPredchoziMesic = days_in_month($predchoziMesic, $predchoziRok);

	} elseif ($mesic == 12) {
		$nasledujiciMesic = 1;
		$nasledujiciRok = $rok+1;
		$predchoziMesic = $mesic-1;
		$predchoziRok = $rok;
		$pocetDnuPredchoziMesic = days_in_month($predchoziMesic, $predchoziRok);
	} else {

		$nasledujiciMesic = $mesic+1;
		$nasledujiciRok = $rok;

		$predchoziMesic = $mesic-1;
		$predchoziRok = $rok;
		$pocetDnuPredchoziMesic = days_in_month($predchoziMesic, $predchoziRok);
	}

	//	print $pocetDnuPredchoziMesic;

	//$days_in_month = date('t', $prvniDenVMesici);
	$cisloPrvniDne = date("w",strtotime($prvniDenVMesici));
	//	print $cisloPrvniDne;

	if ($cisloPrvniDne == 0) {
		$cisloPrvniDne = 7;
	}
	$denVTydnu = 0;
	$cisloTydne = 0;

	$rows = array();
	$row = createRowCalender();

	//print $days_in_month;
	//	print ($days_in_month + $cisloPrvniDne);
	for($i= 1; $i <= $days_in_month + $cisloPrvniDne; $i++)
	{

		$cisloDneVMesici = $i - $cisloPrvniDne;
		$cisloDneVMesici = ($cisloDneVMesici >0) ? $cisloDneVMesici : "";

		$pristupny = false;
		//	print strtotime($cisloDneVMesici . ".".$mesic. "." . $rok) . "(" . date("Ymd",strtotime($cisloDneVMesici . ".".$mesic. "." . $rok)) . ") >= " . (date("Ymd")) . "<br />";
		if ($cisloDneVMesici >0 && date("Ymd",strtotime($cisloDneVMesici . ".".$mesic. "." . $rok)) >= date("Ymd") ) {
			$pristupny = true;
		}

		if ($denVTydnu > 0) {
			$klicDne = $nazvyDnuTedny[($denVTydnu-1)];
			//	print $klicDne;
			if ($cisloDneVMesici > 0)
				$row->$klicDne = date("Y-m-d",strtotime($cisloDneVMesici . ".".$mesic. "." . $rok));
			else {
				// pro zobrazení předchozího měsíce
				$row->$klicDne = date("Y-m-d",strtotime(($pocetDnuPredchoziMesic+1-$cisloPrvniDne+$denVTydnu) . ".".$predchoziMesic. "." . $predchoziRok));
			}
			//print $row->$klicDne . "<br />";
			$row->$klicDne = createTdCalender($row->$klicDne);
		} else {
			//print $denVTydnu . "<br />";
		}

		//	print $denVTydnu . "<br />";
		if ($denVTydnu == 7) {
			//print $cisloTydne;
			$denVTydnu = 0;
			$cisloTydne++;
			$rows[$cisloTydne] = $row;
			$row = createRowCalender();
		}
		$denVTydnu++;
	}
	$denVTydnu--;
	// necelý týden
	if ($denVTydnu > 0) {
		$cisloTydne++;
		$zbyvaDnu = 7 - $denVTydnu;

		for ($i= 1; $i <= $zbyvaDnu; $i++)
		{
			$klicDne = $nazvyDnuTedny[($denVTydnu+$i-1)];

			//print $klicDne;
			$row->$klicDne = date("Y-m-d",strtotime(($i) . ".".$nasledujiciMesic. "." . $nasledujiciRok));
			$row->$klicDne = createTdCalender($row->$klicDne);
		}
		//print $nasledujiciMesic;
		//print_r($row);
		$rows[$cisloTydne] = $row;
	}

	//print_R($rows);
	return $rows;
}

function calenderTable($mesic,$rok,$rezervaceList = array()){

	$nazvyMesicu = array("","Leden", "Únor", "Březen", "Duben", "Květen", "Červen", "Červenec", "Srpen", "Září", "Říjen", "Listopad", "Prosinec");

	$data = calenderBuilder($mesic,$rok);

	$th_attrib = array();
	$column["po"] = "Pondělí";
	$column["ut"] = "Úterý";
	$column["st"] ="Středa";
	$column["ct"] = "Čtvrtek";
	$column["pa"] = "Pátek";
	$column["so"] = "Sobota";
	$column["ne"] = "Neděle";
	$table = new G_Table($data, $column, $th_attrib, $td_attrib);


	$table_attrib = array(
							"class" => "fixed",
							"id" => "calender_grid",
							"cellspacing" => "0",
							);

	$result = '<div class="calTitle">' . $nazvyMesicu[$mesic] . ' ' . $rok . '</div>';
	$result .= $table->makeTable($table_attrib);

	return $result;



}
?>


<div class="calendarBox">

<?php
$mesic = date("n");
if (isset($_GET["month"]) && !empty($_GET["month"])) {
	$mesic = $_GET["month"];
}
$rok = date("Y");
if (isset($_GET["year"]) && !empty($_GET["year"])) {
	$rok = $_GET["year"];
}

?>
<input type="hidden" value="<?php print $mesic; ?>" name="monthSelect"  id="monthSelect"/>
<input type="hidden" value="<?php print $rok; ?>" name="yearSelect"  id="yearSelect"/>
<div class="btn-group">
	<a href="#" class="btn fc-button button-prev"><i class="fa fa-angle-left fa-fc"></i></a>
	<span class="btn fc-button fc-button-today"></span>
	<a class="btn fc-button button-next" href="#">
	<i class="fa fa-angle-right fa-fc"></i></a>
</div>

<?php
print calenderTable($mesic,$rok);?>
<div id="requestBoxList"></div>
</div>

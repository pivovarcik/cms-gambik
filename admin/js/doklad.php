<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2013
 */

session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
include dirname(__FILE__) . "/../../inc/init_spolecne.php";

$formName = "";
if (isset($_GET["radekForm"])) {
	$formName = $_GET["radekForm"];	// . "_";
}
$eshopController = new EshopController();



$mj_model = new models_Mj();
$mjList = $mj_model->getList();
$poleId = array();
$poleValue = array();

foreach ($mjList as $key => $value)
{
	$poleId[] = $value->id;
	$poleValue[] = "'" . $value->name . "'";
}
$hodnotyMj = "[" . implode(",", $poleValue) . "]";
$kliceMj = "[" . implode(",", $poleId) . "]";


$dph_model = new models_Dph();
$params = new ListArgs();
$params->platne = date("Ymd");
$dphList = $dph_model->getList($params);
$poleId = array();
$poleValue = array();

foreach ($dphList as $key => $value)
{
	$poleId[] = $value->id;
	$poleName[] = "'" . $value->name . "'";
	//$poleValue[] = $value->value;

	$value->value = ($value->value <> 0) ? $value->value/100 : $value->value;
	$poleValue[] = $value->id. ":[" . $value->value. "]";
}
//dnyVTydnu= {1:["pondělí"], 2:["úterý"], 3:["středa"], 4:["čtvrtek"], 5:["pátek"], 6:["sobota"], 7:["neděle"]}
$hodnotyDph = "[" . implode(",", $poleName) . "]";
$kliceDph = "[" . implode(",", $poleId) . "]";
$valueDph = "{" . implode(",", $poleValue) . "}";



$dph_model = new models_Kurz();
$dphList = $dph_model->getList();
$poleId = array();
$poleValue = array();
$poleName = array();

$poleId[] = null;
$poleName[] = "'CZK'";
$poleValue[] = "null:[1]";
foreach ($dphList as $key => $value)
{
	$poleId[] = $value->id;
	$poleName[] = "'" . $value->kod . "'";
	//$poleValue[] = $value->value;
	$poleValue[] = $value->id. ":[" . $value->kurz. "]";
}
//dnyVTydnu= {1:["pondělí"], 2:["úterý"], 3:["středa"], 4:["čtvrtek"], 5:["pátek"], 6:["sobota"], 7:["neděle"]}
$hodnotyMeny = "[" . implode(",", $poleName) . "]";
$kliceMeny = "[" . implode(",", $poleId) . "]";
$valueMeny = "{" . implode(",", $poleValue) . "}";



$hodnotySlevy = "[ '%', ' ']";
//print $valueDph;
?>


var formName = "<?php print $formName;?>";

var jednotkyVal = <?php print $hodnotyDph; ?>;
var DPHvalues = <?php print $valueDph; ?>;

var Menavalues = <?php print $valueMeny; ?>;
var hodnotyMeny = <?php print $hodnotyMeny; ?>;

var hodnotySlevy = <?php print $hodnotySlevy; ?>;
function format_Of_Number (stat, num) {
  stat = stat.toLowerCase();
	//nStr = this + '';
	nStr = num + '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2;
	if(stat=='cz')
	x2 = x.length > 1 ? ',' + x[1] : ''; // nahradime tecku carkou
	else if(stat=='us')
	x2 = x.length > 1 ? '.' + x[1] : ''; // us format

	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		if(stat=='cz')
		x1 = x1.replace(rgx, '$1' + ' ' + '$2'); // nahradime mezerou cesky format 1 000,00
		else if(stat=='us')
		x1 = x1.replace(rgx, '$1' + ',' + '$2'); // us format 1,000.00
	}
	return x1 + x2;
}

function isNumeric(hodnota)
{
	hodnota = hodnota.replace(" ","");
	hodnota = hodnota.replace(" ","");
	hodnota = hodnota.replace("&nbsp;","");
	hodnota = hodnota.replace(",",".");

	if (hodnota == (hodnota*1))
		return true;

	return false;
}

function stringToNumeric(hodnota)
{
	hodnota = hodnota.replace(" ","");
	hodnota = hodnota.replace(" ","");
	hodnota = hodnota.replace("&nbsp;","");
	hodnota = hodnota.replace(",",".")*1;
	return hodnota;
}



// vrací hodnotu řádku se seznamu
function getHodnotaRadku(cisloRadku,seznam)
{
	var result = 0;
	seznam.each(function( index, element ) {

	//	console.log(cisloRadku +"==" + index);
		if (cisloRadku == index )
		{
			result = stringToNumeric($( element ).val());
		}
	});
	return result;
}


function setHodnotaRadku(cisloRadku,hodnota,seznam)
{
	seznam.each(function( index, element ) {
		if (cisloRadku == index )
		{
			$( element ).val(hodnota);
			return;
		}
	});
}

function getJednotkovaCenaRadku(cisloRadku)
{
	var seznam = $('#radky tbody tr input[name="' + formName + '_price[]"]');
	return getHodnotaRadku(cisloRadku,seznam);
}
function setJCelkovaCenaRadku(cisloRadku,hodnota)
{
	var seznam = $('#radky tbody tr input[name="' + formName + '_celkem[]"]');
	setHodnotaRadku(cisloRadku,hodnota,seznam);
}

function setJednotkovaCenaRadku(cisloRadku,hodnota)
{
	var seznam = $('#radky tbody tr input[name="' + formName + '_price[]"]');
	setHodnotaRadku(cisloRadku,hodnota,seznam);
}



function getSlevaRadku(cisloRadku)
{
	var seznam = $('#radky tbody tr input[name="' + formName + '_sleva[]"]');
	return getHodnotaRadku(cisloRadku,seznam);
}
function getTypSlevyRadku(cisloRadku)
{
	var seznam = $('#radky tbody tr select[name="' + formName + '_typ_slevy[]"]');
//	console.log("seznam:" + seznam.length);
	return getHodnotaRadku(cisloRadku,seznam);
}
function getMenaRadku(cisloRadku)
{
	var seznam = $('#radky tbody tr select[name="' + formName + '_kurz_id[]"]');
	return getHodnotaRadku(cisloRadku,seznam);
}
function getSazbaDphRadku(cisloRadku)
{
	var seznam = $('#radky tbody tr select[name="' + formName + '_tax_id[]"]');
	return getHodnotaRadku(cisloRadku,seznam);
}
function getMnozstviRadku(cisloRadku)
{
	var seznam = $('#radky tbody tr input[name="' + formName + '_qty[]"]');
	return getHodnotaRadku(cisloRadku,seznam);
}

function setMnozstviRadku(cisloRadku, hodnota)
{
	var seznam = $('#radky tbody tr input[name="' + formName + '_qty[]"]');
	seznam.each(function( index, element  ) {

		if (cisloRadku == index )
		{
			$( element ).val(hodnota);
			return;
		}
	});
}

function prepocti_cenu2()
{
console.log("prepocet");
  	var data_grid = document.getElementById("data_grid");

  	var rows = $('#radky tbody tr');

  	var mezisoucet = 0;
  	var mezisoucetDph = 0;

	for(i=0; i < rows.length; i++)
	{
		var Mnozstvi_na_radku = getMnozstviRadku(i);
		var Jednotkova_cena_radku = getJednotkovaCenaRadku(i);
		var SazbaDphNaRadku = getSazbaDphRadku(i);

		var SlevaNaRadku = getSlevaRadku(i);
		var TypSlevyNaRadku = getTypSlevyRadku(i);
		var MenaRadku = getMenaRadku(i);
		if (MenaRadku == 0) {MenaRadku=1;}

		console.log(i+"Mnozstvi"+Mnozstvi_na_radku);
		console.log(i+"cena"+Jednotkova_cena_radku);

		var ProcentoSazbyDphNaRadku = 0;

		if (DPHvalues[SazbaDphNaRadku])
		{
		ProcentoSazbyDphNaRadku = DPHvalues[SazbaDphNaRadku];
		}

		if (Mnozstvi_na_radku == 0 && Jednotkova_cena_radku > 0)
		{
			Mnozstvi_na_radku = 1;
			setMnozstviRadku(i,Mnozstvi_na_radku);
		}
		console.log(i+"MenaRadku:"+MenaRadku);
		var kurz = 1; // Menavalues[MenaRadku];
		console.log(i+"SazbaDphNaRadku:"+SazbaDphNaRadku);

		console.log(i+"ProcentoSazbyDphNaRadku:"+ProcentoSazbyDphNaRadku);
		console.log(i+"kurz:"+kurz);
		// Vypocet



		Celkova_cena_radku = Jednotkova_cena_radku * Mnozstvi_na_radku * kurz;
		console.log("SlevaNaRadku:" + SlevaNaRadku);
		console.log("TypSlevyNaRadku:"+TypSlevyNaRadku);
		if (SlevaNaRadku != 0)
		{
			if (TypSlevyNaRadku == "%")
			{
				Celkova_cena_radku = Celkova_cena_radku+ Celkova_cena_radku/100*SlevaNaRadku;
			}


		}

		mezisoucet  += Celkova_cena_radku;

		mezisoucetDph  += (Celkova_cena_radku * ProcentoSazbyDphNaRadku);

		setJednotkovaCenaRadku(i,format_Of_Number('cz',Jednotkova_cena_radku.toFixed(2)));
		setJCelkovaCenaRadku(i,format_Of_Number('cz',Celkova_cena_radku.toFixed(2)));




	}
	var sum_price_dph = mezisoucet + mezisoucetDph;

	$('#cost_subtotal').val(format_Of_Number('cz',mezisoucet.toFixed(2)));

	$('#cost_tax').val(format_Of_Number('cz',mezisoucetDph.toFixed(2)));
	$('#cost_total').val(format_Of_Number('cz',sum_price_dph.toFixed(2)));
	$('.cost_subtotal').text(format_Of_Number('cz',mezisoucet.toFixed(2)));
}

function createRadky(radky)
{
	var index = $('#radky tbody tr').length;

	for(i=0;i<radky.length;i++)
	{

	var data = {
		qty : radky[i].qty,
		mj : radky[i].mj,
		tax : jednotkyVal[0],
		mena : hodnotyMeny[0],
		product_code : "",
		product_name : radky[i].popis,
		product_description : radky[i].duvod,
		dodavatel : radky[i].dodavatel,
		price : radky[i].jednotkova_cena,
		celkova_cena : radky[i].celkova_cena
	}

		createRadekBase(formName,data);
	}
	prepocti_cenu2();
}

function createRadekBase(formName, data){
	var index = $('#radky tbody tr').length;

	var row = rowBuilder(data,index,formName);
	if (index > 0)
	{
		$("#radky tbody tr:last").after(row);

	} else {
		$("#radky tbody").html(row);
	}

}
function createRadek(formName){
var data = {
		qty : 0,
		mj : "m",
		tax : jednotkyVal[0],
		mena : hodnotyMeny[0],
		product_code : "",
		product_name : "",
		product_description : "",
		dodavatel : "",
		price : 0,
		sleva : 0,
		celkova_cena : 0,
		typ_slevy : hodnotyMeny[0],
	}
	createRadekBase(formName, data);



}

function deleteRadek(){

	if ($('#radky tbody tr').length == 1) {
		//alert("Nelze zrušit první řádek!");
		//return;
	}
	if (confirm("Opravdu zrušit řádek?")) {
		$("#radky tbody tr:last").remove();
		prepocti_cenu2();
	}

}

function rowBuilder(data,i,formName) {

	var jednotkova_cena = data.price * 1;

	var trClass ="";
	if (i > 0) {

		//var zaokrouhleny = (i/2).round(0);
		//var nezaokrouhleny = (i/2);
		if (Math.round(i/2) == (i/2)) {

		} else {
			var trClass =' class="sudy"';
		}

	}
//	var selectMj = selectMjBuilder(formName+'_mj[' + i + ']',data.mj);
//	var selectDph = selectDphBuilder(formName+'_tax_id[' + i + ']',data.tax);
//	var selectTypSlevy = selectDphBuilder(formName+'_typ_slevy[' + i + ']',data.typ_slevy);



	var selectMj = selectMjBuilder(formName+'_mj_id[]',data.mj);
	var selectDph = selectDphBuilder(formName+'_tax_id[]',data.tax);
	var selectMena = selectMenaBuilder(formName+'_kurz_id[]',data.mena);
	var selectTypSlevy = selectTypSlevyBuilder(formName+'_typ_slevy[]',data.typ_slevy);
      return '<tr' + trClass +'>'
      		+ '<td>'
      			+ '' + (i+1) + ''
      			+ '<input type="hidden" name="' +formName+'_radek_id[]" value="">'
      		+ '</td>'

      		+ '<td>'
      			+ '<input type="text" style="width:98%;text-align:left" name="' +formName+'_product_code[]" value="' + data.product_code + '" class="product_code">'
      		+ '</td>'
      		+ '<td>'
      			+ '<input type="text" class="product_name" name="' +formName+'_product_name[]" value="' + data.product_name + '" />'
      			+ '<input type="text" class="product_description" name="' +formName+'_product_description[]" value="' + data.product_description + '" />'
      		+ '</td>'
      		+ '<td>'
      			+ '<input type="text" style="text-align:right;" name="' +formName+'_qty[]" value="' + data.qty + '" class="form_edit" onblur="prepocti_cenu2();">'
      		+ '</td>'
      		+ '<td>'
      			+ selectMj
			+ '</td>'





      		+ '<td>'
      			+ '<input type="text" style="text-align:right" name="' +formName+'_price[]" value="' + format_Of_Number('cz',jednotkova_cena.toFixed(2)) + '" class="qty" onblur="prepocti_cenu2();">'
      		+ '</td>'


      		+ '<td>'
      			+ '<input type="text" style="text-align:right" name="' +formName+'_sleva[]" value="' + format_Of_Number('cz',data.sleva.toFixed(2)) + '" class="form_edit" onblur="prepocti_cenu2();">'
      		+ '</td>'

      		+ '<td>'
      			+ selectTypSlevy
			+ '</td>'

      		+ '<td>'
      			+ selectDph
			+ '</td>'

      		+ '<td>'
      			+ '<input type="text" style="text-align:right" name="' +formName+'_celkem[]" value="' + format_Of_Number('cz',data.celkova_cena.toFixed(2)) + '" class="form_edit" onblur="prepocti_cenu2();" readonly="readonly">'
      		+ '</td>'
      + '</tr>';
}

function selectBuilder(name, index, values, value){

console.log(name);
	//var jednotky = new MakeArray(2);
	var jednotkyKey = index;
	var jednotkyVal = values;

	var selected = '';
	var res = '<select name="' + name + '" class="form_edit" onchange="prepocti_cenu2();">';

	for(i2=0;i2<jednotkyKey.length;i2++)
	{
		selected = '';
		if (jednotkyVal[i2].toLowerCase() == value.toLowerCase()) {
			selected = ' selected="selected"';
		}
		res += '<option' + selected + ' value="' + jednotkyKey[i2] + '">';
		res += jednotkyVal[i2];
		res += '</option>';
	}

	res += '</select>';
	return res;
}

/**
 *
 * @access public
 * @return void
 **/
function selectMjBuilder(name, val){
	var jednotkyKey = <?php print $kliceMj; ?>;
	var jednotkyVal = <?php print $hodnotyMj; ?>;

	return selectBuilder(name, jednotkyKey, jednotkyVal, val);
}


function selectTypSlevyBuilder(name, val){

	var jednotkyKey = hodnotySlevy;
	var jednotkyVal = hodnotySlevy;

	return selectBuilder(name, jednotkyKey, jednotkyVal, val);
}

function selectDphBuilder(name, val){
	var jednotkyKey = <?php print $kliceDph; ?>;
	var jednotkyVal = <?php print $hodnotyDph; ?>;

	return selectBuilder(name, jednotkyKey, jednotkyVal, val);
}

function selectMenaBuilder(name, val){

	var jednotkyKey = <?php print $kliceMeny; ?>;
	var jednotkyVal = <?php print $hodnotyMeny; ?>;

	return selectBuilder(name, jednotkyKey, jednotkyVal, val);
}
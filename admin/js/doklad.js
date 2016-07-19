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

function prepocti_cenu2()
{
  	var data_grid = document.getElementById("data_grid");

  	var rows = $('#radky tbody tr');

  	var mezisoucet = 0;
  	var mezisoucetDph = 0;
	//alert(rows.length);

	for(i=0; i < rows.length; i++)
	{
		var Mnozstvi_na_radku = $('#radky tbody tr input[name="qty['+i+']"]').val();
		Mnozstvi_na_radku = Mnozstvi_na_radku.replace(" ","");
		Mnozstvi_na_radku = Mnozstvi_na_radku.replace(",",".")*1;

		var Jednotkova_cena_radku = $('#radky tbody tr input[name="price['+i+']"]').val();


		var ProcentoSazbyDphNaRadku = 0; //$('#radky tbody tr input[name="tax['+i+']"]').val();
		var SazbaDphNaRadku = $('#radky tbody tr select[name="tax['+i+']"]').val() * 1
		//alert(SazbaDphNaRadku)
		switch(SazbaDphNaRadku)
		{
			case 0 : ProcentoSazbyDphNaRadku = 0;
			break;
			case 1 : ProcentoSazbyDphNaRadku = 0;
			break;
			case 2 : ProcentoSazbyDphNaRadku = 0;
			break;
			case 3 : ProcentoSazbyDphNaRadku = 0.20;
			break;
			case 4: ProcentoSazbyDphNaRadku = 0.14;
			break;
		}

		Jednotkova_cena_radku = Jednotkova_cena_radku.replace(" ","");
		Jednotkova_cena_radku = Jednotkova_cena_radku.replace(" ","");
		Jednotkova_cena_radku = Jednotkova_cena_radku.replace(" ","");
		Jednotkova_cena_radku = Jednotkova_cena_radku.replace(",",".")*1;


		if (Mnozstvi_na_radku == 0 && Jednotkova_cena_radku > 0)
		{
			Mnozstvi_na_radku = 1;
			$('#radky tbody tr input[name="qty['+i+']"]').val(1);
		}

		var Kurz = 1;
		/*
		var Mena = $('#radky tbody tr select[name="mena['+i+']"]').val();
		switch(Mena)
		{
			case "0" : Kurz = 1;
			break;
			case "1" : Kurz = 25;
			break;
			case "2" : Kurz = 18;
			break;
		}
*/

		// Vypocet
		Celkova_cena_radku = Jednotkova_cena_radku * Mnozstvi_na_radku * Kurz;
		mezisoucet  += Celkova_cena_radku;

		mezisoucetDph  += (Celkova_cena_radku * ProcentoSazbyDphNaRadku);

		$('#radky tbody tr input[name="price['+i+']"]').val(format_Of_Number('cz',Jednotkova_cena_radku.toFixed(2)));
		$('#radky tbody tr input[name="celkem['+i+']"]').val(format_Of_Number('cz',Celkova_cena_radku.toFixed(2)));


	}
	//PrepocetCenyZaZadanku();
//	var sazba_dph = $('#sazba_dph').val();
	//var sum_dph = mezisoucetDph;
	var sum_price_dph = mezisoucet + mezisoucetDph;

	$('#cost_subtotal').val(format_Of_Number('cz',mezisoucet.toFixed(2)));

	$('#cost_tax').val(format_Of_Number('cz',mezisoucetDph.toFixed(2)));
	$('#cost_total').val(format_Of_Number('cz',sum_price_dph.toFixed(2)));

}

/**
 *
 * @access public
 * @return void
 **/
function createRadky(radky)
{
	var index = $('#radky tbody tr').length;

	for(i=0;i<radky.length;i++)
	{
		var row = rowBuilder(radky[i],index + i);
		$("#radky tbody tr:last").after(row);
	}
	prepocti_cenu2();
}

function createRadek(formName)
{


	var data = {
		qty : 0,
		mj : "m",
		tax : "14%",
		product_code : "",
		product_name : "",
		dodavatel : "",
		price : 0,
		celkova_cena : 0
	}

	var index = $('#radky tbody tr').length;

	var row = rowBuilder(data,index, formName);
	$("#radky tbody tr:last").after(row);
}

function deleteRadek(){

	if ($('#radky tbody tr').length == 1) {
		alert("Nelze zrušit první řádek!");
		return;
	}
	if (confirm("Opravdu zrušit řádek?")) {
		$("#radky tbody tr:last").remove();
		prepocti_cenu2();
	}

}

function rowBuilder(data,i, formName) {

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
	var selectMj = selectMjBuilder(formName + '_mj[' + i + ']',data.mj);
	var selectDph = selectDphBuilder(formName + '_tax[' + i + ']',data.tax);
      return '<tr' + trClass +'>'
      		+ '<td>'
      			+ '' + (i+1) + ''
      			+ '<input type="hidden" name="' + formName + '_radek_id[' + i + ']" value="">'
      		+ '</td>'

      		+ '<td>'
      			+ '<input type="text" style="width:98%;text-align:left" name="' + formName + '_product_code[' + i + ']" value="' + data.product_code + '" class="form_edit">'
      		+ '</td>'
      		+ '<td>'
      			+ '<input type="text" style="width:98%;text-align:left" name="' + formName + '_product_name[' + i + ']" value="' + data.product_name + '" class="form_edit">'
      		+ '</td>'
      		+ '<td>'
      			+ '<input type="text" style="text-align:right;width:45px;" name="' + formName + '_qty[' + i + ']" value="' + data.qty + '" class="form_edit" onblur="prepocti_cenu2();">'
      		+ '</td>'
      		+ '<td>'
      			+ selectMj
			+ '</td>'





      		+ '<td>'
      			+ '<input type="text" style="text-align:right" name="' + formName + '_price[' + i + ']" value="' + format_Of_Number('cz',jednotkova_cena.toFixed(2)) + '" class="form_edit" onblur="prepocti_cenu2();">'
      		+ '</td>'

      		+ '<td>'
      			+ selectDph
			+ '</td>'

      		+ '<td>'
      			+ '<input type="text" style="text-align:right" name="' + formName + '_celkem[' + i + ']" value="' + format_Of_Number('cz',data.celkova_cena.toFixed(2)) + '" class="form_edit" onblur="prepocti_cenu2();" readonly="readonly">'
      		+ '</td>'
      + '</tr>';
}

/**
 *
 * @access public
 * @return void
 **/
function selectBuilder(name, index, values, value){

	//var jednotky = new MakeArray(2);
	var jednotkyKey = index;
	var jednotkyVal = values;

	var selected = '';
	var res = '<select name="' + name + '" class="form_edit">';

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
	var jednotkyKey = [2,3,1,4];
	var jednotkyVal = ["Bal.", "Kg","Ks", "m", "Pár"];

	return selectBuilder(name, jednotkyKey, jednotkyVal, val);
}

function selectDphBuilder(name, val){
	var jednotkyKey = [4,3,1,2];
	var jednotkyVal = ["14%", "20%","Ne", "Osv."];

	return selectBuilder(name, jednotkyKey, jednotkyVal, val);
}
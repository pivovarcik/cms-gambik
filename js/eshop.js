$(document).ready(function(){



	$("#favorite-add").click( function(event) {
		event.preventDefault();
		addFavoriteProduct(productId);
	});
	$("#favorite-remove").click( function(event) {
		event.preventDefault();
		remFavoriteProduct(productId);
	});

/*
	$('#slider').slides({
		preload: false,
		start: 1,
		play: 6000,
		pause: 8000,
		generatePagination: true,
		effect: 'slide'
	});
*/
	$('body').delegate('#qty','change', function() {
		var qty = $(this).val() * 1;
		var price = $('#price').val() * qty;
		$('#BuyItemFullPrice').html(price + ' Kč');
		return false;
	});

	$('.product_buy').each(function() {
		$(this).children('.buy').click(function() {
			_addBasket(this);
		});
	});

	$('.add_basket').each(function() {
		$(this).children('.buy-button').click(function(event) {
			event.preventDefault();
			_addBasket(this);
		});
	});


	$('.ui-tabs-nav').delegate('li', 'click', function() {

		$(this.parentNode).children().removeClass('ui-tabs-selected');
		$(this).addClass('ui-tabs-selected');
		var url = $(this).children('a').attr("href");
		var urlPole = url.split('#');

		$('.product_tabs').children('div').addClass('ui-tabs-hide');
		$('#'+urlPole[1]).removeClass('ui-tabs-hide');
		return false;
	});
/*
	$("#productsNav ul li").mouseover(function() {
		if ($(this).index( 'ul' )) {
			$(this).find('ul').css('display', 'block');
		}

	});

	$("#productsNav ul li").mouseout(function() {

		$(this).find('ul').css('display', 'none');
		if ($(this).find('ul').css('display', 'none')) {
		}

	});
*/

	$("#response").click(function() {
		loadProductList();
	});
	$(".dodaci_adresa_check").click(function() {
		isDodaciAdresa();
	});

	// nastaveni dopravy
	$('.transferList .row').click(function(event) {
		event.preventDefault();
		if ($(this).hasClass("disabled_row")) {
			return;
		}
		if ($(this).hasClass("selected_row")) {
			return;
		}

		var price_value = $(this).find('.input_price_value').val();
		var price = $(this).find('.input_price').val() * 1;
		//alert(price);
		var total_price = $('.input_price_total').val() * 1;
		var total_qty = $('.input_qty_total').val() * 1;
		//	alert(total_price);
		total_price = total_price + (price*total_qty);

			$('input[name=doprava]').prop('checked', false);

			$(this).find('input[name=doprava]').prop("checked",true);

		var id = $(this).find('input[name=doprava]').val();
		$('.transferList .selected_row').removeClass("selected_row");
		$(this).addClass("selected_row");
		/*
		$('.transfer_price_value').html(price_value);
		$('.price_total').html(format_Of_Number('cz',total_price.toFixed(0)) + " Kč");
		*/
		setTransfer(id);

		//alert(id);
	});

	$('.paymentList .row').click(function(event) {

		event.preventDefault();
		if ($(this).hasClass("disabled_row")) {
			return;
		}
		if ($(this).hasClass("selected_row")) {
			return;
		}



		// Cena prepravy bez DPH
		var price = $(this).find('.input_price').val() * 1;
		// Popisek ceny přepravy
		var price_text = $(this).find('.price_value_text').val();
		// částka dph přepravy
		var price_dph = $(this).find('.price_value_dph').val() * 1;

		// Celková cena objednávky
		var total_price = $('.input_price_total').val() * 1;
		var total_tax = $('.input_tax_total').val() * 1;

		//	var total_price_transfer = $('.input_price_transfer').val() * 1;
		//total_price_transfer
		//	alert(total_price);
		total_price = total_price + price  + price_dph;


		total_tax =  total_tax + price_dph;
		$('input[name=platba]').prop('checked', false);

		$(this).find('input[name=platba]').prop("checked",true);

		var id = $(this).find('input[name=platba]').val();

		$('.paymentList .selected_row').removeClass("selected_row");
		$(this).addClass("selected_row");
		/*
		//$('.transfer_price_value').html(price_value);
		$('.price_total').html(format_Of_Number('cz',total_price.toFixed(0)) + " Kč");
		$('.tax_total').html(format_Of_Number('cz',total_tax.toFixed(0)) + " Kč");

		$('.transfer_price_value').html(price_text);
		*/
		setPayment(id);

		//alert(qty);
	});


	$('body').delegate('#qty','change', function() {
		var qty = $(this).val() * 1;
		var price = $('#price').val() * qty;
		$('#BuyItemFullPrice').html(price + ' Kč');
		return false;
	});


	$('#basketBox').hover(function(){
		$('.basket_preview').show();
	}, function() {
		//	$(this).removeClass('active');
		$('.basket_preview').hide();
	});



	isDodaciAdresa();

	$('.inc').click(function(e){
		e.preventDefault();
		nastavMnozstviZbozi($(this),1);
	});

	$('.dec').click(function(e){
		e.preventDefault();
		nastavMnozstviZbozi($(this),-1);
	});
	loadBasket();
	loadFavoriteProductList();
});
function nastavMnozstviZbozi(elementClick,plus)
{
	var mnozstviObj = elementClick.parent().find(".inp-text");
	var mnozstviObj;
	//console.log(mnozstviObj.val());
	var mnozstvi = mnozstviObj.val()*1+plus;
	if (mnozstvi >= 1) {


		var upd_product_basket = elementClick.parent().find(".upd_product_basket");
		if (upd_product_basket !="undefined") {
			showReloadDialog();
			var data = {
				"product_id" : mnozstviObj.attr("data-product-id"),
				"qty" : mnozstvi,
				"upd_product_basket" : true

			}
			var url = "/ajax/basket.php?do=changeQtyProductAjax";

			$.ajax({
				type: "POST",
				url: url,
				dataType: "json",
				data: data,
				success: function(r) {

					if(r.status == "success")
					{

						mnozstviObj.val(mnozstvi);
						location.reload();
						return;
					}

				},
				complete: function(){
					//blockFormmyModal=false;
					//location.reload();
				}
			});

		//	upd_product_basket.click();
		}
	}
}
function isOsobniOdber()
{
	if ($(".osobni_odber").val() == 1)
	{
		return true;
	}
	return false;
}

function isDodaciAdresa()
{

	if ($(".dodaci_adresa_check").is(':checked'))
	{
		if ($(".dodaci_adresa").hasClass("dodaci_adresa_disabled")) {
			$(".dodaci_adresa").removeClass("dodaci_adresa_disabled");
		}
		$(".dodaci_adresa :input[type='text']").attr('enabled','enabled');
		$(".dodaci_adresa :input[type='text']").attr('disabled',false);
	} else {

		$(".dodaci_adresa").addClass("dodaci_adresa_disabled");
		$(".dodaci_adresa :input[type='text']").attr('disabled','disabled');
		$(".dodaci_adresa :input[type='text']").attr('enabled',false);
		$(".dodaci_adresa :input[type='text']").val("");
	}
	if (isOsobniOdber()) {
		$(".dodaci_adresa").addClass("dodaci_adresa_disabled");
		$(".dodaci_adresa :input[type='text']").attr('disabled','disabled');
		$(".dodaci_adresa :input[type='text']").attr('enabled',false);
	}
}
var UrlBase = '/ajax';

function loadBasket(){
	$.ajax({
		type: 'POST',
		url: UrlBase + '/basket_info.php?lang='+lang,
		dataType: 'json',
		data: {
			'lang' : lang,
			'rand' : Math.random()
		},
		success: function(r) {

			$('#basketBox').html(r.html);
			$('.kosik_count').html(r.count);


		},
		failure: function() {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		},
		error: function () {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		}

	});
}




function _addBasket(that)
{
	var qty = $(that).parent().find(".qty").val();
	var id = $(that).siblings('.product_id').val();
	var varianty_id = $(that).parent().parent().find('.varianty_id').val();
	data = {
		'product_id' : id,
		'varianty_id' : varianty_id,
		'qty' : qty,
		'add_product_basket2' : '',
		'rand' : Math.random()
	};


	url = UrlBase + '/basket.php?do=addBasket';
	callbackFunction = "loadBasket";
	paramsCallbackFunction = "";
	loadModalBase(data, url, callbackFunction, paramsCallbackFunction);


}
// z product listu
function _addBasket22(that){
	var qty = $(that).parent().find(".qty").val();
	var id = $(that).siblings('.product_id').val();
	var varianty_id = $(that).parent().parent().find('.varianty_id').val();

	$.ajax({
		type: 'POST',
		url: UrlBase + '/basket.php',
		dataType: 'json',
		data: {
			'product_id' : id,
						'varianty_id' : varianty_id,
			'qty' : qty,
			'add_product_basket' : '',
			'rand' : Math.random()
		},
		success: function(r) {
			//alert(r.status);
			if (r.status == "ok") {

				slider(qty);
				$('#basket').html(r);
				loadBasket();
			}

			if (r.status == "product_not_exist") {
				//		slider(qty);
				//	$('#basket').html(r);
				alert('Product not exist!');
			}
			if (r.status == "already") {
				//	slider(qty);
				//	$('#basket').html(r);
				alert('Product is already.');
			}
		},
		failure: function() {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		},
		error: function () {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		}

	});
}
function basketAddproductComplete(qty)
{
	/*
<div id="basket-box" style="display:none;">
<form method="post">
<div class="basket-success">Zboží bylo přidáno do košíku <span id="window-basket-qty"></span> ks.</div>
<a class="btn-next-buy" href="<?php print AKT_PAGE; ?>"><span>Pokračovat v nákupu</span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-go-basket  css3button" href="/basket"><span>Přejít do košíku</span></a>
	</form>
</div>*/
}
function slider(qty){
	$('#slider-box').css('opacity','0.6');
	$('#slider-box').css('height',$('html').height());
	$('#slider-box').css('width',$('html').width());
	$('#slider-box').css('display','block');

	$('#basket-box').css('display','block');
	$('#basket-box').css('top','184px');
	$('#basket-box').css('left',$('html').width()/2 - ($('#basket-box').width()/2));
	$('#window-basket-qty').text(qty);
}

function closeBasketWindow()
{
	$('#slider-box').css('display','none');
	$('#basket-box').css('display','none');
}
// Obecná funkce pro naplnění Výběrového seznamu
function delBasket(id){
	$.ajax({
		type: 'POST',
		url: UrlBase + '/basket.php',
		dataType: 'json',
		data: {
			'product_id' : id,
			'del_product_basket' : '',
			'rand' : Math.random()
		},
		success: function(r) {
			$('#basket').text(r.status);
		},
		failure: function() {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		},
		error: function () {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		}

	});
}


function setTransfer(id){
	showReloadDialog();
	$.ajax({
		type: 'POST',
		url: UrlBase + '/basket.php',
		dataType: 'json',
		data: {
			'id' : id,
			'action' : 'setTransfer',
			'rand' : Math.random()
		},
		success: function(r) {
			//	$('#basket').text(r.status);
			getBasketInfo();

		},
		failure: function() {
			//	alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		},
		error: function () {
			//alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		}

	});
}


function getBasketInfo(){
	//	showReloadDialog();
	$.ajax({
		type: 'POST',
		url: UrlBase + '/basket.php',
		dataType: 'json',
		data: {
			'info' : 1,
			'rand' : Math.random()
		},
		success: function(r) {
			//	$('#basket').text(r.status);

			$('.transfer_price_value').html(r.cena_dopravy);
			$('.cart_bottom_price_vat').html(r.celkova_cena_sdph);
			$('.tax_total').html(r.castka_dph);

			$('.price_total').html(r.celkova_cena_sdph);
			hideReloadDialog();
		},
		failure: function() {
			//	alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		},
		error: function () {
			//	alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		}

	});
}


function favoriteListBuilder(data)
{
	if (data.count > 0) {
	//	$("#favMusic").html('<div class="footer-fixed"><div class="container"><a href="/oblibene"><i class="fa fa-heart"></i> Oblíbené ('+data.count+')</a></div></div>');
		$("#favProducts").html('<div class="footer-fixed"><div class="container"><a href="/porovnani"><i class="fa fa-balance-scale"></i> Zboží k porovnání ('+data.count+')</a></div></div>');
	} else {
		$("#favProducts").html('');
	}
}

function loadFavoriteProductList(){
	//	showReloadDialog();
//	var hash = window.location.hash.substring(1);

	//$("#results").text(hash);

	$.ajax({
		type: 'GET',
		url: UrlBase + '/favoriteProductList.php',
		dataType: 'json',
		success: function(r) {

			if (r.count > 0) {

				favoriteListBuilder(r);
		//	$("#favProducts").html('<div class="footer-fixed"><div class="wrapper"><a href="/porovnani">Zboží k porovnání ('+r.count+')</a></div></div>');
			/*$("<a>",{
				href : "/porovnani",
				text : "porovnat ("+r.count+")"
			}
			).appendTo("#favProducts");

			}*/
		//	$("#favProducts").html(r.count);
			//	$('#basket').text(r.status);
			//	hideReloadDialog();
			}
		},
		failure: function() {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		//	hideReloadDialog();
		},
		error: function () {
		//	alert('Došlo k chybě při komunikaci se serverem!');
		//	hideReloadDialog();
		}

	});
}

function loadProductList(){
	//	showReloadDialog();
	var hash = window.location.hash.substring(1);

	$("#results").text(hash);

	$.ajax({
		type: 'GET',
		url: UrlBase + '/loadProductList.php?'+hash,
		dataType: 'html',
		success: function(r) {
			//	$('#basket').text(r.status);
			//	hideReloadDialog();
		},
		failure: function() {
			//alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		},
		error: function () {
		//	alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		}

	});
}
function setPayment(id){
	showReloadDialog();
	$.ajax({
		type: 'POST',
		url: UrlBase + '/basket.php',
		dataType: 'json',
		data: {
			'id' : id,
			'action' : 'setPayment',
			'rand' : Math.random()
		},
		success: function(r) {
			//	$('#basket').text(r.status);
			//	hideReloadDialog();
			getBasketInfo();
		},
		failure: function() {
			//	alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		},
		error: function () {
			//	alert('Došlo k chybě při komunikaci se serverem!');
			hideReloadDialog();
		}

	});
}

function numberFormat(num)
{
	return format_Of_Number('cz', num);
}

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

function showReloadDialog(){
	$('#WizardPreload').css('height','100%');
	$('#WizardPreload').css('width','100%');
	$('#WizardPreload').css('display','block');
}
function hideReloadDialog(){
	$('#WizardPreload').css('display','none');
}



function nastavView(val){
	$("input[name=\"table_view\"]").val(val);
}


$(document).ready(function(){
	if(window.location.hash!=""){
		hledejObecny(true);
	}

	$(".table-view").click(function(e){
		e.preventDefault();
		nastavView($(this).attr("href").replace("#",""));
		hledejObecny();
	});

	$("input.vyr").click(function(){
		hledejObecny();
	});

	$("input.group").click(function(){
		hledejObecny();
	});

	$("#orderFilter").change(function(){
		hledejObecny();
	});
	$("#sortFilter").change(function(){
		hledejObecny();
	});

	$(".filter-box select.parameter").change(function(){
		hledejObecny();
	});

	$(".paging a").click(function(event){
		event.preventDefault();
		paging($(this).attr("href").replace("#",""));

	});
	$(".filter-box .searchbox").change(function(){
		hledejObecny();
	});

});

function getFilterParams(loadPage)
{
	params = {};
	params.cenaOd 	= "";
	params.cenaDo 	= "";
	params.order 	= "";
	params.sort 	= "";
	params.q 		= "";
	params.view 		= "0";
	params.vyr = new Array();
	params.skupina = new Array();
	params.attributes = new Array();




//	var arrNumber = new Array();
	$(".filter-box select.parameter").each(function(){

		var parameterId = $(this).val();
		params.attributes.push(parameterId);
	});

	params.view = $("input[name=\"table_view\"]").val();

	$(".filter-box input.vyr:checked").each(function(){

		if ($(this).is(':checked')) {
			var vyrobceId2 = $(this).attr("name");
			var vyrobceId = $(this).attr("name");
			vyrobceId = vyrobceId.replace("vyr[","");
			vyrobceId= vyrobceId.replace("]","");
			console.log(vyrobceId);

			if (vyrobceId.length) {
				params.vyr.push(vyrobceId);
			}
		}
	});


	$(".filter-box input.group:checked").each(function(){

		if ($(this).is(':checked')) {
			var vyrobceId2 = $(this).attr("name");
			var vyrobceId = $(this).attr("name");
			vyrobceId = vyrobceId.replace("skupina[","");
			vyrobceId= vyrobceId.replace("]","");
		//	console.log(vyrobceId);
			if (vyrobceId.length) {
				params.skupina.push(vyrobceId);
			}

		}

		//params.vyr[vyrobceId] = vyrobceId;
	});


	//	params.vyr 		= arrNumber;

	//params.limit = 10;
	params.page 	= 1;
	if (typeof $( "#lowestPrice" ) !== "undefined") {
	params.cenaOd 	= $( "#lowestPrice" ).val();
	}
	params.cenaDo 	= $( "#highestPrice" ).val();
	params.order = $("#orderFilter").val();
	params.lang = $("#lang").val();
	params.lang = lang;
	params.sort = $("#sortFilter").val();

	params.q = querySearch; //$(".searchbox").val();

	if (loadPage) {
//		params.vyr = new Array();
//		params.skupina = new Array();
//		params.attributes = new Array();
		jQuery.each(params, function(key, value) {
			var hashValue = getQueryVar(key);
			if (hashValue !="") {
				if (params[key] instanceof Array && hashValue > 0) {
					if (hashValue > 0) {
						if (checkValueArray(params[key],hashValue)) {
							params[key].push(hashValue);
						}

					}

				} else {
					params[key] = hashValue;
				}

			}

		});
	}
	return params;
}
function checkValueArray(pole, hodnota){
	for (var i = 0; i < pole.length; ++i) {
		if (pole[i] == hodnota) {
			return false;
		}
	}
	return true;
}
function createHash(params)
{
	var newhash = "";
	jQuery.each(params, function(key, value) {

		if (typeof value !== "undefined" && value != "") {
			newhash += key + "=" + value + "&";
		}

	});
	newhash = newhash.substr(0, newhash.lastIndexOf("&"));
	window.location.hash = newhash;
}
function loadProductList(params)
{
		searchProducts(params);
}
function hledejObecny(loadPage) {
	var params = getFilterParams(loadPage);
	createHash(params);


	if (typeof cenaslider !== "undefined") {
	cenaslider.slider("values", [params.cenaOd, params.cenaDo]);
	$( ".min-price" ).html(  numberFormat(params.cenaOd) + " Kč");
	$( ".max-price" ).html( numberFormat(params.cenaDo) + " Kč");
	$( "#lowestPrice" ).val(params.cenaOd);
	$( "#highestPrice" ).val(params.cenaDo);
	}
	searchProducts(params);
}
function hledejCena(cenaod, cenado) {
	var params = getFilterParams();
	params.cenaOd = cenaod;
	params.cenaDo = cenado;

	//params.order = $("#orderFilter").val();
	//params.sort = $("#sortFilter").val();
	createHash(params);
	searchProducts(params);
}

function paging(page)
{
	var params = getFilterParams(true);
	params.page = page;
	createHash(params);
	searchProducts(params);
}
function searchProducts(params)
{
	if (typeof attributes !== "undefined") {
		params.attributes = attributes;
	}

	if (typeof limit !== "undefined") {
		params.limit = limit;
	}

	if (typeof not_product_id !== "undefined") {
		params.not_product_id = not_product_id;
	}


	if (typeof cat_id !== "undefined") {
		params.cat_id = cat_id;
	}
	if (typeof img_width !== "undefined") {
		params.img_width = img_width;
	}
	if (typeof img_height !== "undefined") {
		params.img_height = img_height;
	}
	$("#productList-overlay").show();
	$.ajax({
		url: "/ajax/vypis-zbozi.php",
		type: "POST",
		dataType : "json",
		data: params
		,
		success: function(result) {


		//	var html = postavHtmlVypis(result.productList);
			var html = result.productListHtml;
			$(".itemsList-ajax").html(html);

	//		html = strankovani(params.page,result.count,result.pageLimit);

		//	html+='<span class="itemCount">' + result.count + ' položek</span>';
			$(".itemsList-footer").html(result.strankovaniHtml);
			//<div class="itemsList-footer"><span class="itemCount">2 položek</span></div>

			$(".paging a").click(function(event){
				event.preventDefault();

				paging($(this).attr("href").replace("#",""));

			//	paging($(this).attr("data-pg"));

			});
		},
		complete: function() {
			setTimeout(function(){$("#productList-overlay").hide();}, 300);

			$('.product_buy').each(function() {
				$(this).children('.buy').click(function() {
					_addBasket(this);
				});
			});
		}
	}

	);
}

function postavHtmlVypis(productList)
{
	var result = '';

//	result += '<div class="itemsList">';

	jQuery.each(productList, function(key, value) {
		result += '<div class="item">';
		result += '<div class="item_in">';


		result += '<div class="product_info">';
		result += '<div class="description">' + value.description + '</div>';
		result += '</div>';



		result += '<div>';
		result += '<div class="product_image">';

		if (value.img_url != "") {
			result += '<a href="' + value.link + '"><img alt=' + value.title + ' src="' + value.img_url + '" /></a>';
		}

		result += '</div>';

		result += '<div class="product_params">';
		result += '<div class="product_code"><span class="label">kod_zbozi:</span> ' + value.cislo + '</div>';
		result += '</div>';
		result += '<div class="clearfix"><!-- IE --></div>';
		result += '</div>';

		result += '<div class="product_name"><a href="' + value.link + '">' + value.title + '</a></div>';



		result += '<div class="price">';
		result += '<span class="value">' + value.cena + '<small> ' + value.cena_desc + '</small></span>';
		result += '<span class="dostupnost">' + value.nazev_dostupnost + '</span>';
		result += '</div>';


		result += '<form method="post">';
		result += '<div class="product_buy">';
		result += '<input type="hidden" class="product_id" name="product_id" value="' + value.product_id + '" />';
		result += '<input type="text" class="qty" value="' + value.qty + '" name="qty" autocomplete="off">&nbsp;' + value.nazev_mj + '';
		result += '<a title="' + value.title + '" class="buy" href="#"><span>detail</span></a>';
		result += '</div>';
		result += '</form>';


		result += '</div>';
		result += '</div>';
	});
	result += '<div class="clearfix"></div>';
	return result;
	//productList[0].title;
}

function strankovani(pageNo,totalCount,pageLimit)
{
	var result = '';
	result += '<div class="paging">';
	result += '<ul class="pglist">';

	pages = Math.ceil(totalCount/pageLimit);


	for (i=0;i <pages;i++)
	{

		result += '<li class="pgnum"><a data-pg="' + (i+1) + '" title="Přejít na ' + (i+1) + '. stránku" href="#">' + (i+1) + '</a></li>';
	}
		result += '</ul></div>';

	return result;
}


function getQueryVar(varName) {
	var queryStr = unescape(window.location.hash.substring(1));
	var regex = new RegExp(varName + '=([a-zA-Z0-9-,]*)');
	var val = queryStr.match(regex);
	if (val !== null) {
		return val[1];
	} else {
		return "";
	}
}


function addFavoriteProduct(id)
{
	$.ajax({
		type: 'POST',
		url: UrlBase + '/favoriteProductList.php',
		dataType: 'json',
		data : {
			"product_id" : id,
			"add_product_fav" : "add"
		},
		success: function(r) {
			favoriteListBuilder(r);

			$("#favorite-add").hide();
			$("#favorite-remove").show();

		},
		failure: function() {
		},
		error: function () {
		}

	});
}

function remFavoriteProduct(id)
{
	$.ajax({
		type: 'POST',
		url: UrlBase + '/favoriteProductList.php',
		dataType: 'json',
		data : {
			"product_id" : id,
			"remove_product_fav" : "rem"
		},
		success: function(r) {
			favoriteListBuilder(r);
			$("#favorite-add").show();
			$("#favorite-remove").hide();


		},
		failure: function() {
		},
		error: function () {
		}

	});
}


var blockFormmyModal=false;
function closeModalForm(formId)
{
	$("#"+formId).modal("hide");
}

function openModalForm(formId)
{
	$("#"+formId).modal("show");
}

function loadModalBase(data, url, callbackFunction, paramsCallbackFunction)
{
	var formId = "myModal";
	console.log("BÄ›ĹľĂ­: loadModalBase2");
	blockFormmyModal=true;
	$.ajax({
		type: "POST",
		url: url,
		dataType: "json",
		data: data,
		success: function(r) {

			if(r.status == "success")
			{
				closeModalForm(formId);
				//	closeModalForm("ulozeno");
				//	loadGrid("mj");
				console.log("callbackFunction:" + callbackFunction);
				console.log("typeof:" + typeof(callbackFunction));
				//'"+paramsCallbackFunction+"'

				if (callbackFunction && typeof(callbackFunction) === "function") {
					callbackFunction();
				}

				if (callbackFunction && typeof(callbackFunction) === "string") {
					setTimeout(callbackFunction+"("+paramsCallbackFunction+")", 0);
				}
				return;
			}
			//blockFormmyModal=false;
			$("#bs-container").html(r.html);
			openModalForm(formId);




			// nastav submit
			console.log("nastavuji submit");
			$("#myModal-form").on( "submit",function(e){
				e.preventDefault();

				if (!blockFormmyModal){

					var url = $("#myModal-form").attr("action");
					saveData(url, callbackFunction, paramsCallbackFunction);
				}
			});
		},
		complete: function(){
			blockFormmyModal=false;
		}
	});
}


function saveData(url, callbackFunction, paramsCallbackFunction){
	//console.log(action);
	console.log("saveData");

	var data = $("#myModal-form").serialize();
	//	var url = $("#myModa-form").attr("action");

	loadModalBase(data,url, callbackFunction, paramsCallbackFunction);
}
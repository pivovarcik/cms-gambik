//mouseover



//var UrlBase = '/../admin';
function pridej_radek() {
//var id = document.getElementById("id").value;
var id = $("#counter").val() * 1;
$("#divTxt").append("<input type='text' name='Application_Form_AttribValueEdit_attrVal[" + id + "]'>");
id = $("#counter").val(id+1);

}

function registerEventRadekForm(formName)
{
	//$('.rowSetDeleted').unbind( "click" );
	$('.rowSetDeleted').click(function(event)
	{
		event.preventDefault();
		deletedRadekForm(this,formName);
	});
}

function deletedRadekForm(that,formName)
{
	//alert("test");
	var isDeleted = $(that).siblings('input[name="' + formName + '_isDeleted[]"]').val();

	if (isDeleted == "1") {
		$(that).siblings('input[name="' + formName + '_isDeleted[]"]').val(0);
		$(that).find("span").html("x");
	} else {
		$(that).siblings('input[name="' + formName + '_isDeleted[]"]').val(1);
		$(that).find("span").html("+");
	}
}
function isDodaciAdresa()
{
	if ($(".dodaci_adresa_check").attr('checked'))
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
}

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
document.cookie=c_name + "=" + c_value;
}

// this fixes an issue with the old method, ambiguous values
// with this test document.cookie.indexOf( name + "=" );
function getCookie( check_name ) {
	// first we'll split this cookie up into name/value pairs
	// note: document.cookie only returns name=value, not the other components
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false; // set boolean t/f default f

	for ( i = 0; i < a_all_cookies.length; i++ )
	{
		// now we'll split apart each name=value pair
		a_temp_cookie = a_all_cookies[i].split( '=' );


		// and trim left/right whitespace while we're at it
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

		// if the extracted name matches passed check_name
		if ( cookie_name == check_name )
		{
			b_cookie_found = true;
			// we need to handle case where cookie has no value but exists (no = sign, that is):
			if ( a_temp_cookie.length > 1 )
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
			}
			// note that in cases where cookie is initialized but no value, null is returned
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if ( !b_cookie_found )
	{
		return null;
	}
}


sfFocus = function() {

var sfEls = document.getElementsByTagName("INPUT");
//ALERT(sfEls.length);
for (var i=0; i<sfEls.length; i++) {
    sfEls[i].onfocus=function() {
            this.className+=" sffocus";

    }
    sfEls[i].onblur=function() {
            this.className=this.className.replace(new RegExp(" sffocus\\b"), "");
    }
}
var sfEls = document.getElementsByTagName("TEXTAREA");
//ALERT(sfEls.length);
for (var i=0; i<sfEls.length; i++) {
    sfEls[i].onfocus=function() {
            this.className+=" sffocus";

    }
    sfEls[i].onblur=function() {
            this.className=this.className.replace(new RegExp(" sffocus\\b"), "");
    }
}
}

if (window.attachEvent) window.attachEvent("onload", sfFocus);
$(document).ready(function(){



	$('.datetimepicker').datetimepicker();
	$( ".datepicker" ).datepicker();
	$( ".datetime-column .datetime" ).datepicker();

	$( ".ares" ).click(function(event) {
		event.preventDefault();
		 aresLoad(this);

	});


	$('.product_tabs').tabs();
	$('.tabs-min').tabs();
	$("#mainMenu ul li").mouseover(function() {
		if ($(this).find( 'ul' )) {
		//	$(this).find('ul').css('display', 'block');
		}
		$(this).find('ul').css('display', 'block');
	});

	$("#mainMenu ul li").mouseout(function() {
		$(this).find('ul').css('display', 'none');
		if ($(this).find('ul').css('display', 'none')) {
		}
	});

	$( "input.date" ).datepicker();

	$(".dodaci_adresa_check").click(function() {
		isDodaciAdresa();
	});


	$('#data_grid').delegate('tr', 'mouseover', function() {
		$(this).addClass('row_style_radek');
		return false;
	});

	$('#data_grid').delegate('tr', 'mouseout', function() {
		$(this).removeClass('row_style_radek');
		return false;
	});

	MsgCheck();
	isDodaciAdresa();

/*	$(".has_attribute_id").click(function(event) {

			var originalId = $(this).siblings(".attribute_original_id").val();


			if ($(this).is(':checked'))
			{
				//alert(originalId);
				$(this).siblings(".attribute_id").val(originalId);
				$(this).siblings(".selectbox").css("display","inline");


			} else {
				$(this).siblings(".attribute_id").val(0);
				$(this).siblings(".selectbox").css("display","none");
			//	alert("odškrtnuto");

			}

	});*/


});
function OPnonstop(id){
	$('#' + id + '_start1').val('00');
	$('#' + id + '_start2').val('00');
	$('#' + id + '_end1').val('24');
	$('#' + id + '_end2').val('00');

}
function OPclose(id){
	$('#' + id + '_start1').val('00');
	$('#' + id + '_start2').val('00');
	$('#' + id + '_end1').val('00');
	$('#' + id + '_end2').val('00');

}

// Obecná funkce pro naplnění Výběrového seznamu
function reloadPostFotogallery(id){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + '/ajaxPostGallery.php',
		dataType: 'html',
		data: {
			'post_id' : id,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#gallery_items').html(r);
		},
		failure: function() {
		},
		error: function () {
		}

	});
}

// Obecná funkce pro naplnění Výběrového seznamu
function reloadGameFotogallery(id){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + '/ajaxGameGallery.php',
		dataType: 'html',
		data: {
			'game_id' : id,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#gallery_items').html(r);
		},
		failure: function() {
		},
		error: function () {
		}

	});
}

// Obecná funkce pro naplnění Výběrového seznamu
function reloadFotogalery(id){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + '/ajaxCatalogGallery.php',
		dataType: 'html',
		data: {
			'catalog_id' : id,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#gallery_items').html(r);
		},
		failure: function() {
		},
		error: function () {
		}

	});
}
// Obecná funkce pro naplnění Výběrového seznamu
function reloadLogo(id){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + '/ajaxCatalogLogo.php',
		dataType: 'html',
		data: {
			'catalog_id' : id,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#logo').html(r);
		},
		failure: function() {
		},
		error: function () {
		}

	});
}
function deleteFoto(foto_id,gallery_id,gallery_type){
	$.ajax({
	type: 'POST',
	url: UrlBase + 'admin/ajax/delFoto.php',
	dataType: 'json',
	data: {
	'delete_foto' : foto_id,
	'rand' : Math.random()
	},
	success: function(r) {
	loadPhotoGallery(gallery_id,gallery_type);
	},
	failure: function() {
	},
	error: function () {
	}

	});
}

function deleteFotoFromPost(foto_id, gallery_id){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/delFoto.php',
		dataType: 'json',
		data: {
			'delete_foto' : foto_id,
			'rand' : Math.random()
		},
		success: function(r) {
			reloadPostFotogallery(gallery_id);

		},
		failure: function() {
		},
		error: function () {
		}

	});
}
function setMainFoto(catalog_id, foto_id){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/catalogSetMainFoto.php',
		dataType: 'json',
		data: {
			'catalog_id' : catalog_id,
			'foto_id' : foto_id,
			'rand' : Math.random()
		},
		success: function(r) {
			if (r.status == "ok") {

			}
			//$('#gallery_items').html(r);
		},
		failure: function() {
		},
		error: function () {
		}

	});
}


/**
 *
 * @access public
 * @return void
 **/
function show_lang(lang){

	$('.lang').hide();
	$('.lang_'+lang).show();

	$('.langLink').removeClass("lang_selected");
	//alert('#lnkLang'+lang.toUpperCase());

	$('#lnkLang'+lang.toUpperCase()).addClass("lang_selected");
}

/**
 *
 * Univerzální funkce k načtení fotogalerií
 * @return html
 **/
function loadPhotoGallery(gallery_id, gallery_type){

	$.ajax({
	  	type: 'POST',
		url: urlBase + '/admin/ajax/loadPhotoGallery.php',
		dataType: 'json',
		data: {
			'id' : gallery_id,
			'type' : gallery_type,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#gallery_items').html(r.html);
			var countFoto = $('#gallery_items li').length;
			$('#fotoCountTab').html("Fotogalerie (" + r.count + ")");
			registerPhotoGalleryEvents();


		},
		failure: function() {
		},
		error: function () {
		}

	});
}

function registerPhotoGalleryEvents()
{

	$( ".photoGallery .modal-form").click(function(e){
			e.preventDefault();
			var that = $(this);
			var url = that.attr("data-url");
			var callback = that.attr("data-callback");
			var paramsCallbackFunction = that.attr("data-callback-params");
			loadModalForm(url,callback,"" + paramsCallbackFunction+"");
		});

/*
	$( ".photoGallery .delete-btn" ).click(function(event){

		event.preventDefault();
		var place_id =  $(this).siblings(".place_id").val();
		var gallery_id = $("#gallery_id").val();
		var gallery_type = $("#gallery_type").val();
		deleteFotoGallery(place_id,gallery_id,gallery_type);
	});
	*/
	$( ".photoGallery .main-btn" ).click(function(event){

		event.preventDefault();
		var place_id =  $(this).attr("data-place-id");
		var gallery_id = $("#gallery_id").val();
		var gallery_type = $("#gallery_type").val();
		setMainFoto2(place_id,gallery_id,gallery_type);
	});
	registerSortable();
}


function loadFilesGallery(gallery_id, gallery_type){

	$.ajax({
		type: 'POST',
		url: urlBase + '/admin/ajax/loadFilesGallery.php',
		dataType: 'html',
		data: {
			'id' : gallery_id,
			'type' : gallery_type,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#files_items').html(r);
			var countFoto = $('#files_items li').length;
			$('#filesCountTab').html("Soubory (" + countFoto+ ")");
			registerFilesGalleryEvents();


		},
		failure: function() {
		},
		error: function () {
		}

	});
}

function registerFilesGalleryEvents()
{
	$( ".filesGallery .delete-btn" ).click(function(event){

		event.preventDefault();

		var file_id =  $(this).siblings(".file_id").val();
		var gallery_id = $("#files_items").find( ".gallery_id" ).val();
		//alert(gallery_id);


	//	alert(file_id);
		//var gallery_id = $("#gallery_id").val();
		var gallery_type = $("#files_items").find( ".gallery_type").val();
		deleteFilesGallery(file_id,gallery_id,gallery_type);



		return false;
	});
}

/**
 *
 * Univerzální mazání fotky
 * @return html
 **/
function deleteFilesGallery(file_id, gallery_id, gallery_type){
	if (confirm("Opravdu chcete smazat soubor?"))
	{
		$.ajax({
			type: 'POST',
			url: UrlBase + 'admin/ajax/delFile.php',
			dataType: 'html',
			data: {
				'delete_file' : file_id,
				'rand' : Math.random()
			},
			success: function(r) {
				loadFilesGallery(gallery_id, gallery_type);

			},
			failure: function() {
			},
			error: function () {
			}

		});
	}
}

function loadStatistikaObjednavekTab()
{
	$('#statistikaObjednavekTab .fa-refresh').removeClass("fa-refresh").addClass("fa-spinner");
	$.ajax({
		type: "GET",
		url: urlBase + "/admin/ajax/OrderStatsTab.php",
		dataType: 'html',
		data: {
			'rand' : Math.random()
		},
		success: function(r) {
			$('#statistikaObjednavekTab').html(r);

			$('#statistikaObjednavekTab .refresh').click(function(event){
				loadStatistikaObjednavekTab();
			});
		}
	});
}

function loadUserActivityTab()
{
	$('#userActivityTab .fa-refresh').removeClass("fa-refresh").addClass("fa-spinner");
	$.ajax({
		type: "GET",
		url: urlBase +  "/admin/ajax/userActivityTab.php",
		dataType: 'html',
		data: {
			'rand' : Math.random()
		},
		success: function(r) {
			$('#userActivityTab').html(r);

			$('#userActivityTab .refresh').click(function(event){
				loadUserActivityTab();
			});
		}
	});
}




function aresLoad(that)
{
	$(that).html("hledám ...");
	var ico = $('#shipping_ico').val();
	$.ajax({
		type: "GET",
		url: urlBase +  "/admin/ajax/ares.php",
		dataType: 'json',
		data: {
			'rand' : Math.random(),
			'ic' : ico
		},
		success: function(r) {
			$('#shipping_first_name').val(r.firma);
			$('#shipping_dic').val(r.dic);
			$('#shipping_address_1').val(r.ulice);
			$('#shipping_city').val(r.mesto);
			$('#shipping_zip_code').val(r.psc);
			$(that).html("dotaženo.");
		}
	});

}


function registerSortable()
{
		$( ".photoGallery" ).sortable({
			disable: true,
		update: function(event, ui) {
            var info = $(this).sortable("serialize");

            $.ajax({
	            type: "POST",
	            url: urlBase +  "/admin/ajax/sort_items.php",
	            data: info,
	            context: document.body,
	            success: function(){

	            }
      		});
           }
       });
}

/**
 *
 * @access public
 * @return void
 **/
function showReloadDialog(){
	$('#slider-box').css('opacity','0.6');
	$('#slider-box').css('background-color','#000');
	$('#slider-box').css('height','100%');
	$('#slider-box').css('width','100%');
	$('#slider-box').css('display','block');
}
function hideReloadDialog(){
	$('#slider-box').css('display','none');
}
/**
 *
 * Univerzální funkce k načtení fotogalerií
 * @return html
 **/
function loadFullPhotoGallery(){

	dataGrid.loadData();
}
function loadCategoryPicker(type){

	if (type == undefined) {
		type = "category";
	}

	var selectedId = $('#category_id option:selected').val();

//	alert(selectedId);
//	return;
//	showReloadDialog();
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/loadCategoryPicker.php?type=' + type,
		dataType: 'html',
		data: {
			'selected' : selectedId,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#category_id').html(r);
			//hideReloadDialog();
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
function loadFullDataGallery(){

	dataGrid.loadData();
}
/**
 *
 * Univerzální mazání fotky
 * @return html
 **/
function deleteFotoGallery(foto_id, gallery_id, gallery_type){
	if (confirm("Opravdu chcete smazat fotografii?"))
	{
		$.ajax({
		  	type: 'POST',
			url: UrlBase + 'admin/ajax/delFoto.php',
			dataType: 'json',
			data: {
				'delete_foto' : foto_id,
				'gallery_id' : gallery_id,
				'gallery_type' : gallery_type,
				'rand' : Math.random()
			},
			success: function(r) {
				loadPhotoGallery(gallery_id, gallery_type);

			},
			failure: function() {
			},
			error: function () {
			}

		});
	}
}



/**
 *
 * Univerzální mazání
 * @return html
 **/
function setMainFoto2(foto_id, gallery_id, gallery_type){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/setMainFoto.php',
		dataType: 'json',
		data: {
			'foto_id' : foto_id,
			'gallery_id' : gallery_id,
			'gallery_type' : gallery_type,
			'rand' : Math.random()
		},
		success: function(r) {

			if (r.status == "ok") {
				getMainFoto(foto_id);
			}

	//	$('#productfotoMain').html(r);

		},
		failure: function() {
		},
		error: function () {
		}

	});
}

function getMainFoto(foto_id){
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/getMainFoto.php',
		dataType: 'html',
		data: {
			'foto_id' : foto_id,
			'rand' : Math.random()
		},
		success: function(r) {
		$('#productfotoMain').html(r);

		},
		failure: function() {
		},
		error: function () {
		}

	});
}


/**
 *
 * Univerzální funkce pro změnu pořadí stránky
 * @return html
 **/
function changePageLevel(page_id, position, page_type){

	showReloadDialog();
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/changePageLevel.php',
		dataType: 'html',
		data: {
			'id' : page_id,
			'type' : page_type,
			'position' : position,
			'rand' : Math.random()
		},
		success: function(r) {

			loadTree(page_type);
		},
		failure: function() {
			hideReloadDialog();
		},
		error: function () {
			hideReloadDialog();
		}

	});
}


function loadTree(page_type){

	if (page_type == undefined) {
		page_type = "category";
	}
	showReloadDialog();
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/loadTree.php?type=' + page_type,
		dataType: 'html',
		data: {
			'rand' : Math.random()
		},
		success: function(r) {
			$('#treedata').html(r);

			$('#treedata').html(r);

				$("#treecat").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black"
	});

			hideReloadDialog();
		},
		failure: function() {
			hideReloadDialog();
		},
		error: function () {
			hideReloadDialog();
		}

	});
}

function check_version(){

	showReloadDialog();
	$.ajax({
		type: 'POST',
		url: UrlBase + 'admin/ajax/check_version.php',
		dataType: 'json',
		data: {
			'rand' : Math.random()
		},
		success: function(r) {
			if (r.upgrade != "") {



				$( ".check_version" ).click(function(event) {
					event.preventDefault();
					if (confirm("Instalovat novou verzi?")) {
						$(".check_version").text("Probíhá instalace ...");
						upgrade_version();
					}


				});


			}
			$(".check_version").text(r.status);
		//	alert(r.status);
			hideReloadDialog();
		},
		failure: function() {
			hideReloadDialog();
		},
		error: function () {
			hideReloadDialog();
		}

	});
}


function upgrade_version(){

	showReloadDialog();
	$.ajax({
		type: 'POST',
		url:urlBase +  '/install/version.php',
		dataType: 'html',
		data: {
			'rand' : Math.random()
		},
		success: function(r) {
			alert("Nová verze byla nainstalována!");
			location.reload(true);
			hideReloadDialog();
		},
		failure: function() {
			hideReloadDialog();
		},
		error: function () {
			hideReloadDialog();
		}

	});
}

function loadSysTree(){

	showReloadDialog();
	$.ajax({
		type: 'POST',
		url: UrlBase + 'admin/ajax/loadSysTree.php',
		dataType: 'html',
		data: {
			'rand' : Math.random()
		},
		success: function(r) {
			$('#treedata').html(r);

			$('#treedata').html(r);

			$("#treecat").treeview({
				control: "#treecontrol",
				persist: "cookie",
				cookieId: "treeview-black"
			});

			hideReloadDialog();
		},
		failure: function() {
			hideReloadDialog();
		},
		error: function () {
			hideReloadDialog();
		}

	});
}

function loadCiselnikTree(ciselnik){

	showReloadDialog();
	$.ajax({
		type: 'GET',
		url: UrlBase + 'admin/ajax/loadCiselnikTree.php',
		dataType: 'html',
		data: {
			'ciselnik' : ciselnik,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#treedata').html(r);

			$('#treedata').html(r);

			$("#treecat").treeview({
				control: "#treecontrol",
				persist: "cookie",
				cookieId: "treeview-black"
			});

			hideReloadDialog();
		},
		failure: function() {
			hideReloadDialog();
		},
		error: function () {
			hideReloadDialog();
		}

	});
}

/**
 *
 * Kontrola nových zpráv
 * @return html
 **/
function MsgCheck(){

	var timeout = 30 * 1000;
	var status = MsgLoad();
	if (status) {
	//	setTimeout('MsgCheck()', timeout);
	}


}
/**
 *
 * @access public
 * @return void
 **/
function showMSG(){

	if ($("#msgresult").is(":visible")) {
		$("#msgresult").hide();
		setCookie("open_msgbox","0",999);
	} else {
		$("#msgresult").show();
		setCookie("open_msgbox","1",999);
	}

	//$('#msgresult').slideDown();

}

msg=top.document.title; // převzít aktuální text z titulku okna
l=msg.length; // zjistit délku
i=l-1; // počet rolovaných znaků
function movetitle()
{
  top.document.title=msg.substring(i,l)+msg.substring(i,0); // nastavit titulek na odříznutý počet rolovaných znaků z konce a přidat zbytek začátku
  i=(i+1) % l // posunout rolování - zvýšit o počet rolovaných znaků a vypočítat zbytek po vydělení počtem rolovaných znaků
}

/**
 *
 * @access public
 * @return void
 **/
var checkTimer = null;
var oldtitle = $('title').html();
function bliktitle(t){

	if ($("#msgstatus a").hasClass("select")) {
		$("#msgstatus a").removeClass("select");
	} else {
		$("#msgstatus a").addClass("select");
	}
	if (oldtitle == $('title').html()) {
		$('title').html(t);
	} else
	{
		$('title').html(oldtitle);
	}
	var myfunc = 'bliktitle("'+t+'")';
	checkTimer = setTimeout(myfunc, 1000);
}

function stopTimer() {
    clearInterval(checkTimer);
    checkTimer = null;
}
var countNewMessage = 0;
function setPlayNewMessage(count) {

	// prehraj pouze pribyla-li dalsi nova zprava
	//if (count > countNewMessage) {
		countNewMessage = count;
		$('#chat_sound').remove();
		$('#chat_sound').html("");

		$('body').append('<div id="chat_sound"><audio autoplay="true"><source src="/admin/chat_sound.mp3" type="audio/mpeg">Your browser does not support this audio format.</audio></div>');

    	//$('body').append('<embed id="chat_sound" src="/admin/chat_sound.mp3" autostart="true" hidden="true" loop="false">');
//	}
}
/**
 *
 * Kontrola nových zpráv
 * @return html
 **/


function MsgLoad(){

	var timeout = 180 * 1000;
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/msgcheck.php',
		dataType: 'json',
		data: {
			'rand' : Math.random()
		},
		success: function(r) {
			stopTimer();
			if (r.count > -1) {

				if (r.count > 0) {
			//	var oldtitle = $('title').html();
				//$('title').html('zpráva (0)' + oldtitle);
				var newTitle = 'bliktitle("Nová zpráva (' + r.count + ') '+oldtitle+'")';
				bliktitle('Nová zpráva (' + r.count + ') '+oldtitle);

				setPlayNewMessage(r.count);

				//setTimeout(newTitle,1000); // nastavit opakované provádění rolování
				/*
				var interval = 4000;
				$.doTimeout(interval,function() {
					$('title').html('zpráva (0)' + oldtitle);
				});
				*/
			//	$.playSound('/admin/chat_sound.mp3');



				}
				//' + UrlBase + '/messages.php
				var rhtml = '<a class="" href="' + UrlBase + 'admin/message">zprávy (' + r.count + ')</a>';

				//var rhtml = '<a class="select" href="javascript:showMSG();">zprávy (' + r.count + ')</a>';
				rhtml +='<div id="msgresult" style="display:none;">';
				rhtml +='<a href="' + UrlBase + '/add_message"><span>napsat zprávu</span></a>';
				rhtml +='<ul>';
				var len = r.msgs.length;
				for (var i = 0; i < len; i++)
			    {
			    	rhtml +='<li><span class="nick"><a href="' + UrlBase + 'admin/user_detail?id='+r.msgs[i].id+'">' + r.msgs[i].nick + '</a>:</span><span>' + r.msgs[i].message + '</span></li>';
			    }
				rhtml +='</ul>';
				rhtml +='</div>';
				$('#msgstatus').html(rhtml);


			} else {
				$('#msgstatus').html('zpráva (0)');
			}


			if (getCookie("open_msgbox") == "1") {
				$("#msgresult").show();
			}
			setTimeout('MsgCheck()', timeout);
			return true;
		},
		failure: function() {
		//	alert('Došlo k chybě při komunikaci se serverem!');
			return false;
		},
		error: function () {
		//	alert('Došlo k chybě při komunikaci se serverem!');
			return false;
		}

	});
}

/**
 *
 * Univerzální mazání
 * @return html
 **/
function aktualizujStavSortimentu(product_id){
	if ($('#aktivni_'+product_id).hasClass("vyrizena")){
		if (confirm("Opravdu chcete DEAKTIVOVAT produkt?")) {

		} else {
			return;
		}
	}
	var statusText = "čekejte...";
	$('#aktivni_'+product_id).html(statusText);
	$.ajax({
	  	type: 'POST',
		url: UrlBase + 'admin/ajax/aktualizaceStavuSortimentu.php',
		dataType: 'json',
		data: {
			'id' : product_id,
			'rand' : Math.random()
		},
		success: function(r) {

		var statusText = "";
		if (r.status == 1) {
			statusText = "aktivní";
			$('#aktivni_'+product_id).removeClass("storno");
			$('#aktivni_'+product_id).addClass("vyrizena");
		} else {
			statusText = "neaktivní";
			$('#aktivni_'+product_id).addClass("storno");
			$('#aktivni_'+product_id).removeClass("vyrizena");
		}
		$('#aktivni_'+product_id).html(statusText);

		},
		failure: function() {
			alert('Došlo k chybě při komunikaci se serverem!');
		},
		error: function () {
			alert('Došlo k chybě při komunikaci se serverem!');
		}

	});
}
function attrChecked(el)
{
	var originalId = $(el).parent().parent().siblings(".attribute_original_id").val();

//	$(el).parent().parent().siblings(".attribute_id").val(0);
	if ($(el).is(':checked'))
	{
		console.log("zaskrtnuto");
		//alert(originalId);
		$(el).parent().parent().siblings(".attribute_id").val(originalId);
	//	$(el).parent().parent().siblings(".selectbox").css("display","inline");

	//	$(el).parent().parent().siblings(".form-group").children(".attribute_id").val(originalId);
		$(el).parent().parent().siblings(".form-group").find(".selectbox").css("display","inline");



	} else {
		console.log("odskrtnuto");
	//	$(el).parent().parent().siblings(".form-group").children(".attribute_id").val(0);
		$(el).parent().parent().siblings(".form-group").find(".selectbox").css("display","none");
		$(el).parent().parent().siblings(".attribute_id").val(0);
	//	$(el).parent().parent().siblings(".selectbox").css("display","none");
		//	alert("odĹˇkrtnuto");

	}
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
	console.log(paramsCallbackFunction);
		console.log("Běží: loadModalBase");
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
				console.log("ruda");
				console.log(callbackFunction);
				if (callbackFunction && typeof(callbackFunction) === "function") {
					callbackFunction(paramsCallbackFunction);
				}

				console.log(callbackFunction+"("+paramsCallbackFunction+")");
				setTimeout(callbackFunction+"("+paramsCallbackFunction+")", 0);

				return;
			}
			blockFormmyModal=false;
			$("#bs-container").html(r.html);
			openModalForm(formId);

			$("#myModal-form .datepicker").datepicker();
			// nastav submit
			console.log("nastavuji submit");
			$("#myModal-form").on( "submit",function(e){
				e.preventDefault();

				if (!blockFormmyModal){

					var url = $("#myModal-form").attr("action");
					saveData(url, callbackFunction, paramsCallbackFunction);
				}
			});
		}
	});
}

function reloadPage()
{
	location.reload();
}
function loadModalBase2(data, url, callbackFunction, paramsCallbackFunction)
{
	var formId = "myModal";
	console.log("Běží: loadModalBase2");
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
			blockFormmyModal=false;
			$("#bs-container").html(r.html);
			openModalForm(formId);




			// nastav submit
			console.log("nastavuji submit");
			$("#myModal-form").on( "submit",function(e){
				e.preventDefault();

				if (!blockFormmyModal){

					var url = $("#myModal-form").attr("action");
					saveData(url, callbackFunction);
				}
			});
		}
	});
}

function saveData(url, callbackFunction, paramsCallbackFunction){
	//console.log(action);
	console.log("saveData");

	var data = $("#myModal-form").serialize();
//	var url = $("#myModa-form").attr("action");

	loadModalBase2(data,url, callbackFunction, paramsCallbackFunction);
}







var DataGridProvider3=function(args){
	this.gridId = args.id;
	this.modelName = args.modelName;
	this.Wrapper = args.wrapper;
//	this.dataLimit = 5;
	this.pageNumber = 1;
	this.orderBy = "";
	this.sort = "";
	this.search = "";
	this.isModal = false;
	this.url = "/admin/ajax/dataGrid.php";

};

$.extend(DataGridProvider3.prototype, {

	dataLoaded : false,
	dataLimit : "",
	filterDefinitionId : 0,
	params : {},
	loadData : function () {


		var o = this;
		if (o.dataLoaded) {
			return;
		}

		$( '<div class="datagrid-overlay"></div>' ).appendTo( "#grid-container" );

		$( '.datagrid-overlay' ).show();
		this.dataLoaded = true;
		console.log("ataGridProvider3.prototype.loadData");
		var url=this.url+ "?gridId=" + this.gridId + "&model=" + this.modelName + this.getWrapperQuery() + this.getPageLimitQuery() + "&pg=" + this.getPageNumber() + this.getOrderByQuery()+this.getModalQuery()+this.getSearchQuery();
		$.ajax({
			type: "POST",
			url: url,
			dataType: "json",
			data : this.getParams(),

			success: function(r) {
				o.filterDefinitionId = r.fd_id;
				$("#grid-container").html(r.html);
				o.spolecnaAkcePoPrijetiOdpovedi();
			},
			failure: function() {
				o.spolecnaAkcePoPrijetiOdpovedi();
			},
			error: function () {
				o.spolecnaAkcePoPrijetiOdpovedi();
			}

		});
	}


	,
	spolecnaAkcePoPrijetiOdpovedi : function () {
		console.log("ataGridProvider3.prototype.registerGridEvent");
		this.registerGridEvent();
		this.dataLoaded = false;
	//	$( '<div class="datagrid-overlay"></div>' ).appendTo( "#grid-container" );
	},
	getPageLimit : function() {
		return this.dataLimit;
	},

	setParams : function(params) {
		this.params = params;
	},

	getParams : function() {
		return this.params;
	},

	setModal : function(modal) {
		this.isModal = modal;
	},
	getModal : function() {
		return this.isModal;
	},

	getModalQuery : function() {
		if (this.isModal) {
			return "&isModal";
		}
		return "";

	},

	getSearchQuery : function() {
		if (this.search != "") {
			return "&q=" + this.search;
		}
		return "";

	}
	,

	getWrapperQuery : function() {
		if (this.Wrapper) {
			return "&wrapper=" + this.Wrapper;
		}
		return "";

	},
	getPageLimitQuery : function() {
		if (this.getPageLimit() > 0) {
			return "&limit="+this.getPageLimit();
		}
		return "";

	},

	getOrderByQuery : function() {
		if (this.orderBy !="") {
			return "&"+this.orderBy;
		}
		return "";

	},

	getPageNumber : function() {
		return this.pageNumber;
	},

	getFilterDefinitionId : function() {
		return this.filterDefinitionId;
	},
	registerGridEvent : function (){
		var o = this;
		console.log("."+this.gridId+"-modal-form");
		$("."+this.gridId+"-modal-form").on( "click",function(e){
			e.preventDefault();
			console.log("klik");
			var that = $(this);
			var url = that.attr("data-url");
			var data = {};
			o.loadModalBase(data, url);
		});

		$("#grid-container .LimitFilter").on( "change",function(e){
			var that = $(this);
			console.log("limit"+that.val());
			o.dataLimit = that.val();
			o.loadData();
		});


		$("#grid-container .pglist a").on( "click",function(e){
			e.preventDefault();
			console.log("strankovani");
			var that = $(this);
			var page = that.attr("href");

			o.pageNumber = page.replace("#","");
			o.loadData();
		});


		$("#grid-container th a").on( "click",function(e){
			e.preventDefault();

			var that = $(this);
			var page = that.attr("href");

			o.orderBy = page.replace("#","");
			o.loadData();
		});


		$("#grid-container tr").on( "dblclick",function(e){
		//	e.preventDefault();
			var editLink = $(this).find(".editLink");
			var dataUrl = $(editLink).attr("data-url");
			if ( typeof dataUrl === "undefined") {
				var url = $(editLink).attr("href");
				$(location).attr("href",url);

			} else {
				var url = $(editLink).attr("data-url");
				var data = {};
				o.loadModalBase(data, url);
			}
			return false;
		});



		$("#grid-container .grid-settings").on( "click",function(e){
			e.preventDefault();
			console.log("nastavení");
			var that = $(this);
			var page = that.attr("href");

			var data = {};
			o.loadModalBase(data, o.url +  "?model=" + o.modelName+"&do=setting&id="+o.getFilterDefinitionId());

		});

		$("#grid-container .grid-refresh").on( "click",function(e){
			e.preventDefault();
			console.log("refresh");
			o.loadData();

		});


		$("#grid-container .form-search").on( "submit",function(e){
			e.preventDefault();
			o.search = $("#grid-container .form-search .search-text").val();
			o.loadData();
		});




		$("#grid-container .actionSubmit").on( "submit",function(e){
			e.preventDefault();

			//if (!blockFormmyModal){

			var url = $(this).attr("action");
			o.deleteData("?do=");
			//	}
		});




		$('#grid-container a.lightbox').fancybox({
			transition: 'elastic',
			fixed: true,

			current: 'obrázek č. {current} z {total}',

			slideshow: false,
			slideshowSpeed: 3000,
			slideshowAuto: false
		});




	},

	loadModalBase : function(data, url)
	{
		var o = this;


		var formId = "myModal";
		console.log("DataGridProvider3.loadModalBase()");
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
					o.loadData();
					return;
				}
				blockFormmyModal=false;
				$("#bs-container").html(r.html);
				openModalForm(formId);

				$("#myModal-form .datepicker").datepicker();
				// nastav submit
				console.log("nastavuji submit");
				$("#myModal-form").on( "submit",function(e){
					e.preventDefault();

					if (!blockFormmyModal){

						var url = $("#myModal-form").attr("action");
						o.saveData(url);
					}
				});
			}
		});
	},
	deleteData : function(url){
		var o = this;

		if (o.dataLoaded) {
			return;
		}
		this.dataLoaded = true;
		var data = $(".actionSubmit").serialize();
		//	var url="?model=" + o.modelName;
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",

			success: function() {
				o.spolecnaAkcePoPrijetiOdpovedi();
				o.loadData();

			},
			failure: function() {
				o.spolecnaAkcePoPrijetiOdpovedi();
			},
			error: function () {
				o.spolecnaAkcePoPrijetiOdpovedi();
			}

		});
	},

	modalFormCreate : function(urlParam)
	{
		var o = this;
		console.log(urlParam);
		var url = "?do=create";
		if (typeof urlParam !== "undefined") {
			url = urlParam;
		}

		var data = {
		};
		// $("#myModal-form").serialize();
		o.loadModalBase(data,url);
	},
	saveData : function(url){
		var o = this;
		var data = $("#myModal-form").serialize();
		o.loadModalBase(data,url);
	}
});


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


/*
jQuery(function($){
$('select').each(function(i, e){
if (!($(e).data('convert') == 'no')) {
if (!($(e).data('convert') == 'no')) {
$(e).hide().wrap('<div class="btn-group" id="select-group-' + i + '" />');
var select = $('#select-group-' + i);

var xSelect = $(e).attr('id')
var xLabel = $("#"+xSelect + " option:selected").text();

if (xLabel.length == 0) {
xLabel = '&nbsp;';
}

var current = ($(e).val()) ? $(e).val(): '&nbsp;';
select.html('<input type="hidden" value="' + $(e).val() + '" name="' + $(e).attr('name') + '" id="' + $(e).attr('id') + '" class="' + $(e).attr('class') + '" /><a class="btn" href="javascript:;">' + xLabel + '</a><a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="caret"></span></a><ul class="dropdown-menu"></ul>');
$(e).find('option').each(function(o,q) {
select.find('.dropdown-menu').append('<li><a href="javascript:;" data-value="' + $(q).attr('value') + '">' + $(q).text() + '</a></li>');
if ($(q).attr('selected')) select.find('.dropdown-menu li:eq(' + o + ')').click();
});
select.find('.dropdown-menu a').click(function() {
select.find('input[type=hidden]').val($(this).data('value')).change();
select.find('.btn:eq(0)').text($(this).text());
});
}
});
});*/


function handleSidebarState () {
	// remove sidebar toggler if window width smaller than 900(for table and phone mode)
	if ($(window).width() < 980) {

		// Pro menší rozlišení se autoamticky sidebar zakáže
		$('body').removeClass("page-sidebar-closed");
		$('body').removeClass("page-sidebar-fixed");
	} else {
		$('body').addClass("page-sidebar-fixed");
		if (getCookie("slim-sidebar") == "1") {
			$('body').addClass("page-sidebar-closed");
		}
	}

	$( "#rozliseni" ).html($( window ).width()+'x'+$( window ).height());


//	$('.page-sidebar').height($('#sideMenu').height());

}

//page-sidebar-fixed = menu fixované
//page-sidebar-closed = zasunuté menu

//page-sidebar-hover-on = vysunuté menu

/**

 .page-sidebar-closed .page-content {
 margin-left: 35px !important;
 }

 * */
function sidebarMove()
{
	if (getCookie("slim-sidebar") == "1") {
		// sidebar je vyjížděcí
		if ($(this).hasClass("slim-sidebar")) {
			$(this).removeClass("slim-sidebar");
		}
	}
}

function zapamatujSideBar()
{
	if (getCookie("slim-sidebar") == "1") {
		setCookie("slim-sidebar",0,99999);
	} else {
		setCookie("slim-sidebar",1,99999);
	}
}
/*
function nastavSideBar()
{
if (getCookie("slim-sidebar") == "1") {
$('body').addClass("page-sidebar-closed");
}
}
*/

var sidebarWidth = 220;
var sidebarCollapsedWidth = 35;

$(window).resize(function(){
	handleSidebarState();
});


var _calculateFixedSidebarViewportHeight = function () {
	var sidebarHeight = $(window).height() - $('header').height() -15;
//	console.log(sidebarHeight);
	if ($('body').hasClass("page-sidebar-fixed")) {
		sidebarHeight = sidebarHeight - $('footer').height()-50;
		console.log(sidebarHeight);
	}
	return sidebarHeight;
}


$(document).ready(function(){


	//$( ".page-sidebar-menu" ).draggable({ scroll: true });

	var sidebarHeight = _calculateFixedSidebarViewportHeight();

	$('.scrollDiv').slimScroll({
		height: sidebarHeight,
		allowPageScroll: false,
		disableFadeOut: false
	});

//	$('.tabs-min').tabs();
	handleSidebarState();
	//	nastavSideBar();
	$(".sidebar-toggler").click(function(e){
		zapamatujSideBar();
		var body = $('body');
		var sidebar = $('.page-sidebar');

		if (body.hasClass("page-sidebar-fixed") === false) {

			if (body.hasClass("page-sidebar-expanded")) {
				body.removeClass("page-sidebar-expanded");
			} else {
				body.addClass("page-sidebar-expanded");

			}
			return;
		}
		if ((body.hasClass("page-sidebar-hover-on") && body.hasClass("page-sidebar-fixed")) || sidebar.hasClass('page-sidebar-hovering')) {
			// zafixování pozice ve Fix modu
			body.removeClass('page-sidebar-hover-on');
			sidebar.css('width', '').hide().show().removeAttr( 'style' )
			//sidebar.hide().show();
			e.stopPropagation();
			//	runResponsiveHandlers();
			return;
		}

		if (body.hasClass("page-sidebar-closed")) {
			body.removeClass("page-sidebar-closed");
			if (body.hasClass('page-sidebar-fixed')) {
				sidebar.css('width', '');
			}
		} else {
			body.addClass("page-sidebar-closed");

		}

	});


	$('.page-sidebar').off('mouseenter').on('mouseenter', function () {
		var body = $('body');

		if (body.hasClass("page-sidebar-fixed")=== false) {
			return;
		}

		if (body.hasClass('page-sidebar-closed') === false || $(this).hasClass('page-sidebar-hovering')) {
			return;
		}

		body.removeClass('page-sidebar-closed').addClass('page-sidebar-hover-on');
		$(this).addClass('page-sidebar-hovering');
		$(this).animate({
			width: sidebarWidth
		}, 400, '', function () {
			$(this).removeClass('page-sidebar-hovering');
		});
	});

	$(".page-sidebar").off('mouseleave').on('mouseleave',function(){

		var body = $('body');
		if (body.hasClass("page-sidebar-fixed")=== false) {
			return;
		}
		if (body.hasClass('page-sidebar-hover-on') === false || $(this).hasClass('page-sidebar-hovering')) {
			return;
		}
		$(this).addClass('page-sidebar-hovering');
		$(this).animate({
			width: sidebarCollapsedWidth
		}, 400, '', function () {
			$(body).addClass('page-sidebar-closed').removeClass('page-sidebar-hover-on');
			$(this).removeClass('page-sidebar-hovering');
		});

	});
//	$(".dropdown-toggle").dropdown('toggle');
});



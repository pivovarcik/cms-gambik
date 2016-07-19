//var UrlBase = "/admin/ajax";
function loadKalendarTerminy(mesic,rok)
{
	loadKalendar(mesic,rok,loadTerminy,loadKalendarTerminy,"calPlatno");
}

// obecna funkce
function loadZaznamyProKalenar(mesic, rok, url, callback)
{
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'json',
		data: {
			'month' : mesic,
			'year' : rok,
			'rand' : Math.random()
		},
		success: function(r) {
			nactiZaznamyDoPlachty(r);
			registerEventPlocha(callback);
			endLoadKalendar();
		}
	});
}
function loadTerminy(mesic,rok,callback)
{
	loadZaznamyProKalenar(mesic,rok,UrlBase + '/ajax/loadKalendarObjednavky.php', callback);
}

function startLoadKalendar()
{
	$('#cboxOverlay').css("display","block")
	.css("opacity",0.5);
}
function endLoadKalendar()
{
	$('#cboxOverlay').css("display","none")
	.css("opacity",0);
}
/**
 * @mesic - vstupní podmínka
 * @rok -  vstupní podmínka
 * @callbackFunction - funkce volaná po sestavení plátna
 * @registerFunction - funkce pro registraci událostí na kalendáři
 * @platnoId - id plátna
* */
function loadKalendar(mesic,rok,callbackFunction,registerFunction,platnoId)
{
	startLoadKalendar();
	$.ajax({
		type: 'GET',
		url: UrlBase + '/ajax/loadKalendarPlatno.php',
		dataType: 'html',
		data: {
			'month' : mesic,
			'year' : rok,
			'rand' : Math.random()
		},
		success: function(r) {
			$('#'+platnoId).html(r);

			// po nacteni platna dotazeni zaznamu
			callbackFunction(mesic,rok,registerFunction);
		}
	});
}

function nactiZaznamyDoPlachty(data)
{
	$.each(data, function(i, item) {
		var ul = $('#dayBox' + item.start_date + ' ul');
		$("<li></li>")
		.append($('<a title="' + item.description + ' \n' + item.cost_total + '" class="status' + item.status_class + '" href="' + item.link_edit + '"></a>').html(item.title))
		.appendTo(ul);

		var li = ul.children("li");

		if ( li.length > 4 ) {
			li.css("width","50%");
		}
		if ( li.length > 6 ) {
			li.css("width","33%");
		}
		if ( li.length > 8 ) {
			li.css("width","25%");
		}
		if ( li.length > 10 ) {
			li.css("width","20%");
		}
	});
}
// zaregistruje udalosti nad kalendarem
function registerEventPlocha(callback) {

	$('.button-next').click(function(event){
		event.preventDefault();
		var mesic = $('#monthSelect').val();
		var rok = $('#yearSelect').val();
		mesic = mesic * 1;
		rok = rok * 1;
		if (mesic+1 >12) {
			mesic = 1;
			rok = rok+1;
		} else {
			mesic = mesic+1;
		}
		callback(mesic,rok);
	});

	$('.button-prev').click(function(event){
		event.preventDefault();
		var mesic = $('#monthSelect').val();
		var rok = $('#yearSelect').val();
		mesic = mesic * 1;
		rok = rok * 1;
		if (mesic-1 == 0) {
			mesic = 12;
			rok = rok-1;
		} else {
			mesic = mesic-1;
		}
		callback(mesic,rok);
	});
}
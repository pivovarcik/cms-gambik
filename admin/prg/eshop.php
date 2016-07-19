<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);

//print_r($_POST);
$pagetitle = "Elektronický obchod";

$cokoliv = '
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript">
$(document).ready(function() {
	loadStatistikaObjednavekTab();
	//loadUserActivityTab();


});


		$(function() {

		var options = {
			lines: {
				show: true
			},
			points: {
				show: true
			},
			xaxis: {
				minTickSize: [1, "day"]
			},
			colors: [ "#425769", "blue" ],
			xaxes: [ { mode: "time",  monthNames : ["Led", "Úno", "Bře", "Dub", "Kvě", "Čer", "Čnc", "Srp", "Zář", "Říj", "Lis", "Pro"] } ]
		};

		var data = [];


		$.ajax({
			url: "/admin/ajax/OrderStatsGraf.php",
			type: "GET",
			dataType: "json",
			success: onDataReceived
		});

		var alreadyFetched = {};
		function onDataReceived(series) {

			if (!alreadyFetched[series.label]) {
				alreadyFetched[series.label] = true;
				data.push(series);
			}

			$.plot("#placeholder", data, options);
		}

	});
</script>';
$GHtml->setCokolivToHeader($cokoliv);
$GHtml->setServerJs("/js/flot/jquery.flot.js");
$GHtml->setServerJs("/js/flot/jquery.flot.time.js");

//$Kalendar = new GCalender(12,2013);

$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

	<form class="standard_form" method="post">

		<div id="dashboard">

			<div id="statistikaObjednavekTab" class="table_info"></div>
						<div class="table_info">
				<h5>Vývoj prodeje</h5>
					<div class="demo-container">
						<div id="placeholder" class="demo-placeholder"></div>
					</div>
			</div>
			<div id="userActivityTab" class="table_info"></div>


			<div class="clearfix"></div>

		</div>

	</form>

<?php
include PATH_TEMP . "admin_body_footer.php";
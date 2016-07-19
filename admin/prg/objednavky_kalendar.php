<?php

//print_r($_POST);
$pagetitle = "Kalendář objednávek";

$GHtml->setServerJs("/admin/js/kalendar.js");

$cokoliv = '<script type="text/javascript">
$(document).ready(function() {
	//loadStatistikaObjednavekTab();
	loadKalendarTerminy("","");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);


$Kalendar = new GCalender(12,2013);

//print $Kalendar->getPrvniZobrazenyDatum() . " - " . $Kalendar->getPosledniZobrazenyDatum();

$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<div class="wraper">

<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>
<div class="buttons"><a href="<?php print URL_HOME . 'objednavky'; ?>">Zobrazit objednávky</a> <a href="<?php print URL_HOME . 'objednavky_detailne'; ?>">Zobrazit detailní přehled</a> <a href="/admin/objednavky_kalendar">Zobrazit kalendář</a> <a href="<?php print URL_HOME . 'objednavka_add'; ?>"><i class="fa fa-plus-square"></i> Nová objednávka</a></div>

	<?php print getResultMessage();?>
</div>
	<form class="standard_form" method="post">
<legend>


<div id="calPlatno" class=""></div>


  </legend>
	</form>

</div>
<?php
include PATH_TEMP . "admin_body_footer.php";
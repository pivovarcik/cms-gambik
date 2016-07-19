<?php

$fakturyController = new FakturyController();
$fakturyController->saveAction();

$url = $TreeMenu->getUserUrlQuery(URL_HOME . "eshop/faktury");
$nextPrevButton = $fakturyController->getNextPrevButton($_GET["id"], $url);

$form = new Application_Form_FakturaEdit();
$formRadek = new Application_Form_RadekFakturyEdit();

define("AKT_PAGE", "/faktura_detail.php");

$GHtml->setServerJs('/admin/js/doklad.php?radekForm=' . get_class($formRadek) );

$script = '<script type="text/javascript">
	$(function() {
		$( "#pay_date" ).datepicker();
		$( "#faktura_date" ).datepicker();
		$( "#order_date" ).datepicker();
		$( "#maturity_date" ).datepicker();
		$( "#duzp_date" ).datepicker();
	});

</script>';
$GHtml->setCokolivToHeader($script);



$pagetitle = "Editace faktury " . $form->getElement("code")->getValue();
$cat->pagetitle = $pagetitle;
$cat->title = $pagetitle;
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();

$pageButtons[] = $nextPrevButton;
$pageButtons[] = $form->getElement("save")->render();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'eshop/faktura_add">Nová</a>';

?>

<form method="post" class="standard_form">

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php
print $form->Result();
?>

<?php
$GTabs = new FakturaTabs($form);
print $GTabs->makeTabs();
?>
<div class="clearfix"> </div>

<?php print $formRadek->tableRender(); ?>

 <table class="table_header">
	<tr>
		<td colspan="5">
			<input class="tlac" type="button" name="add" value="Přidej" onclick="createRadek('<?php print get_class($formRadek); ?>');">
		 	<input class="tlac" type="button" name="del" value="Zruš" onclick="deleteRadek();">
		</td>
		 <td colspan="2" align="right">
		    <span>Celková částka:</span>
		</td>
		<td class="column-cena">
			<?php print $form->getElement("cost_subtotal")->render(); ?>
		</td>
	</tr>

	<tr>
		<td align="left" colspan="5">
		</td>
		<td class="sazba" colspan="2"  align="right" style="width:200px">
	 		Sazba DPH v zákonné výši
		</td>

		<td class="column-cena">
			<?php print $form->getElement("cost_tax")->render(); ?>
			</td>
	</tr>
	<tr>
			<td align="left" colspan="5">
		</td>
		<td  colspan="2"  align="right">
	    <span style="font-size:12px;font-weight:bold">Celková částka vč. DPH:</span>
		</td>
		<td class="column-cena">
		<?php print $form->getElement("cost_total")->render(); ?>
		</td>
	</tr>

</table>



</form>

<?php
include PATH_TEMP . "admin_body_footer.php";

<?php
$cat = new PageComposite();
$fakturyController = new FakturyController();
$fakturyController->createAction();

$form = new Application_Form_FakturaCreate();
$formRadek = new Application_Form_RadekFakturyCreate();

define("AKT_PAGE", "/faktura_add");

$GHtml->setServerJs('/admin/js/doklad.php');

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


$pagetitle = "Pořízení vydané faktury " . $form->getElement("code")->getValue();
$cat->title = $pagetitle;

$cat->serial_cat_url = "|root|eshop|faktury|faktura_add";
$cat->serial_cat_title = "|Nástěnka|Eshop|Faktury|" . $pagetitle ;


$pageButtons = array();
$pageButtons[] = $form->getElement("ins")->render();

$pagetitle = "Pořízení faktury ";
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";


?>

<?php
print $form->Result();
?>

<form method="post" class="standard_form">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>



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

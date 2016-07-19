<?php
/*
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
*/

$cat = new PageComposite();

define('AKT_PAGE',URL_HOME . 'objednavka_detail?id=' . $_GET["id"]);

if(class_exists('ObjednavkaController')){
	$orderController = new ObjednavkaController();
} else {
	$orderController = new OrderController();
}

$orderController->saveAction();
$orderController->createFakturaAction();
$orderController->odeslatEmailStavObjednavkyAction();

$url = $TreeMenu->getUserUrlQuery(URL_HOME . "eshop/objednavky");
$nextPrevButton = $orderController->getNextPrevButton($_GET["id"], $url);

$form = new Application_Form_ObjednavkaEdit();
$formRadek = new Application_Form_RadekObjednavkyEdit();



//$GHtml->setServerJs('/admin/js/doklad.php');

$GHtml->setServerJs("/admin/js/doklad.php?radekForm=" . get_class($formRadek));


$pagetitle = "Přijatá objednávka č.: " .$form->getElement("code")->getValue();
$cat->pagetitle = $pagetitle;
$cat->title = $pagetitle;


$cat->serial_cat_url = "|root|eshop|objednavky|objednavka_detail";
$cat->serial_cat_title = "|Nástěnka|Eshop|Objednávky|" . $pagetitle ;

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";


$pageButtons = array();

$pageButtons[] = $nextPrevButton;
$pageButtons[] = $form->getElement("save")->render();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'eshop/objednavka_add">Nová</a>';
$pageButtons[] = '<a target="_blank" class="btn btn-sm btn-default" href="'.  URL_HOME . 'orders_pdf.php?id=' . $_GET["id"] . '">Tisk PDF</a>';
$pageButtons[] = '<a class="btn btn-sm btn-default" href="mailto:' . $form->getElement("shipping_email")->getValue() . '">Odeslat email</a>';

$pageButtons[] =' <button class="btn btn-sm btn-default" name="send_stav_order" type="submit">Odeslat email: ' . $form->doklad->nazev_stav. '</button>';
?>


<form method="post" class="">

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
	<?php print $form->Result();?>
	<?php print getResultMessage();?>
<?php
$GTabs = new ObjednavkaTabs($form);
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

	<form method="post" class="standard_form">
<?php print $form->getElement("generovat_fakturu")->render(); ?>
<?php print $form->getElement("id")->render(); ?>
</form>


<?php
include PATH_TEMP . "admin_body_footer.php";
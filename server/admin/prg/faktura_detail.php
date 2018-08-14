<?php

$fakturyController = new FakturyController();
$fakturyController->saveAction();

$url = $TreeMenu->getUserUrlQuery(URL_HOME . "eshop/faktury");
$nextPrevButton = $fakturyController->getNextPrevButton($_GET["id"], $url);

$form = new F_FakturaEdit();
$formRadek = new F_RadekFakturyEdit();

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
$pageButtons[] = '<a target="_blank" class="btn btn-sm btn-default" href="'.  URL_HOME . 'faktura_pdf.php?id=' .  $form->doklad->download_hash  . '">Stáhnout</a>';
$pageButtons[] = '<a href="#" data-postdata="modalFormPostdata" data-url="'.  URL_HOME . 'mailing?do=EmailCreate" class="btn btn-sm btn-info modal-form">Email </a>';
$pageButtons[] = '<a href="#" data-postdata="pohledavkyPostdata" data-url="'.  URL_HOME . 'mailing?do=EmailCreate" class="btn btn-sm btn-info modal-form">Pohledávky email</a>';

?>

<form method="post" class="">

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
			<input class="btn btn-sm" type="button" name="add" value="Přidej" onclick="createRadek('<?php print get_class($formRadek); ?>');">
		 	<input class="btn btn-sm" type="button" name="del" value="Zruš" onclick="deleteRadek();">
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
$cost_total = 0; 
     $res = '';
    for ($i=0;$i<count($GTabs->pohledavkyList);$i++)                                         
    {
      $cost_total += $GTabs->pohledavkyList[$i]->cost_total;
       $res .= '<p>VS <strong>' . $GTabs->pohledavkyList[$i]->code . '</strong>, k úhradě <strong>' . numberFormat($GTabs->pohledavkyList[$i]->cost_total) . '</strong>, ' . date("j.n.Y",strtotime($GTabs->pohledavkyList[$i]->maturity_date)) . ' <i>' . $GTabs->pohledavkyList[$i]->predmet . '</i><br /><a href="' . URL_HOME . 'faktura_pdf.php?id=' . $GTabs->pohledavkyList[$i]->download_hash . '">Stáhnout doklad</a>: <a href="' . URL_HOME . 'faktura_pdf.php?id=' . $GTabs->pohledavkyList[$i]->download_hash . '">' . URL_HOME . 'faktura_pdf.php?id=' . $GTabs->pohledavkyList[$i]->download_hash . '</a><br />-----------------------</p>';
    }
    
    $res .= '<p>Děkujeme za zájem o naše služby a tešíme se na dalši spolupráci.</p>';
?>

<script>


var pohledavkyPostdata  = function() {

  return {
     F_MailCreate_adresat_id : "<?php print $form->getElement("shipping_email")->getValue(); ?>" ,
     F_MailCreate_subject : "Přehled pohledávek" ,
     F_MailCreate_description : 'Vážený zákazníku,<br />zasíláme Vám přehled pohledávek, které evidujeme k <?php print date("j.n.Y"); ?> v celkové výši <strong><?php print numberFormat($cost_total); ?></strong>.<br />Prosíme o jejich úhradu.<br /><br /><?php print $res; ?>' 
  };
} 

var modalFormPostdata  = function() {

  return {
     F_MailCreate_adresat_id : "<?php print $form->getElement("shipping_email")->getValue(); ?>" ,
     F_MailCreate_subject : "faktura č.<?php print $form->getElement("code")->getValue(); ?>" ,
     F_MailCreate_description : 'Dobrý den,<br />zasíláme Vám fakturu č. <?php print $form->doklad->code; ?>, <?php print $form->doklad->description; ?><br /><a href="<?php print URL_HOME; ?>faktura_pdf.php?id=<?php print $form->doklad->download_hash; ?>">Stáhnout doklad</a> nebo odkaz: <a href="<?php print URL_HOME; ?>faktura_pdf.php?id=<?php print $form->doklad->download_hash; ?>"><?php print URL_HOME; ?>faktura_pdf.php?id=<?php print $form->doklad->download_hash; ?></a><br />-----------------------<p>Děkujeme za zájem o naše služby a tešíme se na dalši spolupráci.</p>' 
  };
} 
</script>
<?php
include PATH_TEMP . "admin_body_footer.php";

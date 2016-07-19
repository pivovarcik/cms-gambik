<?php
$pagetitle = "Přehled objednaného zboží";

define('AKT_PAGE',URL_HOME . 'objednavky_detailne');

$ordersController = new OrderController();
$ordersController->stornoAction();

$DataGridProvider = new DataGridProvider("RadekObjednavky");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>
<div class="buttons"><a href="<?php print URL_HOME . 'objednavky'; ?>">Zobrazit objednávky</a> <a href="/admin/objednavky_kalendar">Zobrazit kalendář</a> <a href="<?php print URL_HOME . 'objednavka_add'; ?>"><i class="fa fa-plus-square"></i> Nová objednávka</a></div>

<?php
print getResultMessage();
?>
</div>
<?php print $DataGridProvider->table();?>

</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
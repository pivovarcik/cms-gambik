<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',URL_HOME . 'kurzy');

$ciselnikController = new KurzController();
include PATH_TEMP . "ciselnik_subscriber.php";
//$ciselnikController->saveAction();
$ciselnikController->deleteAction();
$ciselnikController->kurzyImportAction();

$DataGridProvider = new DataGridProvider("Kurz");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<button name="import_kurzy" class="btn btn-sm btn-warning">Natáhnout kurzy</button>';
//$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_kurz">Nová</a>';

$pageButtons[] = $DataGridProvider->addButton("Nový","?do=Create");
?>

<form class="standard_form" method="post">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print getresultmessage();?>

<?php // print $DataGridProvider->table();?>
<?php print $DataGridProvider->ajaxTable();?>
</form>
<?php
include PATH_TEMP . "admin_body_footer.php";
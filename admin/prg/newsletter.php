<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;


$ciselnikController = new NewsletterController();
$ciselnikController->saveAction();
$ciselnikController->deleteAction();

define('AKT_PAGE',URL_HOME . 'newsletter');

$DataGridProvider = new DataGridProvider("Newsletter");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<button name="import_kurzy" class="btn btn-sm btn-warning">Natáhnout kurzy</button>';
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_newsletter">Nový</a>';
?>

<form class="standard_form" method="post">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print getresultmessage();?>

<?php print $DataGridProvider->ajaxtable();?>
</form>
<?php
include PATH_TEMP . "admin_body_footer.php";
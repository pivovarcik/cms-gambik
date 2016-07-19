<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;


define('AKT_PAGE',$cat->link);


$DataGridProvider = new DataGridProvider("Roles");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_role">Nová</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->ajaxtable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";


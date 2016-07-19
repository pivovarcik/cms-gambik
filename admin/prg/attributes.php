<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',URL_HOME . 'attributes');

$attrController = new AttributeController();

$attrController->deleteAction();

$DataGridProvider = new DataGridProvider("Attributes");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<a  class="btn btn-sm btn-info" href="/admin'.   $cat->link . '/add_attrib">Nový</a>';
?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->table();?>

<?php
include PATH_TEMP . "admin_body_footer.php";
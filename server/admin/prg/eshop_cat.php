<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',URL_HOME . 'eshop_cat');

$ciselnikController = new ProductCategoryController();
$ciselnikController->deleteAction();
include PATH_TEMP . "ciselnik_subscriber.php";
$DataGridProvider = new DataGridProvider("ProductCategory");


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();

$pageButtons[] = $DataGridProvider->addButton("Nová",AKT_PAGE . "?do=Create");
?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php print $DataGridProvider->ajaxTable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";

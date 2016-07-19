<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);


$productController = new ShopPlatbyController();
$productController->saveAction();
//$productController->copyAction();
$productController->deleteAction();


$DataGridProvider = new DataGridProvider("ShopPlatby");
//$DataGridProvider->actionRegister("copy","Kopírovat");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

include PATH_TEMP . "admin_body_header.php";

?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php
print getResultMessage();
print $DataGridProvider->Ajaxtable(); ?>

<?php
include PATH_TEMP . "admin_body_footer.php";
?>


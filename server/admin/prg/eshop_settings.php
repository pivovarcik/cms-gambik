<?php


$HeurekaControllerr = new HeurekaController();
$HeurekaControllerr->importDotaznikReportAction();
$HeurekaControllerr->feedGeneratorAction();

$PohodaExportController = new PohodaExportController();
$PohodaExportController->productListPohodaFeedGeneratorAction();
$PohodaExportController->objednavkyListPohodaFeedGeneratorAction();
$PohodaExportController->productImagesZipGeneratorAction();



$FaviController = new FaviController();
$FaviController->feedGeneratorAction();

$ZboziCzController = new ZboziCzController();
$ZboziCzController->feedGeneratorAction();

$eshop = new EshopController();
$eshop->saveAction();

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;




$form = new F_EshopSettings();

$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);


define('AKT_PAGE',URL_HOME . 'eshop');


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();

$pageButtons[] = $form->getElement("upd-setting-eshop")->render();
//$pageButtons[] = '<a class="btn btn-sm btn-warning" target="_blank" href="/export/zbozicz.php">Generovat Feed Zboží.cz</a>';
//$pageButtons[] = '<a class="btn btn-sm btn-warning" target="_blank" href="/export/order_email.php">Generovat emaily CSV z přijatých objednávek</a>';
//$pageButtons[] = '<a class="btn btn-sm btn-warning" target="_blank" href="/export/heurekacz.php">Natáhnout hodnocení z Heureka.cz</a>';
?>
<form class="" method="post">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php
print $form->Result();
?>

<?php
print getResultMessage();
?>

<?php
$GTabs = new EshopSetingsTabs($form);
?>

<?php
print $GTabs->makeTabs();
?>


	</form>

<?php
include PATH_TEMP . "admin_body_footer.php";
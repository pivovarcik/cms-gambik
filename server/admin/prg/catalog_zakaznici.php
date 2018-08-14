<?php

$pagetitle = "Katalog zákazníků";
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
define('AKT_PAGE',URL_HOME . 'admin/catalog_zakaznici');
$catalogController = new CatalogFiremController();
$catalogController->saveAction();
//$catalogController->copyAction();
$catalogController->deleteAction();
//$catalogController->recycleAction();

//print_r($_POST);

$args = new ListArgs();

if (isset($_GET["title"]) && !empty($_GET["title"])) {
	$args->title = trim($_GET["title"]);
}
if (isset($_GET["ico"]) && !empty($_GET["ico"])) {
	$args->ico = trim($_GET["ico"]);
}
if (isset($_GET["email"]) && !empty($_GET["email"])) {
	$args->email = trim($_GET["email"]);
}
if (isset($_GET["address2"]) && !empty($_GET["address2"])) {
	$args->address2 = trim($_GET["address2"]);
}
$DataGridProvider = new DataGridProvider("CatalogZakazniku",$args);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();
$pageButtons[] = '<a class="btn-add" href="'.  URL_HOME . 'add_zakaznik"><i class="fa fa-plus-square"></i> Nový</a>';

?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>



<?php print $DataGridProvider->ajaxtable(); ?>


<?php
include PATH_TEMP . "admin_body_footer.php";


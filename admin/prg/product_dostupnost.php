<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);
$pagetitle = "Číselník dostupností produktů";

//define('AKT_PAGE',URL_HOME . 'product_dostupnost');

$ciselnikController = new ProductDostupnostController();
include PATH_TEMP . "ciselnik_subscriber.php";
//$productCategoryController->saveAction();
//$productCategoryController->deleteAction();

$DataGridProvider = new DataGridProvider("ProductDostupnost");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a  class="btn btn-sm btn-info" href="'.   $cat->link . '/product_dostupnost_create">Nový</a>';

$pageButtons[] = $DataGridProvider->addButton("Nová","?do=Create");

?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>


<?php print $DataGridProvider->ajaxTable(); ?>

<?php
include PATH_TEMP . "admin_body_footer.php";
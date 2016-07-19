<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);

$productVyrobceController = new ProductCenaController();
$productVyrobceController->deleteAction();

$args = new ProductCenaListArgs();
$DataGridProvider = new DataGridProvider("ProductCena",$args);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a href="'.   $cat->link . '/add_product_cenik"><i class="fa fa-plus-square"></i> Nový</a>';

$pageButtons[] = '<a class="btn btn-sm btn-warning" href="/admin/eshop/product_ceniky/generator_cen">Generátor cen</a>';
?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->table();?>
<?php
include PATH_TEMP . "admin_body_footer.php";
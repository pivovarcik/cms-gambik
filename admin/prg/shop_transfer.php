<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);


$shopTransferController = new ShopTransferController();
$shopTransferController->deleteAction();


$args = new ListArgs();
$args->lang = LANG_TRANSLATOR;
$DataGridProvider = new DataGridProvider("Doprava",$args);


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="/admin'.   $cat->link . '/add_shop_transfer">Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $DataGridProvider->table();?>

<?php
include PATH_TEMP . "admin_body_footer.php";
<?php

$pagetitle = "Číselné řady";
define('AKT_PAGE',URL_HOME . 'nextid');
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);

$ciselnikController = new NextIdController();
$ciselnikController->deleteAction();


include PATH_TEMP . "ciselnik_subscriber.php";

$DataGridProvider = new DataGridProvider("NextId");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'nextid_add"> Nová</a>';
$pageButtons[] = '<a class="btn btn-sm btn-info modal-form" data-url="/admin/options/nextid?do=create" href="#">Nová</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php //print $DataGridProvider->table();?>

<?php print $DataGridProvider->ajaxTable();?>
<?php
include PATH_TEMP . "admin_body_footer.php";
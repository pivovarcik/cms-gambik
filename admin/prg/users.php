<?php
$userController->saveAction();
$userController->deleteAction();
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;
define('AKT_PAGE',$cat->link);



$args = new ListArgs();
$DataGridProvider = new DataGridProvider("Users",$args);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'user_add">Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php
print getResultMessage();
?>
<?php print $DataGridProvider->ajaxtable();?>
<?php
include PATH_TEMP . "admin_body_footer.php";
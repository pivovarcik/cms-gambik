<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);


$productController = new ProductStavyController();
$productController->zalozitStavyAction();
$productController->deleteAction();


$DataGridProvider = new DataGridProvider("ProductStavy");
//$DataGridProvider->actionRegister("copy","Kopírovat");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<button class="btn btn-sm btn-warning" type="submit" name="create_stavy">Vytvoř stavy</button>';
?>
<form method="post">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
</form>
<?php
print getResultMessage();
print $DataGridProvider->ajaxTable(); ?>

<?php
include PATH_TEMP . "admin_body_footer.php";
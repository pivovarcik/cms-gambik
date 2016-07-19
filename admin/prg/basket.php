<?php

$pagetitle = "Katalog";

$catalogController = new CatalogFiremController();
$catalogController->saveAction();
//$catalogController->copyAction();
$catalogController->deleteAction();
$catalogController->recycleAction();

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);
$args = new ListArgs();
$DataGridProvider = new DataGridProvider("Basket", $args);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>

<div class="buttons"></div>

</div>

<?php
print getResultMessage();
?>

<?php print $DataGridProvider->ajaxTable(); ?>

</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";


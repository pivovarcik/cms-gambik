<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = "Definice importů produktů";

define('AKT_PAGE',URL_HOME . 'import_product_settings');

$productCategoryController = new ImportProductController();
$productCategoryController->saveAction();
$productCategoryController->deleteAction();
$DataGridProvider = new DataGridProvider("ImportProductSetting");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";?>
<div class="wraper">
	<div class="page-header">
		<h1><?php echo $pagetitle; ?></h1>
		<div class="buttons"><a class="btn btn-sm btn-info" href="<?php print URL_HOME . 'import_product_setting_create'; ?>">Nový</a> </div>
	</div>

	<?php print $DataGridProvider->table(); ?>
</div>
<?php
include PATH_TEMP . "admin_body_footer.php";
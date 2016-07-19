<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = "Zdroje návštěvs";

define('AKT_PAGE',URL_HOME . 'zdroje');


//print_r($_GET);
$params = new UserActivityMonitorListArgs();
//$params->lang = LANG_TRANSLATOR;
//$params->all_public_date = true;
$DataGridProvider = new DataGridProvider("UserActivityMonitor",$params);




$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


<section>
<div class="wraper">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>
</div>

<?php
print getResultMessage();
?>

<?php print $DataGridProvider->ajaxtable(); ?>

</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
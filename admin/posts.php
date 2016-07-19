<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

//print_r($_GET);
define('AKT_PAGE',$cat->link);


$publishController = new PublishController();
$publishController->deleteAction();

$params = new ListArgs();
$params->lang = LANG_TRANSLATOR;
$params->all_public_date = true;
$DataGridProvider = new DataGridProvider("Publish",$params);


$GHtml->setPagetitle($cat->pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//  data-rel="do=PublishCreate"
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_post">Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php print $DataGridProvider->ajaxtable();?>


<?php
include PATH_TEMP . "admin_body_footer.php";
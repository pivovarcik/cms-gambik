<?php
$eshop = new SettingsController();
$eshop->saveAction();

$trans = new TranslatorController();

$trans->activeLanguageAction();
$trans->deactiveLanguageAction();
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;



$form = new Application_Form_AdminSettings();

define('AKT_PAGE',URL_HOME . 'options');


$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();

//$pageButtons[] = $form->getElement("upd-setting-eshop")->render();
$pageButtons[] = '<button class="btn btn-sm btn-success" type="submit" name="upd-nastaveni">Uložit</button>';
?>

<form class="" enctype="multipart/form-data" method="post">

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>



<?php
print getResultMessage();
?>


<?php

$GTabs = new SettingsTabs($form);

?>

<?php
print $GTabs->makeTabs();
?>

<div class="clearfix"> </div>
	</form>

<?php
include PATH_TEMP . "admin_body_footer.php";


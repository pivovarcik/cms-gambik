<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

$shopTransferController = new ShopPaymentController();
$shopTransferController->saveAction();

$form = new Application_Form_ShopPaymentEdit();

//$languageModel = new models_Language();
//$languageList = $languageModel->getActiveLanguage();


define('AKT_PAGE',URL_HOME . 'edit_shop_payment');

$pagetitle = "Typ platby";
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();


$title = 'Definice platby ';
// Verzování dle jazyků
if (count($languageList)>1){$first = true;
	foreach ($languageList as $key => $val){
		$selected = ' class="langLink"';
		if ($first) {$selected = ' class="lang_selected langLink"';}
		$title .= ' <a' . $selected. ' id="lnkLang' . strtoupper($val->code). '" href="javascript:show_lang(\'' . $val->code. '\');">' . strtoupper($val->code) . '</a>';$first = false;}
}

$cat->title = $title;

$pageButtons[] = $form->getElement("upd_payment")->render();
include PATH_TEMP . "admin_body_header.php"; ?>

	<form class="standard_form" method="post">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php print $form->Result(); ?>
<?php print getResultMessage();?>

			<?php $pageTabs = new ShopPaymentTabs($form);	print $pageTabs->makeTabs();?>

		</form>

<?php include PATH_TEMP . "admin_body_footer.php";

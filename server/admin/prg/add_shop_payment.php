<?php
$shopTransferController = new ShopPaymentController();
$shopTransferController->createAction();

$form = new F_ShopPaymentCreate();



define('AKT_PAGE',URL_HOME . 'admin/add_shop_Payment');

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();

$pageButtons = array();



$title = 'Nová definice platby ';
// Verzování dle jazyků
if (count($languageList)>1){$first = true;
	foreach ($languageList as $key => $val){
		$selected = ' class="langLink"';
		if ($first) {$selected = ' class="lang_selected langLink"';}
		$title .= ' <a' . $selected. ' id="lnkLang' . strtoupper($val->code). '" href="javascript:show_lang(\'' . $val->code. '\');">' . strtoupper($val->code) . '</a>';$first = false;}
}

$cat->title = $title;

$pageButtons[] = $form->getElement("ins_payment")->render();

include PATH_TEMP . "admin_body_header.php";?>
<form class="" method="post">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php print $form->Result(); ?>
<?php print getResultMessage();?>
<?php $pageTabs = new ShopPaymentTabs($form);	print $pageTabs->makeTabs();?>
</form>

<?php
include PATH_TEMP . "admin_body_footer.php";
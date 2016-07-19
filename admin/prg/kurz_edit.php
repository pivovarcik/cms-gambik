<?php
$productCategoryController = new KurzController();
$productCategoryController->saveAction();
$url = $TreeMenu->getUserUrlQuery(URL_HOME . "eshop/options/kurzy");
//$nextPrevButton = $productCategoryController->getNextPrevButton($_GET["id"], $url);
$form = new Application_Form_KurzEdit();



define('AKT_PAGE',URL_HOME . 'kurz_edit');


$pagetitle = "Editace kurovního lístku";


$GHtml->setPagetitle($pagetitle);
//$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


<div class="wraper">
<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
	<div class="page-header">
		<h1><?php echo $pagetitle; ?></h1>
		<div class="buttons">
			<?php //print $nextPrevButton;?>
			<?php print $form->getElement("upd_cat")->render();?>
			<?php print $form->getElement("id")->render();?>
			<a href="/admin/add_kurz">Nový</a>
		</div>
	</div>
	<?php print $form->Result(); ?>
<?php
$CiselnikTabs = new KurzTabs($form);
print $CiselnikTabs->makeTabs();
?>


</form>
</div>
<?php
include PATH_TEMP . "admin_body_footer.php";
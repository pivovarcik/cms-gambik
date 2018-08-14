<?php
$productCategoryController = new ProductCenikController();
$productCategoryController->saveAction();

$form = new F_ProductCenikEdit();


$cat = new stdClass();
$cat->title = "Ceník - Editace";
$cat->serial_cat_url = "";
$cat->serial_cat_title = "";
define('AKT_PAGE',URL_HOME . 'product_cenik_edit');

$cokoliv = '<script type="text/javascript">
$(document).ready(function() {
	$("#treecat").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black"
	});

	loadCiselnikTree("ProductCenik");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);
$GHtml->setServerJs("/js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs("/js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss("/js/jquery.treeview/jquery.treeview.css");


$pagetitle = "Editace slev";


$GHtml->setPagetitle($pagetitle);
//$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<form class="" enctype="application/x-www-form-urlencoded" method="POST">
<?php
$pageButtons = array();
$pageButtons[] = $form->getElement("upd_cat")->render();
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php
$CiselnikTabs = new ProductCenikTabs($form);

$tabs = $CiselnikTabs->makeTabs();?>
<?php

if ($CiselnikTabs->produkty_count  + $CiselnikTabs->skupiny_produktu_count  == 0) {
	 print AlertHelper::alert("Tato sleva není zatím nikde použita!","warning");
}
?>
	<?php print $form->Result(); ?>
<?php
print $tabs;
?>

	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="#"><img src="/js/jquery.treeview/images/minus.gif" /> Sbalit vše</a>
		<a title="Expand the entire tree below" href="#"><img src="/js/jquery.treeview/images/plus.gif" /> Rozbalit vše</a>
	</div>
	<div id="treedata" class="treeview2"></div>
</form>

<?php
include PATH_TEMP . "admin_body_footer.php";
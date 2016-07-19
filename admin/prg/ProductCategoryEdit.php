<?php


$productCategoryController = new ProductCategoryController();
$productCategoryController->saveAction();

$form = new Application_Form_ProductCategoryEdit();

define('AKT_PAGE',URL_HOME . 'admin/edit_product_cat');

$pagetitle = "Editace kategorie produktů";
$GHtml->setServerJs("/js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs("/js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss("/js/jquery.treeview/jquery.treeview.css");

$cokoliv = '<script type="text/javascript">
$(document).ready(function() {
	$("#treecat").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black"
	});

	loadCiselnikTree("ProductCategory");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<?php
print $form->Result();
?>
<h1><?php echo $pagetitle; ?></h1>
<div class="buttons"><a href="<?php print URL_HOME . 'admin/add_product_cat.php'; ?>">+ Přidat novou skupinu</a> </div>
<p>Editace kategorie</p>
<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">

<?php print $form->getElement("upd_cat")->render();?>

<?php
$CiselnikTabs = new ProductCategoryTabs($form);
print $CiselnikTabs->makeTabs();
?>

	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="#"><img src="/js/jquery.treeview/images/minus.gif" /> Sbalit vše</a>
		<a title="Expand the entire tree below" href="#"><img src="/js/jquery.treeview/images/plus.gif" /> Rozbalit vše</a>
	</div>
	<div id="treedata" class="treeview2"></div>
</form>
</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
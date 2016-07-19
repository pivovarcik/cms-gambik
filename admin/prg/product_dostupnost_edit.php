<?php
$productCategoryController = new ProductDostupnostController();
$productCategoryController->saveAction();

$form = new Application_Form_ProductDostupnostEdit();


$cat = new stdClass();
$cat->title = "Dostupnost - Editace";
$cat->serial_cat_url = "";
$cat->serial_cat_title = "";
define('AKT_PAGE',URL_HOME . 'product_dostupnost_edit');

$cokoliv = '<script type="text/javascript">
$(document).ready(function() {
	$("#treecat").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black"
	});

	loadCiselnikTree("ProductDostupnost");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);
$GHtml->setServerJs("/js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs("/js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss("/js/jquery.treeview/jquery.treeview.css");


$pagetitle = "Editace dostupnosti";


$GHtml->setPagetitle($pagetitle);
//$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
<?php
$pageButtons = array();
$pageButtons[] = $form->getElement("upd_cat")->render();
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>


	<?php print $form->Result(); ?>
<?php
$CiselnikTabs = new ProductDostupnostTabs($form);
print $CiselnikTabs->makeTabs();
?>

	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="#"><img src="/js/jquery.treeview/images/minus.gif" /> Sbalit vše</a>
		<a title="Expand the entire tree below" href="#"><img src="/js/jquery.treeview/images/plus.gif" /> Rozbalit vše</a>
	</div>
	<div id="treedata" class="treeview2"></div>
</form>

<?php
include PATH_TEMP . "admin_body_footer.php";
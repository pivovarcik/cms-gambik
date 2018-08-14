<?php



$productVyrobceController = new ProductCenikController();
$productVyrobceController->createAction();

$form = new F_ProductCenikCreate();



define('AKT_PAGE',URL_HOME . 'admin/add_product_cenik');

$pagetitle = "Nový výrobce produktů";


$limit = 100;

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

	loadCiselnikTree("ProductCenik");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<?php
$pageButtons = array();
$pageButtons[] = $form->getElement("ins_product_cenik")->render();
?>
<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php
//print $print_result;
print $form->Result();
?>


	<?php
$CiselnikTabs = new ProductCenikTabs($form);
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
?>
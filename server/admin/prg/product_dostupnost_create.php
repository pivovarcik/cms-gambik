<?php
$productCategoryController = new ProductDostupnostController();
$productCategoryController->createAction();

$form = new F_ProductDostupnostCreate();



define('AKT_PAGE',URL_HOME . 'product_dostupnost_create');

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


$pagetitle = "Nová lokace";


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


<div class="wraper">
<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
	<div class="page-header">
		<h1><?php echo $pagetitle; ?></h1>
		<div class="buttons"><?php print $form->getElement("ins_cat")->render();?></div>
	</div>
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
</div>
<?php
include PATH_TEMP . "admin_body_footer.php";
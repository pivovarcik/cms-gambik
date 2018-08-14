<?php
$productCategoryController = new MjController();
$productCategoryController->saveAction();
$url = $TreeMenu->getUserUrlQuery(URL_HOME . "eshop/options/mj");
//$nextPrevButton = $productCategoryController->getNextPrevButton($_GET["id"], $url);
$form = new F_MjEdit();



define('AKT_PAGE',URL_HOME . 'add_mj');

$cokoliv = '<script type="text/javascript">
$(document).ready(function() {
	$("#treecat").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black"
	});

	loadCiselnikTree("Mj");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);
$GHtml->setServerJs("/js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs("/js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss("/js/jquery.treeview/jquery.treeview.css");


$pagetitle = "Editace měrné jednotky";


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
			<a href="/admin/add_mj">Nový</a>
		</div>
	</div>
	<?php print $form->Result(); ?>
<?php
$CiselnikTabs = new MjTabs($form);
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
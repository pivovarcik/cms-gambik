<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',URL_HOME . 'category');

$cokoliv = '<script type="text/javascript">$(document).ready(function() {
	loadTree("SysCategory");
});</script>';
$GHtml->setCokolivToHeader($cokoliv);

$GHtml->setServerJs("/js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs("/js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss("/js/jquery.treeview/jquery.treeview.css");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'syscategory/add_syscat">Nová</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>


		<div id="treecontrol">
			<a title="Collapse the entire tree below" href="#"><img src="/js/jquery.treeview/images/minus.gif" /> Sbalit vše</a>
			<a title="Expand the entire tree below" href="#"><img src="/js/jquery.treeview/images/plus.gif" /> Rozbalit vše</a>
		</div>
	<div id="treedata" class="treeview"></div>

	<div class="clearfix"></div>

<?php
include PATH_TEMP . "admin_body_footer.php";

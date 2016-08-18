<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

$form = new Application_Form_CategoryEdit();

define('AKT_PAGE',URL_HOME . 'category');

$cokoliv = '<script type="text/javascript">$(document).ready(function() {
	loadTree();
});</script>';
$GHtml->setCokolivToHeader($cokoliv);

$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss(URL_HOME_SITE . "js/jquery.treeview/jquery.treeview.css");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'category/add_cat">Nová</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php print $form->Result();?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Struktura rubrik</div>
			<div class="panel-body">
				<div id="treecontrol">
				 	<a title="Collapse the entire tree below" href="#"><img src="<?php print URL_HOME_SITE; ?>js/jquery.treeview/images/minus.gif" /> Sbalit vše</a>
					<a title="Expand the entire tree below" href="#"><img src="<?php print URL_HOME_SITE; ?>js/jquery.treeview/images/plus.gif" /> Rozbalit vše</a>
				</div>
				<div id="treedata" class="treeview"></div>

				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>



<?php
include PATH_TEMP . "admin_body_footer.php";

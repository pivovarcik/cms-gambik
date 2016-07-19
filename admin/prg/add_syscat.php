<?php

$pagetitle = "Editace rubriky";

define('AKT_PAGE',URL_HOME . 'admin/add_syscat');

$CategoryController = new SysCategoryController();
$CategoryController->createAction();

$form = new Application_Form_CategoryCreate();




$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();

$title = "title_".$languageList[0]->code;
$pagetitle = "Edit - " . $form->getElement($title)->getValue();

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);

$cokoliv = '<script type="text/javascript">$(document).ready(function() {
	loadTree("syscategory");
	loadCategoryPicker("syscategory");
});</script>';
$GHtml->setCokolivToHeader($cokoliv);

$params = array(
'buttons1'=>$settings->get("TINY_BUTTONS1"),
'buttons2'=>$settings->get("TINY_BUTTONS2"),
'buttons3'=>$settings->get("TINY_BUTTONS3"),
'valid'=>$settings->get("TINY_VALID"),
'width'=>$settings->get("TINY_WIDTH"),
'height'=>$settings->get("TINY_HEIGHT"),
'plugins'=>$settings->get("TINY_PLUGINS"),
);
$script = tinyMceInit($params);
$GHtml->setCokolivToHeader($script);
/*
$GHtml->setServerJs('/js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs('/js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs('/js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs('/js/SWFUpload/js/handlers.js');
*/

$GHtml->setServerJs("/js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs("/js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss("/js/jquery.treeview/jquery.treeview.css");

$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
	<form class="standard_form" method="post">
<div class="page-header">

	<h1>
	 <?php
	if (count($languageList)>1)
	{
		 // Verzování dle jazyků
		 $first = true;
		 foreach ($languageList as $key => $val)
		 {
		 	$selected = ' class="langLink"';
		 	if ($first) { $selected = ' class="lang_selected langLink"'; }?>

		 <a<?php print $selected;?> id="lnkLang<?php print strtoupper($val->code);?>" href="javascript:show_lang('<?php print $val->code;?>');"><?php print strtoupper($val->code);?></a>
		   <?php $first = false;
		}
	}?>
	</h1>
	<div class="buttons">
		<?php print $form->getElement("ins_cat")->render();?>
	</div>
<?php print $form->Result();?>
</div>

<?php
$pageTabs = new SysCategoryTabs($form);
print $pageTabs->makeTabs();
?>

	<div class="treeBox">
		<div id="treecontrol">
			<a title="Collapse the entire tree below" href="#"><img src="/js/jquery.treeview/images/minus.gif" /> Sbalit vše</a>
			<a title="Expand the entire tree below" href="#"><img src="/js/jquery.treeview/images/plus.gif" /> Rozbalit vše</a>
		</div>
		<div id="treedata" class="treeview2"></div>
	</div>
	<div id="productfotoMain"></div>
</form>

</div>
</section>
<?php include PATH_TEMP . "admin_body_footer.php";
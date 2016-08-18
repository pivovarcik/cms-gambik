<?php
define('AKT_PAGE',URL_HOME . 'admin/category/cat');

$CategoryController = new CategoryController();
$CategoryController->saveAction();
$CategoryController->deleteAction();
$form = new Application_Form_CategoryEdit();

	$EshopController = new EshopController();
	$EshopController->setEshopCategoryAction();
$pageTabs = new PageTabs($form);
$tabs = array();
$eshopSettings = G_EshopSetting::instance();

$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();

$title = "title_".$languageList[0]->code;
$pagetitle = "Edit - " . $form->getElement($title)->getValue();

$GHtml->setPagetitle($pagetitle);
//$GHtml->setPagedescription($cat->pagedescription);


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

$GHtml->setServerJs(URL_HOME_SITE .  "js/SWFUpload/swfupload/swfupload.js");
$GHtml->setServerJs(URL_HOME_SITE . "/js/SWFUpload/js/swfupload.queue.js");
$GHtml->setServerJs(URL_HOME_SITE . "/js/SWFUpload/js/fileprogress.js");
$GHtml->setServerJs(URL_HOME_SITE . "/js/SWFUpload/js/handlers.js");


$cokoliv = '<script type="text/javascript">
$(document).ready(function() {
	loadTree();
	getMainFoto(' . $form->page->foto_id . ');
	loadCategoryPicker();
	});
</script>';
$GHtml->setCokolivToHeader($cokoliv);

$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.treeview/lib/jquery.cookie.js");
$GHtml->setServerJs(URL_HOME_SITE . "js/jquery.treeview/jquery.treeview.js");
$GHtml->setServerCss(URL_HOME_SITE . "js/jquery.treeview/jquery.treeview.css");

$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

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
		<?php print $form->getElement("upd_cat")->render();?>
		<?php print $form->getElement("del_cat")->render();?>
		<?php

		if ("1" == $settings->get("MODUL_ESHOP"))
		{
			print $form->getElement("set_cat_shop")->render();

		}


?>




		<a class="btn btn-sm btn-info" href="<?php print URL_HOME . 'add_cat'; ?>">Nová</a>
	</div>
	<div class="clearfix"> </div>
<?php print $form->Result();?>
</div>





<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">



	<div id="tabs-nested-left2">
<?php
$pageTabs = new CategoryTabs($form);	print $pageTabs->makeTabs();
?>
</div>
		</div>

		<div class="col-lg-4">
			<div id="productfotoMain"></div>

				<div class="treeBox">
		<div id="treecontrol">
			<a title="Collapse the entire tree below" href="#"><img src="<?php print URL_HOME_SITE; ?>js/jquery.treeview/images/minus.gif" /> Sbalit vše</a>
			<a title="Expand the entire tree below" href="#"><img src="<?php print URL_HOME_SITE; ?>js/jquery.treeview/images/plus.gif" /> Rozbalit vše</a>
		</div>
		<div id="treedata" class="treeview2"></div>
	</div>
		</div>
	</div>
</div>




</form>
<?php include PATH_TEMP . "admin_body_footer.php";
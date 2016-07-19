<?php

$url = $TreeMenu->getUserUrlQuery(URL_HOME . "posts");


$publishController = new PublishController();
$publishController->saveAction();
$publishController->sendNewsletterAction();
$publishController->sendNewsletterTestAction();
$form = new Application_Form_PublishPostEdit();

$nextPrevButton = $publishController->getNextPrevButton($_GET["id"], $url);



$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();

$pagetitle = "Editace článku";

if (empty($_GET["id"])){ return FALSE; } else { $id = $_GET["id"];}

define('AKT_PAGE',URL_HOME . 'admin/post_edit.php?id=' . $id);


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



$cokoliv = '<script type="text/javascript">
$(document).ready(function(){
	getMainFoto(' . $form->page->foto_id . ');
	loadCategoryPicker();
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);



$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


	<form class="standard_form" method="post">
	<div class="page-header">

	<h1><?php echo $pagetitle; ?>
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
		<?php print $nextPrevButton;?>
		<?php print $form->getElement("upd_post")->render();?>
		<a class="btn btn-sm btn-info" href="<?php print URL_HOME . 'add_post'; ?>">Nový</a>
	</div>
	<?php print $form->Result();?>
</div>





<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">


					<?php
					$pageTabs = new PublishTabs($form);
					print $pageTabs->makeTabs($tabs);
					?>


		</div>

		<div class="col-lg-4">
			<div id="productfotoMain"></div>
		</div>
	</div>
</div>



    </form>
<?php
include PATH_TEMP . "admin_body_footer.php";
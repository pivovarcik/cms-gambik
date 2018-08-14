<?php

$publishController = new PublishController();
$publishController->createAction();
$form = new F_PublishPostCreate();
//print_r($form);
$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();

//				$language = array("1" => "cs", "2" => "en","3" => "is");
define('AKT_PAGE',URL_HOME . 'admin/add_post');


$params = array(
'buttons1'=>$settings->get("TINY_BUTTONS1"),
'buttons2'=>$settings->get("TINY_BUTTONS2"),
'buttons3'=>$settings->get("TINY_BUTTONS3"),
'valid'=>$settings->get("TINY_VALID"),
'width'=>$settings->get("TINY_WIDTH"),
'height'=>$settings->get("TINY_HEIGHT"),
'plugins'=>$settings->get("TINY_PLUGINS"),
'menubar'=>"edit tools table format view insert",
);
$script = tinyMceInit($params);
$GHtml->setCokolivToHeader($script);


$cokoliv = '<script type="text/javascript">
$(document).ready(function(){
loadCategoryPicker("Category");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);


$script = '
<script type="text/javascript">
	$(function() {
		$( "#date_public2" ).datepicker();
	});
</script>
';
$GHtml->setCokolivToHeader($script);

$pagetitle = "Nový článek";


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<form class="" method="post">

<div class="page-header">
<h1><?php echo $pagetitle; ?>
<?php
// Verzování dle jazyků

if (count($languageList)>1)
{

	// Verzování dle jazyků
	$first = true;
	foreach ($languageList as $key => $val)
	{
		$selected = ' class="langLink"';
		if ($first) {
			$selected = ' class="lang_selected langLink"';
		}
		?>

	 <a<?php print $selected;?> id="lnkLang<?php print strtoupper($val->code);?>" href="javascript:show_lang('<?php print $val->code;?>');"><?php print strtoupper($val->code);?></a>
	   <?php
		$first = false;
	}
}?>
</h1>
	<div class="buttons">
	<?php print $form->getElement("ins_post")->render();?>
	</div>
	<?php
print $form->Result();
?>

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
    </form>

<?php
include PATH_TEMP . "admin_body_footer.php";
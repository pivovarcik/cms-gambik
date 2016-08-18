<?php




$productController = new ProductController();
$productController->saveAction();
$productController->copyAction();

//$productController->setAttributeProduct($_GET["id"]);

$url = $TreeMenu->getUserUrlQuery(URL_HOME . "eshop/sortiment");
$nextPrevButton = $productController->getNextPrevButton($_GET["id"], $url);



$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();


$form = new Application_Form_ProductEdit();

define('AKT_PAGE',URL_HOME . 'sortiment/edit_product?id=' . $_GET["id"]);

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

$script = '<script>$(document).ready(function(){var formName = "ProductVariantyForm";registerEventRadekForm(formName);});</script>';
$GHtml->setCokolivToHeader($script);

$GHtml->setServerJs('/js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs('/js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs('/js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs('/js/SWFUpload/js/handlers.js');
//$GHtml->setServerJs("http://code.jquery.com/ui/1.10.3/jquery-ui.js");
/*
$script = swfUploadInit($_GET["id"],T_SHOP_PRODUCT);
$GHtml->setCokolivToHeader($script);
*/
$cokoliv = '<script type="text/javascript">
$(document).ready(function(){
	/*loadPhotoGallery(' . $_GET["id"] . ', \'' . T_SHOP_PRODUCT . '\');*/
	getMainFoto(' . $form->page->foto_id . ');
	loadCategoryPicker();
	});
</script>';
$GHtml->setCokolivToHeader($cokoliv);

$script = '
<script type="text/javascript">
function show_element($id) {
	if( $("#" + $id).is(":visible") ) {
		$("#" + $id).hide();
	} else {
		$("#" + $id).show();
	}
}
</script>';
$GHtml->setCokolivToHeader($script);

$title = "title_" . $languageList[0]->code;
$pagetitle = $form->getValue("cislo") . " " . $form->getValue($title) . " (edit)";
$pagedescription = "";
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


<form class="" enctype="application/x-www-form-urlencoded" method="POST">

<div class="page-header">
<h1>
Editace produktu
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
	   <?php $first = false;}
}?>
	<?php print GoBackLink(); ?></h1>

	<div class="breadcrumb"><?php print $Breadcrumb; ?>
	<div class="page-help"><a href="#"><i class="fa fa-question-circle"></i></a></div>
</div>

	<div class="buttons">
	<?php print $nextPrevButton;?>
		<?php print $form->getElement("upd_product")->render();?>
		<a class="btn btn-sm btn-default modal-form" data-callback="reloadPage()" data-url="/admin/eshop/sortiment?do&id=<?php print $_GET["id"]?>" href="#">Nastavit parametry</a>
		<?php print $form->getElement("copy_product")->render();?>
		<a class="btn btn-sm btn-info " href="/admin/eshop/add_product">Nový</a>
	</div>
</div>
<?php print $form->Result();?>


<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">



	<div id="tabs-nested-left2">


<?php $pageTabs = new ProductTabs($form);	print $pageTabs->makeTabs();?>
</div>
		</div>

		<div class="col-lg-4">
			<div id="productfotoMain"></div>
		</div>
	</div>
</div>

</form>
<?php
include PATH_TEMP . "admin_body_footer.php";

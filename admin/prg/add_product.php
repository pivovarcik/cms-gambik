<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

//print_r($cat);
$productController = new ProductController();
$productController->createAction();

$form = new Application_Form_ProductCreate();

$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);


$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();

define('AKT_PAGE',URL_HOME . 'add_product');


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


$pagetitle = "Nový produkt";


$cokoliv = '<script type="text/javascript">
$(document).ready(function(){
	loadCategoryPicker();
	});
</script>';
$GHtml->setCokolivToHeader($cokoliv);


$limit = 100;

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<section>
<div class="wraper">
	<form class="standard_form" id="requiredfield" method="post">

<?php print $form->Result();?>
<div class="page-header">
<h1>
<?php print $pagetitle;?>
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
	</h1>
	<div class="buttons">
<?php print $form->getElement("ins_product")->render();?>
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">

<?php $pageTabs = new ProductTabs($form);	print $pageTabs->makeTabs();?>


		</div>

		<div class="col-lg-4">
			<div id="productfotoMain"></div>
		</div>
	</div>
</div>

</form>
<div class="clearfix"> </div>
</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
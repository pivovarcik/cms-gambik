<?php

$url = $TreeMenu->getUserUrlQuery("/admin/catalog");
//PRINT $url;
$catalogController = new CatalogFiremController();
$catalogController->saveAction();

$GHtml->setServerJs("/admin/js/town-complete.js");
$GHtml->setServerJs("/admin/js/init-autocompletes.js");

//$GHtml->setServerCss("/admin/style/ui.css");

$form = new F_CatalogFiremEdit();

define('AKT_PAGE',URL_HOME . 'edit_catalog?id='.$_GET["id"]);


$pagetitle = $form->page->title . " - Editace";


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


$GHtml->setServerJs('/js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs('/js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs('/js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs('/js/SWFUpload/js/handlers.js');

$script = swfUploadInit($_GET["id"],T_CATALOG_FIREM);
$GHtml->setCokolivToHeader($script);


$script = '
<script type="text/javascript">
	$(function() {
		loadCategoryPicker();
	//	loadPhotoGallery(' . $_GET["id"] . ', \'mm_catalog_firem\');
	//	getMainFoto(' . $form->page->foto_id . ');
//		$( "#date_registrace" ).datepicker();
	//	$( "#date_expirace" ).datepicker();
	});
</script>
';
$GHtml->setCokolivToHeader($script);


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">

<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
<?php print $form->getElement("id")->render(); ?>

<div class="page-header">
	<h1><?php echo $pagetitle; ?></h1>



		<div class="breadcrumb"><?php print $Breadcrumb; ?>
			<div class="page-help"><a href="#"><i class="fa fa-question-circle"></i></a></div>
		</div>

	<div class="buttons">
	<?php print $nextPrevButton;?>
		<?php print $form->getElement("upd_catalog")->render();?>
		<a class="btn btn-sm btn-info" href="/admin/add_catalog">Nový</a>
	</div>

</div>
<?php print $form->Result();?>


<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">

			<?php
			$pageTabs = new CatalogFiremTabs($form);
			print $pageTabs->makeTabs();
			?>
			<div class="clearfix"> </div>

		</div>

		<div class="col-lg-4">
			<div id="productfotoMain"></div>
			<div id="logo"></div>
		</div>
	</div>
</div>









</form>



</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
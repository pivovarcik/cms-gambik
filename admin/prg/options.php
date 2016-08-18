<?php
$eshop = new SettingsController();
$eshop->saveAction();

$trans = new TranslatorController();

$trans->activeLanguageAction();
$trans->deactiveLanguageAction();
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;



$form = new Application_Form_AdminSettings();

define('AKT_PAGE',URL_HOME . 'options');


$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();

//$pageButtons[] = $form->getElement("upd-setting-eshop")->render();
$pageButtons[] = '<button class="btn btn-sm btn-success" type="submit" name="upd-nastaveni">Uložit</button>';
?>

<form class="ajax-form" enctype="multipart/form-data" method="post">

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>



<?php
print getResultMessage();
?>
<div class="ajax-response"></div>

<?php

$GTabs = new SettingsTabs($form);

?>

<?php
print $GTabs->makeTabs();
?>

<div class="clearfix"> </div>
	</form>
<script>

 $(".ajax-form").submit(function(e) {

 	e.preventDefault();

 	var that = this;
 	//	console.log($("#contact-form").serialize());
 	var data = $(that).serialize();
 //	console.log(data);
	var responseMessage = $(that).find('.ajax-response');
 	$.ajax({
 		type: "POST",
 		url: "/admin/ajax/form.php?action=AdminSettings",
 		dataType: 'json',
 		data : data,
 		beforeSend: function(result) {
 			$(that).find('button').empty();
 			$(that).find('button').append('<i class="fa fa-cog fa-spin"></i> Wait...');
 		},
 		success: function(result) {
 			if(result.status == "success") {
 				$(that).find('.ajax-hidden').fadeOut(500);
 				responseMessage.html(result.message).fadeIn(500);
 			} else {
 				$(that).find('button').empty();
 				$(that).find('button').append('<i class="fa fa-retweet"></i> Try again.');
 				responseMessage.html(result.message).fadeIn(1000);
 			}
 		}
 	});

 	return false;

 });
</script>
<?php
include PATH_TEMP . "admin_body_footer.php";


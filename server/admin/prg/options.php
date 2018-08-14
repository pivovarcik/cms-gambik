<?php
$eshop = new SettingsController();
$eshop->saveAction();

$trans = new TranslatorController();

$trans->activeLanguageAction();
$trans->deactiveLanguageAction();
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;



$form = new F_AdminSettings();

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
$pageButtons[] = '<button class="btn btn-sm btn-primary" type="submit" name="upd-nastaveni">Uložit</button>';
?>

<form class="ajax-form" enctype="multipart/form-data" method="post">

	<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>


	<div class="ajax-response">
	<?php
	$GTabs = new SettingsTabs($form);
	print $GTabs->makeTabs();
	?>
	</div>

</form>
<script>
var formSerializeButton = "";
 $(".ajax-form").submit(function(e) {

 	e.preventDefault();

 	var that = this;
 	//	console.log($("#contact-form").serialize());
 	var data = $(that).serialize()+formSerializeButton;
 //	console.log(data);
	var responseMessage = $(that).find('.ajax-response');
 	$.ajax({
 		type: "POST",
 		url: urlBase + "ajax/form.php?action=AdminSettings",
 		dataType: 'json',
 		data : data,
 		beforeSend: function(result) {
 			$(that).find('.btn-primary').empty();
 			$(that).find('.btn-primary').append('<i class="fa fa-cog fa-spin"></i> Čekejte...');
 		},
 		success: function(result) {
 			if(result.status == "success") {
 				$(that).find('.ajax-hidden').fadeOut(500);
 				responseMessage.html(result.message).fadeIn(500);

 				$(that).find('.btn-primary').text("Uložit");
 			} else {
 				$(that).find('.btn-primary').empty();
 				$(that).find('.btn-primary').append('<i class="fa fa-retweet"></i> Opakovat');
 				responseMessage.html(result.message).fadeIn(1000);
 			}
 		}
 	});

 	return false;

 });

$("button[type=submit]").click(function (evt) {
	//evt.preventDefault();

	var button = $(evt.target);
	formSerializeButton = '&'
	+ encodeURI(button.attr('name'))
	+ '='
	+ encodeURI(button.attr('value'))
	;

	//console.log(formSerializeButton);
});

</script>
<?php
include PATH_TEMP . "admin_body_footer.php";


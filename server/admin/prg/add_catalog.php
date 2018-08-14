<?php

$catalogController = new CatalogFiremController();
$catalogController->createAction();

$form = new F_CatalogFiremCreate();
//exit;



$today = date("j.m.Y H:i");

define('AKT_PAGE',URL_HOME . 'admin/add_catalog');


$pagetitle = "Nový záznam";




$params = array(
'buttons1'=>$g->setting["TINY_BUTTONS1"],
'buttons2'=>$g->setting["TINY_BUTTONS2"],
'buttons3'=>$g->setting["TINY_BUTTONS3"],
'valid'=>$g->setting["TINY_VALID"],
'width'=>$g->setting["TINY_WIDTH"],
'height'=>'100',
'plugins'=>$g->setting["TINY_PLUGINS"],
);
$script = $g->tinyMceInit($params);
$GHtml->setCokolivToHeader($script);
$script = '
<script type="text/javascript">
	$(function() {
		loadCategoryPicker();
		$( "#date_registrace" ).datepicker();
		$( "#date_expirace" ).datepicker();
	});

</script>
';
$GHtml->setCokolivToHeader($script);


//print_r($_POST);
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>

<div class="wraper">
<?php
//print $print_result;
print $g->get_result_message2();
?>
<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
<div class="page-header">
	<h1><?php echo $pagetitle; ?></h1>
	<div class="buttons">
		<?php print $form->getElement("ins_catalog")->render();?>
	</div>
</div>
<?php
$pageTabs = new CatalogFiremTabs($form);
print $pageTabs->makeTabs();
?>

</form>
</div>


</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
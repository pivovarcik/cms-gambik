<?php
$productCategoryController = new NewsletterController();
$productCategoryController->sendNewsletterTestAction();
$productCategoryController->sendNewsletterAction();
$productCategoryController->saveAction();


$form = new F_NewsletterEdit();



define('AKT_PAGE',URL_HOME . 'edit_newsletter');

$pagetitle = "Detail newsletteru";


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


<div class="wraper">
<form class="standard_form2" enctype="application/x-www-form-urlencoded" method="POST">
	<div class="page-header">
		<h1><?php echo $pagetitle; ?></h1>
		<div class="buttons"><?php print $form->getElement("upd_cat")->render();?>
 <?php print $form->getElement("send_newsletter")->render();?></div>
	</div>
	<?php print $form->Result(); ?>
<?php
$CiselnikTabs = new NewsletterTabs($form);
print $CiselnikTabs->makeTabs();
?>
</form>
</div>
<?php
include PATH_TEMP . "admin_body_footer.php";
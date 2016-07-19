<?php
$productCategoryController = new NewsletterController();
$productCategoryController->createAction();

$form = new Application_Form_NewsletterCreate();



define('AKT_PAGE',URL_HOME . 'add_newsletter');

$pagetitle = "Nový newsletter";


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


<div class="wraper">
<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
	<div class="page-header">
		<h1><?php echo $pagetitle; ?></h1>
		<div class="buttons"><?php print $form->getElement("ins_cat")->render();?></div>
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
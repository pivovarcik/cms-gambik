<?php
$attrController = new AttributeController();
$attrController->createAction();

$form = new Application_Form_AttribCreate();

$pagetitle = "Nový parametr";

$cat->title = $pagetitle;
$pageButtons = array();
$pageButtons[] = $form->getElement("ins_attr")->render();
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";?>

<form class="standard_form" enctype="application/x-www-form-urlencoded" method="POST">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
	<?php print $form->Result();?>


	<?php $pageTabs = new AttributeTabs($form);	print $pageTabs->makeTabs();?>
</form>

<?php include PATH_TEMP . "admin_body_footer.php";
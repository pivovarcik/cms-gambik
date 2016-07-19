<?php


$nextIdController = new NextIdController();
$nextIdController->createAction();

$form = new Application_Form_NextIdCreate();

$pagetitle = "Založení řady";

define('AKT_PAGE',URL_HOME . 'nextid_add');

$GHtml->setPagetitle($pagetitle);
//$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<h1><?php echo $pagetitle; ?></h1>
<?php
print $form->Result();
?>
	<form class="standard_form"  method="post">

				<?php
$GTabs = new NextIdTabs($form);
print $GTabs->makeTabs();
?>
		<?php print $form->getElement("ins_nextid")->render(); ?>

	</form>


<?php
include PATH_TEMP . "admin_body_footer.php";
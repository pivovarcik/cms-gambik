<?php


$nextIdController = new NextIdController();
$nextIdController->saveAction();

$form = new F_NextIdEdit();

$pagetitle = "Editace řady";

define('AKT_PAGE',URL_HOME . 'nextid_detail');

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


		<?php print $form->getElement("upd_nextid")->render(); ?>

	</form>


<?php
include PATH_TEMP . "admin_body_footer.php";
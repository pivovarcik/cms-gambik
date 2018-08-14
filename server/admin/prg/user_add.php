<?php
$cat = new PageComposite();
$pagetitle = $cat->title;

define('AKT_PAGE',URL_HOME . 'user_add');

$userController->createAction();

$form = new F_AdminUserCreate();

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
	<form class="" method="post">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>
<?php
print $form->Result();
?>
	<div class="buttons">
	<?php print $form->getElement("add_user")->render();?>
	</div>
	</div>






<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">
<?php

$GTabs = new UserTabs($form);
print $GTabs->makeTabs();
?>
		</div>

		<div class="col-lg-4">
			<div id="productfotoMain"></div>
		</div>
	</div>
</div>

	</form>
<?php
include PATH_TEMP . "admin_body_footer.php";
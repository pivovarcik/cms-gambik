<?php

$pagetitle = "Detail role";

define('AKT_PAGE',URL_HOME . 'role_detail');

$rolesController = new RolesController();
$rolesController->saveAction();
$form = new F_AdminRoleEdit();


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<form class="standard_form" method="post">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>
	<div class="buttons">
<?php print $form->getElement("upd_role")->render();?>
</div>

<?php echo $form->Result(); ?>


<?php $GTabs = new G_Tabs();

$tabs = array();
$contentMain ='';
$contentMain .=$form->getElement("title")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p1")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p2")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p3")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p4")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p5")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p6")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p7")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p8")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p9")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("p10")->render();
$contentMain .='<p class="desc"></p><br />';
$contentMain .=$form->getElement("id")->render();
//$contentMain .=$form->getElement("upd_role")->render();
$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $contentMain );
print $GTabs->makeTabs($tabs);
?>
	</form>
<?php
include PATH_TEMP . "admin_body_footer.php";
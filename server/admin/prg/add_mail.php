<?php
$cat = new PageComposite();
$messageController = new MailingController();
$messageController->createAction();
$form = new F_MailCreate();

//				$language = array("1" => "cs", "2" => "en","3" => "is");
define('AKT_PAGE',URL_HOME . 'mailing/add_mail');
$pagetitle = "Nový email";

$cat->serial_cat_url = "|root|mailing|faktura_add";
$cat->serial_cat_title = "|Nástěnka|Pošta|" . $pagetitle ;

$cat->title = $pagetitle ;
$pageButtons = array();
$pageButtons[] = $form->getElement("ins_mail")->render();



$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


<form method="post">
<?php  require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
<?php
print $form->Result();
?>

<?php
$pageTabs = new MailTabs($form);
print $pageTabs->makeTabs();
?>
</form>

<?php
include  PATH_TEMP . "admin_body_footer.php";
<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;



define('AKT_PAGE',URL_HOME . 'mj');
$ciselnikController = new MjController();
//$ciselnikController->createAjaxAction();
//PRINT_R($_SERVER);

include PATH_TEMP . "ciselnik_subscriber.php";

//$ciselnikController->createAction();
//$ciselnikController->saveAction();
//$ciselnikController->deleteAction();
$form = new Application_Form_MjCreate();
$DataGridProvider = new DataGridProvider("Mj");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();

$pageButtons[] = $DataGridProvider->addButton("Nová","?do=Create");

?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print getResultMessage();?>
	<?php print $form->Result(); ?>
<?php //print $DataGridProvider->table();?>

<?php print $DataGridProvider->ajaxTable();?>








<?php
include PATH_TEMP . "admin_body_footer.php";
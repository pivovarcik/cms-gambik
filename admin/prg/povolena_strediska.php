<?php

$pagetitle = "Povolená střediska";

define('AKT_PAGE',URL_HOME . 'povolena_strediska');
$catalogController = new StrediskaController();
//$catalogController->saveAction();
//$catalogController->copyAction();
//$catalogController->deleteAction();
//$catalogController->recycleAction();


$DataGridProvider = new DataGridProvider("PovolenaStrediska");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>

<div class="buttons"><a href="<?php print 'add_catalog'; ?>">+ Přidat</a> </div>

</div>

<?php
print $g->get_result_message2();
?>

<?php print $DataGridProvider->table(); ?>

</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";


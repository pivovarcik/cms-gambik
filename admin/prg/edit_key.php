<?php

$translatorController = new TranslatorController();
$translatorController->saveAction();

$form = new Application_Form_TranslatorEdit();

$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();


define('AKT_PAGE',URL_HOME . 'admin/edit_key');

$pagetitle = "Editace slova v slovníku";

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<section>
<div class="wraper">
<h1><?php echo $pagetitle; ?></h1>
<?php
print $form->Result();
?>
<p>Editace slova nebo fráze</p>
	<form class="standard_form" id="requiredfield" method="post">
	<fieldset>
<?php print $form->getElement("keyword")->render();?>
<p class="desc">Povinný údaj.</p>
<br />


				<?php
				// Verzování dle jazyků
				$first = true;
				foreach ($languageList as $key => $val)
				{
				?>

				<?php print $form->getElement("name_$val->code")->render();?>
				<p class="desc"></p>
<br />

				<?php
$first = false;
} ?>



<?php print $form->getElement("upd_keyword")->render();?>
<?php print $form->getElement("id")->render();?>
</p>
</fieldset>
</form>
</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
?>
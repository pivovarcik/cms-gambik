<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;


$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);

$translatorController = new TranslatorController();
$translatorController->createAction();

$form = new F_TranslatorCreate();

$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();


define('AKT_PAGE',URL_HOME . 'add_key');


$limit = 100;

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

<section>
<div class="wraper">
<?php
print getResultMessage();
?>
<h1><?php echo $pagetitle; ?></h1>
<p>Zadejte nové slovo nebo frázi</p>
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



<?php print $form->getElement("ins_keyword")->render();?>
</p>
</fieldset>
</form>
</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
?>
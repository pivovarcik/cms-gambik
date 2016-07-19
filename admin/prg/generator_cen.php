<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;
//error_reporting(E_ALL);
define('AKT_PAGE',$cat->link);

$productVyrobceController = new ProductCenaController();
$productVyrobceController->generatorAction();

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();

$form = new Application_Form_ProductCenyGenerator();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a href="'.   $cat->link . '/add_product_cenik"><i class="fa fa-plus-square"></i> Nový</a>';
?>

	<form class="standard_form" method="post">
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print $form->Result();?>
<div style="overflow: hidden;">
<?php print $form->getElement("cenik_id")->render(); ?>
<p class="desc"></p><br />


<fieldset>
<legend>Produkty, které  <?php print $form->getElement("skupina")->render(); ?> skupinu:</legend>
<?php
print '<ul class="parameters">';
foreach ($form->getElement("skupina_id[]") as $element) {
	print '<li>' . $element->render() .'</li>';
}
print '</ul>';
//print $form->getElement("skupina_id[0]")->render(); ?>
<p class="desc"></p><br />
</fieldset>

<fieldset>
<legend>Produkty, které  <?php print $form->getElement("vyrobce")->render(); ?> značku:</legend>
<?php
print '<ul class="parameters">';
foreach ($form->getElement("vyrobce_id[]") as $element) {
	print '<li>' . $element->render() .'</li>';
}
print '</ul>';
//print $form->getElement("vyrobce_id")->render(); ?>
<p class="desc"></p><br />
</fieldset>

<?php print $form->getElement("platnost_od")->render(); ?>
<p class="desc"></p><br />
<?php print $form->getElement("platnost_do")->render(); ?>
<p class="desc"></p><br />

<?php print $form->getElement("sleva")->render(); ?>
<p class="desc"></p><br />
<?php print $form->getElement("typ_slevy")->render(); ?>
<p class="desc"></p><br />

<?php print $form->getElement("generator")->render(); ?>
<p class="desc"></p><br />

</div>
</form>
<?php
include PATH_TEMP . "admin_body_footer.php";
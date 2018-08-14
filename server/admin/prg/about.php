<?php
include dirname(__FILE__) . "/../inc/init_admin.php";
$pagetitle = "Redakční systém Gambik!";
define('AKT_PAGE',URL_HOME . 'admin/about.php');

$form = new AboutCMSForm();


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<h1><?php echo $pagetitle; ?></h1>
<p class="tip">Děkujeme, že používáte redakční systém RS Gambik. Jeho užíváním přispíváte k dalšímu rozvoji systému. Aktuální informace o novinkách a změnách naleznete vždy na našich domovských stránkách <a href="http://www.pivovarcik.cz">www.pivovarcik.cz</a>.</p>
<form class="">
<fieldset class="well">

<?php echo $form->getElement("verze_cms")->render(); ?>
<p class="desc"><span class="check_version"></span></p>


<?php echo $form->getElement("licence_key_cms")->render(); ?>
<p class="desc">Licenční číslo k užívání systému.</p>
<?php echo $form->getElement("datum_instalace")->render(); ?>

<?php echo $form->getElement("datum_cms")->render(); ?>



<?php echo $form->getElement("verze_php")->render(); ?>
<?php echo $form->getElement("robots_txt")->render(); ?>
<?php echo $form->getElement("htaccess")->render(); ?>
<?php echo $form->getElement("autor_cms")->render(); ?>
<?php echo $form->getElement("autor_contact")->render(); ?>


</fieldset>

</form>
</div>
</section>
	<script>
$(document).ready(function(){
	check_version();
});
	</script>
<?php
include PATH_TEMP . "admin_body_footer.php";
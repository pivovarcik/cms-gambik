<?php
$userProfilController = new UserController();
$userProfilController->saveAction();
$userController->changePasswordProfilAction();
$formUserProfil = new Application_Form_AdminUserProfilEdit();
$formUserPwdChange = new Application_Form_AdminUserPwdChangeEdit();


define('AKT_PAGE',"/profil");
$pagetitle = "Editace profilu";
$GHtml->setPageTitle($pagetitle);
$GHtml->setPageDescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

		<div class="page-header">
			<h1>Nastavení profilu</h1>
			<div class="buttons">

			</div>
			<?php //print $form->Result();?>
		</div>

		<?php print $formUserProfil->Result();?>
		<form class="standard_form table_form" name="profilform" method="post">
			<fieldset>
				<?php print $formUserProfil->getElement("jmeno")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserProfil->getElement("prijmeni")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserProfil->getElement("email")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserProfil->getElement("mobil")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserProfil->getElement("titul")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserProfil->getElement("user_profil_edit")->render();?>
			</fieldset>
			<div class="clearfix"><!-- IE --></div>
		</form>

		<form class="standard_form table_form" name="profilpwdform" method="post">
			<fieldset>
				<legend>Změna hesla</legend>
				<?php print $formUserPwdChange->Result();?>
				<?php print $formUserPwdChange->getElement("pwd")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserPwdChange->getElement("newpwd1")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserPwdChange->getElement("newpwd2")->render();?>
				<p class="desc"></p><br />
				<?php print $formUserPwdChange->getElement("user_pwd_change")->render();?>
			</fieldset>
			<div class="clearfix"><!-- IE --></div>
		</form>
<?php include PATH_TEMP . "admin_body_footer.php";
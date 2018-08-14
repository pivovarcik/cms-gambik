<?php
$userProfilController = new UserController();
$userProfilController->saveAction();
$userProfilController->removeUserLoginAction();
$userController->changePasswordProfilAction();
$formUserProfil = new F_AdminUserProfilEdit();
$formUserPwdChange = new F_AdminUserPwdChangeEdit();


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
		<div class="row">

		<div class="col-sm-6">
		<form class="" enctype="multipart/form-data" method="post">
			<fieldset class="well">
				<?php print $formUserProfil->getElement("jmeno")->render();?>

				<?php print $formUserProfil->getElement("prijmeni")->render();?>

				<?php print $formUserProfil->getElement("email")->render();?>

				<?php print $formUserProfil->getElement("mobil")->render();?>

				<?php print $formUserProfil->getElement("titul")->render();?>
				<?php //print $formUserProfil->getElement("id")->render();?>


        			<?php print $formUserProfil->getElement("file")->render(); ?>
      
      <?php //print_r($formUserProfil->page);?>
      <?php if (!empty($formUserProfil->page->file)) { ?>
      
                        <img src="<?php print URL_IMG . $formUserProfil->page->file; ?>" />
    <?php   } ?>
    
				<?php print $formUserProfil->getElement("user_profil_edit")->render();?>
			</fieldset>
			<div class="clearfix"><!-- IE --></div>
		</form>

		</div>
		<div class="col-sm-6">


				<form name="profilpwdform" method="post">
				<fieldset class="well">
				<h2>Změna hesla</h2>
				<?php print $formUserPwdChange->Result();?>
				<?php print $formUserPwdChange->getElement("pwd")->render();?>

				<?php print $formUserPwdChange->getElement("newpwd1")->render();?>

				<?php print $formUserPwdChange->getElement("newpwd2")->render();?>

				<?php print $formUserPwdChange->getElement("user_pwd_change")->render();?>
			</fieldset>
			<div class="clearfix"><!-- IE --></div>
		</form>
		</div>

		</div>

<?php
$userLogin = new models_UserLogin();
$args = new ListArgs();
$args->user_id = USER_ID;
$userLoginList = $userLogin->getList($args);

//print_r($userLoginList);
?>
<h2>Údaje o aktuálním přihlášení</h2>
<?php

$browser = getBrowser();
?>

<?php print $browser["name"];?>, <?php print $browser["version"];?> <?php print $browser["platform"];?> <?php print $_SERVER["REMOTE_ADDR"];?>

<h2>Uložená trvalá přihlášení k tomuto účtu</h2>
<form method="post">
<table>

<tr>
<th>Prohlížeč</th>
<th>Operační systém</th>
<th>IP</th>
<th>Založeno</th>
<th>Naposledy použito</th>
</tr>
<?php
foreach ($userLoginList as $login) { ?>
<?php

$browser = getBrowser($login->user_agent);
?>
<tr>
<td><?php print $browser["name"];?>, <?php print $browser["version"];?></td>
<td><?php print $browser["platform"];?></td>
<td><?php print $login->ip_adresa;?></td>
<td><?php print date("j.n.Y H:i:s", strtotime($login->TimeStamp));?></td>
<td><?php print date("j.n.Y H:i:s", strtotime($login->LastLogin));?></td>
<td><button name="user_login_remove" value="<?php print $login->token;?>" class="btn btn-danger">Odebrat</button></td>
</tr>
<?php
}
?>
</table>
</form>


<?php include PATH_TEMP . "admin_body_footer.php";
<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(1);


if (isset($_GET["do"])) {
//	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
	$action = $_GET["do"];
	switch ($action) {


		case "updLicence":
			$basketController = new SettingsController();

			//	$basketController->delProduct();
			if ($basketController->saveLicenceKeyAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;
			}


			$formName = "Application_Form_LicenceEdit";
			$form = new $formName();
			//Nová sms zpráva
			$modalForm = new BootrapModalForm("myModal",$form);

$res .= '<div class="alert alert-warning">Platnost vašeho licenčního čísla vypršela, prosím zadejte nové licenční číslo</div>';
			$res .= '<div class="row">';
			$res .= '<div class="col-xs-12">';

			$res .= $form->getElement("licence_key")->render();
	//		$res .= $form->getElement("qty")->render();
			$res .= '</div>';
			$res .= '</div>';

			$res .= $form->getElement("upd_licence")->render();

			$modalForm->setBody($res);


			//	print_r($modalForm);
			$data["html"] = $modalForm->render();
			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;



	}

}
define('AKT_PAGE','/');

$userModel = new models_Users();
$params = new ListArgs();
$params->aktivni_od =  date("Ymd");
$userModel->getList($params);
$aktivni_users_dnes = $userModel->total;

$params = new ListArgs();
$params->aktivni_od =  date("Ymd",strtotime("-1 week"));
$userModel->getList($params);
$aktivni_users_tyden = $userModel->total;

$params = new ListArgs();
$params->novy_od =  date("Ymd");
$userModel->getList($params);
$novy_users_dnes = $userModel->total;

$params = new ListArgs();
$params->novy_od =  date("Ymd",strtotime("-1 week"));
$userModel->getList($params);
$novy_users_tyden = $userModel->total;


$cokoliv = '<script type="text/javascript">
$(document).ready(function() {
	loadStatistikaObjednavekTab();
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);


$GHtml->setPagetitle($cat->title);
$GHtml->setPagedescription($cat->pagedescription);

$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
			<div class="content_in">


				<p>Vítejte v administraci Vašich stránek.</p>
	<form class="standard_form" method="post">
<legend>

<h2>Přehled</h2>

<table>
	<tr>
		<td>
		<div class="stat_item">
			<span class="title_stat">Aktivní uživatelé</span>
			<span class="today"><strong><?php print $aktivni_users_dnes; ?></strong> dnes</span><br /><span class="week"><strong><?php print $aktivni_users_tyden; ?></strong> týden</span>
		</div>

		</td>
		<td>
		<div class="stat_item">
			<span class="title_stat">Nový uživatelé</span>
			<span class="today"><strong><?php print $novy_users_dnes; ?></strong> dnes</span><br /><span class="week"><strong><?php print $novy_users_tyden; ?></strong> týden</span>
		</div>
		</td>
	</tr>
		<tr>
		<td>
		</td>
		<td>
		</td>
	</tr>
</table>
	<br />
  </legend>
	</form>


	<?php


	$upozorneniSystemuA = array();

$userModelTest = new models_Users();
$userDetail = $userModelTest->getUserById(1);

	if ($userDetail && $userDetail->aktivni== 1 && $userDetail->password == "78a301055dc251d6de30ee8f013bc18f") {
		array_push($upozorneniSystemuA, AlertHelper::alert("Bezpečnostní riziko! Změňte heslo pro <strong>admin</strong> účet! Je použito univerzální heslo.","danger"));
	}

	if ($settings->get("google_analytics_key") == "") {
				array_push($upozorneniSystemuA,AlertHelper::alert("Není vyplněn <strong>kód Google Analytics</strong> pro sledování statistik přístupů návštěvníků!","warning"));
	}

$filename = PATH_ROOT. "robots.txt";
//$file = file_get_contents($filename);
if(!is_file($filename)) {
	array_push($upozorneniSystemuA,AlertHelper::alert("Neexistuje konfigurační soubor <strong>robots.txt</strong>! Některé vyhledávače vyžadují přítomnost souboru.","warning"));
}

$filename = PATH_ROOT. "export/sitemap.php";
if(!is_file($filename)) {
	array_push($upozorneniSystemuA,AlertHelper::alert("Neexistuje soubor <strong>sitemap.xml</strong>! Některé vyhledavče vyžadují přítomnost souboru.","warning"));
}

if (count($upozorneniSystemuA) > 0) { ?>


	<h2>Upozornění systému</h2>
	<ul class="warnings">
<?php


	foreach ($upozorneniSystemuA as $upozorneni) { ?>
		<li><?php print $upozorneni;?></li>
<?php	}
	?>

	</ul>
	<?php
}
?>

	</ul>

				</div>

<?php require_once(PATH_TEMP . 'admin_body_footer.php');
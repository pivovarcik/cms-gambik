<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = "Přehled emailových zpráv";

define('AKT_PAGE',URL_HOME . 'mailing');

$mailController = new MailingController();
if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();


	if ($mailController->createAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	$formName = "Application_Form_MailCreate";
	$form = new $formName();
	//Nová sms zpráva
	$modalForm = new BootrapModalForm("myModal",$form);


	$res .= '<div class="row">';
	$res .= '<div class="col-sm-12">';
	$res .= $form->getElement("adresat_id")->render();
	$res .= '</div>';


	$res .= '<div class="col-sm-12">';

	$res .= $form->getElement("subject")->render();
	$res .= '</div>';


		$res .= '<div class="col-sm-12">';
	$res .= $form->getElement("description")->render();
	$res .= $form->getElement("action")->render();

	$res .= '</div>';
	$res .= '</div>';


//	$res .= '<p class="text-warning"><small>K odeslání SMS je nutné mít dostatečný kredit</small></p>';
	$modalForm->setBody($res);


	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}

$DataGridProvider = new DataGridProvider("Mailing");



$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_mail">Nový</a>';
$pageButtons[] = $DataGridProvider->addButton("Nový", "mailing?do=EmailCreate");
//$pageButtons[] = '<a class="btn-add" data-rel="?id=1&do=MailCreate" href="'.  URL_HOME . 'add_mail"><i class="fa fa-plus-square"></i> Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>



<?php print $DataGridProvider->ajaxtable();?>

<?php include PATH_TEMP . "admin_body_footer.php";
<?php
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
define('AKT_PAGE',URL_HOME . 'smsgatein');
$smsController = new SmsGateController();



if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();


	if ($smsController->sendSmsAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	$formName = "F_SmsCreate";
	$form = new $formName();
	//Nová sms zpráva
	$modalForm = new BootrapModalForm("myModal",$form);


$res .= '<div class="form-group">';
$res .= '<label for="message-text" class="control-label">Mobilní číslo:</label>';
$res .= $form->getElement("phone")->render();
	                    $res .= '</div>';


					   $res .= '<div class="form-group">';
	                            $res .= '<label for="message-text" class="control-label">Zpráva:</label>';
$res .= $form->getElement("message")->render();
$res .= $form->getElement("action")->render();

	                    $res .= '</div>';


	                    $res .= '<p class="text-warning"><small>K odeslání SMS je nutné mít dostatečný kredit</small></p>';
	               $modalForm->setBody($res);


	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}

//$smsController->sendSmsAction();
$DataGridProvider = new DataGridProvider("SmsGate");
//$form = new F_SmsCreate();

$GHtml->setPagetitle($cat->pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_sms">Nová</a>';
//$pageButtons[] = '<a class="btn btn-sm btn-info add-modal" href="#">Nová</a>';
$pageButtons[] = $DataGridProvider->addButton("Nová", "smsgatein?do=SmsCreate");
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>
	<?php //print $form->Result();?>

<?php // print $DataGridProvider->table(); ?>
<?php print $DataGridProvider->ajaxTable();?>



<?php
include PATH_TEMP . "admin_body_footer.php";
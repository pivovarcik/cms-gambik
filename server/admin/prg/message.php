<?php
//include dirname(__FILE__) . "/../inc/init_admin.php";

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);

$messageController = new MessageController();
//$messageController->createAction();

if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();


	if ($messageController->createAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}
  if ($action == "MsgChat")
  {
  	$formName = "F_ChatForm";
  	$form = new $formName();
  	//Nová sms zpráva
  	$modalForm = new BootrapModalForm("myModal",$form);
  
  
  	$res .= '<div class="row">';
  	$res .= '<div class="col-sm-12">';
  	$res .= $form->getElement("adresat_id")->render();
  	$res .= '</div>';
  
  
  	$res .= '<div class="col-sm-12">';
  	$res .= $form->getElement("message")->render();
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
  if ($action == "MsgCreate")
  {
  	$formName = "F_MessageCreate";
  	$form = new $formName();
  	//Nová sms zpráva
  	$modalForm = new BootrapModalForm("myModal",$form);
  
  
  	$res .= '<div class="row">';
  	$res .= '<div class="col-sm-12">';
  	$res .= $form->getElement("adresat_id")->render();
  	$res .= '</div>';
  
  
  	$res .= '<div class="col-sm-12">';
  	$res .= $form->getElement("message")->render();
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

}

define('AKT_PAGE',URL_HOME . 'message');
$DataGridProvider = new DataGridProvider("Message");

//adresat_autor

//$table = $DataGridProvider->table();
//$messagesList = $DataGridProvider->getDataLoaded();
/*
for($i=0;$i<count($messagesList);$i++)
{
	if (empty($messagesList[$i]->ReadTimeStamp) && $messagesList[$i]->autor_id <> USER_ID) {
		$messageController->setReader($messagesList[$i]->id);
	}
}*/
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_mail">No</a>';
$pageButtons[] = $DataGridProvider->addButton("Nová", "message?do=MsgCreate");
//$pageButtons[] = '<a class="btn-add" data-rel="?id=1&do=MailCreate" href="'.  URL_HOME . 'add_mail"><i class="fa fa-plus-square"></i> Nový</a>';
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>



<?php print $DataGridProvider->ajaxtable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";
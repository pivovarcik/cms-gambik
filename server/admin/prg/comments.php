<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);

$commentsController = new CommentsController();

if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();


	if ($commentsController->createAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}

	$formName = "F_CommentsCreate";
	$form = new $formName();
	//Nová sms zpráva
	$modalForm = new BootrapModalForm("myModal",$form);


//	$res .= '<div class="row">';
	$res .= $form->getElement("category_id")->render();
//	$res .= '</div>';



//	$res .= '<div class="row">';
	$res .= $form->getElement("message")->render();
	$res .= $form->getElement("action")->render();

//	$res .= '</div>';


	//	$res .= '<p class="text-warning"><small>K odeslání SMS je nutné mít dostatečný kredit</small></p>';
	$modalForm->setBody($res);


	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
}

$DataGridProvider = new DataGridProvider("Comments");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
//$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'add_comment">Nový</a>';
$pageButtons[] = $DataGridProvider->addButton("Nový", "comments?do=CommentCreate");
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php print getResultMessage(); ?>
<?php print $DataGridProvider->ajaxtable();?>
<?php
include PATH_TEMP . "admin_body_footer.php";
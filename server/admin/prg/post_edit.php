<?php

$url = $TreeMenu->getUserUrlQuery(URL_HOME . "posts");


$publishController = new PublishController();




if (isset($_GET["do"])) {

	$action = $_GET["do"];

	$data = array();

  	switch ($action) {
    
    	case "newsletterCreate":
    
      $mailController = new PublishController();
    	if ($mailController->sendNewsletterAjaxAction() === true) {
    		$data["status"] = "success";
    		$json = json_encode($data);
    		print_r($json);
    		exit;
    
    	}
    
    	$formName = "F_NewsletterCreate";
      $form = new $formName();
      
      	//Nová sms zpráva
	$modalForm = new BootrapModalForm("myModal",$form,"medium");

  		$GTabs = new NewsletterTabs($form);
		$body = $GTabs->makeTabs();
      $modalForm->setBody($body);
       /*
	$res .= '<div class="row">';
	$res .= '<div class="col-sm-12">';
//	$res .= $form->getElement("adresat_id")->render();
	$res .= '</div>';


	$res .= '<div class="col-sm-12">';

//	$res .= $form->getElement("subject")->render();
	$res .= '</div>';


		$res .= '<div class="col-sm-12">';
	$res .= $form->getElement("description_cs")->render();
//	$res .= $form->getElement("action")->render();

	$res .= '</div>';
	$res .= '</div>';
                        */

//	$res .= '<p class="text-warning"><small>K odeslání SMS je nutné mít dostatečný kredit</small></p>';
//	$modalForm->setBody($res);


	$data["html"] = $modalForm->render();
	$data["control"] = $name;
	$data["action"] = $action;
	$json = json_encode($data);
	print_r($json);
	exit;
  break;
  
  }
  
}
$publishController->saveAction();
$publishController->sendNewsletterAction();
$publishController->sendNewsletterTestAction();
$form = new F_PublishPostEdit();

$nextPrevButton = $publishController->getNextPrevButton($_GET["id"], $url);



$languageModel = new models_Language();
$languageList = $languageModel->getActiveLanguage();

$pagetitle = "Editace článku";

if (empty($_GET["id"])){ return FALSE; } else { $id = $_GET["id"];}

define('AKT_PAGE',URL_HOME . 'admin/post_edit.php?id=' . $id);


$params = array(
'buttons1'=>$settings->get("TINY_BUTTONS1"),
'buttons2'=>$settings->get("TINY_BUTTONS2"),
'buttons3'=>$settings->get("TINY_BUTTONS3"),
'valid'=>$settings->get("TINY_VALID"),
'width'=>$settings->get("TINY_WIDTH"),
'height'=>$settings->get("TINY_HEIGHT"),
'plugins'=>$settings->get("TINY_PLUGINS"),
'menubar'=>"edit tools table format view insert",
);
$script = tinyMceInit($params);
$GHtml->setCokolivToHeader($script);



$cokoliv = '<script type="text/javascript">
$(document).ready(function(){
	getMainFoto(' . $form->page->foto_id . ');
	loadCategoryPicker("Category");
});
</script>';
$GHtml->setCokolivToHeader($cokoliv);



$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>


	<form class="" method="post">
	<div class="page-header">

	<h1><?php echo $pagetitle; ?>
	 <?php
if (count($languageList)>1)
{
	// Verzování dle jazyků
	$first = true;
	foreach ($languageList as $key => $val)
	{
		$selected = ' class="langLink"';
		if ($first) { $selected = ' class="lang_selected langLink"'; }?>

		 <a<?php print $selected;?> id="lnkLang<?php print strtoupper($val->code);?>" href="javascript:show_lang('<?php print $val->code;?>');"><?php print strtoupper($val->code);?></a>
		   <?php $first = false;
	}
}?>
	</h1>


	<div class="buttons">
		<?php print $nextPrevButton;?>
		<?php print $form->getElement("upd_post")->render();?>
		<a class="btn btn-sm btn-info" href="<?php print URL_HOME . 'add_post'; ?>">Nový</a>
		<a class="btn btn-sm btn-info modal-form" data-url="<?php print URL_HOME . 'post_edit?do=newsletterCreate&id=' . $form->page_id ; ?>" href="#">Odeslat newsletter</a>
	</div>
	<?php print $form->Result();?>
</div>





<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">


					<?php
					$pageTabs = new PublishTabs($form);
					print $pageTabs->makeTabs($tabs);
					?>


		</div>

		<div class="col-lg-4">
			<div id="productfotoMain"></div>
		</div>
	</div>
</div>



    </form>
<?php
include PATH_TEMP . "admin_body_footer.php";
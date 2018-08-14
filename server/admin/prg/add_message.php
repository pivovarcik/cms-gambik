<?php

$messageController = new MessageController();
$messageController->createAction();
$form = new F_MessageCreate();

//				$language = array("1" => "cs", "2" => "en","3" => "is");
define('AKT_PAGE',URL_HOME . 'admin/add_message.php');
$pagetitle = "Nová zpráva";



$GHtml->setPagetitle($pagetitle);
//$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>

	<form class="standard_form" method="post">
<?php
//print $print_result;
print $g->get_result_message2();
?>


<h1><?php echo $pagetitle; ?></h1>

	<p>Napište rychlou zprávu</p>
	<?php print $form->getElement("ins_message")->render();?>


	<?php
		$tabs = new MessageTabs($form);
		print $tabs->makeTabs();
		?>



</form>
<?php
include PATH_TEMP . "admin_body_footer.php";
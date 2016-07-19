<?php

//error_reporting(E_ALL);

$messageController = new SmsGateController();
$messageController->sendSmsAction();
$form = new Application_Form_SmsCreate();

//				$language = array("1" => "cs", "2" => "en","3" => "is");
define('AKT_PAGE',URL_HOME . 'add_sms');
$pagetitle = "Nová SMS zpráva";


$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

	<form class="standard_form" id="requiredfield" method="post">





	<p>Napište rychlou zprávu</p>
	<?php print $form->Result();?>
	<?php print $form->getElement("ins_sms")->render();?>
<div class="product_tabs ui-tabs">
<?php
$select_desc = ' class="ui-tabs-selected"';
$ul_hlavni = '';
?>
	<ul class="ui-tabs-nav">
		<li<?php print $select_desc; ?>><a href="<?php print AKT_PAGE; ?>#TabDesc">Hlavní</a></li>
	</ul>
	<div class="clear"> </div>
	<div id="TabDesc" class="ui-tabs-panel<?php print $ul_hlavni; ?>">
  		<div class="container_content_labels">
			<div class="container_parameters">
				<?php print $form->getElement("phone")->render();?>
				<p class="desc">telefonní číslo - Povinný údaj.</p>
				<br />
				<?php print $form->getElement("message")->render();?>
				<p class="desc">Krátká zpráva 160 zanků.</p>
				<br />
			</div>
		</div>
	</div>
</div>


</form>
<?php
include PATH_TEMP . "admin_body_footer.php";
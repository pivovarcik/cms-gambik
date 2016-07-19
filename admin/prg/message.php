<?php
//include dirname(__FILE__) . "/../inc/init_admin.php";

$pagetitle = "Seznam zpráv";
$messageController = new MessageController();
$messageController->createAction();
define('AKT_PAGE',URL_HOME . 'message');
$DataGridProvider = new DataGridProvider("Message");
$table = $DataGridProvider->table();
$messagesList = $DataGridProvider->getDataLoaded();

for($i=0;$i<count($messagesList);$i++)
{
	if (empty($messagesList[$i]->ReadTimeStamp) && $messagesList[$i]->autor_id <> USER_ID) {
		$messageController->setReader($messagesList[$i]->id);
	}
}
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<h1><?php print $pagetitle; ?></h1>
<div class="buttons"><a href="<?php print URL_HOME . 'add_message'; ?>">+ Napsat zprávu</a></div>
<p><?php print $cat->description; ?></p>
<?php //print $g->get_result_message2();?>
<?php print $table;?>
</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
<?php


class ViewModel {
	public $pagetitle = "";
	public $pagedescription = "";

}

class AdminViewModel extends ViewModel {

	protected function pageHeader()
	{
		$res = '<div class="page-header">';
		$res .= '<h1>' . $pagetitle . GoBackLink() .'</h1>';


		$res .= '<div class="breadcrumb">' . $Breadcrumb . GoBackLink() .'<div class="page-help"><a href="#"><i class="fa fa-question-circle"></i></a></div></div>';


		$res .= '<div class="buttons">';

		if (isset($pageButtons) && is_array($pageButtons)) {
			foreach ($pageButtons as $key=>$val) {

				print $val . ' ';
			}
		}
			$res .= '</div>';
			$res .= '</div>';

	}
}


$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

$userController->createAction();
$userController->saveAction();


$form = new F_AdminUserEdit();


$url = $TreeMenu->getUserUrlQuery(URL_HOME . "users");
$nextPrevButton = $userController->getNextPrevButton($_GET["id"], $url);
/*
$GHtml->setServerJs('/js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs('/js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs('/js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs('/js/SWFUpload/js/handlers.js');

*/
$pagetitle = "Detail uživatele";

define('AKT_PAGE', URL_HOME . 'user_detail');

$GHtml->setPagetitle($pagetitle);
//$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<form class="" method="post">
<div class="page-header">
<h1><?php echo $pagetitle; ?></h1>
	<div class="buttons">
<?php print $form->getElement("edit_user")->render();?>
<?php print $nextPrevButton;?> <a class="btn btn-sm btn-info" href="<?php print URL_HOME . 'user_add'; ?>">Nový</a>
</div>
<?php
print $form->Result();
?>
</div>






<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">
<?php

$GTabs = new UserTabs($form);
print $GTabs->makeTabs();
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
?>
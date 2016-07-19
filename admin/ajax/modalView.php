<?php

class BaseView {

	public $viewTitle;
	public $formName;
	public $body;

	public function __construct($viewTitle, $formObject, $body)
	{
		$this->viewTitle = $viewTitle;
		$this->formName = $formObject;
		$this->body = $body;
	}
	public function header(){

		$res = '';
		$res .= '<div class="modal-header">';
		$res .= '<button title="Zavřít" aria-hidden="true" data-dismiss="modal" class="close-button" type="button"></button>';
		$res .= '<h3>' . $this->viewTitle . '</h3>';
		$res .= '</div>';

		return $res;
	}

	public function footer(){
		$res = '';
		$res .= '<div class="modal-footer">';
		$res .= '<button title="Close" class="close-button button btn"><span>Zavřít</span></button>';


		$elements = $this->formName->getElementByType("Button");
		foreach ($elements as $element) {
			$res .= $element->render();
		}

		$elements = $this->formName->getElementByType("Submit");
		foreach ($elements as $element) {
			$res .= $element->render();
		}
		$res .= '</div>';

		return $res;
	}

	public function body(){
		$res = '';
		$res .= '<div class="modal-body">';
		$res .= $this->body;
		$res .= '</div>';

		return $res;
	}
	public function viewRender()
	{
		$res = '';
		$res .= '<div class="page-view page-view-modal">';
		$res .= $this->header();

		$res .= '<form name="' . get_class($this->formName) . '" id="' . get_class($this->formName) . '" class="page-form" method="post" action="/zadani?do=' . get_class($this->formName) . '-submit">';
		$res .= $this->body();
		$res .= $this->footer();
		$res .= '</form>';
		$res .= '</div>';
		return $res;
	}
}
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";
//error_reporting(E_ALL);

$viewModelClass =  $_GET["do"] . "ViewModel";
if (class_exists($viewModelClass)) {
	$viewModel = new $viewModelClass;

	print $viewModel->viewRender();
	exit;
} else {
	exit;
}

$messageController = new MailingController();
$messageController->createAction();
//$form = new Application_Form_MailCreate();
//$elements = $form->getElementByType("Button");
//print_r($elements);
$tabs = new MailTabs($form);
$body = $tabs->makeTabs();
$view = new BaseView("Nový email", $form, $body);

$formName = "newTaskForm";

print $view->viewRender();
exit;
?>


<div class="page-view page-view-modal">

<?php print $g->get_result_message2();?>


<h1><?php echo $pagetitle; ?></h1>


<div class="modal-header">
	<button title="Zavřít" aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
	<h3>Nové zadání</h3>
</div>

<form name="<?php print $formName; ?>" id="<?php print $formName; ?>" class="page-form" method="post" action="/zadani?do=<?php print $formName; ?>-submit">
<div class="modal-body">

	<p>Napište rychlou zprávu</p>
	<div class="ui-tabs">
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
					<?php print $form->getElement("adresat_email")->render();?>
					<p class="desc">příjemce emailové zprávy</p>
					<br />

					<?php print $form->getElement("subject")->render();?>
					<p class="desc">Předmět emailové zpávy</p>
					<br />
					<?php print $form->getElement("description")->render();?>
					<p class="desc">Obsah emailové zprávy</p>
					<br />
				</div>
			</div>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button title="Close" class="close-button button btn"><span>Zavřít</span></button>
	<?php print $form->getElement("ins_mail")->render();?>
</div>
</form>
</div>


<?php

exit; ?>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

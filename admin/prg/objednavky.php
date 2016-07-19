<?php


if (isset($_GET["do"])) {

	switch ($_GET["do"]) {
		case "ObjednavkaDelete":
			$ProductVariantyController = new OrderController();

			if ($ProductVariantyController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "Application_Form_ObjednavkaDeleteConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
			$modalForm->setBody($body);;

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
		case "ObjednavkaCopy":
			$ProductVariantyController = new OrderController();

			if ($ProductVariantyController->copyAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "Application_Form_ObjednavkaCopyConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
			$modalForm->setBody($body);;

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;

		case "ObjednavkaStorno":
			$ProductVariantyController = new OrderController();

			if ($ProductVariantyController->stornoAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "Application_Form_ObjednavkaStornoConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
			$modalForm->setBody($body);;

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;

		case "ObjednavkaEdit":
			$ProductVariantyController = new OrderController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
			$formName = "Application_Form_ObjednavkaEdit";

			$form = new $formName();

			$modalForm = new BootrapModalForm("myModal",$form);

			$body = '';
$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("code")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("stav")->render();
			$body .= '</div>';
$body .= '</div>';







			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("order_date")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("cost_total")->render();
			$body .= '</div>';

			$body .= '</div>';

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("shipping_transfer")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("shipping_pay")->render();
			$body .= '</div>';

			$body .= '</div>';

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("description_secret")->render();
			$body .= $form->getElement("action")->render();
			$body .= '</div>';

			$body .= '</div>';


			$modalForm->setBody($body);

			/*
			   //$modalForm->setBody($res);
			   foreach ($form->getElement() as $key => $element ) {
			   if (get_class($element) != "G_Form_Element_Submit" && get_class($element) != "G_Form_Element_Button") {
			   $modalForm->addElement($element);
			   }

			   }

			*/

			//	$modalForm->setBody($form->filterDefinitionRender());

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
		default:
			exit;


	}
}
$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;
define('AKT_PAGE',$cat->link);
$ordersController = new OrderController();
$ordersController->stornoAction();
$ordersController->copyAction();
$ordersController->deleteAction();

$args = new OrdersListArgs();
//print_r($args->shipping_first_name);
$DataGridProvider = new DataGridProvider("Orders",$args);
$DataGridProvider->setModalForm();
$DataGridProvider->actionRegister("copy","Kopírovat");
$DataGridProvider->actionRegister("storno","Stornovat");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();



$filterList = new ObjednavkaFilter();
$filter = '<form class="standard_form filter_form page-filter" method="get">';
$filter .= '<div class="filtr_name">Pořízeno:</div>';

$filter .= '<div class="filtr_values">od: '.$filterList->getElement("df")->render().' - do: '.$filterList->getElement("dt")->render().'</div>';
$filter .= '<div class="clearfix"> </div>';

$filter .= ''.$filterList->getElement("code")->render().'';
$filter .= '<div class="clearfix"> </div>';

$filter .= ''.$filterList->getElement("shipping_first_name")->render().'';
$filter .= '<div class="clearfix"> </div>';

$filter .= ''.$filterList->getElement("shipping_email")->render().'';
$filter .= '<div class="clearfix"> </div>';

$filter .= '<div class="filtr_name">Částka:</div>';

$filter .= '<div class="filtr_values">od: '.$filterList->getElement("lowestPrice")->render().'Kč - do: '.$filterList->getElement("highestPrice")->render().'Kč</div>';
$filter .= '<div class="clearfix"> </div>';



$filter .= '<div id="slider-range"></div>';
$filter .= '<script>';
$filter .= '$(function() {';
$filter .= '$( "#slider-range" ).slider({';
$filter .= 'range: true,';
$filter .= 'min: 0,';
$filter .= 'max: 99999,';
$filter .= 'values: [ '.$filterList->getElement("lowestPrice")->getValue().', '.$filterList->getElement("highestPrice")->getValue().' ],';
$filter .= 'slide: function( event, ui ) {';
$filter .= '$( "#lowestPrice" ).val(  ui.values[ 0 ] );';
$filter .= '$( "#highestPrice" ).val( ui.values[ 1 ] );';
$filter .= '}';
$filter .= '});';
$filter .= '$( "lowestPrice" ).val($( "#slider-range" ).slider( "values", 0 ));';
$filter .= '$( "highestPrice" ).val($( "#slider-range" ).slider( "values", 1 ));';

$filter .= '});';
$filter .= '</script>';



$filter .= '<p class="WizardParametersAjax"><a href="'.AKT_PAGE.'" type="reset" class="button">Zrušit filtr</a> <button type="submit" class="tlac">Filtrovat</button></p>';
$filter .= '</form>';

include PATH_TEMP . "admin_body_header.php";


$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-default" href="'.  URL_HOME . 'eshop/objednavky_detailne">Detailní přehled</a>';
$pageButtons[] = '<a class="btn btn-sm btn-default" href="'.  URL_HOME . 'eshop/objednavky_kalendar">Kalendář</a>';
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'eshop/objednavka_add">Nová</a>';
?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>

<?php
print getResultMessage();
?>


<?php
print $filter;
?>
<?php print $DataGridProvider->ajaxTable();?>

<?php
include PATH_TEMP . "admin_body_footer.php";
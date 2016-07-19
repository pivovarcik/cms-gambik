<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);


$productController = new ProductController();
$productController->saveAction();
$productController->copyAction();
$productController->deleteAction();

if ($productController->setAttributeProduct($_GET["id"]) === true) {
	$data["status"] = "success";
	$json = json_encode($data);
	print_r($json);
	exit;

}
if (isset($_GET["do"])) {

	$ProductVariantyController = new ProductVariantyController();
	if ($ProductVariantyController->deleteAjaxAction() === true) {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;

	}
	switch ($_GET["do"]) {


		case "ProductEdit":
			$ProductVariantyController = new ProductController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
			$formName = "Application_Form_ProductEdit";

			$form = new $formName();

			$modalForm = new BootrapModalForm("myModal",$form);

			$body = '';
			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("cislo")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("title_cs")->render();
			$body .= '</div>';
			$body .= '</div>';


			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("qty")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("skupina_id")->render();
			$body .= '</div>';

			$body .= '</div>';

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("prodcena_sdph")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("dostupnost_id")->render();
			$body .= '</div>';

			$body .= '</div>';

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("aktivni")->render();
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

		case "ProductDelete":
			$ProductVariantyController = new ProductController();

			if ($ProductVariantyController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}

			$formName = "Application_Form_ProductDeleteConfirm";

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

		case "ProductVariantyDelete":
			$ProductVariantyController = new ProductVariantyController();

			if ($ProductVariantyController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}

			$formName = "Application_Form_ProductVariantyDeleteConfirm";

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

		case "variantyEdit":
			$ProductVariantyController = new ProductVariantyController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
			$formName = "Application_Form_ProductVariantyEdit";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);


			$body = '';
		/*	$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("code")->render();
			$body .= '</div>';
			$body .= '</div>';
*/

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("code")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("qty")->render();
			$body .= '</div>';
			$body .= '</div>';


			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("name")->render();
			$body .= '</div>';
			$body .= '</div>';


			$eshopSettings = G_EshopSetting::instance();
			if ($eshopSettings->get("PRICE_TAX") == 0) {
				$name = "price";
			} else {
				$name = "price_sdani";
			}

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement($name)->render();
			$body .= '</div>';


			$body .= '<div class="col-xs-6">';
			$form->getElement("dph_id")->setAttrib("label","Daň");
			$body .= $form->getElement("dph_id")->render();
			$body .= '</div>';
			$body .= '</div>';


			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("dostupnost_id")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("order")->render();
			$body .= '</div>';
			$body .= '</div>';
			$body .= $form->getElement("action")->render();





			$atributyCheckbox = '<div class="row">';
			foreach ($form->atributyList as $key => $atribut ) {

				//	print_r($atribut);
				$atributyCheckbox .= '<div class="col-xs-3">';





				$name =  "attribute_original_id[]";
				$elem = new G_Form_Element_Hidden($name);
				$elem->setAttribs('class','attribute_original_id');
				//	$value = $this->getPost($name, $atribut->id);
				//print $value;

				$elem->setAttribs('value',$atribut->id);
				$form->addElement($elem);
				//	$elem->setAnonymous();
				$atributyCheckbox .= $elem->render();


				$name = "has_attribute_id[]";
				$elem= new G_Form_Element_Checkbox($name);
				$elem->setAttribs('class','has_attribute_id');
				$value = $atribut->id;


				$elem->setAttribs('value',$value);
				$elem->setAttribs('label',$atribut->name);

				$has_attribute = false;
				if (($form->Request->isPost() && $form->getPost($name, false))) {
					$elem->setAttribs('checked','checked');
					$has_attribute = true;
				} elseif ($atribut->has_attribute == 1) {
					$has_attribute = true;
					$elem->setAttribs('checked','checked');
				}
				$elem->setAttribs('onclick',"javascript:attrChecked(this);");
				$form->addElement($elem);
				$atributyCheckbox .= $elem->render();

				$name =  "attribute_id[]";
				$elem = new G_Form_Element_Hidden($name);
				if ($has_attribute) {
					$value = $form->getPost($name, $atribut->id);
				} else {
					$value = $form->getPost($name, 0);
				}

				//print $value;
				$elem->setAttribs('class','attribute_id');
				$elem->setAttribs('value',$value);
				$form->addElement($elem);
				//	$elem->setAnonymous();
				$atributyCheckbox .= $elem->render();

				$attribList = $form->atributyValuesList[$atribut->id];
				//get_class($this) .
				$name = "attribute_value_id[{$atribut->id}]";
				$elem = new G_Form_Element_Select($name);
				$elem->setDecoration();
				$value2 = $form->getPost($name, $atribut->attribute_id);
				$elem->setAttribs('value', $value2);
				if (!$has_attribute) {
					$elem->setAttribs('style','display:none;');
				}
				$elem->setAttribs('class','selectbox');
				$pole = array();

				foreach ($attribList as $keya => $valuea)
				{
					$pole[$valuea->id] = $valuea->name;
				}
				//print_r($pole);
				$elem->setMultiOptions($pole);
				//	array_push($elements, $elemAttrib);
				$form->addElement($elem);
				$atributyCheckbox .= $elem->render();


				$atributyCheckbox .= '</div>';
			}
			$atributyCheckbox .= '</div>';
			$body .= $atributyCheckbox;

			/*
			//$modalForm->setBody($res);
			foreach ($form->getElement() as $key => $element ) {
				if (get_class($element) != "G_Form_Element_Submit" && get_class($element) != "G_Form_Element_Button") {
					$modalForm->addElement($element);
				}

			}
*/
			$modalForm->setBody($body);
			//	$modalForm->setBody($form->filterDefinitionRender());

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
		case "variantyCreate":
			$ProductVariantyController = new ProductVariantyController();

			if ($ProductVariantyController->createAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
			$formName = "Application_Form_ProductVariantyCreate";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);


			$body = '';
			/*	$body .= '<div class="row">';
			   $body .= '<div class="col-xs-12">';
			   $body .= $form->getElement("code")->render();
			   $body .= '</div>';
			   $body .= '</div>';
			*/

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("code")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("qty")->render();
			$body .= '</div>';
			$body .= '</div>';


			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("name")->render();
			$body .= '</div>';
			$body .= '</div>';


			$eshopSettings = G_EshopSetting::instance();
			if ($eshopSettings->get("PRICE_TAX") == 0) {
				$name = "price";
			} else {
				$name = "price_sdani";
			}

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement($name)->render();
			$body .= '</div>';


			$body .= '<div class="col-xs-6">';
			$form->getElement("dph_id")->setAttrib("label","Daň");
			$body .= $form->getElement("dph_id")->render();
			$body .= '</div>';
			$body .= '</div>';


			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("dostupnost_id")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("order")->render();
			$body .= '</div>';
			$body .= '</div>';
			$body .= $form->getElement("action")->render();

			$atributyCheckbox = '<div class="row">';
			foreach ($form->atributyList as $key => $atribut ) {

				//	print_r($atribut);
				$atributyCheckbox .= '<div class="col-xs-3">';





				$name =  "attribute_original_id[]";
				$elem = new G_Form_Element_Hidden($name);
				$elem->setAttribs('class','attribute_original_id');
				//	$value = $this->getPost($name, $atribut->id);
				//print $value;

				$elem->setAttribs('value',$atribut->id);
				$form->addElement($elem);
				//	$elem->setAnonymous();
				$atributyCheckbox .= $elem->render();


				$name = "has_attribute_id[]";
				$elem= new G_Form_Element_Checkbox($name);
				$elem->setAttribs('class','has_attribute_id');
				$value = $atribut->id;


				$elem->setAttribs('value',$value);
				$elem->setAttribs('label',$atribut->name);

				$has_attribute = false;
				if (($form->Request->isPost() && $form->getPost($name, false))) {
					$elem->setAttribs('checked','checked');
					$has_attribute = true;
				} elseif ($atribut->has_attribute == 1) {
					$has_attribute = true;
					$elem->setAttribs('checked','checked');
				}
				$elem->setAttribs('onclick',"javascript:attrChecked(this);");
				$form->addElement($elem);
				$atributyCheckbox .= $elem->render();

				$name =  "attribute_id[]";
				$elem = new G_Form_Element_Hidden($name);
				if ($has_attribute) {
					$value = $form->getPost($name, $atribut->id);
				} else {
					$value = $form->getPost($name, 0);
				}

				//print $value;
				$elem->setAttribs('class','attribute_id');
				$elem->setAttribs('value',$value);
				$form->addElement($elem);
				//	$elem->setAnonymous();
				$atributyCheckbox .= $elem->render();

				$attribList = $form->atributyValuesList[$atribut->id];
				//get_class($this) .
				$name = "attribute_value_id[{$atribut->id}]";
				$elem = new G_Form_Element_Select($name);
				$elem->setDecoration();
				$value2 = $form->getPost($name, $atribut->attribute_id);
				$elem->setAttribs('value', $value2);
				if (!$has_attribute) {
					$elem->setAttribs('style','display:none;');
				}
				$elem->setAttribs('class','selectbox');
				$pole = array();

				foreach ($attribList as $keya => $valuea)
				{
					$pole[$valuea->id] = $valuea->name;
				}
				//print_r($pole);
				$elem->setMultiOptions($pole);
				//	array_push($elements, $elemAttrib);
				$form->addElement($elem);
				$atributyCheckbox .= $elem->render();


				$atributyCheckbox .= '</div>';
			}
			$atributyCheckbox .= '</div>';
			$body .= $atributyCheckbox;

			$modalForm->setBody($body);
	/*		foreach ($form->getElement() as $key => $element ) {
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
			$formName = "Application_Form_ProductAtributeEdit";
			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);


			foreach ($form->getElement() as $key => $element ) {
				if (get_class($element) != "G_Form_Element_Submit" && get_class($element) != "G_Form_Element_Button") {
					$modalForm->addElement($element);
				}

			}


			$modalForm->setBody($form->filterDefinitionRender());

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;

	} // switch



}






$args = new ListArgs();
$args->lang = LANG_TRANSLATOR;
if (isset($_GET["lowestPrice"])) {
	$args->lowestPrice = (int) $_GET["lowestPrice"];
}


if (isset($_GET["highestPrice"])) {
	$args->highestPrice = (int) $_GET["highestPrice"];
}

if (isset($_GET["df"])) {
	$args->df = (string) $_GET["df"];
}


if (isset($_GET["dt"])) {
	$args->dt = (string) $_GET["dt"];
}


if (isset($_GET["vyr"])) {
	$args->vyrobce = $_GET["vyr"];
}

if (isset($_GET["skupina"])) {
	$args->skupina = $_GET["skupina"];
}
if (isset($_GET["q"])) {
	$args->fulltext = $_GET["q"];
}
if (isset($_GET["cislo"])) {
	$args->cislo = $_GET["cislo"];
}



$args->thumb_width = 90;
$args->thumb_height = 90;


//print_r($args);
$DataGridProvider = new DataGridProvider("Products", $args);
$DataGridProvider->actionRegister("copy","Kopírovat");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();


$filterList = new ProductParamsFilter();
	$filter = '<form class="standard_form filter_form page-filter " method="get">';
$filter .= '<div class="filtr_name">Pořízeno:</div>';

$filter .= '<div class="filtr_values">od: '.$filterList->getElement("df")->render().' - do: '.$filterList->getElement("dt")->render().'</div>';
$filter .= '<div class="clearfix"> </div>';

$filter .= '<div class="filtr_values">'.$filterList->getElement("status")->render().'</div>';
$filter .= '<div class="clearfix"> </div>';




$filter .= '<div class="filtr_name">Prodejní cena:</div>';

//$filter .= '<div class="filtr_values">od: '.$filterList->getElement("lowestPrice")->render().'Kč - do: '.$filterList->getElement("highestPrice")->render().'Kč</div>';
$filter .= '<div class="clearfix"> </div>';

$filter .= '<div class="slider-range-box">';
$filter .= '<div class="min-price"></div>
<div class="max-price"></div>';

$filter .= '<div id="slider-range"></div>';
	$filter .= '</div>';
$filter .= '<script>';
$filter .= '$(function() {';
$filter .= '$( "#slider-range" ).slider({';
$filter .= 'range: true,';
$filter .= 'min:  '.floor($filterList->minCena).',';
$filter .= 'max: '.ceil($filterList->maxCena).',';
$filter .= 'values: [ '.floor($filterList->getElement("lowestPrice")->getValue()).', '.ceil($filterList->getElement("highestPrice")->getValue()).' ],';
$filter .= 'slide: function( event, ui ) {';
$filter .= '$( "#lowestPrice" ).val(  ui.values[ 0 ] );';
$filter .= '$( "#highestPrice" ).val( ui.values[ 1 ] );';

$filter .= '$( ".min-price" ).html(  numberFormat(ui.values[ 0 ]) + " Kč");
$( ".max-price" ).html( numberFormat(ui.values[ 1 ]) + " Kč");';

$filter .= '}';

$filter .= ',';
$filter .= 'stop: function(event, ui) {';
$filter .= '	dataGrid.params.lowestPrice = ui.values[0]; dataGrid.params.highestPrice = ui.values[1];dataGrid.loadData();';
$filter .= '}';

$filter .= '});';
$filter .= '$( "lowestPrice" ).val($( "#slider-range" ).slider( "values", 0 ));';
$filter .= '$( "highestPrice" ).val($( "#slider-range" ).slider( "values", 1 ));';

$filter .= '$( ".min-price" ).html(  numberFormat($( "#slider-range" ).slider( "values", 0 ))+ " Kč");';
$filter .= '$( ".max-price" ).html( numberFormat($( "#slider-range" ).slider( "values", 1 )) + " Kč");';

$filter .= '});';
$filter .= '</script>';


$categoryA = $filterList->getElement("vyr[]");
if ($categoryA) {

	$filter .= '<div class="filtr_name">Výrobce:</div>';
	$filter .= '<div class="filtr_values">';
	$filter .= '<ul>';


	foreach ($categoryA as $key => $val){
		$filter .= '<li>' . $val->render() . '</li>';
	}
	$filter .= '</ul>';
	$filter .= '</div>';
	$filter .= '<div class="clearfix"> </div>';

}

$categoryA = $filterList->getElement("skupina[]");
if ($categoryA) {
	$filter .= '<div class="filtr_name">Skupina:</div>';
	$filter .= '<div class="filtr_values">';
	$filter .= '<ul>';

	foreach ($categoryA as $key => $val){
		$filter .= '<li>' . $val->render() . '</li>';
	}
	$filter .= '</ul>';
	$filter .= '</div>';
	$filter .= '<div class="clearfix"> </div>';
}


$filter .= '<script>';
$filter .= '$(function() {
	$("input.vyr").click(function(){
		getVyrobci();
	});

	$("input.group").click(function(){
		getVyrobci();
	});

		$("input.date").blur(function(){
		getVyrobci();
	});

});


function getVyrobci()
{
	dataGrid.params.vyr = new Array();
	dataGrid.params.skupina = new Array();

//	var arrNumber = new Array();
	$("input.vyr:checked").each(function(){

		if ($(this).is(":checked")) {
		//	var vyrobceId2 = $(this).attr("name");
			var vyrobceId = $(this).attr("name");
			vyrobceId = vyrobceId.replace("vyr[","");
			vyrobceId= vyrobceId.replace("]","");
		//	console.log(vyrobceId);

			if (vyrobceId.length) {
				dataGrid.params.vyr.push(vyrobceId);
			}
		}

	});

	$("input.group:checked").each(function(){

		if ($(this).is(":checked")) {
	//		var vyrobceId2 = $(this).attr("name");
			var vyrobceId = $(this).attr("name");
			vyrobceId = vyrobceId.replace("skupina[","");
			vyrobceId= vyrobceId.replace("]","");
			console.log(vyrobceId);

			if (vyrobceId.length) {
				dataGrid.params.skupina.push(vyrobceId);
			}
		}

	});

	dataGrid.params.df = $("input.date_from").val();
	dataGrid.params.dt = $("input.date_to").val();


	dataGrid.loadData();
}


</script>';


$filter .= '<p class="WizardParametersAjax"><a href="'.AKT_PAGE.'" type="reset" class="button">Zrušit filtr</a> <button type="submit" class="tlac">Filtrovat</button></p>';
$filter .= '</form>';
//$filter = "";
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();
$pageButtons[] = '<a  class="btn btn-sm btn-info" href="'.  URL_HOME . 'eshop/add_product">Nový</a>';
$pageButtons[] = '<a  class="btn btn-sm btn-warning" href="'.  URL_HOME . 'eshop/import_produkty_xls">Import ceníku</a>';
?>

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>


<?php
print $filter;
?>
<?php
//print $print_result;
print getResultMessage();
//print $DataGridProvider->table();
print $DataGridProvider->ajaxtable();

 ?>



<?php
include PATH_TEMP . "admin_body_footer.php";
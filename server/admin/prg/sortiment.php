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
			$formName = "F_ProductEdit";
				$modalForm = new ProductBootstrapModalForm($formName);

				$modalForm->setBody();


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

			$formName = "F_ProductDeleteConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
			$modalForm->setBody($body);

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
		case "ProductCopy":
			$ProductVariantyController = new ProductController();

			if ($ProductVariantyController->copyAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "F_ProductCopyConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
      
      $body .= '<div class="row">';
			$body .= '<div class="col-xs-4">';
			$body .= $form->getElement("cislo")->render();
			$body .= '</div>';      
			$body .= '<div class="col-xs-4">';
			$body .= $form->getElement("copy_foto")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-4">';
			$body .= $form->getElement("copy_params")->render();
			$body .= '</div>';
      
			$body .= '<div class="col-xs-4">';
			$body .= $form->getElement("copy_varianty")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-4">';
			$body .= $form->getElement("copy_cenik")->render();
			$body .= '</div>';
            
			$body .= '</div>';
      
			$modalForm->setBody($body);

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

			$formName = "F_ProductVariantyDeleteConfirm";

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

		case "ProductVariantyEdit":
			$ProductVariantyController = new ProductVariantyController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
			$formName = "F_ProductVariantyEdit";

		//	$form = new $formName();
			$modalForm = new ProductVariantyBootstrapModalForm($formName);
      $modalForm->setBody();

		//	$modalForm->setBody($body);
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
			$formName = "F_ProductVariantyCreate";
      $modalForm = new ProductVariantyBootstrapModalForm($formName);
                             $modalForm->setBody();
		
			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
		default:
			$formName = "F_ProductAtributeEdit";
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

/*
$GHtml->setServerJs('/js/SWFUpload/swfupload/swfupload.js');
$GHtml->setServerJs('/js/SWFUpload/js/swfupload.queue.js');
$GHtml->setServerJs('/js/SWFUpload/js/fileprogress.js');
$GHtml->setServerJs('/js/SWFUpload/js/handlers.js');

*/
$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();


$filterList = new ProductParamsFilter();
	//$filter = '<a id="showFilterButton" href="javascript:showFilter();"><i class="fa fa-filter" aria-hidden="true"></i> Zobrazit filtr</a>';
	$filter = '';

	$filter .= '<form style="display:none;" class="filter_form page-filter " method="get">';
//$filter .= '<div class="filtr_name">Pořízeno:</div>';

//$filter .= '<div class="filtr_values">od: '.$filterList->getElement("df")->render().' - do: '.$filterList->getElement("dt")->render().'</div>';
//$filter .= '<div class="clearfix"> </div>';
/*	$filter .= '<div class="form-group">';
$filter .= '<span>'.$filterList->getElement("status")->render().'</span>';
	$filter .= '</div>';
                      */
$filter .= '<div class="row">';
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="row">';   
     
    $filter .= '<div class="col-sm-4">';                         
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("status2")->render().'</span>';
    $filter .= '</div>';
    $filter .= '</div>';
    
    
    $filter .= '<div class="col-sm-4">';                         
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("bazar")->render().'</span>';
    $filter .= '</div>';
    $filter .= '</div>';
    
    
    $filter .= '<div class="col-sm-4">';                         
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("neprenaset")->render().'</span>';
    $filter .= '</div>';
    $filter .= '</div>';
    
    
    $filter .= '</div>';
  $filter .= '</div>';
    
    
    
    
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("category_id")->render().'</span>';
    $filter .= '</div>';
  $filter .= '</div>';
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("dostupnost_id")->render().'</span>';
    $filter .= '</div>'; 
  $filter .= '</div>';   
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("dodavatel_id")->render().'</span>';
    $filter .= '</div>'; 
  $filter .= '</div>';  
$filter .= '</div>';  
    
$filter .= '<div class="form-group">';
  $filter .= '<div class="filtr_name">Prodejní cena:</div>';
  $filter .= '<div class="clearfix"> </div>';
  
  $filter .= '<div class="slider-range-box">';
    $filter .= '<div class="min-price"></div><div class="max-price"></div>';
    
    $filter .= '<div id="slider-range"></div>';
  $filter .= '</div>';
$filter .= '</div>';


$filter .= '<script>';
$filter .= 'loadCategoryPicker();';
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
$filter .= '	dataGridProducts.params.lowestPrice = ui.values[0]; dataGridProducts.params.highestPrice = ui.values[1];dataGridProducts.loadData();';
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

	$filter .= '<div class="form-group">';
	$filter .= '<div class="filtr_name">Výrobce:</div>';

//	$filter .= '<div class="filtr_values">';
	$filter .= '<div class="checkbox-group service-box">';


	foreach ($categoryA as $key => $val){
	//	$filter .= '<li>' . $val->render() . '</li>';
		$filter .= '<span>' . $val->render() . '</span>';
	}
	$filter .= '<div class="clearfix"> </div>';
	$filter .= '</div>';
	$filter .= '</div>';


}

$categoryA = $filterList->getElement("skupina[]");
if ($categoryA) {
	$filter .= '<div class="form-group">';
	$filter .= '<div class="filtr_name">Skupina:</div>';
/*	$filter .= '<div class="filtr_values">';
	$filter .= '<ul>';

	foreach ($categoryA as $key => $val){
		$filter .= '<li>' . $val->render() . '</li>';
	}
	$filter .= '</ul>';
	$filter .= '</div>';
	$filter .= '<div class="clearfix"> </div>';


	*/



	$filter .= '<div class="checkbox-group service-box">';
	foreach ($categoryA as $key => $val){
		$filter .= '<span>' . $val->render() . '</span>';
	}
	//<span id="sort_primary_sluzba_0"><div class="checkbox"><label for="group_id[1]_519271852"><input value="4" id="group_id[1]_519271852" name="F_ProductEdit_group_id[1]" type="checkbox"><span>Doporučujeme</span></label></div></span>


	$filter .= '<div class="clearfix"> </div>';
	$filter .= '</div>';
	$filter .= '</div>';

}









$filter .= '<script>';
$filter .= '$(function() {
	$("input.vyr").click(function(){
		getVyrobci();
	});

	$("input.group").click(function(){
		getVyrobci();
	});

	$("input[name=bazar]").click(function(){
		getVyrobci();
	});    
  
  	$("input[name=neprenaset]").click(function(){
		getVyrobci();
	});   
  
	$("input[name=status2]").change(function(){
		getVyrobci();
	});
	$("select[name=category_id]").change(function(){
		getVyrobci();
	});  
  	$("select[name=dostupnost_id]").change(function(){
		getVyrobci();
	}); 
   	$("select[name=dodavatel_id]").change(function(){
		getVyrobci();
	});  
   
  
});


function getVyrobci()
{
	dataGridProducts.params.vyr = new Array();
	dataGridProducts.params.skupina = new Array();

//	var arrNumber = new Array();
	$("input.vyr:checked").each(function(){

		if ($(this).is(":checked")) {
		//	var vyrobceId2 = $(this).attr("name");
			var vyrobceId = $(this).attr("name");
			vyrobceId = vyrobceId.replace("vyr[","");
			vyrobceId= vyrobceId.replace("]","");
		//	console.log(vyrobceId);

			if (vyrobceId.length) {
				dataGridProducts.params.vyr.push(vyrobceId);
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
				dataGridProducts.params.skupina.push(vyrobceId);
			}
		}

	});


  dataGridProducts.params.child = $("#category_id").find(":selected").val();
  dataGridProducts.params.dostupnost_id = $("#dostupnost_id").find(":selected").val();
  dataGridProducts.params.dodavatel_id = $("#dodavatel_id").find(":selected").val();
//  dataGridProducts.params.child = 1;

	dataGridProducts.params.df = $("input.date_from").val();
	dataGridProducts.params.dt = $("input.date_to").val();

	dataGridProducts.params.bazar = 0;
	if ($("input[name=bazar]").is(":checked")) {
		dataGridProducts.params.bazar = 1;
	}  
  dataGridProducts.params.neexportovat = 0;
  if ($("input[name=neprenaset]").is(":checked")) {
		dataGridProducts.params.neexportovat = 1;
	} 
   
   var myRadio = $(\'input[name="status2"]\');
   dataGridProducts.params.status = myRadio.filter(":checked").val();
   
	//	dataGridProducts.params.status = $("input[name=status2]").is(":checked").val();


	dataGridProducts.loadData();
}


</script>';


//$filter .= '<p class="WizardParametersAjax"><a href="'.AKT_PAGE.'" type="reset" class="button">Zrušit filtr</a> <button type="submit" class="tlac">Filtrovat</button></p>';
$filter .= '</form>';
//$filter = "";
include PATH_TEMP . "admin_body_header.php";

$pageButtons = array();
$pageButtons[] = '<a id="showFilterButton" href="javascript:showFilter();" class="btn btn-sm "><i class="fa fa-filter" aria-hidden="true"></i> Zobrazit filtr</a>';
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
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


			$formName = "F_ObjednavkaDeleteConfirm";

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


			$formName = "F_ObjednavkaCopyConfirm";

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


			$formName = "F_ObjednavkaStornoConfirm";

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


			$modalForm = new ObjednavkaBootrapModalFormEdit();


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
//$filter = '<form class="standard_form filter_form page-filter" method="get">';
/*
$filter .= '<div class="filtr_name">Pořízeno:</div>';

$filter .= '<div class="filtr_values">od: '.$filterList->getElement("df")->render().' - do: '.$filterList->getElement("dt")->render().'</div>';
$filter .= '<div class="clearfix"> </div>';

$filter .= ''.$filterList->getElement("code")->render().'';
$filter .= '<div class="clearfix"> </div>';

$filter .= ''.$filterList->getElement("shipping_first_name")->render().'';
$filter .= '<div class="clearfix"> </div>';

$filter .= ''.$filterList->getElement("shipping_email")->render().'';
$filter .= '<div class="clearfix"> </div>';


       */








	$filter = '<a id="showFilterButton" href="javascript:showFilter();"><i class="fa fa-filter" aria-hidden="true"></i> Zobrazit filtr</a>';

	$filter .= '<form style="display:none;" class="filter_form page-filter " method="get">';


$filter .= '<div class="row">';
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="row">';   
     
    $filter .= '<div class="col-sm-4">';                         
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("code")->render().'</span>';
    $filter .= '</div>';
    $filter .= '</div>';
    
    
    $filter .= '<div class="col-sm-4">';                         
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("df")->render().'</span>';
    $filter .= '</div>';
    $filter .= '</div>';
    
    
    $filter .= '<div class="col-sm-4">';                         
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("dt")->render().'</span>';
    $filter .= '</div>';
    $filter .= '</div>';
    
    
    $filter .= '</div>';
  $filter .= '</div>';
    
    
    
    
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("shipping_first_name")->render().'</span>';
    $filter .= '</div>';
  $filter .= '</div>';
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("shipping_email")->render().'</span>';
    $filter .= '</div>'; 
  $filter .= '</div>'; 
          /*
  $filter .= '<div class="col-sm-3">';
    $filter .= '<div class="form-group">';
    $filter .= '<span>'.$filterList->getElement("dodavatel_id")->render().'</span>';
    $filter .= '</div>'; 
  $filter .= '</div>'; 
  */ 
$filter .= '</div>';  


$filter .= '<div class="form-group">';
  $filter .= '<div class="filtr_name">Celková částka:</div>';
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
$filter .= '	dataGrid.params.lowestPrice = ui.values[0]; dataGrid.params.highestPrice = ui.values[1];dataGridOrders.loadData();';
$filter .= '}';

$filter .= '});';
$filter .= '$( "lowestPrice" ).val($( "#slider-range" ).slider( "values", 0 ));';
$filter .= '$( "highestPrice" ).val($( "#slider-range" ).slider( "values", 1 ));';

$filter .= '$( ".min-price" ).html(  numberFormat($( "#slider-range" ).slider( "values", 0 ))+ " Kč");';
$filter .= '$( ".max-price" ).html( numberFormat($( "#slider-range" ).slider( "values", 1 )) + " Kč");';

$filter .= '});';
$filter .= '</script>';






$filter .= '<script>';
$filter .= '$(function() {
	$("input.vyr").click(function(){
		getFilter();
	});

	$("input.group").click(function(){
		getFilter();
	});

	$("input[name=bazar]").click(function(){
		getFilter();
	});    
  
  	$("input[name=neprenaset]").click(function(){
		getFilter();
	});   
  
	$("input[name=df]").change(function(){
		getFilter();
	});
	$("input[name=dt]").change(function(){
		getFilter();
	});  
  	$("input[name=code]").change(function(){
		getFilter();
	}); 
  
  
  $("input[name=shipping_first_name]").change(function(){
		getFilter();
	}); 
  $("input[name=shipping_email]").change(function(){
		getFilter();
	});  
   
  
});


function getFilter()
{
	dataGridOrders.params.vyr = new Array();
	dataGridOrders.params.skupina = new Array();
                                    /*
//	var arrNumber = new Array();
	$("input.vyr:checked").each(function(){

		if ($(this).is(":checked")) {
		//	var vyrobceId2 = $(this).attr("name");
			var vyrobceId = $(this).attr("name");
			vyrobceId = vyrobceId.replace("vyr[","");
			vyrobceId= vyrobceId.replace("]","");
		//	console.log(vyrobceId);

			if (vyrobceId.length) {
				dataGridOrders.params.vyr.push(vyrobceId);
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
				dataGridOrders.params.skupina.push(vyrobceId);
			}
		}

	});  */


  dataGridOrders.params.child = $("#category_id").find(":selected").val();
  dataGridOrders.params.dostupnost_id = $("#dostupnost_id").find(":selected").val();
  dataGridOrders.params.dodavatel_id = $("#dodavatel_id").find(":selected").val();
//  dataGridOrders.params.child = 1;

	dataGridOrders.params.df = $("input.date_from").val();
	dataGridOrders.params.dt = $("input.date_to").val();
  
	dataGridOrders.params.shipping_first_name = $("input[name=shipping_first_name]").val();
	dataGridOrders.params.shipping_email = $("input[name=shipping_email]").val();
	dataGridOrders.params.bazar = 0;
	if ($("input[name=bazar]").is(":checked")) {
		dataGridOrders.params.bazar = 1;
	}  
  dataGridOrders.params.neexportovat = 0;
  if ($("input[name=neprenaset]").is(":checked")) {
		dataGridOrders.params.neexportovat = 1;
	} 
   
   var myRadio = $(\'input[name="status2"]\');
   dataGridOrders.params.status = myRadio.filter(":checked").val();
   
	//	dataGridOrders.params.status = $("input[name=status2]").is(":checked").val();


	dataGridOrders.loadData();
}


</script>';

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
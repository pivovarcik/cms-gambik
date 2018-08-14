<?php
if (isset($_GET["do"])) {

	switch ($_GET["do"]) {
		case "FakturaDelete":
			$ProductVariantyController = new FakturyController();

			if ($ProductVariantyController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "F_FakturaDeleteConfirm";

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
		case "FakturaCopy":
			$ProductVariantyController = new FakturyController();

			if ($ProductVariantyController->copyAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "F_FakturaCopyConfirm";

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

		case "FakturaStorno":
			$ProductVariantyController = new FakturyController();

			if ($ProductVariantyController->stornoAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "F_FakturaStornoConfirm";

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

		case "FakturaEdit":
			$ProductVariantyController = new FakturyController();

			if ($ProductVariantyController->saveAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$modalForm = new FakturaBootrapModalFormEdit();


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

$fakturyController = new FakturyController();
$fakturyController->stornoAction();
$fakturyController->copyAction();
$fakturyController->deleteAction();
//print_r($_POST);
$args = new FakturaListArgs();
$DataGridProvider = new DataGridProvider("Faktura",$args);
//$DataGridProvider->actionRegister("copy","Kopírovat");
//$DataGridProvider->actionRegister("storno","Stornovat");

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();


$filterList = new FakturaFilter();

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
$filter .= '	dataGrid.params.lowestPrice = ui.values[0]; dataGrid.params.highestPrice = ui.values[1];dataGrid.loadData();';
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
	dataGrid.params.vyr = new Array();
	dataGrid.params.skupina = new Array();
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

	});  */


  dataGrid.params.child = $("#category_id").find(":selected").val();
  dataGrid.params.dostupnost_id = $("#dostupnost_id").find(":selected").val();
  dataGrid.params.dodavatel_id = $("#dodavatel_id").find(":selected").val();
//  dataGrid.params.child = 1;

	dataGrid.params.df = $("input.date_from").val();
	dataGrid.params.dt = $("input.date_to").val();
  
	dataGrid.params.shipping_first_name = $("input[name=shipping_first_name]").val();
	dataGrid.params.shipping_email = $("input[name=shipping_email]").val();
	dataGrid.params.bazar = 0;
	if ($("input[name=bazar]").is(":checked")) {
		dataGrid.params.bazar = 1;
	}  
  dataGrid.params.neexportovat = 0;
  if ($("input[name=neprenaset]").is(":checked")) {
		dataGrid.params.neexportovat = 1;
	} 
   
   var myRadio = $(\'input[name="status2"]\');
   dataGrid.params.status = myRadio.filter(":checked").val();
   
	//	dataGrid.params.status = $("input[name=status2]").is(":checked").val();


	dataGrid.loadData();
}


</script>';

$filter .= '</form>';

include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();
$pageButtons[] = '<a class="btn btn-sm btn-info" href="'.  URL_HOME . 'eshop/faktura_add">Nová</a>';
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
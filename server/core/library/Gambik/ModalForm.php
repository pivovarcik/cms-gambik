<?php

class ModalForm {


	protected $formId;

	protected $containerNameId = "bs-container";



	public function __construct($formId)
	{
		$this->formId = $formId;
	}

	/*
	   * Skript pro zavolání zadávacího formuláře na klientovi
	*/
  
  // novější způsob
  public function getScript2()
  {
    $res = '<script type="text/javascript" src="/js/ModalForm.js"></script>';
		$res .= '<div id="' . $this->containerNameId . '"></div>';
		$res .= '<script>';
		$res .= '$(document).ready(function(){';
    
    
     //   $res .= 'console.log("testttt");';
    $res .= '$(".modal-form").each(function() { ';
   $res .= 'var that = $(this);';  

		$res .=   'that.GModalForm(); ';
  //  $res .= 'console.log(that);';   
		$res .= '});   ';
  
  
		$res .= '});';
		$res .= '</script>';
    return $res; 

  }
	public function getScript()
	{

		$res = '<div id="' . $this->containerNameId . '"></div>';
		$res .= '<script type="text/javascript">';
		$res .= '$(document).ready(function(){';


		//$res .= 'var blockForm' . $this->formId . '=false;';
		$res .= 'var lastAction' . $this->formId . '="";';
		$res .= 'var lastControl' . $this->formId . '="";';

		$res .= '$(".modal-form").click(function(e){';
		$res .= 'e.preventDefault();';

		$res .= 'var that = $(this);';
		$res .= 'var url = that.attr("data-url");';
    $res .= '	postdata = {};';
		$res .= 'var callback = that.attr("data-callback");';
		$res .= 'var postdataFunction = that.attr("data-postdata");';
		$res .= 'var paramsCallbackFunction = that.attr("data-callback-params");';
   //    $res .= '  console.log("postdataFunction:"+ typeof postdataFunction); ';


 		$res .= 'if (postdataFunction && typeof(postdataFunction) === "string" && postdataFunction !="") {';
    $res .= 'var s = postdataFunction+"()";  ';
    $res .= '     postdata =   eval(s);';
		$res .= '	}';
    

       
		$res .= 'loadModalForm(url, postdata, callback,"" + paramsCallbackFunction+"");';

		$res .= '});';

		$res .= 'if ($(".alert-danger").length) {';
		$res .= '$("#' . $this->formId . '").modal("show");';
		$res .= '}';





		$res .= '});';


/*

		$res .= 'function saveData(action,control){';
		$res .= 'console.log(action);';
$res .= 'console.log(control);';
		//$res .= 'var data = $("#' . $this->formId . '-form").serialize()+ "&load-action=" + action+"&control=" + control;';
		$res .= 'var data = $("#' . $this->formId . '-form").serialize();';
		$res .= 'var url = $("#' . $this->formId . '-form").attr("action");';
	//	$res .= 'data.action = action;';
	//	$res .= 'data.control = control;';
	//	$res .= 'data["control"] = control;';
		$res .= 'loadModal(data,url);';
		$res .= '}';

*/
		$res .= 'function loadModalForm(url, data, callback,paramsCallbackFunction){';
		$res .= 'console.log(data);';

	//	$res .= 'if (typeof modalFormPostdata == "undefined") {	        var modalFormPostdata = {};        };';
	//	$res .= 'var data = {};';
	//	$res .= 'loadModal(data, url,callback);';

		$res .= 'loadModalBase(data, url, callback, paramsCallbackFunction);';


		$res .= '}';

/*
		$res .= 'function loadModal(data, url, callbackFunction){';

			$res .= 'console.log(callbackFunction);';
		$res .= 'blockForm' . $this->formId . '=true;';
		$res .= '$.ajax({';
		$res .= 'type: "POST",';
	//	$res .= 'url: UrlBase + "/ajax/modalForm.php?id=",';
		$res .= 'url: url,';
		$res .= 'dataType: "json",';
		$res .= 'data: data,';
		$res .= 'success: function(r) {';


		$res .= 'if(r.status == "success") {';
	//	$res .= 'alert("Data byla uložena.");';
		$res .= '$("#' . $this->formId . '").modal("hide");';

		$res .= 'console.log(callbackFunction);';
		$res .= 'if (callbackFunction && typeof(callbackFunction) === "function") {';
		$res .= '	callbackFunction();';
		$res .= '	}';

		//	$res .= 'callbackFunction();';
		$res .= 'return;';
		$res .= '}';
		*/
		/*
		$res .= 'if(r.status == "success") {';
		$res .= 'alert("Data byla uložena.");';
		$res .= '$("#' . $this->formId . '").modal("hide");';

		$res .= 'return;';
		$res .= '}';
		*/
		/*
		$res .= 'if(r.status == "wrong") {';
	//	$res .= '$("#' . $this->formId . '").modal("hide");';
		$res .= 'alert("Data nebyla uložena!");';
		$res .= 'return;';
		$res .= '}';

		$res .= '$("#' . $this->containerNameId . '").html(r.html);';

		$res .= 'lastAction' . $this->formId . '=r.action;';
		$res .= 'lastControl' . $this->formId . '=r.control;';
		$res .= '$("#' . $this->formId . '").modal("show");';
		$res .= 'spolecnaAkcePoPrijetiOdpovedi();';
		$res .= '},';
		$res .= 'failure: function() {';
		$res .= 'spolecnaAkcePoPrijetiOdpovedi();';
		$res .= '},';
		$res .= 'error: function () {';
		$res .= 'spolecnaAkcePoPrijetiOdpovedi();';
		$res .= '}';

		$res .= '});';

		$res .= '}';
	*/
		$res .= 'function spolecnaAkcePoPrijetiOdpovedi(){';

		$res .= 'blockForm' . $this->formId . '=false;';
		$res .= '}';

		$res .= '</script>';
		return $res;
	}


}
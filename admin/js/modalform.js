
var blockFormmyModal=false;
function closeModalForm(formId)
{
	$("#"+formId).modal("hide");
}

function openModalForm(formId)
{
	$("#"+formId).modal("show");
}

function loadModalBase(data, url, callbackFunction, paramsCallbackFunction)
{
	var formId = "myModal";
	console.log(callbackFunction);
	console.log("Běží: loadModalBase");
	blockFormmyModal=true;
	$.ajax({
		type: "POST",
		url: url,
		dataType: "json",
		data: data,
		success: function(r) {

			if(r.status == "success")
			{
				closeModalForm(formId);
				//	closeModalForm("ulozeno");
				//	loadGrid("mj");
				//	console.log(callbackFunction);
				/*	if (callbackFunction && typeof(callbackFunction) === "function") {
				callbackFunction(paramsCallbackFunction);
				}*/

				console.log(callbackFunction+"("+paramsCallbackFunction+")");
				setTimeout(callbackFunction+"('"+paramsCallbackFunction+"')", 0);

				return;
			}
			blockFormmyModal=false;
			$("#bs-container").html(r.html);
			openModalForm(formId);

			$("#" + formId + "-form .datepicker").datepicker();
			// nastav submit
			console.log("nastavuji submit");
			$("#" + formId + "-form").on( "submit",function(e){
				e.preventDefault();

				if (!blockFormmyModal){

					var data = $("#" + formId + "-form").serialize();
					loadModalBase(data,url, callbackFunction, paramsCallbackFunction);

				//	var url = $("#myModal-form").attr("action");
				//	saveData(url, callbackFunction, paramsCallbackFunction);
				}
			});
		}
	});
}

function reloadPage()
{
	location.reload();
}
function loadModalBase2(data, url, callbackFunction)
{
	var formId = "myModal";
	console.log("Běží: loadModalBase2");
	blockFormmyModal=true;
	$.ajax({
		type: "POST",
		url: url,
		dataType: "json",
		data: data,
		success: function(r) {

			if(r.status == "success")
			{
				closeModalForm(formId);
				//	closeModalForm("ulozeno");
				//	loadGrid("mj");
				console.log("callbackFunction:" + callbackFunction);
				console.log("typeof:" + typeof(callbackFunction));
				//'"+paramsCallbackFunction+"'

				if (callbackFunction && typeof(callbackFunction) === "function") {
					callbackFunction();
				}

				if (callbackFunction && typeof(callbackFunction) === "string") {
					setTimeout(callbackFunction+"()", 0);
				}
				return;
			}
			blockFormmyModal=false;
			$("#bs-container").html(r.html);
			openModalForm(formId);




			// nastav submit
			console.log("nastavuji submit");
			$("#myModal-form").on( "submit",function(e){
				e.preventDefault();

				if (!blockFormmyModal){

					var url = $("#myModal-form").attr("action");
					saveData(url, callbackFunction);
				}
			});
		}
	});
}

function saveData(url, callbackFunction){
	//console.log(action);
	//console.log(control);

	var data = $("#myModal-form").serialize();
	//	var url = $("#myModa-form").attr("action");

	loadModalBase2(data,url, callbackFunction);
}
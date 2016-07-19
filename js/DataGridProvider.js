

// verze 4

var DataGridProvider=function(args){
	this.gridId = args.id;
	this.modelName = args.modelName;
	this.Wrapper = args.wrapper;
	//	this.dataLimit = 5;
	this.pageNumber = 1;
	this.orderBy = "";
	this.sort = "";
	this.search = "";
	this.isModal = false;
	this.isLoading = false;
	this.url = UrlBase + "admin/ajax/dataGrid.php";
	this.firstLoadData = true;

};

$.extend(DataGridProvider.prototype, {

	dataLoaded : false,
	dataLimit : "",
	filterDefinitionId : 0,
	params : {},
	ajax : false,
	changeFilter : false,
	ajax : false,
	filterData : {},

	/* Přeruší vzdaleny dotaz */
	zrusitQuery : function()
	{
		if(this.ajax){
			this.ajax.abort();
		}
	},

	loadData : function () {


		var o = this;
		if (o.dataLoaded) {
			return;
		}
		console.log(o.pageNumber);
		if (o.changeFilter) {
			// při změně filtru nastavuji na první stránku
			o.pageNumber = 1;
			o.changeFilter = false;
		}
		console.log(o.pageNumber);

		o.unregistredGridEvent();

		$( '<div class="datagrid-overlay"></div>' ).appendTo( "#" + this.gridId);

		$( '.datagrid-overlay' ).show();
		o.dataLoaded = true;


		//console.log(o.firstLoadData);
		var request = o.getParamsRequest(o.firstLoadData);

		console.log(o.pageNumber);
	//	console.log(request);
		createHash(request);

	//	console.log("DataGridProvider.prototype.loadData");
		var url = o.url+ "?gridId=" + o.gridId
		+ "&model=" + o.modelName
		+ o.getWrapperQuery()
		+ o.getPageLimitQuery()
		+ "&pg=" + o.getPageNumber()
		+ o.getOrderByQuery()
		+ o.getModalQuery()
		+ o.getSearchQuery()
		+ (o.getFilterQuery());

		o.ajax = $.ajax({
			type: "POST",
			url: url,
			dataType: "json",
			data : this.getParams(),


			success: function(r) {
				o.filterDefinitionId = r.fd_id;
				console.log("data nactena pro grid #" + o.gridId);
				$("#" + o.gridId).html(r.html);
				o.spolecnaAkcePoPrijetiOdpovedi();
			},
			failure: function() {
				o.spolecnaAkcePoPrijetiOdpovedi();
			},
			error: function () {
				o.spolecnaAkcePoPrijetiOdpovedi();
			}

		});
	}


	,
	spolecnaAkcePoPrijetiOdpovedi : function () {
		console.log("DataGridProvider.prototype.registerGridEvent");
		this.registerGridEvent();
		this.dataLoaded = false;
		this.firstLoadData = false;
		//	$( '<div class="datagrid-overlay"></div>' ).appendTo( "#grid-container" );
	},
	getPageLimit : function() {
		return this.dataLimit;
	},

	setParams : function(params) {
		this.params = params;
	},

	getParams : function() {
		return this.params;
	},

	setModal : function(modal) {
		this.isModal = modal;
	},
	getModal : function() {
		return this.isModal;
	},

	getModalQuery : function() {
		if (this.isModal) {
			return "&isModal";
		}
		return "";

	},

	getSearchQuery : function() {
		if (this.search != "") {
			return "&q=" + this.search;
		}
		return "";

	}
	,

	getWrapperQuery : function() {
		if (this.Wrapper) {
			return "&wrapper=" + this.Wrapper;
		}
		return "";

	},
	getPageLimitQuery : function() {
		if (this.getPageLimit() > 0) {
			return "&limit="+this.getPageLimit();
		}
		return "";

	},

	getOrderByQuery : function() {
		if (this.orderBy !="") {
			return "&order="+this.orderBy + "&sort="+this.sort;
		}
		return "";

	},

	getPageNumber : function() {
		return this.pageNumber;
	},

	getFilterDefinitionId : function() {
		return this.filterDefinitionId;
	},

	unregistredGridEvent : function(){
		console.log("unregistredGridEvent()");

	//	$("#" + this.gridId + " .date-picker").datepicker("destroy");

	//	$("#ui-datepicker-div").hide();
	},

	registerGridEvent : function (){
		var o = this;
		console.log("."+this.gridId+"-modal-form");
		$("."+this.gridId+"-modal-form").on( "click",function(e){
			e.preventDefault();
			console.log("klik");
			var that = $(this);
			var url = that.attr("data-url");
			var data = {};
			o.loadModalBase(data, url);
		});

		$("#" + this.gridId + " .LimitFilter").on( "change",function(e){
			var that = $(this);
			console.log("limit"+that.val());
			o.dataLimit = that.val();
			o.loadData();
		});


		$("#" + this.gridId + " .pglist a").on( "click",function(e){
			e.preventDefault();
			console.log("strankovani");
			var that = $(this);
			var page = that.attr("href");

			o.pageNumber = page.replace("#","");
			o.loadData();
		});


		$("#" + this.gridId + " th a").on( "click",function(e){
			e.preventDefault();

			var that = $(this);
			var page = that.attr("href");

		//	o.orderBy = page.replace("#","");

			var hashParams = parseHashParams(page);
			o.orderBy = hashParams.order;
			o.sort = hashParams.sort;
		//	o.orderBy = page.replace("#order=","");
			o.loadData();
		});


		$("#" + this.gridId + " tr").on( "dblclick",function(e){
			//	e.preventDefault();
			var editLink = $(this).find(".editLink");
			var dataUrl = $(editLink).attr("data-url");
			if ( typeof dataUrl === "undefined") {
				var url = $(editLink).attr("href");
				$(location).attr("href",url);

			} else {
				var url = $(editLink).attr("data-url");
				var data = {};
				o.loadModalBase(data, url);
			}
			return false;
		});



		$("#" + this.gridId + " .grid-settings").on( "click",function(e){
			e.preventDefault();
			console.log("nastavení");
			var that = $(this);
			var page = that.attr("href");

			var data = {};
			o.loadModalBase(data, o.url +  "?model=" + o.modelName+"&do=setting&id="+o.getFilterDefinitionId());

		});

		$("#" + this.gridId + " .grid-refresh").on( "click",function(e){
			e.preventDefault();
			console.log("refresh");
			o.loadData();

		});


		$("#" + this.gridId + " .form-search").on( "submit",function(e){
			e.preventDefault();
			//o.search = $("#" + this.gridId + " .form-search .search-text").val();
			o.search = $("#" + o.gridId + " .search-text").val();
			o.loadData();
		});




		$("#" + this.gridId + " .actionSubmit").on( "submit",function(e){
			e.preventDefault();

			//if (!blockFormmyModal){

			var url = $(this).attr("action");
			o.deleteData("?do=");
			//	}
		});




		$("#" + this.gridId + " a.lightbox").fancybox({
			transition: 'elastic',
			fixed: true,

			current: 'obrázek č. {current} z {total}',

			slideshow: false,
			slideshowSpeed: 3000,
			slideshowAuto: false
		});


		o.isLoading = false;




	},

	loadModalBase : function(data, url)
	{
		var o = this;


		if (o.isLoading){
			console.log("DataGridProvider.loadModalBase() bloknute");
			return;
		}

		var formId = "myModal";
		console.log("DataGridProvider.loadModalBase()");
		blockFormmyModal=true;
		o.isLoading = true;
		$.ajax({
			type: "POST",
			url: url,
			dataType: "json",
			data: data,
			success: function(r) {

				if(r.status == "success")
				{
					closeModalForm(formId);
					o.loadData();
					return;
				}
				blockFormmyModal=false;
				$("#bs-container").html(r.html);
				openModalForm(formId);

				$("#myModal-form .datepicker").datepicker();
				$("#myModal-form .combobox").DataPicker();
				// nastav submit
				console.log("nastavuji submit");
				$("#myModal-form").on( "submit",function(e){
					e.preventDefault();

					if (!blockFormmyModal){

						var url = $("#myModal-form").attr("action");
						o.saveData(url);
					}
				});

				setTimeout(function(){
					o.isLoading = false;
				}, 1000);


			}
		});
	},
	deleteData : function(url){
		var o = this;

		if (o.dataLoaded) {
			return;
		}
		this.dataLoaded = true;
		var data = $(".actionSubmit").serialize();
		//	var url="?model=" + o.modelName;
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",

			success: function() {
				o.spolecnaAkcePoPrijetiOdpovedi();
				o.loadData();

			},
			failure: function() {
				o.spolecnaAkcePoPrijetiOdpovedi();
			},
			error: function () {
				o.spolecnaAkcePoPrijetiOdpovedi();
			}

		});
	},

	modalFormCreate : function(urlParam)
	{
		var o = this;
		console.log(urlParam);
		var url = "?do=create";
		if (typeof urlParam !== "undefined") {
			url = urlParam;
		}

		var data = {
		};
		// $("#myModal-form").serialize();
		o.loadModalBase(data,url);
	},
	saveData : function(url){
		var o = this;
		var data = $("#myModal-form").serialize();
		o.loadModalBase(data,url);
	},

	/**
	* Vrací objekt ze kterého sestavý HASH, při loadu se ovšem nejprve z Hash zinicializují atributy DG
	*/
	getParamsRequest : function(loadPage)
	{

		var o = this;
		params = {};
		params.page = o.pageNumber;
		params.order = o.orderBy;
		params.order = params.order.replace("order=","");
		params.sort = o.sort;
		params.q = o.search;
		params.limit = o.dataLimit;

	//	console.log(params);
		// slíznu parametry z url;
		if (loadPage) {
			/* Pokud se poprvé načítám, nejsou ještě atributy DG  */
			jQuery.each(params, function(key, value) {
				var hashValue = getQueryVar(key);
				if (hashValue !="") {
					if (params[key] instanceof Array && hashValue > 0) {
						if (hashValue > 0) {
							if (checkValueArray(params[key],hashValue)) {
								params[key].push(hashValue);
							}
						}
					} else {
						params[key] = hashValue;
					}

				}
			});

			// skenuji, zda v # existují filtry
			jQuery.each(getHashParams(), function(key, value) {
				if (key.substring(0,2) == "f[") {
					o.setFilter(key, value);
				}
			});
		//	console.log(params);
			o.pageNumber = params.page;
			o.orderBy = params.order;
			o.sort = params.sort;
			o.setSearch(params.q);
		//	o.setLimit(params.limit);
			o.dataLimit = params.limit;
			o.init();
		}

		jQuery.each(this.filterData, function(key, value) {
			params["f["+key+"]"] = value;
		});


		// aktualizace atributu na zakladě url
		return params;
	},


	/*
	* Vrací řetězec sestavený z objektu filterData pro request na server
	*/
	getFilterQuery : function(){

		var obsahujeHodnotu = false;
		if (this.filterData.length == 0) {
			return "";
		}
		var query = "&filter=";
		jQuery.each(this.filterData, function(key, value) {


			if (value != "") {
				obsahujeHodnotu = true;
				value = value.replace('&', '%26');
				//	value = encodeURI(value);
				query += "" + key + ";" + value + ";";
				if (value.indexOf(";") == -1) {
					// Pridam ;
					query += ";";
				}
			}

		});

		if (!obsahujeHodnotu) {
			return "";
		}
		return query;
	},
	setSearch : function(search){
		// valu prijde zakodovane, musim dekodovat
		search = decodeURIComponent(search);
		if (this.search != search) {
			console.log("o.setSearch:" + search);
			this.search = search;
			//console.log("o.search:" + decodeURIComponent(search));
			setQueryVar("q", this.search);
			this.changeFilter = true;
		}
	},
	setLimit : function(limit)
	{
		limit = limit*1;
		if (this.dataLimit != limit) {
			console.log("o.setLimit:" + limit);
			this.dataLimit = limit;
			this.changeFilter = true;
			setQueryVar("limit", this.dataLimit);
		}
	},

	init : function()
	{
		var o = this;
/*
		$("#textbox_hledej").val(o.search);
		// fulltextové vyhledávání
		$(".page-filter").submit( function(e){
			e.preventDefault();
			var searchA =  $( this ).serialize().split("=");
			o.setSearch(searchA[1]);

			o.loadData();
		//	console.log( $( this ).serialize() );
		});
*/
	}
});

function createHash(params)
{
	var newhash = "";
	jQuery.each(params, function(key, value) {

		if (typeof value !== "undefined" && value != "") {

			console.log("setQueryVar:" + value);
//			value = encodeURIComponent(value);


	//		value = value.replace("%3B", ";");
			//	console.log("setQueryVar:" + value);

			newhash += key + "=" + value + "&";
		}

	});

	newhash = newhash.substr(0, newhash.lastIndexOf("&"));

	console.log(newhash);
	window.location.hash = newhash;
}


function getQueryVar(varName) {


	var hashParams = getHashParams();
	if (hashParams[varName]) {

		return hashParams[varName];
	} else {
		return "";
	}

	var queryStr = unescape(window.location.hash.substring(1));
	var regex = new RegExp(varName + '=([a-zA-Z0-9-,]*)');
	var val = queryStr.match(regex);
	if (val !== null) {
		return val[1];
	} else {
		return "";
	}
}

function setQueryVar(varName, value) {

	var hashParams = getHashParams();
	hashParams[varName] = value;
	console.log(hashParams);
	return	createHash(hashParams);
}


function getHashParams() {
	return parseHashParams(window.location.hash);
}

function parseHashParams(hashString) {

	var hashParams = {};
	var e,
	a = /\+/g,  // Regex for replacing addition symbol with a space
	r = /([^&=]+)=?([^&]*)/g,
	//	d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
	d = function (s) { return (s.replace(a, " ")); },
	q = hashString.substring(1);

	while (e = r.exec(q))
	hashParams[d(e[1])] = d(e[2]);

	return hashParams;
}

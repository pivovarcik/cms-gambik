function initAutocompletes() {
	$('input.combobox').each(function() {



		if ($(this).hasClass('hasAutocomplete')) {
			return;
		}
		$(this).addClass('hasAutocomplete');





		$(this).DataPicker({

			addButton: false ,
		});

		// zaregistrování události na klik .combo_select_button
		var that = $(this);
		$(this).siblings(".combo_select_button").click(function(){
			$(that).trigger("focus");
		});
	});
}

//[PV] Číselník
	var URL_AUTOCOMPLETE = "/admin/ajax/picker.php";

var townCache = {};

jQuery.fn.DataPicker = function(options) {

	jQuery(this).autocomplete({
		source: function(request, response) {
			var element = this.element;
			var term = request.term;

			request.model = $(element).siblings(".item_id").attr("data-model");
			request.column = $(element).siblings(".item_id").attr("data-col");
			request.label = $(element).siblings(".item_id").attr("data-label");

			lastXhr = $.getJSON(URL_AUTOCOMPLETE + "?",
			request,
			function (data, status, xhr) {

				if ($(element).attr('hasFocus') == undefined) {
					//alert("Jedu z Chache");
					response(data.rows);
				}
			}
			);
		},
		select: function(event, ui) {
			var item = ui.item;
			$(this).siblings('.item_id').val(item.id);
			$(this).attr('autocompleted', item.value);
		},

		blur : function (event, ui) {
				console.log("ven2");
		},
		focus: function (event, ui) {
			$(this).attr('hasFocus', true);
		},
		search: function (event, ui) {
			$(this).removeAttr('hasFocus');
		},
		delay: 500,
		minLength: browserMsie()? 1 : 0
	}).data("uiAutocomplete")._renderItem = function (ul, item)
	{
		return $("<li></li>")
		.data("item.autocomplete", item)
		.append($("<a></a>").html(item.value))
		.appendTo(ul);
	};

	jQuery(this).focus(function() {
		if (!browserMsie()) {
			jQuery(this).autocomplete("search");
		}
	});
	jQuery(this).autocomplete("option", options);

	/*
	$(this).blur(function() {
			console.log("ven");
		console.log(this.element);
		var that = this;
		if ($(this).val() != $(that).attr('autocompleted'))
		{
			console.log($(this).val() + " <> " + $(that).attr('autocompleted'));
			$(this).val($(that).attr('autocompleted'));
		}
	});

	*/
		// Při změně value
		$(this).change(function() {
			console.log("zmena");
			var that = this;
			//console.log("change" + $(this).val());
			//console.log("change" + $(this).attr('autocompleted'));
			if ($(this).val() && $(this).attr('autocompleted') != $(this).val())
			{
			$.getJSON(URL_AUTOCOMPLETE + "?", {
			term: $(this).val(),



							model : $(that).siblings(".item_id").attr("data-model"),
				column : $(that).siblings(".item_id").attr("data-col"),
				label : $(that).siblings(".item_id").attr("data-label")

			},
			function (data, status, xhr) {

			if (data.hasresults  && $(that).attr('autocompleted') != $(that).val())
			{
			var item = data.rows[0];
			$(that).attr('autocompleted', item.value);
			$(that).val(item.value);
			$(that).siblings('.item_id').val(item.id);
			//$( "#HlavniFormular" ).valid();
			//$(this).siblings('.item_id').valid();
			}
			});
			} else if ($(this).val() == "") {
			$(that).removeAttr('autocompleted');
			$(that).val("");
			$(that).siblings('.item_id').val("");
			//$( "#HlavniFormular" ).valid();
			//	$(this).siblings('.item_id').valid();
			}
		});

};

function browserMsie()
{
	return
	(navigator.userAgent.toLowerCase().indexOf('msie 6') != -1) && (navigator.userAgent.toLowerCase().indexOf('msie 7') == -1);
}

function zjistiValue(that,selector)
{
	return $(that).siblings(selector).val();
}

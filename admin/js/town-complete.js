	var TOWN_AUTOCOMPLETE = "/admin/ajax/town-search.php";
	var townCache = {};

jQuery.fn.townAutocomplete = function(options) {

	jQuery(this).autocomplete({
        source: function(request, response) {
			 var element = this.element;
			 var term = request.term;
			 // prohledám Cache
             if (term in townCache) {
                 response(townCache[term]);
                 return;
             }

             lastXhr = $.getJSON(TOWN_AUTOCOMPLETE, request, function(data, status, xhr) {
            	 if (options.addButton) {
            		// data.push({ id: '+', label: '<span class="new">+ přidat nové město</span>', value: '' });
            	 }

                 townCache[term] = data;

                 //alert("Nacteni dat:" + townCache[term]);
                 if ($(element).attr('hasFocus') == undefined) {
                 //alert("Jedu z Chache");
                	 response(data);
                 }

             });
        },
        focus: function (event, ui) {
        	 $(this).attr('hasFocus', true);
        },
        search: function (event, ui) {
        	 $(this).removeAttr('hasFocus');
        },
        delay: 100,
        minLength: browserMsie()? 1 : 0
		//$.browser.msie? 1 : 0
	}).data("uiAutocomplete")._renderItem = function (ul, item)
    {
		 return $("<li></li>")
              .data("item.autocomplete", item)
              .append($("<a></a>").html(item.label))
              .appendTo(ul);
    };

	jQuery(this).focus(function() {
		if (!browserMsie()) {
			jQuery(this).autocomplete("search");
		}
	});
	jQuery(this).autocomplete("option", options);
};

function browserMsie()
{
	return
	(navigator.userAgent.toLowerCase().indexOf('msie 6') != -1) && (navigator.userAgent.toLowerCase().indexOf('msie 7') == -1);
}
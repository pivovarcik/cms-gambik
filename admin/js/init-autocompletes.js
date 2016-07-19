    /**
     *
     * @access public
     * @return void
     **/
function clearPoints(){

	// TODO dočasné řešení
	return false;
	if ($("#start_address").val() == '') {
		$("input[name='start_latitude']").val("");
		$("input[name='start_longitude']").val("");
	}

	if ($("#end_address").val() == '') {
		$("input[name='end_latitude']").val("");
		$("input[name='end_longitude']").val("");
	}


	if ($("#waypoints").val() == '') {
		$("input[name='waypoint_latitude']").val("");
		$("input[name='waypoint_longitude']").val("");
	}
}

function initAutocompletes() {
	clearPoints();
	$('input.waypoint').each(function() {
		if ($(this).hasClass('hasAutocomplete')) {
			return;
		}
		$(this).addClass('hasAutocomplete');
		$(this).townAutocomplete({
			select: function(event, ui) {
				var item = ui.item;


				$(this).parent().parent().siblings('.mesto_id').val(item.id);
				$(this).parent().parent().siblings('.latitude').val(item.latitude);
				$(this).parent().parent().siblings('.longitude').val(item.longitude);

				$(this).attr('autocompleted', item.value);

				clearPoints();

			}
			//addButton: false
		});

		$(this).change(function() {
			if ($(this).val() && $(this).attr('autocompleted') != $(this).val()) {
				var that = this;
				$.getJSON(TOWN_AUTOCOMPLETE, { term: $(this).val() }, function(data, status, xhr) {


					if (data.length && $(that).attr('autocompleted') != $(that).val()) {
						var item = data[0];

						$(that).attr('autocompleted', item.value);
						$(that).val(item.value);

						//alert("změna2");


						$(that).parent().parent().siblings('.mesto_id').val(item.id);
						$(that).parent().parent().siblings('.latitude').val(item.latitude);
						$(that).parent().parent().siblings('.longitude').val(item.longitude);

						clearPoints();
						// prepocita trasu

					}
				});
			} else {
				var that = this;
				//alert($(that).val().length);
				if ($(that).val().length== 0) {
					$(that).parent().parent().siblings('.mesto_id').val("");
					$(that).parent().parent().siblings('.latitude').val("");
					$(that).parent().parent().siblings('.longitude').val("");
				}

			}
		});
	});
}

$(document).ready(function() {
	initAutocompletes();
});
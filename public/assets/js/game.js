;(function($) {

	var coords = [];
	var letters = {}

	function update_fields() {
		$('#coords').val(coords.join(','));
		var str = "";
		for (coord in coords) {
			str += " " + letters[coords[coord]];
		}
		$('#word').text(str);
	}

	$('td').on('click', function(el) {
		var td = $(el.target);
		var coord = td.attr('data-coord');
		var coord_index = $.inArray(coord, coords); // IE < 9 compliant
		if (coord_index != -1) {
			// letter already chosen
			td.removeClass('disabled');
			coords.splice(coord_index, 1);
		} else {
			// letter not chosen yet - append to end
			coords.push(coord);
			td.addClass('disabled');
			var letter = td.text();
			letters[coord] = letter;
		}
		update_fields();
	});
})(jQuery);
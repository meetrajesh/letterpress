;(function($) {

	var all_coords = {};
	var all_letters = {};

	function update_fields(gid) {
		var coords = all_coords[gid] || [];
		var letters = all_letters[gid] || {};

		$('#coords_' + gid).val(coords.join(','));
		var str = "";
		for (coord in coords) {
			str += " " + letters[coords[coord]];
		}
		$('#word_' + gid).text(str);
	}

	$('div.enabled td').on('click', function(el) {
		var td = $(this);
		var gid = td.parents('div["game-id"]').attr('game-id');

		var coords = all_coords[gid] || [];
		var letters = all_letters[gid] || {};

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

		all_coords[gid] = coords;
		all_letters[gid] = letters;

		update_fields(gid);
	});
})(jQuery);
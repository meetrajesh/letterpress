;(function($) {

	var all_coords = {};
	var all_letters = {};
	var my_score = {};
	var their_score = {};

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

	// initialize scores
	$('div.game_div').each(function(i, div) {
		var gid = parseInt($(div).attr('game-id'));
		my_score[gid] = parseInt($(div).attr('my-score'));
		their_score[gid] = parseInt($(div).attr('their-score'));
	});

	$('div.enabled td').on('click', function(el) {
		var td = $(this);
		var gid = parseInt(td.parents('div.game_div').attr('game-id'));

		var coords = all_coords[gid] || [];
		var letters = all_letters[gid] || {};

		var coord = td.attr('data-coord');
		var coord_index = $.inArray(coord, coords); // IE < 9 compliant
		if (coord_index != -1) {
			// letter already chosen
			td.removeClass('disabled');
			coords.splice(coord_index, 1);
			update_scores(gid, td, -1);
		} else {
			// letter not chosen yet - append to end
			coords.push(coord);
			td.addClass('disabled');
			var letter = td.text();
			letters[coord] = letter;
			update_scores(gid, td, 1);
		}

		all_coords[gid] = coords;
		all_letters[gid] = letters;

		update_fields(gid);
	});

	function update_scores(gid, td, direction) {
		if ($('#scores')) {
			my_score[gid] += direction * parseInt(td.attr('delta-me'));
			their_score[gid] += direction * parseInt(td.attr('delta-them'));
		}

		var html = "Score: ";

		// update my score
		str = "You (" + my_score[gid] + ")";
		html += (my_score[gid] > their_score[gid]) ? ("<strong>" + str + "</strong>") : str;
		html += ", ";

		// update their score
		str = "Them (" + their_score[gid] + ")";
		html += (my_score[gid] < their_score[gid]) ? ("<strong>" + str + "</strong>") : str;

		td.parents('div.game_div').siblings('p[name="score"]').html(html);
	}

	// delete warning
	$('a.warning').click(function() {
		return confirm('Are you sure?');
	});

})(jQuery);
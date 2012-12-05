;(function($) {
	$('td').on('click', function(el) {
		var td = $(el.target);
		var letter = td.text();
		var old_val = $('#letters').val();
		$('#letters').val(old_val + " " + letter);
		$('#coords').val(td.attr('data-coord'));
	});
})(jQuery);
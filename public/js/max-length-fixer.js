$(function() {
	let refresh = () => {
		$('input[maxlength]').off('input').on('input', function(e) {
			if ($(this).val().length > $(this).attr('maxlength')) {
				$(this).val($(this).val().slice(0, $(this).attr('maxlength')));
			}
		});
	}

	window['max-length-fixer'] = {refresh};

	window['max-length-fixer'].refresh();
});
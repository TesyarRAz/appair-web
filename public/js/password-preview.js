$(function() {
	$('[data-toggle=password-preview]').each(function() {
		let source = $(this).children('input[data-source]');
		let target = $(this).children('[data-target]');


		window.b = target;

		target.on('click', function(event) {
			event.preventDefault();

			if(source.attr("type") == "text") {
				source.attr('type', 'password');

				target.find('i').addClass( "fa-eye-slash" );
				target.find('i').removeClass( "fa-eye" );
			} else if(source.attr("type") == "password") {
				source.attr('type', 'text');

				target.find('i').removeClass( "fa-eye-slash" );
				target.find('i').addClass( "fa-eye" );
			}
		});
	});
});
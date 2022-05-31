$(document).ready(function() {
	$('[data-toggle=image-preview]').each(function() {
		let source = $(this).children('input[data-source]');
		let target = $(this).children('img[data-target]');

		target.on('click', () => source.click());

		source.on('change', (e) => {
			let reader = new FileReader();

			reader.onload = e => target.attr('src', e.target.result);
			
			reader.readAsDataURL(e.target.files[0]);
		});
	});
});
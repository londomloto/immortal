
$(document).ready(function(){

	$('#form-login').submit(function(e){
			
		var data = $(this).serialize();

		$('body').mask({transparent: true});

		$.ajax({
			url: $(this).attr('action'),
			type: 'post',
			dataType: 'json',
			data: data
		})
		.done(function(res){
			if ( ! res.success) {
				$('#modal-alert').find('.modal-body > p').html(res.message);
				$('#modal-alert').modal();
			} else {
				location.href = baseUrl();
			}
		})
		.always(function(){
			$('body').unmask();
		})
		e.preventDefault();
	});

});
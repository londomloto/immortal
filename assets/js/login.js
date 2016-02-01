
$(document).ready(function(){

	$('#form-login').submit(function(e){
			
		var email = $('[name=email]').val(),
			password = $('[name=password]').val();

		$('body').mask({transparent: true});

		$.ajax({
			url: $(this).attr('action'),
			type: 'post',
			dataType: 'json',
			data: {
				email: email,
				password: password
			}
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
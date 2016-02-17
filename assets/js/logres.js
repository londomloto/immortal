//$(document).ready(function(){

    function resetForm() {
        $('input.form-control', $('#modal-logpel')).val('').removeAttr('disabled', false);
    }

    function showModal() {
        resetForm();
        $('#modal-logpel').modal('show');    
    }

    function hideModal() {
        $('#modal-logpel').modal('hide');
    }

    function showAlert(message) {
        $('#modal-alert').find('.modal-body > p').html(message);
        $('#modal-alert').modal('show');
    }

    // tampilkan login saat alert ditutup
    $('#modal-alert').on('hidden.bs.modal', function(e){
        showModal();
    });
    
    //showModal();

    $('#form-logpel').submit(function(e){
        
        e.preventDefault();

        hideModal();

        var data = $(this).serialize(),
            redir = getParam('ref') || 'pelanggan/profile';

        $('body').mask({transparent: true});

        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: data
        })
        .done(function(res){
            if ( ! res.success) {
                showAlert(res.message);
            } else {
                location.href = siteUrl(redir);
            }
        })
        .always(function(){
            $('body').unmask();
        });

    });


//});
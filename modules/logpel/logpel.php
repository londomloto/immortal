<?php 
    if (has_session('pelanggan')) {
        redirect('pelanggan/profile');
    }
?>
<!-- Modal Login -->
<div class="modal modal-info fade" id="modal-logpel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:450px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>				
            <div class="modal-body">
                <form id="form-logpel" method="post" action="<?php echo site_url('logpel/validate'); ?>">
                    <?php csrf_inject(); ?>
                    <div class="form-group">
                        <label class="sr-only" for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" required="" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" required="" placeholder="Password">
                    </div>
                    <div class="form-group clearfix">
                        <div class="checkbox-custom checkbox-inline pull-left">
                            <input type="checkbox" id="inputCheckbox" name="checkbox">
                            <label for="inputCheckbox">Ingat saya</label>
                        </div>
                        <a class="pull-right" href="<?php echo site_url('lupa'); ?>">Lupa password ?</a><br>
                        <a class="pull-right" href="<?php echo site_url('aktivasi'); ?>">Belum menerima aktivasi</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end of login -->

<!-- modal -->
<div class="modal modal-info fade modal-fade-in-scale-up" id="modal-alert" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Login gagal</h4>
            </div>
            <div class="modal-body">
                <p style="color: #222"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info margin-0" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- end of modal -->

<script>


$(document).ready(function(){

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
    
    showModal();

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


});

</script>
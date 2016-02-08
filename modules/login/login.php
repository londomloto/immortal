<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
    <div class="page-content vertical-align-middle">
        <div class="brand">
            <img class="brand-img" src="<?php echo asset_url('img/logo-small.png'); ?>" alt="...">
            <h2 class="brand-text">Immortal</h2>
        </div>
        <p>Sign into your pages account</p>
        <form id="form-login" method="post" action="<?php echo site_url('login/validate'); ?>">
            <?php echo csrf_inject(); ?>
            <div class="form-group">
                <label class="sr-only" for="inputEmail">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label class="sr-only" for="inputPassword">Password</label>
                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
            </div>
            <div class="form-group clearfix">
                <div class="checkbox-custom checkbox-inline pull-left">
                    <input type="checkbox" id="inputCheckbox" name="checkbox">
                    <label for="inputCheckbox">Remember me</label>
                </div>
                <a class="pull-right" href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
        </form>
        <p>Still no account? Please go to <a href="#">Register</a></p>

    </div>
</div>

<!-- modal -->
<div class="modal modal-danger fade modal-fade-in-scale-up" id="modal-alert" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Login Error!</h4>
            </div>
            <div class="modal-body">
                <p style="color: #222"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end of modal -->
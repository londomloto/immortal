<div class="page-error text-center">
    <header>
        <h1 class="animation-slide-top"><?php echo $error_code; ?></h1>
        <p><?php echo $error_name; ?></p>
    </header>
    <p class="error-advise"><?php echo strtoupper($error_message); ?></p>
    <a href="<?php echo base_url(); ?>" data-push="1" class="btn btn-primary btn-round">GO TO HOME PAGE</a>
</div>
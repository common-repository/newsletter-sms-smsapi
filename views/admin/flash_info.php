<?php if ($successMessage = smsapi_get_flash_success()): ?>
    <div class="alert alert-success">
        <?php echo esc_html($successMessage); ?>
    </div>
<?php endif; ?>

<?php if ($errorMessage = smsapi_get_flash_error()): ?>
    <div class="alert alert-danger">
        <?php echo esc_html($errorMessage); ?>
    </div>
<?php endif; ?>

<?php if ($warningMessage = smsapi_get_flash_warning()): ?>
    <div class="alert alert-warning">
        <?php echo esc_html($warningMessage); ?>
    </div>
<?php endif; ?>
<div class="wrap">
    <?php include(dirname(__FILE__) . '/tabs.php'); ?>
    <form action="<?php echo admin_url('admin.php?page=smsapi-settings'); ?>" name="general-settings-form"
          id="general-settings-form" method="POST">
        <table class="form-table">
            <tr>
                <th><?php _e("API token", 'newsletter-sms-smsapi'); ?>:</th>
                <td>
                    <input type="text" class="regular-text" name="api_token" id="api_token" autocomplete="off"
                           maxlength="50"
                           value="<?php echo esc_attr(smsapi_array_safe_get($config, 'api_token', '')); ?>"/>

                    <p class="description"><?php _e('Enter token information', 'newsletter-sms-smsapi'); ?></p>

                    <?php if (smsapi_array_safe_get($errors, 'api_token')): ?>
                        <span class="text-danger"><?php echo esc_attr(smsapi_array_safe_get($errors, 'api_token')); ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="" id="settings-form-submit" class="btn btn-primary"
                           value="<?php _e('Save', 'newsletter-sms-smsapi'); ?>">
                </td>
            </tr>
        </table>
    </form>
</div>
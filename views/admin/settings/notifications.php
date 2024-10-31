<div class="wrap">
    <?php include(dirname(__FILE__) . '/tabs.php'); ?>

    <form name="notifications-settings-form" id="notifications-settings-form" method="POST">
        <table class="form-table">
            <tr>
                <th><?php _e("SMS notifications", 'newsletter-sms-smsapi'); ?>:</th>
                <td>
                    <input type="checkbox" name="subscription_notification" id="subscription-notification"
                        <?php echo (bool) smsapi_array_safe_get($config, 'subscription_notification') ? 'checked="checked"' : ''; ?>/>

                    <label for="subscription-notification"><?php _e('Subscription notification', 'newsletter-sms-smsapi'); ?></label>
                    <p class="description"><?php _e('Notification sent when user submits subscription form.', 'newsletter-sms-smsapi'); ?></p>

                    <br/>

                    <div>
                        <textarea name="subscription_notification_content" id="subscription-notification-content">
                            <?php echo esc_textarea(smsapi_array_safe_get($config, 'subscription_notification_content', '')); ?>
                        </textarea>

                        <p class="description"><?php _e('Message content', 'newsletter-sms-smsapi'); ?></p>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="" id="settings-form-submit" class="btn btn-primary" value="<?php _e('Save', 'newsletter-sms-smsapi'); ?>">
                </td>
            </tr>
        </table>
    </form>
</div>
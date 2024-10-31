<div class="wrap">

    <?php include(dirname(__FILE__) . '/../flash_info.php'); ?>

    <form name="send-sms-form" id="send-sms-form" method="POST">
        <table class="form-table">
            <tr>
                <th><?php _e("Sendername", 'newsletter-sms-smsapi'); ?>:</th>

                <td>
                    <select name="sendername" id="sendername">
                        <?php if(!empty($senderNames)): ?>
                            <?php foreach($senderNames as $sender): ?>
                                <option value="<?php echo esc_attr($sender); ?>" <?php echo ($defaultSendername == $sender) ? 'selected' : ''; ?>>
                                    <?php echo esc_attr($sender); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <?php if (smsapi_array_safe_get($errors, 'sendername')): ?>
                        <div class="text-danger"><?php echo esc_attr(smsapi_array_safe_get($errors, 'sendername')); ?></div>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th><?php _e("Send to", "newsletter-sms-smsapi"); ?>:</th>

                <td>
                    <select name="recipients_type" id="recipients-type-select">
                        <option value="all"><?php _e('All', 'newsletter-sms-smsapi'); ?></option>
                        <option value="specified" <?php echo isset($recipients) ? 'selected' : ''; ?>><?php _e('Specified', 'newsletter-sms-smsapi'); ?></option>
                    </select>

                    <?php if (smsapi_array_safe_get($errors, 'recipients_type')): ?>
                        <div class="text-danger"><?php echo esc_attr(smsapi_array_safe_get($errors, 'recipients_type')); ?></div>
                    <?php endif; ?>

                    <br />

                    <div id="recipients-specified" class="<?php echo empty($recipients) ? ' hidden' : '' ?>">
                        <textarea type="text" class="regular-text" name="recipients"><?php echo !empty($recipients) ? $recipients : ''; ?></textarea>
                        <p class="description"><?php _e('Numbers separated by comma.', 'newsletter-sms-smsapi'); ?></p>
                    </div>
                </td>
            </tr>

            <tr>
                <th><?php _e("Message", "newsletter-sms-smsapi"); ?>:</th>

                <td>
                    <textarea name="message" id="message"></textarea>

                    <?php if (smsapi_array_safe_get($errors, 'message')): ?>
                        <div class="text-danger"><?php echo esc_attr(smsapi_array_safe_get($errors, 'message')); ?></div>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th>
                    <?php _e('Normalize message content', 'newsletter-sms-smsapi'); ?>
                </th>

                <td>
                    <input type="checkbox" name="normalize" value="1" id="normalize">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="" id="settings-form-submit" class="btn btn-primary" value="<?php _e('Send', 'newsletter-sms-smsapi'); ?>">
                </td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#recipients-type-select").on('change', function() {
            if ($(this).val() == 'specified') {
                $("#recipients-specified").show();
            } else {
                $("#recipients-specified").hide();
            }
        }).trigger('change');
    });
</script>
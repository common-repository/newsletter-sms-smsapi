<form id="smsapi-unsubscribe-form" class="smsapi-form smsapi-form-hidden">
    <div>
        <label for="smsapi-input-phonenumber"><?php _e('Phone number', 'newsletter-sms-smsapi'); ?>:</label>
        <input class="smsapi-input" type="text" name="phonenumber" id="smsapi-input-phonenumber" />
        <span class="smsapi-input-error"></span>
    </div>

    <div>
        <input type="radio" name="form_action" id="smsapi_input_subscribe" value="subscribe"/>
        <label for="smsapi-input-subscribe"><?php _e('Subscribe', 'newsletter-sms-smsapi'); ?></label>

        <input type="radio" name="form_action" id="smsapi-input-unsubscribe" value="unsubscribe" checked="checked"/>
        <label for="smsapi-input-unsubscribe"><?php _e('Unsubscribe', 'newsletter-sms-smsapi'); ?></label>
    </div>

    <div class="smsapi-state-unsubscribe">
        <button class="smsapi-submit"><?php _e('Unsubscribe', 'newsletter-sms-smsapi'); ?></button>
        <span class="smsapi-form-loading"></span>
    </div>
</form>
<form id="smsapi-subscription-activation-form" class="smsapi-form smsapi-form-hidden">
    <div>
        <label for="smsapi-input-security-code"><?php _e('Code from SMS', 'newsletter-sms-smsapi'); ?>:</label>
        <input class="smsapi-input" type="text" name="security_code" id="smsapi-input-security-code"/>
        <span class="smsapi-input-error"></span>
    </div>

    <div>
        <button class="smsapi-submit"><?php _e('Send', 'newsletter-sms-smsapi'); ?></button>
        <span class="smsapi-form-loading"></span>
    </div>
</form>
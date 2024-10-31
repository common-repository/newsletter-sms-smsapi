<form id="smsapi-subscribe-form" class="smsapi-form">
    <div>
        <label for="smsapi-input-phonenumber"><?php _e('Phone number', 'newsletter-sms-smsapi'); ?>:</label>
        <input class="smsapi-input" type="text" name="phonenumber" id="smsapi-input-phonenumber" />
        <span class="smsapi-input-error"></span>
    </div>

    <?php if(smsapi_array_safe_get($options, 'save_contact_firstname')): ?>
        <div>
            <label for="smsapi-input-firstname"><?php _e('First name', 'newsletter-sms-smsapi'); ?>:</label>
            <input class="smsapi-input" type="text" name="firstname" id="smsapi-input-firstname" />
            <span class="smsapi-input-error"></span>
        </div>
    <?php endif; ?>

    <?php if(smsapi_array_safe_get($options, 'save_contact_lastname')): ?>
        <div>
            <label for="smsapi-input-lastname"><?php _e('Last name', 'newsletter-sms-smsapi'); ?>:</label>
            <input class="smsapi-input" type="text" name="lastname" id="smsapi-input-lastname" />
            <span class="smsapi-input-error"></span>
        </div>
    <?php endif; ?>

    <?php if(smsapi_array_safe_get($options, 'save_contact_email')): ?>
        <div>
            <label for="smsapi-input-email"><?php _e('Email', 'newsletter-sms-smsapi'); ?>:</label>
            <input class="smsapi-input" type="text" name="email" id="smsapi-input-email" />
            <span class="smsapi-input-error"></span>
        </div>
    <?php endif; ?>

    <?php if(smsapi_array_safe_get($options, 'save_contact_city')): ?>
        <div>
            <label for="smsapi-input-city"><?php _e('City', 'newsletter-sms-smsapi'); ?>:</label>
            <input class="smsapi-input" type="text" name="city" id="smsapi-input-city" />
            <span class="smsapi-input-error"></span>
        </div>
    <?php endif; ?>

    <?php if(smsapi_array_safe_get($options, 'save_contact_birthdate')): ?>
        <div>
            <label for="smsapi-input-birthdate"><?php _e('Birth date', 'newsletter-sms-smsapi'); ?>:</label>
            <input class="smsapi-input" type="text" name="birthdate" id="smsapi-input-birthdate" />
            <span class="smsapi-input-error"></span>

            <p class="help-text"><?php _e('Date in year-month-day format, ex: 1971-01-01', 'newsletter-sms-smsapi'); ?></p>
        </div>
    <?php endif; ?>

    <div>
        <input type="radio" name="form_action" id="smsapi_input_subscribe" value="subscribe" checked="checked"/>
        <label for="smsapi-input-subscribe"><?php _e('Subscribe', 'newsletter-sms-smsapi'); ?></label>

        <input type="radio" name="form_action" id="smsapi-input-unsubscribe" value="unsubscribe"/>
        <label for="smsapi-input-unsubscribe"><?php _e('Unsubscribe', 'newsletter-sms-smsapi'); ?></label>
    </div>

    <div class="smsapi-state-subscribe">
        <button class="smsapi-submit"><?php _e('Subscribe', 'newsletter-sms-smsapi'); ?></button>
        <span class="smsapi-form-loading"></span>
    </div>
</form>
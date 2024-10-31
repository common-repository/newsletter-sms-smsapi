<div class="wrap">
    <?php include(dirname(__FILE__) . '/tabs.php'); ?>

    <form name="subscription-settings-form" id="subscription-settings-form" method="POST">
        <table class="form-table attrs">
            <tr>
                <th>
                    <?php _e('Subscription verification', 'newsletter-sms-smsapi'); ?> <input
                            type="hidden" name="subscription_security" value=""/>
                </th>
                <td>
                    <label><input type="checkbox" name="subscription_security" id="subscription-security-input"
                        <?php echo (bool)smsapi_array_safe_get($config, 'subscription_security') ? 'checked="checked"' : ''; ?> />
                   <?php _e('Enable sms authorization in subscription/cancellation process', 'newsletter-sms-smsapi'); ?></label>
                </td>
            </tr>

            <tr>
                <th class="short"><?php _e("Additional attributes to save", 'newsletter-sms-smsapi'); ?>:</th>
                <th class="short"><?php _e('Field enabled', 'newsletter-sms-smsapi'); ?></th>
                <th><?php _e('Field required', 'newsletter-sms-smsapi'); ?></th>
            </tr>

            <tr>
                <td></td>
                <td>
                    <p>
                        <input type="checkbox" name="save_contact_firstname" id="contact-firstname"
                            <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_firstname') ? 'checked="checked"' : ''; ?> />
                        <label for="contact-firstname"><?php _e('First name', 'newsletter-sms-smsapi'); ?></label>
                    </p>
                </td>
                <td><input type="checkbox" name="save_contact_firstname_required" id="contact-firstname"
                        <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_firstname_required') ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <p>
                        <input type="checkbox" name="save_contact_lastname" id="contact-lastname"
                            <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_lastname') ? 'checked="checked"' : ''; ?> />

                        <label for="contact-lastname"><?php _e('Last name', 'newsletter-sms-smsapi'); ?></label>
                    </p>
                </td>
                <td>
                    <input type="checkbox" name="save_contact_lastname_required" id="contact-lastname_required"
                        <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_lastname_required') ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <p>
                        <input type="checkbox" name="save_contact_email" id="contact-email"
                            <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_email') ? 'checked="checked"' : ''; ?> />
                        <label for="contact-email"><?php _e('Email', 'newsletter-sms-smsapi'); ?></label>
                    </p>
                </td>
                <td>
                    <input type="checkbox" name="save_contact_email_required" id="contact-email_required"
                        <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_email_required') ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td></td>
                <td>

                    <p>
                        <input type="checkbox" name="save_contact_city" id="contact-city"
                            <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_city') ? 'checked="checked"' : ''; ?> />
                        <label for="contact-city"><?php _e('City', 'newsletter-sms-smsapi'); ?></label>
                    </p></td>
                <td>
                    <input type="checkbox" name="save_contact_city_required" id="contact-city_required"
                        <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_city_required') ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <p>
                        <input type="checkbox" name="save_contact_birthdate" id="contact-birthdate"
                            <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_birthdate') ? 'checked="checked"' : ''; ?> />
                        <label for="contact-birthdate"><?php _e('Birth date', 'newsletter-sms-smsapi'); ?></label>
                    </p>
                </td>
                <td>
                    <input type="checkbox" name="save_contact_birthdate_required" id="contact-birthdate_required"
                        <?php echo (bool)smsapi_array_safe_get($config, 'save_contact_birthdate_required') ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <input type="submit" name="" id="settings-form-submit" class="btn btn-primary"
                           value="<?php _e('Save', 'newsletter-sms-smsapi'); ?>">
                </td>
            </tr>
        </table>
    </form>
</div>
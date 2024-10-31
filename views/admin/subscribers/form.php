<div class="wrap">

    <?php include(dirname(__FILE__) . '/../flash_info.php'); ?>

    <h2>
        <?php _e('SMSAPI subscribers edit', 'newsletter-sms-smsapi'); ?>
    </h2>

    <div id="smsapi-subscribe-form">
        <form id="smsapi-subscription-form" method="post">
            <table class="form-table">
                <tr>
                    <th>
                        <label for="smsapi-input-phonenumber"><?php _e('Phone number', 'newsletter-sms-smsapi'); ?>:</label>
                    </th>

                    <td>
                        <input class="smsapi-input" type="text" name="phonenumber" id="smsapi-input-phonenumber"
                               value="<?php echo esc_attr($subscriber->phoneNumber); ?>" />
                        <span class="smsapi-input-error">
                            <?php echo esc_attr(smsapi_array_safe_get($errors, 'phonenumber')); ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="smsapi-input-firstname"><?php _e('First name', 'newsletter-sms-smsapi'); ?>:</label>
                    </th>

                    <td>
                        <input class="smsapi-input" type="text" name="firstname" id="smsapi-input-firstname"
                               value="<?php echo esc_attr($subscriber->firstName); ?>" />

                        <span class="smsapi-input-error"><?php echo esc_attr(smsapi_array_safe_get($errors, 'firstname')); ?></span>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="smsapi-input-lastname"><?php _e('Last name', 'newsletter-sms-smsapi'); ?>:</label>
                    </th>

                    <td>
                        <input class="smsapi-input" type="text" name="lastname" id="smsapi-input-lastname"
                               value="<?php echo esc_attr($subscriber->lastName); ?>" />

                        <span class="smsapi-input-error"><?php echo esc_attr(smsapi_array_safe_get($errors, 'lastname')); ?></span>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="smsapi-input-email"><?php _e('Email', 'newsletter-sms-smsapi'); ?>:</label>
                    </th>

                    <td>
                        <input class="smsapi-input" type="text" name="email" id="smsapi-input-email"
                               value="<?php echo esc_attr($subscriber->email); ?>" />

                        <span class="smsapi-input-error"><?php echo esc_attr(smsapi_array_safe_get($errors, 'email')); ?></span>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="smsapi-input-city"><?php _e('City', 'newsletter-sms-smsapi'); ?>:</label>
                    </th>

                    <td>
                        <input class="smsapi-input" type="text" name="city" id="smsapi-input-city"
                               value="<?php echo esc_attr($subscriber->city); ?>" />

                        <span class="smsapi-input-error"><?php echo esc_attr(smsapi_array_safe_get($errors, 'city')); ?></span>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="smsapi-input-birthdate"><?php _e('Birth date', 'newsletter-sms-smsapi'); ?>:</label>
                    </th>

                    <td>
                        <input class="smsapi-input" type="text" name="birthdate" id="smsapi-input-birthdate"
                               value="<?php echo !empty($subscriber->birthdayDate) ? date('Y-m-d', strtotime($subscriber->birthdayDate)) : ''; ?>" />

                        <span class="smsapi-input-error">
                            <?php echo esc_attr(smsapi_array_safe_get($errors, 'birthdate')); ?>
                        </span>

                        <p class="description"><?php _e('Date in year-month-day format, ex: 1971-01-01', 'newsletter-sms-smsapi'); ?></p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" class="btn btn-primary" id="smsapi-submit" value="<?php _e('Save', 'newsletter-sms-smsapi'); ?>" />
                        <a href="?page=smsapi-subscribers" class="btn btn-default"><?php _e('Back', 'newsletter-sms-smsapi'); ?></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
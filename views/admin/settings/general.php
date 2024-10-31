<div class="wrap">
    <?php include(dirname(__FILE__) . '/tabs.php'); ?>

    <table class="form-table">
        <tr>
            <th>
                <?php _e("API username", 'newsletter-sms-smsapi'); ?>
            </th>
            <td>
                <input type="text" class="regular-text" maxlength="50" value="<?php echo esc_attr($username); ?>" disabled />
            </td>
        </tr>
        <tr>
            <th>
                <?php _e("API token", 'newsletter-sms-smsapi'); ?>
            </th>
            <td>
                <input type="text" class="regular-text" maxlength="50" value="<?php echo esc_attr($token); ?>" disabled />
            </td>
        </tr>
    </table>

    <a class="confirm-logout btn btn-danger" href="?page=smsapi-settings&noheader=true&tab=logout"><?php _e('Log out', 'newsletter-sms-smsapi'); ?></a>

    <form action="<?php echo admin_url('admin.php?page=smsapi-settings'); ?>" name="general-settings-form"
          id="general-settings-form" method="POST">
        <table class="form-table">
            <tr>
                <th><?php _e('Saved to group', 'newsletter-sms-smsapi'); ?>:</th>

                <td>
                    <select name="phonebook_group" id="phonebook-group">
                        <option value=""><?php _e('-- select --', 'newsletter-sms-smsapi'); ?></option>

                        <?php foreach ($phonebookGroups as $group): ?>
                            <option
                                value="<?php echo esc_attr($group->id); ?>" <?php echo (smsapi_array_safe_get($config, 'phonebook_group') == $group->id) ? 'selected' : ''; ?>>
                                <?php echo esc_attr($group->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <?php if (smsapi_array_safe_get($errors, 'phonebook_group')): ?>
                        <p class="text-danger"><?php echo esc_attr(smsapi_array_safe_get($errors, 'phonebook_group')); ?></p>
                    <?php endif; ?>

                    <p class="description description-warning"><?php _e('Choose group information', 'newsletter-sms-smsapi'); ?></p>

                    <br/>

                    <label> <input type="checkbox" name="add_new_group"
                                   id="add-new-group"/> <?php _e('Add new group', 'newsletter-sms-smsapi'); ?></label>

                    <div id="new-group-name-block" class="hidden">
                        <input type="text" name="new_group_name"/>
                        <p class="description"><?php _e('Enter name for new group.', 'newsletter-sms-smsapi'); ?></p>
                    </div>
                </td>
            </tr>

            <tr>
                <th><?php _e("Default sendername", 'newsletter-sms-smsapi'); ?>:</th>
                <td>
                    <select name="api_sendername" id="api-sendername">
                        <option value=""><?php _e('-- select --', 'newsletter-sms-smsapi'); ?></option>

                        <?php if (!empty($senderNames)): ?>
                            <?php foreach ($senderNames as $sender): ?>
                                <option
                                    value="<?php echo esc_attr($sender); ?>" <?php echo (smsapi_array_safe_get($config, 'api_sendername') == $sender) ? 'selected' : ''; ?>>
                                    <?php echo esc_attr($sender); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <?php if (smsapi_array_safe_get($errors, 'api_sendername')): ?>
                        <p class="text-danger"><?php echo esc_attr(smsapi_array_safe_get($errors, 'api_sendername')); ?></p>
                    <?php endif; ?>

                    <p class="description"><?php _e('Enter default sendername used to send messages from plugin.', 'newsletter-sms-smsapi'); ?></p>
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

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('input#add-new-group').on('change', function () {
            if (this.checked) {
                $("#new-group-name-block").show();
            } else {
                $("#new-group-name-block").hide();
            }
        }).trigger('change');
        $("a.confirm-logout").click(function() {
            return confirm("<?php _e('Are you sure you want to log out?', 'newsletter-sms-smsapi') ?>")
        });
    });
</script>